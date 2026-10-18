<?php
/**
 * Shared footer, falling petals, Ferris-wheel menu and scripts.
 * Optional: $page['scripts'] = ['assets/js/events.js', ...]
 */
$cur = current_page();
?>
<footer class="site-foot" id="siteFoot">
  <div class="sf-in">
    <div class="sf-brand">
      <img src="assets/img/logo.webp" alt="<?= e(SITE_NAME) ?>" width="700" height="394" loading="lazy" decoding="async">
      <p><?= e(SITE_DESC) ?> Organised by the students of the National Institute of Technology Sikkim.</p>
    </div>
    <div>
      <h3 class="sf-h">Explore</h3>
      <nav class="sf-nav" aria-label="Footer">
        <?php foreach ($NAV as $n): ?><a href="<?= e($n['href']) ?>"><?= e($n['label']) ?></a><?php endforeach; ?>
      </nav>
    </div>
    <div class="sf-contact">
      <h3 class="sf-h">Contact</h3>
      <ul>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M4 8l8 5.5L20 8"/></svg><a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r=".9" fill="#ffd9e6"/></svg><a href="<?= e($SITE['instagram']['url']) ?>" target="_blank" rel="noopener"><?= e($SITE['instagram']['handle']) ?></a></li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="M10 9v6l5-3z" fill="#ffd9e6" stroke="none"/></svg><a href="<?= e($SITE['youtube']['url']) ?>" target="_blank" rel="noopener"><?= e($SITE['youtube']['handle']) ?></a></li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21S5 15 5 9.5a7 7 0 0114 0C19 15 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg><a href="<?= e($SITE['maps']) ?>" target="_blank" rel="noopener"><?= e($SITE['address']) ?></a></li>
      </ul>
    </div>
  </div>
  <p class="sf-copy">&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?> &middot; <a href="<?= e($SITE['institute']) ?>" target="_blank" rel="noopener">National Institute of Technology Sikkim</a>. All rights reserved.</p>
</footer>

<canvas id="petalFall" aria-hidden="true"></canvas>

<nav class="fw" id="fw" aria-label="Site sections — Ferris wheel menu">
  <svg class="fw-svg" id="fwSvg" aria-hidden="true" focusable="false"></svg>
  <span class="fw-probe" id="fwProbe" aria-hidden="true"></span>
  <?php foreach ($WHEEL as $k => $w):
    $onPage = $w['page'] === $cur;
    if ($onPage)                 $href = '#' . $w['sec'];               // scrolls within this page
    elseif ($w['sec'] === 'home') $href = $w['page'];                    // plain link to the homepage
    else                         $href = $w['page'] . '#' . $w['sec'];  // deep link into another page
  ?><a class="fw-cab" href="<?= e($href) ?>" data-k="<?= $k ?>"<?= $onPage ? ' data-sec="' . e($w['sec']) . '"' : '' ?> aria-label="<?= e($w['label']) ?>" title="<?= e($w['label']) ?>"><i class="fw-hang"></i><span class="fw-pod"><?= $WHEEL_ICONS[$w['id']] ?></span><b class="fw-lab"><?= e($w['label']) ?></b></a><?php endforeach; ?>
</nav>

<script src="<?= asset('assets/js/main.js') ?>"></script>
<?php foreach (($page['scripts'] ?? []) as $s): ?>
<script src="<?= asset($s) ?>"></script>
<?php endforeach; ?>
</body>
</html>
