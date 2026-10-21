<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/residential-electrical/ — Residential Electrical, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical-code knowledge stated as such;
 * prices, timeframes, permits-pulled and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'residential-electrical';
$pageService     = 'Residential Electrical';
$pageTitle       = 'Residential Electrical Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Home electrical repairs, kitchen and bathroom circuits, surge protection, smart home wiring and safety inspections in Hagerstown, MD. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'How can I check that an electrician working on my house is licensed in Maryland?',
     'a' => 'Maryland requires electrical contractors to hold a license, and you can look one up through the Maryland State Board of Master Electricians, part of the Maryland Department of Labor. Ask the electrician for the license number before work starts, and ask for proof of general liability and workers\' compensation coverage while you are at it.'],
    ['q' => 'What does a home electrical repair cost in Hagerstown?',
     'a' => 'It depends on what is wrong, how the house is wired, the parts involved and whether the job needs a permit. A dead outlet traced to a loose connection is a very different job from a circuit that has to be replaced. Call All Connected Electric LLC at (301) 704-6333, describe the problem, and ask how pricing works for your repair.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Residential electrical services';
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
    ['slug' => 'panel-upgrades',       'icon' => 'zap',       'desc' => 'New panels and bigger services for houses that have outgrown theirs.', 'bullets' => ['Room for new circuits', 'Worn breakers replaced', 'Capacity for EVs and heat pumps']],
    ['slug' => 'wiring-rewiring',      'icon' => 'waypoints', 'desc' => 'Old or damaged house wiring traced, repaired or replaced.',              'bullets' => ['Knob-and-tube replaced', 'Ungrounded circuits updated', 'Wiring for renovations']],
    ['slug' => 'outlet-switch-repair', 'icon' => 'plug',      'desc' => 'Dead outlets, worn switches and GFCI devices repaired or replaced.',     'bullets' => ['Dead outlets traced', 'GFCI outlets installed', 'Dimmers and smart switches']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Residential Electrical — page-specific: the room-by-room "floor plan" (signature section).
   Tokens only.
   ========================================================================== */
.res-plan {
  display: grid;
  grid-template-columns: repeat(6, minmax(0, 1fr));
  grid-auto-rows: minmax(var(--space-16), auto);
  gap: var(--space-1);
  padding: var(--space-1);
  border-radius: var(--radius-lg);
  background: var(--color-ink);
  box-shadow: var(--shadow-lg);
}
.res-room {
  position: relative;
  display: grid;
  gap: var(--space-xs);
  align-content: start;
  padding: var(--space-lg) var(--space-md) var(--space-md);
  background: var(--color-surface);
  border-radius: var(--radius-sm);
  transition: background var(--transition);
}
.res-room:hover { background: color-mix(in srgb, var(--color-accent) 9%, var(--color-surface)); }
.res-room--kitchen { grid-column: span 3; grid-row: span 2; }
.res-room--bath { grid-column: span 3; }
.res-room--laundry { grid-column: span 3; }
.res-room--living { grid-column: span 2; }
.res-room--basement { grid-column: span 2; }
.res-room--garage { grid-column: span 2; }
.res-room--outdoor { grid-column: 1 / -1; background: color-mix(in srgb, var(--color-secondary) 10%, var(--color-surface)); }
.res-room__tag {
  position: absolute;
  top: 0;
  left: var(--space-md);
  transform: translateY(-50%);
  padding: var(--space-1) var(--space-xs);
  border-radius: var(--radius-sm);
  background: var(--color-accent);
  color: var(--color-ink);
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
}
.res-room h3 { font-size: 1rem; display: flex; align-items: center; gap: var(--space-xs); }
.res-room h3 svg { color: var(--color-accent-dark); }
.res-room p { margin: 0; font-size: .88rem; color: var(--color-ink-2); }
.res-room ul { display: flex; flex-wrap: wrap; gap: var(--space-1); margin: var(--space-1) 0 0; padding: 0; list-style: none; }
.res-room li { font-size: .74rem; font-weight: 600; color: var(--color-ink); border: 1px solid var(--color-line); border-radius: var(--radius-full); padding: 2px var(--space-xs); background: var(--color-paper); }
.res-plan__note { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: var(--color-muted); max-width: 70ch; }
@media (max-width: 900px) {
  .res-plan { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .res-room--kitchen, .res-room--bath, .res-room--laundry, .res-room--living, .res-room--basement, .res-room--garage { grid-column: span 1; grid-row: auto; }
  .res-room--kitchen, .res-room--outdoor { grid-column: 1 / -1; }
}
@media (max-width: 520px) { .res-plan { grid-template-columns: 1fr; } .res-room { grid-column: 1 / -1 !important; } }
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
        <span class="eyebrow">Home electrical &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Home electrical work in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC handles home electrical work in Hagerstown, MD: repairs, kitchen and bathroom circuits, surge protection, smart home wiring, safety inspections and wiring for new homes and additions. Describe what is happening in the house, and the circuit or room is looked at before anything is quoted.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a home estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('house', 16); ?>Kitchen &amp; bath circuits</li>
          <li><?php echo icon('shield-check', 16); ?>Whole-home surge protection</li>
          <li><?php echo icon('search', 16); ?>Electrical safety inspections</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an electrician at your house?</h2>
        <p class="hero-form-tagline">Tell us which room and what it is doing.</p>
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
      <span class="eyebrow-label">When to call</span>
      <h2 id="sp-signs-title">When does a Hagerstown house need an electrician, not a quick fix?</h2>
    </div>
    <p class="answer-block reveal-up">A house needs an electrician when a problem keeps coming back or involves heat. Think of outlets that go dead, lights that flicker in one room, a GFCI that trips for no clear reason, or extension cords doing the job of permanent wiring. Each one usually points to a loose connection or a circuit asked to do too much.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">Most household electrical problems are a nuisance for months before they are a hazard.</p>
        <p>Plenty of Hagerstown homes have had a kitchen remodeled, a bathroom redone or a basement finished on top of wiring that is decades older. The trouble tends to show up where the new and the old meet.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>Outlets that quit, then come back</h3>
          <p>An outlet that works some days and not others almost always has a loose connection, either at that device or at another outlet upstream on the same circuit. Loose connections make heat, so this one is worth chasing down rather than living with.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Flicker in one room only</h3>
          <p>If only one room flickers, the cause is usually on that circuit, not the utility.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('droplets', 20); ?></span>
          <h3>A GFCI that will not stay set</h3>
          <p>Moisture in an outdoor box, a failing appliance or a worn GFCI itself are the usual suspects.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('link', 20); ?></span>
          <h3>Extension cords as wiring</h3>
          <p>A power strip run behind the couch for years is a sign the room needs more outlets, not more cords.</p>
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
        <b><span>3</span> sectors</b>
        <span>Residential, commercial and industrial work from one Hagerstown company, owned by <?php echo esc($ownerName); ?>.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why hire All Connected Electric for work on your home?</h2>
        <p class="answer-block">All Connected Electric LLC is a Hagerstown electrical contractor that wires and repairs houses as well as businesses and industrial sites. For a homeowner that means one company for a dead kitchen circuit, a surge protector at the panel and the wiring for an addition, planned around how your particular house was built.</p>
        <ul class="sp-points">
          <li><?php echo icon('house', 20); ?><div><b>Work planned around the house you have</b><span>An older brick house near downtown and a newer house on the edge of town are wired very differently. The existing wiring and panel are checked first, so new work is not stacked on a circuit that cannot carry it. If the panel is the limit, <?php echo serviceLink('panel-upgrades', 'a panel upgrade'); ?> comes first.</span></div></li>
          <li><?php echo icon('shield-check', 20); ?><div><b>Surge protection where it does the most</b><span>A whole-home surge protective device at the panel covers every circuit, including the furnace, the refrigerator and the dishwasher, which plug-in strips do not.</span></div></li>
          <li><?php echo icon('map-pin', 20); ?><div><b>Based in Hagerstown</b><span>The company works out of <?php echo esc($address['street']); ?> on Leitersburg Pike, so the houses it wires are local ones.</span></div></li>
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
        <h2 id="sp-scope-title">Which home electrical services does All Connected Electric cover?</h2>
        <p class="answer-block">All Connected Electric covers home repairs, kitchen and bathroom wiring, surge protection, smart home wiring, safety inspections and new-home wiring around Hagerstown. Bigger jobs such as rewiring, panel upgrades and EV chargers have their own pages with more detail on how each one is done.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Repairs</b> for dead circuits, flickering lights, warm outlets and breakers that trip.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Kitchen electrical</b>: dedicated circuits for the range, dishwasher, disposal and microwave, plus GFCI-protected countertop outlets.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Bathroom wiring</b> for vanity lights, exhaust fans and GFCI outlets near the sink and tub.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Smart home wiring</b> for smart switches, video doorbells and hardwired detectors. Many smart switches need a neutral wire that older switch boxes do not have.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>House electrical inspections</b> to see what condition the wiring and panel are in, useful before buying or renovating.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>New home and addition wiring</b>, from rough-in to devices.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a home electrical visit work?</h3>
        <ol class="sp-steps">
          <li><b>Tell us what the house is doing</b><span>Which room, what stopped working, and whether anything was changed recently.</span></li>
          <li><b>Trace it to the source</b><span>The circuit is followed from the problem back toward the panel instead of guessing at one device.</span></li>
          <li><b>Explain the fix</b><span>You hear what failed, what it takes to repair, and whether anything else on that circuit needs attention.</span></li>
          <li><b>Repair and test</b><span>The work is done and the circuit is tested with you before the visit ends.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: WHICH VISIT ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Do you need a repair, an upgrade or a house electrical inspection?</h2>
    </div>
    <p class="answer-block reveal-up">You need a repair when something specific has stopped working. An upgrade fits when the house needs more than its wiring was built for, and an inspection when you want to know the condition of the whole system before a sale, a renovation or a new appliance. The table shows how the three visits differ.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Home electrical repair, upgrade and inspection compared</caption>
        <thead>
          <tr><th scope="col">Visit</th><th scope="col">Pick it when</th><th scope="col">What happens</th><th scope="col">What you leave with</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Repair</th><td>One outlet, switch, light or circuit has stopped working or acts up.</td><td>The fault is traced, the damaged part or connection is fixed, the circuit is tested.</td><td>A working circuit and an explanation of what failed.</td></tr>
          <tr><th scope="row">Upgrade</th><td>You are adding appliances, finishing space, or running out of outlets and capacity.</td><td>New circuits, outlets or protection are added, sometimes with panel work.</td><td>Wiring that matches how the house is used now.</td></tr>
          <tr><th scope="row">Safety inspection</th><td>You are buying, selling, insuring or renovating an older house.</td><td>Panel, visible wiring, outlets and protection devices are checked room by room.</td><td>A list of what is fine, what should be fixed, and what is urgent.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Inspections in older Hagerstown houses often turn up original wiring. <?php echo serviceLink('wiring-rewiring', 'How rewiring an older house is planned'); ?> covers what happens next.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: ROOM BY ROOM ============ -->
<section class="section res-rooms" aria-labelledby="res-rooms-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Room by room</span>
      <h2 id="res-rooms-title">What does current electrical code expect in each room of your house?</h2>
    </div>
    <p class="answer-block reveal-up">Current electrical code puts the most protection where water and heavy appliances are. That means GFCI outlets in kitchens, bathrooms, laundry areas, garages, basements and outdoors, AFCI protection on living-area circuits, and tamper-resistant outlets throughout a home. Older Hagerstown houses often predate some of these rules, which is fine until that room is worked on.</p>
    <div class="res-plan reveal-up">
      <div class="res-room res-room--kitchen">
        <span class="res-room__tag">Busiest room</span>
        <h3><?php echo icon('flame', 18); ?>Kitchen</h3>
        <p>The range, dishwasher, disposal, microwave and refrigerator each tend to want a circuit of their own, and countertop outlets are split across at least two small-appliance circuits. Remodels are where kitchens most often outgrow the original wiring.</p>
        <ul><li>GFCI countertops</li><li>Dedicated circuits</li><li>Under-cabinet lights</li></ul>
      </div>
      <div class="res-room res-room--bath">
        <h3><?php echo icon('droplets', 18); ?>Bathrooms</h3>
        <p>Outlets near the sink need GFCI protection; exhaust fans keep moisture off the walls.</p>
        <ul><li>GFCI</li><li>Exhaust fan circuit</li></ul>
      </div>
      <div class="res-room res-room--laundry">
        <h3><?php echo icon('waves', 18); ?>Laundry</h3>
        <p>A 240-volt dryer circuit, plus a GFCI-protected outlet for the washer.</p>
        <ul><li>240V dryer</li><li>GFCI</li></ul>
      </div>
      <div class="res-room res-room--living">
        <h3><?php echo icon('house', 18); ?>Bedrooms &amp; living</h3>
        <p>AFCI protection on new circuits, and enough outlets to retire the cords.</p>
        <ul><li>AFCI</li><li>Tamper-resistant</li></ul>
      </div>
      <div class="res-room res-room--basement">
        <h3><?php echo icon('layers', 18); ?>Basement</h3>
        <p>Finishing one means lighting, outlets and often a subpanel.</p>
        <ul><li>GFCI</li><li>New circuits</li></ul>
      </div>
      <div class="res-room res-room--garage">
        <h3><?php echo icon('car', 18); ?>Garage</h3>
        <p>GFCI outlets, shop circuits, and the likely spot for an EV charger.</p>
        <ul><li>GFCI</li><li>240V options</li></ul>
      </div>
      <div class="res-room res-room--outdoor">
        <h3><?php echo icon('sun', 18); ?>Outdoors &amp; whole house</h3>
        <p>Weather-resistant GFCI outlets with in-use covers outside, and a surge protective device at the panel that protects every circuit inside.</p>
        <ul><li>In-use covers</li><li>Whole-home surge</li><li>Hardwired detectors</li></ul>
      </div>
    </div>
    <p class="res-plan__note">Code requirements apply to new work and depend on the code edition the City of Hagerstown or Washington County enforces; existing wiring is not automatically out of compliance. Planning a charger in the garage? See <?php echo serviceLink('ev-charger-installation', 'how a home EV charger circuit is sized'); ?>.</p>
  </div>
</section>

<!-- ============ 7. PROOF: GOOGLE REVIEWS (Page One feed; renders nothing until the profile has written reviews) ============ -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$pageReviews = p1_google_reviews($slug, ['heading' => 'What Hagerstown homeowners say about All Connected Electric']);
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
      <h2 id="sp-faq-title">What do Hagerstown homeowners ask before hiring an electrician?</h2>
      <p>Homeowners in Washington County tend to ask two things before anyone opens a wall: how to confirm the electrician is licensed in Maryland, and what a home electrical repair is going to cost. Here are straight answers to both.</p>
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
      <h2 id="sp-related-title">Which <span class="text-accent">home electrical</span> jobs are bigger than a repair?</h2>
      <p class="hero-answer">Some home problems turn out to be symptoms of something larger. A panel with no open slots, original wiring behind plaster walls, or a house full of two-prong outlets each has its own page, because each one is planned differently from a single repair and is often the reason the repair kept failing.</p>
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
    <p class="sp-related__hub">Home work is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Home estimate</span>
      <h2 id="sp-cta-title">Want someone to look at the electrical in your house?</h2>
      <p>Send the room, the symptom and roughly how old the house is, or call <?php echo esc(formatPhone($phone)); ?>. All Connected Electric LLC will follow up to set a time. If an outlet or switch is hot to the touch, turn that circuit off at the panel and leave it off until it has been checked.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a home estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
