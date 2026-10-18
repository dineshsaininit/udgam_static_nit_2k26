/* Team page: committee directory — one section per committee, name search, committee filter. */
(function () {
  var dataEl = document.getElementById('cd-data'), root = document.getElementById('cd');
  if (!dataEl || !root) return;
  var D = JSON.parse(dataEl.textContent);
  var TH = 'https://drive.google.com/thumbnail?id=', ALT = 'https://lh3.googleusercontent.com/d/';

  function el(t, c, x) { var e = document.createElement(t); if (c) e.className = c; if (x != null) e.textContent = x; return e; }
  function norm(s) { return s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ''); }
  function ini(n) { var w = n.replace(/[^A-Za-z\u00C0-\u024F ]/g, '').split(/\s+/).filter(Boolean); return ((w[0] || '?').charAt(0) + (w.length > 1 ? w[w.length - 1].charAt(0) : '')).toUpperCase(); }

  function card(m, c, showC) {
    var li = el('li', 'cd-card cd-t' + m.t), ph = el('div', 'cd-ph'), b = el('div', 'cd-body');
    var src = m.img || (m.p ? TH + m.p + '&sz=w600' : ''), alt = m.img ? '' : (m.p ? ALT + m.p + '=w600' : '');
    ph.dataset.photo = src ? 'loading' : 'none';
    ph.appendChild(el('span', 'cd-av', ini(m.n)));
    if (src) {
      var im = new Image();
      im.alt = 'Portrait of ' + m.n; im.loading = 'lazy'; im.decoding = 'async'; im.referrerPolicy = 'no-referrer';
      if (alt) im.setAttribute('data-fallback', alt);
      im.src = src; ph.appendChild(im);
      if (window.UDGAM && UDGAM.wirePhoto) UDGAM.wirePhoto(im);
    }
    b.appendChild(el('h4', 'cd-name', m.n)); b.appendChild(el('span', 'cd-role', m.r));
    if (showC) b.appendChild(el('span', 'cd-com', c.name));
    li.appendChild(ph); li.appendChild(b); return li;
  }
  function grid(list, c, cls, showC) { var u = el('ul', 'cd-grid ' + (cls || '')); list.forEach(function (m) { u.appendChild(card(m, c, showC)); }); return u; }

  var secs = [];
  function sec(c) {
    var s = el('section', 'cd-sec'), h = el('div', 'cd-sh'),
        L = c.m.filter(function (m) { return m.t < 2; }), A = c.m.filter(function (m) { return m.t == 2; }), M = c.m.filter(function (m) { return m.t == 3; });
    s.id = 'cd-' + c.id; s.setAttribute('aria-labelledby', s.id + '-h');
    var t = el('h3', null, c.name); t.id = s.id + '-h'; h.appendChild(t);
    h.appendChild(el('span', 'cd-n', c.m.length + (c.m.length == 1 ? ' person' : ' people'))); h.appendChild(el('i'));
    var up = el('a', 'cd-top', 'Back to committees'); up.href = '#cd-nav'; h.appendChild(up); s.appendChild(h);
    if (L.length) s.appendChild(grid(L, c, 'cd-g1'));
    [[A, 'Associate leads'], [M, 'Members']].forEach(function (g) {
      if (g[0].length) { if (L.length || (A.length && M.length)) s.appendChild(el('h4', 'cd-sub', g[1])); s.appendChild(grid(g[0], c)); }
    });
    return s;
  }

  var nav = root.querySelector('.cd-chips'), qi = root.querySelector('.cd-q'), sel = root.querySelector('.cd-f'),
      body = root.querySelector('.cd-secs'), res = root.querySelector('.cd-res'), rc = root.querySelector('.cd-rc'),
      rg = root.querySelector('.cd-rg'), em = root.querySelector('.cd-empty'), emp = em.querySelector('p');

  D.forEach(function (c) {
    var s = sec(c); secs.push(s); body.appendChild(s);
    var a = el('a', null, c.name); a.href = '#' + s.id; nav.appendChild(a);
    var o = el('option', null, c.name); o.value = c.id; sel.appendChild(o);
  });
  nav.addEventListener('click', function (e) { if (e.target.tagName == 'A' && (qi.value || sel.value != 'all')) { qi.value = ''; sel.value = 'all'; render(); } });

  function render() {
    var q = norm(qi.value.trim()), f = sel.value;
    if (!q) { res.hidden = em.hidden = true; body.hidden = false; secs.forEach(function (s, i) { s.hidden = f != 'all' && D[i].id != f; }); return; }
    body.hidden = true; rg.textContent = ''; var n = 0;
    D.forEach(function (c) {
      if (f != 'all' && c.id != f) return;
      var hit = c.m.filter(function (m) { return [m.n].concat(m.a || []).some(function (x) { return norm(x).indexOf(q) > -1; }); });
      hit.forEach(function (m) { rg.appendChild(card(m, c, true)); n++; });
    });
    res.hidden = !n; em.hidden = !!n;
    rc.textContent = n + (n == 1 ? ' match' : ' matches');
    emp.textContent = 'No one matches \u201C' + qi.value.trim() + '\u201D. Check the spelling or try just a first name.';
  }
  qi.addEventListener('input', render); sel.addEventListener('change', render);
  em.querySelector('button').addEventListener('click', function () { qi.value = ''; render(); qi.focus(); });
  root.querySelector('.cd-tools').addEventListener('submit', function (e) { e.preventDefault(); });

  // Deep links like team.php?c=technical pre-select a committee.
  var want = new URLSearchParams(location.search).get('c');
  if (want && D.some(function (c) { return c.id === want; })) sel.value = want;

  window.UDGAM_DIR = { data: D, report: function () { var r = {}; [].forEach.call(document.querySelectorAll('#cd .cd-sec .cd-ph'), function (p) { r[p.dataset.photo] = (r[p.dataset.photo] || 0) + 1; }); return r; } };
  render();
})();
