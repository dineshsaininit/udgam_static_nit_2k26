<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'      => 'events',
  'title'   => 'Events — ' . SITE_NAME,
  'desc'    => 'Event highlights, categories, the upcoming schedule and past editions of UDGAM, NIT Sikkim\'s cultural festival.',
  'scripts' => ['assets/js/events.js'],
];

$events   = load_json('events');
$upcoming = $events['upcoming'] ?? [];
$past     = $events['past'] ?? [];
$stageData = ['highlights' => $events['highlights'] ?? [], 'categories' => $events['categories'] ?? []];

$statusLabel = ['upcoming' => 'Upcoming', 'live' => 'Happening now', 'done' => 'Completed'];

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Events', 'a celebration of art, culture and people', 'UDGAM 2K26 brings together a diverse range of events across art, culture, technology, literature, music and more. Each one is a vibrant expression of talent, creativity and community.', 'assets/img/events-bg.jpg') ?>

  <!-- ILLUSTRATED STAGE: highlights + categories -->
  <section class="ev" id="events" aria-label="Event highlights" data-nav=".5">
    <div class="ev-glow" aria-hidden="true"></div>
    <div class="ev-stage" id="evStage">
      <div class="mhero" aria-hidden="true"></div>
      <div class="bgs" id="evBgs"><div class="band" style="--y:0;--h:380" data-p="6"></div><div class="band" style="--y:380;--h:260" data-p="12"></div><div class="band" style="--y:640;--h:260" data-p="20"></div></div>
      <div class="sw" style="--x:0;--y:0;--w:880;--h:210;--o:0 0"></div>
      <div class="sw" style="--x:0;--y:330;--w:230;--h:330;--o:0 50%;--t:7s"></div>
      <div class="sw" style="--x:0;--y:640;--w:320;--h:260;--o:0 100%;--t:8s"></div>
      <div class="sw" style="--x:1400;--y:320;--w:200;--h:580;--o:100% 50%;--t:5s"></div>
      <div class="fx mist" style="left:2%;top:63%;width:36%;height:7%;--t:16s;--dx:60px"></div><div class="fx mist" style="left:44%;top:77%;width:30%;height:5%;--t:20s;--dx:-60px"></div><div class="fx mist" style="left:52%;top:5%;width:30%;height:6%;--t:18s;--dx:50px"></div>
      <div class="fx glow" style="left:93%;top:21%"></div>
      <div class="fx steam" style="left:90.4%;top:79.5%"><i></i><i></i><i></i></div>
      <div class="fx wf" style="left:70.2%;top:79.8%;width:2.4%;height:9%"></div>
      <div class="fx wheel" style="left:53.7%;top:85%;width:4%"><i style="--i:0"></i><i style="--i:1"></i><i style="--i:2"></i><i style="--i:3"></i><i style="--i:4"></i><i style="--i:5"></i><i style="--i:6"></i><i style="--i:7"></i></div>
      <div class="fx cg" id="evCg"></div>
      <div class="fx lights" id="evLights" style="inset:0"></div>
      <div class="fx" style="left:44%;top:92.5%;width:24%;height:7%" id="evRv"></div>
      <div class="bd" style="left:62%;top:9%;--s:0s"><svg viewBox="0 0 16 8"><path d="M0 5Q4 0 8 5Q12 0 16 5"/></svg></div><div class="bd" style="left:66%;top:11.5%;--s:-6s"><svg viewBox="0 0 16 8"><path d="M0 5Q4 0 8 5Q12 0 16 5"/></svg></div><div class="bd" style="left:72%;top:7%;--s:-12s"><svg viewBox="0 0 16 8"><path d="M0 5Q4 0 8 5Q12 0 16 5"/></svg></div>
      <div class="a sc rv" style="--x:430;--y:36;--f:38;--r:-12deg">Moments<br>&nbsp;&nbsp;&nbsp;People<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Passion</div>
      <nav class="a nav nav2 rv" aria-label="Event themes" id="evNav" style="--x:66;--y:150"><a href="#evTop" class="on">ART</a><a href="#evTop">CULTURE</a><a href="#evCats">PEOPLE</a><a href="#evCats">IDEAS</a><a href="#schedule">SCHEDULE</a></nav>

      <div class="a legacy rv" id="evTop" style="--x:228;--y:168;--w:388"><svg width="28" height="28" viewBox="0 0 30 30"><g fill="#d63a73"><ellipse cx="15" cy="7" rx="5" ry="7"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(72 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(144 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(216 15 15)"/><ellipse cx="15" cy="7" rx="5" ry="7" transform="rotate(288 15 15)"/></g><circle cx="15" cy="15" r="3" fill="#fff"/></svg><span>EVENT HIGHLIGHTS</span></div>
      <h2 class="a h2 rv" style="--x:142;--y:208;--w:560;--f:45;--dl:.15s;white-space:nowrap;text-align:center">A CELEBRATION OF</h2>
      <div class="a bl bl2 rv" style="--x:176;--y:258;--dl:.3s"><span style="display:inline-block;transform:skewX(-4deg)">Art, Culture and People</span></div>
      <p class="a copy c rv" style="--x:228;--y:350;--w:416;--dl:.45s">UDGAM 2K26 brings together a diverse range of events across art, culture, technology, literature, music and more. Each event is a vibrant expression of talent, creativity and community, making UDGAM an experience to remember.</p>
      <div class="a mk rv" style="--x:355;--y:442;--w:146">&#10047;</div>
      <div class="pols" id="evPols"></div>
      <div class="evdots" id="evDots"></div>
      <div class="cps" id="evCps"></div>
      <div class="mscene rv" aria-hidden="true"></div>
      <div class="a sc sc2 rv" style="--x:52;--y:768;--f:34;--r:-13deg">Different<br>&nbsp;&nbsp;&nbsp;Stages<br>&nbsp;&nbsp;&nbsp;&nbsp;Same Spirit</div>
    </div>
  </section>
  <script type="application/json" id="ev-data"><?= json_encode($stageData, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

  <!-- SCHEDULE: upcoming + past -->
  <section class="pg evs" id="schedule" aria-label="Schedule" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('SCHEDULE', 'Upcoming<br>events', 'mark your calendar', 'The line-up for UDGAM 2K26. Dates, times and venues are confirmed here as soon as the committees lock them in.') ?>

    <?php if ($upcoming): ?>
    <div class="evs-list">
      <?php foreach ($upcoming as $i => $ev):
        $st = $ev['status'] ?? 'upcoming';
        $when = trim(($ev['date'] ?? '') . (!empty($ev['time']) ? ' · ' . $ev['time'] : '')); ?>
      <article class="evs-item nr" style="--d:<?= sprintf('%.2f', $i * .06) ?>s">
        <div class="evs-date"><?= nl2br(e(str_replace(' to be announced', "\nTBA", $ev['date'] ?? 'TBA'))) ?></div>
        <div>
          <span class="evs-meta"><?= e($ev['category'] ?? '') ?><?= !empty($ev['venue']) ? ' &middot; ' . e($ev['venue']) : '' ?></span>
          <h3><?= e($ev['name']) ?></h3>
          <?php if (!empty($ev['desc'])): ?><p><?= e($ev['desc']) ?></p><?php endif; ?>
          <?php if (!empty($ev['time'])): ?><p><?= e($when) ?></p><?php endif; ?>
        </div>
        <span class="evs-tag <?= $st === 'live' ? 'live' : '' ?>"><?= e($statusLabel[$st] ?? ucfirst($st)) ?></span>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="evs-note nr">Follow <a href="<?= e($SITE['instagram']['url']) ?>" target="_blank" rel="noopener"><?= e($SITE['instagram']['handle']) ?></a> for schedule announcements, or <a href="contact.php">write to the team</a> if you would like to host or perform.</p>
    <?php else: ?>
    <p class="evs-note nr">The schedule will be published here soon.</p>
    <?php endif; ?>

    <?= section_head('PAST EDITIONS', 'Every year<br>leaves a story', 'revisit the editions that led us here') ?>
    <div class="evs-past nr">
      <?php foreach ($past as $y): ?>
      <a class="evs-year" href="<?= e($y['url']) ?>" target="_blank" rel="noopener" title="Open the UDGAM <?= (int)$y['year'] ?> website"><b><?= (int)$y['year'] ?></b><small>Open site</small></a>
      <?php endforeach; ?>
      <a class="evs-year now" href="index.php#journey" aria-current="true"><b>2026</b><small>You are here</small></a>
    </div>
  </section>
</main>

<div class="evlb" id="evLb"><div><i id="evLi"></i><h3 id="evLy"></h3><p id="evLc"></p></div></div>

<?php require __DIR__ . '/includes/footer.php'; ?>
