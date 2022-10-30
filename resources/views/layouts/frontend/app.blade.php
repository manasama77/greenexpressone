{{-- @extends('layouts.frontend.app') --}}
{{-- @section('page_content')
@endsection --}}


<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- owl carousel css -->
    <link rel="stylesheet" href="/css/owl.carousel.min.css" />
    <!-- font awesome icons -->
    <link rel="stylesheet" href="/css/font-awesome.css" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <!-- main css -->
    <link rel="stylesheet" href="/css/welcome.css" />
    {{-- slick css --}}
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    {{-- choice css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    {{-- flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!-- preloader start -->
    <div class="preloader">
        <span></span>
    </div>
    <!-- preloader end -->

    @include('layouts.frontend.navbar')

    @yield('page_content')

    @include('layouts.frontend.android')

    <!-- footer section start -->
    @include('layouts.frontend.footer')
    <!-- footer section end -->

    <!-- toggle theme start -->
    {{-- <div class="toggle-theme">
        <i class="fas"></i>
    </div> --}}
    <!-- toggle theme end -->

    <input type="hidden" id="base" value="{{ env('APP_URL') }}" />

    <!-- jquery js -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- popper js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="/js/bootstrap4.6.0.min.js"></script>
    <!-- owl carousel js -->
    <script src="/js/owl.carousel.min.js"></script>
    <!-- ScrollIt js -->
    <script src="/js/scrollIt.min.js"></script>
    <!-- sweetalert2 -->
    <script src="/js/sweetalert2.all.min.js"></script>
    <!-- blockui -->
    <script src="/js/jquery.blockUI.js"></script>
    {{-- slick js --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    {{-- choice js --}}
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let base_url = $('#base').val();

        $(window).on("load", function() {
            $('.preloader').fadeOut("slow");
        });

        window.onbeforeunload = function() {
            window.scrollTo(0, 0);
        }

        $(document).ready(function() {

            // navbar shrink
            $(window).on("scroll", function() {
                if ($(this).scrollTop() > 90) {
                    $('.navbar').addClass("navbar-shrink");
                } else {
                    $('.navbar').removeClass("navbar-shrink");
                }
            });

            // Slick
            $('#slick_slider').slick({
                infinite: true,
                dots: true,
            });

            // page scrollit
            // $.scrollIt({
            //     topOffset: -50
            // });

            // navbar colapse
            $('.nav-link').on('click', function() {
                $('.navbar-collapse').collapse("hide");
            });


            // toggle theme
            toggleTheme();
            $('.toggle-theme').on('click', function() {
                $("body").toggleClass("dark");

                if ($('body').hasClass("dark")) {
                    localStorage.setItem("bioner-theme", "dark");
                } else {
                    localStorage.setItem("bioner-theme", "light");
                }

                updateIcon();
            });
        });

        function toggleTheme() {
            if (localStorage.getItem("bioner-theme") != null) {
                if (localStorage.getItem("bioner-theme") === "dark") {
                    $("body").addClass("dark");
                } else {
                    $("body").removeClass("dark");
                }

            }
            updateIcon();
        }

        function updateIcon() {
            if ($('body').hasClass("dark")) {
                $(".toggle-theme i").removeClass("fa-moon");
                $(".toggle-theme i").addClass("fa-sun");
            } else {
                $(".toggle-theme i").removeClass("fa-sun");
                $(".toggle-theme i").addClass("fa-moon");
            }
        }

        function comingSoon() {
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: `Coming Soon`,
                showConfirmButton: false,
                toast: true,
                timer: 3000,
            });
        }
    </script>

    @yield('vitamin')
</body>
