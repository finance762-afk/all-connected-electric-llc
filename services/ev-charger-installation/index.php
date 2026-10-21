<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ev-charger-installation/ — EV Charger Installation, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Charger output figures are general Level 1 / Level 2 / NEC facts, not client claims. Prices, timeframes,
 * charger brands, permits-pulled and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'ev-charger-installation';
$pageService     = 'EV Charger Installation';
$pageTitle       = 'EV Charger Installation Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Level 2 EV charger installation in Hagerstown, MD. All Connected Electric LLC checks your panel and runs a dedicated 240-volt circuit to where you park.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'Will an older Hagerstown house need a new panel before an EV charger goes in?',
     'a' => 'Not always. What decides it is the capacity the existing service has left once heating, cooling, the range, the dryer and the water heater are counted. Some older homes have room for a 40- or 50-amp charger circuit as they are; others need a service upgrade first, or a charger set to a lower output. A load calculation settles it before any work is booked.'],
    ['q' => 'Does a home EV charger installation in Hagerstown need a permit?',
     'a' => 'In most cases, yes. A new 240-volt circuit for a charger is work Maryland jurisdictions expect to be permitted and inspected, and the City of Hagerstown and unincorporated Washington County handle permits through different offices. Ask All Connected Electric LLC which office covers your address when you request the estimate.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Electric vehicle charger installation';
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
if ($pageFaqs) $schemaMarkup[] = generateFAQSchema($pageFaqs);

$pageRelated = [
    ['slug' => 'panel-upgrades',         'icon' => 'zap',   'desc' => 'More capacity when the load calculation says the charger will not fit.', 'bullets' => ['Service capacity added', 'Room for new circuits', 'Old panels replaced safely']],
    ['slug' => 'generator-installation', 'icon' => 'power', 'desc' => 'Transfer switches and hookups so the house runs during an outage.',      'bullets' => ['Portable or standby units', 'Chosen circuits stay powered', 'No backfeed onto utility lines']],
    ['slug' => 'residential-electrical', 'icon' => 'house', 'desc' => 'Garage, kitchen and whole-house electrical work for Hagerstown homes.',   'bullets' => ['Garage outlets and lighting', 'Whole-home surge protection', 'Electrical safety inspections']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   EV Charger Installation — page-specific: the panel-to-parking-spot route (signature section).
   Tokens only.
   ========================================================================== */
.ev-route { position: relative; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; padding: 0; list-style: none; counter-reset: ev; }
.ev-route::before {
  content: "";
  position: absolute;
  top: calc(var(--space-12) / 2);
  left: var(--space-xl);
  right: var(--space-xl);
  height: 3px;
  background: repeating-linear-gradient(90deg, var(--color-accent) 0 var(--space-md), transparent var(--space-md) var(--space-lg));
  z-index: 0;
}
.ev-route li { counter-increment: ev; position: relative; z-index: 1; display: grid; gap: var(--space-xs); align-content: start; }
.ev-route__node {
  display: grid;
  place-items: center;
  width: var(--space-12);
  height: var(--space-12);
  border-radius: var(--radius-full);
  background: var(--color-primary);
  color: var(--color-accent);
  box-shadow: 0 0 0 var(--space-2) var(--color-paper), var(--shadow);
}
.ev-route li:last-child .ev-route__node { background: var(--color-accent); color: var(--color-primary); }
.ev-route__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.ev-route__tag::before { content: counter(ev, decimal-leading-zero) " · "; }
.ev-route h3 { font-size: 1.05rem; }
.ev-route p { margin: 0; font-size: .93rem; color: var(--color-ink-2); }
.ev-route__card { padding: var(--space-md); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); display: grid; gap: var(--space-xs); transition: transform var(--transition), box-shadow var(--transition); }
.ev-route li:hover .ev-route__card { transform: translateY(-2px); box-shadow: var(--shadow); }
@media (max-width: 900px) {
  .ev-route { grid-template-columns: 1fr; gap: var(--space-md); }
  .ev-route::before { top: var(--space-lg); bottom: var(--space-lg); left: calc(var(--space-12) / 2 - 1px); right: auto; width: 3px; height: auto; background: repeating-linear-gradient(180deg, var(--color-accent) 0 var(--space-md), transparent var(--space-md) var(--space-lg)); }
  .ev-route li { grid-template-columns: var(--space-12) 1fr; column-gap: var(--space-md); }
  .ev-route__node { grid-row: span 2; }
}
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
        <span class="eyebrow">Level 2 charging &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">EV charger installation in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC installs Level 2 EV chargers at homes and businesses in Hagerstown, MD, on a dedicated 240-volt circuit sized for the charger. Before anything is mounted, the panel's spare capacity and the route from the panel to the parking spot are checked, because those two things shape the whole job.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a charger estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('battery-charging', 16); ?>Level 2 chargers</li>
          <li><?php echo icon('plug', 16); ?>Hardwired or NEMA 14-50</li>
          <li><?php echo icon('zap', 16); ?>Panel capacity checked</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an EV charger estimate?</h2>
        <p class="hero-form-tagline">Tell us the car, the charger and where you park.</p>
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
      <span class="eyebrow-label">Signs it is time</span>
      <h2 id="sp-signs-title">When does a Hagerstown driver need a <span class="text-accent">Level 2 charger</span>?</h2>
    </div>
    <p class="answer-block reveal-up">A Level 2 charger makes sense once a standard 120-volt outlet cannot refill the battery overnight for the miles you actually drive. That usually happens with a new EV, a second electric car in the household, or a long daily commute on I-81 or I-70 that the wall outlet cannot keep up with.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">The charger on the wall is the easy part. The circuit behind it is the job.</p>
        <p>Most chargers bought online arrive with a manual and a breaker size, not a plan for getting 240 volts from a basement panel to a garage wall. In older Hagerstown houses, where the panel can sit at the far end of the basement and the garage may be detached, that route is what the electrician works out first.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('battery-charging', 20); ?></span>
          <h3>The wall outlet cannot keep up</h3>
          <p>Level 1 charging on an ordinary 120-volt outlet adds only a few miles of range per hour. That works for short trips, but a battery drained by a full day of driving can still be low the next morning. Level 2 on a 240-volt circuit fills the same battery several times faster.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>An extension cord in the garage</h3>
          <p>Household cords are not built for hours of continuous charging current and can overheat at the plug.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('car', 20); ?></span>
          <h3>Two EVs, one driveway</h3>
          <p>A second electric car raises the question of a second circuit, or one charger that shares power between both.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('clipboard-list', 20); ?></span>
          <h3>Charger bought, no circuit yet</h3>
          <p>The charger is in its box and the manual names a breaker size the panel may not have room for.</p>
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
        <b><span>3</span> Sectors</b>
        <span>Home garages, business parking and industrial sites: All Connected Electric has worked across all three since <?php echo (int) $yearEstablished; ?>.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have All Connected Electric install your EV charger?</h2>
        <p class="answer-block">All Connected Electric LLC treats an EV charger as a new 240-volt circuit first and a gadget second. The panel, the load already on it and the wire route are worked out before the charger goes up, so the charger can run at the output you paid for without tripping or overloading the service.</p>
        <ul class="sp-points">
          <li><?php echo icon('zap', 20); ?><div><b>Panel capacity settled first</b><span>If the load calculation shows the service is short, the fix comes before the charger, not after the first tripped breaker. <?php echo serviceLink('panel-upgrades', 'How panel and service upgrades are sized'); ?> covers that step.</span></div></li>
          <li><?php echo icon('building-2', 20); ?><div><b>Workplace and storefront chargers too</b><span>Chargers for staff or customer parking are part of <?php echo serviceLink('commercial-electrical', 'commercial electrical work around Hagerstown'); ?>, where the panel, the distance and the parking layout all change the plan.</span></div></li>
          <li><?php echo icon('clipboard-list', 20); ?><div><b>The charger's own manual followed</b><span>The maker's installation instructions set the breaker size, the wire size and the mounting height. Those are matched exactly, along with the charger's power setting.</span></div></li>
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
        <span class="eyebrow-label">What's included</span>
        <h2 id="sp-scope-title">What does an EV charger installation from All Connected Electric include?</h2>
        <p class="answer-block">An EV charger installation covers the load check, a dedicated 240-volt circuit and breaker sized to the charger, the wire run from the panel to the parking spot, mounting and connecting the charger or installing a 14-50 outlet, and a test charge with your car before the job is called done.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>A dedicated circuit</b>, sized the way the National Electrical Code treats EV charging: as a continuous load, so the breaker is rated 125 percent of the charger's output. A 48-amp charger goes on a 60-amp circuit.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>The wire route</b> from the panel through the basement, along the garage wall, or in conduit outside to a driveway post or a detached garage.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Charger mounting</b> at the height and location the manual calls for, within reach of the car's charge port.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>GFCI protection</b> where current code calls for it, which generally includes a 240-volt receptacle in a garage or outdoors.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>A test charge</b> with the car plugged in, and the charger's amperage setting confirmed against the breaker.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does an EV charger install go, step by step?</h3>
        <ol class="sp-steps">
          <li><b>You send the details</b><span>The car, the charger model if you have one, and where the car parks at night.</span></li>
          <li><b>Panel and route are checked</b><span>Spare capacity in the panel, and the path the wire has to take to reach the parking spot.</span></li>
          <li><b>Scope and permit</b><span>Circuit size, charger location and what the City of Hagerstown or Washington County needs for the job.</span></li>
          <li><b>Install day</b><span>The circuit is run, the breaker added, and the charger or outlet mounted and connected.</span></li>
          <li><b>Test charge and inspection</b><span>The car charges at the expected rate, and the work is ready for the inspector.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: CHARGING OPTIONS ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Should an EV charger be hardwired or plugged into a 14-50 outlet?</h2>
    </div>
    <p class="answer-block reveal-up">A hardwired charger can run at higher power and suits an outdoor or permanent install, while a plug-in charger on a NEMA 14-50 outlet can be unplugged and taken with you. Both are Level 2 on a 240-volt circuit; the right choice depends on the charger, the panel's spare capacity and where it mounts.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Level 1 outlet charging, plug-in Level 2 and hardwired Level 2 compared</caption>
        <thead>
          <tr><th scope="col">Setup</th><th scope="col">Power supply</th><th scope="col">Typical charging output</th><th scope="col">Best fit</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Level 1 cord</th><td>Standard 120-volt outlet, ideally on its own circuit.</td><td>About 1.4 kW, a few miles of range per hour.</td><td>Plug-in hybrids and short daily drives.</td></tr>
          <tr><th scope="row">Level 2 plug-in (NEMA 14-50)</th><td>240-volt, 50-amp receptacle on a dedicated circuit.</td><td>Up to 40 amps, about 9.6 kW.</td><td>Indoor garages, renters planning to move, chargers you may want to take along.</td></tr>
          <tr><th scope="row">Level 2 hardwired</th><td>240-volt circuit wired straight into the charger.</td><td>Up to 48 amps on a 60-amp circuit, about 11.5 kW.</td><td>Outdoor mounts, faster charging, and panels with the capacity to spare.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Output figures are typical for residential chargers; the car's onboard charger sets the real ceiling. A charger can also be set to a lower amperage when the panel's spare capacity is tight.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: PANEL-TO-PARKING ROUTE ============ -->
<section class="section ev-plan" aria-labelledby="ev-plan-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">What shapes the job</span>
      <h2 id="ev-plan-title">What decides how involved an EV charger install is?</h2>
    </div>
    <p class="answer-block reveal-up">Four things decide how involved an EV charger install is: how much capacity the panel has left, how far the parking spot is from the panel, what the wire has to pass through on the way, and whether the charger mounts indoors or outside. Telling us those four up front makes the first conversation much shorter.</p>
    <ol class="ev-route reveal-up">
      <li>
        <span class="ev-route__node"><?php echo icon('zap', 22); ?></span>
        <div class="ev-route__card"><span class="ev-route__tag">The panel</span><h3>Spare capacity</h3><p>The number on the main breaker and what is already connected decide the charger circuit size, or whether the service comes first.</p></div>
      </li>
      <li>
        <span class="ev-route__node"><?php echo icon('ruler', 22); ?></span>
        <div class="ev-route__card"><span class="ev-route__tag">The distance</span><h3>Panel to parking spot</h3><p>A charger on the other side of the garage wall from the panel is a short run. A detached garage or a driveway post is a longer one.</p></div>
      </li>
      <li>
        <span class="ev-route__node"><?php echo icon('route', 22); ?></span>
        <div class="ev-route__card"><span class="ev-route__tag">The path</span><h3>What the wire passes</h3><p>Open basement joists are simple. Finished ceilings, block walls or a trench across the yard add work.</p></div>
      </li>
      <li>
        <span class="ev-route__node"><?php echo icon('car', 22); ?></span>
        <div class="ev-route__card"><span class="ev-route__tag">The spot</span><h3>Indoor or outdoor</h3><p>An outdoor charger needs a weather-rated unit and protected wiring, and a cable long enough to reach the charge port.</p></div>
      </li>
    </ol>
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

<!-- ============ 8. FAQ (research-brief questions only) ============ -->
<?php if ($pageFaqs): ?>
<section class="section sp-faq" aria-labelledby="sp-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sp-faq-title">What do Hagerstown EV owners ask before a charger install?</h2>
      <p>Older panels and permits are the two questions EV owners in Hagerstown and Washington County raise first. All Connected Electric LLC answers both below, and goes through them again during the estimate for your own house.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($pageFaqs as $pageFaqIdx => $pageFaq): ?>
      <details class="faq"<?php echo $pageFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($pageFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo esc($pageFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></p></div>
</article>

<!-- ============ 9. RELATED SERVICES (required services-grid component) ============ -->
<section class="section sp-related" aria-labelledby="sp-related-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="sp-related-title">What other work comes up with an <span class="text-accent">EV charger</span> install?</h2>
      <p class="hero-answer">A charger often brings the rest of the house into the conversation. All Connected Electric LLC handles the panel upgrade when capacity runs short, the generator hookup for homes that cannot lose power, and the garage outlets, lighting and surge protection that tend to get added while the walls are already open.</p>
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
    <p class="sp-related__hub">EV charging is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Charger estimate</span>
      <h2 id="sp-cta-title">Want a price on an EV charger install in Hagerstown?</h2>
      <p>Send the car, the charger model and a photo of your panel, or call <?php echo esc(formatPhone($phone)); ?>. All Connected Electric LLC will follow up to look at the panel and the route to your parking spot.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a charger estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
