<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'team',
  'title'   => 'Team — ' . SITE_NAME,
  'desc'    => 'Meet the people behind UDGAM 2K26: the core committee and the fifteen organising committees of NIT Sikkim\'s cultural festival.',
  'scripts' => ['assets/js/team.js'],
];

$core       = load_json('core');
$committees = load_json('committees');

/* Head-count of unique people (some core members also serve on a committee). */
$names = [];
foreach ($core as $t) foreach ($t['people'] as $m) $names[mb_strtolower($m['n'])] = 1;
foreach ($committees as $c) foreach ($c['m'] as $m) $names[mb_strtolower($m['n'])] = 1;
$total = count($names);

/* Committee card art: a gold line icon per committee (24-unit grid) on a festival colour pair. */
$COM_ICONS = [
  'web-development'  => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4M9.5 7.5L7 10l2.5 2.5M14.5 7.5L17 10l-2.5 2.5"/>',
  'sponsorship'      => '<path d="M11 17l2 2a1 1 0 103-3"/><path d="M14 14l2.5 2.5a1 1 0 103-3l-3.88-3.88a3 3 0 00-4.24 0l-.88.88a1 1 0 11-3-3l2.81-2.81a5.79 5.79 0 017.06-.87l.47.28a2 2 0 001.42.25L21 4"/><path d="M21 3l1 11h-2M3 3L2 14l6.5 6.5a1 1 0 103-3M3 4h8"/>',
  'event-management' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M12 12.6l1.1 2.2 2.4.35-1.75 1.7.41 2.4L12 18.1l-2.16 1.15.41-2.4-1.75-1.7 2.4-.35z"/>',
  'merchandise'      => '<path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"/>',
  'publicity'        => '<path d="M3 11l18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 11-5.8-1.6"/>',
  'hospitality'      => '<path d="M3 20a1 1 0 01-1-1v-1a2 2 0 012-2h16a2 2 0 012 2v1a1 1 0 01-1 1z"/><path d="M20 16a8 8 0 10-16 0M12 4v4M10 4h4"/>',
  'medical'          => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0016.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 002 8.5c0 2.3 1.5 4.05 3 5.5l7 7z"/><path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"/>',
  'technical'        => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
  'photography'      => '<path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/>',
  'cultural'         => '<path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>',
  'graphics'         => '<path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.93 0 1.65-.75 1.65-1.69 0-.44-.18-.84-.44-1.13-.29-.29-.44-.65-.44-1.13a1.64 1.64 0 011.67-1.67h2c3.05 0 5.55-2.5 5.55-5.55C21.97 6.01 17.46 2 12 2z"/><circle cx="13.5" cy="6.5" r="1"/><circle cx="17.5" cy="10.5" r="1"/><circle cx="8.5" cy="7.5" r="1"/><circle cx="6.5" cy="12.5" r="1"/>',
  'discipline'       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 01-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 011-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 011.52 0C14.51 3.81 17 5 19 5a1 1 0 011 1z"/><path d="M9 12l2 2 4-4"/>',
  'guest-receiving'  => '<path d="M13 4h3a2 2 0 012 2v14M2 20h3M13 20h9M10 12v.01"/><path d="M13 4.56v16.16a1 1 0 01-1.24.97L5 20V5.56a2 2 0 011.52-1.94l4-1A2 2 0 0113 4.56z"/>',
  'content'          => '<path d="M12.67 19a2 2 0 001.42-.59l6.15-6.17a6 6 0 00-8.49-8.49L5.59 9.91A2 2 0 005 11.33V18a1 1 0 001 1zM16 8L2 22M17.5 15H9"/>',
  'social-media'     => '<path d="M7.9 20A9 9 0 104 16.1L2 22z"/><path d="M15.8 9.2a2.5 2.5 0 00-3.5 0l-.3.4-.35-.3a2.42 2.42 0 10-3.2 3.6l3.6 3.5 3.6-3.5c1.2-1.2 1.1-2.7.2-3.7"/>',
];
$COM_HUES = [['#7d1238', '#c8576b'], ['#4a3d5f', '#9a6f9e'], ['#17283a', '#3f6b8f'], ['#8a2a2f', '#d08a5c'], ['#5c2346', '#b8577f'], ['#2f3a5c', '#7a6aa8']];

function committee_face(array $c, int $i, int $n): string {
  global $COM_ICONS, $COM_HUES;
  [$c1, $c2] = $COM_HUES[$i % count($COM_HUES)];
  $icon = $COM_ICONS[$c['id']] ?? '<circle cx="12" cy="12" r="8"/>';
  return '<span class="cf" style="--c1:' . $c1 . ';--c2:' . $c2 . '" aria-hidden="true">'
       . '<span class="cf-no">No. ' . sprintf('%02d', $i + 1) . '<i>/' . $n . '</i></span>'
       . flower_svg('#fff4d6', 'cf-fl cf-fl1') . flower_svg('#fff4d6', 'cf-fl cf-fl2')
       . '<span class="cf-emblem"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' . $icon . '</svg></span>'
       . '<b class="cf-name">' . e($c['name']) . '</b>'
       . '<span class="cf-orn"><i></i>' . flower_svg('#fff4d6', 'cf-dot') . '<i></i></span>'
       . '<small class="cf-sub">Committee</small></span>';
}

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Our Team', 'the people behind the petals',
      'One core committee, ' . count($committees) . ' organising committees and ' . $total . ' students who give their time, ideas and energy so the whole campus can celebrate together.', 'assets/img/journey-bg.webp', 'UDGAM 2K26 · TEAM') ?>

  <!-- CORE COMMITTEE: one tier per row, top of the hierarchy first -->
  <section class="pg tmx" id="core" aria-label="Core committee" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('THE CORE COMMITTEE', 'Leading<br>UDGAM 2K26', 'the hearts behind the bloom') ?>

    <div class="tc-tree">
      <?php foreach ($core as $ti => $t): ?>
      <div class="tc-tier tc-tier<?= $ti ?>">
        <h3 class="tc-label nr"><?= e($t['title']) ?><span class="tc-orn" aria-hidden="true"><i></i><?= flower_svg('#fbeee9', 'tc-dot') ?><i></i></span></h3>
        <div class="tc-row">
          <?php foreach ($t['people'] as $i => $m) echo team_card($m, $t['title'], $i * .07); ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ORGANISING COMMITTEES: one emblem card per committee; members open in a dialog -->
  <section class="pg cmx" id="team" aria-label="Organising committees" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('COMMITTEES', count($committees) . ' committees,<br>one festival', 'open a card to meet the team') ?>

    <form class="cm-tools nr" role="search" aria-label="Find a team member">
      <label><span class="sr-only">Search the whole team by name</span><input class="cm-q" type="search" placeholder="Search anyone by name" autocomplete="off"></label>
    </form>

    <div class="cm-grid" id="cm-grid">
      <?php foreach ($committees as $i => $c):
        $leads = array_values(array_filter($c['m'], fn($m) => (int)$m['t'] === 1)); ?>
      <a class="cm-card nr" href="#c-<?= e($c['id']) ?>" data-c="<?= e($c['id']) ?>" style="--d:<?= sprintf('%.2f', ($i % 5) * .06) ?>s">
        <?= committee_face($c, $i, count($committees)) ?>
        <span class="cm-meta">
          <b><?= e($c['name']) ?></b>
          <span class="cm-faces" aria-hidden="true"><?php foreach (array_slice($c['m'], 0, 4) as $m): ?><?= photo_box($m, 'cm-face') ?><?php endforeach; ?></span>
          <small><?= count($c['m']) ?> <?= count($c['m']) === 1 ? 'person' : 'people' ?> &middot; led by <?= e(implode(' & ', array_map(fn($m) => explode(' ', $m['n'])[0], $leads))) ?></small>
        </span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="cm-res" hidden><p class="cm-rc" role="status" aria-live="polite"></p><div class="tc-row cm-rg"></div></div>
    <div class="cm-empty" hidden><p role="status"></p><button type="button" class="pg-btn">Clear search</button></div>

    <!-- Committee rosters. Shown inline without JavaScript; team.js moves each into the dialog on demand. -->
    <div class="cm-panels">
      <?php foreach ($committees as $ci => $c):
        $groups = [
          'Leads'           => array_filter($c['m'], fn($m) => (int)$m['t'] <= 1),
          'Associate Leads' => array_filter($c['m'], fn($m) => (int)$m['t'] === 2),
          'Members'         => array_filter($c['m'], fn($m) => (int)$m['t'] >= 3),
        ]; ?>
      <section class="cm-panel" id="c-<?= e($c['id']) ?>" aria-labelledby="c-<?= e($c['id']) ?>-h">
        <div class="cm-art"><?= committee_face($c, $ci, count($committees)) ?></div>
        <div class="cm-body">
          <p class="cm-kick">Committee <?= $ci + 1 ?> of <?= count($committees) ?></p>
          <h3 class="cm-title" id="c-<?= e($c['id']) ?>-h"><?= e($c['name']) ?></h3>
          <p class="cm-count"><?= count($c['m']) ?> <?= count($c['m']) === 1 ? 'person' : 'people' ?></p>
          <?php foreach ($groups as $label => $ms): if (!$ms) continue; ?>
          <h4 class="cm-sub"><i></i><?= e($label) ?><i></i></h4>
          <div class="tc-row cm-row">
            <?php foreach ($ms as $m) echo team_card($m, $c['name']); ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<dialog class="cm-dlg" id="cmDlg" aria-label="Committee members">
  <div class="cm-sheet">
    <button type="button" class="cm-x" aria-label="Close">&times;</button>
    <div class="cm-slot"></div>
    <nav class="cm-step" aria-label="Other committees">
      <button type="button" class="cm-prev"><span aria-hidden="true">&lsaquo;</span> <b></b></button>
      <button type="button" class="cm-next"><b></b> <span aria-hidden="true">&rsaquo;</span></button>
    </nav>
  </div>
</dialog>

<?php require __DIR__ . '/includes/footer.php'; ?>
