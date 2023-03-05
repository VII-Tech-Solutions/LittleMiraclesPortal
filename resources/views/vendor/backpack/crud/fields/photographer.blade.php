<?php

use App\Constants\Attributes;
use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Models\Photographer;
use App\Models\PackagePhotographer;

$route_params = Route::current()->parameters();
// type
$entity = Route::getCurrentRoute()->controller->crud->entity_name;

// get package id
$package_id = $route_params;

if (!empty($package_id)) {
    // get package
    /** @var Package $package */
    $package = Package::where(Attributes::ID, $package_id)->first();

    // get package photographers
    $package_photographers = $package->packagePhotographers()->get();
    $package_photographers_ids = $package_photographers->pluck(Attributes::ID)->toArray();

    // check if it has subpackages
    $subpackages = $package->subpackages()->get()->count();
} else {
    $package_photographers_ids = [];
    $subpackages = 0;
}

// get photographers
$photographers = Photographer::all();
?>

<div class="col-md-12" id="content">
    @if($subpackages == 0)
        @foreach($photographers as $photographer)
            @if(!empty($package_id) && in_array($photographer->id, $package_photographers_ids))
                <input type="checkbox" id="photographers[]" name="photographers[]" value="{{$photographer->id}}"
                       checked> {{$photographer->name}}
                @php($additional_charge = PackagePhotographer::where(Attributes::PACKAGE_ID, $package->id)->where(Attributes::PHOTOGRAPHER_ID, $photographer->id)->pluck(Attributes::ADDITIONAL_CHARGE)->first())
                Additional Charge <input type="text" id="additional_charge_{{$photographer->id}}" name="additional_charge_{{$photographer->id}}"
                                         value="{{$additional_charge}}">  <br>
            @else
                <input type="checkbox" id="photographers[]" name="photographers[]"
                       value="{{$photographer->id}}"> {{$photographer->name}}
                Additional Charge <input type="text" id="additional_charge_{{$photographer->id}}" name="additional_charge_{{$photographer->id}}" value="">
                <br>
            @endif
        @endforeach
    @endif
</div>

<link rel="stylesheet" href="https://vadimsva.github.io/waitMe/waitMe.min.css">
<script src="https://vadimsva.github.io/waitMe/waitMe.min.js"></script>
<script src="{{ mix('js/Sortable.min.js') }}"></script>
