<?php
/**
 * "A Journey Through Time": the road of past editions with the little car, and the edition panel below it.
 * Used by the homepage and the gallery; needs assets/js/journey.js on the page.
 * Optional before including: $journeyPhotoYears = [2025, 2024, ...] adds a "See the photos" button
 * (data-gf="<year>") to those editions; the gallery script turns it into a filter.
 */
$pastYears  = load_json('events')['past'] ?? [];
$journeyPhotoYears = $journeyPhotoYears ?? [];

/* every past edition plus this year, newest past edition open by default */
$editions   = array_map(fn($y) => $y + ['tagline' => '', 'blurb' => '', 'logo' => '', 'photos' => []], $pastYears);
$editions[] = ['year' => 2026, 'url' => 'events.php', 'tagline' => SITE_TAGLINE, 'logo' => '',
               'blurb' => 'You are here. This year UDGAM returns to NIT Sikkim, and the next chapter of the journey is yours to write.',
               'photos' => ['assets/img/hero-bg.webp']];
$openYear   = $pastYears ? (int)end($pastYears)['year'] : 2026;
?>
  <!-- JOURNEY THROUGH TIME -->
  <div class="jy reveal" id="journey">
    <div class="jy-scroller" id="jyScroller">
      <div class="jy-scene" id="jyScene">
        <img class="jy-bg" src="assets/img/journey-bg.webp" alt="" width="2121" height="741" draggable="false" loading="lazy" decoding="async">
        <header class="jy-title">
          <div class="jy-small">THE UDGAM JOURNEY</div>
          <h2>A Journey Through Time</h2>
          <p class="jy-quote">&ldquo;Every year leaves a story,<br>and every journey leads us here.&rdquo;</p>
          <div class="jy-line"></div>
          <p class="jy-sub">Point at a year and the little car drives you there</p>
          <p class="jy-swipe" aria-hidden="true">&lsaquo; swipe to travel &rsaquo;</p>
        </header>

        <?php foreach ($pastYears as $y): ?>
        <a class="jy-year" href="<?= e($y['url']) ?>" data-year="<?= (int)$y['year'] ?>" target="_blank" rel="noopener" style="--x:<?= e($y['x']) ?>" aria-label="UDGAM <?= (int)$y['year'] ?> website (opens in a new tab)">
          <img class="jy-tree" src="assets/img/journey-tree.webp" alt="Cherry blossom tree for <?= (int)$y['year'] ?>" width="663" height="561" draggable="false" loading="lazy" decoding="async">
          <span class="jy-plaque"><img src="assets/img/journey-plaque.webp" alt="" width="564" height="204" draggable="false" loading="lazy" decoding="async"><b><?= (int)$y['year'] ?></b></span>
        </a>
        <?php endforeach; ?>
        <a class="jy-year jy-current" href="#journey" data-year="2026" style="--x:84.42%" title="You are here — UDGAM 2026" aria-current="true">
          <img class="jy-sign" src="assets/img/journey-sign.webp" alt="You are here" width="687" height="207" draggable="false" loading="lazy" decoding="async">
          <img class="jy-tree" src="assets/img/journey-tree.webp" alt="Cherry blossom tree for 2026" width="663" height="561" draggable="false" loading="lazy" decoding="async">
          <span class="jy-plaque"><img src="assets/img/journey-plaque-2026.webp" alt="" width="564" height="204" draggable="false" loading="lazy" decoding="async"><b>2026</b></span>
        </a>
        <img class="jy-car" id="jyCar" src="assets/img/journey-car.webp" alt="Little pink car" width="399" height="243" draggable="false" decoding="async">
      </div>
    </div>

    <!-- Edition panel: the year the car is parked at. journey.js switches it; without JS the latest edition shows. -->
    <div class="jy-panel" id="jyPanel">
      <nav class="jy-chips" aria-label="Choose an edition">
        <?php foreach ($editions as $y): ?>
        <button type="button" class="jy-chip<?= $y['year'] === $openYear ? ' on' : '' ?>" data-year="<?= (int)$y['year'] ?>" aria-pressed="<?= $y['year'] === $openYear ? 'true' : 'false' ?>"><?= (int)$y['year'] ?></button>
        <?php endforeach; ?>
      </nav>
      <?php foreach ($editions as $y): $now = $y['year'] === 2026; ?>
      <article class="jy-ed<?= $y['photos'] ? '' : ' jy-ed-art' ?>" data-year="<?= (int)$y['year'] ?>"<?= $y['year'] === $openYear ? '' : ' hidden' ?> aria-label="UDGAM <?= (int)$y['year'] ?>">
        <div class="jy-media">
          <?php foreach ($y['photos'] as $i => $p): ?>
          <img class="jy-ph<?= $i ? '' : ' on' ?>" src="<?= e($p) ?>" alt="<?= $i ? '' : 'Moments from UDGAM ' . (int)$y['year'] ?>" width="1100" height="688" loading="lazy" decoding="async">
          <?php endforeach; ?>
          <?php if (!$y['photos']): ?><img class="jy-art" src="<?= e($y['logo']) ?>" alt="UDGAM <?= (int)$y['year'] ?> emblem" loading="lazy" decoding="async"><?php endif; ?>
          <?php if (count($y['photos']) > 1): ?><span class="jy-dots" aria-hidden="true"><?= str_repeat('<i></i>', count($y['photos'])) ?></span><?php endif; ?>
        </div>
        <div class="jy-info">
          <p class="jy-kick"><?php if ($y['photos'] && !empty($y['logo'])): ?><img src="<?= e($y['logo']) ?>" alt="" width="44" height="44" loading="lazy" decoding="async"><?php endif; ?><?= $now ? 'This year' : 'Past edition' ?></p>
          <h3 class="jy-name">UDGAM <span><?= (int)$y['year'] ?></span></h3>
          <p class="jy-tag"><?= e($y['tagline']) ?></p>
          <p class="jy-blurb"><?= e($y['blurb']) ?></p>
          <div class="jy-acts">
            <?php if ($now): ?>
            <a class="jy-go" href="events.php">Explore UDGAM 2K26 <span aria-hidden="true">&rsaquo;</span></a>
            <?php else: ?>
            <a class="jy-go" href="<?= e($y['url']) ?>" target="_blank" rel="noopener">Visit the UDGAM <?= (int)$y['year'] ?> website <span aria-hidden="true">&#8599;</span><span class="sr-only"> (opens in a new tab)</span></a>
            <?php endif; ?>
            <?php if (in_array((int)$y['year'], $journeyPhotoYears, true)): ?>
            <a class="jy-go2" href="#gallery" data-gf="<?= (int)$y['year'] ?>">See the <?= (int)$y['year'] ?> photos <span aria-hidden="true">&darr;</span></a>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
