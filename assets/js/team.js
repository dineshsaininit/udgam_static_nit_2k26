/* Team page: committee cards open their roster in a dialog (with prev/next), and one search box covers the whole team. */
(function () {
  var grid = document.getElementById('cm-grid'), dlg = document.getElementById('cmDlg');
  if (!grid || !dlg || typeof dlg.showModal !== 'function') return; // no <dialog>: rosters stay inline below the cards

  var sec = grid.closest('.cmx'), home = sec.querySelector('.cm-panels'),
      panels = [].slice.call(home.querySelectorAll('.cm-panel')),
      slot = dlg.querySelector('.cm-slot'), prev = dlg.querySelector('.cm-prev'), next = dlg.querySelector('.cm-next'),
      cur = -1, opener = null;
  sec.classList.add('cm-js');

  function name(i) { return panels[i].querySelector('.cm-title').textContent; }
  function wire(scope) { if (window.UDGAM && UDGAM.wirePhoto) [].forEach.call(scope.querySelectorAll('[data-photo] img'), UDGAM.wirePhoto); }
  function reveal(scope) {
    [].forEach.call(scope.querySelectorAll('.nr'), function (n, k) { n.style.setProperty('--d', (Math.min(k, 8) * .05) + 's'); n.classList.remove('in'); });
    requestAnimationFrame(function () { requestAnimationFrame(function () { [].forEach.call(scope.querySelectorAll('.nr'), function (n) { n.classList.add('in'); }); }); });
  }

  function show(i) {
    var N = panels.length; i = (i + N) % N;
    if (cur > -1) home.appendChild(panels[cur]);
    cur = i; slot.appendChild(panels[i]); slot.scrollTop = 0; dlg.querySelector('.cm-sheet').scrollTop = 0;
    prev.querySelector('b').textContent = name((i - 1 + N) % N);
    next.querySelector('b').textContent = name((i + 1) % N);
    dlg.setAttribute('aria-label', name(i) + ' committee');
    wire(panels[i]); reveal(panels[i]);
    history.replaceState(null, '', '#' + panels[i].id);
  }
  function open(id, from) {
    var i = panels.findIndex(function (p) { return p.id === 'c-' + id; });
    if (i < 0) return;
    opener = from || null;
    show(i);
    if (!dlg.open) { dlg.showModal(); document.documentElement.classList.add('cm-lock'); }
    dlg.querySelector('.cm-x').focus({ preventScroll: true });
  }
  function close() { if (dlg.open) dlg.close(); }

  dlg.addEventListener('close', function () {
    if (cur > -1) home.appendChild(panels[cur]);
    cur = -1; document.documentElement.classList.remove('cm-lock');
    history.replaceState(null, '', location.pathname + location.search + '#team');
    if (opener) opener.focus({ preventScroll: true });
  });
  dlg.addEventListener('click', function (e) { if (e.target === dlg) close(); }); // backdrop
  dlg.querySelector('.cm-x').addEventListener('click', close);
  prev.addEventListener('click', function () { show(cur - 1); });
  next.addEventListener('click', function () { show(cur + 1); });
  dlg.addEventListener('keydown', function (e) {
    if (e.target.closest('input,textarea')) return;
    if (e.key === 'ArrowLeft') { e.preventDefault(); show(cur - 1); }
    else if (e.key === 'ArrowRight') { e.preventDefault(); show(cur + 1); }
  });

  grid.addEventListener('click', function (e) {
    var a = e.target.closest('.cm-card');
    if (!a || e.metaKey || e.ctrlKey || e.shiftKey) return;
    e.preventDefault(); open(a.getAttribute('data-c'), a);
  });

  /* ---- search across the core tiers and every committee ---- */
  var qi = sec.querySelector('.cm-q'), res = sec.querySelector('.cm-res'), rc = sec.querySelector('.cm-rc'), rg = sec.querySelector('.cm-rg'),
      em = sec.querySelector('.cm-empty'), emp = em.querySelector('p');
  var people = [].slice.call(document.querySelectorAll('#core .tc-card, .cm-panels .tc-card'));
  function norm(s) { return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, ''); }
  people.forEach(function (c) { c._q = norm(c.getAttribute('data-q') || ''); });

  function render() {
    var q = norm(qi.value.trim());
    rg.textContent = '';
    if (!q) { res.hidden = em.hidden = true; grid.hidden = false; return; }
    grid.hidden = true;
    var hits = people.filter(function (c) { return c._q.indexOf(q) > -1; });
    hits.forEach(function (c) {
      var k = c.cloneNode(true), p = c.closest('.cm-panel'), g = el(p ? 'button' : 'span', 'tc-grp', c.getAttribute('data-g'));
      k.classList.add('in');
      if (p) { g.type = 'button'; g.setAttribute('data-c', p.id.slice(2)); g.setAttribute('aria-label', 'Open ' + g.textContent + ' committee'); }
      k.appendChild(g); rg.appendChild(k);
    });
    wire(rg);
    res.hidden = !hits.length; em.hidden = !!hits.length;
    rc.textContent = hits.length + (hits.length === 1 ? ' match' : ' matches');
    emp.textContent = 'No one matches “' + qi.value.trim() + '”. Check the spelling or try just a first name.';
  }
  function el(t, c, x) { var n = document.createElement(t); n.className = c; n.textContent = x; return n; }
  rg.addEventListener('click', function (e) { var b = e.target.closest('button.tc-grp'); if (b) open(b.getAttribute('data-c'), b); });
  qi.addEventListener('input', render);
  sec.querySelector('.cm-tools').addEventListener('submit', function (e) { e.preventDefault(); });
  em.querySelector('button').addEventListener('click', function () { qi.value = ''; render(); qi.focus(); });

  // Deep links: team.php#c-technical or team.php?c=technical open that committee.
  var want = new URLSearchParams(location.search).get('c') || (location.hash.indexOf('#c-') === 0 ? location.hash.slice(3) : '');
  if (want) open(want);
})();
