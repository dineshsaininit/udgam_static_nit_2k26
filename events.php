<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'events',
  'title'   => 'Events — ' . SITE_NAME,
  'desc'    => 'Every event of UDGAM 2K26, NIT Sikkim\'s cultural festival: headliners, games, sport, performance, creative, food and e-sports, with entry fees, team sizes and rulebooks.',
  'scripts' => ['assets/js/events.js'],
];

$data     = load_json('events');
$events   = $data['events'] ?? [];
$cats     = array_column($data['categories'] ?? [], null, 'id');
$heads    = array_values(array_filter($events, fn($e) => !empty($e['headliner'])));
$free     = count(array_filter($events, fn($e) => empty($e['fee'])));

/* gold line icons (24-unit grid): one per headliner, one per category for everything else */
$ICONS = [
  'dance-competition'   => '<path d="M12 3l2.2 6.8L21 12l-6.8 2.2L12 21l-2.2-6.8L3 12l6.8-2.2z"/><path d="M19 3v4M17 5h4"/>',
  'food-fiesta'         => '<path d="M17 21a1 1 0 001-1v-5.35c0-.46.32-.84.73-1.04a4 4 0 00-2.14-7.59 5 5 0 00-9.18 0 4 4 0 00-2.14 7.59c.41.2.73.58.73 1.04V20a1 1 0 001 1z"/><path d="M6 17h12"/>',
  'treasure-hunt'       => '<path d="M14.1 5.55a2 2 0 001.79 0l3.66-1.83A1 1 0 0121 4.62v12.76a1 1 0 01-.55.9l-4.56 2.27a2 2 0 01-1.78 0l-4.22-2.1a2 2 0 00-1.78 0l-3.66 1.83A1 1 0 013 19.38V6.62a1 1 0 01.55-.9l4.56-2.27a2 2 0 011.78 0z"/><path d="M15 5.76v15M9 3.24v15"/>',
  'ipl-auction'         => '<path d="M14.5 12.5l-8 8a2.12 2.12 0 11-3-3l8-8M16 16l6-6M8 8l6-6M9 7l8 8M21 11l-8-8"/>',
  'ramp-walk'           => '<path d="M11.56 3.27a.5.5 0 01.88 0l2.95 5.6a1 1 0 001.52.3l4.27-3.67a.5.5 0 01.8.52l-2.83 10.25a1 1 0 01-.96.73H5.81a1 1 0 01-.96-.73L2.02 6.02a.5.5 0 01.8-.52l4.27 3.67a1 1 0 001.52-.3z"/><path d="M5 21h14"/>',
  'singing-competition' => '<path d="M12 2a3 3 0 00-3 3v7a3 3 0 006 0V5a3 3 0 00-3-3z"/><path d="M19 10v2a7 7 0 01-14 0v-2M12 19v3"/>',
  'wall-painting'       => '<path d="M18.38 2.62a1 1 0 113 3l-4.02 4.02a.5.5 0 000 .71l.94.94a2.41 2.41 0 010 3.41l-.94.94a.5.5 0 01-.7 0L8.35 7.35a.5.5 0 010-.7l.94-.95a2.41 2.41 0 013.41 0l.94.95a.5.5 0 00.71 0z"/><path d="M9 8c-1.8 2.71-3.97 3.46-6.58 3.95a.5.5 0 00-.3.82l7.32 8.88a1 1 0 001.18.2C12.74 20.4 16 16.8 16 15"/>',
  'housie'              => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M3 14h18M9 5v14M15 5v14"/>',
  'spoil-the-tshirt'    => '<path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"/>',
  /* categories */
  'games'       => '<rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8" cy="8" r="1.2"/><circle cx="16" cy="8" r="1.2"/><circle cx="12" cy="12" r="1.2"/><circle cx="8" cy="16" r="1.2"/><circle cx="16" cy="16" r="1.2"/>',
  'sports'      => '<path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 01-10 0z"/><path d="M17 5h3v2a3 3 0 01-3 3M7 5H4v2a3 3 0 003 3"/>',
  'performance' => '<path d="M12 2a3 3 0 00-3 3v7a3 3 0 006 0V5a3 3 0 00-3-3z"/><path d="M19 10v2a7 7 0 01-14 0v-2M12 19v3"/>',
  'creative'    => '<path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.93 0 1.65-.75 1.65-1.69 0-.44-.18-.84-.44-1.13-.29-.29-.44-.65-.44-1.13a1.64 1.64 0 011.67-1.67h2c3.05 0 5.55-2.5 5.55-5.55C21.97 6.01 17.46 2 12 2z"/><circle cx="13.5" cy="6.5" r="1"/><circle cx="17.5" cy="10.5" r="1"/><circle cx="8.5" cy="7.5" r="1"/><circle cx="6.5" cy="12.5" r="1"/>',
  'food'        => '<path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>',
  'esports'     => '<path d="M6 11h4M8 9v4M15 12h.01M18 10h.01"/><path d="M17.32 5H6.68a4 4 0 00-3.98 3.59C2.6 9.42 2 14.46 2 16a3 3 0 003 3c1 0 1.5-.5 2-1l1.41-1.41A2 2 0 019.83 16h4.34a2 2 0 011.41.59L17 18c.5.5 1 1 2 1a3 3 0 003-3c0-1.55-.6-6.58-.68-7.26A4 4 0 0017.32 5z"/>',
];
function ev_icon(string $key): string {
  global $ICONS;
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ICONS[$key] ?? '') . '</svg>';
}
function ev_fee(array $e): array {
  return empty($e['fee']) ? ['Free', 'entry'] : ['₹' . (int)$e['fee'], 'per ' . ($e['per'] ?? 'team')];
}
function ev_team(array $e): string {
  [$a, $b] = $e['team'] ?? [1, 1];
  if ($a === 1 && $b === 1) return 'Solo';
  if ($a === $b) return 'Team of ' . $a;
  return $a . '–' . $b . ' members';
}
/** One festival pass. $big = headliner card with the emblem; otherwise the compact open-floor card. */
function ev_pass(array $e, array $cat, int $n, bool $big): string {
  [$fee, $per] = ev_fee($e);
  $line  = $e['tagline'] ?? ($e['desc'] ?? '');
  $icon  = ev_icon(isset($GLOBALS['ICONS'][$e['id']]) ? $e['id'] : $e['category']);
  $rules = !empty($e['rules']) ? '<a class="ep-rules" href="' . e($e['rules']) . '" target="_blank" rel="noopener">Rulebook<span class="sr-only"> for ' . e($e['name']) . ' (opens in a new tab)</span></a>' : '';
  $meta  = '<span class="ep-team"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/><circle cx="17" cy="9" r="2.4"/><path d="M15.5 14.6c2.9.2 5.5 2 5.5 5"/></svg>' . e(ev_team($e)) . '</span>'
         . (!empty($e['rounds']) ? '<span class="ep-team" title="' . e(implode(' · ', $e['rounds'])) . '">' . count($e['rounds']) . ' rounds</span>' : '');
  return '<article class="ep' . ($big ? ' ep-big' : '') . ' nr" id="ev-' . e($e['id']) . '" data-cat="' . e($e['category']) . '" data-fee="' . (int)($e['fee'] ?? 0) . '" data-n="' . $n . '"'
       . ' data-q="' . e(mb_strtolower($e['name'] . ' ' . ($e['tagline'] ?? '') . ' ' . ($e['desc'] ?? '') . ' ' . $cat['label'])) . '"'
       . ' style="--c1:' . e($cat['hue'][0]) . ';--c2:' . e($cat['hue'][1]) . ';--d:' . sprintf('%.2f', ($n % 4) * .06) . 's">'
       . '<div class="ep-face">'
       .   '<div class="ep-top"><span class="ep-cat">' . ev_icon($e['category']) . e($cat['label']) . '</span><span class="ep-fee' . (empty($e['fee']) ? ' is-free' : '') . '"><b>' . e($fee) . '</b><small>' . e($per) . '</small></span></div>'
       .   ($big ? '<span class="ep-no" aria-hidden="true">' . sprintf('%02d', $n) . '</span>' . flower_svg('rgba(255,236,214,.45)', 'ep-fl') . '<span class="ep-emblem">' . $icon . '</span>' : '')
       .   '<h3 class="ep-name">' . (!$big ? '<span class="ep-ico">' . $icon . '</span>' : '') . e($e['name']) . '</h3>'
       .   ($line !== '' ? '<p class="ep-line">' . e($line) . '</p>' : '')
       .   ($big && !empty($e['desc']) && !empty($e['tagline']) ? '<p class="ep-desc">' . e($e['desc']) . '</p>' : '')
       . '</div>'
       . '<div class="ep-stub"><div class="ep-meta">' . $meta . '</div>' . ($rules ? '<div class="ep-acts">' . $rules . '</div>' : '')
       . '</div></article>';
}

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Events', 'pick your stage',
      count($events) . ' events across games, sport, performance, creative arts, food and e-sports. Find yours and read the rulebook.', 'assets/img/events-bg.webp', 'UDGAM 2K26 · EVENTS') ?>

  <!-- HEADLINERS -->
  <section class="pg evx" id="events" aria-label="Headliner events" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>
    <ul class="ev-stats nr" aria-label="At a glance">
      <li><b><?= count($events) ?></b><span>Events</span></li>
      <li><b><?= count($heads) ?></b><span>Headliners</span></li>
      <li><b><?= count($cats) ?></b><span>Categories</span></li>
      <li><b><?= $free ?></b><span>Free entry</span></li>
    </ul>

    <?= section_head('HEADLINERS', 'The big<br>stage events', 'where legends are made', 'The nine flagship events of UDGAM 2K26. Some winners even earn a spot on the festival stage or a stall of their own.') ?>
    <div class="eh-grid">
      <?php foreach ($heads as $i => $e) echo ev_pass($e, $cats[$e['category']], $i + 1, true); ?>
    </div>
  </section>

  <!-- OPEN FLOOR: every event, with filter / search / sort -->
  <section class="pg evy" id="all" aria-label="All events" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('OPEN FLOOR', 'Every event,<br>one festival', 'find your game') ?>

    <div class="ex-tools nr" id="exTools">
      <label class="ex-search"><span class="sr-only">Search events</span><input type="search" id="exQ" placeholder="Search events" autocomplete="off"></label>
      <label class="ex-sort"><span class="sr-only">Sort events</span>
        <select id="exSort"><option value="n">Featured</option><option value="fa">Fee: low to high</option><option value="fd">Fee: high to low</option><option value="az">Name A–Z</option></select>
      </label>
    </div>
    <div class="ex-chips nr" role="group" aria-label="Filter by category">
      <button type="button" class="ex-chip on" data-f="all" aria-pressed="true">All <i><?= count($events) ?></i></button>
      <?php foreach ($cats as $c): $n = count(array_filter($events, fn($e) => $e['category'] === $c['id'])); ?>
      <button type="button" class="ex-chip" data-f="<?= e($c['id']) ?>" aria-pressed="false" style="--c1:<?= e($c['hue'][0]) ?>;--c2:<?= e($c['hue'][1]) ?>"><?= ev_icon($c['id']) ?><?= e($c['label']) ?> <i><?= $n ?></i></button>
      <?php endforeach; ?>
    </div>
    <p class="ex-count" id="exCount" role="status" aria-live="polite">Showing all <?= count($events) ?> events</p>

    <div class="ex-grid" id="exGrid">
      <?php foreach ($events as $i => $e) echo ev_pass($e, $cats[$e['category']], $i + 1, false); ?>
    </div>
    <div class="ex-empty" id="exEmpty" hidden><p>No event matches that search.</p><button type="button" class="pg-btn" id="exClear">Show all events</button></div>

    <div class="ex-note nr">
      <p class="pg-script">Ready to play?</p>
      <p>Rulebooks open as PDFs or documents. Follow <a href="<?= e($SITE['instagram']['url']) ?>" target="_blank" rel="noopener"><?= e($SITE['instagram']['handle']) ?></a> for dates and announcements.</p>
      <a class="pg-btn" href="contact.php">Questions? Contact the team</a>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
