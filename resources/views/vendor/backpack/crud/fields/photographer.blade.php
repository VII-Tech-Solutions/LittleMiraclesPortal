<?php
use App\Constants\Attributes;
use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Models\Photographer;
use App\Models\PackagePhotographer;

$route_params = Route::current()->parameters();
// type
$entity = Route::getCurrentRoute()->controller->crud->entity_name;

// if session
$package_id = $route_params;

// get package
/** @var Package $package */
$package = Package::where(Attributes::ID, $package_id)->first();

// get package photographers
$package_photographers = $package->packagePhotographers()->get();
$package_photographers_ids = $package_photographers->pluck(Attributes::ID)->toArray();

// get photographers
$photographers = Photographer::all();

// check if it has subpackages
$subpackages = $package->subpackages()->get()->count();
?>

<div class="col-md-12" id="content">
    @if($subpackages == 0)
        @foreach($photographers as $photographer)
            @if(in_array($photographer->id, $package_photographers_ids))
                <input type="checkbox" id="photographers[]" name="photographers[]" value="{{$photographer->id}}"
                       checked> {{$photographer->name}}
                @php($additional_charge = PackagePhotographer::where(Attributes::PACKAGE_ID, $package->id)->where(Attributes::PHOTOGRAPHER_ID, $photographer->id)->pluck(Attributes::ADDITIONAL_CHARGE)->first())
                Additional Charge <input type="text" id="additional_charge[]]" name="additional_charge[]"
                                         value="{{$additional_charge}}">  <br>
            @else
                <input type="checkbox" id="photographers[]" name="photographers[]"
                       value="{{$photographer->id}}"> {{$photographer->name}}
                Additional Charge <input type="text" id="additional_charge[]]" name="additional_charge[]" value="">
                <br>
            @endif
        @endforeach
    @endif
</div>

<link rel="stylesheet" href="https://vadimsva.github.io/waitMe/waitMe.min.css">
<script src="https://vadimsva.github.io/waitMe/waitMe.min.js"></script>
<script src="{{ mix('js/Sortable.min.js') }}"></script>
