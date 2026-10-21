<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/panel-upgrades/ — Panel Upgrades, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical-code knowledge stated as such;
 * prices, timeframes, permits-pulled and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'panel-upgrades';
$pageService     = 'Panel Upgrades';
$pageTitle       = 'Panel Upgrades Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Electrical panel replacement, service upgrades and breaker repair in Hagerstown, MD. All Connected Electric LLC checks the load first. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'Do I need a permit to replace an electrical panel in Hagerstown or Washington County?',
     'a' => 'A panel replacement or service upgrade almost always needs an electrical permit and an inspection in Maryland. The rules and the office you deal with differ between the City of Hagerstown and unincorporated Washington County, so ask All Connected Electric LLC which applies to your address before the work is scheduled.'],
    ['q' => 'Can an EV charger go into an older Hagerstown home without a panel upgrade?',
     'a' => 'Sometimes. A Level 2 charger needs its own 240-volt circuit, and whether the existing panel can carry it depends on its size and what is already connected. A load calculation answers that. If the service is too small, the panel or service is upgraded first and the charger circuit goes in on the new panel.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Electrical panel upgrade';
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
    ['slug' => 'ev-charger-installation', 'icon' => 'battery-charging', 'desc' => 'A dedicated 240-volt circuit sized for the charger you bought.', 'bullets' => ['Panel capacity checked first', 'Hardwired or plug-in chargers', 'Garage or driveway installs']],
    ['slug' => 'generator-installation',  'icon' => 'power',            'desc' => 'Transfer switches and generator hookups wired to the panel.',  'bullets' => ['Portable or standby units', 'Transfer switch installed', 'Chosen circuits stay powered']],
    ['slug' => 'wiring-rewiring',         'icon' => 'waypoints',        'desc' => 'Rewiring and faulty wiring repair for older Hagerstown houses.', 'bullets' => ['Old wiring traced and tested', 'Circuits replaced room by room', 'New runs for renovations']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Panel Upgrades — page-specific: the "panel door" checklist (signature section).
   Tokens only.
   ========================================================================== */
.pu-check__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.pu-door {
  position: relative;
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border-radius: var(--radius-lg);
  background:
    linear-gradient(160deg, color-mix(in srgb, var(--color-secondary) 22%, var(--color-surface)) 0%, color-mix(in srgb, var(--color-secondary) 10%, var(--color-surface)) 100%);
  border: 1px solid color-mix(in srgb, var(--color-secondary) 35%, var(--color-line));
  box-shadow: var(--shadow-lg), inset 0 1px 0 color-mix(in srgb, var(--color-white) 70%, transparent);
}
.pu-door::before {
  content: "";
  position: absolute;
  top: var(--space-sm);
  left: 50%;
  width: var(--space-12);
  height: var(--space-1);
  border-radius: var(--radius-full);
  background: color-mix(in srgb, var(--color-secondary) 45%, var(--color-surface));
  transform: translateX(-50%);
}
.pu-door__label {
  display: flex;
  justify-content: space-between;
  gap: var(--space-sm);
  margin: 0 0 var(--space-md);
  padding: var(--space-xs) var(--space-sm);
  border-radius: var(--radius-sm);
  background: var(--color-surface);
  border: 1px dashed color-mix(in srgb, var(--color-secondary) 45%, var(--color-line));
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--color-muted);
}
.pu-breakers { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.pu-breakers li {
  display: grid;
  grid-template-columns: var(--space-8) 1fr;
  gap: var(--space-sm);
  align-items: center;
  padding: var(--space-xs) var(--space-sm);
  border-radius: var(--radius-sm);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  font-size: .82rem;
  color: var(--color-ink-2);
}
.pu-breakers li::before {
  content: "";
  height: var(--space-4);
  border-radius: var(--radius-sm);
  background: linear-gradient(90deg, var(--color-primary) 0 55%, color-mix(in srgb, var(--color-primary) 55%, var(--color-surface)) 55%);
  box-shadow: var(--shadow-sm);
}
.pu-breakers li.is-main { grid-column: 1 / -1; font-weight: 600; color: var(--color-ink); }
.pu-breakers li.is-main::before { background: linear-gradient(90deg, var(--color-accent) 0 55%, var(--color-accent-dark) 55%); }
.pu-breakers li.is-tripped::before { background: linear-gradient(90deg, color-mix(in srgb, var(--color-primary) 55%, var(--color-surface)) 0 45%, var(--color-danger) 45%); }
.pu-checklist { display: grid; gap: var(--space-md); margin: var(--space-lg) 0 0; padding: 0; list-style: none; counter-reset: pu; }
.pu-checklist li { counter-increment: pu; display: grid; grid-template-columns: var(--space-8) 1fr; gap: var(--space-sm); color: var(--color-ink-2); }
.pu-checklist li::before { content: counter(pu); font-family: var(--font-accent); font-size: 1.4rem; line-height: 1.1; color: var(--color-accent-dark); }
.pu-checklist b { color: var(--color-ink); }
@media (max-width: 900px) { .pu-check__grid { grid-template-columns: 1fr; } .pu-door { order: 2; } }
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
        <span class="eyebrow">Electrical panels &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Panel upgrades in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC replaces electrical panels, upgrades service capacity and repairs breakers for homes and commercial buildings in Hagerstown, MD. The job starts with a look at the panel and the load on it, so you know whether a breaker repair, a new panel or a bigger service is the right fix.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a panel estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('zap', 16); ?>Panel replacement</li>
          <li><?php echo icon('layers', 16); ?>Service upgrades</li>
          <li><?php echo icon('wrench', 16); ?>Breaker repair</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a panel upgrade estimate?</h2>
        <p class="hero-form-tagline">Tell us the main breaker size and what you plan to add.</p>
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
      <h2 id="sp-signs-title">What are the signs a Hagerstown home needs a <span class="text-accent">panel upgrade</span>?</h2>
    </div>
    <p class="answer-block reveal-up">The usual signs are breakers that trip again and again, lights that dim when a large appliance starts, a panel that feels warm or buzzes, and a plan to add a big load such as an EV charger or a heat pump. Any one of them is a reason to have the panel looked at before it gets worse.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">A panel rarely fails without warning. It trips, hums or runs warm first.</p>
        <p>Many Hagerstown houses still run on the panel they were built with, sized for a household that had no central air, no EV and far fewer appliances. The signs below are what an overloaded or worn-out panel looks like from the hallway.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>Breakers that will not stay on</h3>
          <p>A breaker that trips every time the microwave and the toaster run together is telling you the circuit is at its limit. One that trips with almost nothing plugged in may be failing itself. Both get checked, because resetting it over and over is not a fix.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Lights dim when something starts</h3>
          <p>A brief dip when the air conditioner, well pump or dryer kicks on points to a service that is close to full.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('flame', 20); ?></span>
          <h3>A warm, buzzing or scorched cover</h3>
          <p>Heat and buzzing usually mean a loose connection or a breaker that is breaking down. Treat it as urgent.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>No room for one more circuit</h3>
          <p>Every slot is full, or two wires share one breaker, and you still want to add a circuit.</p>
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
        <b>Est. <span><?php echo (int) $yearEstablished; ?></span></b>
        <span>Electrical contractor based on Leitersburg Pike in Hagerstown, working on homes, commercial buildings and industrial sites.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have All Connected Electric look at your panel?</h2>
        <p class="answer-block">All Connected Electric LLC is a Hagerstown electrical contractor, owned by <?php echo esc($ownerName); ?>, that has worked on houses, commercial buildings and industrial sites since <?php echo (int) $yearEstablished; ?>. That range matters for panels: the new one is sized to what the building runs today and what you plan to add next, not copied from the old label.</p>
        <ul class="sp-points">
          <li><?php echo icon('clipboard-list', 20); ?><div><b>Sized from a load calculation</b><span>The appliances, heating and cooling, square footage and planned additions are added up before a panel or service size is chosen. That is the method the National Electrical Code lays out for dwellings, and it is what tells you whether 100 amps is still enough.</span></div></li>
          <li><?php echo icon('building-2', 20); ?><div><b>Commercial panels too</b><span>The same company replaces panels and adds capacity in offices, storefronts and shops. See <?php echo serviceLink('commercial-electrical', 'commercial electrical work in Hagerstown'); ?> for that side of the business.</span></div></li>
          <li><?php echo icon('route', 20); ?><div><b>The utility side explained up front</b><span>A service upgrade usually means Potomac Edison, the utility serving Hagerstown, has to disconnect and reconnect the service. Ask how that sequence works for your address before the day is set.</span></div></li>
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
        <h2 id="sp-scope-title">What does a panel upgrade from All Connected Electric include?</h2>
        <p class="answer-block">A panel upgrade covers taking out the old panel, installing a new one with breakers matched to each circuit, reconnecting and labeling every circuit, and bringing grounding and bonding up to current code. When the service size goes up, the meter base and the service entrance cable are usually replaced as well.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>New panel and breakers</b>, each breaker sized to the wire it protects.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Every circuit labeled</b> so the next person, or you at 2 a.m., can find the right breaker.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Grounding and bonding</b> checked and corrected to what the inspector will look for.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>AFCI or GFCI protection</b> on circuits where current code calls for it.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Surge protection</b> at the panel, which recent editions of the National Electrical Code require when a home's service equipment is replaced. Ask what applies to your job.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a panel upgrade go from first call to finished?</h3>
        <ol class="sp-steps">
          <li><b>You describe the problem</b><span>What trips, what you plan to add, and the number on the main breaker if you can see it.</span></li>
          <li><b>The panel and load are checked</b><span>The panel, the main breaker, the service cable and what is connected are looked at before any price is given.</span></li>
          <li><b>Scope and permit</b><span>You get the size, the parts and what the job needs from the City of Hagerstown or Washington County.</span></li>
          <li><b>Install day</b><span>Power is off while the old panel comes out and the new one goes in, then circuits are reconnected one at a time.</span></li>
          <li><b>Inspection and walk-through</b><span>After inspection you see the labeled panel and what changed.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: WHICH FIX ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sp-compare-title">Do you need a new panel, a bigger service, or only a breaker repair?</h2>
    </div>
    <p class="answer-block reveal-up">Not every tripping breaker means a new panel. A single failed breaker in a sound panel is a repair; a full or damaged panel is a replacement; a building that needs more power than its service delivers needs a service upgrade. The load check is what separates the three, and this table shows how they differ.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Breaker repair, panel replacement, service upgrade and subpanel compared</caption>
        <thead>
          <tr><th scope="col">Option</th><th scope="col">Usually the fix when</th><th scope="col">What gets replaced</th><th scope="col">What to plan for</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Breaker repair</th><td>One breaker trips with little load, runs warm, or will not reset, and the panel is otherwise sound.</td><td>The breaker, and the connection at it if that is damaged.</td><td>Usually a short visit. The circuit is off while the breaker is changed.</td></tr>
          <tr><th scope="row">Panel replacement</th><td>The panel is full, damaged, corroded, or a brand with a known safety record such as Federal Pacific Stab-Lok or Zinsco.</td><td>The panel and all breakers, at the same service size.</td><td>Power is off for the swap. A permit and inspection apply.</td></tr>
          <tr><th scope="row">Service upgrade</th><td>The load calculation shows the building needs more than its service delivers, often 100 amps going to 200.</td><td>Panel, breakers, and usually the meter base and service entrance cable.</td><td>Utility disconnect and reconnect, permit and inspection.</td></tr>
          <tr><th scope="row">Subpanel</th><td>The main service has capacity left but no room, or a garage, shop or addition needs its own panel.</td><td>Nothing; a new subpanel is fed from the main panel.</td><td>Only works if the load calculation shows spare capacity.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Planning an EV charger, a heat pump or a finished basement? Those are the most common reasons a load calculation comes back short. <?php echo serviceLink('ev-charger-installation', 'How EV charger installs are sized'); ?> explains the charger side.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: PANEL DOOR CHECKLIST ============ -->
<section class="section pu-check" aria-labelledby="pu-check-title">
  <div class="container">
    <div class="pu-check__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Before you call</span>
        <h2 id="pu-check-title">What should you check on your panel before you call?</h2>
        <p class="answer-block">Five things on the panel door make the first call faster: the number on the main breaker, the brand name, how many open slots are left, any breaker that is tripped or warm, and whether the panel has its original circuit list. A phone photo of the open door works just as well.</p>
        <ol class="pu-checklist">
          <li><span><b>The main breaker number.</b> Usually 100, 150 or 200, printed on the large breaker at the top. That is the service size.</span></li>
          <li><span><b>The brand on the label.</b> Federal Pacific and Zinsco panels are replaced rather than repaired.</span></li>
          <li><span><b>Open slots.</b> Count the empty spaces. Zero means a new circuit needs a bigger panel or a subpanel.</span></li>
          <li><span><b>Tripped or warm breakers.</b> Note which ones, and do not keep resetting them. If the cover is hot, leave it closed and call.</span></li>
          <li><span><b>The circuit list.</b> Faded or missing labels are common in older houses and get redone on a replacement.</span></li>
        </ol>
      </div>
      <div class="pu-door reveal-right" aria-hidden="true">
        <p class="pu-door__label"><span>Service panel</span><span>Main 100A</span></p>
        <ul class="pu-breakers">
          <li class="is-main">Main breaker &middot; service size</li>
          <li>Kitchen counters</li>
          <li>Range 240V</li>
          <li class="is-tripped">Bath &middot; tripped</li>
          <li>Dryer 240V</li>
          <li>Bedrooms</li>
          <li>Furnace</li>
          <li>Basement</li>
          <li>Open slot?</li>
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

<!-- ============ 8. FAQ (research-brief questions only) ============ -->
<?php if ($pageFaqs): ?>
<section class="section sp-faq" aria-labelledby="sp-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sp-faq-title">What do Hagerstown homeowners ask about panel upgrades?</h2>
      <p>Two questions come up before almost every panel job in the Hagerstown area: whether a permit is needed, and whether a new EV charger means a new panel. Here is how All Connected Electric LLC answers both.</p>
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
      <h2 id="sp-related-title">What electrical work often goes with a <span class="text-accent">panel upgrade</span>?</h2>
      <p class="hero-answer">A new panel is often the first step, not the last. Once the capacity is there, All Connected Electric LLC can add the EV charger circuit, wire a generator transfer switch, or replace the old wiring the panel feeds, so the whole job is planned around one load calculation instead of three separate visits.</p>
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
    <p class="sp-related__hub">Panel work is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Panel estimate</span>
      <h2 id="sp-cta-title">Want a price on a panel upgrade in Hagerstown?</h2>
      <p>Send the main breaker size and what you plan to add, or call <?php echo esc(formatPhone($phone)); ?>. All Connected Electric LLC will follow up to set a time to look at the panel. If the cover is hot or smells of burning, switch off the main if it is safe to do so and call right away.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a panel estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
