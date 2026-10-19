<?php
/**
 * Shared <head> + fixed header (corner logo + main navigation).
 * Expects $page = ['id' => 'home', 'title' => '...', 'desc' => '...'] from the calling page.
 * Optional: $page['css'] (or 'stylesheets') = ['assets/css/page.css'] loaded after style.css,
 *           $page['head'] = raw extra <head> markup.
 */
if (!isset($page) || !is_array($page)) { $page = []; }
$page += ['id' => 'home', 'title' => SITE_NAME . ' — NIT Sikkim', 'desc' => SITE_DESC];
$isHome = $page['id'] === 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['desc']) ?>">
<meta name="theme-color" content="#17283a">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['desc']) ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="assets/img/logo.webp">
<link rel="icon" type="image/png" href="assets/img/favicon.png">
<link rel="preload" as="font" type="font/woff2" crossorigin href="assets/fonts/playfair-display-600.woff2">
<link rel="preload" as="font" type="font/woff2" crossorigin href="assets/fonts/cinzel-500.woff2">
<link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
<?php foreach (array_merge($page['css'] ?? [], $page['stylesheets'] ?? []) as $c): ?>
<link rel="stylesheet" href="<?= asset($c) ?>">
<?php endforeach; ?>
<?= $page['head'] ?? '' ?>
<script>document.documentElement.classList.add('js')</script>
<noscript><style>.gate,.progress,.fw,#petalFall{display:none!important}#main{visibility:visible!important}body.locked{overflow:auto!important;height:auto!important}.site-head{opacity:1!important;pointer-events:auto!important}.reveal,.nr,.ev .rv{opacity:1!important;transform:none!important}</style></noscript>
</head>
<body class="<?= $isHome ? 'locked home' : 'entered' ?> page-<?= e($page['id']) ?>">
<a class="skip" href="#main">Skip to content</a>
<?= flower_symbol() ?>

<header class="site-head" id="siteHead">
  <a class="site-logo" href="index.php" aria-label="<?= e(SITE_NAME) ?> — home">
    <img src="assets/img/logo-sm.webp" alt="<?= e(SITE_NAME . ' — ' . SITE_TAGLINE) ?>" width="320" height="180" decoding="async">
  </a>
  <button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="siteNav">
    <span></span><span></span><span></span><b class="sr-only">Menu</b>
  </button>
  <nav class="site-nav" id="siteNav" aria-label="Main navigation">
    <?php foreach ($NAV as $n):
      $current = $n['id'] === $page['id']; ?>
      <a href="<?= e($n['href']) ?>"<?= $current ? ' aria-current="page"' : '' ?>><?= e($n['label']) ?></a>
    <?php endforeach; ?>
  </nav>
</header>

<div class="progress" id="progress" aria-hidden="true"><i></i></div>
