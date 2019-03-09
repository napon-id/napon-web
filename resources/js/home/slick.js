(function ($) {
    $(function () {
        // Why Choose Us carousel
        $('.why-choose-us').slick({
          arrows: false,
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 1500,
        });

        // hero carousel
        $('.hero').slick({
            arrows: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
        });
    })
}) ( jQuery );
