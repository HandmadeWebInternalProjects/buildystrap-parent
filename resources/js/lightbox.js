import GLightbox from 'glightbox';

export default function () {

    let galleries = document.querySelectorAll('.gallery-lightbox');
    galleries.forEach(function(gallery) {
        let uuid = gallery.getAttribute('data-uuid');
        console.log('.gallery-lightbox[data-uuid="' + uuid + '"] a.lightbox-trigger')

        const lightbox = GLightbox({
            selector: '.gallery-lightbox[data-uuid="' + uuid + '"] a.lightbox-trigger',
            touchNavigation: true,
            loop: true,
        });
    });

} 