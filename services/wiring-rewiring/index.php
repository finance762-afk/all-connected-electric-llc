<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/wiring-rewiring/ — Wiring & Rewiring, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical knowledge stated as such;
 * prices, timeframes, permits-pulled, wall patching and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'wiring-rewiring';
$pageService     = 'Wiring & Rewiring';
$pageTitle       = 'Wiring & Rewiring in Hagerstown, MD | All Connected Electric';
$pageDescription = 'House rewiring, faulty wiring repair and new wiring for renovations in Hagerstown, MD. Knob-and-tube and ungrounded circuits replaced. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'Does rewiring a house in Hagerstown or Washington County need a permit?',
     'a' => 'Rewiring, new circuits and wiring for an addition or renovation generally need an electrical permit and an inspection in Maryland, often with a rough-in inspection before the walls are closed. The office and the rules differ between the City of Hagerstown and unincorporated Washington County, so ask All Connected Electric LLC which applies to your house before work is scheduled.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Electrical wiring and rewiring';
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
    ['slug' => 'panel-upgrades',        'icon' => 'zap',       'desc' => 'A panel with the capacity and space new circuits need.',          'bullets' => ['Fuse boxes replaced', 'Breakers matched to wiring', 'Room for added circuits']],
    ['slug' => 'outlet-switch-repair',  'icon' => 'plug',      'desc' => 'Grounded, GFCI and tamper-resistant outlets on the new circuits.', 'bullets' => ['Two-prong outlets replaced', 'GFCI near water', 'Worn switches swapped']],
    ['slug' => 'lighting-installation', 'icon' => 'lightbulb', 'desc' => 'New fixtures and recessed lights while the ceilings are open.',  'bullets' => ['Recessed lighting runs', 'Fixtures on new circuits', 'Outdoor lights rewired']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Wiring & Rewiring — page-specific: "wiring by the age of the house" era timeline (signature section).
   A horizontal conductor line runs through four era stops. Tokens only.
   ========================================================================== */
.wr-eras { position: relative; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; padding: 0; list-style: none; }
.wr-eras::before {
  content: "";
  position: absolute;
  top: calc(var(--space-12) / 2);
  left: 0;
  right: 0;
  height: var(--space-1);
  border-radius: var(--radius-full);
  background: linear-gradient(90deg, color-mix(in srgb, var(--color-danger) 70%, var(--color-surface)) 0%, var(--color-warning) 40%, var(--color-accent) 70%, var(--color-success) 100%);
}
.wr-era { position: relative; display: grid; gap: var(--space-sm); align-content: start; }
.wr-era__dot {
  position: relative;
  z-index: 1;
  display: grid;
  place-items: center;
  width: var(--space-12);
  height: var(--space-12);
  border-radius: var(--radius-full);
  background: var(--color-dark);
  color: var(--color-accent-bright);
  border: var(--space-1) solid var(--color-paper);
  box-shadow: var(--shadow);
}
.wr-era__years { font-family: var(--font-accent); font-size: 1.35rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); line-height: 1; }
.wr-era h3 { font-size: 1.05rem; }
.wr-era p { margin: 0; font-size: .92rem; color: var(--color-ink-2); }
.wr-era__risk {
  justify-self: start;
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
  padding: var(--space-1) var(--space-xs);
  border-radius: var(--radius-sm);
  border: 1px solid var(--color-line);
  background: var(--color-surface);
  color: var(--color-ink-2);
}
.wr-era--1 .wr-era__risk { border-color: var(--color-danger); color: var(--color-danger); }
.wr-era--2 .wr-era__risk { border-color: var(--color-warning); }
.wr-era--4 .wr-era__risk { border-color: var(--color-success); color: var(--color-success); }
.wr-eras__note { margin: var(--space-xl) 0 0; padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: var(--color-surface); border: 1px dashed var(--color-line); font-size: var(--fs-small); color: var(--color-ink-2); max-width: 72ch; }
@media (max-width: 900px) {
  .wr-eras { grid-template-columns: 1fr; gap: var(--space-xl); padding-left: var(--space-lg); }
  .wr-eras::before { top: 0; bottom: 0; left: calc(var(--space-lg) + var(--space-12) / 2 - var(--space-1) / 2); right: auto; width: var(--space-1); height: auto; background: linear-gradient(180deg, color-mix(in srgb, var(--color-danger) 70%, var(--color-surface)) 0%, var(--color-warning) 40%, var(--color-accent) 70%, var(--color-success) 100%); }
  .wr-era { grid-template-columns: var(--space-12) 1fr; column-gap: var(--space-md); }
  .wr-era > :not(.wr-era__dot) { grid-column: 2; }
  .wr-era__dot { grid-row: span 4; }
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
        <span class="eyebrow">House wiring &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Wiring and rewiring in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC repairs faulty wiring, replaces old circuits and runs new wiring for renovations and additions in Hagerstown, MD. In an older house the first step is finding out what kind of wiring is behind the walls and which circuits can stay, before any rewiring is priced.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a rewiring estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('search', 16); ?>Faulty wiring traced</li>
          <li><?php echo icon('house', 16); ?>Older-home rewiring</li>
          <li><?php echo icon('hammer', 16); ?>Renovation wiring</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a rewiring estimate?</h2>
        <p class="hero-form-tagline">Tell us roughly when the house was built and what you are seeing.</p>
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
      <h2 id="sp-signs-title">How can you tell the wiring in an older Hagerstown house is wearing out?</h2>
    </div>
    <p class="answer-block reveal-up">Worn-out wiring shows itself through heat, smell and flicker. Watch for switch plates that feel warm, brown scorch marks at outlets, lights that flicker when a door closes, a faint hot-plastic smell, and two-prong outlets throughout the house. Any of these means the circuit should be opened up and checked.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">Wire insulation does not last forever. Heat and age make it brittle long before anything stops working.</p>
        <p>Hagerstown has a large stock of older houses, from brick rowhouses near downtown to farmhouses out in Washington County. Many still carry original wiring in some rooms, spliced into newer circuits wherever a kitchen or bath was redone.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('flame', 20); ?></span>
          <h3>Warm plates or scorch marks</h3>
          <p>A switch plate or outlet cover that is warm to the touch, or a brown ring around a receptacle, means a connection behind it is making heat. That is the single most important sign on this list, and the circuit should be switched off until someone opens the box.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>Two-prong outlets everywhere</h3>
          <p>Usually ungrounded circuits, common in houses wired before the 1960s.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Flicker you can trigger</h3>
          <p>If lights flicker when a door slams or a floor creaks, a splice is loose somewhere on that run.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('layers', 20); ?></span>
          <h3>Fuses instead of breakers</h3>
          <p>A fuse box usually means the wiring it feeds is just as old.</p>
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
        <b><span><?php echo count($services); ?></span> services</b>
        <span>Rewiring is planned alongside panel, outlet and lighting work by the same Hagerstown company, so the pieces fit together.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have All Connected Electric trace the wiring before rewiring?</h2>
        <p class="answer-block">Tracing the wiring first is what keeps a rewiring job from being bigger than it needs to be. All Connected Electric LLC, a Hagerstown contractor in business since <?php echo (int) $yearEstablished; ?>, maps which circuits are original, which were added later and which are failing, then rewires the ones that need it.</p>
        <ul class="sp-points">
          <li><?php echo icon('route', 20); ?><div><b>Circuit-by-circuit, not all-or-nothing</b><span>Many houses do not need every wire replaced at once. Original circuits in bedrooms and halls can be replaced first, with the kitchen or bath done when it is remodeled.</span></div></li>
          <li><?php echo icon('zap', 20); ?><div><b>The panel is part of the plan</b><span>New grounded circuits need breakers to land on. If the house still has a fuse box or a full panel, <?php echo serviceLink('panel-upgrades', 'replacing the panel'); ?> is usually scheduled with the rewiring.</span></div></li>
          <li><?php echo icon('house', 20); ?><div><b>Homes and businesses</b><span>The same approach applies to an older storefront or office building, where tenants and equipment have changed many times over the years.</span></div></li>
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
        <span class="eyebrow-label">What's involved</span>
        <h2 id="sp-scope-title">What does rewiring a house involve?</h2>
        <p class="answer-block">Rewiring a house means replacing old cable with modern grounded cable, circuit by circuit, along with the boxes and devices it feeds. Each new run is pulled through walls, floors and the attic or basement, connected to the panel on a correctly sized breaker, then tested and inspected before the walls are closed.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Circuit mapping</b> so you know which outlets and lights share a breaker before anything is cut.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>New grounded cable</b> to replace knob-and-tube, cloth-insulated or ungrounded runs.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>New boxes and devices</b>, with grounded outlets in place of two-prong ones.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>AFCI and GFCI protection</b> on the new circuits where current code calls for it.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Small, planned openings</b> in plaster or drywall where cable has to pass. Ask who handles the patching on your job.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a rewiring job run from start to finish?</h3>
        <ol class="sp-steps">
          <li><b>Walk-through and mapping</b><span>Outlets, switches and lights are tested and matched to breakers or fuses.</span></li>
          <li><b>A plan by circuit</b><span>You see which circuits are replaced now, which can wait and how the panel fits in.</span></li>
          <li><b>Rough-in</b><span>New cable is run and boxes are set, then the rough-in is inspected while walls are still open.</span></li>
          <li><b>Devices and testing</b><span>Outlets, switches and fixtures go back on and every circuit is tested.</span></li>
          <li><b>Final inspection</b><span>The finished work is inspected, and you get a labeled panel.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: SCOPE OF WORK ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Should you repair the faulty wiring, rewire part of the house, or rewire all of it?</h2>
    </div>
    <p class="answer-block reveal-up">Repair the faulty wiring when one circuit has one problem. Rewire part of the house when several circuits share the same old cable, and rewire all of it when original wiring runs through most rooms or the insulation is crumbling. The walk-through decides which, and the table below shows the trade-offs between the three.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Faulty wiring repair, partial rewiring, whole-house rewiring and renovation wiring compared</caption>
        <thead>
          <tr><th scope="col">Scope</th><th scope="col">Fits when</th><th scope="col">What changes</th><th scope="col">Disruption</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Faulty wiring repair</th><td>One circuit has a loose splice, a damaged run or a burned connection.</td><td>The damaged section, splice or device on that circuit.</td><td>Low. Usually one area and one circuit off.</td></tr>
          <tr><th scope="row">Partial rewiring</th><td>Some rooms still run on original cable; others were updated.</td><td>The original circuits only, room by room.</td><td>Moderate. Openings in the rooms being done.</td></tr>
          <tr><th scope="row">Whole-house rewiring</th><td>Knob-and-tube or brittle cloth cable runs through most of the house.</td><td>Nearly every circuit, often with a new panel.</td><td>High. Best planned with any renovation.</td></tr>
          <tr><th scope="row">Renovation wiring</th><td>A kitchen, bath, basement or addition is being built or gutted.</td><td>New circuits for the remodeled space.</td><td>Done while walls are open anyway.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Sparks, smoke or a burning smell are not a rewiring question. Turn off the circuit and see <?php echo serviceLink('emergency-electrician', 'what to do in an electrical emergency'); ?>.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: WIRING BY THE AGE OF THE HOUSE ============ -->
<section class="section wr-age" aria-labelledby="wr-age-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Wiring by era</span>
      <h2 id="wr-age-title">What kind of wiring is likely behind the walls of your house?</h2>
    </div>
    <p class="answer-block reveal-up">The likely wiring behind your walls depends on when the house was built and last updated. Very old homes may have knob-and-tube, mid-century houses often have cloth-sheathed cable without a ground, some homes from the late 1960s and early 1970s used aluminum branch wiring, and later houses have plastic-sheathed cable with a ground wire.</p>
    <ol class="wr-eras reveal-up">
      <li class="wr-era wr-era--1">
        <span class="wr-era__dot"><?php echo icon('milestone', 20); ?></span>
        <span class="wr-era__years">Early 1900s&ndash;1930s</span>
        <h3>Knob-and-tube</h3>
        <p>Single wires on porcelain knobs, no ground, insulation that turns brittle. Not built for modern loads or for being buried in attic insulation.</p>
        <span class="wr-era__risk">Replace</span>
      </li>
      <li class="wr-era wr-era--2">
        <span class="wr-era__dot"><?php echo icon('waypoints', 20); ?></span>
        <span class="wr-era__years">1930s&ndash;1960s</span>
        <h3>Cloth-sheathed, ungrounded</h3>
        <p>Two-wire cable in a fabric jacket, feeding two-prong outlets. The jacket and insulation dry out with age and heat.</p>
        <span class="wr-era__risk">Inspect</span>
      </li>
      <li class="wr-era wr-era--3">
        <span class="wr-era__dot"><?php echo icon('link', 20); ?></span>
        <span class="wr-era__years">Late 1960s&ndash;1970s</span>
        <h3>Aluminum branch wiring</h3>
        <p>Used in some homes of this period. Connections at outlets and switches can loosen and overheat unless they use devices and connectors rated for aluminum.</p>
        <span class="wr-era__risk">Check connections</span>
      </li>
      <li class="wr-era wr-era--4">
        <span class="wr-era__dot"><?php echo icon('shield-check', 20); ?></span>
        <span class="wr-era__years">Later homes</span>
        <h3>Grounded plastic-sheathed cable</h3>
        <p>Copper conductors with a ground wire in a plastic jacket. Usually fine to keep; problems tend to be at individual connections.</p>
        <span class="wr-era__risk">Usually keep</span>
      </li>
    </ol>
    <p class="wr-eras__note">Dates are rough. Houses were updated at different times, so one Hagerstown home can have three of these in different rooms. The walk-through is what tells you for certain. For outlet-level problems on otherwise sound wiring, <?php echo serviceLink('residential-electrical', 'home electrical repairs'); ?> may be all you need.</p>
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
      <h2 id="sp-faq-title">Is a permit needed to rewire a house in Washington County?</h2>
      <p>The permit question comes up on nearly every rewiring job in the Hagerstown area, because the answer depends on whether the house is inside city limits or in unincorporated Washington County.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($pageFaqs as $pageFaqIdx => $pageFaq): ?>
      <details class="faq"<?php echo $pageFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($pageFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo linkContacts(esc($pageFaq['a'])); ?></p>
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
      <h2 id="sp-related-title">What else gets done while the <span class="text-accent">walls are open</span>?</h2>
      <p class="hero-answer">Rewiring, while the walls are open, is the easiest moment to fix everything the old wiring held back. With cable already being pulled, All Connected Electric LLC can replace the panel those circuits land on, put grounded and GFCI outlets where the two-prong ones were, and run new lighting before the plaster or drywall is patched.</p>
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
    <p class="sp-related__hub">Wiring is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Rewiring estimate</span>
      <h2 id="sp-cta-title">Want to know what is behind your walls?</h2>
      <p>Send the year the house was built, if you know it, and what you have noticed, or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>. All Connected Electric LLC will follow up to set up a walk-through. If a plate is warm or you smell hot plastic, switch that circuit off at the panel and leave it off.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a rewiring estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
