/* Homepage: mounts the rotating 3D island (assets/models) when the About section comes near.
   The 3D viewer script (~650 KB) and model (~1.2 MB) are fetched only then, and never on weak or
   data-saving devices: those keep the still poster picture, which looks the same at rest. */
(function () {
  var art = document.getElementById('abArt'), canvas = document.getElementById('abCanvas'), poster = document.getElementById('abPoster');
  if (!art || !canvas) return;
  var model = canvas.getAttribute('data-model') || 'assets/models/island.glb';
  var texture = canvas.getAttribute('data-texture') || 'assets/models/island-texture.jpg';
  var viewer = canvas.getAttribute('data-viewer') || 'assets/js/island-viewer.js';

  var nav = navigator, conn = nav.connection || {};
  var weak = conn.saveData || /(^|-)2g$/.test(conn.effectiveType || '') ||
             (nav.deviceMemory && nav.deviceMemory <= 2) || (nav.hardwareConcurrency && nav.hardwareConcurrency <= 2) ||
             window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
             window.matchMedia('(pointer: coarse) and (max-width: 700px)').matches;
  if (weak) return;

  function loadViewer() {
    if (window.IslandViewer) return Promise.resolve();
    return new Promise(function (ok, fail) {
      var s = document.createElement('script');
      s.src = viewer; s.async = true; s.onload = ok; s.onerror = fail;
      document.head.appendChild(s);
    });
  }
  var started = false;
  function start() {
    if (started) return; started = true;
    Promise.all([loadViewer(), fetch(model).then(function (r) { if (!r.ok) throw new Error(r.status); return r.arrayBuffer(); })])
      .then(function (res) {
        if (!window.IslandViewer) return;
        IslandViewer.mount(canvas, { data: res[1], texture: texture, angle: 0.55,
          onReady: function () { canvas.classList.add('on'); poster.classList.add('off'); },
          onFail: function () { /* keep the still poster picture */ } });
      })
      .catch(function () { /* keep the still poster picture */ });
  }
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { io.disconnect(); start(); } }, { rootMargin: '700px 0px' });
    io.observe(art);
  } else { start(); }
})();
