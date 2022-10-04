// global variable
let site_url = $('#base').val();
let from_type = 'airport'
let from_area_id = null

$(window).on("load", function () {
    $('.preloader').fadeOut("slow");
});

$(document).ready(function () {

    // navbar shrink
    $(window).on("scroll", function () {
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
    $.scrollIt({
        topOffset: -50
    });

    // navbar colapse
    $('.nav-link').on('click', function () {
        $('.navbar-collapse').collapse("hide");
    });


    // toggle theme
    toggleTheme();
    $('.toggle-theme').on('click', function () {
        $("body").toggleClass("dark");

        if ($('body').hasClass("dark")) {
            localStorage.setItem("bioner-theme", "dark");
        } else {
            localStorage.setItem("bioner-theme", "light");
        }

        updateIcon();
    });

    initData()

    $('input[name=from_type]').on('change', e => {
        from_type = $('input[name=from_type]:checked').val();
        getFromToList()
    })

    $('#from_area_id').on('change', e => {
        from_area_id = parseInt($('#from_area_id').val())
    })
});

function initData() {
    from_type = $('input[name=from_type]:checked').val();
    getFromList()
    getToList()
}

function getFromList() {
    $.ajax({
        url: `${site_url}api/get_list_from_departure`,
        method: 'get',
        dataType: 'json',
        data: {
            from_type
        },
        beforeSend: () => {
            $('#from_area_id').html('<option value=""></option>').prop('disabled', true)
        }
    }).fail(e => {
        console.log(e.responseText)
    }).done(e => {
        console.log(e)
        let data = e.data
        let htmlnya = '<option value=""></option>';

        data.forEach(x => {
            let id = x.id
            let name = x.name
            htmlnya += `<option value="${id}">${name}</option>`
        })
        $('#from_area_id').html(htmlnya).prop('disabled', false)
    })
}

function getToList() {
    $.ajax({
        url: `${site_url}api/get_list_to_destination`,
        method: 'get',
        dataType: 'json',
        data: {
            from_type
        },
        beforeSend: () => {
            $('#to_area_id').html('<option value=""></option>').prop('disabled', true)
        }
    }).fail(e => {
        console.log(e.responseText)
    }).done(e => {
        console.log(e)
        let data = e.data
        let htmlnya = '<option value=""></option>';

        data.forEach(x => {
            let id = x.id
            let name = x.name
            htmlnya += `<option value="${id}">${name}</option>`
        })
        $('#to_area_id').html(htmlnya).prop('disabled', false)
    })
}

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
        timer: 3000,
    });
}
