/* Gallery page: category filter + lightbox with keyboard support. */
(function () {
  var $ = function (s, r) { return (r || document).querySelector(s); },
      $$ = function (s, r) { return [].slice.call((r || document).querySelectorAll(s)); };
  var grid = $('#glGrid'); if (!grid) return;
  var tiles = $$('.gl-tile', grid), chips = $$('.gl-chip'), lb = $('#glLb'), cur = 0, vis = tiles.slice();
  document.body.appendChild(lb);

  chips.forEach(function (c) {
    c.addEventListener('click', function () {
      chips.forEach(function (x) { x.classList.toggle('on', x === c); x.setAttribute('aria-pressed', x === c ? 'true' : 'false'); });
      var f = c.getAttribute('data-f');
      tiles.forEach(function (t) { t.classList.toggle('hide', f !== 'all' && t.getAttribute('data-cat') !== f); t.classList.add('in'); });
      vis = tiles.filter(function (t) { return !t.classList.contains('hide'); });
    });
  });

  // "See the 2024 photos" in the Journey panel: pick that year's filter, then scroll down to the grid
  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-gf]'); if (!a) return;
    var chip = $('.gl-chip[data-f="' + a.getAttribute('data-gf') + '"]'); if (!chip) return;
    e.preventDefault(); chip.click();
    $('#gallery').scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
  });

  function show(i) {
    cur = (i + vis.length) % vis.length;
    var t = vis[cur], big = $('#glBig');
    big.style.setProperty('--img', t.style.getPropertyValue('--img'));
    big.style.setProperty('--bs', t.style.getPropertyValue('--bs') || 'cover');
    big.style.setProperty('--bp', t.style.getPropertyValue('--bp') || 'center');
    big.style.backgroundColor = t.getAttribute('style').indexOf('--fit') > -1 ? '#f2c9d6' : '';
    $('#glT').textContent = t.getAttribute('data-title');
    $('#glS').textContent = t.getAttribute('data-sub');
  }
  var lastFocus = null;
  function open(t) {
    lastFocus = t;
    vis = tiles.filter(function (x) { return !x.classList.contains('hide'); });
    show(vis.indexOf(t)); lb.classList.add('on'); document.documentElement.style.overflow = 'hidden'; $('#glX').focus();
  }
  function close() { lb.classList.remove('on'); document.documentElement.style.overflow = ''; if (lastFocus) lastFocus.focus(); }

  tiles.forEach(function (t) {
    t.addEventListener('click', function () { open(t); });
    t.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(t); } });
  });
  $('#glX').addEventListener('click', close);
  $('#glPrev').addEventListener('click', function (e) { e.stopPropagation(); show(cur - 1); });
  $('#glNext').addEventListener('click', function (e) { e.stopPropagation(); show(cur + 1); });
  lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
  document.addEventListener('keydown', function (e) {
    if (!lb.classList.contains('on')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') show(cur - 1);
    if (e.key === 'ArrowRight') show(cur + 1);
  });
})();
