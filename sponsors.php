<?php
/**
 * UDGAM 2K26 — Sponsors page (sponsors.php)
 * Add a sponsor by putting entries in a tier's 'sponsors' array:
 *   ['name'=>'Acme Corp','logo'=>'img/acme.png','url'=>'https://acme.example']
 * A tier with no sponsors shows its "Your brand here" slots instead.
 */
declare(strict_types=1);
require __DIR__ . '/includes/config.php';

$page = [
  'id'    => 'sponsors',
  'title' => 'Sponsors — ' . SITE_NAME,
  'desc'  => 'The partners who help UDGAM 2K26 bloom — NIT Sikkim\'s annual fest.',
  'css'   => ['assets/css/sponsors.css'],
  /* page fonts + the saved day/night mode, applied before first paint */
  'head'  => '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@400;500;600;700&family=Mrs+Saint+Delafield&family=Playfair+Display:ital,wght@1,400;1,500;1,600&display=swap">
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@400;500;600;700&family=Mrs+Saint+Delafield&family=Playfair+Display:ital,wght@1,400;1,500;1,600&display=swap" rel="stylesheet" media="print" onload="this.media=\'all\'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Inter:wght@400;500;600;700&family=Mrs+Saint+Delafield&family=Playfair+Display:ital,wght@1,400;1,500;1,600&display=swap" rel="stylesheet"></noscript>
<script>document.documentElement.classList.add(\'js\');try{if(localStorage.getItem(\'udgam-mode\')===\'night\'){document.documentElement.setAttribute(\'data-mode\',\'night\');document.documentElement.style.setProperty(\'--nt\',1)}}catch(e){}</script>',
];

$tiers = [
  [
    'id'       => 'corporate',
    'title'    => 'Corporate & Cash Sponsors',
    'size'     => 'lg',
    'slots'    => 0,
    'cta'      => 'Become a Corporate Sponsor',
    'tag'      => 'Valued corporate and infrastructure partners supporting seamless festival operations.',
    'sponsors' => [
      ['name'=>'Quarks Technosoft', 'logo'=>'uploads/sponsors/quarks_logo.png', 'url'=>'https://www.qtsolv.com/'],
      ['name'=>'NBCC (India) Limited', 'logo'=>'uploads/sponsors/nbcc_logo.png', 'url'=>'https://www.nbccindia.in/'],
      ['name'=>'CISB Services Ltd.', 'logo'=>'uploads/sponsors/cisb_logo.png', 'url'=>'https://cisb.co.in/'],
      ['name'=>'Sistema Smart Tech', 'logo'=>'uploads/sponsors/sistema_smart_tech_logo.png', 'url'=>'https://sistema.com'],
      ['name'=>'The Kollektor', 'logo'=>'uploads/sponsors/kollektor_logo.png', 'url'=>'https://thekollektor.com/']
    ]
  ],
  [
    'id'       => 'banking',
    'title'    => 'Banking & Cash Partners',
    'size'     => 'md',
    'slots'    => 0,
    'cta'      => 'Become a Banking Partner',
    'tag'      => 'Empowering youth vitality, student excellence, and financial enablement.',
    'sponsors' => [
      ['name'=>'Union Bank of India', 'logo'=>'uploads/sponsors/union_bank_logo.png', 'url'=>'https://www.unionbankofindia.bank.in/en/home'],
      ['name'=>'Canara Bank', 'logo'=>'uploads/sponsors/canara_bank_logo.png', 'url'=>'https://www.canarabank.bank.in/']
    ]
  ],
  [
    'id'       => 'gaming',
    'title'    => 'Gaming & Esports Partners',
    'size'     => 'md',
    'slots'    => 0,
    'cta'      => 'Become an Esports Partner',
    'tag'      => 'Powering BGMI, Real Cricket, Free Fire, and eFootball tournaments at UDGAM 2K26.',
    'sponsors' => [
      ['name'=>'Krafton India Esports', 'logo'=>'uploads/sponsors/krafton_india_esports_logo.png', 'url'=>'https://kraftonindiaesports.com/'],
      ['name'=>'Unstop', 'logo'=>'uploads/sponsors/unstop_logo.png', 'url'=>'https://unstop.com/']
    ]
  ],
  [
    'id'       => 'food',
    'title'    => 'Food & Beverage Partners',
    'size'     => 'md',
    'slots'    => 0,
    'cta'      => 'Become a Food Partner',
    'tag'      => 'Keeping festival delegates and attendees energized throughout UDGAM.',
    'sponsors' => [
      ['name'=>"Domino's Pizza", 'logo'=>'uploads/sponsors/dominos_logo.png', 'url'=>'https://www.dominos.co.in/'],
      ['name'=>'The Waffle Stop', 'logo'=>'uploads/sponsors/waffle_stop_logo.png', 'url'=>'']
    ]
  ],
  [
    'id'       => 'media_hospitality',
    'title'    => 'Media & Hospitality Partners',
    'size'     => 'md',
    'slots'    => 0,
    'cta'      => 'Become a Partner',
    'tag'      => 'Broadcasting festival stories and welcoming our guests in the hills of Sikkim.',
    'sponsors' => [
      ['name'=>'Sikkim Express', 'logo'=>'uploads/sponsors/sikkim_express_logo.png', 'url'=>'https://www.sikkimexpress.com/'],
      ['name'=>'Ravongla Star', 'logo'=>'uploads/sponsors/ravongla_star_logo.png', 'url'=>'https://www.facebook.com/ravongla/'],
      ['name'=>'The Alnus Ravangla', 'logo'=>'uploads/sponsors/alnus_ravangla_logo.png', 'url'=>'https://www.facebook.com/thealnus.ravangla/']
    ]
  ]
];

function h(string $v): string { return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function bloom(string $cls): string {
  $o = '<svg class="bloom '.$cls.'" viewBox="-112 -112 224 224" aria-hidden="true"><g class="spin"><g class="pt" style="--i:4"><use href="#lv"/></g>';
  foreach (['pb','pp','pr','pa'] as $i => $p) $o .= '<g class="pt" style="--i:'.$i.'"><use href="#'.$p.'"/></g>';
  return $o.'</g><circle r="21" fill="url(#gs)" stroke="#fff" stroke-width="2.6"/><circle r="23.8" fill="none" stroke="#ff9db8" stroke-opacity=".75" stroke-width="1.1"/></svg>';
}
require __DIR__ . '/includes/header.php';
?>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs><linearGradient id="gb" x1="0" y1="1" x2="0" y2="0"><stop offset="0" stop-color="#1e66c0"/><stop offset="1" stop-color="#2cc0d8"/></linearGradient><linearGradient id="gp" x1="0" y1="1" x2="0" y2="0"><stop offset="0" stop-color="#d23fb2"/><stop offset="1" stop-color="#7d1fa8"/></linearGradient><linearGradient id="gr" x1="0" y1="1" x2="0" y2="0"><stop offset="0" stop-color="#ea2f4c"/><stop offset="1" stop-color="#bd1238"/></linearGradient><linearGradient id="ga" x1="0" y1="1" x2="0" y2="0"><stop offset="0" stop-color="#ffc928"/><stop offset="1" stop-color="#f07a10"/></linearGradient><linearGradient id="gs" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#f5a21c"/><stop offset="1" stop-color="#fff3c2"/></linearGradient><g id="sk"><g fill="#ffe0ec"><circle cx="0" cy="-3" r="2.7"/><circle cx="2.9" cy="-.9" r="2.7"/><circle cx="1.8" cy="2.4" r="2.7"/><circle cx="-1.8" cy="2.4" r="2.7"/><circle cx="-2.9" cy="-.9" r="2.7"/></g><circle r="1.3" fill="#e24a6f"/></g><clipPath id="cb"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z"/></clipPath><g id="pb"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" fill="url(#gb)"/><g clip-path="url(#cb)"><path d="M-24 -26L-6 -54L2 -46L12 -60L38 -30Z" fill="#1c4f9f"/><path d="M-6 -54l5 8-4-2-3 3zM12 -60l6 9-4-2-4 4z" fill="#e8f6ff"/><path d="M-14 -26L8 -46L20 -34L30 -40L42 -26Z" fill="#2e86d4"/><path d="M12 -82q2-5 8-4 3-5 10-1 6-1 4 4z" fill="#fff"/><path d="M-16 -50q2-4 7-3 3-4 8 0z" fill="#e7f6ff" opacity=".8"/></g><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" fill="none" stroke="#fff" stroke-width="2.4" stroke-linejoin="round"/><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform=" scale(.93)" fill="none" stroke="#fff" stroke-opacity=".45" stroke-width=".9"/></g><clipPath id="cp"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(-90)"/></clipPath><g id="pp"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(-90)" fill="url(#gp)"/><g clip-path="url(#cp)"><use href="#sk" transform="translate(-62 -14) scale(1.15)"/><use href="#sk" transform="translate(-47 -27) scale(0.95)"/><use href="#sk" transform="translate(-72 2) scale(0.75)"/><use href="#sk" transform="translate(-42 -7) scale(0.75)"/><use href="#sk" transform="translate(-55 5) scale(0.6)"/></g><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(-90)" fill="none" stroke="#fff" stroke-width="2.4" stroke-linejoin="round"/><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(-90) scale(.93)" fill="none" stroke="#fff" stroke-opacity=".45" stroke-width=".9"/></g><clipPath id="cr"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(180)"/></clipPath><g id="pr"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(180)" fill="url(#gr)"/><g clip-path="url(#cr)"><circle cx="-6" cy="42" r="3.2" fill="#7a0c26"/><path d="M-8 46C-2 45 2 50 4 56L12 82L-28 82L-17 62Z" fill="#7a0c26"/><path d="M-4 47L4 36M-12 50L-25 56" stroke="#7a0c26" stroke-width="2" stroke-linecap="round" fill="none"/></g><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(180)" fill="none" stroke="#fff" stroke-width="2.4" stroke-linejoin="round"/><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(180) scale(.93)" fill="none" stroke="#fff" stroke-opacity=".45" stroke-width=".9"/></g><clipPath id="ca"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(90)"/></clipPath><g id="pa"><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(90)" fill="url(#ga)"/><g clip-path="url(#ca)"><g fill="none" stroke="#c4271b" stroke-width="1.2"><circle cx="52" cy="6" r="11"/><path d="M52 -5V17M41 6H63M44 -2L60 14M60 -2L44 14M52 6L45 25M52 6L59 25"/></g><circle cx="52" cy="6" r="1.8" fill="#c4271b"/><path d="M63 27L76 12L89 27Z" fill="#d6361f"/><path d="M76 12V5l5 2-5 2" fill="#c4271b" stroke="#c4271b" stroke-width=".8"/></g><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(90)" fill="none" stroke="#fff" stroke-width="2.4" stroke-linejoin="round"/><path d="M-26 -3C-38 -40 -14 -78 30 -96C47 -70 47 -34 6 -22C-4 -20 -18 -16 -26 -3Z" transform="rotate(90) scale(.93)" fill="none" stroke="#fff" stroke-opacity=".45" stroke-width=".9"/></g><g id="lv"><path d="M59.7 -57.7A83 83 0 0 1 81.2 -17.3" transform="rotate(0)" stroke="#e8386d" stroke-width="1.6" fill="none" stroke-linecap="round"/><path d="M59.7 -57.7A83 83 0 0 1 81.2 -17.3" transform="rotate(90)" stroke="#e8386d" stroke-width="1.6" fill="none" stroke-linecap="round"/><path d="M59.7 -57.7A83 83 0 0 1 81.2 -17.3" transform="rotate(180)" stroke="#e8386d" stroke-width="1.6" fill="none" stroke-linecap="round"/><path d="M59.7 -57.7A83 83 0 0 1 81.2 -17.3" transform="rotate(270)" stroke="#e8386d" stroke-width="1.6" fill="none" stroke-linecap="round"/><g transform="rotate(51) translate(0 -85)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(73) translate(0 -88)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(141) translate(0 -85)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(163) translate(0 -88)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(231) translate(0 -85)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(253) translate(0 -88)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(321) translate(0 -85)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g><g transform="rotate(343) translate(0 -88)"><path d="M0 0C4.5 -5 5 -13 0 -19C-5 -13 -4.5 -5 0 0Z" fill="#e8386d"/><path d="M0 -1V-14" stroke="#ff9bb8" stroke-width=".6" opacity=".75"/></g></g></defs></svg>
<div id="prog"></div>
<canvas id="petalfx" aria-hidden="true"></canvas><div class="bokeh" id="bokeh" aria-hidden="true"></div><div class="brn l" id="brl" aria-hidden="true"></div><div class="brn r" id="brr" aria-hidden="true"></div>
<button class="mode mode-float" id="mode" type="button" aria-label="Switch to night mode" aria-pressed="false"><svg class="mn" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 14.6A8.5 8.5 0 0 1 9.4 3.5a8.5 8.5 0 1 0 11.1 11.1z"/></svg><svg class="sn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4.2" fill="currentColor"/><path d="M12 2.5v2.4M12 19.1v2.4M2.5 12h2.4M19.1 12h2.4M5.3 5.3l1.7 1.7M17 17l1.7 1.7M5.3 18.7L7 17M17 7l1.7-1.7"/></svg></button>
<main id="main">
<section class="hero" id="top">
  <div class="hero-bg" id="hbg"><div class="stage" aria-hidden="true">
    <div class="base"></div><canvas id="wfcv" aria-hidden="true"></canvas><div class="aura"></div><div class="rayw"><div class="rays"></div></div><canvas id="skyfx" aria-hidden="true"></canvas>
    <div class="plate"></div><div class="dmove">
      <div class="layer dbody"></div>
      <div class="dp t"><div class="layer dtail"></div></div>
      <div class="dp h"><div class="layer dhead"></div><span class="eye"></span><svg class="lid" viewBox="0 0 60 30" aria-hidden="true"><defs><radialGradient id="lg"><stop offset="0" stop-color="#ecd7e0"/><stop offset=".7" stop-color="#e9d2dc"/><stop offset="1" stop-color="#e9d2dc" stop-opacity="0"/></radialGradient></defs><ellipse cx="30" cy="15" rx="29" ry="14" fill="url(#lg)"/><path d="M7 11Q30 29 53 11" fill="none" stroke="#6b2a4a" stroke-width="2.6" stroke-linecap="round"/><path d="M15 17l-3 4M24 20l-1.5 4.5M34 20l1.5 4.5M44 17l3 4" stroke="#6b2a4a" stroke-width="1.5" stroke-linecap="round"/></svg><i class="mist" style="--d:0s"></i><i class="mist" style="--d:2s"></i><i class="mist" style="--d:4s"></i></div>
      <div id="sparks"></div>
    </div><div class="nt nt1"></div><div class="nt nt2"></div><div class="nt nsun"></div><div class="moon"></div><div class="fm" aria-hidden="true"><i class="ring"></i><i class="d"></i><i class="wp" style="top:22%;--w:-6s"></i><i class="wp" style="top:56%;--w:-17s"></i></div><div class="dr" aria-hidden="true"><i style="--d:0s;left:0;top:0;width:.55cqw;height:.55cqw"></i><i style="--d:.8s;left:.9cqw;top:-1.5cqw;width:.9cqw;height:.9cqw"></i><i style="--d:1.6s;left:2cqw;top:-3.3cqw;width:1.3cqw;height:1.3cqw"></i><i style="--d:2.4s;left:3.4cqw;top:-8.4cqw;width:3.6cqw;height:3.6cqw"><b>&#10047;</b></i></div><canvas id="litfx" aria-hidden="true"></canvas><div class="zz" aria-hidden="true"><i style="--k:0">z</i><i style="--k:1">Z</i><i style="--k:2">z</i></div></div></div><div class="sunrise"></div>
  <div class="w hero-in">
    <img class="logo up" src="assets/img/sponsors/hero-logo.webp" width="260" height="146" alt="UDGAM 2K26" style="--d:.1s">
    <p class="kick up" style="--d:.3s;margin:6px 0 0">Our Partners</p>
    <h1 class="h" id="h1" aria-label="Our Grand Sponsors">Our Grand Sponsors</h1>
    <p class="script up" style="--d:1s">With heartfelt gratitude, we celebrate the partners who help UDGAM 2K26 bloom.</p>
  </div>
</section>
<section class="sponsors" id="sponsors"><div class="w">
<?php foreach($tiers as $t): $n=count($t['sponsors']); ?>
<div class="tier" id="t-<?= h($t['id']) ?>"><div class="th rv"><h2><?= h($t['title']) ?></h2><div class="div"><i></i><?= bloom('mini') ?><i></i></div><p><?= h($t['tag']) ?></p></div>
<div class="sgrid <?= h($t['size']) ?>">
<?php if($n): foreach($t['sponsors'] as $i=>$sp): ?>
<div class="sc rv" style="--d:<?= $i*0.1 ?>s"><?php if(!empty($sp['url'])): ?><a class="pl" href="<?= h($sp['url']) ?>" target="_blank" rel="noopener" aria-label="<?= h($sp['name']) ?>"><?php else: ?><div class="pl" aria-label="<?= h($sp['name']) ?>"><?php endif; ?><?php if(!empty($sp['logo'])): ?><img src="<?= h($sp['logo']) ?>" alt="<?= h($sp['name']) ?>" loading="lazy" decoding="async"><?php else: ?><span class="nm"><?= h($sp['name']) ?></span><?php endif; ?><?= !empty($sp['url']) ? '</a>' : '</div>' ?></div>
<?php endforeach; else: for($i=0;$i<$t['slots'];$i++): ?>
<div class="sc rv" style="--d:<?= $i*0.1 ?>s"><a class="pl slot" href="contact.php" aria-label="Become our <?= h($t['title']) ?>"><?= bloom('bud') ?><b>Your brand here</b><small style="color:var(--mu)"><?= h($t['cta']) ?></small></a></div>
<?php endfor; endif; ?>
</div></div>
<?php endforeach; ?>
</div></section>
</main>
<script>
(function(){
var $=function(s,c){return(c||document).querySelector(s)},$$=function(s,c){return[].slice.call((c||document).querySelectorAll(s))};
var reduce=matchMedia('(prefers-reduced-motion: reduce)').matches,touch=matchMedia('(hover:none)').matches;
/* headline: split into letters */
var h=$('#h1');if(h&&!reduce){var t=h.textContent,i=0;h.textContent='';t.split(' ').forEach(function(w){var s=document.createElement('span');s.className='wd';s.setAttribute('aria-hidden','true');
  w.split('').forEach(function(c){var l=document.createElement('span');l.className='ch';l.style.setProperty('--i',i++);l.textContent=c;s.appendChild(l)});h.appendChild(s)})}
/* nav + progress + parallax + bloom-on-scroll */
var nav=$('#nav'),links=$('#links'),burger=$('#burger'),prog=$('#prog'),bg=$('#hbg'),join=$('#join'),logo=$('.hero .logo');
var wy=0,wind=0,lastY=scrollY,hero=$('#top');
function fit(){bg.style.setProperty('--hh',hero.offsetHeight*1.1+'px')}fit();addEventListener('resize',fit);
function onScroll(){var y=scrollY,max=document.documentElement.scrollHeight-innerHeight;
  if(nav)nav.classList.toggle('sc',y>30);prog.style.transform='scaleX('+(max>0?y/max:0)+')';
  if(join){var r=join.getBoundingClientRect(),p=1-Math.max(0,Math.min(1,(r.top-innerHeight*.15)/(innerHeight*.7)));join.style.setProperty('--bp',p.toFixed(3))}
  wind+=(y-lastY)*.04;lastY=y}
addEventListener('scroll',onScroll,{passive:true});onScroll();
if(burger)burger.addEventListener('click',function(){var o=links.classList.toggle('open');burger.setAttribute('aria-expanded',o)});
if(burger)document.addEventListener('keydown',function(e){if(e.key==='Escape'){links.classList.remove('open');burger.setAttribute('aria-expanded','false')}});
/* reveal */
var rv=$$('.rv');
if('IntersectionObserver' in window&&!reduce){var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}})},{threshold:.15});rv.forEach(function(r){io.observe(r)})}
else rv.forEach(function(r){r.classList.add('in')});
if(reduce)return;
/* dragon sparkles drifting off its body */
var sk=$('#sparks');for(var q=0;q<22;q++){var s=document.createElement('i');s.className='sp';s.style.setProperty('--x',(12+Math.random()*26)+'%');s.style.setProperty('--y',(10+Math.random()*55)+'%');s.style.setProperty('--s',(.35+Math.random()*.5)+'%');s.style.setProperty('--t',(3+Math.random()*4)+'s');s.style.setProperty('--d',(-Math.random()*7)+'s');sk.appendChild(s)}
/* card tilt + spotlight */
$$('.pl').forEach(function(c){
  c.addEventListener('pointermove',function(e){if(e.pointerType==='touch')return;var r=c.getBoundingClientRect(),x=(e.clientX-r.left)/r.width,y=(e.clientY-r.top)/r.height;
    c.style.setProperty('--mx',x*100+'%');c.style.setProperty('--my',y*100+'%');c.style.setProperty('--ry',((x-.5)*12).toFixed(2)+'deg');c.style.setProperty('--rx',((.5-y)*10).toFixed(2)+'deg')});
  c.addEventListener('pointerleave',function(){c.style.setProperty('--rx','0deg');c.style.setProperty('--ry','0deg')});
  c.addEventListener('click',function(e){burst(e.clientX||innerWidth/2,e.clientY||innerHeight/2)});
});
function burst(x,y){for(var i=0;i<12;i++){var p=document.createElement('span'),a=Math.random()*6.283,d=50+Math.random()*90;p.className='bp';p.style.left=x+'px';p.style.top=y+'px';
  p.style.setProperty('--x',Math.cos(a)*d+'px');p.style.setProperty('--y',(Math.sin(a)*d-30)+'px');p.style.setProperty('--r',(Math.random()*540-270)+'deg');p.style.width=(8+Math.random()*8)+'px';p.style.height=(10+Math.random()*10)+'px';
  document.body.appendChild(p);setTimeout(function(q){q.remove()}.bind(null,p),1150)}}
/* 3D waterfall: one canvas, 3 depth layers + foam, ripples, spray and mist. Runs only while the hero is on screen */
(function(){var cv=$('#wfcv');if(!cv)return;
var c=cv.getContext('2d'),BX=29,BY=55,BW=42,BH=27,small=innerWidth<700,R=1,CW=0,CH=0,t=0,last=0,run=false,vis=true,inView=true;
var D=[[34.3,59.6,2.6,10,7,1],[43.6,63,2.3,11,6,1.2],[60,70,4.4,8.5,6.5,1.4],[66,64,3.6,6.5,7,1],[57.2,71.5,1.4,7.5,8,.8]];
function spr(r,g,b){var s=document.createElement('canvas');s.width=s.height=64;var q=s.getContext('2d'),gr=q.createRadialGradient(32,32,0,32,32,32);
  gr.addColorStop(0,'rgba('+r+','+g+','+b+',1)');gr.addColorStop(.35,'rgba('+r+','+g+','+b+',.45)');gr.addColorStop(1,'rgba('+r+','+g+','+b+',0)');q.fillStyle=gr;q.fillRect(0,0,64,64);return s}
var SW=spr(255,255,255),SP=spr(255,205,228),SB=spr(150,200,255);
var L=[{w:.8,a:.34,sp:.85,wd:.85,n:small?9:14,c:'rgb(150,198,255)'},{w:1,a:.5,sp:1,wd:1.05,n:small?9:14,c:'rgb(226,240,255)'},{w:1.2,a:.62,sp:1.22,wd:1.4,n:small?8:12,c:'rgb(255,246,250)'}],WARM='rgb(255,216,178)';
var F=D.map(function(d,k){var f={x:d[0],y:d[1],w:d[2],h:d[3],loop:d[4],m:d[5],o:k*.7,sa:0,pt:[],st:[]};
  L.forEach(function(l){var a=[];for(var i=0;i<l.n;i++){var xn=(i+.1+Math.random()*.8)/l.n;a.push({xn:xn,ph:Math.random(),pw:.75+Math.random()*.6,edge:Math.pow(Math.sin(Math.PI*xn),.55),warm:xn>.8})}f.st.push(a)});return f});
function rs(){var w=cv.clientWidth,h=cv.clientHeight;if(!w||!h)return;R=Math.min(devicePixelRatio||1,small?1.5:2);cv.width=Math.round(w*R);cv.height=Math.round(h*R);CW=w;CH=h;
  F.forEach(function(f){f.px=(f.x-BX)/BW*CW;f.py=(f.y-BY)/BH*CH;f.pw=f.w/BW*CW;f.ph=f.h/BH*CH})}
function spawn(f,base){var p=null,i;for(i=0;i<f.pt.length;i++)if(f.pt[i].t>=1){p=f.pt[i];break}
  if(!p){if(f.pt.length>(small?10:20))return;p={};f.pt.push(p)}
  p.t=0;p.L=.9+Math.random()*1.1;p.x=f.px+f.pw*(.15+Math.random()*.7);p.y=base;p.vx=(Math.random()-.4)*f.pw*.9;p.vy=-f.ph*(.3+Math.random()*.45);p.s=Math.max(3,f.pw*(.08+Math.random()*.12))}
function draw(dt){c.setTransform(1,0,0,1,0,0);c.clearRect(0,0,cv.width,cv.height);c.setTransform(R,0,0,R,0,0);c.globalCompositeOperation='lighter';
  F.forEach(function(f){var cx=f.px+f.pw/2,base=f.py+f.ph,li,i,s,p,u,y,len,fade,x,w,cur='';
    c.globalAlpha=.16;c.drawImage(SB,f.px-f.pw*.5,f.py-f.ph*.05,f.pw*2,f.ph*1.1);c.globalAlpha=.1;c.drawImage(SW,f.px-f.pw*.2,f.py,f.pw*1.4,f.ph);
    for(li=0;li<3;li++){var Ly=L[li],sw=Math.sin(t*.8+f.o*3+li*1.7)*f.pw*.035*(li+1)+Math.sin(t*1.9+li)*f.pw*.01,arr=f.st[li];
      for(i=0;i<arr.length;i++){s=arr[i];p=(t*Ly.sp/f.loop+s.ph)%1;u=Math.pow(p,1.55);y=f.py+u*f.ph*.92;len=f.ph*(.12+.34*p)*s.pw;
        if(y+len>base)len=base-y;if(len<1)continue;fade=Math.min(1,p*7)*Math.min(1,(1-p)*4);
        var col=s.warm&&li>0?WARM:Ly.c;if(col!==cur){c.fillStyle=col;cur=col}
        x=cx+(s.xn-.5)*f.pw*Ly.w+sw;w=Math.max(.7,f.pw*.02*Ly.wd*s.pw);c.globalAlpha=Ly.a*s.edge*fade;c.fillRect(x-w/2,y,w,len)}}
    var gs=Math.max(4,f.pw*.14);for(i=0;i<3;i++){var gp=(t*.35+i*.33+f.o)%1;c.globalAlpha=.6*Math.sin(gp*Math.PI)*(.6+.4*Math.sin(t*9+i*2));c.drawImage(SW,cx+Math.sin(t*.7+i*2+f.o)*f.pw*.3-gs/2,f.py+gp*f.ph-gs/2,gs,gs)}
    c.globalAlpha=.5;c.drawImage(SW,cx-f.pw*.65,f.py-f.pw*.1,f.pw*1.3,f.pw*.35);
    for(i=0;i<3;i++){var pu=.8+.2*Math.sin(t*2.3+i+f.o);c.globalAlpha=.4*pu;c.drawImage(SW,cx+(i-1)*f.pw*.35-f.pw*.5*pu,base-f.pw*.14,f.pw*pu,f.pw*.34*pu)}
    var rp=(t*.5+f.o)%1;c.globalAlpha=.11*(1-rp)*Math.min(1,rp*6);c.strokeStyle='rgb(255,235,245)';c.lineWidth=1.5;c.beginPath();c.ellipse(cx,base+f.pw*.05,f.pw*(.4+rp*.9),f.pw*(.08+rp*.2),0,0,6.283);c.stroke();
    f.sa+=dt*(small?8:15)*f.m;while(f.sa>=1){f.sa--;spawn(f,base-f.pw*.05)}
    var g=f.ph*.9;for(i=0;i<f.pt.length;i++){p=f.pt[i];if(p.t>=1)continue;p.t+=dt/p.L;p.x+=p.vx*dt;p.vy+=g*dt;p.y+=p.vy*dt;if(p.t>=1)continue;
      c.globalAlpha=.65*(1-p.t);var sz=p.s*(1+p.t*1.4);c.drawImage(SW,p.x-sz/2,p.y-sz/2,sz,sz)}
    for(i=0;i<3;i++){var mp=(t/7+i/3+f.o*.1)%1,ms=f.pw*(2+mp*2.2)*Math.sqrt(f.m);c.globalAlpha=.24*Math.sin(mp*Math.PI);
      c.drawImage(SP,cx+(mp-.35)*f.pw*3.2+Math.sin(t*.5+i)*f.pw*.3-ms/2,base-f.ph*.04-mp*f.ph*.2-ms*.3,ms,ms*.6)}});
  c.globalAlpha=1;c.globalCompositeOperation='source-over'}
function go(){var ok=vis&&inView;if(ok&&!run){run=true;last=performance.now();requestAnimationFrame(frame)}else if(!ok)run=false}
function frame(now){if(!run)return;requestAnimationFrame(frame);var dt=(now-last)/1000;if(dt<(small?.033:.014))return;last=now;dt=Math.min(dt,.05);t+=dt;if(CW)draw(dt)}
rs();if('ResizeObserver' in window)new ResizeObserver(rs).observe(cv);else addEventListener('resize',rs);
if('IntersectionObserver' in window)new IntersectionObserver(function(e){inView=e[0].isIntersecting;go()}).observe(hero);
document.addEventListener('visibilitychange',function(){vis=!document.hidden;go()});go()})();
/* HD sky layer: bird flocks (V-formation, flap + glide), sun flare, water glints, lantern flicker, mist, pointer + scroll parallax */
(function(){var cv=$('#skyfx');if(!cv)return;var NT=function(){return window.__nt||0};
var st=cv.parentNode,bg=$('#hbg'),c=cv.getContext('2d'),small=innerWidth<700,W=0,H=0,R=1,t=0,last=0,run=false,vis=true,inView=true,tx=0,ty=0,cx=0,cy=0,TAU=6.2832;
function spr(r,g,b){var s=document.createElement('canvas');s.width=s.height=128;var q=s.getContext('2d'),gr=q.createRadialGradient(64,64,0,64,64,64);
  gr.addColorStop(0,'rgba('+r+','+g+','+b+',1)');gr.addColorStop(.3,'rgba('+r+','+g+','+b+',.4)');gr.addColorStop(1,'rgba('+r+','+g+','+b+',0)');q.fillStyle=gr;q.fillRect(0,0,128,128);return s}
var WARM=spr(255,214,160),PINK=spr(255,175,210),WH=spr(255,255,255);
function rs(){var w=cv.clientWidth,h=cv.clientHeight;if(!w||!h)return;R=Math.min(devicePixelRatio||1,2);cv.width=Math.round(w*R);cv.height=Math.round(h*R);W=w;H=h}
function sm(a,b,x){x=Math.max(0,Math.min(1,(x-a)/(b-a)));return x*x*(3-2*x)}
/* birds */
var fl=[];
function mkFlock(init){var r=Math.random(),n=r<.2?1:r<.35?2+(Math.random()*2|0):(small?4:5)+(Math.random()*(small?2:5)|0),d=Math.random(),dir=Math.random()<.72?1:-1;
  var f={dir:dir,d:d,x:init?-.1+Math.random()*1.2:(dir>0?-.12:1.12),y:.08+Math.random()*.3,v:(.012+.012*d)*(.92+Math.random()*.16),ph:Math.random()*TAU,s:.0042+.0062*d,b:[]};
  for(var k=0;k<n;k++){var row=(k+1)>>1,sd=k%2?1:-1;f.b.push({bx:k?-row*2.3:0,by:k?sd*row*1.5:0,fp:k*.07,fr:TAU*1.45,j:Math.random()*TAU})}
  return f}
for(var i=0;i<(small?5:11);i++)fl.push(mkFlock(true));
function bird(x,y,s,a1,a2,rot,dir,col,rim){c.save();c.translate(x,y);c.rotate(rot);c.fillStyle=col;
  for(var sd=-1;sd<2;sd+=2){c.save();c.scale(sd,1);var ex=s*.5,ey=-a1*s*.34,tx=s*1.05,ty=-a2*s*.78+s*.08;
    c.beginPath();c.moveTo(0,-s*.04);c.quadraticCurveTo(ex*.55,ey-s*.2,ex,ey-s*.04);c.quadraticCurveTo((ex+tx)*.5,(ey+ty)*.5-s*.14,tx,ty);
    c.quadraticCurveTo((ex+tx)*.5+s*.02,(ey+ty)*.5+s*.02,ex*.85,ey+s*.17);c.quadraticCurveTo(ex*.35,ey*.4+s*.16,0,s*.12);c.closePath();c.fill();
    if(rim){c.strokeStyle='rgba(255,178,208,.42)';c.lineWidth=Math.max(.5,s*.04);c.stroke()}c.restore()}
  c.beginPath();c.ellipse(dir*s*.03,s*.06,s*.22,s*.07,0,0,TAU);c.fill();c.beginPath();c.arc(dir*s*.24,s*.03,s*.05,0,TAU);c.fill();c.restore()}
function birds(dt){var bn=NT();if(bn>.3)return;c.globalAlpha=1-bn/.3;fl.sort(function(a,b){return a.d-b.d});
  for(var i=0;i<fl.length;i++){var f=fl[i];f.x+=f.dir*f.v*dt;if((f.dir>0&&f.x>1.14)||(f.dir<0&&f.x<-.14)){fl[i]=mkFlock(false);continue}
    var s=f.s*W,d=f.d,col='rgba('+(96-66*d|0)+','+(80-62*d|0)+','+(138-86*d|0)+','+(.72+.26*d).toFixed(2)+')',
      gl=sm(.25,.8,Math.sin(t*.3+f.ph)),fy=(f.y+Math.sin(t*.3+f.ph)*.016)*H,bank=Math.sin(t*.5+f.ph)*.04;
    for(var k=0;k<f.b.length;k++){var b=f.b[k],p=t*b.fr*(1-.45*gl)+b.fp*TAU,A=1-.78*gl,
      a1=Math.sin(p)*A+.2*gl,a2=Math.sin(p-.95)*A+.1*gl,
      x=f.x*W+f.dir*b.bx*s*1.6+Math.sin(t*1.1+b.j)*s*.05,y=fy+b.by*s*1.1+Math.sin(t*1.7+b.j)*s*.04-Math.sin(p)*s*.05*A;
      bird(x,y,s,a1,a2,bank+Math.sin(t*.8+b.j)*.015,f.dir,col,d>.55)}}}
/* sparkle layers */
var G=[],LAN=[[.051,.262],[.041,.696]],MI=[];
for(i=0;i<(small?16:34);i++)G.push({x:Math.random()<.5?.72+Math.random()*.2:.3+Math.random()*.7,y:.855+Math.random()*.135,s:.002+Math.random()*.004,sp:.8+Math.random()*2.2,ph:Math.random()*TAU});
for(i=0;i<5;i++)MI.push({x:Math.random(),y:.76+Math.random()*.1,sp:.004+Math.random()*.006,s:.2+Math.random()*.22});
function fx(){c.globalCompositeOperation='lighter';var i,g,a,z,pu=.5+.5*Math.sin(t*1.3),sx=W*.847,sy=H*.465;
  c.globalAlpha=(.3+.2*pu)*(1-NT());c.drawImage(WARM,sx-W*.1,sy-W*.1,W*.2,W*.2);c.globalAlpha=(.2+.18*pu)*(1-NT());c.drawImage(WARM,sx-W*.2,sy-H*.007,W*.4,H*.014);
  for(i=0;i<G.length;i++){g=G[i];a=Math.pow(Math.max(0,Math.sin(t*g.sp+g.ph)),8);if(a<.03)continue;z=g.s*W;var gx=(g.x+Math.sin(t*.2+g.ph)*.004)*W,gy=g.y*H;
    c.globalAlpha=a*.85;c.drawImage(WH,gx-z,gy-z,z*2,z*2);c.globalAlpha=a*.7;c.fillStyle='#fff';c.fillRect(gx-z*1.8,gy-.5,z*3.6,1);c.fillRect(gx-.5,gy-z,1,z*2)}
  for(i=0;i<2;i++){var f=.55+.22*Math.sin(t*7.3+i*3)+.15*Math.sin(t*13.1+i)+.08*Math.sin(t*23+i*5);z=W*.032;c.globalAlpha=.32*f*(1-NT());c.drawImage(WARM,LAN[i][0]*W-z,LAN[i][1]*H-z,z*2,z*2)}
  for(i=0;i<MI.length;i++){var m=MI[i],mp=(t*m.sp+m.x)%1;c.globalAlpha=.12*Math.sin(mp*Math.PI);c.drawImage(i%2?PINK:WH,(mp*1.5-.25)*W-m.s*W/2,m.y*H,m.s*W,m.s*W*.2)}
  c.globalAlpha=1;c.globalCompositeOperation='source-over'}
function frame(now){if(!run)return;requestAnimationFrame(frame);var dt=Math.min((now-last)/1000,.05);last=now;t+=dt;if(!W)return;
  c.setTransform(1,0,0,1,0,0);c.clearRect(0,0,cv.width,cv.height);c.setTransform(R,0,0,R,0,0);
  birds(dt);fx();if(window.__lit)window.__lit(t);
  var k=Math.min(1,dt*3);cx+=(tx-cx)*k;cy+=(ty-cy)*k;st.style.transform='translate3d('+(-cx*18).toFixed(2)+'px,'+(-cy*10).toFixed(2)+'px,0) scale(1.035)';
  bg.style.transform='translate3d(0,'+(Math.min(scrollY,innerHeight*1.2)*.12).toFixed(1)+'px,0)'}
function go(){var ok=vis&&inView;if(ok&&!run){run=true;last=performance.now();requestAnimationFrame(frame)}else if(!ok)run=false}
addEventListener('pointermove',function(e){if(e.pointerType==='touch')return;tx=e.clientX/innerWidth-.5;ty=e.clientY/innerHeight-.5},{passive:true});
rs();if('ResizeObserver' in window)new ResizeObserver(rs).observe(cv);else addEventListener('resize',rs);
if('IntersectionObserver' in window)new IntersectionObserver(function(e){inView=e[0].isIntersecting;go()}).observe($('#top'));
document.addEventListener('visibilitychange',function(){vis=!document.hidden;go()});go()})();
/* falling cherry-blossom petals (one canvas, one loop). Drawn BEHIND page content and only BELOW the hero — the dragon hero gets none. */
var cv=$('#petalfx'),x=cv.getContext('2d'),W,H,P=[],N=innerWidth<640?24:52,mw=0,vis=true,SPR=[];
function rs(){var d=Math.min(devicePixelRatio||1,2);W=innerWidth;H=innerHeight;cv.width=W*d;cv.height=H*d;x.setTransform(d,0,0,d,0,0)}rs();addEventListener('resize',rs);
function mkSpr(c1,c2,soft){var S=64,o=document.createElement('canvas');o.width=o.height=S;var g=o.getContext('2d'),s=24,gr;g.translate(S/2,S/2);
  gr=g.createLinearGradient(0,-s,0,s);gr.addColorStop(0,c1);gr.addColorStop(1,c2);g.fillStyle=gr;
  g.beginPath();g.moveTo(0,-s);g.bezierCurveTo(s*.9,-s*.7,s*.8,s*.6,0,s);g.bezierCurveTo(-s*.8,s*.6,-s*.9,-s*.7,0,-s);g.fill();
  for(var i=0;i<soft;i++){var k=document.createElement('canvas');k.width=k.height=S/3;var q=k.getContext('2d');q.imageSmoothingQuality='high';q.drawImage(o,0,0,S/3,S/3);g.setTransform(1,0,0,1,0,0);g.clearRect(0,0,S,S);g.drawImage(k,0,0,S,S)}return o}
[['#ffe3ee','#ff9ec4'],['#ffd0e2','#ff6fa6'],['#e6eeff','#8fb0ff'],['#cddcff','#5f8cff']].forEach(function(c,i){SPR[i]=[mkSpr(c[0],c[1],0),mkSpr(c[0],c[1],1),mkSpr(c[0],c[1],2)]});
function mk(init){var r=Math.random(),d=r<.4?0:r<.85?1:2; /* far / mid / near: size, opacity, speed and softness differ by depth */
  return{x:Math.random()*W,y:init?Math.random()*H:-30,d:d,s:d==0?7+Math.random()*5:d==1?11+Math.random()*7:20+Math.random()*10,vy:(d==0?.35:d==1?.6:.95)+Math.random()*.5,
    ph:Math.random()*6.28,sp:.008+Math.random()*.018,r:Math.random()*6.28,vr:(Math.random()-.5)*.03,f:Math.random()*6.28,
    a:d==0?.3+Math.random()*.25:d==1?.55+Math.random()*.25:.3+Math.random()*.2,b:d==0?1:d==1?0:2,c:Math.random()<.5?0:1}}
for(var k=0;k<N;k++)P.push(mk(true));
addEventListener('pointermove',function(e){if(e.movementX)mw+=e.movementX*.012});
document.addEventListener('visibilitychange',function(){vis=!document.hidden});
var pOn=false,bk=$('#bokeh'),b1=$('#brl'),b2=$('#brr'),hb=hero.getBoundingClientRect().bottom;
function updateHb(){hb=hero.getBoundingClientRect().bottom}
addEventListener('scroll',updateHb,{passive:true});addEventListener('resize',updateHb);
var lt=performance.now();(function loop(now){requestAnimationFrame(loop);var dt=Math.min(3,(now-lt)/16.7||1);lt=now;if(!vis)return;
  var on=hb<H*.92;if(on!==pOn){pOn=on;bk.classList.toggle('on',on);b1.classList.toggle('on',on);b2.classList.toggle('on',on)}if(hb>=H-2){x.clearRect(0,0,W,H);return} /* hero fills the screen → no petals */
  x.clearRect(0,0,W,H);wind*=Math.pow(.96,dt);mw*=Math.pow(.95,dt);var wd=wind+mw,top=Math.max(0,hb);
  P.forEach(function(p,i){p.ph+=p.sp*dt;p.f+=.05*dt;p.r+=(p.vr+wd*.004)*dt;p.x+=(Math.sin(p.ph)*.7+.25+wd)*dt;p.y+=(p.vy+Math.max(0,wind)*.6)*dt;
    if(p.y>H+30||p.x>W+40||p.x<-60){P[i]=mk(false);if(Math.random()<.4)P[i].x=-20;return}
    var ef=Math.min(1,(p.y-top)/90);if(ef<=0)return;
    x.save();x.translate(p.x,p.y);x.rotate(p.r);x.scale(1,Math.cos(p.f)*.8+.2);var nt=window.__nt||0;if(nt<.99){x.globalAlpha=p.a*ef*(1-nt);x.drawImage(SPR[p.c][p.b],-p.s,-p.s,p.s*2,p.s*2)}if(nt>.01){x.globalAlpha=p.a*ef*nt;x.drawImage(SPR[p.c+2][p.b],-p.s,-p.s,p.s*2,p.s*2)}x.restore()})})(lt);
})();
</script>

<script>
/* NIGHT MODE: toggle, smooth day->night level (window.__nt), stars, lit windows, lanterns, moon streak */
(function(){var root=document.documentElement,btn=document.getElementById('mode'),meta=document.querySelector('meta[name=theme-color]'),
 rm=matchMedia('(prefers-reduced-motion: reduce)').matches,nt=root.getAttribute('data-mode')==='night'?1:0,target=nt,raf=0,last=0;window.__nt=nt;
function apply(){window.__nt=nt;root.style.setProperty('--nt',nt.toFixed(3));window.dispatchEvent(new Event('udgam-mode'))}
function step(now){var dt=Math.min(.05,(now-last)/1000||0);last=now;var d=target-nt;nt+=Math.sign(d)*Math.min(Math.abs(d),dt/1.8);apply();raf=nt===target?0:requestAnimationFrame(step)}
function set(n,save){target=n?1:0;root.setAttribute('data-mode',n?'night':'day');btn.setAttribute('aria-pressed',n?'true':'false');btn.setAttribute('aria-label',n?'Switch to day mode':'Switch to night mode');
 if(meta)meta.setAttribute('content',n?'#050b1f':'#0b1424');if(save){try{localStorage.setItem('udgam-mode',n?'night':'day')}catch(e){}}
 if(rm){nt=target;apply()}else if(!raf){last=performance.now();raf=requestAnimationFrame(step)}}
btn.addEventListener('click',function(){set(root.getAttribute('data-mode')!=='night',true)});
set(nt===1,false);nt=target;apply();
/* lights layer */
var cv=document.getElementById('litfx');if(!cv)return;var c=cv.getContext('2d'),W=0,H=0,R=1,TAU=6.2832;
function spr(r,g,b){var s=document.createElement('canvas');s.width=s.height=128;var q=s.getContext('2d'),gr=q.createRadialGradient(64,64,0,64,64,64);
 gr.addColorStop(0,'rgba('+r+','+g+','+b+',1)');gr.addColorStop(.3,'rgba('+r+','+g+','+b+',.4)');gr.addColorStop(1,'rgba('+r+','+g+','+b+',0)');q.fillStyle=gr;q.fillRect(0,0,128,128);return s}
var WARM=spr(255,190,100),ICE=spr(200,220,255),WH=spr(255,255,255);
function rs(){var w=cv.clientWidth,h=cv.clientHeight;if(!w||!h)return;R=Math.min(devicePixelRatio||1,2);cv.width=Math.round(w*R);cv.height=Math.round(h*R);W=w;H=h;if(rm)draw(0)}
function sm(x){x=Math.max(0,Math.min(1,x));return x*x*(3-2*x)}
var WIN=[[32.56,51.8],[33.2,52],[32.8,52.5],[34.8,58.3],[35.5,58.2],[36.3,58.3],[37.9,58.3],[38.9,58.2],[39.8,58],[41,54.6],[42.2,56.2],[41.15,56.9],[43.4,57.3],[40.5,53.4],[44.9,60.6],[46.2,60.8],[47.1,60.9],[48.2,60.7],[49.2,60.9],[79.3,57.4],[80,57.4],[80.7,57.4],[81.4,57.4],[82.2,57.4],[83,57.4],[83.9,57.4],[73.5,60.3],[74.9,60.2],[75.6,59.7],[76.4,59.7],[77,59.6]],
 LN=[[5.15,26.3],[4.1,69.6]],ST=[];
for(var i=0;i<110;i++){var x=.4+Math.random()*.59,y=.03+Math.random()*.37;if(x>.85&&y<.2)continue;ST.push({x:x,y:y,z:.0008+Math.pow(Math.random(),3)*.0028,sp:.6+Math.random()*2.4,ph:Math.random()*TAU})}
function draw(t){c.setTransform(1,0,0,1,0,0);c.clearRect(0,0,cv.width,cv.height);var n=window.__nt||0;if(n<.01||!W)return;
 c.setTransform(R,0,0,R,0,0);c.globalCompositeOperation='lighter';var i,a,z,k,fi=sm((n-.4)/.5);
 for(i=0;i<ST.length;i++){k=ST[i];a=(.25+.75*Math.pow(.5+.5*Math.sin(t*k.sp+k.ph),2))*fi;z=k.z*W;c.globalAlpha=a*.9;c.drawImage(ICE,k.x*W-z*3,k.y*H-z*3,z*6,z*6);c.globalAlpha=a;c.drawImage(WH,k.x*W-z,k.y*H-z,z*2,z*2);
  if(k.z>.0028*.7){c.globalAlpha=a*.5;c.fillStyle='#dfeaff';c.fillRect(k.x*W-z*4,k.y*H-.4,z*8,.8);c.fillRect(k.x*W-.4,k.y*H-z*4,.8,z*8)}}
 for(i=0;i<WIN.length;i++){var f=(i*.618)%1,on=sm((n-.3-.45*f)/.16);if(on<.01)continue;var fl=.82+.14*Math.sin(t*3+i*1.7)+.05*Math.sin(t*11+i*3),x=WIN[i][0]/100*W,y=WIN[i][1]/100*H,g=W*.012;
  c.globalAlpha=.6*on*fl;c.drawImage(WARM,x-g,y-g,g*2,g*2);c.globalAlpha=.95*on*fl;c.fillStyle='rgb(255,208,122)';c.fillRect(x-W*.0015,y-W*.0019,W*.003,W*.0038)}
 for(i=0;i<2;i++){var q=.8+.1*Math.sin(t*7+i)+.1*Math.sin(t*13+i*2),X=LN[i][0]/100*W,Y=LN[i][1]/100*H;z=W*.05;c.globalAlpha=.55*q*sm((n-.3)/.4);c.drawImage(WARM,X-z,Y-z,z*2,z*2);z=W*.012;c.globalAlpha=.8*q*sm((n-.3)/.4);c.drawImage(WH,X-z,Y-z,z*2,z*2)}
 c.fillStyle='#cfe0ff';for(i=0;i<12;i++){var w=W*(.02-i*.0013);c.globalAlpha=.3*fi*(.45+.55*Math.sin(t*1.7+i*2.1));c.fillRect(W*.677+Math.sin(t*.9+i)*W*.004-w/2,H*(.845+i*.012),w,1.3)}
 c.globalAlpha=1;c.globalCompositeOperation='source-over'}
window.__lit=draw;rs();if('ResizeObserver' in window)new ResizeObserver(rs).observe(cv);else addEventListener('resize',rs);
if(rm)window.addEventListener('udgam-mode',function(){draw(0)})})();
</script>
<script>
/* After 5s on the hero, glide down to the sponsors (cancels the moment the visitor scrolls/touches/types) */
(function(){var H=document.documentElement;
var st3=document.querySelector('.stage'),rmo=matchMedia('(prefers-reduced-motion: reduce)').matches;
function tr3(){if(!st3||rmo)return;var n=window.__nt||0,on=n>.003&&n<.997;st3.classList.toggle('trans',on);if(on){st3.style.setProperty('--tr',Math.sin(Math.PI*n).toFixed(3));st3.style.setProperty('--dr',H.getAttribute('data-mode')==='night'?1:-1)}}
window.addEventListener('udgam-mode',tr3);
if(matchMedia('(prefers-reduced-motion: reduce)').matches||location.hash)return;
var EV=['wheel','touchstart','touchmove','pointerdown','mousedown','keydown'],raf=0,timer=0,running=false;
function listen(on){EV.forEach(function(e){window[on?'addEventListener':'removeEventListener'](e,halt,{passive:true})})}
function halt(){clearTimeout(timer);if(raf)cancelAnimationFrame(raf);raf=0;if(running){running=false;H.style.scrollBehavior=''}listen(false)}
function ease(p){return p<.5?4*p*p*p:1-Math.pow(-2*p+2,3)/2} /* easeInOutCubic: gentle start, gentle landing */
function go(){if(window.scrollY>40){halt();return}
  var tg=document.getElementById('t-grand')||document.querySelector('.tier'),nv=document.getElementById('siteHead');if(!tg){halt();return}
  var y0=window.scrollY,y1=tg.getBoundingClientRect().top+y0-(nv?nv.offsetHeight:70)-24,d=y1-y0;if(d<80){halt();return}
  var dur=Math.min(4600,Math.max(3000,d*2.6)),t0=performance.now();running=true;H.style.scrollBehavior='auto';
  (function step(now){var p=Math.min(1,(now-t0)/dur);window.scrollTo(0,y0+d*ease(p));if(p<1)raf=requestAnimationFrame(step);else halt()})(t0)}
listen(true);
function arm(){timer=setTimeout(go,5000)}
if(document.readyState==='complete')arm();else window.addEventListener('load',arm,{once:true})})();
</script>
<?php require __DIR__ . '/includes/footer.php'; ?>
