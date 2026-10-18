/* Homepage: mounts the rotating 3D island (assets/models) when the About section comes near. */
(function () {
  var art = document.getElementById('abArt'), canvas = document.getElementById('abCanvas'), poster = document.getElementById('abPoster');
  if (!art || !canvas || !window.IslandViewer) return;
  var model = canvas.getAttribute('data-model') || 'assets/models/island.glb';
  var texture = canvas.getAttribute('data-texture') || 'assets/models/island-texture.jpg';
  var started = false;
  function start() {
    if (started) return; started = true;
    fetch(model).then(function (r) { if (!r.ok) throw new Error(r.status); return r.arrayBuffer(); })
      .then(function (buf) {
        IslandViewer.mount(canvas, { data: buf, texture: texture, angle: 0.55,
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
