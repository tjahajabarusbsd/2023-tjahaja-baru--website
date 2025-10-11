<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
                {{ trans('backpack::base.dashboard') }}</a></li>

@can('can_manage_users')
        <!-- Users, Roles, Permissions -->
        <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
                <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                                                class="nav-icon la la-user"></i> <span>Users</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                                                class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                                                class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
                </ul>
        </li>
@endcan

@can('can_manage_menu_website')
        <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-motorcycle"></i> Products</a>
                <ul class="nav-dropdown-items">
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class=''></i>
                                        Categories</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('group') }}'><i class=''></i> Groups</a>
                        </li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('variant') }}'><i class=''></i>
                                        Variants</a></li>
                </ul>
        </li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('banner') }}'><i class='nav-icon las la-images'></i>Home
                        Banners</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('promo') }}'><i class='nav-icon las la-scroll'></i>
                        Promo</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class='nav-icon las la-paperclip'></i>
                        Pesan & Kritik</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('dealer') }}'><i class='nav-icon las la-industry'></i>
                        Dealer</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('review') }}'><i class='nav-icon la la-question'></i>
                        Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('group-product-spec') }}"><i
                                class="nav-icon las la-wrench"></i> Group product specs</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('consultation') }}"><i
                                class="nav-icon las la-file-alt"></i> Consultations</a></li>
@endcan

@can('can_manage_menu_mobile')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('nomor-rangka') }}"><i
                                class='nav-icon la la-barcode'></i> Nomor Rangka</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('booking-service') }}"><i
                                class='nav-icon la la-calendar-check'></i> Booking services</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('order-motor') }}"><i
                                class='nav-icon la la-motorcycle'></i>
                        Order motors</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('merchant') }}"><i class='nav-icon la la-store'></i>
                        Merchants</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('reward') }}"><i class="nav-icon la la-gift"></i>
                        Rewards</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('event') }}"><i class="nav-icon la-calendar-alt"></i>
                        Events</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('qrcode') }}"><i class="nav-icon la la-qrcode"></i>
                        Qrcodes</a></li>
@endcan