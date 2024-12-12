// import './bootstrap';
import "@/sass/parent-style.scss";

declare global {
  interface Window {
    bs_video_init: any;
  }
}

import "./skip-link-focus-fix";
import lightbox from "./components/lightbox";
import videos from "./components/videos";
import sitewideMessage from "./components/sitewideMessage";

// In case we have to re-call this function due to AJAX
window.bs_video_init = videos;

// On DOM Content Loaded
document.addEventListener("DOMContentLoaded", function () {
  lightbox();
  videos();
});

let sitewideMessageEL = document.querySelector(".sitewide-message");
if (sitewideMessageEL) {
  sitewideMessage(sitewideMessageEL);
}
