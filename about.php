<?php
require __DIR__ . '/includes/config.php';

$page = [
  'id'          => 'about',
  'title'       => 'About Us — ' . SITE_NAME . ' | Chase the Bloom',
  'desc'        => 'Where ideas take flight, cultures intertwine, and every moment becomes a memory — Udgam 2K26, the annual cultural festival of NIT Sikkim.',
  'stylesheets' => ['assets/css/about.css'],
  'scripts'     => ['assets/js/about.js'],
];

require __DIR__ . '/includes/header.php';
?>

<main id="main">
  <div class="about-page-wrap">
    <!-- Scenic Himalayas Blossom Background (Theme Coexists with Home Page) -->
    <div class="about-bg-stage" aria-hidden="true">
      <img class="about-bg-img" src="assets/img/about_blossom_bg.webp" alt="UDGAM 2K26 — Scenic Himalayan Blossom Panorama" loading="eager" decoding="async">
      <div class="about-bg-overlay"></div>
    </div>

    <!-- Soft Floating Petals Stream -->
    <div class="about-petals-stream" aria-hidden="true">
      <?php for ($i = 0; $i < 14; $i++): 
        $left = ($i * 23) % 95;
        $sizeW = 10 + ($i % 3) * 4;
        $sizeH = 14 + ($i % 3) * 5;
        $dur = 13 + ($i % 4) * 3;
        $delay = $i * 0.9;
        $drift = ($i % 2 === 0 ? 35 : -35);
      ?>
      <span class="about-petal" style="left:<?= $left ?>%;width:<?= $sizeW ?>px;height:<?= $sizeH ?>px;--dur:<?= $dur ?>s;--delay:-<?= $delay ?>s;--drift:<?= $drift ?>px;"></span>
      <?php endfor; ?>
    </div>

    <div class="about-container">
      <!-- 1. HERO SECTION -->
      <section class="about-hero" id="about">
        <!-- Concentric Circle Badge -->
        <div class="about-badge">
          <span class="about-badge-icon">✿</span>
          <span>CHASE THE BLOOM &middot; UDGAM 2K26</span>
          <span class="about-badge-icon">✿</span>
        </div>

        <!-- Majestic Display Headline -->
        <h1 class="about-title">Celebrating Udgam</h1>

        <!-- Creative Narrative Lead -->
        <div class="about-subtitle-wrap">
          <p class="about-subtitle">
            Where ideas take flight, cultures intertwine, and every moment becomes a memory &mdash; 
            <span class="about-subtitle-highlight">Udgam, the spirit of NIT Sikkim, blooming amidst the Himalayas.</span>
          </p>
        </div>

        <!-- Call to Action Buttons -->
        <div class="about-hero-actions">
          <a href="#campus-showcase" class="btn-blossom-primary">
            Explore the Campus
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="events.php" class="btn-blossom-secondary">
            Explore Events
          </a>
        </div>
      </section>

      <!-- 2. CAMPUS SHOWCASE SECTION -->
      <section class="about-showcase-section" id="campus-showcase">
        <div class="blossom-glass about-showcase-card">
          <div class="about-showcase-grid">
            
            <!-- Left: 3D Interactive Parallax Stage -->
            <div class="campus-stage-wrap">
              <div class="campus-3d-box" id="campus3DBox" role="region" aria-label="Interactive 3D preview of NIT Sikkim Campus">
                <div class="campus-3d-card" id="campus3DCard">
                  <div class="campus-ambient-glow"></div>
                  
                  <div class="campus-inner-viewport">
                    <!-- Pane 1: Campus Sketch -->
                    <div class="campus-view-pane active" id="paneSketch">
                      <img class="campus-sketch-img" src="assets/img/campus_original_sketch.webp" alt="NIT Sikkim Campus Anime Sketch Illustration" loading="lazy" decoding="async">
                      <div class="campus-badge-float">
                        <span style="color:#f43f5e">✿</span>
                        <span>NIT Sikkim &middot; 7,000 ft</span>
                      </div>
                    </div>

                    <!-- Pane 2: Real Campus View Photo -->
                    <div class="campus-view-pane" id="panePhoto">
                      <img class="campus-photo-img" src="assets/img/campus_real_photo.webp" alt="NIT Sikkim Campus Ravangla Real View" loading="lazy" decoding="async">
                      <div class="campus-badge-float campus-badge-float-photo">
                        <span>📍 Ravangla, South Sikkim</span>
                      </div>
                    </div>
                  </div>

                  <!-- Specular dynamic light glare -->
                  <div class="campus-card-glare" id="campusGlare"></div>
                </div>
              </div>

              <!-- Switcher Toggle: Campus Sketch vs Campus View -->
              <div class="campus-toggle-bar" role="tablist" aria-label="Campus view toggle">
                <button type="button" class="campus-toggle-btn active" id="btnSketch" role="tab" aria-selected="true" aria-controls="paneSketch">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                  <span>Campus Sketch</span>
                </button>
                <button type="button" class="campus-toggle-btn" id="btnPhoto" role="tab" aria-selected="false" aria-controls="panePhoto">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                  <span>Campus View</span>
                </button>
              </div>
            </div>

            <!-- Right: Campus Cultural Narrative -->
            <div class="campus-narrative">
              <h2 class="campus-narrative-title">Where Nature &amp; Culture Bloom</h2>
              <p class="campus-narrative-p">
                Perched against the snow-crested grandeur of Mount Kanchenjunga in Ravangla, the campus of <strong>NIT Sikkim</strong> transforms each spring into an open-air wonderland of creativity.
              </p>
              <p class="campus-narrative-p campus-narrative-muted">
                As wild Himalayan cherry blossoms blush across the hillside, Udgam awakens as the vibrant cultural heartbeat of the North East &mdash; uniting students, artists, and dreamers from every corner of India under one starlit mountain canopy.
              </p>

              <!-- Concentric Pill Badges -->
              <div class="campus-badges-row">
                <span class="campus-pill-badge">📍 Ravangla &middot; South Sikkim</span>
                <span class="campus-pill-badge">🌸 Annual Cultural Fest</span>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- 3. THE FESTIVAL EXPERIENCE (3 CARDS) -->
      <section class="about-experience-section">
        <div class="experience-head">
          <span class="experience-tag">THE FESTIVAL EXPERIENCE</span>
          <h2 class="experience-title">Three Days in Full Bloom</h2>
        </div>

        <div class="experience-cards-grid">
          <!-- Card I -->
          <article class="experience-card">
            <div class="experience-card-top">
              <div class="experience-step-circle">I</div>
              <div class="experience-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2a4 4 0 0 0-4 4c0 3 4 6 4 6s4-3 4-6a4 4 0 0 0-4-4z"/><path d="M12 22a4 4 0 0 0 4-4c0-3-4-6-4-6s-4 3-4 6a4 4 0 0 0 4 4z"/><path d="M22 12a4 4 0 0 0-4-4c-3 0-6 4-6 4s3 4 6 4a4 4 0 0 0 4-4z"/><path d="M2 12a4 4 0 0 0 4 4c3 0 6-4 6-4s-3-4-6-4a4 4 0 0 0-4 4z"/></svg>
              </div>
            </div>
            <div class="experience-card-body">
              <span class="experience-tag-small">THE FIRST BLOOM</span>
              <h3 class="experience-card-heading">A Stage for Every Art</h3>
              <p class="experience-card-desc">
                From music and dance to theatre, poetry, and fine arts, Udgam brings student creativity to life in the spirit of spring.
              </p>
            </div>
          </article>

          <!-- Card II -->
          <article class="experience-card">
            <div class="experience-card-top">
              <div class="experience-step-circle">II</div>
              <div class="experience-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C22 6.5 17.5 2 12 2z"/></svg>
              </div>
            </div>
            <div class="experience-card-body">
              <span class="experience-tag-small">A CANOPY OF CULTURE</span>
              <h3 class="experience-card-heading">Where Traditions Meet</h3>
              <p class="experience-card-desc">
                A vibrant blend of cultural performances, folk traditions, artistic expression, and friendly competitions that unite diverse talents.
              </p>
            </div>
          </article>

          <!-- Card III -->
          <article class="experience-card">
            <div class="experience-card-top">
              <div class="experience-step-circle">III</div>
              <div class="experience-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3L12 3z"/><path d="M5 3v4M3 5h4M19 17v4M17 19h4"/></svg>
              </div>
            </div>
            <div class="experience-card-body">
              <span class="experience-tag-small">BLOOMING UNDER THE STARS</span>
              <h3 class="experience-card-heading">Nights to Remember</h3>
              <p class="experience-card-desc">
                From electrifying performances to music-filled evenings, celebrate the magic of togetherness beneath the Himalayan sky.
              </p>
            </div>
          </article>
        </div>
      </section>

      <!-- 4. THE FOUR CIRCLES (FESTIVAL STATS) -->
      <section class="about-stats-section">
        <div class="blossom-glass about-stats-card">
          <div class="about-stats-grid">
            <!-- Stat 1 -->
            <div class="stat-item">
              <div class="stat-circle-outer">
                <div class="stat-circle-inner">30+</div>
              </div>
              <div class="stat-title">Cultural Competitions</div>
              <div class="stat-sub">Where talent takes the stage</div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-item">
              <div class="stat-circle-outer">
                <div class="stat-circle-inner">One</div>
              </div>
              <div class="stat-title">Vibrant Community</div>
              <div class="stat-sub">Where cultures and friendships bloom</div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-item">
              <div class="stat-circle-outer">
                <div class="stat-circle-inner">3 Days</div>
              </div>
              <div class="stat-title">Of Celebration</div>
              <div class="stat-sub">Music, art, dance and memories</div>
            </div>

            <!-- Stat 4 -->
            <div class="stat-item">
              <div class="stat-circle-outer">
                <div class="stat-circle-inner" style="font-size:0.95rem;">Countless</div>
              </div>
              <div class="stat-title">Moments in Bloom</div>
              <div class="stat-sub">Memories that stay long after the petals fall</div>
            </div>
          </div>
        </div>
      </section>

    </div>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
