<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/emergency-electrician/ — Emergency Electrician, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Hours are not in intake: NO 24/7, same-day, after-hours or response-time claim anywhere on this page —
 * visitors are told to call and ask about availability. See /content-confirmations.json.
 */
$pageSlug        = 'emergency-electrician';
$pageService     = 'Emergency Electrician';
$pageTitle       = 'Emergency Electrician Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Lost power, a breaker that will not reset or a burning smell in Hagerstown, MD? What to do first, and how All Connected Electric LLC finds the fault.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'How much does an emergency electrician call cost in Hagerstown?',
     'a' => 'The price depends on what failed, how long it takes to find and the parts the repair needs, so a fair number comes once the fault is located. When you call All Connected Electric LLC, ask whether there is a service-call or diagnostic fee, whether it is credited toward the repair, and what availability looks like at that moment.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Emergency electrical troubleshooting and repair';
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
    ['slug' => 'outlet-switch-repair', 'icon' => 'plug',      'desc' => 'Dead, warm or scorched outlets and failing switches repaired or replaced.', 'bullets' => ['Scorched outlets replaced', 'GFCI outlets reset or replaced', 'Short circuits found']],
    ['slug' => 'panel-upgrades',       'icon' => 'zap',       'desc' => 'A new panel when breakers keep failing or the panel runs hot.',            'bullets' => ['Failing breakers replaced', 'Warm panels made safe', 'Capacity for new loads']],
    ['slug' => 'wiring-rewiring',      'icon' => 'waypoints', 'desc' => 'Damaged or aging wiring found and replaced in older buildings.',            'bullets' => ['Burned wiring replaced', 'Loose connections repaired', 'Old circuits rewired']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Emergency Electrician — page-specific: the safety-first alert band and the "call sheet" (signature section).
   Tokens only.
   ========================================================================== */
.em-alert { display: grid; grid-template-columns: auto 1fr; gap: var(--space-md); align-items: start; margin: 0 0 var(--space-xl); padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-danger) 40%, var(--color-line)); background: color-mix(in srgb, var(--color-danger) 7%, var(--color-surface)); box-shadow: var(--shadow-sm); }
.em-alert__icon { display: grid; place-items: center; width: var(--space-12); height: var(--space-12); border-radius: var(--radius-full); background: var(--color-danger); color: var(--color-white); animation: em-pulse 2.4s var(--ease) infinite; }
@keyframes em-pulse { 0%, 100% { box-shadow: 0 0 0 0 color-mix(in srgb, var(--color-danger) 45%, transparent); } 50% { box-shadow: 0 0 0 var(--space-3) color-mix(in srgb, var(--color-danger) 0%, transparent); } }
.em-alert p { margin: 0; color: var(--color-ink); }
.em-alert b { display: block; font-family: var(--font-heading); font-size: 1.05rem; margin-bottom: var(--space-1); }
.em-sheet__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.em-sheet {
  position: relative;
  padding: var(--space-xl) var(--space-xl) var(--space-lg) var(--space-3xl);
  border-radius: var(--radius-lg);
  background:
    linear-gradient(90deg, transparent calc(var(--space-2xl) - 1px), color-mix(in srgb, var(--color-danger) 35%, transparent) calc(var(--space-2xl) - 1px) var(--space-2xl), transparent var(--space-2xl)),
    var(--color-surface);
  border: 1px solid var(--color-line);
  box-shadow: var(--shadow-lg);
  transform: rotate(-.6deg);
}
.em-sheet__title { margin: 0 0 var(--space-md); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.em-sheet ol { display: grid; gap: var(--space-sm); margin: 0; padding: 0; list-style: none; counter-reset: em; }
.em-sheet li { counter-increment: em; display: grid; grid-template-columns: var(--space-6) 1fr; gap: var(--space-sm); padding-bottom: var(--space-sm); border-bottom: 1px dashed var(--color-line); font-size: .95rem; color: var(--color-ink-2); }
.em-sheet li:last-child { border-bottom: 0; padding-bottom: 0; }
.em-sheet li::before { content: ""; width: var(--space-4); height: var(--space-4); margin-top: var(--space-1); border: 2px solid var(--color-ink); border-radius: var(--radius-sm); }
.em-sheet li b { color: var(--color-ink); }
@media (max-width: 900px) { .em-sheet__grid { grid-template-columns: 1fr; } .em-sheet { transform: none; padding-left: var(--space-lg); background: var(--color-surface); } }
@media (max-width: 560px) { .em-alert { grid-template-columns: 1fr; } }
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
        <span class="eyebrow">Urgent electrical problems &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Emergency electrician in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC troubleshoots urgent electrical problems at homes and businesses in Hagerstown, MD: power lost to part of a building, breakers that will not reset, sparking outlets and burning smells. If there is smoke or flame, get out and call 911 first, then call <?php echo esc(formatPhone($phone)); ?> and ask about availability.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Describe the problem</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('zap', 16); ?>Power loss troubleshooting</li>
          <li><?php echo icon('search', 16); ?>Electrical fault finding</li>
          <li><?php echo icon('flame', 16); ?>Burning smells and sparks</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an electrician for an urgent problem?</h2>
        <p class="hero-form-tagline">For smoke, flame or a downed line, call 911 first.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($pageService); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Send the details</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="sp-hero-title">

<!-- ============ 2. PROBLEM: SAFETY FIRST ============ -->
<section class="section sp-signs" aria-labelledby="sp-signs-title">
  <div class="container">
    <div class="em-alert reveal-up" role="note">
      <span class="em-alert__icon"><?php echo icon('flame', 24); ?></span>
      <p><b>Smoke, flame, sparks or a strong burning smell?</b> Get everyone out of the building and call 911. Do not open a hot panel or try to unplug a smoking device. Call an electrician once the fire department says it is safe.</p>
    </div>
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Safety first</span>
      <h2 id="sp-signs-title">What should you do first when <span class="text-accent">something electrical</span> goes wrong?</h2>
    </div>
    <p class="answer-block reveal-up">What you do first depends on what you see: fire, smoke or a burning smell means leaving and calling 911; a downed line means staying well away and calling 911 and Potomac Edison; a dark street means reporting the outage to Potomac Edison. Only a problem inside your own building is a job for an electrician.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">Call 911 for fire. Call the utility for the street. Call an electrician for the building.</p>
        <p>Sorting out who to call first saves time on a bad day. Potomac Edison owns the lines and the meter that serve Hagerstown; everything from the meter into the building, including the panel, the wiring and the outlets, is the owner's side and the electrician's job.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('flame', 20); ?></span>
          <h3>Smoke, flame or a burning smell</h3>
          <p>Leave the building and call 911. A burning plastic or fishy smell near an outlet, switch or panel can mean wiring insulation is overheating even without visible smoke. Once the fire department has cleared it, the circuit stays off until the cause is found and repaired.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>A power line on the ground</h3>
          <p>Treat every downed line as live. Stay well away, keep others back, and call 911 and Potomac Edison.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('map-pin', 20); ?></span>
          <h3>The whole street is dark</h3>
          <p>Neighbors and streetlights out too usually means a utility outage. Report it to Potomac Edison.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>One room or circuit is dead</h3>
          <p>Check the panel for a tripped breaker and the nearest GFCI outlet for a popped reset button. Reset once.</p>
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
        <span>Houses, storefronts and shop floors: the urgent calls come from all three, and All Connected Electric has worked in all three since <?php echo (int) $yearEstablished; ?>.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why call All Connected Electric for an urgent electrical problem?</h2>
        <p class="answer-block">All Connected Electric LLC finds the fault before replacing parts. An urgent call is usually one failed connection, breaker or device somewhere along a circuit, and tracing it methodically from the panel to the last outlet is what turns a dead kitchen or a tripping breaker into a repair that holds instead of a reset that fails again.</p>
        <ul class="sp-points">
          <li><?php echo icon('search', 20); ?><div><b>Fault finding, not guesswork</b><span>The circuit is isolated, then tested at the panel and at each device until the loose, burned or shorted point turns up.</span></div></li>
          <li><?php echo icon('building-2', 20); ?><div><b>Homes, businesses and industrial sites</b><span>The same troubleshooting applies to a storefront that lost its lights, covered under <?php echo serviceLink('commercial-electrical', 'commercial electrical service in Hagerstown'); ?>, or a shop machine that stopped mid-shift.</span></div></li>
          <li><?php echo icon('wrench', 20); ?><div><b>The repair that follows</b><span>When the cause is a scorched receptacle, <?php echo serviceLink('outlet-switch-repair', 'outlet and switch repair'); ?> finishes the job. When it is the panel itself, the fix is planned from there.</span></div></li>
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
        <h2 id="sp-scope-title">What does emergency troubleshooting from All Connected Electric cover?</h2>
        <p class="answer-block">Emergency troubleshooting covers electrical problems on the building side of the meter: lost power to part of a house or business, breakers that trip the moment they are reset, short circuits, sparking or scorched outlets and switches, and failing panel parts. The first goal is always making the building safe; the full repair follows.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Power outage troubleshooting</b> when your building is dark or half-dark and the neighbors are not.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Tripping breakers and short circuits</b> traced to the wire, device or appliance causing them.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Sparking, warm or scorched devices</b> such as outlets, switches and light fixtures.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Panel problems</b> such as a breaker that will not latch, a buzzing bus or a burned connection.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Making it safe</b>: when a repair needs parts, the damaged circuit is isolated so the rest of the building can stay on.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does an urgent service call go?</h3>
        <ol class="sp-steps">
          <li><b>You call and describe it</b><span>What stopped, what you saw or smelled, and what you have already tried.</span></li>
          <li><b>The circuit is made safe</b><span>The affected circuit or equipment is shut off before anything is opened up.</span></li>
          <li><b>The fault is traced</b><span>From the panel through the circuit to the point that failed.</span></li>
          <li><b>Repair, or isolate and schedule</b><span>Fixed on the spot when parts allow; otherwise isolated with a plan for the repair.</span></li>
          <li><b>You hear what failed</b><span>What caused it, and whether anything else on the system needs attention.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: WHO TO CALL ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Who to call</span>
      <h2 id="sp-compare-title">Is a power problem Potomac Edison's job or an electrician's?</h2>
    </div>
    <p class="answer-block reveal-up">A power problem is Potomac Edison's job when it starts on the street side, at the lines or the meter, and an electrician's job when it starts inside the building. Half-power symptoms can be either, so report those to the utility first. The table below shows how each symptom usually sorts out.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Common power problems, what they usually mean, and who to call first</caption>
        <thead>
          <tr><th scope="col">What you notice</th><th scope="col">What it usually means</th><th scope="col">Call first</th><th scope="col">Avoid</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Neighbors and streetlights are out too</th><td>A utility outage on the lines.</td><td>Potomac Edison</td><td>Running a generator without a transfer switch.</td></tr>
          <tr><th scope="row">Your building is dark, neighbors are not</th><td>A problem at your service: the main breaker, the meter or the service drop.</td><td>Check the main breaker, then Potomac Edison, then an electrician.</td><td>Touching the meter or the service cable.</td></tr>
          <tr><th scope="row">Half the house works, or lights go dim and bright</th><td>Often one leg of the service or a loose neutral connection.</td><td>Potomac Edison, then an electrician if their side checks out.</td><td>Ignoring it. Loose neutrals can damage appliances.</td></tr>
          <tr><th scope="row">One circuit is dead</th><td>A tripped breaker, a popped GFCI or a failed connection.</td><td>Reset once; if it stays dead, an electrician.</td><td>Resetting a breaker again and again.</td></tr>
          <tr><th scope="row">A breaker trips the moment it is reset</th><td>A short circuit or a faulty appliance on that circuit.</td><td>An electrician.</td><td>Swapping in a bigger breaker.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Storm damage that pulls the service mast or meter base off the house is usually split: Potomac Edison handles the lines, and the owner's side needs an electrician before power can be restored.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: THE CALL SHEET ============ -->
<section class="section em-callsheet" aria-labelledby="em-sheet-title">
  <div class="container">
    <div class="em-sheet__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Before you call</span>
        <h2 id="em-sheet-title">What should you tell the electrician when you call?</h2>
        <p class="answer-block">Tell the electrician what stopped working, when it started, what was running at that moment, what the breaker or GFCI is doing now, and anything you saw, heard or smelled. Those five details narrow an urgent call down before anyone arrives, which means less time searching and a faster route to the actual repair.</p>
        <p class="prose">Write them down while they are fresh. A photo of the open panel, with the tripped breaker visible, helps too. Then call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a> and ask All Connected Electric LLC about availability.</p>
      </div>
      <div class="em-sheet reveal-right">
        <p class="em-sheet__title">Call sheet</p>
        <ol>
          <li><span><b>What stopped working.</b> One outlet, one room, half the house, or a whole machine.</span></li>
          <li><span><b>When it started.</b> During a storm, after a new appliance, or out of nowhere.</span></li>
          <li><span><b>What was running.</b> Space heater, microwave, dryer, a compressor, a shop tool.</span></li>
          <li><span><b>What the panel shows.</b> A tripped breaker, one that will not reset, or nothing at all.</span></li>
          <li><span><b>What you noticed.</b> Buzzing, crackling, flicker, heat, or a burning smell.</span></li>
          <li><span><b>How old the building is.</b> Original wiring in an older Hagerstown house changes where to look first.</span></li>
        </ol>
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

<!-- ============ 8. FAQ (research-brief questions only) ============ -->
<?php if ($pageFaqs): ?>
<section class="section sp-faq" aria-labelledby="sp-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sp-faq-title">What does an urgent electrical call cost in Hagerstown?</h2>
      <p>Cost is the question people ask on almost every urgent call, usually while the lights are still out. Here is how All Connected Electric LLC answers it, and what to ask before the visit.</p>
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
      <h2 id="sp-related-title">What repairs usually follow an <span class="text-accent">urgent call</span>?</h2>
      <p class="hero-answer">Most urgent calls end in one of three repairs. All Connected Electric LLC replaces the scorched outlet or failed switch that caused the trouble, replaces breakers or the whole panel when the panel is the source, and rewires the damaged run when old or overheated wiring is behind it, so the same problem does not return next month.</p>
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
    <p class="sp-related__hub">Emergency troubleshooting is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Urgent problem</span>
      <h2 id="sp-cta-title">Need an electrician for a problem that cannot wait?</h2>
      <p>Call <?php echo esc(formatPhone($phone)); ?>, describe what happened and ask about availability, or send the details with the form. If there is smoke, flame or a downed line, call 911 first.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Send the details</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
