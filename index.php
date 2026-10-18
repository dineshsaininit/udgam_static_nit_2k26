<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'home',
  'title'   => SITE_NAME . ' — NIT Sikkim',
  'desc'    => SITE_DESC,
  'scripts' => ['assets/js/island-viewer.js', 'assets/js/island.js', 'assets/js/journey.js'],
];

$committees = load_json('committees');
$people     = key_people($committees);
$events     = load_json('events');
$pastYears  = $events['past'] ?? [];

$explore = [
  ['href' => 'events.php',   'title' => 'Events',   'text' => 'Highlights, categories and the full schedule of UDGAM 2K26.',  'img' => 'assets/img/event-1.jpg',          'pos' => 'center'],
  ['href' => 'gallery.php',  'title' => 'Gallery',  'text' => 'Memories and glimpses from the celebration, up close.',        'img' => 'assets/img/event-3.jpg',          'pos' => 'center'],
  ['href' => 'sponsors.php', 'title' => 'Sponsors', 'text' => 'The partners who help the festival bloom, and how to join.',   'img' => 'assets/img/events-bg.jpg',        'pos' => '56% 100%'],
  ['href' => 'team.php',     'title' => 'Team',     'text' => 'The complete committee directory, every role and designation.', 'img' => 'assets/img/journey-bg.webp',      'pos' => '60% 40%'],
  ['href' => 'contact.php',  'title' => 'Contact',  'text' => 'Reach the team by email, Instagram, YouTube or in person.',    'img' => 'assets/img/contact-hero.webp',    'pos' => 'center'],
];

require __DIR__ . '/includes/header.php';
?>

<!-- WELCOME GATE (first visit in a session) -->
<section class="gate" id="gate" aria-label="Welcome to UDGAM 2K26">
  <div class="gate-art"><img src="assets/img/gate-art.jpg" alt="" width="1600" height="900" decoding="async" fetchpriority="high"></div>
  <div class="petals" aria-hidden="true">
    <span class="petal" style="left:3%;animation-delay:-2s;--dur:13s;--s:14px;--drift:42px;--rot:-18deg;--pos:0% 0%"></span>
    <span class="petal" style="left:9%;animation-delay:-8s;--dur:16s;--s:10px;--drift:-28px;--rot:24deg;--pos:50% 0%"></span>
    <span class="petal" style="left:16%;animation-delay:-5s;--dur:12s;--s:18px;--drift:55px;--rot:8deg;--pos:100% 0%"></span>
    <span class="petal" style="left:24%;animation-delay:-11s;--dur:17s;--s:12px;--drift:-46px;--rot:-32deg;--pos:0% 50%"></span>
    <span class="petal" style="left:31%;animation-delay:-1s;--dur:14s;--s:9px;--drift:32px;--rot:12deg;--pos:50% 50%"></span>
    <span class="petal" style="left:39%;animation-delay:-7s;--dur:18s;--s:16px;--drift:-38px;--rot:26deg;--pos:100% 50%"></span>
    <span class="petal" style="left:47%;animation-delay:-13s;--dur:15s;--s:11px;--drift:48px;--rot:-14deg;--pos:0% 100%"></span>
    <span class="petal" style="left:54%;animation-delay:-4s;--dur:12s;--s:19px;--drift:-24px;--rot:34deg;--pos:50% 100%"></span>
    <span class="petal" style="left:61%;animation-delay:-9s;--dur:17s;--s:13px;--drift:36px;--rot:-25deg;--pos:100% 100%"></span>
    <span class="petal" style="left:68%;animation-delay:-15s;--dur:14s;--s:9px;--drift:-52px;--rot:16deg;--pos:0% 0%"></span>
  </div>
  <div class="gate-frame">
    <img src="assets/img/gate-title.webp" alt="NIT Sikkim presents UDGAM 2K26 — Where imagination comes alive" width="1200" height="596" decoding="async" class="gate-title" fetchpriority="high">
    <button class="enter-btn" id="enterBtn" type="button" aria-label="Enter UDGAM"><img src="assets/img/enter-button.webp" alt="" width="900" height="278" decoding="async"></button>
  </div>
</section>

<main id="main">
  <!-- HERO -->
  <div class="first-page" id="home">
    <div class="hero-parallax" id="heroParallax">
      <img class="hero-bg" src="assets/img/hero-bg.jpg" alt="" aria-hidden="true" width="1600" height="900" decoding="async" fetchpriority="high">
      <div class="hero-glow" aria-hidden="true"></div>
      <div class="hero-logo" role="img" aria-label="Udgam 2K26 — Chase The Bloom">
        <img src="assets/img/hero-logo.webp" alt="Udgam 2K26 — Chase The Bloom" width="1753" height="897" decoding="async">
      </div>
    </div>
  </div>

  <!-- ABOUT -->
  <section class="second-page ab reveal" id="about" aria-label="About UDGAM">
    <div class="ab-stage">
      <div class="ab-art" id="abArt">
        <img class="ab-plate" src="assets/img/about-plate.webp" alt="" width="1600" height="900" decoding="async" loading="lazy">
        <div class="ab-island" id="abIsland">
          <img class="ab-poster" id="abPoster" src="assets/img/island-poster.webp" alt="Floating island campus of NIT Sikkim with a waterfall" width="1100" height="756" decoding="async">
          <canvas class="ab-canvas" id="abCanvas" role="img" aria-label="Rotating 3D model of the floating NIT Sikkim island. Drag sideways to spin it." data-model="assets/models/island.glb" data-texture="assets/models/island-texture.jpg"></canvas>
        </div>
        <div class="ab-mist ab-mist1"></div><div class="ab-mist ab-mist2"></div>
      </div>

      <div class="ab-vline"></div>
      <ul class="ab-vlist"><li>Art</li><li>Culture</li><li>People</li><li>Ideas</li><li>Memories</li></ul>

      <div class="ab-copy">
        <div class="ab-label"><i></i><?= flower_svg('#f6dfe0', 'ab-flower') ?><b>ABOUT</b><i></i></div>
        <h2 class="ab-title">More than<br>just a fest</h2>
        <div class="ab-orn" aria-hidden="true"><i></i><u></u><i></i></div>
        <p class="ab-para">UDGAM is more than just a cultural fest. It is the heartbeat of the National Institute of Technology Sikkim and one of the most awaited celebrations in the north east. From art to culture, every moment here is filled with energy, togetherness, and memories that last a lifetime.</p>
        <div class="ab-rule" aria-hidden="true"></div>
        <p class="ab-script ab-bigger">A Bigger Brighter<br><span>Udgam</span></p>
        <div class="ab-feats">
          <div class="ab-feat" style="--cx:26.923%"><span class="ab-ico"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M24 6C13 6 5 14 5 24s8 18 18 18c3 0 4-2 4-4 0-3-3-3-3-6s2-4 5-4h6c5 0 8-3 8-8C43 13 35 6 24 6z"/><circle cx="14" cy="22" r="2.2"/><circle cx="20" cy="14" r="2.2"/><circle cx="30" cy="14" r="2.2"/></svg></span><span class="ab-ft">Celebrate<br>Creativity</span></div>
          <div class="ab-feat" style="--cx:41.827%"><span class="ab-ico"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="15" r="6"/><path d="M12 38v-3c0-5 5-8 12-8s12 3 12 8v3"/><circle cx="10" cy="20" r="4"/><circle cx="38" cy="20" r="4"/><path d="M3 36v-2c0-3 3-5 7-5M45 36v-2c0-3-3-5-7-5"/></svg></span><span class="ab-ft">Bring People<br>Together</span></div>
          <div class="ab-feat" style="--cx:56.113%"><span class="ab-ico"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 38L19 12l8 13 5-8 12 21z"/><path d="M15 21l4 4 4-3"/></svg></span><span class="ab-ft">Embrace<br>Our Culture</span></div>
          <div class="ab-feat" style="--cx:72.321%"><span class="ab-ico"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M24 5c1 10 4 16 14 19-10 3-13 9-14 19-1-10-4-16-14-19 10-3 13-9 14-19z"/><path d="M38 7v6M35 10h6"/></svg></span><span class="ab-ft">Create<br>Lasting Memories</span></div>
        </div>
      </div>

      <p class="ab-script ab-new" aria-hidden="true"><span>New</span><span>Stories</span><span>Await</span></p>
      <p class="ab-script ab-where" aria-hidden="true"><span>Where</span><span>Ideas</span><span>Take</span><span>Root</span></p>
      <div class="ab-fdiv ab-fdiv1"></div><div class="ab-fdiv ab-fdiv2"></div><div class="ab-fdiv ab-fdiv3"></div>
    </div>
  </section>

  <!-- MAIN LEADS / KEY PERSONS -->
  <section class="pg ld" id="leads" aria-label="Main leads" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-r" aria-hidden="true"></div>
    <?= section_head('THE TEAM', 'The people behind<br>the petals', 'leads who bring UDGAM to life',
        'Meet the office bearers and committee leads steering UDGAM 2K26 &mdash; the students who give their time, ideas and energy so the whole campus can celebrate together.') ?>

    <?php if ($people['core']): ?>
    <div class="ld-core">
      <?php foreach ($people['core'] as $i => $m): ?>
      <article class="tm-card nr" style="--d:<?= sprintf('%.2f', $i * .08) ?>s">
        <?= photo_box($m) ?>
        <h3 class="tm-name"><?= e($m['n']) ?></h3>
        <p class="tm-role"><?= e($m['r']) ?></p>
        <p class="tm-note"><?= e(implode(' · ', $m['coms'])) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($people['leads']): ?>
    <h3 class="ld-sub nr"><i></i>COMMITTEE LEADS<i></i></h3>
    <div class="ld-strip nr" aria-label="Committee leads" tabindex="0">
      <?php foreach ($people['leads'] as $m): ?>
      <article class="tm-card">
        <?= photo_box($m) ?>
        <h3 class="tm-name"><?= e($m['n']) ?></h3>
        <p class="tm-role"><?= e($m['r']) ?></p>
        <span class="tm-com"><?= e(implode(' · ', $m['coms'])) ?></span>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="ld-cta nr">
      <p class="ld-hint">Looking for someone in particular? Every committee, associate lead and member is listed in the directory.</p>
      <a class="pg-btn" href="team.php">View the full committee directory</a>
    </div>
  </section>

  <!-- JOURNEY THROUGH TIME -->
  <div class="jy reveal" id="journey">
    <div class="jy-scroller" id="jyScroller">
      <div class="jy-scene" id="jyScene">
        <img class="jy-bg" src="assets/img/journey-bg.webp" alt="" draggable="false" loading="lazy" decoding="async">
        <header class="jy-title">
          <div class="jy-small">THE UDGAM JOURNEY</div>
          <h2>A Journey Through Time</h2>
          <p class="jy-quote">&ldquo;Every year leaves a story,<br>and every journey leads us here.&rdquo;</p>
          <div class="jy-line"></div>
          <p class="jy-sub">Choose a year and let the little car take you there</p>
          <p class="jy-swipe" aria-hidden="true">&lsaquo; swipe to travel &rsaquo;</p>
        </header>

        <?php foreach ($pastYears as $y): ?>
        <a class="jy-year" href="<?= e($y['url']) ?>" data-year="<?= (int)$y['year'] ?>" target="_blank" rel="noopener" style="--x:<?= e($y['x']) ?>" title="Open UDGAM <?= (int)$y['year'] ?>">
          <img class="jy-tree" src="assets/img/journey-tree.webp" alt="Cherry blossom tree for <?= (int)$y['year'] ?>" draggable="false" loading="lazy">
          <span class="jy-plaque"><img src="assets/img/journey-plaque.webp" alt="" draggable="false" loading="lazy"><b><?= (int)$y['year'] ?></b></span>
        </a>
        <?php endforeach; ?>
        <a class="jy-year jy-current" href="#journey" data-year="2026" style="--x:84.42%" title="You are here — UDGAM 2026" aria-current="true">
          <img class="jy-sign" src="assets/img/journey-sign.webp" alt="You are here" draggable="false" loading="lazy">
          <img class="jy-tree" src="assets/img/journey-tree.webp" alt="Cherry blossom tree for 2026" draggable="false" loading="lazy">
          <span class="jy-plaque"><img src="assets/img/journey-plaque-2026.webp" alt="" draggable="false" loading="lazy"><b>2026</b></span>
        </a>
        <img class="jy-car" id="jyCar" src="assets/img/journey-car.webp" alt="Little pink car" draggable="false">
      </div>
    </div>
  </div>

  <!-- EXPLORE THE REST OF THE SITE -->
  <section class="pg xp" id="explore" aria-label="Explore UDGAM" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('EXPLORE', 'Everything UDGAM,<br>one page at a time', 'where would you like to go next?') ?>
    <div class="xp-grid">
      <?php foreach ($explore as $i => $x): ?>
      <a class="xp-card nr" href="<?= e($x['href']) ?>" style="--img:<?= css_url($x['img']) ?>;--pos:<?= e($x['pos']) ?>;--d:<?= sprintf('%.2f', $i * .07) ?>s">
        <b><?= e($x['title']) ?></b>
        <span><?= e($x['text']) ?></span>
        <em>Open <?= e($x['title']) ?> &rsaquo;</em>
      </a>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
