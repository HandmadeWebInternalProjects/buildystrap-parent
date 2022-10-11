// Swiper JS
const sliders = document.querySelectorAll('.swiper');
sliders.forEach(slider => {
    new Swiper(slider, {
        autoHeight: true,
        autoplay: true,
        loop: true,
        pauseOnMouseEnter: true,
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});