<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- owl carousel css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <!-- font awesome icons -->
    <link rel="stylesheet" href="css/font-awesome.css" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/welcome.css" />
    {{-- slick css --}}
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    {{-- choice css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    {{-- flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <!-- preloader start -->
    {{-- <div class="preloader">
        <span></span>
    </div> --}}
    <!-- preloader end -->

    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <div class="navbar-brand-img">
                    <img src="img/logo-green-express-one.png" alt="Logo {{ $app_name }}" class="img-logo">
                    GreenExpress
                </div>
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/outlet">Outlet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/how-to-pay">How to Pay</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold btn btn-dark text-white px-2" href="/check-booking">
                            <i class="fas fa-search fa-fw"></i> Check Booking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold btn btn-danger text-white px-2" href="/sign-in">
                            <i class="fas fa-sign-in-alt fa-fw"></i> Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <!-- home section start -->
    <section id="home" class="home d-flex align-items-center" data-scroll-index="0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <x-banner :banners=$banners></x-banner>
                </div>
            </div>
        </div>
    </section>
    <!-- home section end -->

    <!-- booking section start -->
    <section id="booking" class="booking section-padding" data-scroll-index="1">
        <img src="img/8493.jpg" class="bg" loading="lazy" />
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-5">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="text-center font-weight-bold mb-4">Airport Shuttle & Charter Booking</h5>
                            <form id="form_booking">
                                <div class="form-group text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="from_type" id="airport"
                                            value="airport" checked>
                                        <label class="form-check-label" for="airport">Airport</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="from_type" id="district"
                                            value="district">
                                        <label class="form-check-label" for="district">District</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="from_area_id" class="form-text font-weight-bold">From/Departure</label>
                                    <select class="form-control select2" id="from_area_id" name="from_area_id"
                                        data-placeholder="From/Departure" required disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="from_sub_area_id" class="form-text font-weight-bold">Sub
                                        From/Departure</label>
                                    <select class="form-control select2" id="from_sub_area_id"
                                        name="from_sub_area_id" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="to_area_id" class="form-text font-weight-bold">To/Arrival</label>
                                    <select class="form-control select2" id="to_area_id" name="to_area_id"
                                        data-placeholder="To/Arrival" required disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="to_sub_area_id" class="form-text font-weight-bold">Sub
                                        To/Arrival</label>
                                    <select class="form-control select2" id="to_sub_area_id" name="to_sub_area_id"
                                        disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="booking_type"
                                            id="one_way" value="one way" checked>
                                        <label class="form-check-label" for="one_way">One Way</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="booking_type"
                                            id="charter" value="charter">
                                        <label class="form-check-label" for="charter">Charter</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date_departure" class="form-text font-weight-bold">Outward
                                        journey</label>
                                    <input type="date" class="form-control" id="date_departure"
                                        name="date_departure" placeholder="Outward Journey" required />
                                </div>
                                <div class="form-group">
                                    <label for="passanger_adult" class="form-text font-weight-bold">Adult
                                        Passangers</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="passanger_adult"
                                            name="passanger_adult" placeholder="Adult Passangers" min="1"
                                            max="9" value="1" required />
                                        <div class="input-group-append bg-light">
                                            <span class="input-group-text">Adult
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passanger_baby" class="form-text font-weight-bold">Baby
                                        Passangers</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="passanger_baby"
                                            name="passanger_baby" placeholder="Adult Passangers" min="0"
                                            max="9" value="0" required />
                                        <div class="input-group-append bg-light">
                                            <span class="input-group-text">Baby
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="card card-semi shadow">
                        <div class="card-body">
                            <div class="section-title">
                                <h1>Shuttle bus to and from the main America airports</h1>
                            </div>
                            <div class="booking-text">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium mollitia eum
                                    ducimus
                                    accusamus, nisi repellat distinctio iusto deleniti, saepe, nobis ex reprehenderit?
                                    Pariatur
                                    cupiditate consequatur unde exercitationem, sit a adipisci molestias labore,
                                    officiis
                                    repudiandae esse voluptate eveniet magni laborum vel. Labore magni modi sit fugiat
                                    neque!
                                    Quo eligendi corporis in, repudiandae molestias dignissimos eum recusandae officiis,
                                    atque
                                    incidunt hic? Optio possimus ut laudantium accusamus reprehenderit dolorem mollitia
                                    sed
                                    aliquam explicabo corrupti? Quisquam nisi vitae, quod quibusdam libero quas quidem
                                    molestiae. Aspernatur ad fuga itaque. Amet enim recusandae blanditiis aliquid
                                    tenetur natus
                                    fugiat, distinctio quae! Sit sapiente a corrupti praesentium ea in ipsam cupiditate
                                    dolor
                                    atque, at saepe soluta reiciendis vel qui eligendi dignissimos repudiandae nemo
                                    ipsa, modi,
                                    exercitationem ullam quasi? Architecto similique, quasi, tempore placeat, laudantium
                                    minus
                                    sapiente vel laborum tempora fuga eligendi alias velit qui maxime molestiae labore
                                    omnis
                                    quia! Alias corporis pariatur quae minima? Iste, ex tempore nulla perferendis nisi
                                    explicabo
                                    incidunt illo aliquam accusantium unde dolorem possimus harum est ipsam tenetur
                                    corporis
                                    neque, magnam laudantium obcaecati atque suscipit. Ea obcaecati cumque deserunt
                                    alias
                                    officiis, esse ipsum quibusdam accusantium suscipit nihil saepe aliquam eaque maxime
                                    veniam
                                    magni minus soluta ullam aliquid? Iure aperiam, itaque dolores consectetur qui
                                    saepe.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- booking section end -->

    <!-- profile section start -->
    <section id="profile" class="profile section-padding" data-scroll-index="2">
        <div class="container">
            <div class="section-title">
                <h1>Our Services</h1>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/Picture2.png"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Whether you’re a business traveller, a couple, a big group of friends
                                or family
                                travelling with lots of luggage, by reserving your airport shuttle or private car you
                                can have the reassurance and security that you’ll be picked up on time and taken
                                straight to your home, hotel or attraction</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/green.jpg"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">We drive safely and follow all rules of the road to ensure you have a
                                safe and
                                pleasurable trip</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/istockphoto-1206670377-640x640-1-300x169.jpg"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Passenger Pick Up And Drop Off Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- profile section end -->

    <!-- android section start -->
    <section id="android" class="android section-padding" data-scroll-index="3">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-sm-6 text-white">
                    <p><img src="img/logo-green-express-one.png" class="img-fluid" width="200px"></p>
                    <h3 class="font-weight-bold">Instal juga aplikasi DayTrans di smartphone android kamu sekarang !
                    </h3>
                    <p>dapatkan kemudahan saat memesan tiket dimanapun kamu berada.</p>
                    <p class="pt-3">
                        <img src="https://www.daytrans.co.id/css/daytrans/images/qr.png" class="img-fluid pr-3"
                            width="150px">
                        <span class="align-bottom"><a
                                href="https://play.google.com/store/apps/details?id=com.trust.android.daytrans"><img
                                    src="https://www.daytrans.co.id/css/daytrans/images/playstorebtn.png"
                                    class="img-fluid bottom-align" width="150px"></a></span>
                    </p>
                </div>
                <div class="col-sm-6 mt-auto mb-auto">
                    <p class="text-center"><img src="https://www.daytrans.co.id/css/daytrans/images/phone.png"
                            class="img-fluid pr-3"></p>
                </div>
            </div>
        </div>
    </section>
    <!-- stacking section end -->

    <!-- as-seen section start -->
    {{-- <section class="as-seen section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>As Seen <span>In</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel as-seen-carousel">
                    <div class="as-seen-item">
                        <a href="https://github.com/Poincoin-Token" target="_blank">
                            <img src="img/github_PNG15.png" alt="GITHUB" class="img-fluid mx-auto d-block">
                        </a>
                    </div>
                    <div class="as-seen-item">
                        <a href="https://tronscan.io/#/token20/TU9PmX8ivxMScQSWq67xHMHL8KBUTSyFwV" target="_blank">
                            <img src="img/tronscan.png" alt="TRONSCAN" class="img-fluid mx-auto d-block">
                        </a>
                    </div>
                    <div class="as-seen-item">
                        <a href="https://justswap.io/#/home" target="_blank">
                            <img src="img/justswap.png" alt="JUSTSWAP" class="img-fluid mx-auto d-block">
                        </a>
                    </div>
                    <div class="as-seen-item">
                        <a href="https://www.tronlink.org/" target="_blank">
                            <img src="img/tronlink.png" alt="TRONLINK" class="img-fluid mx-auto d-block">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- as-seen section end -->

    <!-- contact section start -->
    {{-- <section class="contact section-padding" data-scroll-index="6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>get in <span>touch</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-lg-4">
                    <div class="contact-info">
                        <h3>For Any Queries and Support</h3>
                        <div class="contact-info-item">
                            <i class="fas fa-location-arrow"></i>
                            <h4>Company Location</h4>
                            <p>
                                <a
                                    href="https://www.google.com/search?q=Poincoin&safe=strict&rlz=1C1CHZN_enID906ID906&ei=pFZnYKiWB56H4-EPq--9iAc&oq=Poincoin&gs_lcp=Cgdnd3Mtd2l6EAMyBwgAEMkDEAoyBQgAEJIDMgUIABCSAzICCAAyAggAMgIIADIECAAQCjICCAAyBAgAEAoyAggAOgcIABBHELADUKYXWLsYYN0ZaAFwAXgAgAGrAYgBrgOSAQMwLjOYAQCgAQGqAQdnd3Mtd2l6yAEIwAEB&sclient=gws-wiz&ved=2ahUKEwjE44CRjeDvAhU4yDgGHdPdAdQQvS4wAHoECAQQLg&uact=5&tbs=lf:1,lf_ui:2&tbm=lcl&rflfq=1&num=10&rldimm=147105881091625054&lqi=CgZiaW9uZXJaEAoGYmlvbmVyIgZiaW9uZXKSARBjb21tdW5pdHlfY2VudGVyqgEOEAEqCiIGYmlvbmVyKAA&rlst=f#rlfi=hd:;si:147105881091625054,l,CgZiaW9uZXJaEAoGYmlvbmVyIgZiaW9uZXKSARBjb21tdW5pdHlfY2VudGVyqgEOEAEqCiIGYmlvbmVyKAA;mv:[[52.0709155,-118.1531556],[-33.7945478,133.42145739999998]];tbs:lrf:!1m4!1u3!2m2!3m1!1e1!1m4!1u2!2m2!2m1!1e1!2m1!1e2!2m1!1e3!3sIAE,lf:1,lf_ui:2">
                                    Jl. Pasir Kuda Raya Blok Jabaru 2 No.175, RT.04/RW.04, Pasirkuda, West Bogor, Bogor
                                    City, West Java 16119
                                </a>
                            </p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <h4>Write to us at</h4>
                            <p>
                                <a href="mailto:admin@k-rbu.com">
                                    admin@k-rbu.com
                                </a>
                            </p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <h4>Call us on</h4>
                            <p>
                                <a href="https://wa.me/62123">
                                    08123
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="contact-form">
                        <form id="form_guestbook">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name"
                                            id="nama" name="nama" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your Email"
                                            id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Your Phone"
                                            id="phone" name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Subject"
                                            id="subject" name="subject" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Your Message" id="pesan" name="pesan" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-2">Send Mesasge</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- contact section end -->

    <!-- footer section start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="footer-col">
                        <h3>About us</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic nobis fugiat quidem doloribus
                            placeat harum molestiae dolore provident aspernatur accusantium iusto quisquam ducimus
                            expedita voluptas perspiciatis, impedit aliquid odio. Odit.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-col">
                        <h3>Apps</h3>
                        <ul>
                            <li>
                                <a href="#member/signin">Sign in</a>
                            </li>
                            <li>
                                <a href="#">Sign up</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-col">
                        <h3>Quick Links</h3>
                        <ul>
                            <li>
                                <a href="#home">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-col">
                        <h3>Social Pages</h3>
                        <ul>
                            <li>
                                <a href="https://github.com/Poincoin-Token" target="_blank">Github</a>
                            </li>
                            <li>
                                <a href="https://web.facebook.com/Poincoincoin" target="_blank">Facebook</a>
                            </li>
                            <li>
                                <a href="https://t.me/joinchat/1cIjWvGCyjI0ODdl" target="_blank">Telegram</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-white">
                    <p class="copyright-text">
                    <div class="float-right d-none d-sm-block">
                        version 123
                    </div>
                    <strong>Copyright &copy; 2022 <a href=" #"
                            class="footer_link">{{ $app_name }}</a></strong>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer section end -->

    <!-- toggle theme start -->
    {{-- <div class="toggle-theme">
        <i class="fas"></i>
    </div> --}}
    <!-- toggle theme end -->


    <!-- video popup start -->
    <div class="video-popup">
        <div class="video-popup-inner">
            <i class="fas fa-times video-popup-close"></i>
            <div class="iframe-box">
                <!-- <iframe id="player-1" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
        </div>
    </div>
    <!-- video popup end -->

    <input type="text" id="base" value="{{ env('APP_URL') }}" />

    <!-- jquery js -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- popper js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="js/bootstrap4.6.0.min.js"></script>
    <!-- owl carousel js -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- ScrollIt js -->
    <script src="js/scrollIt.min.js"></script>
    <!-- sweetalert2 -->
    <script src="js/sweetalert2.all.min.js"></script>
    <!-- blockui -->
    <script src="js/jquery.blockUI.js"></script>
    <!-- main js -->
    <script src="js/welcome.js"></script>
    {{-- slick js --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    {{-- choice js --}}
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>
