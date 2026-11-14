(function () {
  'use strict';

  var header = document.getElementById('header-menu');
  if (!header) {
    return;
  }

  var trigger = header.querySelector('.mobileHeader__trigger');
  var overlay = header.querySelector('.mobileHeader__overlay');
  var menu = header.querySelector('.mainHeader__menu');
  var desktopQuery = window.matchMedia('(min-width: 992px)');

  function setMenu(open) {
    header.classList.toggle('is-menu-open', open);
    document.body.classList.toggle('menu-open', open);
    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    trigger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  }

  function updateStuck() {
    header.classList.toggle('is-stuck', window.scrollY > 10);
  }

  updateStuck();
  window.addEventListener('scroll', updateStuck, { passive: true });

  function isOpen() {
    return header.classList.contains('is-menu-open');
  }

  if (trigger && menu) {
    trigger.addEventListener('click', function () {
      setMenu(!isOpen());
    });

    if (overlay) {
      overlay.addEventListener('click', function () {
        setMenu(false);
      });
    }

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && isOpen()) {
        setMenu(false);
        trigger.focus();
      }
    });

    // Close the drawer when a link is followed (e.g. in-page anchors).
    menu.addEventListener('click', function (event) {
      if (event.target.closest('a[href]')) {
        setMenu(false);
      }
    });

    desktopQuery.addEventListener('change', function (event) {
      if (event.matches) {
        setMenu(false);
      }
    });
  }

})();
