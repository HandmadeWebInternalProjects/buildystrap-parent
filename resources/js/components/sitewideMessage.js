import { cookieHelper } from '../util/storage'

// HMW sitewide message
export default function (el) {
  if (el) {
    const body = document.body
    const header = document.querySelector('.main-header')
    const messageBar = el
    const adminBar = document.getElementById('wpadminbar')
    const links = messageBar.querySelectorAll('a');
    const exitButton = messageBar.querySelector('.bar-exit')
    const storage = new cookieHelper('sitewide_message', 4)
    const visibleClass = 'message-bar-visible'
    let messageBarHeight = messageBar?.clientHeight || 0

    let options = {
      root: null,
      rootMargin: '0px',
      threshold: 0
    }

    // let observer = new IntersectionObserver(visibilityCheck, options);

    scrollToggle('up')

    let timeout;
    if (!storage.checkCookie()) {
      timeout = setTimeout(function () {
        openMessage()
      }, 250)
    }

    const stopProp = (e) => {
      return e.stopPropagation();
    }

    function openMessage() {
      messageBar.addEventListener('click', stopProp, { once: true })

      body.classList.add(visibleClass)

      messageBar.classList.add('is--visible')
      scrollToggle('down')

      messageBarHeight = messageBar?.clientHeight

      if (window.pageYOffset < 100) {
        window.scrollTo(0, 0);
      }

      // observer.observe(messageBar);

      // window.addEventListener('scroll', messageBarVisibilityCheck, true)

      exitButton.addEventListener('click', closeMessage, { once: true })
      messageBar.dispatchEvent(new CustomEvent('hmw_message:opened'));
    }

    function closeMessage(e) {
      messageBar.classList.remove('is--visible')
      body.classList.remove(visibleClass)

      scrollToggle('up')

      header.style.top = 0;

      storage.setCookie()
      messageBar.dispatchEvent(new CustomEvent('hmw_message:closed'));
    }

    function visibilityCheck(entries, observer) {
      entries.forEach(entry => {
        let headerTop = parseInt(header.style.top) || 0;
        if (entry.isIntersecting) {
          document.body.classList.remove('sticky')
          window.dispatchEvent(new CustomEvent(`body-unstickied`));
          document.body.classList.add(visibleClass)
        } else {
          document.body.classList.add('sticky')
          window.dispatchEvent(new CustomEvent(`body-stickied`));
          document.body.classList.remove(visibleClass)
        }
      });
    }

    function scrollToggle(direction) {
      messageBar.style.marginTop = `${direction === 'up' ? `-${messageBarHeight}px` : 0}`
    }
  }
}
