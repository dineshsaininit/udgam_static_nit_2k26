<?php
/**
 * UDGAM 2K26 — shared configuration and helpers.
 * Every page starts with:  require __DIR__ . '/includes/config.php';
 */
declare(strict_types=1);

/* Gzip the page when the web server does not (Apache's mod_deflate sets Content-Encoding first and this is skipped). */
if (PHP_SAPI !== 'cli' && extension_loaded('zlib') && !ini_get('zlib.output_compression') && !headers_sent()) {
  ob_start('ob_gzhandler');
}

define('SITE_NAME', 'UDGAM 2K26');
define('SITE_TAGLINE', 'Chase the Bloom');
define('SITE_DESC', "UDGAM 2K26 — NIT Sikkim's annual cultural festival. Chase the Bloom.");
define('SITE_ROOT', dirname(__DIR__));

/* Official contact channels (single source of truth for every page). */
$SITE = [
  'email'     => 'udgam@nitsikkim.ac.in',
  'instagram' => ['handle' => '@udgam_nitsikkim', 'url' => 'https://www.instagram.com/udgam_nitsikkim?stkn=YW8zY3VsZDk0c2w1'],
  'youtube'   => ['handle' => '@NITSikkimUdgam', 'url' => 'https://youtube.com/@nitsikkimudgam?si=7hCv5yMYeXClD-IW'],
  'address'   => 'National Institute of Technology Sikkim, Ravangla, South Sikkim 737139',
  'address_short' => 'NIT Sikkim, Ravangla, Sikkim 737139',
  'maps'      => 'https://www.google.com/maps/search/?api=1&query=NIT+Sikkim+Ravangla+Sikkim+737139',
  'maps_embed'=> 'https://www.google.com/maps?q=NIT+Sikkim+Ravangla+Sikkim+737139&output=embed',
  'institute' => 'https://www.nitsikkim.ac.in/',
];

/* Main navigation (header + footer). */
$NAV = [
  ['id' => 'home',     'label' => 'Home',     'href' => 'index.php'],
  ['id' => 'about',    'label' => 'About',    'href' => 'about.php'],
  ['id' => 'events',   'label' => 'Events',   'href' => 'events.php'],
  ['id' => 'gallery',  'label' => 'Gallery',  'href' => 'gallery.php'],
  ['id' => 'sponsors', 'label' => 'Sponsors', 'href' => 'sponsors.php'],
  ['id' => 'team',     'label' => 'Team',     'href' => 'team.php'],
  ['id' => 'contact',  'label' => 'Contact',  'href' => 'contact.php'],
];

/* Ferris-wheel menu on the right edge: cabins that live on the current page scroll, others navigate. */
$WHEEL = [
  ['id' => 'home',     'label' => 'Home',        'page' => 'index.php',    'sec' => 'home'],
  ['id' => 'about',    'label' => 'About Udgam', 'page' => 'about.php',    'sec' => 'about'],
  ['id' => 'leads',    'label' => 'Core Team',   'page' => 'team.php',     'sec' => 'core'],
  ['id' => 'journey',  'label' => 'Legacy',      'page' => 'index.php',    'sec' => 'journey'],
  ['id' => 'events',   'label' => 'Events',      'page' => 'events.php',   'sec' => 'events'],
  ['id' => 'memories', 'label' => 'Memories',    'page' => 'gallery.php',  'sec' => 'memories'],
  ['id' => 'gallery',  'label' => 'Gallery',     'page' => 'gallery.php',  'sec' => 'gallery'],
  ['id' => 'sponsors', 'label' => 'Sponsors',    'page' => 'sponsors.php', 'sec' => 'sponsors'],
  ['id' => 'team',     'label' => 'Team',        'page' => 'team.php',     'sec' => 'team'],
  ['id' => 'contact',  'label' => 'Contact',     'page' => 'contact.php',  'sec' => 'contact'],
];

$WHEEL_ICONS = [
  'home'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 11.2L12 4l8.5 7.2"/><path d="M6 10v9h12v-9"/><path d="M10 19v-5h4v5"/></svg>',
  'about'    => '<svg viewBox="0 0 24 24" fill="currentColor"><g transform="translate(12 12)"><path transform="rotate(0)" d="M0-1.6C-3.2-4.2-3.8-8.6 0-9.8 3.8-8.6 3.2-4.2 0-1.6z"/><path transform="rotate(72)" d="M0-1.6C-3.2-4.2-3.8-8.6 0-9.8 3.8-8.6 3.2-4.2 0-1.6z"/><path transform="rotate(144)" d="M0-1.6C-3.2-4.2-3.8-8.6 0-9.8 3.8-8.6 3.2-4.2 0-1.6z"/><path transform="rotate(216)" d="M0-1.6C-3.2-4.2-3.8-8.6 0-9.8 3.8-8.6 3.2-4.2 0-1.6z"/><path transform="rotate(288)" d="M0-1.6C-3.2-4.2-3.8-8.6 0-9.8 3.8-8.6 3.2-4.2 0-1.6z"/><circle r="1.8" fill="#fff4ee"/></g></svg>',
  'leads'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 19.5c0-3.6 2.9-5.6 6.5-5.6s6.5 2 6.5 5.6"/><path d="M12 2.5l.9 1.8 2 .3-1.45 1.4.35 2L12 7l-1.8 1 .35-2L9.1 4.6l2-.3z" fill="currentColor" stroke="none"/></svg>',
  'journey'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3.2 2"/></svg>',
  'events'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5.5" width="17" height="15" rx="2.5"/><path d="M3.5 10h17M8 3.5v4M16 3.5v4"/><path d="M12 12.6l1 2 2.2.3-1.6 1.5.4 2.2-2-1.1-2 1.1.4-2.2-1.6-1.5 2.2-.3z" fill="currentColor" stroke="none"/></svg>',
  'memories' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 20.5S3.5 15 3.5 9.2A4.7 4.7 0 0112 7a4.7 4.7 0 018.5 2.2C20.5 15 12 20.5 12 20.5z"/></svg>',
  'gallery'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="4.5" width="17" height="15" rx="2.5"/><circle cx="9" cy="10" r="1.6" fill="currentColor"/><path d="M4 17l5-4.5 3.5 3 3-2.5L20 16.5"/></svg>',
  'sponsors' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3.2l2.5 5.2 5.7.8-4.1 4 1 5.7L12 16.2l-5.1 2.7 1-5.7-4.1-4 5.7-.8z"/></svg>',
  'team'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 19.5c0-3.6 2.9-5.6 6.5-5.6s6.5 2 6.5 5.6"/><circle cx="5" cy="9.5" r="2"/><circle cx="19" cy="9.5" r="2"/></svg>',
  'contact'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5.5" width="17" height="13" rx="2.5"/><path d="M4.5 8l7.5 5.5L19.5 8"/></svg>',
];

/* ---------------------------------------------------------------- helpers */

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function current_page(): string { return basename($_SERVER['SCRIPT_NAME'] ?? 'index.php'); }

/* URL prefix of the site ('' at the web root, '/udgam26' when installed in a sub-folder). */
define('BASE_PATH', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/'));

/**
 * url() for inline styles / custom properties. Browsers resolve url() inside a
 * var() relative to the stylesheet, so these must be root-relative, not "assets/...".
 */
function css_url(string $path): string {
  if (preg_match('~^(https?:)?//~', $path)) return 'url(' . e($path) . ')';
  return 'url(' . e(BASE_PATH . '/' . ltrim($path, '/')) . ')';
}

/** Appends the file's mtime so browsers pick up new CSS/JS after a deploy (memoized). */
function asset(string $path): string {
  static $mtimes = [];
  if (!isset($mtimes[$path])) {
    $f = SITE_ROOT . '/' . $path;
    $mtimes[$path] = is_file($f) ? '?v=' . filemtime($f) : '';
  }
  return e($path) . $mtimes[$path];
}

/** Reads data/<name>.json with request-level memoization; returns [] when missing or invalid. */
function load_json(string $name): array {
  static $cache = [];
  if (isset($cache[$name])) {
    return $cache[$name];
  }
  $f = SITE_ROOT . '/data/' . $name . '.json';
  if (!is_file($f)) return $cache[$name] = [];
  $d = json_decode((string)file_get_contents($f), true);
  return $cache[$name] = (is_array($d) ? $d : []);
}

/** Extracts uppercase initials from a name (memoized). */
function initials(string $name): string {
  static $memo = [];
  if (isset($memo[$name])) return $memo[$name];
  $words = preg_split('/\s+/', trim(preg_replace('/[^\p{L} ]/u', '', $name)) ?: '') ?: [];
  $words = array_values(array_filter($words));
  if (!$words) return $memo[$name] = '?';
  $i = mb_substr($words[0], 0, 1);
  if (count($words) > 1) $i .= mb_substr($words[count($words) - 1], 0, 1);
  return $memo[$name] = mb_strtoupper($i);
}

/** Portrait sources for a member: `img` (local path) wins, else Google Drive id `p`. */
function member_photo(array $m): array {
  if (!empty($m['img'])) return ['src' => $m['img'], 'fallback' => ''];
  if (!empty($m['p'])) return [
    'src' => 'https://drive.google.com/thumbnail?id=' . $m['p'] . '&sz=w600',
    'fallback' => 'https://lh3.googleusercontent.com/d/' . $m['p'] . '=w600',
  ];
  return ['src' => '', 'fallback' => ''];
}

/** Round photo box with initials fallback (JS in main.js swaps states via data-photo). */
function photo_box(array $m, string $cls = 'tm-ph'): string {
  $ph = member_photo($m);
  $h = '<div class="' . e($cls) . '" data-photo="' . ($ph['src'] ? 'loading' : 'none') . '"><span class="tm-ring"></span>'
     . '<span class="tm-av" aria-hidden="true">' . e(initials($m['n'])) . '</span>';
  if ($ph['src']) {
    $h .= '<img src="' . e($ph['src']) . '" alt="Portrait of ' . e($m['n']) . '" loading="lazy" decoding="async" referrerpolicy="no-referrer"'
        . ($ph['fallback'] ? ' data-fallback="' . e($ph['fallback']) . '"' : '') . '>';
  }
  return $h . '</div>';
}

/**
 * Team page portrait card: round photo in a blossom medallion, name, role, optional LinkedIn.
 * $group is the committee (or core tier) shown when the card appears in search results.
 */
function team_card(array $m, string $group, float $delay = 0): string {
  $q = implode(' ', array_merge([$m['n']], $m['a'] ?? []));
  $in = '';
  if (!empty($m['li'])) {
    $in = '<a class="tc-in" href="' . e($m['li']) . '" target="_blank" rel="noopener" aria-label="' . e($m['n']) . ' on LinkedIn">'
        . '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><use href="#i-in"/></svg></a>';
  }
  return '<article class="tc-card nr" data-q="' . e($q) . '" data-g="' . e($group) . '"' . ($delay ? ' style="--d:' . sprintf('%.2f', $delay) . 's"' : '') . '>'
       . '<span class="tc-medal">' . photo_box($m, 'tc-ph')
       . flower_svg('#fff4d6', 'tc-fl tc-fl1') . flower_svg('#fff4d6', 'tc-fl tc-fl2') . $in . '</span>'
       . '<h4 class="tc-name">' . e($m['n']) . '</h4><span class="tc-role">' . e($m['r']) . '</span></article>';
}

/** The four public contact channels (used by the contact page and the footer poster). */
function contact_channels(): array {
  global $SITE;
  return [
    ['id' => 'email', 'href' => 'mailto:' . $SITE['email'], 'title' => 'Email us', 'sub' => $SITE['email'], 'ext' => false,
     'icon' => '<rect x="4" y="7" width="24" height="18" rx="3"/><path d="M5 10l11 8 11-8"/>'],
    ['id' => 'instagram', 'href' => $SITE['instagram']['url'], 'title' => 'Instagram', 'sub' => $SITE['instagram']['handle'], 'ext' => true,
     'icon' => '<rect x="5" y="5" width="22" height="22" rx="6.5"/><circle cx="16" cy="16" r="5.2"/><circle cx="22.6" cy="9.4" r="1.1" fill="currentColor"/>'],
    ['id' => 'youtube', 'href' => $SITE['youtube']['url'], 'title' => 'YouTube', 'sub' => $SITE['youtube']['handle'], 'ext' => true,
     'icon' => '<rect x="3.5" y="7.5" width="25" height="17" rx="5"/><path d="M13.5 12v8l7-4z" fill="currentColor"/>'],
    ['id' => 'maps', 'href' => $SITE['maps'], 'title' => 'Visit us', 'sub' => $SITE['address_short'], 'ext' => true,
     'icon' => '<path d="M16 28S6 19.5 6 12.5a10 10 0 0120 0C26 19.5 16 28 16 28z"/><circle cx="16" cy="12.5" r="3.6"/>'],
  ];
}

/** Small five-petal flower used in section labels. */
function flower_svg(string $centre = '#fbeee9', string $cls = 'pg-fl'): string {
  return '<span class="' . e($cls) . '"><svg viewBox="0 0 40 40" fill="currentColor" aria-hidden="true" style="--fc:' . e($centre) . '"><use href="#i-fl"/></svg></span>';
}

/** Icons drawn once per page (header.php): the blossom flower_svg() points at (centre colour from --fc) and the LinkedIn mark. */
function flower_symbol(): string {
  $petals = '';
  foreach ([0, 72, 144, 216, 288] as $r) $petals .= '<path transform="rotate(' . $r . ')" d="M0-3C-6-8-7-16 0-18 7-16 6-8 0-3z"/>';
  return '<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false"><symbol id="i-fl" viewBox="0 0 40 40"><g transform="translate(20 20)">'
       . $petals . '<circle r="3" style="fill:var(--fc,#fbeee9)"/></g></symbol>'
       . '<symbol id="i-in" viewBox="0 0 24 24"><path d="M6.94 8.5H3.56V20h3.38V8.5zM5.25 3.5a1.96 1.96 0 100 3.92 1.96 1.96 0 000-3.92zM20.44 13.4c0-3.1-1.66-4.54-3.87-4.54-1.79 0-2.59.98-3.04 1.67V8.5h-3.37c.04.95 0 11.5 0 11.5h3.37v-6.42c0-.34.03-.69.12-.93.27-.69.89-1.4 1.93-1.4 1.36 0 1.9 1.04 1.9 2.56V20h3.37v-6.6z"/></symbol></svg>';
}

/** Section heading used by every content page. */
function section_head(string $label, string $title, string $script, string $lead = ''): string {
  $h = '<header class="pg-head nr"><div class="pg-label"><i></i>' . flower_svg() . '<b>' . e($label) . '</b><i></i></div>'
     . '<h2 class="pg-title">' . $title . '</h2>';
  if ($script !== '') $h .= '<p class="pg-script">' . e($script) . '</p>';
  if ($lead !== '')   $h .= '<p class="pg-lead">' . $lead . '</p>';
  return $h . '</header>';
}

/** Sub-page banner (below the fixed header). */
function page_banner(string $title, string $script, string $lead, string $img, string $label = 'UDGAM 2K26'): string {
  return '<section class="pb" style="--pb-img:' . css_url($img) . '">'
       . '<div class="pb-in"><div class="pb-label"><i></i><span>' . e($label) . '</span><i></i></div>'
       . '<h1 class="pb-title">' . $title . '</h1>'
       . '<p class="pb-script">' . e($script) . '</p>'
       . ($lead !== '' ? '<p class="pb-lead">' . $lead . '</p>' : '')
       . '<p class="pb-crumb"><a href="index.php">Home</a><span>/</span>' . strip_tags($title) . '</p>'
       . '</div></section>';
}
