export default function () {
  const videoOverlays = document.querySelectorAll('.video-overlay');
  const playVimeo = (iframe) => {
    if (iframe?.classList.contains('vimeo-iframe')) {
      let data = { method: 'play' };
      iframe.contentWindow.postMessage(JSON.stringify(data), '*');
    }
  }
  videoOverlays.forEach(function (videoOverlay) {
    let playButton = videoOverlay?.querySelector('.video-play'),
      parent = playButton?.closest('.buildystrap-video-module'),
      iframe = parent?.querySelector('.video-overlay iframe'),
      autoplay = videoOverlay?.dataset.autoplay;

    if (!playButton) return;

    if (autoplay) {
      parent.classList.add('is-playing');
      playVimeo(iframe);
      return;
    }

    playButton.addEventListener('click', function (e) {
      e.preventDefault();
      parent.classList.add('is-playing');
      iframe.src += '&autoplay=1';
      playVimeo(iframe);
    }, { once: true });
  });
}  