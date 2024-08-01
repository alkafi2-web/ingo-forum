<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="">
            <img alt="Logo" src="{{ asset('public/frontend/images/' . $global['logo'] ?? 'logo.png') }}"
                class="h-25px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                {{-- dashboard sidebar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission(['dashboard-view']))
                    <div class="menu-item">
                        <div class="menu-content pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                @endif
                {{-- dashboard sidebar end --}}

                {{-- member sidebar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission(['member-list-view', 'member-request-view']))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Member Management</span>
                        </div>
                    </div>
                    {{-- <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'member.request' || Route::currentRouteName() == 'member.view' || Route::currentRouteName() == 'member.list' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                            fill="black" />
                                        <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Member</span>
                            <div class="pendingMemberCount">
                                @if ($global['pendingMemberCount'] > 0)
                                    <span class="badge badge-light-danger">{{ $global['pendingMemberCount'] }}</span>
                                @endif
                            </div>
                            <span class="menu-arrow"></span>
                        </span>

                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'member.request' || Route::currentRouteName() == 'member.list' ? 'hover show' : '' }}">
                            @can('member-list-view')
                                <a class="menu-item menu-accordion" href="{{ route('member.list') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'member.list' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Member List</span>

                                    </span>
                                </a>
                            @endcan
                            @can('member-request-view')
                                <a class="menu-item menu-accordion" href="{{ route('member.request') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'member.request' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Member Request</span>
                                        <div class="pendingMemberCount">
                                            @if ($global['pendingMemberCount'] > 0)
                                                <span
                                                    class="badge badge-light-danger">{{ $global['pendingMemberCount'] }}</span>
                                            @endif
                                        </div>
                                    </span>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'system' ? 'active' : '' }}"
                            href="{{ route('system') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Subscriber</span>
                        </a>
                    </div> --}}
                @endif
                {{-- member sidebar end --}}

                {{-- post and publication management start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission([
                            'post-add',
                            'post-view-all',
                            'post-category-manage',
                            'post-subcategory-manage',
                            'publication-add',
                            'publication-view-all',
                            'publication-category-manage',
                        ]))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Post Management</span>
                        </div>
                    </div>
                @endif
                {{-- post sidebar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission(['post-add', 'post-view-all', 'post-category-manage', 'post-subcategory-manage']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'category' || Route::currentRouteName() == 'subcategory' || Route::currentRouteName() == 'post.create' || Route::currentRouteName() == 'post.list' || Route::currentRouteName() == 'post.edit' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                            fill="black" />
                                        <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Post</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'category' || Route::currentRouteName() == 'subcategory' || Route::currentRouteName() == 'post.create' || Route::currentRouteName() == 'post.list' ? 'hover show' : '' }}">

                            @can('post-add')
                                <a class="menu-item menu-accordion" href="{{ route('post.create') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'post.create' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Add Post</span>
                                    </span>
                                </a>
                            @endcan
                            @can('post-view-all')
                                <a class="menu-item menu-accordion" href="{{ route('post.list') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'post.list' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Post</span>
                                    </span>
                                </a>
                            @endcan
                            @can('post-category-manage')
                                <a class="menu-item menu-accordion" href="{{ route('category') }}">
                                    <span class="menu-link {{ Route::currentRouteName() == 'category' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Category</span>
                                    </span>
                                </a>
                            @endcan
                            @can('post-subcategory-manage')
                                <a class="menu-item menu-accordion" href="{{ route('subcategory') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'subcategory' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Sub Category</span>
                                    </span>
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif
                {{-- post sidebar end --}}
                {{-- publication sidebar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission(['publication-add', 'publication-view-all', 'publication-category-manage']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'category' || Route::currentRouteName() == 'publication.create' || Route::currentRouteName() == 'post.create' || Route::currentRouteName() == 'post.list' || Route::currentRouteName() == 'post.edit' || Route::currentRouteName() == 'publication.category' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                            fill="black" />
                                        <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Publication</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'publication.category' || Route::currentRouteName() == 'publication.create' || Route::currentRouteName() == 'publication.list' || Route::currentRouteName() == 'post.list' ? 'hover show' : '' }}">

                            @can('publication-add')
                                <a class="menu-item menu-accordion" href="{{ route('publication.create') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'publication.create' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Add Publication</span>
                                    </span>
                                </a>
                            @endcan
                            @can('publication-view-all')
                                <a class="menu-item menu-accordion" href="{{ route('publication.list') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'publication.list' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Publication</span>
                                    </span>
                                </a>
                            @endcan
                            @can('publication-category-manage')
                                <a class="menu-item menu-accordion" href="{{ route('publication.category') }}">
                                    <span
                                        class="menu-link {{ Route::currentRouteName() == 'publication.category' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Category</span>
                                    </span>
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif
                {{-- publication sidebar end --}}
                {{-- post and publication management start --}}

                {{-- event side bar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission(['event-view']))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Event Management</span>
                        </div>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['event-view']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Route::currentRouteName() == 'category' || Route::currentRouteName() == 'subcategory' ? 'hover show' : '' }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                            fill="black" />
                                        <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Event</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'event' || Route::currentRouteName() == 'subcategory' ? 'hover show' : '' }}">
                            @can('event-view')
                                <a class="menu-item menu-accordion" href="{{ route('event') }}">
                                    <span class="menu-link {{ Route::currentRouteName() == 'event' ? 'active' : '' }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Events</span>
                                    </span>
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif
                {{-- event side bar end --}}

                {{-- apperarence sidebar start --}}
                @if (Auth::guard('admin')->user()->hasAnyPermission([
                            'page-add',
                            'page-view-all',
                            'menu-manage',
                            'banner-content-manage',
                            'faqs-manage',
                            'photo-album-manage',
                            'photo-gallery-manage',
                            'video-gallery-manage',
                        ]))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Appereance</span>
                        </div>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission([
                            'page-add',
                            'page-view-all',
                            'menu-manage',
                            'banner-content-manage',
                            'faqs-manage',
                            'about-us-content-manage',
                        ]))
                    @can('menu-manage')
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'menu.index' ? 'active' : '' }}"
                                href="{{ route('menu.index') }}">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect x="2" y="2" width="9" height="9" rx="2"
                                                fill="black" />
                                            <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                                rx="2" fill="black" />
                                            <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                                rx="2" fill="black" />
                                            <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                                rx="2" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title">Menu</span>
                            </a>
                        </div>
                    @endcan
                    @if (Auth::guard('admin')->user()->hasAnyPermission(['page-add', 'page-view-all']))
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ Route::currentRouteName() == 'admin.page' || Route::currentRouteName() == 'admin.page.create' ? 'hover show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                                fill="black" />
                                            <path
                                                d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title">Pages</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div
                                class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'admin.page.create' ? 'hover show' : '' }}">

                                @can('page-add')
                                    <a class="menu-item menu-accordion" href="{{ route('admin.page.create') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'admin.page.create' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Add Page</span>
                                        </span>
                                    </a>
                                @endcan
                                @can('page-view-all')
                                    <a class="menu-item menu-accordion" href="{{ route('admin.page') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'admin.page' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">All Page</span>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->hasAnyPermission(['banner-content-manage', 'about-us-content-manage', 'faqs-manage']))
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ Route::currentRouteName() == 'banner' || Route::currentRouteName() == 'aboutus' || Route::currentRouteName() == 'faqs' ? 'hover show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                                fill="black" />
                                            <path
                                                d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title">Website Content</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div
                                class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'banner' || Route::currentRouteName() == 'aboutus' || Route::currentRouteName() == 'faqs' ? 'hover show' : '' }}">
                                @can('banner-content-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('banner') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'banner' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Home Banner</span>
                                        </span>
                                    </a>
                                @endcan
                                @can('about-us-content-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('aboutus') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'aboutus' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">About Us</span>
                                        </span>
                                    </a>
                                @endcan
                                @can('faqs-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('faqs') }}">
                                        <span class="menu-link {{ Route::currentRouteName() == 'faqs' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">FAQs</span>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('admin')->user()->hasAnyPermission(['photo-album-manage', 'photo-gallery-manage', 'video-gallery-manage']))
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ Route::currentRouteName() == 'media.album' || Route::currentRouteName() == 'photo' || Route::currentRouteName() == 'video' ? 'hover show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm007.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                                fill="black" />
                                            <path
                                                d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title">Media Gallery</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div
                                class="menu-sub menu-sub-accordion  {{ Route::currentRouteName() == 'media.album' || Route::currentRouteName() == 'photo' || Route::currentRouteName() == 'video' ? 'hover show' : '' }}">

                                @can('photo-album-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('media.album') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'media.album' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Photo Album</span>
                                        </span>
                                    </a>
                                @endcan
                                @can('photo-gallery-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('photo') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'photo' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Photo Galllery</span>
                                        </span>
                                    </a>
                                @endcan
                                @can('video-gallery-manage')
                                    <a class="menu-item menu-accordion" href="{{ route('video') }}">
                                        <span
                                            class="menu-link {{ Route::currentRouteName() == 'video' ? 'active' : '' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Video Gallery</span>
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endif

                @endif
                {{-- apperarence sidebar end --}}

                @if (Auth::guard('admin')->user()->hasAnyPermission(['users-manage', 'roles-manage', 'contact-list-view', 'user-activity']))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">User Management</span>
                        </div>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['users-manage']))
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'createUser' ? 'active' : '' }}"
                            href="{{ route('createUser') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['roles-manage']))
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'role' ? 'active' : '' }}"
                            href="{{ route('role') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="bactivity.listlack" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['contact-list-view']))
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'contact.list' ? 'active' : '' }}"
                            href="{{ route('contact.list') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Contact List</span>
                        </a>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['user-activity']))
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'activity.list' ? 'active' : '' }}"
                            href="{{ route('activity.list') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">User Activities</span>
                        </a>
                    </div>
                @endif
                @if (Auth::guard('admin')->user()->hasAnyPermission(['system-settings-manage']))
                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Settings</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteName() == 'system' ? 'active' : '' }}"
                            href="{{ route('system') }}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="black" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">System Setting</span>
                        </a>
                    </div>
                @endif
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
