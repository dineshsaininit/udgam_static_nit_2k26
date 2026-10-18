<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'gallery',
  'title'   => 'Gallery — ' . SITE_NAME,
  'desc'    => 'Memories and photo glimpses from UDGAM, the cultural festival of NIT Sikkim.',
  'scripts' => ['assets/js/gallery.js'],
];

$g        = load_json('gallery');
$memories = $g['memories'] ?? [];
$filters  = $g['filters'] ?? [['id' => 'all', 'label' => 'All']];
$photos   = $g['photos'] ?? [];

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Gallery', 'a frame for every feeling', 'A little preview of the colour, music and joy that fill UDGAM. Tap any picture to see it up close.', 'assets/img/event-3.jpg') ?>

  <!-- MEMORIES -->
  <section class="pg mem" id="memories" aria-label="Memories" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>
    <?= section_head('MEMORIES', 'Moments that<br>stay with us', 'stories we carry home',
        'Behind every stage light and every cheer are small moments that turn into lifelong memories &mdash; new friends, late-night rehearsals and the joy of belonging to something bigger than ourselves.') ?>
    <div class="mem-wrap nr">
      <div class="mem-string" aria-hidden="true"></div>
      <div class="mem-row" id="memRow">
        <?php foreach ($memories as $i => $m): ?>
        <figure class="mem-card nr" style="--r:<?= e($m['rotate'] ?? '0deg') ?>;--d:<?= sprintf('%.2f', $i * .08) ?>s">
          <i class="mem-clip"></i>
          <div class="mem-ph" style="background-image:<?= css_url($m['img']) ?>" role="img" aria-label="<?= e($m['caption']) ?>"></div>
          <figcaption><small><?= e($m['label']) ?></small><span><?= e($m['caption']) ?></span></figcaption>
        </figure>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="mem-cta nr">
      <p class="pg-script">Have a UDGAM memory of your own?</p>
      <a class="pg-btn" href="mailto:<?= e($SITE['email']) ?>?subject=My%20UDGAM%20memory">Share your memory</a>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="pg gal" id="gallery" aria-label="Photo gallery" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>
    <?= section_head('GALLERY', 'Glimpses of<br>the celebration', 'a frame for every feeling', 'Filter by theme, then tap any picture to open it. Use the arrow keys to move between photos.') ?>
    <div class="gl-filters nr" role="group" aria-label="Filter photos">
      <?php foreach ($filters as $i => $f): ?><button class="gl-chip<?= $i === 0 ? ' on' : '' ?>" data-f="<?= e($f['id']) ?>" type="button" aria-pressed="<?= $i === 0 ? 'true' : 'false' ?>"><?= e($f['label']) ?></button><?php endforeach; ?>
    </div>
    <div class="gl-grid" id="glGrid">
      <?php foreach ($photos as $i => $p):
        $shape = in_array($p['shape'] ?? 'w', ['w', 't', 's'], true) ? $p['shape'] : 'w';
        $style = '--img:' . css_url($p['img']) . ';--bs:' . e($p['fit'] ?? 'cover') . ';--bp:' . e($p['pos'] ?? 'center') . ';--d:' . sprintf('%.2f', ($i % 6) * .06) . 's' . (!empty($p['pad']) ? ';--fit:1' : ''); ?>
      <figure class="gl-tile t-<?= $shape ?> nr" tabindex="0" role="button" aria-label="Open photo: <?= e($p['title']) ?>" data-cat="<?= e($p['cat']) ?>" data-title="<?= e($p['title']) ?>" data-sub="<?= e($p['sub']) ?>" style="<?= $style ?>">
        <div class="gl-ph"></div>
        <figcaption><b><?= e($p['title']) ?></b><span><?= e($p['sub']) ?></span></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<div class="gl-lb" id="glLb" role="dialog" aria-modal="true" aria-label="Photo viewer">
  <button class="gl-x" id="glX" aria-label="Close" type="button">&times;</button>
  <button class="gl-nav gl-prev" id="glPrev" aria-label="Previous photo" type="button">&lsaquo;</button>
  <div class="gl-card"><div class="gl-big" id="glBig"></div><h3 id="glT"></h3><p id="glS"></p></div>
  <button class="gl-nav gl-next" id="glNext" aria-label="Next photo" type="button">&rsaquo;</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
