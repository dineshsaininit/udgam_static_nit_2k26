<?php
/**
 * Shared footer, falling petals, Ferris-wheel menu and scripts.
 * Optional: $page['scripts'] = ['assets/js/events.js', ...]
 */
$cur      = current_page();
$channels = contact_channels();
$ftIntro  = 'Have a question, collaboration idea, sponsorship enquiry or just want to be a part of UDGAM 2K26? We&rsquo;d love to hear from you. Let&rsquo;s keep the conversation going and create more stories together.';
?>
<footer class="site-foot" id="siteFoot">
  <!-- Wide screens: the illustrated "Get in Touch" poster; the four cards in the artwork are clickable -->
  <div class="sf-poster">
    <div class="sf-poster-in">
      <img class="sf-art" src="assets/img/contact-poster.webp" alt="Get in touch with UDGAM 2K26 — email, Instagram, YouTube or visit NIT Sikkim, Ravangla" width="1672" height="941" loading="lazy" decoding="async">
      <?php foreach ($channels as $c): ?>
      <a class="sf-hot sf-hot-<?= e($c['id']) ?>" href="<?= e($c['href']) ?>"<?= $c['ext'] ? ' target="_blank" rel="noopener"' : '' ?> aria-label="<?= e($c['title']) ?>: <?= e($c['sub']) ?>"></a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Narrow / tall screens: the same content laid out in HTML -->
  <div class="sf-html">
    <div class="sf-html-in">
      <p class="sf-script">Let&rsquo;s Stay Connected</p>
      <div class="pg-label sf-label"><i></i><?= flower_svg('#fbeee9', 'pg-fl') ?><b>CONTACT</b><i></i></div>
      <h2 class="sf-title"><span>Get in</span> <em>Touch</em></h2>
      <p class="sf-lead"><?= $ftIntro ?></p>
      <ul class="sf-cards">
        <?php foreach ($channels as $c): ?>
        <li><a class="sf-card" href="<?= e($c['href']) ?>"<?= $c['ext'] ? ' target="_blank" rel="noopener"' : '' ?>>
          <?= flower_svg('#fbeee9', 'sf-card-fl') ?>
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $c['icon'] ?></svg>
          <b><?= e($c['title']) ?></b><small><?= e($c['sub']) ?></small>
        </a></li>
        <?php endforeach; ?>
      </ul>
      <ul class="sf-vals">
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="3"/><circle cx="5" cy="10" r="2.2"/><circle cx="19" cy="10" r="2.2"/><path d="M7 20c0-3 2.2-5 5-5s5 2 5 5M1.5 17.5c0-2.2 1.5-3.6 3.5-3.6M22.5 17.5c0-2.2-1.5-3.6-3.5-3.6"/></svg>People build<br>communities</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18h6M10 21h4M12 3a6 6 0 00-3.5 10.9c.6.5 1 1.2 1 2.1h5c0-.9.4-1.6 1-2.1A6 6 0 0012 3z"/></svg>Ideas spark<br>possibilities</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 19l6-10 3.5 5.5L15 9l7 10z"/><path d="M8 9l1.5-2.5L11 9"/></svg>Friendships go<br>beyond borders</li>
      </ul>
      <p class="sf-script sf-script-end">Different People, Same Spirit</p>
    </div>
  </div>

  <div class="sf-bar">
    <div class="sf-bar-in">
      <p class="sf-copy">&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?> &middot; <a href="<?= e($SITE['institute']) ?>" target="_blank" rel="noopener">National Institute of Technology Sikkim</a>. All rights reserved.</p>
    </div>
  </div>
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
