<?php
use App\Constants\Attributes; use App\Constants\MediaType;
use App\Constants\Status;
use App\Helpers;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
$route_params = Route::current()->parameters();
$total_images = Media::where(Attributes::STATUS, Status::ACTIVE)->count();
$all_images = Media::where(Attributes::STATUS, Status::ACTIVE)->get();
$has_more_images = $total_images > 48;
$images = [];
$item_id = null;
if(isset($entry) && !is_null($entry->media)){
    $media = $entry->media;
    if(!is_a($media, Collection::class) || !is_a($media, \Illuminate\Support\Collection::class)){
        $media = collect([$media]);
    }
    $images = $media->sortBy(Attributes::ORDER);
}
if(isset($entry)){
    $item_id = $entry->id;
}
?>
<div class="col-md-12" id="content">
    <h3>Images</h3>
    <p style="padding-bottom: 5px;">
    <ul>

            <li>Order is left to right</li>
            <li>Drag to reorder</li>

    </ul>
    </p>
    <a id="btn-select-image" href="" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-th"></i> Select from Gallery</span></a>
    @if(isset($entry))
        <a id="btn-upload-image" href="" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-th"></i> Upload to Gallery</span></a>
    @endif
    <div class="row image-grid" id="media-items" style="margin-top: 20px;">
        @if(count($images) > 0)
            @foreach($images as $image)
                <div class="col-sm-2 col-md-2 image-item">
                    <div class="panel panel-default">
                        <div class="panel-body image-area">
                            <div class="preview-container" data-media-id="{{ $image->id }}" data-url="{{ $image->url }}" style="background-image: url({{ $image->url }});
                                background-size: cover; width: 100% !important; background-position: center;"></div>
                            <a class="remove-image" href="#" style="display: inline;">&#215;</a>
                            <input type='hidden' name='media_ids[]' value='{{ $image->id }}'>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('before_styles')
    <link rel="stylesheet" href="{{ mix('css/media.css') }}">
@endpush

@push('after_scripts')
    <div class="modal fade modal-grid" id="images-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Select Images</h4>
                </div>
                <div class="modal-body">
                    <div class="media-grid" data-has-more-image="{{ $has_more_images ? 'true' : 'false' }}">
                        @if(isset($all_images) && count($all_images) > 0)
                            @foreach($all_images as $image)
                                <label>
                                    <input type="checkbox" name="media_ids[]" value="{{ $image->id }}">
                                    <div class="preview-container" data-media-id="{{ $image->id }}" data-url="{{ $image->url }}" style="background-image: url({{ $image->url }})"></div>
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-confirm-media-selection" data-related-table-id="#table-images">Add Images</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-grid" id="upload-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <form id="form" action="{{ backpack_url("upload") }}" method="POST" enctype="multipart/form-data" onsubmit="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload Images</h4>
                    </div>
                    <div class="modal-body">
                            <input type="file" name="media[]">
                        <label class="backstrap-file-label" for="media">Size limit: 7MB per image</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="item_id" name="item_id" value="{{ $item_id }}">
                        <input type="submit" class="btn btn-primary btn-confirm-media-selection" value="Upload" name="submit" data-value="save_and_edit">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://vadimsva.github.io/waitMe/waitMe.min.css">
    <link rel="stylesheet" href="{{ mix('css/media.css') }}">
    <script src="https://vadimsva.github.io/waitMe/waitMe.min.js"></script>
    <script src="{{ mix('js/Sortable.min.js') }}"></script>
    <script src="{{ mix('js/media.js') }}"></script>
@endpush
