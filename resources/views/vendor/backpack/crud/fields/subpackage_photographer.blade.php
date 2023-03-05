<?php

use App\Constants\Attributes;
use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Models\Photographer;
use App\Models\PackagePhotographer;
use App\Models\SubPackage;
use App\Models\PackageSubPackage;

$route_params = Route::current()->parameters();
// type
$entity = Route::getCurrentRoute()->controller->crud->entity_name;

// get sub package id
$sub_package_id = $route_params;


// get package
/** @var SubPackage $package */
$sub_package = SubPackage::where(Attributes::ID, $sub_package_id)->first();
/** @var PackageSubPackage $package_sub_package */
$package_sub_package = PackageSubPackage::where(Attributes::PACKAGE_ID, $sub_package->id)->first();
/** @var Package $package */
$package = Package::where(Attributes::ID, $package_sub_package->sub_package_id)->first();

// get package photographers
$sub_package_photographers = $sub_package->subPackagePhotographers()->get();
$sub_package_photographers_ids = $sub_package_photographers->pluck(Attributes::ID)->toArray();

// get photographers
$photographers = Photographer::all();
?>

<div class="col-md-12" id="content">
    @foreach($photographers as $photographer)
        @if(in_array($photographer->id, $sub_package_photographers_ids))
            <input type="checkbox" id="photographers[]" name="photographers[]" value="{{$photographer->id}}"
                   checked> {{$photographer->name}}
            @php($additional_charge = PackagePhotographer::where(Attributes::PACKAGE_ID, $package->id)->where(Attributes::SUB_PACKAGE_ID, $sub_package->id)->where(Attributes::PHOTOGRAPHER_ID, $photographer->id)->pluck(Attributes::ADDITIONAL_CHARGE)->first())
            Additional Charge <input type="text" id="additional_charge[]]" name="additional_charge[]"
                                     value="{{$additional_charge}}">  <br>
        @else
            <input type="checkbox" id="photographers[]" name="photographers[]"
                   value="{{$photographer->id}}"> {{$photographer->name}}
            Additional Charge <input type="text" id="additional_charge[]]" name="additional_charge[]" value="">
            <br>
        @endif
    @endforeach
    <input type="hidden" name="package_id" id="package_id" value="{{$package->id}}">
</div>

<link rel="stylesheet" href="https://vadimsva.github.io/waitMe/waitMe.min.css">
<script src="https://vadimsva.github.io/waitMe/waitMe.min.js"></script>
<script src="{{ mix('js/Sortable.min.js') }}"></script>
