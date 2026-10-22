<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/outlet-switch-repair/ — Outlet & Switch Repair, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical-code knowledge stated as such;
 * prices, timeframes, smart-device brands and credentials are NOT claimed — see /content-confirmations.json.
 * No FAQ section: the research brief has no outlet- or switch-specific customer question.
 */
$pageSlug        = 'outlet-switch-repair';
$pageService     = 'Outlet & Switch Repair';
$pageTitle       = 'Hagerstown Outlet & Switch Repair | All Connected Electric';
$pageDescription = 'Dead outlets, faulty switches, GFCI outlets and short circuits repaired in Hagerstown, MD homes and businesses. Call All Connected Electric: (301) 704-6333.';
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
$svcNode['serviceType'] = 'Electrical outlet and switch repair';
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
    ['slug' => 'wiring-rewiring',       'icon' => 'waypoints', 'desc' => 'When the outlet is fine but the cable feeding it is not.',      'bullets' => ['Ungrounded circuits replaced', 'Loose splices found', 'Old cable traced']],
    ['slug' => 'lighting-installation', 'icon' => 'lightbulb', 'desc' => 'New fixtures, recessed lights and outdoor lighting installed.', 'bullets' => ['Dimmer-compatible LED fixtures', 'Recessed lighting added', 'Outdoor lights repaired']],
    ['slug' => 'emergency-electrician', 'icon' => 'flame',     'desc' => 'Troubleshooting for sparks, burning smells and power loss.',    'bullets' => ['Burning smells investigated', 'Tripping breakers traced', 'Power loss diagnosed']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Outlet & Switch Repair — page-specific: the device guide, drawn as wall plates (signature section).
   Tokens only.
   ========================================================================== */
.os-plates { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; padding: 0; list-style: none; }
.os-plate { display: grid; grid-template-columns: var(--space-16) 1fr; gap: var(--space-md); align-items: start; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); transition: box-shadow var(--transition), transform var(--transition); }
.os-plate:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
.os-face {
  position: relative;
  display: grid;
  justify-items: center;
  align-content: center;
  gap: var(--space-2);
  width: var(--space-16);
  aspect-ratio: 2 / 3;
  border-radius: var(--radius);
  background: linear-gradient(170deg, var(--color-surface) 0%, var(--color-paper-2) 100%);
  border: 1px solid color-mix(in srgb, var(--color-ink) 18%, var(--color-line));
  box-shadow: var(--shadow-sm), inset 0 -2px 0 color-mix(in srgb, var(--color-ink) 6%, transparent);
}
.os-face i { display: block; width: var(--space-8); height: var(--space-6); border-radius: var(--radius-sm); background: var(--color-paper-2); border: 1px solid var(--color-line); position: relative; }
.os-face i::before, .os-face i::after { content: ""; position: absolute; top: 30%; width: 3px; height: 35%; border-radius: 1px; background: var(--color-ink); }
.os-face i::before { left: 28%; }
.os-face i::after { right: 28%; }
.os-face--gfci::after { content: "TEST · RESET"; font-family: var(--font-accent); font-size: .5rem; letter-spacing: .08em; color: var(--color-danger); }
.os-face--usb i:last-child { width: var(--space-6); height: var(--space-3); }
.os-face--usb i:last-child::before, .os-face--usb i:last-child::after { display: none; }
.os-face--switch i { width: var(--space-4); height: var(--space-8); border-radius: var(--radius-sm); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.os-face--switch i::before, .os-face--switch i::after { display: none; }
.os-face--dimmer i { width: var(--space-3); height: var(--space-10); background: linear-gradient(180deg, var(--color-accent) 0 40%, var(--color-paper-2) 40%); }
.os-face--dimmer i::before, .os-face--dimmer i::after { display: none; }
.os-face--afci::after { content: "AFCI"; font-family: var(--font-accent); font-size: .55rem; letter-spacing: .1em; color: var(--color-secondary); }
.os-plate h3 { font-size: 1.02rem; margin-bottom: var(--space-1); }
.os-plate p { margin: 0; font-size: .9rem; color: var(--color-ink-2); }
.os-plate__where { display: block; margin-top: var(--space-xs); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-dark); }
@media (max-width: 1000px) { .os-plates { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 600px) { .os-plates { grid-template-columns: 1fr; } }
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
        <span class="eyebrow">Outlets &amp; switches &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Outlet and switch repair in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC repairs and replaces dead outlets, faulty light switches, GFCI outlets and short circuits in Hagerstown homes and businesses. A dead outlet is often a tripped GFCI or a loose connection elsewhere on the circuit, so the circuit is traced instead of just swapping the device.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an outlet repair estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('plug', 16); ?>Dead outlets traced</li>
          <li><?php echo icon('droplets', 16); ?>GFCI outlets</li>
          <li><?php echo icon('lightbulb', 16); ?>Switches &amp; dimmers</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an outlet or switch fixed?</h2>
        <p class="hero-form-tagline">Tell us which room and what stopped working.</p>
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
      <span class="eyebrow-label">Warning signs</span>
      <h2 id="sp-signs-title">Which outlet and switch problems should not be ignored?</h2>
    </div>
    <p class="answer-block reveal-up">Outlet and switch problems involving heat or sparks should never be ignored. That means a cover plate that is warm or discolored, a pop or flash when something is plugged in, a switch or dimmer that buzzes or gets hot, and plugs that fall out because the outlet no longer grips. Each points to a failing connection.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">An outlet is the end of the circuit, so it is where a loose connection gets noticed first.</p>
        <p>Outlets and switches are handled every day, and in older Hagerstown houses many are decades old. Contacts wear, screws back out, and the older back-stab connections loosen, which is why a device that looks fine can still be the problem.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('flame', 20); ?></span>
          <h3>Warm or discolored plates</h3>
          <p>A cover that feels warm, or shows a brown or melted ring, means the connection behind it is overheating. Stop using it and switch off the breaker. A light-colored plate that has slowly yellowed near one slot is the same warning in slow motion.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>A pop or flash at the plug</h3>
          <p>A bigger spark than usual, or a pop, often means a short or worn contacts.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Buzzing or hot dimmers</h3>
          <p>Dimmers run slightly warm, but buzzing or real heat means it is overloaded or failing.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>Plugs that fall out</h3>
          <p>Worn contacts make poor connections, and poor connections make heat.</p>
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
        <span>Based at <?php echo esc($address['street']); ?>, Hagerstown, working in homes, storefronts and shops across the county.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why call All Connected Electric for a dead outlet?</h2>
        <p class="answer-block">A dead outlet is a circuit problem more often than a device problem, and All Connected Electric LLC treats it that way. The Hagerstown contractor, owned by <?php echo esc($ownerName); ?>, traces the circuit back toward the panel to find the actual failure, so the outlet that gets replaced is the one that caused it.</p>
        <ul class="sp-points">
          <li><?php echo icon('search', 20); ?><div><b>The whole circuit, not one box</b><span>Outlets are wired in a chain. When one connection fails, every outlet after it goes dead, so the fix is often two or three boxes away from the outlet you noticed.</span></div></li>
          <li><?php echo icon('droplets', 20); ?><div><b>GFCI protection checked upstream</b><span>One GFCI can protect several outlets downstream, including ones in another room or outside. A tripped GFCI in the garage is a common reason a bathroom outlet stops working.</span></div></li>
          <li><?php echo icon('building-2', 20); ?><div><b>Businesses as well as homes</b><span>Worn receptacles in an office or a shop get the same treatment. For larger jobs see <?php echo serviceLink('commercial-electrical', 'commercial electrical work'); ?>.</span></div></li>
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
        <h2 id="sp-scope-title">What does an outlet or switch repair include?</h2>
        <p class="answer-block">An outlet or switch repair includes finding why the device failed, fixing the connection or wiring behind it, and replacing the device with the right type for that location. That might mean a GFCI near a sink, a tamper-resistant outlet in a bedroom, or a dimmer rated for the LED bulbs you actually use.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Dead outlets</b> traced to the loose connection, tripped GFCI or failed device.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Light switch repair</b> for switches that flicker, stick or control nothing.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>GFCI outlet installation</b> in kitchens, bathrooms, laundry areas, garages, basements and outdoors.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Short circuit repair</b> when a breaker trips the moment something is plugged in or switched on.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Upgrades</b> to USB outlets, dimmers and smart switches. Many smart switches need a neutral wire, which is checked first.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How is a dead outlet tracked down?</h3>
        <ol class="sp-steps">
          <li><b>Check the easy causes</b><span>Tripped breakers and GFCI outlets on the same circuit are reset and tested.</span></li>
          <li><b>Map the circuit</b><span>Which outlets and lights share it, and which is the last one that still works.</span></li>
          <li><b>Open the boxes</b><span>The connections between the last working outlet and the first dead one are inspected.</span></li>
          <li><b>Repair and replace</b><span>Loose or burned connections are fixed and worn devices replaced.</span></li>
          <li><b>Test everything on the run</b><span>Every outlet on the circuit is tested, including GFCI trip and reset.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: WHERE THE PROBLEM IS ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Troubleshooting</span>
      <h2 id="sp-compare-title">Is the problem the outlet, the circuit, or something upstream?</h2>
    </div>
    <p class="answer-block reveal-up">The pattern tells you where the outlet problem is. One dead outlet with live neighbors points to the device or its connection; a row of dead outlets points to the circuit; a breaker that trips the instant something is plugged in points to a short. The table lists what you can safely check yourself first.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Common outlet and switch symptoms, likely causes and safe first checks</caption>
        <thead>
          <tr><th scope="col">What you notice</th><th scope="col">Likely cause</th><th scope="col">Safe first check</th><th scope="col">Call when</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">One outlet dead, others fine</th><td>Worn device or a loose connection at that box.</td><td>Look for a GFCI nearby that has tripped.</td><td>It stays dead after resetting.</td></tr>
          <tr><th scope="row">Several outlets dead</th><td>A failed connection upstream on the circuit.</td><td>Check the breaker and every GFCI in the house, garage and outside.</td><td>Breaker and GFCIs are fine but outlets are still dead.</td></tr>
          <tr><th scope="row">Breaker trips on plug-in</th><td>A short in the device, the cord or the wiring.</td><td>Try a different appliance on that outlet.</td><td>It trips with anything plugged in.</td></tr>
          <tr><th scope="row">Switch flickers or does nothing</th><td>Worn switch, loose wire, or a dimmer not rated for LED bulbs.</td><td>Try a different bulb.</td><td>New bulb, same problem.</td></tr>
          <tr><th scope="row">Warm plate, scorch mark, smell</th><td>An overheating connection.</td><td>Turn off the breaker. Do not use it.</td><td>Right away.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">If outlets all over the house are two-prong or several circuits keep failing, the problem may be the wiring itself. See <?php echo serviceLink('wiring-rewiring', 'how older wiring is assessed and replaced'); ?>.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: DEVICE GUIDE ============ -->
<section class="section os-guide" aria-labelledby="os-guide-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Device guide</span>
      <h2 id="os-guide-title">Which outlet or switch belongs where in your home?</h2>
    </div>
    <p class="answer-block reveal-up">The right outlet or switch depends on the room. GFCI outlets go where water is nearby, AFCI protection covers living-area circuits under current code, and tamper-resistant outlets are required in new home work. USB outlets, dimmers and smart switches are upgrades, each with its own wiring needs. Here is how the six common devices compare.</p>
    <ul class="os-plates reveal-up">
      <li class="os-plate">
        <span class="os-face" aria-hidden="true"><i></i><i></i></span>
        <div><h3>Tamper-resistant outlet</h3><p>Shutters inside the slots block anything but a real plug, which protects small children.</p><span class="os-plate__where">Throughout a home</span></div>
      </li>
      <li class="os-plate">
        <span class="os-face os-face--gfci" aria-hidden="true"><i></i><i></i></span>
        <div><h3>GFCI outlet</h3><p>Cuts power in a fraction of a second if current leaks to ground, such as through water. Test it monthly with the button.</p><span class="os-plate__where">Kitchen, bath, laundry, garage, basement, outdoors</span></div>
      </li>
      <li class="os-plate">
        <span class="os-face os-face--afci" aria-hidden="true"><i></i><i></i></span>
        <div><h3>AFCI protection</h3><p>Detects arcing from damaged cords or loose wires, a common cause of house fires. Usually a breaker, sometimes an outlet.</p><span class="os-plate__where">Bedrooms, living areas, halls</span></div>
      </li>
      <li class="os-plate">
        <span class="os-face os-face--usb" aria-hidden="true"><i></i><i></i></span>
        <div><h3>USB outlet</h3><p>Charging ports built into the receptacle, so a bedside or kitchen counter loses the adapter clutter.</p><span class="os-plate__where">Kitchens, bedrooms, offices</span></div>
      </li>
      <li class="os-plate">
        <span class="os-face os-face--dimmer" aria-hidden="true"><i></i></span>
        <div><h3>Dimmer switch</h3><p>Must match the bulbs. An older dimmer with LED lamps often flickers or buzzes.</p><span class="os-plate__where">Dining, living, bedrooms</span></div>
      </li>
      <li class="os-plate">
        <span class="os-face os-face--switch" aria-hidden="true"><i></i></span>
        <div><h3>Smart switch</h3><p>App or voice control and schedules. Most models need a neutral wire in the box, which many older switch boxes lack.</p><span class="os-plate__where">Wherever the wiring allows</span></div>
      </li>
    </ul>
    <p class="sp-table-note">Swapping a dimmer is the usual fix for flickering LEDs. For new fixtures or recessed lights, see <?php echo serviceLink('lighting-installation', 'lighting installation in Hagerstown'); ?>.</p>
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
      <h2 id="sp-related-title">What if the <span class="text-accent">outlet</span> is not the real problem?</h2>
      <p class="hero-answer">Sometimes the outlet is just where a bigger problem shows up. Repeated failures on the same circuit can mean old wiring, flickering can mean a lighting circuit that needs work, and heat or a burning smell is an urgent call. All Connected Electric LLC handles each of these, starting from the outlet that first got your attention.</p>
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
    <p class="sp-related__hub">Outlet and switch repair is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Outlet &amp; switch repair</span>
      <h2 id="sp-cta-title">Got an outlet or switch that will not cooperate?</h2>
      <p>Tell us which outlets are dead and whether you have already reset the GFCIs, or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>. All Connected Electric LLC will follow up to set a time. If a plate is warm or scorched, turn off that breaker and leave the outlet unused until it is checked.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a repair estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
