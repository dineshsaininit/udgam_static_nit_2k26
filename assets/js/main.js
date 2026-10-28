/* UDGAM 2K26 — shared behaviour for every page.
   Header/nav, progress bar, welcome gate (homepage only), scroll reveals,
   portrait fallbacks, petal burst, falling petals and the Ferris-wheel menu. */
(function () {
  'use strict';

  var d = document, root = d.documentElement, body = d.body;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var raf = window.requestAnimationFrame.bind(window);

  /* ------------------------------------------------------------------
     Header: mobile menu toggle + "scrolled" look.
     ------------------------------------------------------------------ */
  var head = d.getElementById('siteHead'), tog = d.getElementById('navToggle'), nav = d.getElementById('siteNav');
  function closeNav() { if (!head) return; head.classList.remove('open'); if (tog) tog.setAttribute('aria-expanded', 'false'); }
  if (tog && nav) {
    tog.addEventListener('click', function () {
      var open = head.classList.toggle('open');
      tog.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    nav.addEventListener('click', function (e) { if (e.target.tagName === 'A') closeNav(); });
    d.addEventListener('keydown', function (e) { if (e.key === 'Escape' && head.classList.contains('open')) { closeNav(); tog.focus(); } });
    d.addEventListener('pointerdown', function (e) { if (head.classList.contains('open') && !head.contains(e.target)) closeNav(); });
  }

  /* ------------------------------------------------------------------
     One scroll handler: progress bar, header state, hero parallax.
     ------------------------------------------------------------------ */
  var bar = d.getElementById('progress'), hero = d.getElementById('heroParallax'), ticking = false;
  function frame() {
    ticking = false;
    var y = window.pageYOffset, h = window.innerHeight, max = root.scrollHeight - h,
        p = max > 0 ? Math.min(Math.max(y / max, 0), 1) : 0;
    if (bar) bar.style.setProperty('--p', p.toFixed(4));
    if (head) head.classList.toggle('scrolled', y > 36);
    if (hero && !reduce && y < h * 2) hero.style.transform = 'translate3d(0,' + (y * .14).toFixed(1) + 'px,0)';
  }
  function onScroll() { if (!ticking) { ticking = true; raf(frame); } }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', frame);
  frame();

  /* ------------------------------------------------------------------
     Petal burst: a few petals pop out from a point and drift down.
     ------------------------------------------------------------------ */
  var CELLS = ['0% 0%', '50% 0%', '100% 0%', '0% 50%', '50% 50%', '100% 50%', '0% 100%', '50% 100%', '100% 100%'];
  function burst(x, y, n) {
    if (reduce || !Element.prototype.animate) return;
    for (var i = 0; i < n; i++) {
      var s = d.createElement('span');
      s.className = 'burst';
      s.style.left = x + 'px';
      s.style.top = y + 'px';
      s.style.backgroundPosition = CELLS[(Math.random() * CELLS.length) | 0];
      var a = Math.random() * Math.PI * 2,
          dist = 50 + Math.random() * 130,
          dx = Math.cos(a) * dist,
          dy = Math.sin(a) * dist * .7 - 30,
          size = .55 + Math.random() * .7;
      var anim = s.animate([
        { transform: 'translate(-50%,-50%) scale(.2) rotate(0deg)', opacity: 0 },
        { transform: 'translate(calc(-50% + ' + dx * .6 + 'px),calc(-50% + ' + dy * .6 + 'px)) scale(' + size + ') rotate(' + (a * 60) + 'deg)', opacity: 1, offset: .35 },
        { transform: 'translate(calc(-50% + ' + dx + 'px),calc(-50% + ' + (dy + 110) + 'px)) scale(' + size * .9 + ') rotate(' + (a * 140) + 'deg)', opacity: 0 }
      ], { duration: 1000 + Math.random() * 700, easing: 'cubic-bezier(.2,.7,.3,1)' });
      anim.onfinish = (function (node) { return function () { node.remove(); }; })(s);
      body.appendChild(s);
    }
  }

  /* ------------------------------------------------------------------
     Scroll reveal for .reveal (big sections) and .nr (cards).
     ------------------------------------------------------------------ */
  var revealed = false;
  function startReveal() {
    if (revealed) return; revealed = true;
    var items = [].slice.call(d.querySelectorAll('.reveal, .nr'));
    if (!('IntersectionObserver' in window)) {
      items.forEach(function (n) { n.classList.add('in'); });
      root.classList.add('no-io');
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0, rootMargin: '0px 0px -8% 0px' });
    items.forEach(function (n) { io.observe(n); });
  }

  /* ------------------------------------------------------------------
     Portraits: Google-Drive thumbnail -> alternate host -> initials.
     Works for any element with [data-photo] wrapping an <img>.
     ------------------------------------------------------------------ */
  function wirePhoto(img) {
    var box = img.closest('[data-photo]');
    if (!box || img._wired) return;
    img._wired = true;
    var alt = img.getAttribute('data-fallback');
    function ok() { box.dataset.photo = 'ok'; }
    function fail() {
      if (alt) { img.src = alt; alt = null; }
      else { img.remove(); box.dataset.photo = 'failed'; }
    }
    img.addEventListener('load', ok);
    img.addEventListener('error', fail);
    if (img.complete && img.naturalWidth) ok();
  }
  [].forEach.call(d.querySelectorAll('[data-photo] img'), wirePhoto);

  window.UDGAM = { burst: burst, wirePhoto: wirePhoto, startReveal: startReveal, reduce: reduce };

  /* ------------------------------------------------------------------
     Entering the site. The homepage has the welcome gate; every other
     page (and return visits within the same session) starts open.
     ------------------------------------------------------------------ */
  var entered = false;
  function markEntered() {
    body.classList.remove('locked');
    body.classList.add('entered');
    entered = true;
    startReveal();
    frame();
  }

  var gate = d.getElementById('gate'), btn = d.getElementById('enterBtn');
  var seen = false;
  try { seen = sessionStorage.getItem('udgamEntered') === '1'; } catch (err) {}

  if (!gate || !btn || seen || location.hash) {
    if (gate) gate.hidden = true;
    markEntered();
  } else {
    // Wait for the artwork, then play the entrance.
    var decoded = [].slice.call(gate.querySelectorAll('img')).map(function (im) {
      return im.decode ? im.decode().catch(function () {}) :
        new Promise(function (r) { if (im.complete) r(); else im.onload = im.onerror = r; });
    });
    Promise.race([Promise.all(decoded), new Promise(function (r) { setTimeout(r, 2500); })])
      .then(function () { gate.classList.add('ready'); });

    // Mouse parallax: art, title and petals drift at different depths.
    var px = 0, py = 0, tx = 0, ty = 0, pRaf = 0;
    function parallaxLoop() {
      px += (tx - px) * .07; py += (ty - py) * .07;
      gate.style.setProperty('--px', px.toFixed(4));
      gate.style.setProperty('--py', py.toFixed(4));
      pRaf = (Math.abs(tx - px) > .001 || Math.abs(ty - py) > .001) ? raf(parallaxLoop) : 0;
    }
    gate.addEventListener('pointermove', function (e) {
      if (reduce || e.pointerType === 'touch') return;
      tx = e.clientX / window.innerWidth * 2 - 1;
      ty = e.clientY / window.innerHeight * 2 - 1;
      if (!pRaf) pRaf = raf(parallaxLoop);
    });
    gate.addEventListener('pointerleave', function () { tx = ty = 0; if (!pRaf) pRaf = raf(parallaxLoop); });

    var entering = false;
    function enter() {
      if (entering) return;
      entering = true;
      btn.disabled = true;
      var r = btn.getBoundingClientRect();
      burst(r.left + r.width / 2, r.top + r.height / 2, 18);
      gate.classList.add('is-zooming');
      try { sessionStorage.setItem('udgamEntered', '1'); } catch (err) {}
      setTimeout(function () {
        window.scrollTo(0, 0);
        markEntered();
        gate.classList.add('is-open');
        setTimeout(function () { gate.hidden = true; }, 2600);
      }, reduce ? 150 : 1000);
    }
    btn.addEventListener('click', enter);
    d.addEventListener('keydown', function (e) {
      if (entering) return;
      if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown' || e.key === 'PageDown') { e.preventDefault(); enter(); }
    });
    window.addEventListener('wheel', function (e) { if (!entering && e.deltaY > 30) enter(); }, { passive: true });
    var touchY = null;
    window.addEventListener('touchstart', function (e) { touchY = e.touches[0].clientY; }, { passive: true });
    window.addEventListener('touchmove', function (e) {
      if (!entering && touchY !== null && touchY - e.touches[0].clientY > 50) enter();
    }, { passive: true });
  }

  // Click anywhere on the page: a small burst of petals.
  var main = d.getElementById('main');
  if (main) main.addEventListener('pointerdown', function (e) {
    if (!entered || e.target.closest('a, button, input, select, [role="button"], canvas')) return;
    burst(e.clientX, e.clientY, 7);
  });

  /* ------------------------------------------------------------------
     Falling petals over the whole page (canvas).
     ------------------------------------------------------------------ */
  (function () {
    var cv = d.getElementById('petalFall');
    if (!cv || !cv.getContext || reduce) { if (cv) cv.style.display = 'none'; return; }
    var ctx = cv.getContext('2d'), W = 0, H = 0, dpr = 1, petals = [], running = false, last = 0, lastY = window.pageYOffset || 0, t = 0;
    var nv = navigator, weak = (nv.connection && nv.connection.saveData) || (nv.deviceMemory && nv.deviceMemory <= 2) || (nv.hardwareConcurrency && nv.hardwareConcurrency <= 2);  // fewer, cheaper petals on low-end devices
    function sprite(c1, c2) {
      var s = d.createElement('canvas'); s.width = 48; s.height = 64;
      var g = s.getContext('2d'); g.translate(24, 32);
      var gr = g.createLinearGradient(-10, -26, 10, 26); gr.addColorStop(0, c1); gr.addColorStop(1, c2);
      g.fillStyle = gr; g.beginPath(); g.moveTo(0, -27);
      g.bezierCurveTo(17, -19, 19, 11, 0, 27); g.bezierCurveTo(-19, 11, -17, -19, 0, -27); g.closePath(); g.fill();
      g.strokeStyle = 'rgba(255,255,255,.35)'; g.lineWidth = 1.4; g.beginPath(); g.moveTo(0, -20); g.quadraticCurveTo(1.5, 0, 0, 20); g.stroke();
      return s;
    }
    var sprites = [sprite('#ffd0df', '#ff9db9'), sprite('#ffe3ec', '#ffb6cb'), sprite('#fff3f6', '#ffc3d4'), sprite('#ff9bbb', '#ea6d94')];
    function rnd(a, b) { return a + Math.random() * (b - a); }
    function make(p, fresh) {
      p.s = sprites[(Math.random() * sprites.length) | 0];
      p.size = rnd(11, 24); p.depth = rnd(.35, 1);
      p.x = rnd(-20, W + 20); p.y = fresh ? rnd(-H * .1, H) : rnd(-60, -20);
      p.vy = rnd(34, 78) * (.6 + p.depth * .6); p.amp = rnd(14, 42); p.ph = rnd(0, 6.28); p.fr = rnd(.5, 1.3);
      p.rot = rnd(0, 6.28); p.spin = rnd(-1.4, 1.4); p.flip = rnd(0, 6.28); p.ff = rnd(1.2, 2.8); p.a = rnd(.55, .95) * (.55 + p.depth * .45);
      return p;
    }
    function resize() {
      dpr = weak ? 1 : Math.min(window.devicePixelRatio || 1, 1.5);
      W = window.innerWidth; H = window.innerHeight;
      cv.width = Math.round(W * dpr); cv.height = Math.round(H * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      var n = W < 600 ? 18 : Math.max(22, Math.min(42, Math.round(W / 40)));
      if (weak) n = Math.round(n / 2);
      while (petals.length < n) petals.push(make({}, true));
      petals.length = n;
    }
    function loop(now) {
      if (!running) return;
      var dt = Math.min((now - last) / 1000, .05); last = now; t += dt;
      ctx.clearRect(0, 0, W, H);
      var wind = Math.sin(t * .35) * 16 + 8;
      for (var i = 0; i < petals.length; i++) {
        var p = petals[i];
        p.y += p.vy * dt; p.ph += p.fr * dt; p.rot += p.spin * dt; p.flip += p.ff * dt;
        var x = p.x + Math.sin(p.ph) * p.amp + wind * p.depth * .25;
        p.x += wind * dt * p.depth * .6;
        if (p.y > H + 40 || p.x > W + 60) make(p, false);
        if (p.x < -60) p.x = W + 40;
        var w = p.size * .7 * (.35 + Math.abs(Math.cos(p.flip)) * .65), h = p.size * 1.15;
        ctx.globalAlpha = p.a;
        ctx.save(); ctx.translate(x, p.y); ctx.rotate(p.rot); ctx.drawImage(p.s, -w / 2, -h / 2, w, h); ctx.restore();
      }
      ctx.globalAlpha = 1;
      requestAnimationFrame(loop);
    }
    function go() { if (running || d.hidden) return; running = true; last = performance.now(); requestAnimationFrame(loop); }
    function stop() { running = false; }
    window.addEventListener('scroll', function () {
      var y = window.pageYOffset || 0, dy = y - lastY; lastY = y;
      for (var i = 0; i < petals.length; i++) { var p = petals[i]; p.y -= dy * p.depth * .22; if (p.y < -70) p.y = H + 30; }
    }, { passive: true });
    window.addEventListener('resize', resize);
    d.addEventListener('visibilitychange', function () { d.hidden ? stop() : go(); });
    resize(); go();
  })();

  /* ------------------------------------------------------------------
     In-page section navigation. Blended sections (.pg/.jy/.ev) pull
     themselves up over the previous one with a negative top margin, so
     "the start of the section" is a little below its box top. data-nav
     on the section says how far into that overlap to land (0..1).
     Used by the Ferris wheel, same-page anchor links and #hash URLs.
     ------------------------------------------------------------------ */
  function sectionTop(sec) {
    var f = parseFloat(sec.getAttribute('data-nav'));
    if (isNaN(f)) f = .5;
    var mt = parseFloat(getComputedStyle(sec).marginTop) || 0;
    var fade = -Math.min(0, mt) * f;                       // only negative margins count
    var cs = getComputedStyle(sec), hh = ((d.querySelector('.site-head') || {}).offsetHeight || 0);
    var padTop = parseFloat(cs.paddingTop) || 0;
    // blended sections: land inside the fade, but never let the fixed header cover the section's content
    var head = sec.id === 'home' ? 0 : (mt < 0 ? Math.max(0, hh + 12 - (padTop - fade)) : hh + 16);
    return Math.max(0, sec.getBoundingClientRect().top + window.pageYOffset + fade - head);
  }
  function goTo(sec, smooth) {
    window.scrollTo({ top: sectionTop(sec), behavior: (smooth && !reduce) ? 'smooth' : 'auto' });
  }
  window.UDGAM.goTo = goTo;

  function hashTarget(h) {
    h = (h || '').replace(/^#/, '');
    if (!h) return null;
    try { h = decodeURIComponent(h); } catch (err) {}
    return d.getElementById(h);
  }
  function samePath(a, b) {
    var f = function (p) { return p.replace(/\/index\.php$/, '/'); };
    return f(a) === f(b);
  }
  // Same-page anchor clicks (header "About", wheel cabins, year plaques, directory chips, ...)
  d.addEventListener('click', function (e) {
    if (e.defaultPrevented || e.button || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    var a = e.target.closest && e.target.closest('a[href]');
    if (!a || a.target === '_blank') return;
    var u; try { u = new URL(a.getAttribute('href'), location.href); } catch (err) { return; }
    if (u.origin !== location.origin || !samePath(u.pathname, location.pathname) || !u.hash) return;
    var sec = hashTarget(u.hash);
    if (!sec) return;
    e.preventDefault();
    goTo(sec, true);
    if (location.hash !== u.hash) { try { history.pushState(null, '', u.hash); } catch (err) {} }
  });
  // Arriving with a #hash: the browser jumps before images/layout settle, so re-aim once now and once after load.
  if (location.hash && hashTarget(location.hash)) {
    try { if ('scrollRestoration' in history) history.scrollRestoration = 'manual'; } catch (err) {}
    var hashSec = hashTarget(location.hash), aiming = true;
    goTo(hashSec, false);
    // keep re-aiming while fonts/images settle the layout, until the user takes over or 2.5s pass
    var stopAim = function () { aiming = false; };
    ['wheel', 'touchstart', 'keydown', 'pointerdown'].forEach(function (t) { window.addEventListener(t, stopAim, { passive: true, once: true }); });
    var reAim = function () { if (aiming) goTo(hashSec, false); };
    if ('ResizeObserver' in window) { var ro = new ResizeObserver(reAim); ro.observe(d.documentElement); setTimeout(function () { ro.disconnect(); }, 2500); }
    window.addEventListener('load', function () { setTimeout(reAim, 60); setTimeout(reAim, 400); setTimeout(stopAim, 2500); });
    if (d.fonts && d.fonts.ready) d.fonts.ready.then(reAim);
  }
  window.addEventListener('hashchange', function () { var s = hashTarget(location.hash); if (s) goTo(s, true); });

  /* ------------------------------------------------------------------
     Ferris-wheel menu. Cabins with data-sec belong to sections on this
     page and drive the rotation as you scroll; the others link to other
     pages. The wheel can also be turned by hand (arrows, mouse wheel,
     drag, arrow keys) so every cabin is reachable from every page.
     ------------------------------------------------------------------ */
  (function () {
    var fw = d.getElementById('fw'), svg = d.getElementById('fwSvg'), probe = d.getElementById('fwProbe');
    if (!fw || !svg) return;
    var cabs = [].slice.call(fw.querySelectorAll('.fw-cab'));
    if (!cabs.length) return;
    var N = cabs.length;
    var local = []; // [{k, el, cab}] cabins whose section exists on this page
    cabs.forEach(function (c, k) {
      var id = c.getAttribute('data-sec'), el = id && d.getElementById(id);
      if (el) local.push({ k: k, el: el, cab: c });
    });
    var STEP = 30, R = 120, cur = 0, target = 0, auto = 0, manual = 0, rafId = 0, rotG = null, shown = -1, lastT = 0;
    var ARC = 92;                                   // cabins fade out beyond this many degrees from the centre
    var NS = 'http://www.w3.org/2000/svg';
    function el(n, a) { var e = d.createElementNS(NS, n); for (var k in a) e.setAttribute(k, a[k]); return e; }

    // rotate-by-hand controls
    var up = d.createElement('button'), down = d.createElement('button');
    up.type = down.type = 'button';
    up.className = 'fw-arrow fw-arrow-up'; down.className = 'fw-arrow fw-arrow-down';
    up.setAttribute('aria-label', 'Show previous sections'); down.setAttribute('aria-label', 'Show more sections');
    up.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 15l6-6 6 6"/></svg>';
    down.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
    fw.appendChild(up); fw.appendChild(down);

    function clamp(v) { return Math.max(0, Math.min(N - 1, v)); }
    function setTarget() { target = clamp(auto + manual); manual = target - auto; }
    function turn(n) { manual += n; setTarget(); kick(); }

    function build() {
      R = probe.offsetWidth || 120;
      var pod = (cabs[0].querySelector('.fw-pod') || {}).offsetWidth || 32;
      STEP = Math.max(26, (pod + 14) / R * 180 / Math.PI);
      var P = R + 18; svg.innerHTML = '';
      svg.setAttribute('width', P * 2); svg.setAttribute('height', P * 2); svg.setAttribute('viewBox', (-P) + ' ' + (-P) + ' ' + P * 2 + ' ' + P * 2);
      svg.style.left = (-P) + 'px'; svg.style.top = (-P) + 'px';
      var defs = el('defs', {}), g = el('linearGradient', { id: 'fwGold', x1: '0', y1: '0', x2: '1', y2: '1' });
      g.appendChild(el('stop', { offset: '0', 'stop-color': '#fbe7a1' })); g.appendChild(el('stop', { offset: '1', 'stop-color': '#c99b43' }));
      defs.appendChild(g); svg.appendChild(defs);
      rotG = el('g', {}); svg.appendChild(rotG);
      var sw = Math.max(2, R * .028);
      rotG.appendChild(el('circle', { r: R, fill: 'rgba(255,236,244,.10)', stroke: 'url(#fwGold)', 'stroke-width': sw }));
      rotG.appendChild(el('circle', { r: R * .62, fill: 'none', stroke: 'rgba(240,205,120,.75)', 'stroke-width': sw * .55 }));
      for (var i = 0; i < 12; i++) {
        var a = i * Math.PI / 6;
        rotG.appendChild(el('line', { x1: 0, y1: 0, x2: Math.cos(a) * R, y2: Math.sin(a) * R, stroke: 'rgba(240,210,130,.8)', 'stroke-width': sw * .5 }));
      }
      for (var j = 0; j < 24; j++) {
        var b = j * Math.PI / 12, c = el('circle', { cx: Math.cos(b) * R, cy: Math.sin(b) * R, r: Math.max(1.8, R * .02), 'class': 'fw-bulb' });
        c.style.animationDelay = (-(j % 6) * .4) + 's'; rotG.appendChild(c);
      }
      rotG.appendChild(el('circle', { r: R * .09, fill: 'url(#fwGold)', stroke: '#8a2a2f', 'stroke-width': sw * .6 }));
      // arrows sit just outside the rim, above and below the visible arc, ~26px in from the screen edge
      var cx = fw.getBoundingClientRect().left || window.innerWidth;
      var ax = Math.min(-16, (window.innerWidth - 26) - cx), rr = R + 20, ay = Math.sqrt(Math.max(0, rr * rr - ax * ax));
      var pod = fw.querySelector('.fw-pod'), hang = pod ? Math.max(0, pod.getBoundingClientRect().bottom - (pod.closest('.fw-cab').getBoundingClientRect().top)) : 0;
      up.style.transform = 'translate(' + ax.toFixed(1) + 'px,' + (-ay).toFixed(1) + 'px)';
      // cabins hang below their pivot, so the lower arrow needs extra room
      down.style.transform = 'translate(' + ax.toFixed(1) + 'px,' + (ay + hang).toFixed(1) + 'px)';
      render();
    }
    function render() {
      rotG.setAttribute('transform', 'rotate(' + (-cur * STEP).toFixed(2) + ')');
      var on = clamp(Math.round(auto));                 // the section actually on screen, not merely the centred cabin
      cabs.forEach(function (c, k) {
        var dd = (k - cur) * STEP, a = (180 + dd) * Math.PI / 180, ad = Math.abs(dd);
        c.style.transform = 'translate(' + (Math.cos(a) * R).toFixed(1) + 'px,' + (Math.sin(a) * R).toFixed(1) + 'px)';
        var o = Math.max(0, Math.min(1, (ARC - ad) / 22));
        c.style.opacity = o.toFixed(2); c.style.visibility = o <= 0 ? 'hidden' : 'visible'; c.style.pointerEvents = o < .4 ? 'none' : 'auto';
        var isOn = k === on && c.hasAttribute('data-sec');
        c.classList.toggle('on', isOn);
        if (isOn) c.setAttribute('aria-current', 'true'); else c.removeAttribute('aria-current');
      });
      up.disabled = target <= .01; down.disabled = target >= N - 1.01;
      if (on !== shown) {
        var first = shown < 0; shown = on;
        if (!first && cabs[on].hasAttribute('data-sec')) { var c2 = cabs[on]; c2.classList.add('flash'); clearTimeout(c2._t); c2._t = setTimeout(function () { c2.classList.remove('flash'); }, 1500); }
      }
    }
    function calc() {
      if (!local.length) { auto = 0; return; }
      var vh = window.innerHeight, mid = vh * .5, i = 0;
      var tops = local.map(function (s) { return s.el.getBoundingClientRect().top; });
      for (var k = 0; k < tops.length; k++) if (tops[k] <= mid) i = k;
      var f = local[i].k;
      if (i < local.length - 1) {
        var Z = vh * .5, frac = Math.max(0, Math.min(1, (mid + Z - tops[i + 1]) / Z));
        f = local[i].k + (local[i + 1].k - local[i].k) * frac;
      }
      auto = f;
    }
    function tick(now) {
      rafId = 0; var dd = target - cur, dt = lastT ? Math.min((now - lastT) / 1000, .1) : .016; lastT = now;
      if (reduce || Math.abs(dd) < .002) { cur = target; lastT = 0; render(); return; }
      cur += dd * (1 - Math.exp(-dt * 9)); render(); rafId = requestAnimationFrame(tick);
    }
    function kick() { if (!rafId) rafId = requestAnimationFrame(tick); }
    var lastY = window.pageYOffset, fwTicking = false;
    function updateFw() {
      fwTicking = false;
      var y = window.pageYOffset;
      if (Math.abs(y - lastY) > 2) { manual = 0; lastY = y; }  // real page scrolling hands control back to the page
      calc(); setTarget(); kick();
    }
    function onScrollFw() {
      if (!fwTicking) { fwTicking = true; raf(updateFw); }
    }

    // (clicking a cabin for a section on this page is handled by the same-page anchor handler above)
    var dragging = false;
    // arrows
    up.addEventListener('click', function () { turn(-1); });
    down.addEventListener('click', function () { turn(1); });
    // mouse wheel over the cabins / arrows turns the wheel instead of the page
    var wheelAcc = 0, wheelT = 0;
    fw.addEventListener('wheel', function (e) {
      e.preventDefault();
      var now = Date.now(); if (now - wheelT > 400) wheelAcc = 0; wheelT = now;
      wheelAcc += e.deltaMode === 1 ? e.deltaY * 16 : e.deltaY;
      if (Math.abs(wheelAcc) >= 40) { turn(wheelAcc > 0 ? 1 : -1); wheelAcc = 0; }
    }, { passive: false });
    // drag (touch or mouse) along the cabins
    var pStart = null, pLast = 0, pAcc = 0;
    fw.addEventListener('pointerdown', function (e) {
      if (!e.target.closest('.fw-cab')) return;
      pStart = e.clientY; pLast = e.clientY; pAcc = 0; dragging = false;
    });
    fw.addEventListener('pointermove', function (e) {
      if (pStart === null) return;
      var dy = e.clientY - pLast; pLast = e.clientY; pAcc += dy;
      if (!dragging && Math.abs(e.clientY - pStart) > 8) dragging = true;
      if (!dragging) return;
      var per = R * STEP * Math.PI / 180;               // px of arc between two cabins
      while (pAcc <= -per) { turn(1); pAcc += per; }
      while (pAcc >= per)  { turn(-1); pAcc -= per; }
      e.preventDefault();
    });
    function pEnd() { pStart = null; setTimeout(function () { dragging = false; }, 0); }
    fw.addEventListener('pointerup', pEnd); fw.addEventListener('pointercancel', pEnd);
    fw.addEventListener('click', function (e) { if (dragging) { e.preventDefault(); e.stopPropagation(); } }, true);
    // arrow keys while a cabin or arrow is focused
    fw.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowDown' || e.key === 'ArrowRight') { e.preventDefault(); turn(1); }
      else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') { e.preventDefault(); turn(-1); }
    });

    window.addEventListener('scroll', onScrollFw, { passive: true });
    window.addEventListener('resize', function () { build(); onScrollFw(); });
    build(); calc(); setTarget(); cur = target; render();
    window.addEventListener('load', function () { build(); calc(); setTarget(); cur = target; render(); });
  })();
})();
