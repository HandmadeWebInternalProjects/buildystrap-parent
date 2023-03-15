/* ES6 */
// import html2canvas
import html2canvas from 'html2canvas';
// import * as htmlToImage from 'html-to-image';
// import { toPng, toJpeg, toBlob, toPixelData, toSvg } from 'html-to-image';

const nodes = document.querySelectorAll('.module-render-preview');

if (nodes.length) {
  nodes.forEach((node) => {
    html2canvas(node).then(function (canvas) {
      node.remove();
      const img = document.createElement('img');
      img.src = canvas.toDataURL("image/jpg");
      img.style.maxWidth = '48rem';
      img.style.maxHeight = '30rem';
      img.classList.add('h-100', 'w-100', 'object-cover')
      document.body.appendChild(img);
    });
  });
}