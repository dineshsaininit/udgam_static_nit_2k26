<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'team',
  'title'   => 'Team & Committee Directory — ' . SITE_NAME,
  'desc'    => 'The complete committee directory of UDGAM 2K26: every committee, lead, associate lead and member with their role.',
  'scripts' => ['assets/js/directory.js'],
];

$committees = load_json('committees');
$people     = key_people($committees);
$total      = array_sum(array_map(fn($c) => count($c['m']), $committees));

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Committee Directory', 'the people behind the petals',
      count($committees) . ' committees, ' . $total . ' people. Search by name or jump straight to a committee.', 'assets/img/journey-bg.webp', 'UDGAM 2K26 · TEAM') ?>

  <section class="pg tmx" id="team" aria-label="Team" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>

    <?php if ($people['core']): ?>
    <?= section_head('OFFICE BEARERS', 'Leading<br>UDGAM 2K26', 'the core committee') ?>
    <div class="tm-core" id="cd-core">
      <div class="tm-grid">
        <?php foreach ($people['core'] as $i => $m): ?>
        <article class="tm-card nr" style="--d:<?= sprintf('%.2f', $i * .08) ?>s">
          <?= photo_box($m) ?>
          <h3 class="tm-name"><?= e($m['n']) ?></h3>
          <p class="tm-role"><?= e($m['r']) ?></p>
          <p class="tm-note"><?= e(implode(' · ', $m['coms'])) ?></p>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="cd" id="cd">
      <div class="cd-head nr" id="cd-nav">
        <h2 class="cd-title">Committee directory</h2>
        <p class="cd-lead">Search by name or jump to a committee. Leads come first, then associate leads and members.</p>
      </div>
      <form class="cd-tools nr" role="search" aria-label="Find a committee member">
        <label><span class="sr-only">Search members by name</span><input class="cd-q" type="search" placeholder="Search by name" autocomplete="off"></label>
        <label><span class="sr-only">Show one committee</span><select class="cd-f"><option value="all">All committees</option></select></label>
      </form>
      <nav class="cd-chips nr" aria-label="Committees"><a href="#cd-core">Office Bearers</a></nav>
      <div class="cd-secs"></div>
      <div class="cd-res" hidden><p class="cd-rc" role="status" aria-live="polite"></p><ul class="cd-grid cd-rg"></ul></div>
      <div class="cd-empty" hidden><p role="status"></p><button type="button" class="pg-btn">Clear search</button></div>

      <noscript>
        <?php foreach ($committees as $c): ?>
        <section class="cd-sec" id="cd-<?= e($c['id']) ?>">
          <div class="cd-sh"><h3><?= e($c['name']) ?></h3><span class="cd-n"><?= count($c['m']) ?> people</span><i></i></div>
          <ul class="cd-grid">
            <?php foreach ($c['m'] as $m): ?>
            <li class="cd-card cd-t<?= (int)$m['t'] ?>"><div class="cd-ph" data-photo="none"><span class="cd-av"><?= e(initials($m['n'])) ?></span></div><div class="cd-body"><h4 class="cd-name"><?= e($m['n']) ?></h4><span class="cd-role"><?= e($m['r']) ?></span></div></li>
            <?php endforeach; ?>
          </ul>
        </section>
        <?php endforeach; ?>
      </noscript>
    </div>
    <script type="application/json" id="cd-data"><?= json_encode($committees, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
