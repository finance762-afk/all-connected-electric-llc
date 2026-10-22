<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/commercial-electrical/ — Commercial Electrical, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical knowledge stated as such;
 * prices, schedules, after-hours work, permits-pulled and credentials are NOT claimed — see /content-confirmations.json.
 */
$pageSlug        = 'commercial-electrical';
$pageService     = 'Commercial Electrical';
$pageTitle       = 'Hagerstown Commercial Electrician | All Connected Electric';
$pageDescription = 'Commercial electrical in Hagerstown, MD: equipment circuits, lighting, panels and repairs for offices and shops. Call All Connected Electric: (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [
    ['q' => 'Does a commercial build-out or tenant space in Hagerstown need an electrical permit?',
     'a' => 'Most do. New circuits, panel work and lighting changes in an office or storefront generally need an electrical permit and an inspection, and many leases also require the landlord to approve the work. Requirements differ between the City of Hagerstown and unincorporated Washington County, so confirm with All Connected Electric LLC which office covers your building before the work is scheduled.'],
];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Commercial electrical contracting';
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
    ['slug' => 'lighting-installation', 'icon' => 'lightbulb', 'desc' => 'Fixtures, recessed lights and exterior lighting installed or repaired.', 'bullets' => ['Dead fixtures traced and fixed', 'LED-friendly switches and dimmers', 'Exterior and sign lighting']],
    ['slug' => 'panel-upgrades',        'icon' => 'zap',       'desc' => 'More capacity when a building runs out of panel or service.', 'bullets' => ['Load calculated before sizing', 'Subpanels for added space', 'Worn breakers replaced']],
    ['slug' => 'industrial-electrical', 'icon' => 'hard-hat',  'desc' => 'Power distribution and equipment circuits for shops and plants.', 'bullets' => ['Three-phase equipment circuits', 'Feeders and distribution panels', 'Machine faults traced']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Commercial Electrical — page-specific: the "work order" ticket (signature section).
   Tokens only.
   ========================================================================== */
.com-prep { background: var(--color-paper-2); }
.com-prep__grid { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.com-ticket {
  position: relative;
  background: var(--color-surface);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  border: 1px solid var(--color-line);
  overflow: hidden;
}
.com-ticket__head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: var(--space-md);
  padding: var(--space-md) var(--space-lg);
  background: var(--color-primary);
  color: var(--color-white);
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .16em;
  text-transform: uppercase;
}
.com-ticket__head b { color: var(--color-accent-bright); font-size: 1rem; letter-spacing: .08em; }
.com-ticket__perf {
  height: var(--space-md);
  background:
    radial-gradient(circle at var(--space-2) 50%, var(--color-paper-2) calc(var(--space-2) - 1px), transparent var(--space-2)) 0 0 / var(--space-6) 100% repeat-x;
  border-bottom: 1px dashed var(--color-line);
}
.com-ticket ul { display: grid; gap: 0; margin: 0; padding: var(--space-xs) var(--space-lg) var(--space-lg); list-style: none; }
.com-ticket li {
  display: grid;
  grid-template-columns: var(--space-6) 1fr;
  gap: var(--space-sm);
  align-items: start;
  padding: var(--space-sm) 0;
  border-bottom: 1px solid color-mix(in srgb, var(--color-line) 70%, transparent);
  font-size: .92rem;
  color: var(--color-ink-2);
}
.com-ticket li:last-child { border-bottom: 0; }
.com-ticket li::before {
  content: "";
  width: var(--space-5);
  height: var(--space-5);
  margin-top: 2px;
  border: 2px solid var(--color-ink);
  border-radius: var(--radius-sm);
  background: linear-gradient(135deg, transparent 45%, var(--color-accent) 45% 60%, transparent 60%);
}
.com-ticket li b { color: var(--color-ink); display: block; }
.com-ticket__foot { margin: 0; padding: var(--space-sm) var(--space-lg); border-top: 1px dashed var(--color-line); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.com-prep .prose p { margin-bottom: var(--space-md); }
@media (max-width: 900px) { .com-prep__grid { grid-template-columns: 1fr; } }
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
        <span class="eyebrow">Offices &amp; storefronts &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Commercial electrician in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC handles electrical installation, repair and upgrades for offices, storefronts and other commercial buildings in Hagerstown, MD. That covers new circuits for added equipment, lighting, panel capacity and tracking down faults, planned around the business so the work fits how the space is used each day.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a commercial estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('building-2', 16); ?>Offices &amp; storefronts</li>
          <li><?php echo icon('lightbulb', 16); ?>Commercial lighting</li>
          <li><?php echo icon('plug', 16); ?>Circuits for new equipment</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a commercial electrical estimate?</h2>
        <p class="hero-form-tagline">Tell us the building, the business and what needs to change.</p>
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
      <h2 id="sp-signs-title">When does a Hagerstown business need a <span class="text-accent">commercial electrician</span>?</h2>
    </div>
    <p class="answer-block reveal-up">A business needs a commercial electrician when it adds equipment the existing circuits were never built for, when breakers trip during the busiest hours, when lighting flickers or goes dark, or when a tenant space is being fitted out. Each of those reaches customers or staff, so it is worth fixing before it interrupts a working day.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">Electrical trouble in a business tends to show up at the busiest hour, when everything is switched on at once.</p>
        <p>Many of the older commercial buildings in downtown Hagerstown, around Potomac Street and Washington Street, were wired for a very different tenant than the one in them now. Newer buildings out toward the interstates fill up with equipment their original circuits never planned for. Either way, the warning signs look much the same.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('zap', 20); ?></span>
          <h3>Breakers that trip at peak hours</h3>
          <p>The lunch rush, the Monday morning start, the afternoon when every space heater and printer runs at once: if a breaker gives out at the same time every week, the circuit is carrying more than it was sized for. Moving loads around or adding a dedicated circuit is usually the cure, and the panel is checked to see which one fits.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plug', 20); ?></span>
          <h3>New equipment, nowhere to plug it in</h3>
          <p>A cooler, a coffee machine, a copier or a register run off an extension cord is a circuit that should exist.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>Lighting that flickers or quits</h3>
          <p>Dark aisles, dead tubes and buzzing fixtures make a sales floor or an office look closed.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('building', 20); ?></span>
          <h3>A space changing hands</h3>
          <p>A new tenant rarely needs the outlets, lighting and circuits the last one left behind.</p>
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
        <span>Residential, commercial and industrial electrical work from one Hagerstown company since <?php echo (int) $yearEstablished; ?>.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why use All Connected Electric for commercial electrical work in Hagerstown?</h2>
        <p class="answer-block">All Connected Electric LLC is a Hagerstown electrical contractor, owned by <?php echo esc($ownerName); ?> and based on Leitersburg Pike, that has done residential, commercial and industrial work since <?php echo (int) $yearEstablished; ?>. A business gets one contractor for the storefront lighting, the office circuits and the equipment in the back room, instead of a separate call for each.</p>
        <ul class="sp-points">
          <li><?php echo icon('calendar-check', 20); ?><div><b>Planned around how the space is used</b><span>Before work starts, the schedule is talked through: which circuits go off, for how long, and what has to keep running, from the register to the walk-in cooler. Ask how the work can be arranged around your opening hours.</span></div></li>
          <li><?php echo icon('zap', 20); ?><div><b>Capacity checked, not assumed</b><span>When a business keeps adding equipment, the panel eventually runs out of room. See <?php echo serviceLink('panel-upgrades', 'how panel and service capacity is added'); ?> when the load calculation says the building needs more.</span></div></li>
          <li><?php echo icon('hard-hat', 20); ?><div><b>Shop floors as well as front offices</b><span>When the building is part office and part workshop, the same company handles both. <?php echo serviceLink('industrial-electrical', 'Industrial electrical work for shops and warehouses'); ?> covers the heavier equipment side.</span></div></li>
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
        <h2 id="sp-scope-title">What commercial electrical work does All Connected Electric handle?</h2>
        <p class="answer-block">All Connected Electric LLC handles the electrical work an office, storefront or other commercial building needs: dedicated circuits for new equipment, lighting installation and repair, panel replacement and added capacity, outlet and switch repairs, and tracing faults when part of the building loses power. Larger fit-outs combine several of these into one planned job.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Dedicated equipment circuits</b> for coolers, ovens, copiers, servers and anything that should not share a circuit.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Commercial lighting</b>, from replacing failed fixtures to relighting a sales floor. <?php echo serviceLink('lighting-installation', 'Lighting installation and repair'); ?> has the detail.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Exit and emergency lighting circuits</b>, which building and fire codes expect to work in most commercial spaces.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Panels and capacity</b> for buildings that have outgrown what they were built with.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Repairs and fault finding</b> when outlets die, breakers trip or one part of the building goes dark.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it runs</span>
        <h3>How does a commercial electrical job run from first call to handover?</h3>
        <ol class="sp-steps">
          <li><b>Describe the space and the problem</b><span>The address, the type of business, and what is tripping, failing or being added.</span></li>
          <li><b>Walk-through</b><span>The panel, the circuits involved and the equipment are looked at on site before a price is given.</span></li>
          <li><b>Scope, schedule and permit</b><span>What changes, which circuits go off and when, and what the City of Hagerstown or Washington County requires.</span></li>
          <li><b>Work in sections</b><span>Where the job allows it, circuits are taken down a few at a time so the rest of the space keeps working.</span></li>
          <li><b>Inspection and handover</b><span>After inspection the panel directory is updated so staff can find the right breaker.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: DISRUPTION BY JOB TYPE ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Planning</span>
      <h2 id="sp-compare-title">How much does each type of commercial electrical job disrupt a business?</h2>
    </div>
    <p class="answer-block reveal-up">The disruption depends on how much of the building has to be switched off. Adding one equipment circuit usually affects only the panel area, a lighting job darkens one zone at a time, and a panel replacement takes the whole building off for the swap. Knowing which kind of job you have makes it easier to pick the day.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Common commercial electrical jobs, what is usually off during the work, and what to plan for</caption>
        <thead>
          <tr><th scope="col">Job</th><th scope="col">What is usually off during the work</th><th scope="col">What to plan for</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">New equipment circuit</th><td>Often only the new circuit, plus a short shutdown at the panel to connect it.</td><td>Have the equipment's voltage and amp rating ready, and know where it will sit.</td></tr>
          <tr><th scope="row">Lighting replacement or retrofit</th><td>The lighting circuit for the area being worked on.</td><td>Which zones can go dark first, and whether the work happens with the space open.</td></tr>
          <tr><th scope="row">Tenant fit-out</th><td>Varies; the space is often closed while walls are open.</td><td>Landlord approval, a layout of desks, registers and equipment, and the permit.</td></tr>
          <tr><th scope="row">Panel replacement or upgrade</th><td>The whole building or tenant space during the swap.</td><td>A shutdown window, utility coordination with Potomac Edison if the service changes, and inspection.</td></tr>
          <tr><th scope="row">Fault finding</th><td>The affected circuits while they are traced.</td><td>A list of what stopped working, when, and what was running at the time.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Every commercial building is wired differently, so the walk-through sets the real plan. The table is a starting point for that conversation, not a quote.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: WORK-ORDER TICKET ============ -->
<section class="section com-prep" aria-labelledby="com-prep-title">
  <div class="container">
    <div class="com-prep__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Before the walk-through</span>
        <h2 id="com-prep-title">What should a business have ready before a fit-out or equipment install?</h2>
        <p class="answer-block">Five things speed up a commercial job: the nameplate ratings of any new equipment, a rough layout of where it all goes, the landlord's approval, access to the electrical room or panel, and the hours the space must stay open. With those in hand, the walk-through turns into a plan instead of a list of questions.</p>
        <div class="prose">
          <p>Leased spaces add a step that houses do not have. The property manager may hold the key to the electrical room, may want to see the plan before anything is opened up, and may have rules about when contractors can work in the building. Sorting that out first keeps the start date from slipping.</p>
          <p>Whether the building sits inside the City of Hagerstown or out in Washington County also matters, because it decides which office reviews the permit.</p>
        </div>
      </div>
      <div class="com-ticket reveal-right" role="group" aria-label="Commercial job checklist">
        <div class="com-ticket__head"><span>Work order checklist</span><b>Commercial</b></div>
        <div class="com-ticket__perf" aria-hidden="true"></div>
        <ul>
          <li><span><b>Equipment ratings</b>Voltage and amps from the nameplate of each new machine, cooler or appliance.</span></li>
          <li><span><b>Layout</b>A sketch showing desks, registers, displays and equipment.</span></li>
          <li><span><b>Landlord sign-off</b>Written approval if the lease requires it.</span></li>
          <li><span><b>Panel access</b>Who has the key to the electrical room or meter area.</span></li>
          <li><span><b>Hours to protect</b>When the space must stay open and powered.</span></li>
          <li><span><b>City or county</b>Whether the address is in the City of Hagerstown or Washington County.</span></li>
        </ul>
        <p class="com-ticket__foot">Send it with the form or bring it to the walk-through</p>
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
      <h2 id="sp-faq-title">What do Hagerstown business owners ask about commercial electrical permits?</h2>
      <p>Permits come up before almost every commercial job, especially in a leased space where the landlord, the tenant and the permit office all have a say. Here is how All Connected Electric LLC answers the most common version of the question.</p>
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
      <h2 id="sp-related-title">What other services do <span class="text-accent">Hagerstown businesses</span> pair with commercial work?</h2>
      <p class="hero-answer">Commercial jobs rarely stop at one circuit. A business that adds equipment often needs more panel capacity, a sales floor that gets new fixtures needs its lighting circuits checked, and a building with a workshop out back needs heavier circuits, so All Connected Electric LLC plans them together when the walk-through shows they are connected.</p>
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
    <p class="sp-related__hub">Commercial work is one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Commercial estimate</span>
      <h2 id="sp-cta-title">Planning electrical work for a Hagerstown business?</h2>
      <p>Send the address, the type of business and what needs to change, or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>. All Connected Electric LLC will follow up to arrange a walk-through of the space and the panel.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a commercial estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
