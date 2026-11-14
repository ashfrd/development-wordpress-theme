(function () {
  'use strict';

  var header = document.getElementById('header-menu');
  if (!header) {
    return;
  }

  // Bottom edge (not height) so the WP admin bar offset is included.
  function updateOffset() {
    var offset = Math.ceil(header.getBoundingClientRect().bottom);
    document.documentElement.style.setProperty('--header-height', offset + 'px');
  }

  updateOffset();

  if ('ResizeObserver' in window) {
    new ResizeObserver(updateOffset).observe(header);
  }
  window.addEventListener('resize', updateOffset);

  // The browser's initial hash scroll can run before the offset is known, so redo it.
  window.addEventListener('load', function () {
    updateOffset();

    if (window.location.hash.length > 1) {
      var target = document.getElementById(decodeURIComponent(window.location.hash.slice(1)));
      if (target) {
        target.scrollIntoView();
      }
    }
  });
})();
