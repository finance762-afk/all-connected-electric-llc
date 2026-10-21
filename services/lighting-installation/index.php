<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/lighting-installation/ — Lighting Installation, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general lighting/electrical knowledge stated as such;
 * prices, fixture brands, smart-control systems, drywall patching and credentials are NOT claimed — see /content-confirmations.json.
 * No research-brief FAQ fits this page, so there is no FAQ section and no FAQPage node.
 */
$pageSlug        = 'lighting-installation';
$pageService     = 'Lighting Installation';
$pageTitle       = 'Lighting Installation Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Recessed, fixture, under-cabinet and outdoor lighting installed or repaired in Hagerstown, MD homes and businesses. All Connected Electric LLC, (301) 704-6333.';
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
$svcNode['serviceType'] = 'Lighting installation and repair';
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
    ['slug' => 'ceiling-fan-installation', 'icon' => 'wind',  'desc' => 'Ceiling fans installed or repaired on boxes rated for the weight.', 'bullets' => ['Fan-rated ceiling boxes', 'Separate fan and light control', 'Wobbling fans steadied']],
    ['slug' => 'outlet-switch-repair',     'icon' => 'plug',  'desc' => 'Dead outlets, faulty switches and GFCIs repaired or replaced.', 'bullets' => ['Switches that spark replaced', 'GFCI outlets where required', 'Loose connections tightened']],
    ['slug' => 'residential-electrical',   'icon' => 'house', 'desc' => 'Repairs, upgrades and new wiring for houses around Hagerstown.', 'bullets' => ['Kitchen and bath circuits', 'Surge protection for the house', 'Safety inspections on request']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Lighting Installation — page-specific: color-temperature scale (signature section).
   Tokens only: the warm-to-daylight ramp is mixed from the warning, accent and secondary tokens.
   ========================================================================== */
.lt-kelvin { background: var(--color-dark); color: var(--color-white); position: relative; isolation: isolate; overflow: clip; }
.lt-kelvin .grain-layer { opacity: .3; }
.lt-kelvin h2 { color: var(--color-white); }
.lt-kelvin .eyebrow-label { color: var(--color-accent-bright); }
.lt-kelvin .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 64ch; }
.lt-scale { margin: var(--space-2xl) 0 0; }
.lt-scale__bar {
  position: relative;
  height: var(--space-12);
  border-radius: var(--radius-full);
  background: linear-gradient(90deg,
    color-mix(in srgb, var(--color-warning) 85%, var(--color-white)) 0%,
    color-mix(in srgb, var(--color-accent) 70%, var(--color-white)) 30%,
    color-mix(in srgb, var(--color-accent) 25%, var(--color-white)) 55%,
    var(--color-white) 75%,
    color-mix(in srgb, var(--color-secondary) 30%, var(--color-white)) 100%);
  box-shadow: 0 0 var(--space-3xl) color-mix(in srgb, var(--color-accent) 30%, transparent), inset 0 0 0 1px color-mix(in srgb, var(--color-white) 40%, transparent);
}
.lt-scale__ticks { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-md); margin: var(--space-md) 0 0; padding: 0; list-style: none; }
.lt-scale__ticks li { position: relative; display: grid; gap: var(--space-1); padding-top: var(--space-md); border-top: 2px solid color-mix(in srgb, var(--color-white) 25%, transparent); }
.lt-scale__ticks b { font-family: var(--font-accent); font-size: 1.6rem; line-height: 1; letter-spacing: .02em; color: var(--color-white); }
.lt-scale__ticks em { font-style: normal; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.lt-scale__ticks span { font-size: .88rem; color: color-mix(in srgb, var(--color-white) 76%, transparent); }
.lt-kelvin__note { margin: var(--space-xl) 0 0; max-width: 64ch; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 70%, transparent); }
@media (max-width: 800px) {
  .lt-scale__ticks { grid-template-columns: 1fr 1fr; }
  .lt-scale__ticks li:last-child { grid-column: 1 / -1; }
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
        <span class="eyebrow">Indoor &amp; outdoor lighting &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Lighting installation in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC installs and repairs indoor and outdoor lighting in Hagerstown, MD, from recessed lights and fixture swaps to under-cabinet and exterior lights for homes, offices and storefronts. Each job starts with the circuit and the switch behind the light, so new LEDs dim smoothly and old wiring is checked first.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a lighting estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('lightbulb', 16); ?>Recessed &amp; fixture installs</li>
          <li><?php echo icon('sun', 16); ?>Outdoor &amp; security lights</li>
          <li><?php echo icon('wrench', 16); ?>Lighting repair</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a lighting estimate?</h2>
        <p class="hero-form-tagline">Tell us the room or area and what you want lit.</p>
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
      <span class="eyebrow-label">Repair or replace</span>
      <h2 id="sp-signs-title">When is it time to repair or replace <span class="text-accent">lighting</span> in a Hagerstown home or business?</h2>
    </div>
    <p class="answer-block reveal-up">It is time to repair or replace lighting when lights flicker or buzz, a fixture stays dead after a new bulb, LEDs hum or will not dim on the old switch, outdoor lights quit after rain, or a room is too dark to work in. Flickering and dead fixtures can mean a loose connection, so check those first.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">If a new bulb did not fix it, the problem is in the fixture, the switch or the wire.</p>
        <p>Older Hagerstown houses often have one ceiling light per room, plaster ceilings and little insulation-safe space above them, which shapes where new lights can go. In offices and storefronts the usual complaint is the opposite: plenty of fixtures, but tired tubes and ballasts that buzz.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>Flicker and buzz</h3>
          <p>One flickering bulb is usually the bulb. Several lights on the same circuit flickering together, or a fixture that buzzes and runs warm, points to a loose connection at a switch, a splice or the fixture itself. Loose connections heat up over time, so they are found and fixed rather than lived with.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Dead after a new bulb</h3>
          <p>A failed socket, switch or broken wire in the box, not something a bulb can fix.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('sun', 20); ?></span>
          <h3>LEDs that will not dim</h3>
          <p>Older dimmers built for incandescent bulbs often make LEDs flicker, hum or drop out.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('droplets', 20); ?></span>
          <h3>Outdoor lights that quit after rain</h3>
          <p>Water in a fixture or box that was never rated for an exposed spot.</p>
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
        <b><span>11</span> Services</b>
        <span>Lighting is one of eleven electrical services, so the circuit, switch and panel behind a fixture are part of the same job.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have an electrician install lighting instead of just swapping fixtures?</h2>
        <p class="answer-block">An electrician checks what a light fixture connects to: the box, the circuit, the switch and the wiring. All Connected Electric LLC, a Hagerstown contractor since <?php echo (int) $yearEstablished; ?>, handles lighting as part of a full electrical service, so a dead fixture caused by a failing switch or old wiring gets fixed at the source instead of being replaced twice.</p>
        <ul class="sp-points">
          <li><?php echo icon('layers', 20); ?><div><b>Boxes rated for what hangs on them</b><span>Heavy fixtures, chandeliers and anything that moves need a box and support rated for the weight. If the light is coming down so a fan can go up, see <?php echo serviceLink('ceiling-fan-installation', 'fan-rated ceiling box installs'); ?>.</span></div></li>
          <li><?php echo icon('waypoints', 20); ?><div><b>The wire behind the fixture</b><span>Decades of heat from incandescent bulbs can leave the insulation on old ceiling wiring brittle. It is looked at when the fixture comes down, and <?php echo serviceLink('wiring-rewiring', 'rewiring for older houses'); ?> takes over when it needs replacing.</span></div></li>
          <li><?php echo icon('building-2', 20); ?><div><b>Homes and businesses</b><span>The same work covers kitchen pendants and a storefront's sales floor. <?php echo serviceLink('commercial-electrical', 'Commercial electrical work'); ?> covers lighting in offices and stores alongside the rest of the building.</span></div></li>
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
        <h2 id="sp-scope-title">What does a lighting installation from All Connected Electric include?</h2>
        <p class="answer-block">A lighting installation covers planning where the lights go, running or extending the circuit, fitting boxes and fixtures rated for the location, installing a switch or dimmer matched to the fixture, and testing everything before the job is closed up. In an insulated ceiling, recessed lights use IC-rated housings or canless LED fixtures that can touch insulation safely.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>A layout</b> that spaces recessed lights for even light rather than a row of bright spots.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Circuit and switch wiring</b>, including three-way switching for stairs and long hallways.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Location-rated fixtures</b>: damp-rated under a covered porch, wet-rated where rain hits directly.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Dimmers matched to LEDs</b>, so the lights dim smoothly instead of flickering at the low end.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Testing</b> of every light, switch and dimmer before the job is called finished.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a lighting job go from idea to switched on?</h3>
        <ol class="sp-steps">
          <li><b>Tell us the room and the goal</b><span>Brighter kitchen, recessed lights in a living room, a dead porch light or security lights over a driveway.</span></li>
          <li><b>Look at the ceiling and the circuit</b><span>Attic or basement access, joist direction, insulation and which circuit can take the new load.</span></li>
          <li><b>Layout, fixtures and switches</b><span>Where each light goes and what controls it, agreed before any hole is cut.</span></li>
          <li><b>Install</b><span>Boxes or housings, wiring, fixtures and controls go in.</span></li>
          <li><b>Test and walk-through</b><span>Every light and dimmer is tested with you so you know what each switch does.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: FIXTURE TYPES ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Which type of lighting fits your project?</h2>
    </div>
    <p class="answer-block reveal-up">The right type of lighting depends on the room and the ceiling: recessed lights for even general light, a fixture or pendant where a box already exists, under-cabinet strips for kitchen counters, and wet-rated exterior or security lights outside. The table compares what each one involves so you can decide before anyone comes out to price it.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Recessed, fixture, under-cabinet, exterior and landscape lighting compared</caption>
        <thead>
          <tr><th scope="col">Type</th><th scope="col">Best for</th><th scope="col">What the install involves</th><th scope="col">Worth knowing</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Recessed or canless LED</th><td>Kitchens, living rooms, basements, offices.</td><td>Cutting openings, running wire between them, a switch or dimmer.</td><td>Use IC-rated or canless fixtures wherever insulation is above the ceiling.</td></tr>
          <tr><th scope="row">Fixture or pendant swap</th><td>Dining rooms, entries, over islands.</td><td>Replacing what is on an existing box, checking the box can hold it.</td><td>Heavy fixtures may need a new box and support.</td></tr>
          <tr><th scope="row">Under-cabinet</th><td>Kitchen counters, workbenches.</td><td>A power source in the cabinet run and a switch.</td><td>Hardwired strips beat plug-in ones for a clean look.</td></tr>
          <tr><th scope="row">Exterior and security</th><td>Porches, garages, driveways, storefronts.</td><td>Weather-rated boxes and fixtures, often a motion sensor or timer.</td><td>Wet-rated where rain hits directly; damp-rated only under cover.</td></tr>
          <tr><th scope="row">Landscape</th><td>Paths, steps, plantings.</td><td>Low-voltage runs from a transformer, or line-voltage for brighter lights.</td><td>Low-voltage is simpler to run; line-voltage needs buried, protected wiring.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Repairs follow the same logic. A dead fixture of any type gets the bulb, socket, switch and connection checked in that order.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: COLOR-TEMPERATURE SCALE ============ -->
<section class="section lt-kelvin texture-grain edge-parallelogram-top" aria-labelledby="lt-kelvin-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Choosing bulbs</span>
      <h2 id="lt-kelvin-title">What color temperature should you choose for each room?</h2>
    </div>
    <p class="answer-block reveal-up">Choose warm white around 2700K to 3000K for living rooms, bedrooms and dining rooms, 3500K to 4000K for kitchens, bathrooms, garages and offices, and 5000K daylight for workshops, warehouses and security lights. Keeping one color temperature per room avoids the patchy look of mismatched bulbs.</p>
    <div class="lt-scale reveal-up">
      <div class="lt-scale__bar" aria-hidden="true"></div>
      <ul class="lt-scale__ticks">
        <li><b>2700K</b><em>Warm white</em><span>Living rooms, bedrooms, dining rooms.</span></li>
        <li><b>3000K</b><em>Soft white</em><span>Kitchens with a warm finish, hallways, porches.</span></li>
        <li><b>3500K</b><em>Neutral</em><span>Kitchens, bathrooms, retail sales floors.</span></li>
        <li><b>4000K</b><em>Cool white</em><span>Offices, garages, laundry rooms.</span></li>
        <li><b>5000K</b><em>Daylight</em><span>Workshops, warehouses, security lighting.</span></li>
      </ul>
    </div>
    <p class="lt-kelvin__note">The number is printed on the bulb box or the fixture label as a "K" value. Brightness is a separate number, in lumens, so a warm light can still be bright.</p>
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
      <h2 id="sp-related-title">What electrical work often goes with new <span class="text-accent">lighting</span>?</h2>
      <p class="hero-answer">Lighting jobs often turn up a second fix. A ceiling light coming down is the moment to put in a fan-rated box, a flickering light can trace back to a worn switch, and a room getting new lights may be due for other updates, so All Connected Electric LLC handles those in the same visit when it makes sense.</p>
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
    <p class="sp-related__hub">Lighting is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Lighting estimate</span>
      <h2 id="sp-cta-title">Want new lights or a dead fixture fixed in Hagerstown?</h2>
      <p>Tell us the room, the ceiling and what you have in mind, or call <?php echo esc(formatPhone($phone)); ?>. All Connected Electric LLC will follow up to look at the space and the circuit before pricing the work.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a lighting estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
