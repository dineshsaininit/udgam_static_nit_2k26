/* Homepage: "A Journey Through Time" — point at a year (or pick a chip) and the little car drives there;
   the panel below shows that edition, and the tree / panel button open its website. */
(function () {
  'use strict';
  var scene = document.getElementById('jyScene'),
      scroller = document.getElementById('jyScroller'),
      car = document.getElementById('jyCar'),
      panel = document.getElementById('jyPanel');
  if (!scene || !car) return;

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches,
      fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var years = [].slice.call(scene.querySelectorAll('.jy-year')),
      chips = panel ? [].slice.call(panel.querySelectorAll('.jy-chip')) : [],
      eds = panel ? [].slice.call(panel.querySelectorAll('.jy-ed')) : [];
  var cur = null, parkTimer = 0, hoverTimer = 0, slideTimer = 0;
  function store(k, v) { try { if (v === undefined) return sessionStorage.getItem(k); sessionStorage.setItem(k, v); } catch (e) {} return null; }
  function tree(yr) { return scene.querySelector('.jy-year[data-year="' + yr + '"]'); }

  function carLeftFor(y) { return ((y.offsetLeft + y.offsetWidth / 2 - car.offsetWidth / 2) / scene.clientWidth) * 100; }
  function park(y) {
    if (!y) return;
    var t = car.style.transition;
    car.style.transition = 'none';
    car.style.left = carLeftFor(y) + '%';
    car.offsetWidth;
    car.style.transition = t;
  }
  function scrollToYear(y, smooth) {
    // only the phone layout scrolls sideways; never yank the page while someone is pointing with a mouse
    if (scroller.scrollWidth <= scroller.clientWidth + 2) return;
    scroller.scrollTo({ left: y.offsetLeft + y.offsetWidth / 2 - scroller.clientWidth / 2, behavior: smooth ? 'smooth' : 'auto' });
  }
  function drive(y) {
    var from = car.offsetLeft / scene.clientWidth * 100, to = carLeftFor(y);
    if (Math.abs(to - from) < .2) return;
    var secs = reduce ? 0.01 : Math.min(2.2, 0.7 + Math.abs(to - from) * 0.03);
    car.style.setProperty('--drive-time', secs + 's');
    car.style.setProperty('--dir', to >= from ? 1 : -1);
    car.classList.add('driving');
    car.style.left = to + '%';
    clearTimeout(parkTimer);
    parkTimer = setTimeout(function () { car.classList.remove('driving'); }, secs * 1000 + 60);
  }

  /* ---- edition panel ---- */
  function slides(ed) {
    clearInterval(slideTimer);
    var ph = ed ? [].slice.call(ed.querySelectorAll('.jy-ph')) : [], dots = ed ? ed.querySelectorAll('.jy-dots i') : [], k = 0;
    function show(n) { ph.forEach(function (p, i) { p.classList.toggle('on', i === n); }); [].forEach.call(dots, function (d, i) { d.classList.toggle('on', i === n); }); }
    show(0);
    if (ph.length > 1 && !reduce) slideTimer = setInterval(function () { k = (k + 1) % ph.length; show(k); }, 3200);
  }
  function showEdition(yr) {
    eds.forEach(function (ed) {
      var on = ed.getAttribute('data-year') === yr;
      if (on && ed.hidden) { ed.hidden = false; ed.classList.remove('jy-in'); ed.offsetWidth; ed.classList.add('jy-in'); slides(ed); }
      else if (!on) ed.hidden = true;
    });
    chips.forEach(function (c) { var on = c.getAttribute('data-year') === yr; c.classList.toggle('on', on); c.setAttribute('aria-pressed', on ? 'true' : 'false'); });
  }

  function select(yr, opts) {
    var y = tree(yr);
    if (!y || yr === cur) return;
    cur = yr;
    years.forEach(function (t) { t.classList.toggle('on', t === y); });
    if (opts && opts.scroll) scrollToYear(y, true);
    drive(y);
    showEdition(yr);
    store('jyLast', yr);
  }

  var viaPointer = false;
  document.addEventListener('pointerdown', function () { viaPointer = true; }, true);
  document.addEventListener('keydown', function () { viaPointer = false; }, true);

  scroller.addEventListener('scroll', function () { if (scroller.scrollLeft > 24) scroller.classList.add('jy-moved'); }, { passive: true });

  years.forEach(function (y) {
    var yr = y.getAttribute('data-year');
    if (fine) {
      y.addEventListener('mouseenter', function () { clearTimeout(hoverTimer); hoverTimer = setTimeout(function () { select(yr); }, 140); });
      y.addEventListener('mouseleave', function () { clearTimeout(hoverTimer); });
    }
    y.addEventListener('focus', function () { if (!viaPointer) select(yr); });  // keyboard only; taps are handled on click
    y.addEventListener('click', function (e) {
      var href = y.getAttribute('href');
      // touch / keyboard: the first press drives there and shows the edition, the next one opens it
      if (yr !== cur) { e.preventDefault(); clearTimeout(hoverTimer); select(yr, { scroll: true }); return; }
      if (!href || href.charAt(0) === '#') e.preventDefault();          // 2026 = "you are here"
    });
  });
  chips.forEach(function (c) {
    c.addEventListener('click', function () { select(c.getAttribute('data-year'), { scroll: true }); });
  });

  // start parked at the last visited edition (or the one the panel opened with), without driving
  var openEd = eds.filter(function (ed) { return !ed.hidden; })[0];
  var start = store('jyLast') || (openEd && openEd.getAttribute('data-year')) || '2026';
  if (!tree(start)) start = '2026';
  cur = start;
  years.forEach(function (t) { t.classList.toggle('on', t.getAttribute('data-year') === start); });
  showEdition(start);
  if (openEd && openEd.getAttribute('data-year') === start) slides(openEd);
  park(tree(start)); scrollToYear(tree(start), false);

  // warm up every edition's photos once the section is near, so switching years never shows an empty frame
  if (panel) {
    var warm = function () { [].forEach.call(panel.querySelectorAll('img[loading="lazy"]'), function (im) { im.loading = 'eager'; }); };
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { warm(); io.disconnect(); } }, { rootMargin: '600px 0px' });
      io.observe(panel);
    } else warm();
  }

  window.addEventListener('resize', function () { if (!car.classList.contains('driving')) park(tree(cur)); });
  window.addEventListener('load', function () { if (!car.classList.contains('driving')) park(tree(cur)); });
})();
