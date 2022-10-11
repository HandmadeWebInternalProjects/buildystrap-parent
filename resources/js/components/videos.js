export default function () {
    const videoOverlays = document.querySelectorAll('.video-overlay');
    videoOverlays.forEach(function (videoOverlay) {
        let playButton = videoOverlay.querySelector('.video-play');
        playButton.addEventListener('click', function (e) {
            e.preventDefault();
            let parent = e.target.closest('.buildystrap-video-module'),
                iframe = parent.querySelector('.video-overlay iframe');
            parent.classList.add('is-playing');
            iframe.src += '&autoplay=1';
            if (iframe.classList.contains('vimeo-iframe')) {
                let data = { method: 'play' };
                iframe.contentWindow.postMessage(JSON.stringify(data), '*');
            }
        });
    });
}  