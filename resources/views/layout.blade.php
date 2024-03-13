@php
    $topbar_contact = App\Models\ContactPage::first();
    $setting = App\Models\Setting::first();
    $customPages = App\Models\CustomPage::all();
    $social_links = App\Models\FooterSocialLink::get();
    $facebookPixel = App\Models\FacebookPixel::first();
    $menus = App\Models\MenuVisibility::all();
    $languages = App\Models\Language::all();
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    @yield('title')
    @yield('meta')

    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;900&family=Poppins:wght@400;500;600;900&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ url($setting->favicon) }}">
    <link rel="stylesheet" href="{{ asset('user/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/responsive.css') }}">
    @if (session()->has('text_direction') && session()->get('text_direction') == 'rtl')
        <link rel="stylesheet" href="{{ asset('user/css/rtl.css') }}">
    @elseif ($setting->text_direction == 'rtl')
        <link rel="stylesheet" href="{{ asset('user/css/rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('user/css/dev.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

    {{-- @include('user.theme_style') --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('user/js/sweetalert2@11.js') }}"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if ($setting->google_analytic == 1)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $setting->google_analytic_code }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $setting->google_analytic_code }}');
        </script>
    @endif

    @if ($facebookPixel->status == 1)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $facebookPixel->app_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $facebookPixel->app_id }}&ev=PageView&noscript=1" /></noscript>
    @endif


    @include('theme_style')


</head>

<body>

    <!--=====TOPBAR START=====-->
    <section class="wsus__topbar">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-12 col-sm-4 col-md-6 d-none d-md-block">
                    <ul class="wsus__topbar_left d-flex align-items-center">
                        <li><a href="callto:{{ $setting->topbar_phone }}"><i class="fal fa-mobile"></i>
                                {{ $setting->topbar_phone }}</a></li>
                        <li><a href="maolto:{{ $setting->topbar_email }}"><i class="fas fa-envelope"></i>
                                {{ $setting->topbar_email }}</a></li>
                    </ul>
                </div>
                <div class="col-xl-6 col-12 col-sm-12 col-md-6">
                    <div class="wsus__topbar_right_area d-flex justify-content-end align-items-center">
                        <ul class="wsus__topbar_right d-flex justify-content-end align-items-center">
                            @foreach ($social_links as $social_link)
                                <li><a href="{{ $social_link->link }}"><i class="{{ $social_link->icon }}"></i></a>
                                </li>
                            @endforeach
                        </ul>
                        <form id="setLanguageHeader" action="{{ route('set-language') }}">
                            <select class="select_js" name="code">
                                @forelse ($languages as $language)
                                    <option value="{{ $language->code }}"
                                        {{ getSessionLanguage() == $language->code ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @empty
                                    <option value="en" {{ getSessionLanguage() == 'en' ? 'selected' : '' }}>English
                                    </option>
                                @endforelse
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====TOPBAR END=====-->


    <!--=====MAIN MENU START=====-->
    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ url($setting->logo) }}" alt="logo" class="img-fluid w-100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fal fa-align-right"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">

                    @php
                        $menu = $menus->where('id', 1)->first();
                    @endphp

                    @if ($menu->status == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page"
                                href="{{ url('/') }}">{{ $menu->translated_custom_name }}</a>
                        </li>
                    @endif

                    @php
                        $menu = $menus->where('id', 2)->first();
                    @endphp

                    @if ($menu->status == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('about.us') ? 'active' : '' }}"
                                href="{{ route('about.us') }}">{{ $menu->translated_custom_name }}</a>
                        </li>
                    @endif


                    @php
                        $menu = $menus->where('id', 3)->first();
                    @endphp

                    @if ($menu->status == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('properties') || Route::is('agents') || request()->get('sorting_id') == 6 || request()->get('sorting_id') == 3 || request()->get('sorting_id') == 4 || Route::is('property.details') ? 'active' : '' }}"
                                href="javascript:;" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ $menu->translated_custom_name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                @php
                                    $menu = $menus->where('id', 4)->first();
                                @endphp

                                @if ($menu->status == 1)
                                    @if (Route::is('properties'))
                                        <li><a class="dropdown-item {{ !request()->has('sorting_id') ? 'active' : '' }}"
                                                href="{{ route('properties', ['page_type' => 'list_view']) }}">{{ $menu->translated_custom_name }}</a>
                                        </li>
                                    @else
                                        <li><a class="dropdown-item"
                                                href="{{ route('properties', ['page_type' => 'list_view']) }}">{{ $menu->translated_custom_name }}</a>
                                        </li>
                                    @endif
                                @endif

                                @php
                                    $menu = $menus->where('id', 5)->first();
                                @endphp

                                @if ($menu->status == 1)
                                    <li><a class="dropdown-item {{ request()->get('sorting_id') == 3 ? 'active' : '' }}"
                                            href="{{ route('properties', ['page_type' => 'list_view', 'sorting_id' => 3]) }}">{{ $menu->translated_custom_name }}</a>
                                    </li>
                                @endif

                                @php
                                    $menu = $menus->where('id', 6)->first();
                                @endphp

                                @if ($menu->status == 1)
                                    <li><a class="dropdown-item {{ request()->get('sorting_id') == 4 ? 'active' : '' }}"
                                            href="{{ route('properties', ['page_type' => 'list_view', 'sorting_id' => 4]) }}">{{ $menu->translated_custom_name }}</a>
                                    </li>
                                @endif


                                @php
                                    $menu = $menus->where('id', 7)->first();
                                @endphp

                                @if ($menu->status == 1)
                                    <li><a class="dropdown-item {{ request()->get('sorting_id') == 6 ? 'active' : '' }}"
                                            href="{{ route('properties', ['page_type' => 'list_view', 'sorting_id' => 6]) }}">{{ $menu->translated_custom_name }}</a>
                                    </li>
                                @endif


                                @php
                                    $menu = $menus->where('id', 8)->first();
                                @endphp
                                @if ($menu->status == 1)
                                    <li>
                                        <a class="dropdown-item {{ Route::is('agents') ? 'active' : '' }}"
                                            href="{{ route('agents') }}">{{ $menu->translated_custom_name }}</a>
                                    </li>
                                @endif


                            </ul>
                        </li>

                    @endif

                    @php
                        $menu = $menus->where('id', 10)->first();
                    @endphp
                    @if ($menu->status == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('pricing.plan') ? 'active' : '' }}"
                                href="{{ route('pricing.plan') }}">{{ $menu->translated_custom_name }}</a>
                        </li>
                    @endif

                    @php
                        $menu = $menus->where('id', 9)->first();
                    @endphp
                    @if ($menu->status == 1)

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('blog') || Route::is('blog.details') || Route::is('custom.page') || Route::is('faq') || Route::is('show-career') ? 'active' : '' }}"
                                href="javascript:;" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ $menu->translated_custom_name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                @php
                                    $menu = $menus->where('id', 11)->first();
                                @endphp
                                @if ($menu->status == 1)
                                    <li><a class="dropdown-item {{ Route::is('faq') ? 'active' : '' }}"
                                            href="{{ route('faq') }}">{{ $menu->translated_custom_name }}</a></li>
                                @endif

                                @php
                                    $menu = $menus->where('id', 14)->first();
                                @endphp
                                @if ($menu->status == 1)
                                    <li><a class="dropdown-item {{ Route::is('career') || Route::is('show-career') ? 'active' : '' }}"
                                            href="{{ route('career') }}">{{ $menu->translated_custom_name }}</a></li>
                                @endif

                                @php
                                    $menu = $menus->where('id', 12)->first();
                                @endphp
                                @if ($menu->status == 1)
                                    <li>
                                        <a class="dropdown-item {{ Route::is('blog') || Route::is('blog.details') ? 'active' : '' }}"
                                            href="{{ route('blog') }}">{{ $menu->translated_custom_name }}</a>
                                    </li>
                                @endif

                                @if ($customPages->count() != 0)
                                    @foreach ($customPages as $custom_item)
                                        <li><a class="dropdown-item {{ Request::url() == route('custom.page', $custom_item->slug) ? 'active' : '' }}"
                                                href="{{ route('custom.page', $custom_item->slug) }}">{{ $custom_item->translated_page_name }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>

                    @endif


                    @php
                        $menu = $menus->where('id', 13)->first();
                    @endphp
                    @if ($menu->status == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('contact-us') ? 'active' : '' }}"
                                href="{{ route('contact.us') }}">{{ $menu->translated_custom_name }}</a>
                        </li>
                    @endif

                </ul>

                <ul class="login_icon ms-auto">
                    <li><a href="{{ route('user.dashboard') }}"><i class="fal fa-user-circle"></i>
                            {{ __('user.Dashboard') }}</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!--=====MAIN MENU END=====-->

    @yield('user-content')





    @php
        $footer_contact = App\Models\Footer::first();
        $setting = App\Models\Setting::first();
        $modalConsent = App\Models\CookieConsent::first();
        $social_links = App\Models\FooterSocialLink::get();
        $tawk_chat = App\Models\TawkChat::first();
    @endphp


    @if ($tawk_chat->status == 1)
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $tawk_chat->chat_link }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endif



    @if ($modalConsent->status == 1)
        <script src="{{ asset('user/js/cookieconsent.min.js') }}"></script>

        <script>
            window.addEventListener("load", function() {
                window.wpcc.init({
                    "border": "{{ $modalConsent->border }}",
                    "corners": "{{ $modalConsent->corners }}",
                    "colors": {
                        "popup": {
                            "background": "{{ $modalConsent->background_color }}",
                            "text": "{{ $modalConsent->text_color }} !important",
                            "border": "{{ $modalConsent->border_color }}"
                        },
                        "button": {
                            "background": "{{ $modalConsent->btn_bg_color }}",
                            "text": "{{ $modalConsent->btn_text_color }}"
                        }
                    },
                    "content": {
                        "href": "{{ route('privacy-policy') }}",
                        "message": "{{ $modalConsent->message }}",
                        "link": "{{ $modalConsent->link_text }}",
                        "button": "{{ $modalConsent->btn_text }}"
                    }
                })
            });
        </script>
    @endif



    <!--=====FOOTER START=====-->
    <footer class="pt_45">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-4 col-sm-8 col-md-7 col-lg-4">
                    <div class="wsus__footer_content">
                        <a href="{{ route('home') }}" class="footer_logo"><img
                                src="{{ asset($setting->footer_logo) }}" alt=""></a>

                        <p class="address"><i class="fal fa-location-circle"></i> {!! nl2br(e($footer_contact->translated_address)) !!}</p>
                        <a class="call_mail" href="javascript:;"><i class="fal fa-phone-alt"></i>
                            {!! nl2br(e($footer_contact->phone)) !!}</a>
                        <a class="call_mail" href="javascript:;"><i class="fal fa-envelope-open"></i>
                            {!! nl2br(e($footer_contact->email)) !!}</a>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-lg-2">
                    <div class="wsus__footer_content">
                        <h4>{{ $footer_contact->translated_first_column }}</h4>
                        <ul class="footer_link">
                            <li><a href="{{ route('about.us') }}">{{ __('user.About Us') }}</a></li>

                            <li><a href="{{ route('properties', ['page_type' => 'list_view']) }}">{{ __('user.All Properties') }}
                                </a></li>

                            <li class="nav-item">
                            <li><a href="{{ route('blog') }}">{{ __('user.Blog') }}</a></li>
                            </li>

                            <li><a href="{{ route('pricing.plan') }}">{{ __('user.Pricing Plan') }}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-lg-2 order-md-4">
                    <div class="wsus__footer_content">
                        <h4>{{ $footer_contact->translated_second_column }}</h4>
                        <ul class="footer_link">
                            <li><a
                                    href="{{ route('terms-and-conditions') }}">{{ __('user.Terms And Conditions') }}</a>
                            </li>

                            <li><a href="{{ route('privacy-policy') }}">{{ __('user.Privacy Policy') }}</a></li>


                            <li><a href="{{ route('faq') }}">{{ __('user.FAQ') }}</a></li>

                            <li><a href="{{ route('contact.us') }}">{{ __('user.Contact Us') }}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-xl-2 col-sm-7 col-md-7 col-lg-3 order-lg-4">
                    <div class="wsus__footer_content">
                        <h4>{{ $footer_contact->translated_third_column }}</h4>
                        <ul class="footer_icon d-flex flex-wrap">
                            @foreach ($social_links as $social_link)
                                <li><a href="{{ $social_link->link }}"><i
                                            class="{{ $social_link->icon }}"></i></a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="row large_subscribe">
                <div class="col-xl-4 col-lg-5">
                    <div class="large_subscribe_text">
                        <h4 class="">{{ __('user.Subscribe Us') }}</h4>
                    </div>
                </div>
                <div class="col-xl-8 pe-0 col-lg-7">
                    <form id="subscribeForm">
                        <input type="text" placeholder="{{ __('user.Email') }}" name="email">
                        <button id="subscribeBtn" type="submit"><i id="subscribe-spinner"
                                class="loading-icon fa fa-spin fa-spinner d-none mt-1"></i> <i id="angleRight"
                                class="fal fa-angle-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="wsus__copyright mt_45">
            <div class="ontainer">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>{{ $footer_contact->translated_copyright }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=====FOOTER END=====-->


    <!--=====SCROLL BUTTON START=====-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--=====SCROLL BUTTON END=====-->



    <!--bootstrap js-->
    <script src="{{ asset('user/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('user/js/Font-Awesome.js') }}"></script>
    <!--slick js-->
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <!--select-2 js-->
    <script src="{{ asset('user/js/select2.min.js') }}"></script>
    <!--counter-2 js-->
    <script src="{{ asset('user/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.countup.min.js') }}"></script>
    <!--add row custon js-->
    <script src="{{ asset('user/js/add_row_custon.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('user/js/sticky_sidebar.js') }}"></script>
    <!--nice select js-->
    <script src="{{ asset('user/js/jquery.nice-select.min.js') }}"></script>



    <!--main/custom js-->
    <script src="{{ asset('user/js/main.js') }}"></script>

    <script src="{{ asset('toastr/toastr.min.js') }}"></script>

    <script>
        @if (Session::has('messege'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('messege') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('messege') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('messege') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('messege') }}");
                    break;
            }
        @endif
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {

                $("#subscribeBtn").on('click', function(e) {
                    e.preventDefault();

                    $("#subscribe-spinner").removeClass('d-none')
                    $("#subscribeBtn").addClass('custom-opacity')
                    $("#subscribeBtn").removeClass('common_btn_2')
                    $("#subscribeBtn").attr('disabled', true);
                    $("#angleRight").addClass('d-none');

                    $.ajax({
                        url: "{{ route('subscribe-us') }}",
                        type: "get",
                        data: $('#subscribeForm').serialize(),
                        success: function(response) {
                            if (response.success) {
                                $("#subscribeForm").trigger("reset");
                                toastr.success(response.success)

                                $("#subscribe-spinner").addClass('d-none')
                                $("#subscribeBtn").removeClass('custom-opacity')
                                $("#subscribeBtn").addClass('common_btn_2')
                                $("#subscribeBtn").attr('disabled', false);
                                $("#angleRight").removeClass('d-none');

                            }
                            if (response.error) {
                                toastr.error(response.error)
                                $("#subscribeForm").trigger("reset");
                                $("#subscribe-spinner").addClass('d-none')
                                $("#subscribeBtn").removeClass('custom-opacity')
                                $("#subscribeBtn").addClass('common_btn_2')
                                $("#subscribeBtn").attr('disabled', false);
                                $("#angleRight").removeClass('d-none');
                            }
                        },
                        error: function(response) {
                            if (response.responseJSON.errors.email) {

                                toastr.error(response.responseJSON.errors.email[0])

                                $("#subscribe-spinner").addClass('d-none')
                                $("#subscribeBtn").removeClass('custom-opacity')
                                $("#subscribeBtn").addClass('common_btn_2')
                                $("#subscribeBtn").attr('disabled', false);
                                $("#angleRight").removeClass('d-none');

                            }
                        }

                    });
                })
            });

        })(jQuery);
        $("#setLanguageHeader").on('change', function(e) {
            this.submit();
        });
    </script>

</body>

</html>
