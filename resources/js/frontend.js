// import './bootstrap';
import './skip-link-focus-fix';
import lightbox from './components/lightbox';
import videos from './components/videos';
import sitewideMessage from './components/sitewideMessage'
import './components/htmlToImage';

// On DOM Content Loaded
document.addEventListener('DOMContentLoaded', function () {
  lightbox();
  videos();
});


let sitewideMessageEL = document.querySelector('.sitewide-message')
if (sitewideMessageEL) {
  sitewideMessage(sitewideMessageEL)
} 