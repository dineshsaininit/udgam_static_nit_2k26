/* Events page: filter the open-floor passes by category, search them and sort them. */
(function () {
  var grid = document.getElementById('exGrid'); if (!grid) return;
  var cards = [].slice.call(grid.querySelectorAll('.ep')),
      chips = [].slice.call(document.querySelectorAll('.ex-chip')),
      q = document.getElementById('exQ'), sort = document.getElementById('exSort'),
      count = document.getElementById('exCount'), empty = document.getElementById('exEmpty'),
      cat = 'all';
  var total = cards.length;
  function norm(s) { return (s || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, ''); }
  cards.forEach(function (c) {
    c._q = norm(c.getAttribute('data-q'));
    c._n = +c.getAttribute('data-n'); c._fee = +c.getAttribute('data-fee');
    c._name = c.querySelector('.ep-name').textContent.trim();
  });

  function render() {
    var term = norm(q.value.trim()), shown = 0;
    cards.forEach(function (c) {
      var ok = (cat === 'all' || c.getAttribute('data-cat') === cat) && (!term || c._q.indexOf(term) > -1);
      c.hidden = !ok; if (ok) { shown++; c.classList.add('in'); }
    });
    var by = sort.value, list = cards.slice();
    list.sort(function (a, b) {
      if (by === 'fa') return a._fee - b._fee || a._n - b._n;
      if (by === 'fd') return b._fee - a._fee || a._n - b._n;
      if (by === 'az') return a._name.localeCompare(b._name);
      return a._n - b._n;
    });
    list.forEach(function (c) { grid.appendChild(c); });
    empty.hidden = shown > 0;
    var label = cat === 'all' ? '' : ' in ' + chips.filter(function (c) { return c.classList.contains('on'); })[0].firstChild.nextSibling.textContent.trim();
    count.textContent = shown === total ? 'Showing all ' + total + ' events' : 'Showing ' + shown + ' of ' + total + ' events' + label;
  }

  chips.forEach(function (c) {
    c.addEventListener('click', function () {
      cat = c.getAttribute('data-f');
      chips.forEach(function (x) { var on = x === c; x.classList.toggle('on', on); x.setAttribute('aria-pressed', on ? 'true' : 'false'); });
      render();
    });
  });
  q.addEventListener('input', render);
  sort.addEventListener('change', render);
  document.getElementById('exClear').addEventListener('click', function () { q.value = ''; chips[0].click(); q.focus(); });
})();
