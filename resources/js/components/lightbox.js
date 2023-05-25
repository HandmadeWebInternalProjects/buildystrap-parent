import GLightbox from 'glightbox';
window.GLightbox = GLightbox;

export default function () {

    let galleries = document.querySelectorAll('.gallery-lightbox');
    galleries.forEach(function(gallery) {
        let uuid = gallery.getAttribute('data-uuid');
        const lightbox = GLightbox({
            selector: '.gallery-lightbox[data-uuid="' + uuid + '"] a.lightbox-trigger',
            touchNavigation: true,
            loop: true,
        });
        gallery.GLightbox = lightbox;
    });

} 