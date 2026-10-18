/* Events page: illustrated stage — polaroid highlights, category plaques, lights, ripples, parallax. */
(() => {
  const root = document.getElementById('events');
  const dataEl = document.getElementById('ev-data');
  if (!root || !dataEl) return;
  const DATA = JSON.parse(dataEl.textContent);
  const $ = s => document.querySelector(s);
  // url() inside a custom property resolves against the stylesheet, so make image URLs absolute
  const abs = p => new URL(p, document.baseURI).href;
  DATA.highlights.forEach(p => { p.img = abs(p.img); });
  const mob = () => matchMedia('(max-width:900px),(max-aspect-ratio:11/10)').matches;

  const fl = '<svg viewBox="0 0 30 30"><g fill="#ffc2d4" stroke="#ff8fb3"><ellipse cx="15" cy="7" rx="5" ry="7"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(72 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(144 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(216 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(288 15 15)"/></g><circle cx="15" cy="15" r="3" fill="#ffd36a"/></svg>';

  /* polaroid highlights */
  const pols = $('#evPols'), st = $('#evStage');
  st.insertBefore(pols, $('#evDots'));
  DATA.highlights.forEach((p, i) => {
    const d = document.createElement('article');
    d.className = 'pol';
    d.style.cssText = `--x:${p.x};--y:${p.y};--r:${p.r}deg;--ph:url("${p.img}");--dl:${.2 + i * .12}s`;
    d.innerHTML = `<div class="ph"></div><div class="cp">${p.title}</div><div class="sub">${p.tag}</div><div class="fl" style="top:-14px;${i % 2 ? 'left' : 'right'}:-12px">${fl}</div>${i % 3 !== 1 ? '<div class="fl" style="bottom:30px;right:-14px;width:26px;height:26px">' + fl + '</div>' : ''}`;
    d.onpointermove = e => { const r = d.getBoundingClientRect(); d.style.setProperty('--ry', ((e.clientX - r.left) / r.width - .5) * 14 + 'deg'); d.style.setProperty('--rx', -((e.clientY - r.top) / r.height - .5) * 14 + 'deg'); };
    d.onpointerleave = () => { d.style.setProperty('--rx', '0deg'); d.style.setProperty('--ry', '0deg'); };
    d.onclick = () => { $('#evLi').style.backgroundImage = `url("${p.img}")`; $('#evLy').textContent = p.title; $('#evLc').textContent = p.tag; $('#evLb').classList.add('on'); };
    pols.appendChild(d);
  });

  /* dots under the swipeable polaroid row (phones) */
  const ds = $('#evDots');
  DATA.highlights.forEach(() => ds.appendChild(document.createElement('i')));
  const dl = [...ds.children];
  const ud = () => { const m = pols.scrollWidth - pols.clientWidth || 1, i = Math.round(pols.scrollLeft / m * (dl.length - 1)); dl.forEach((d, k) => d.classList.toggle('on', k === i)); };
  pols.addEventListener('scroll', ud, { passive: true }); ud();

  /* lightbox */
  document.body.appendChild($('#evLb'));
  $('#evLb').onclick = () => $('#evLb').classList.remove('on');
  addEventListener('keydown', e => e.key === 'Escape' && $('#evLb').classList.remove('on'));

  /* category plaques */
  const I = {
    m: '<path d="M15 30V9l16-3v21"/><circle cx="11" cy="30" r="4"/><circle cx="27" cy="27" r="4"/>',
    p: '<path d="M20 4C10 4 4 11 4 19s7 15 15 15c3 0 3-3 1-5-2-3 0-5 3-5h5c4 0 8-2 8-7C36 9 29 4 20 4z"/><circle cx="12" cy="16" r="2"/><circle cx="19" cy="10" r="2"/><circle cx="27" cy="12" r="2"/>',
    l: '<path d="M4 8c6 2 12 2 17 0v12c0 6-4 10-9 10S4 26 4 20zM19 16c5 2 11 2 16 0v8c0 6-4 10-8 10s-8-4-8-10z"/><path d="M9 15v2M16 15v2M25 23v2M31 23v2M9 23q3 2 6 0"/>',
    g: '<path d="M10 12h20c5 0 8 5 8 12 0 4-2 6-5 5l-5-6H12l-5 6c-3 1-5-1-5-5 0-7 3-12 8-12zM12 17v6M9 20h6"/><circle cx="27" cy="18" r="1"/><circle cx="31" cy="21" r="1"/>',
    c: '<rect x="3" y="11" width="34" height="23" rx="3"/><path d="M13 11l2-5h10l2 5"/><circle cx="20" cy="22" r="6"/>',
    w: '<circle cx="20" cy="12" r="5"/><circle cx="8" cy="16" r="4"/><circle cx="32" cy="16" r="4"/><path d="M10 32c0-7 5-10 10-10s10 3 10 10zM2 30c0-5 3-8 7-8M38 30c0-5-3-8-7-8"/>',
    t: '<path d="M14 28c-4-3-6-6-6-10a12 12 0 0124 0c0 4-2 7-6 10v4H14zM15 36h10M20 4V1M6 8 4 6M34 8l2-2"/>',
    s: '<circle cx="20" cy="20" r="16"/><path d="M20 13l7 5-3 8h-8l-3-8zM20 13V4M27 18l9-3M24 26l5 8M16 26l-5 8M13 18l-9-3"/>'
  };
  DATA.categories.forEach((c, i) => {
    const d = document.createElement('div');
    d.className = 'fc rv'; if (i == 0) d.id = 'evCats';
    d.style.cssText = `--x:${c.x};--w:${c.w};--y:${c.y};--hh:92;--dl:${.4 + i * .08}s`;
    d.innerHTML = `<svg viewBox="0 0 40 40">${I[c.icon] || ''}</svg>${c.line1}<br>${c.line2}`;
    $('#evCps').appendChild(d);
  });

  /* fairy lights + lake ripples */
  const L = $('#evLights');
  for (let i = 0; i < 64; i++) { const t = i / 64, x = 33.5 + t * 32, y = 88.1 + Math.sin(t * 17) * .5 - t * .3; const s = document.createElement('i'); s.className = 'lt'; s.style.cssText = `left:${x}%;top:${y}%;--d:${.8 + Math.random() * 2}s;animation-delay:-${Math.random() * 3}s`; L.appendChild(s); }
  for (let i = 0; i < 16; i++) { const s = document.createElement('i'); s.className = 'lt'; s.style.cssText = `left:${34 + Math.random() * 31}%;top:${88.6 + Math.random() * 2.2}%;--d:${1 + Math.random() * 2}s;background:#ff9ad0;box-shadow:0 0 8px 3px #ff5fa8`; L.appendChild(s); }
  const R = $('#evRv');
  for (let i = 0; i < 9; i++) { const s = document.createElement('i'); s.className = 'rip'; s.style.cssText = `position:absolute;left:${Math.random() * 40}%;top:${i * 11}%;width:${30 + Math.random() * 50}%;--t:${3 + Math.random() * 3}s`; R.appendChild(s); }

  /* reveal + cursor glow + parallax bands */
  const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }), { threshold: .1 });
  document.querySelectorAll('#events .rv,#events .pol').forEach(e => io.observe(e));
  st.addEventListener('pointermove', e => { const b = st.getBoundingClientRect(), g = $('#evCg'); g.style.left = e.clientX - b.left + 'px'; g.style.top = e.clientY - b.top + 'px'; });
  const bands = [...document.querySelectorAll('#events .band')];
  root.addEventListener('pointermove', e => { if (mob()) return; const bb = root.getBoundingClientRect(), x = (e.clientX - bb.left) / bb.width - .5, y = (e.clientY - bb.top) / bb.height - .5; bands.forEach(b => b.style.transform = `translate(${-x * b.dataset.p * 2}px,${-y * b.dataset.p * .6}px)`); });
})();
