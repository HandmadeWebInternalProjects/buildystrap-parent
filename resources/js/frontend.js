// import './bootstrap';
import './skip-link-focus-fix';
import lightbox from './components/lightbox';
import videos from './components/videos';

// On DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    lightbox();
    videos();
});