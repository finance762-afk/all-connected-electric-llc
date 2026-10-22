<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/generator-installation/ — Generator Installation, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Transfer-switch and interlock descriptions are general electrical facts, not client claims. Prices, generator
 * brands, dealer status, timeframes, permits-pulled and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'generator-installation';
$pageService     = 'Generator Installation';
$pageTitle       = 'Hagerstown Generator Installation | All Connected Electric';
$pageDescription = 'Generator hookups, transfer switches and standby generator wiring in Hagerstown, MD to keep chosen circuits on in an outage. Call All Connected Electric today.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'Do I need a permit to install a generator or transfer switch in Washington County?',
     'a' => 'Usually, yes. A transfer switch, a panel interlock or a standby generator changes how power enters the building, and Maryland jurisdictions generally expect that work to be permitted and inspected; the gas line to a standby unit can need its own permit. The rules differ between the City of Hagerstown and Washington County, so ask All Connected Electric LLC which applies to your address before scheduling.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Generator and transfer switch installation';
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
    ['slug' => 'panel-upgrades',        'icon' => 'zap',          'desc' => 'A panel with room for the interlock or transfer switch the generator needs.', 'bullets' => ['Full panels replaced', 'Service capacity added', 'Circuits relabeled clearly']],
    ['slug' => 'emergency-electrician', 'icon' => 'shield-check', 'desc' => 'Troubleshooting when power is lost inside the building, not on the street.',   'bullets' => ['Dead circuits traced', 'Breakers that will not reset', 'Burning smells investigated']],
    ['slug' => 'commercial-electrical', 'icon' => 'building-2',   'desc' => 'Electrical work for offices, storefronts and other Hagerstown businesses.',    'bullets' => ['Backup power for businesses', 'New equipment circuits', 'Commercial lighting repairs']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Generator Installation — page-specific: the "what stays on" circuit priority tiers (signature section).
   Tokens only.
   ========================================================================== */
.gen-tiers { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; padding: 0; list-style: none; }
.gen-tier {
  position: relative;
  display: grid;
  gap: var(--space-sm);
  align-content: start;
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-line);
  background: var(--color-surface);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
}
.gen-tier::before { content: ""; position: absolute; inset: 0 auto auto 0; height: var(--space-1); background: var(--color-accent); }
.gen-tier--1::before { width: 100%; }
.gen-tier--2::before { width: 66%; background: color-mix(in srgb, var(--color-accent) 70%, var(--color-secondary)); }
.gen-tier--3::before { width: 33%; background: var(--color-secondary); }
.gen-tier--1 { background: var(--color-card-tint-3); border-color: color-mix(in srgb, var(--color-accent) 40%, var(--color-line)); }
.gen-tier__head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-sm); }
.gen-tier__rank { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.gen-tier__meter { display: flex; gap: var(--space-1); }
.gen-tier__meter i { display: block; width: var(--space-2); height: var(--space-4); border-radius: var(--radius-sm); background: var(--color-line); }
.gen-tier--1 .gen-tier__meter i { background: var(--color-primary); }
.gen-tier--2 .gen-tier__meter i:nth-child(-n+2) { background: var(--color-primary); }
.gen-tier--3 .gen-tier__meter i:first-child { background: var(--color-primary); }
.gen-tier h3 { font-size: 1.1rem; }
.gen-tier p { margin: 0; font-size: .93rem; color: var(--color-ink-2); }
.gen-tier ul { display: grid; gap: var(--space-xs); margin: 0; padding: var(--space-sm) 0 0; list-style: none; border-top: 1px solid var(--color-line); }
.gen-tier ul li { position: relative; padding-left: var(--space-lg); font-size: .92rem; color: var(--color-ink); }
.gen-tier ul li::before { content: ""; position: absolute; left: 0; top: .55em; width: var(--space-2); height: var(--space-2); border-radius: var(--radius-full); background: var(--color-accent-dark); }
.gen-note { display: flex; gap: var(--space-sm); align-items: flex-start; margin-top: var(--space-lg); padding: var(--space-md) var(--space-lg); border-left: 3px solid var(--color-danger); background: var(--color-surface); border-radius: 0 var(--radius) var(--radius) 0; font-size: var(--fs-small); color: var(--color-ink-2); max-width: 80ch; }
.gen-note svg { color: var(--color-danger); flex: 0 0 auto; margin-top: 2px; }
.gen-note p { margin: 0; }
@media (max-width: 900px) { .gen-tiers { grid-template-columns: 1fr; } }
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
        <span class="eyebrow">Backup power &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Generator installation in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC connects generators to homes and businesses in Hagerstown, MD, through a transfer switch or an approved panel interlock, so the circuits you choose stay powered and nothing feeds back onto Potomac Edison's lines. Portable hookups, standby generator wiring and generator repair are all part of the work.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a generator estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('power', 16); ?>Transfer switches</li>
          <li><?php echo icon('plug', 16); ?>Portable generator hookups</li>
          <li><?php echo icon('home', 16); ?>Standby generator wiring</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a generator hookup estimate?</h2>
        <p class="hero-form-tagline">Tell us the generator you have, or what must stay on.</p>
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
      <h2 id="sp-signs-title">When is it time to wire a <span class="text-accent">generator</span> into a Hagerstown home or business?</h2>
    </div>
    <p class="answer-block reveal-up">It is time to wire in a generator when an outage would cost more than the hookup: a sump or well pump that cannot stop, medical equipment, a freezer full of food, or a business that loses sales every hour it is dark. Winter ice storms and summer thunderstorms in Washington County make those outages a regular risk.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">A generator is only as safe as the way it connects to the house.</p>
        <p>Plugging a generator into a dryer outlet with a double-ended cord, sometimes called backfeeding, can send power back out through the meter and onto the street. That puts Potomac Edison line crews and neighbors at risk, and can destroy the generator when utility power returns. A transfer switch or interlock is what prevents it.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('droplets', 20); ?></span>
          <h3>A sump or well pump that cannot stop</h3>
          <p>A basement that floods during a summer storm outage, or a well pump that leaves the house without water, is the most common reason people wire in backup power. Both are motor loads, so the generator has to handle the surge each time the pump starts, not only its running draw.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>Extension cords through a window</h3>
          <p>Cords snaking from a portable generator to the fridge work for a night, but cannot reach the furnace or the well pump.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('snowflake', 20); ?></span>
          <h3>Heat that depends on electricity</h3>
          <p>Gas and oil furnaces still need power for the blower and controls. In a January ice storm, that matters.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('building-2', 20); ?></span>
          <h3>A business that cannot close</h3>
          <p>Refrigerated stock, a server closet or a register that must stay on through an outage.</p>
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
        <b><span><?php echo count($services); ?></span> Services</b>
        <span>Generator hookups sit next to panel work, rewiring and urgent repairs, all handled by one Hagerstown company on Leitersburg Pike.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have All Connected Electric connect your generator?</h2>
        <p class="answer-block">All Connected Electric LLC connects generators at the panel, where the switch-over has to happen safely. The company handles panels, wiring and repairs for homes, businesses and industrial sites in Hagerstown, so the transfer switch, the inlet and the circuits it feeds are planned together rather than added as an afterthought.</p>
        <ul class="sp-points">
          <li><?php echo icon('zap', 20); ?><div><b>Connected through the panel properly</b><span>An interlock needs a panel that accepts one, and a transfer switch needs room beside it. When the panel is full or worn out, <?php echo serviceLink('panel-upgrades', 'replacing or upgrading the panel'); ?> comes first.</span></div></li>
          <li><?php echo icon('clipboard-list', 20); ?><div><b>Sized to the circuits you choose</b><span>The list of what must stay on, and the starting surge of any pumps or compressors on it, decides the generator size and the switch you need.</span></div></li>
          <li><?php echo icon('wrench', 20); ?><div><b>Repairs when a unit will not start or transfer</b><span>Generator repair is part of the work, from a unit that will not hand over power to wiring at the inlet that has failed.</span></div></li>
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
        <h2 id="sp-scope-title">What does a generator installation from All Connected Electric include?</h2>
        <p class="answer-block">A generator installation covers picking the circuits to keep on, installing a transfer switch or panel interlock, adding an outdoor inlet box for a portable unit or wiring a standby unit's automatic switch, and running a full switch-over test so you know exactly what happens when the power drops.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>A transfer switch or interlock</b>, so utility power and generator power can never be connected at the same time.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>An outdoor power inlet</b> for a portable generator, placed so the unit can run outside, well away from windows, doors and vents because of carbon monoxide.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Standby generator wiring</b> between the unit, its automatic transfer switch and the panel. The fuel connection is gas work; ask how it is coordinated on your job.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Circuits labeled</b> on the switch or panel, so anyone in the house can tell what runs on generator power.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>A switch-over test</b> with you watching, start to finish.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a generator hookup go, from list to test?</h3>
        <ol class="sp-steps">
          <li><b>Make the must-stay-on list</b><span>Pumps, heat, refrigeration, medical equipment, and anything a business cannot lose.</span></li>
          <li><b>Panel and placement are checked</b><span>Room for a switch or interlock, and a spot outside for the inlet or the standby unit.</span></li>
          <li><b>Scope and permit</b><span>Switch type, inlet location, and what the City of Hagerstown or Washington County requires.</span></li>
          <li><b>Install day</b><span>The switch or interlock goes in, the inlet or standby wiring is run, and circuits are connected.</span></li>
          <li><b>Switch-over test</b><span>Utility power off, generator on, every chosen circuit checked, then back again.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: HOOKUP OPTIONS ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Which generator setup fits: an interlock, a manual transfer switch, or a standby unit?</h2>
    </div>
    <p class="answer-block reveal-up">The right generator setup depends on how much of the building has to run and whether someone will be home to start it. A portable generator with an interlock or a manual transfer switch keeps chosen circuits on at lower cost; a standby generator with an automatic transfer switch starts on its own within moments of an outage.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Portable generator with interlock, portable with manual transfer switch, and standby with automatic transfer switch compared</caption>
        <thead>
          <tr><th scope="col">Setup</th><th scope="col">How it switches</th><th scope="col">What it can power</th><th scope="col">What you do in an outage</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Portable + panel interlock</th><td>A plate on the panel lets the generator breaker on only when the main is off.</td><td>Any circuit in the panel, as long as the total stays within the generator's output.</td><td>Roll the generator out, plug into the inlet, start it, switch the main off and the generator breaker on.</td></tr>
          <tr><th scope="row">Portable + manual transfer switch</th><td>A separate switch box feeds a set number of pre-wired circuits.</td><td>Only the circuits wired to the switch, often six to ten.</td><td>Start the generator, plug in, flip each circuit on the switch to generator.</td></tr>
          <tr><th scope="row">Standby + automatic transfer switch</th><td>The switch senses the outage, starts the unit and transfers on its own.</td><td>Selected circuits or the whole house, depending on the unit's size.</td><td>Nothing. It runs on natural gas or propane until utility power returns.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">A standby generator also needs a level pad and clearances from windows, doors and the property line set by the manufacturer and local code. Which option suits your address is part of the estimate visit.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: WHAT STAYS ON ============ -->
<section class="section gen-priority" aria-labelledby="gen-priority-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Plan the circuits</span>
      <h2 id="gen-priority-title">Which circuits should stay on when the power goes out?</h2>
    </div>
    <p class="answer-block reveal-up">The circuits that should stay on are the ones that protect the building and the people in it: pumps, heat, refrigeration and any medical equipment come first, comfort loads second, big heaters and air conditioning only if the generator is large enough. Sorting your circuits into these three groups is the start of every generator plan.</p>
    <ol class="gen-tiers reveal-up">
      <li class="gen-tier gen-tier--1">
        <div class="gen-tier__head"><span class="gen-tier__rank">First priority</span><span class="gen-tier__meter" aria-hidden="true"><i></i><i></i><i></i></span></div>
        <h3>Protect the house</h3>
        <p>The loads that prevent damage or danger when an outage runs long.</p>
        <ul><li>Sump pump</li><li>Well pump</li><li>Furnace or boiler controls and blower</li><li>Refrigerator and freezer</li><li>Medical equipment</li></ul>
      </li>
      <li class="gen-tier gen-tier--2">
        <div class="gen-tier__head"><span class="gen-tier__rank">Second priority</span><span class="gen-tier__meter" aria-hidden="true"><i></i><i></i><i></i></span></div>
        <h3>Keep the house usable</h3>
        <p>Modest loads that make a day without power livable.</p>
        <ul><li>A few lighting circuits</li><li>Internet router and phone charging</li><li>Microwave</li><li>Garage door opener</li></ul>
      </li>
      <li class="gen-tier gen-tier--3">
        <div class="gen-tier__head"><span class="gen-tier__rank">If capacity allows</span><span class="gen-tier__meter" aria-hidden="true"><i></i><i></i><i></i></span></div>
        <h3>The big loads</h3>
        <p>Heavy 240-volt loads that usually need a large standby unit.</p>
        <ul><li>Central air conditioning</li><li>Electric water heater</li><li>Electric range and dryer</li><li>EV charger</li></ul>
      </li>
    </ol>
    <div class="gen-note" role="note">
      <?php echo icon('flame', 20); ?>
      <p><strong>Running a portable generator?</strong> Keep it outdoors, away from windows, doors and vents, and never in a garage, even with the door open. Carbon monoxide from a generator can kill within minutes.</p>
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

<!-- ============ 8. FAQ (research-brief questions only) ============ -->
<?php if ($pageFaqs): ?>
<section class="section sp-faq" aria-labelledby="sp-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sp-faq-title">Is a permit needed for generator work in Hagerstown?</h2>
      <p>The permit question comes up on almost every generator job in the Hagerstown area, because a transfer switch changes how power enters the building. Here is how All Connected Electric LLC answers it for the City of Hagerstown and Washington County.</p>
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
      <h2 id="sp-related-title">What other work pairs with a <span class="text-accent">generator hookup</span>?</h2>
      <p class="hero-answer">A generator hookup touches the rest of the electrical system. All Connected Electric LLC can replace a panel that has no room for an interlock, troubleshoot the circuits that fail when the power comes back, and plan standby power for a Hagerstown storefront or office, so the outage plan covers the whole building rather than one cord.</p>
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
    <p class="sp-related__hub">Generator work is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Generator estimate</span>
      <h2 id="sp-cta-title">Want a price on a generator hookup in Hagerstown?</h2>
      <p>Send the generator make and size if you already own one, plus the list of what must stay on, or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>. All Connected Electric LLC will follow up to look at the panel and where the inlet or standby unit can go.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a generator estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
