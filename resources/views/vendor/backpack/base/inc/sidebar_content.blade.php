<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('onboardings') }}'><i class='nav-icon la la-hands-helping'></i>Onboardings</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('photographers') }}'><i class='nav-icon la la-hands-helping'></i>Photographers</a></li>

<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-list-ul"></i>Manage Metadata</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('onboarding') }}'><i class='nav-icon la la-hands-helping'></i>On-boarding</a></li>
    </ul>
</li>
