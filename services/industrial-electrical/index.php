<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/industrial-electrical/ — Industrial Electrical, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical knowledge stated as such;
 * voltages/equipment worked on, schedules, credentials and permits-pulled are NOT claimed — see /content-confirmations.json.
 * No research-brief FAQ fits this page, so there is no FAQ section.
 */
$pageSlug        = 'industrial-electrical';
$pageService     = 'Industrial Electrical';
$pageTitle       = 'Hagerstown Industrial Electrician | All Connected Electric';
$pageDescription = 'Industrial electrical work in Hagerstown, MD: power distribution, equipment circuits and fault finding for warehouses, shops and plants. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Industrial electrical contracting';
$schemaMarkup = [
    $svcNode,
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle,
     'about' => ['@id' => $svcNode['@id']], 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Services', 'url' => $siteUrl . '/services/'],
        ['name' => $pageService, 'url' => $canonicalUrl],
    ]),
];

$pageRelated = [
    ['slug' => 'commercial-electrical', 'icon' => 'building-2', 'desc' => 'Circuits, lighting and repairs for the office side of the building.', 'bullets' => ['Offices and front counters', 'Dedicated equipment circuits', 'Exit and emergency lighting']],
    ['slug' => 'panel-upgrades',        'icon' => 'zap',        'desc' => 'Panel replacement and added capacity when the service is full.', 'bullets' => ['Load added up first', 'Subpanels near the equipment', 'Failing breakers replaced']],
    ['slug' => 'emergency-electrician', 'icon' => 'flame',      'desc' => 'Troubleshooting when power is lost or something smells hot.', 'bullets' => ['Power loss traced', 'Tripping breakers diagnosed', 'Burning smells taken seriously']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Industrial Electrical — page-specific: the stamped equipment nameplate (signature section).
   Tokens only.
   ========================================================================== */
.ind-plate-sec { background: var(--color-paper-2); }
.ind-plate__grid { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.ind-plate {
  position: relative;
  padding: var(--space-xl) var(--space-xl) var(--space-lg);
  border-radius: var(--radius);
  background:
    repeating-linear-gradient(90deg, color-mix(in srgb, var(--color-white) 18%, transparent) 0 1px, transparent 1px 3px),
    linear-gradient(135deg, color-mix(in srgb, var(--color-secondary) 30%, var(--color-white)) 0%, color-mix(in srgb, var(--color-secondary) 55%, var(--color-white)) 50%, color-mix(in srgb, var(--color-secondary) 28%, var(--color-white)) 100%);
  border: 2px solid color-mix(in srgb, var(--color-secondary) 70%, var(--color-ink));
  box-shadow: var(--shadow-lg), inset 0 0 0 4px color-mix(in srgb, var(--color-white) 35%, transparent);
  color: var(--color-ink);
}
.ind-plate::before, .ind-plate::after {
  content: "";
  position: absolute;
  top: var(--space-sm);
  width: var(--space-sm);
  height: var(--space-sm);
  border-radius: var(--radius-full);
  background: radial-gradient(circle at 35% 35%, var(--color-white), color-mix(in srgb, var(--color-secondary) 80%, var(--color-ink)));
}
.ind-plate::before { left: var(--space-sm); }
.ind-plate::after { right: var(--space-sm); }
.ind-plate__title {
  margin: 0 0 var(--space-md);
  padding-bottom: var(--space-xs);
  border-bottom: 2px solid color-mix(in srgb, var(--color-ink) 55%, transparent);
  font-family: var(--font-accent);
  font-size: 1.2rem;
  letter-spacing: .18em;
  text-transform: uppercase;
  text-align: center;
}
.ind-plate dl { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-sm) var(--space-md); margin: 0; }
.ind-plate dl div { display: grid; gap: 2px; padding: var(--space-xs) var(--space-sm); border: 1px solid color-mix(in srgb, var(--color-ink) 30%, transparent); border-radius: var(--radius-sm); background: color-mix(in srgb, var(--color-white) 30%, transparent); }
.ind-plate dl div.is-wide { grid-column: 1 / -1; }
.ind-plate dt { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-ink-2); }
.ind-plate dd { margin: 0; font-family: var(--font-heading); font-weight: 700; font-size: .95rem; }
.ind-plate__foot { margin: var(--space-md) 0 0; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; text-align: center; color: var(--color-ink-2); }
.ind-why { display: grid; gap: var(--space-sm); margin: var(--space-lg) 0 0; padding: 0; list-style: none; }
.ind-why li { padding-left: var(--space-lg); position: relative; color: var(--color-ink-2); }
.ind-why li::before { content: ""; position: absolute; left: 0; top: .55em; width: var(--space-sm); height: 2px; background: var(--color-accent-dark); }
.ind-why b { color: var(--color-ink); }
@media (max-width: 900px) { .ind-plate__grid { grid-template-columns: 1fr; } }
@media (max-width: 420px) { .ind-plate dl { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO ============ -->
<section class="hero hero--interior sp-hero" aria-labelledby="sp-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/services/">Services</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page"><?php echo esc($pageService); ?></span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <span class="eyebrow">Warehouses, shops &amp; plants &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Industrial electrical work in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC does electrical work for warehouses, shops and plants in Hagerstown, MD, including power distribution, dedicated circuits for heavy equipment, and finding the faults that stop a machine or a line. Each job starts from the equipment nameplate and the building's service, so every circuit is sized to what it actually runs.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an industrial estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('hard-hat', 16); ?>Warehouses &amp; shops</li>
          <li><?php echo icon('power', 16); ?>Equipment circuits</li>
          <li><?php echo icon('search', 16); ?>Fault finding</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an industrial electrical estimate?</h2>
        <p class="hero-form-tagline">Tell us the equipment, the voltage if you know it, and the site.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($pageService); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="sp-hero-title">

<!-- ============ 2. PROBLEM: SIGNS ============ -->
<section class="section sp-signs" aria-labelledby="sp-signs-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">What stops work</span>
      <h2 id="sp-signs-title">What electrical problems hold up a <span class="text-accent">warehouse, shop or plant</span>?</h2>
    </div>
    <p class="answer-block reveal-up">The common electrical problems in a warehouse, shop or plant are a machine that trips its breaker on startup, new equipment with no circuit sized for it, motors that run hot or sluggish on low voltage, and a distribution panel with no capacity left. Each costs production time, so trace it to the cause instead of resetting.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">A breaker that trips on startup is a symptom. The cause sits somewhere between the panel and the motor.</p>
        <p>Hagerstown sits where I-81 and I-70 cross, and the corridors along both are lined with warehouses, distribution buildings and shops. Those buildings change tenants and equipment often, which is why the circuits the last occupant left behind rarely match the machines the next one brings in.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>Trips the moment a machine starts</h3>
          <p>Motors draw several times their running current for a moment at startup. A breaker that trips then may be the wrong type or size for a motor load, or the conductor feeding it may be too long and too small. Swapping in a bigger breaker without checking the wire is how equipment and buildings get damaged.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>A new machine with no circuit</h3>
          <p>A compressor, welder or production machine arrives before anyone checks what it needs.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('wrench', 20); ?></span>
          <h3>Motors running hot or slow</h3>
          <p>Low voltage at the machine, from undersized or overloaded feeders, shortens motor life.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('layers', 20); ?></span>
          <h3>A distribution panel with no room left</h3>
          <p>Every space is used and the floor still needs another drop.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 3. EXPERT POSITIONING (dark, asymmetric) ============ -->
<section class="section sp-expert texture-grain slant-top" aria-labelledby="sp-expert-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-expert__grid">
      <div class="sp-expert__fact reveal-left">
        <b>Washington <span>Co.</span></b>
        <span>Based on Leitersburg Pike in Hagerstown, a short drive from the I-81 and I-70 warehouse corridors.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why bring All Connected Electric in for industrial electrical work?</h2>
        <p class="answer-block">All Connected Electric LLC is a Hagerstown contractor, owned by <?php echo esc($ownerName); ?>, that handles industrial work alongside its commercial and residential jobs, from power distribution to equipment circuits and repairs. With the office on Leitersburg Pike, the warehouses and shops along the I-81 and I-70 corridors are close by when a fault needs tracing.</p>
        <ul class="sp-points">
          <li><?php echo icon('clipboard-list', 20); ?><div><b>Sized from the nameplate</b><span>The voltage, phase and full-load amps stamped on the equipment decide the conductor, the breaker and the disconnect. Guessing from the plug on the old machine is how circuits end up wrong.</span></div></li>
          <li><?php echo icon('route', 20); ?><div><b>Distribution, not only outlets</b><span>Feeders and subpanels bring power to where the equipment sits instead of running every machine back to one crowded panel. When the main service itself is full, <?php echo serviceLink('panel-upgrades', 'adding panel and service capacity'); ?> comes first.</span></div></li>
          <li><?php echo icon('search', 20); ?><div><b>Faults traced with the line in mind</b><span>Finding a fault means knowing what must stay running while circuits are tested. For a sudden loss of power or a hot smell, see <?php echo serviceLink('emergency-electrician', 'urgent electrical troubleshooting'); ?>.</span></div></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 4. SERVICE BREAKDOWN: SCOPE + PROCESS ============ -->
<section class="section sp-scope" aria-labelledby="sp-scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">What's covered</span>
        <h2 id="sp-scope-title">What industrial electrical work does All Connected Electric cover?</h2>
        <p class="answer-block">Industrial electrical work covers power distribution from the main service out to subpanels and feeders, dedicated circuits and disconnects for motors, compressors, welders and other equipment, lighting for warehouse and work areas, and diagnosing the faults that trip breakers or stop machines. Equipment and voltages vary by site, so each job starts with a walk of the floor.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Feeders and subpanels</b> that put power close to the equipment it serves.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Equipment circuits</b> with a disconnect within sight of the machine, the way code expects for motors.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Welder and compressor receptacles</b> wired for the voltage and phase on the nameplate.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Warehouse and shop lighting</b>, where bright, even light is a safety issue. <?php echo serviceLink('lighting-installation', 'Lighting installation and repair'); ?> covers fixture options.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Fault finding and repair</b> for trips, dead circuits and equipment that will not start.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it runs</span>
        <h3>How does an industrial job get from request to running equipment?</h3>
        <ol class="sp-steps">
          <li><b>Send the equipment list</b><span>Photos of the nameplates, where each machine will sit, and the building address.</span></li>
          <li><b>Walk the floor and the service</b><span>The main service, the distribution panels and the route to the equipment are looked at on site.</span></li>
          <li><b>Scope, schedule and permit</b><span>What gets installed, what has to shut down and when, and what the City of Hagerstown or Washington County requires.</span></li>
          <li><b>Install</b><span>Feeder, disconnect and circuit go in, then the equipment is connected.</span></li>
          <li><b>Start-up and labeling</b><span>The machine is started on its new circuit and the panels are labeled for your maintenance staff.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: SINGLE VS THREE PHASE ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Power types</span>
      <h2 id="sp-compare-title">Does your equipment need single-phase or three-phase power?</h2>
    </div>
    <p class="answer-block reveal-up">The equipment's nameplate decides whether it needs single-phase or three-phase power. Single-phase runs most small tools, small compressors and lighting, while larger motors and many production machines are built for three-phase. If the building has only single-phase service, three-phase equipment needs a service change from the utility or, for limited loads, a phase converter.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Single-phase and three-phase power compared for shops, warehouses and plants</caption>
        <thead>
          <tr><th scope="col">Factor</th><th scope="col">Single-phase</th><th scope="col">Three-phase</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Typical voltages</th><td>120/240 V, the service most houses and small shops have.</td><td>120/208 V or 277/480 V, common in larger commercial and industrial buildings.</td></tr>
          <tr><th scope="row">Common loads</th><td>Lighting, receptacles, hand tools, small compressors, many smaller welders.</td><td>Larger motors and compressors, production machines, big air handlers.</td></tr>
          <tr><th scope="row">How motors behave</th><td>Need starting components and draw more current per horsepower.</td><td>Start and run more smoothly, with less current per horsepower.</td></tr>
          <tr><th scope="row">Getting it to the building</th><td>Standard on most small buildings.</td><td>Supplied by the utility where it is available at the site; Potomac Edison serves Hagerstown and decides what can be delivered.</td></tr>
          <tr><th scope="row">If you do not have it</th><td>Not applicable.</td><td>A utility service change, or a phase converter for a limited number of machines.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Moving into a building with different service from your last one is the most common time this comes up. Check before the machines are delivered, not after.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: EQUIPMENT NAMEPLATE ============ -->
<section class="section ind-plate-sec" aria-labelledby="ind-plate-title">
  <div class="container">
    <div class="ind-plate__grid">
      <div class="ind-plate reveal-left" role="group" aria-label="What to read off an equipment nameplate">
        <p class="ind-plate__title">Equipment data</p>
        <dl>
          <div class="is-wide"><dt>Manufacturer &amp; model</dt><dd>As stamped on the tag</dd></div>
          <div><dt>Volts</dt><dd>208 / 230 / 460</dd></div>
          <div><dt>Phase</dt><dd>1 or 3</dd></div>
          <div><dt>FLA</dt><dd>Full-load amps</dd></div>
          <div><dt>HP or kW</dt><dd>Motor size</dd></div>
          <div><dt>MCA</dt><dd>Min. circuit amps</dd></div>
          <div><dt>MOP</dt><dd>Max. breaker size</dd></div>
          <div class="is-wide"><dt>Location</dt><dd>Where it sits and where the disconnect goes</dd></div>
        </dl>
        <p class="ind-plate__foot">Photograph it before the call</p>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Before you call</span>
        <h2 id="ind-plate-title">What should you send before adding a machine or compressor?</h2>
        <p class="answer-block">Send a clear photo of the equipment nameplate and a note of where the machine will sit. The nameplate gives the voltage, phase, full-load amps and often the minimum circuit and maximum breaker ratings, which together set the size of the wire, the breaker and the disconnect before anyone opens a panel.</p>
        <ul class="ind-why">
          <li><b>Voltage and phase</b> show whether the building can run it as it is.</li>
          <li><b>FLA, MCA and MOP</b> set the wire gauge and the breaker size.</li>
          <li><b>Location</b> sets the length of the run, and long runs need heavier wire to avoid voltage drop.</li>
          <li><b>Model number</b> lets the manufacturer's installation instructions be checked for anything unusual.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 7. PROOF: GOOGLE REVIEWS (Page One feed; renders nothing until the profile has written reviews) ============ -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$pageReviews = p1_google_reviews($slug, ['heading' => 'What Hagerstown customers say about All Connected Electric']);
if ($pageReviews !== ''): ?>
<section class="section sp-reviews" aria-label="Google reviews">
  <div class="container"><?php echo $pageReviews; ?></div>
</section>
<?php endif; ?>

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></p></div>
</article>

<!-- ============ 9. RELATED SERVICES (required services-grid component) ============ -->
<section class="section sp-related" aria-labelledby="sp-related-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="sp-related-title">What other electrical work do <span class="text-accent">industrial sites</span> usually need?</h2>
      <p class="hero-answer">Most industrial buildings also have an office, a front counter or a showroom, and every one of them eventually runs short of panel space. All Connected Electric LLC handles the commercial side of the building, the capacity upgrades and the urgent troubleshooting as well, so one contractor knows how the whole site is wired.</p>
    </div>
    <div class="services-grid">
<?php foreach ($pageRelated as $relIdx => $rel):
    $relTint = ($relIdx % 3) + 1;
    $relName = '';
    foreach ($services as $relSvc) if ($relSvc['slug'] === $rel['slug']) $relName = $relSvc['name'];
    $relUrl = serviceUrl($rel['slug']); ?>
      <article class="service-card-with-image card-tint-<?php echo $relTint; ?> reveal-up reveal-delay-<?php echo $relTint; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php echo icon($rel['icon'], 24); ?></div>
          <h3><?php echo esc($relName); ?></h3>
          <p class="service-card__desc"><?php echo esc($rel['desc']); ?></p>
          <ul>
<?php foreach ($rel['bullets'] as $relBullet): ?>
            <li><?php echo esc($relBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($relUrl !== ''): ?>
          <a href="<?php echo esc($relUrl); ?>" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc($relName); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta" data-open-estimate>Ask about this<span class="sr-only">: <?php echo esc($relName); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="sp-related__hub">Industrial work is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Industrial estimate</span>
      <h2 id="sp-cta-title">Adding equipment or chasing a fault at a Hagerstown site?</h2>
      <p>Send the nameplate photos and the site address, or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>. All Connected Electric LLC will follow up to walk the floor and the service before anything is priced.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get an industrial estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
