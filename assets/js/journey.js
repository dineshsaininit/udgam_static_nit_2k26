/* Homepage: "A Journey Through Time" — the little car drives to the year you pick, then opens that edition. */
(function () {
  'use strict';
  var scene = document.getElementById('jyScene'),
      scroller = document.getElementById('jyScroller'),
      car = document.getElementById('jyCar');
  if (!scene || !car) return;

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var years = scene.querySelectorAll('.jy-year');
  var driving = false;
  function store(k, v) { try { if (v === undefined) return sessionStorage.getItem(k); sessionStorage.setItem(k, v); } catch (e) {} return null; }

  function carLeftFor(y) {
    return ((y.offsetLeft + y.offsetWidth / 2 - car.offsetWidth / 2) / scene.clientWidth) * 100;
  }
  function park(y) {
    if (!y) return;
    var t = car.style.transition;
    car.style.transition = 'none';
    car.style.left = carLeftFor(y) + '%';
    car.offsetWidth;
    car.style.transition = t;
  }
  function scrollToYear(y, smooth) {
    scroller.scrollTo({ left: y.offsetLeft + y.offsetWidth / 2 - scroller.clientWidth / 2, behavior: smooth ? 'smooth' : 'auto' });
  }
  function restingTree() {
    return scene.querySelector('.jy-year[data-year="' + store('jyLast') + '"]') || scene.querySelector('.jy-current');
  }

  scroller.addEventListener('scroll', function () { if (scroller.scrollLeft > 24) scroller.classList.add('jy-moved'); }, { passive: true });
  var start = restingTree();
  park(start); scrollToYear(start, false);

  [].forEach.call(years, function (y) {
    y.addEventListener('click', function (e) {
      var url = y.getAttribute('href');
      if (!url || url.charAt(0) === '#') { e.preventDefault(); return; }   // 2026 = "you are here"
      e.preventDefault();
      if (driving) return;
      driving = true;

      // open the tab right now (inside the click) so pop-up blockers allow it; point it at the page after the drive
      var tab = null;
      try { tab = window.open('', '_blank'); if (tab) tab.opener = null; } catch (err) {}

      var from = car.offsetLeft / scene.clientWidth * 100, to = carLeftFor(y);
      var secs = reduce ? 0.01 : Math.min(3, 0.9 + Math.abs(to - from) * 0.045);
      car.style.setProperty('--drive-time', secs + 's');
      car.style.setProperty('--dir', to >= from ? 1 : -1);
      scrollToYear(y, true);
      car.classList.add('driving');
      car.style.left = to + '%';

      setTimeout(function () {
        car.classList.remove('driving');
        store('jyLast', y.dataset.year);
        if (tab) tab.location.href = url; else window.open(url, '_blank', 'noopener');
        driving = false;
      }, secs * 1000 + (reduce ? 0 : 450));
    });
  });

  window.addEventListener('resize', function () { if (!driving) park(restingTree()); });
  window.addEventListener('load', function () { if (!driving) park(restingTree()); });
})();
