<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'    => 'sponsors',
  'title' => 'Sponsors — ' . SITE_NAME,
  'desc'  => 'Our sponsors and partners, and how to partner with UDGAM 2K26, the cultural festival of NIT Sikkim.',
];

$sp    = load_json('sponsors');
$tiers = $sp['tiers'] ?? [];
$why   = $sp['why'] ?? [];

/* Sponsorship committee lead(s) from the directory, so the contact card never goes stale. */
$spLeads = [];
foreach (load_json('committees') as $c) {
  if (($c['id'] ?? '') === ($sp['contact_committee'] ?? 'sponsorship')) {
    foreach ($c['m'] as $m) if ((int)$m['t'] <= 1) $spLeads[] = $m;
  }
}

function sponsor_slot(array $s, string $tierLabel, bool $big = false): string {
  $cls = 'sp-slot' . ($big ? ' sp-big' : '');
  $inner = '';
  if (!empty($s['name'])) {
    $inner .= !empty($s['logo'])
      ? '<img src="' . e($s['logo']) . '" alt="' . e($s['name']) . '" loading="lazy" decoding="async">'
      : '<span class="sp-logo" aria-hidden="true">' . flower_svg('#fbeee9', '') . '</span>';
    $inner .= '<b>' . e($s['name']) . '</b><small>' . e($tierLabel) . '</small>';
    if (!empty($s['url'])) $inner = '<a href="' . e($s['url']) . '" target="_blank" rel="noopener sponsored">' . $inner . '</a>';
  } else {
    $inner .= '<span class="sp-logo" aria-hidden="true">' . flower_svg('#fbeee9', '') . '</span><b>Your Logo Here</b><small>' . e($tierLabel) . '</small>';
  }
  return '<div class="' . $cls . '">' . $inner . '</div>';
}

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Sponsors', 'partners in every petal', 'UDGAM 2K26 is made possible by the generosity of organisations who believe in art, culture and young talent. Meet the partners who help the festival grow.', 'assets/img/events-bg.jpg') ?>

  <section class="pg spn" id="sponsors" aria-label="Sponsors" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('SPONSORS', 'Together we<br>make it bloom', 'partners in every petal') ?>

    <?php foreach ($tiers as $t):
      $label = $t['label'] ?? '';
      $single = ucwords(strtolower(rtrim($label, 'S'))); // "ASSOCIATE SPONSORS" -> "Associate Sponsor"
      $layout = $t['layout'] ?? 'row3'; ?>
    <div class="sp-tier nr" id="tier-<?= e($t['id'] ?? '') ?>">
      <h3 class="sp-t"><i></i><?= e($label) ?><i></i></h3>
      <?php if ($layout === 'title'): ?>
      <div class="sp-title-card"><?php foreach ($t['slots'] as $s) echo sponsor_slot($s, $single, true); ?></div>
      <?php else: ?>
      <div class="sp-row sp-<?= e($layout) ?>"><?php foreach ($t['slots'] as $s) echo sponsor_slot($s, $single); ?></div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <div class="sp-cta nr" id="partner">
      <?php if ($why): ?>
      <div class="sp-why">
        <?php foreach ($why as $w): ?><div><b><?= e($w['title']) ?></b><span><?= e($w['text']) ?></span></div><?php endforeach; ?>
      </div>
      <?php endif; ?>
      <p class="pg-script">Want to partner with UDGAM 2K26?</p>
      <a class="pg-btn" href="mailto:<?= e($SITE['email']) ?>?subject=Sponsorship%20enquiry%20-%20UDGAM%202K26">Become a sponsor</a>

      <?php foreach ($spLeads as $m): ?>
      <div class="sp-contact">
        <?= photo_box($m) ?>
        <div>
          <b><?= e($m['n']) ?></b>
          <span><?= e($m['r']) ?> &middot; Sponsorship Committee</span>
          <small>For proposals, brand decks and partnership tiers, write to <a href="mailto:<?= e($SITE['email']) ?>?subject=Sponsorship%20enquiry%20-%20UDGAM%202K26"><?= e($SITE['email']) ?></a> and mention <?= e(explode(' ', $m['n'])[0]) ?>.</small>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
