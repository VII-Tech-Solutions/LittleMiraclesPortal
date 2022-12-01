<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>--}}
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('notifications') }}'><i class='nav-icon la la-bell'></i>Notifications</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('onboardings') }}'><i class='nav-icon la la-hands-helping'></i>Onboardings</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('photographers') }}'><i class='nav-icon la la-user-friends'></i>Photographers</a></li>

{{--Cakes Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-birthday-cake"></i>Cakes</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cakes') }}'><i class='nav-icon la la-birthday-cake'></i>Cakes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cake-categories') }}'><i class='nav-icon la la-layer-group'></i>Cake Categories</a></li>
    </ul>
</li>

{{--Backdrop Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-image"></i>Backdrop</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backdrops') }}'><i class='nav-icon la la-image'></i>Backdrop</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backdrop-categories') }}'><i class='nav-icon la la-layer-group'></i>Backdrop Categories</a></li>
    </ul>
</li>

{{--Family Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-users"></i>Family</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-info') }}'><i class='nav-icon la la-info'></i>Family Information</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-members') }}'><i class='nav-icon la la-user-circle'></i>Family Members</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-info-questions') }}'><i class='nav-icon la la-question-circle-o'></i>Family Information Questions</a></li>
    </ul>
</li>

{{--Package Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-box-open"></i>Package</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('packages') }}'><i class='nav-icon la la-box'></i>Packages</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sessions') }}'><i class='nav-icon la la-calendar-check'></i>Sessions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sub-session') }}'><i class='nav-icon la la-calendar-check'></i> Sub sessions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('reviews') }}'><i class='nav-icon la la-comment-alt'></i>Reviews</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sections') }}'><i class='nav-icon la la-boxes'></i>Sections</a></li>
    </ul>
</li>

{{--Studio Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-camera"></i>Studio</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio-metadata') }}'><i class='nav-icon la la-camera'></i>Studio</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio-packages') }}'><i class='nav-icon la la-box'></i>Studio Packages</a></li>

    </ul>
</li>

{{--Feedback Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-file-alt"></i>Pages</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pages') }}'><i class='nav-icon la la-file'></i>Pages</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('faqs') }}'><i class='nav-icon la la-question'></i>FAQs</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('social-media') }}'><i class='nav-icon la la-hashtag'></i>Social Media</a></li>
    </ul>
</li>

{{-- Explore Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-search"></i>Explore</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('daily-tips') }}'><i class='nav-icon la la-lightbulb'></i>Daily Tip</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('promotions') }}'><i class='nav-icon la la-bullhorn'></i>Promotions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('workshops') }}'><i class='nav-icon la la-users-cog'></i>Workshops</a></li>
    </ul>
</li>

{{--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('order') }}'><i class='nav-icon la la-question'></i> Orders</a></li>--}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('gifts') }}'><i class='nav-icon la la-gifts'></i>Gifts</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('users') }}'><i class='nav-icon la la-user'></i>Users</a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('tags') }}'><i class='nav-icon la la-tags'></i>Tags</a></li>


{{--Feedback Drop Down Menu--}}
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-comment"></i>Feedback</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('feedback') }}'><i class='nav-icon la la-comments'></i>Feedback</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('feedback-questions') }}'><i class='nav-icon la la-question-circle-o'></i>Feedback Questions</a></li>
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('payment-method') }}'><i class='nav-icon la la-credit-card'></i>Payment Methods</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('available-dates') }}'><i class='nav-icon la la-calendar-week'></i>Available Dates</a></li>



{{--Explore Drop Down Menu--}}
{{--<li class='nav-item nav-dropdown'>--}}
{{--    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-list"></i>Explore</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('daily-tips') }}'><i class='nav-icon la la-hands-helping'></i>Daily Tip</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('workshops') }}'><i class='nav-icon la la-hands-helping'></i>Workshops</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('promotions') }}'><i class='nav-icon la la-hands-helping'></i>Promotions</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('feedback') }}'><i class='nav-icon la la-hands-helping'></i>Feedback</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('feedback-questions') }}'><i class='nav-icon la la-hands-helping'></i>Feedback Questions</a></li>--}}

{{--    </ul>--}}
{{--</li>--}}

{{--Booking Drop Down Menu--}}
{{--<li class='nav-item nav-dropdown'>--}}
{{--    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-list"></i>Booking</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('photographers') }}'><i class='nav-icon la la-hands-helping'></i>Photographers</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backdrops') }}'><i class='nav-icon la la-hands-helping'></i>Backdrop</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backdrop-categories') }}'><i class='nav-icon la la-hands-helping'></i>Backdrop Categories</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cakes') }}'><i class='nav-icon la la-hands-helping'></i>Cakes</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cake-categories') }}'><i class='nav-icon la la-hands-helping'></i>Cake Categories</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('payment-method') }}'><i class='nav-icon la la-hands-helping'></i>Payment Methods</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('available-dates') }}'><i class='nav-icon la la-hands-helping'></i>Available Dates</a></li>--}}

{{--    </ul>--}}
{{--</li>--}}

{{--Studio Drop Down Menu--}}
{{--<li class='nav-item nav-dropdown'>--}}
{{--    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-list"></i>Studio</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio-metadata') }}'><i class='nav-icon la la-hands-helping'></i>Studio</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio-packages') }}'><i class='nav-icon la la-hands-helping'></i>Studio Packages</a></li>--}}

{{--    </ul>--}}
{{--</li>--}}

{{--More Drop Down Menu--}}
{{--<li class='nav-item nav-dropdown'>--}}
{{--    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon la la-list"></i>More</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-info') }}'><i class='nav-icon la la-hands-helping'></i>Family Information</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-members') }}'><i class='nav-icon la la-hands-helping'></i>Family Members</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-info-questions') }}'><i class='nav-icon la la-hands-helping'></i>Family Information Questions</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('users') }}'><i class='nav-icon la la-hands-helping'></i>Users</a></li>--}}

{{--    </ul>--}}
{{--</li>--}}

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('transaction') }}'><i class='nav-icon la la-question'></i> Transactions</a></li>