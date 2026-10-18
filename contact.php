<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'    => 'contact',
  'title' => 'Contact — ' . SITE_NAME,
  'desc'  => 'Get in touch with the UDGAM 2K26 team at NIT Sikkim: email, Instagram, YouTube and how to find the campus in Ravangla.',
];

$channels = contact_channels();

require __DIR__ . '/includes/header.php';
?>
<main id="main">
  <?= page_banner('Get in <em style="font-style:normal">Touch</em>', 'we would love to hear from you',
      'Have a question, collaboration idea, sponsorship enquiry or just want to be a part of UDGAM 2K26? Let&rsquo;s keep the conversation going and create more stories together.', 'assets/img/contact-hero.webp', 'UDGAM 2K26 · CONTACT') ?>

  <section class="pg ctc" id="contact" aria-label="Contact details" data-nav=".45">
    <div class="pg-deco pg-branch pg-branch-l" aria-hidden="true"></div>
    <?= section_head('CONTACT', 'Reach the<br>UDGAM team', 'every channel, in one place') ?>

    <div class="ctc-grid">
      <?php foreach ($channels as $i => $c): ?>
      <a class="ctm-btn nr" href="<?= e($c['href']) ?>"<?= $c['ext'] ? ' target="_blank" rel="noopener"' : '' ?> style="--d:<?= sprintf('%.2f', $i * .07) ?>s">
        <span class="ctm-ico"><svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $c['icon'] ?></svg></span>
        <span class="ctm-tx"><b><?= e($c['title']) ?></b><small><?= e($c['sub']) ?></small></span>
        <span class="ctm-go" aria-hidden="true">&rsaquo;</span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="ctc-two">
      <div class="ctc-card nr">
        <h3>Where to find us</h3>
        <p><?= e($SITE['address']) ?>. The campus sits above Ravangla in South Sikkim, about four hours from Bagdogra airport and New Jalpaiguri railway station.</p>
        <ul>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M4 8l8 5.5L20 8"/></svg><span><b>General enquiries, media &amp; collaborations:</b> <a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.2l2.5 5.2 5.7.8-4.1 4 1 5.7L12 16.2l-5.1 2.7 1-5.7-4.1-4 5.7-.8z"/></svg><span><b>Sponsorship:</b> <a href="mailto:<?= e($SITE['email']) ?>?subject=Sponsorship%20enquiry%20-%20UDGAM%202K26">email with the subject &ldquo;Sponsorship enquiry&rdquo;</a> or see the <a href="sponsors.php#partner">sponsors page</a>.</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 19.5c0-3.6 2.9-5.6 6.5-5.6s6.5 2 6.5 5.6"/></svg><span><b>Looking for a committee member?</b> Every lead and member is listed in the <a href="team.php">committee directory</a>.</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5.5" width="17" height="15" rx="2.5"/><path d="M3.5 10h17M8 3.5v4M16 3.5v4"/></svg><span><b>Schedule updates</b> are posted on <a href="<?= e($SITE['instagram']['url']) ?>" target="_blank" rel="noopener">Instagram</a> and the <a href="events.php#schedule">events page</a>.</span></li>
        </ul>
      </div>
      <div class="ctc-map nr">
        <iframe src="<?= e($SITE['maps_embed']) ?>" title="Map showing NIT Sikkim, Ravangla" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
    </div>

    <ul class="ctm-vals nr"><li>People build<br>communities</li><li>Ideas spark<br>possibilities</li><li>Friendships go<br>beyond borders</li></ul>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
