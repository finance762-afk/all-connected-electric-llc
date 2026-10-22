<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ — services hub, All Connected Electric LLC (Phase 4).
 * Lists ALL services from config.php $services (11) with links to each built page, a sector-to-service table
 * (signature section), the service-area statement and research-brief FAQs (cost, license).
 * No client photos on disk: cards are icon-led, as on the homepage. No price, hours, license or "free" claims.
 */
$pageTitle       = 'Electrical Services Hagerstown, MD | All Connected Electric';
$pageDescription = 'Residential, commercial and industrial electrical services in Hagerstown, MD: panels, EV chargers, lighting, rewiring, generators and repairs. (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = '';
$heroPreload     = [];

/* Card copy per slug (icon, one-sentence description, exactly 3 bullets of 3-6 words). Order = config.php. */
$hubCards = [
    'commercial-electrical'    => ['icon' => 'building-2',       'desc' => 'Circuits, lighting, panels and repairs for offices, storefronts and other commercial space.', 'bullets' => ['Tenant spaces and storefronts', 'Circuits for new equipment', 'Lighting and panel work']],
    'residential-electrical'   => ['icon' => 'house',            'desc' => 'Repairs, upgrades and new wiring for houses, room by room.', 'bullets' => ['Kitchens, baths and basements', 'Surge protection and smart wiring', 'Home electrical inspections']],
    'industrial-electrical'    => ['icon' => 'hard-hat',         'desc' => 'Power distribution, machine circuits and fault finding for warehouses, shops and plants.', 'bullets' => ['Equipment and machine circuits', 'Power distribution work', 'Faults traced and repaired']],
    'panel-upgrades'           => ['icon' => 'zap',              'desc' => 'New panels, service upgrades and breaker repair, sized from a load calculation.', 'bullets' => ['Capacity for new loads', 'Failing breakers replaced', 'Old panel brands removed']],
    'ev-charger-installation'  => ['icon' => 'battery-charging', 'desc' => 'Level 2 chargers on a dedicated 240-volt circuit sized for the charger.', 'bullets' => ['Panel capacity checked first', 'Hardwired or plug-in chargers', 'Overnight charging at home']],
    'lighting-installation'    => ['icon' => 'lightbulb',        'desc' => 'Indoor and outdoor fixtures, recessed lights and lighting repairs.', 'bullets' => ['Recessed and fixture installs', 'Exterior and security lights', 'Dead fixtures traced and fixed']],
    'wiring-rewiring'          => ['icon' => 'waypoints',        'desc' => 'Whole-house rewiring, faulty wiring repair and new runs for renovations.', 'bullets' => ['Older wiring replaced', 'Faulty connections repaired', 'New circuits for additions']],
    'ceiling-fan-installation' => ['icon' => 'wind',             'desc' => 'Fan installs and repairs on boxes rated to carry the fan.', 'bullets' => ['Fan-rated ceiling boxes', 'Wall controls and switches', 'Wobbling fans corrected']],
    'generator-installation'   => ['icon' => 'power',            'desc' => 'Transfer switches and hookups for portable and standby generators.', 'bullets' => ['Transfer switch installed', 'Chosen circuits stay on', 'Generator repairs too']],
    'outlet-switch-repair'     => ['icon' => 'plug',             'desc' => 'Dead outlets, failing switches, GFCI devices and short circuits.', 'bullets' => ['Dead outlets brought back', 'GFCI protection added', 'Warm switches replaced']],
    'emergency-electrician'    => ['icon' => 'flame',            'desc' => 'Troubleshooting for power loss, repeat trips and burning smells.', 'bullets' => ['Power loss tracked down', 'Repeat trips diagnosed', 'Unsafe wiring made safe']],
];
$hubCount = count($services);

/* Signature: sector → typical work → services that cover it (all from config.php service descriptions). */
$hubSectors = [
    ['sector' => 'Homes', 'icon' => 'house', 'work' => 'A breaker that keeps tripping, a kitchen remodel that needs new circuits, an EV in the garage, a generator for winter outages, original wiring in an older house.',
     'slugs' => ['residential-electrical', 'panel-upgrades', 'ev-charger-installation', 'wiring-rewiring', 'generator-installation', 'outlet-switch-repair', 'ceiling-fan-installation']],
    ['sector' => 'Commercial buildings', 'icon' => 'building-2', 'work' => 'An office or storefront that needs more circuits, lighting replaced or added, a panel that is full, a repair that has to happen without closing the doors for long.',
     'slugs' => ['commercial-electrical', 'lighting-installation', 'panel-upgrades', 'emergency-electrician']],
    ['sector' => 'Industrial sites', 'icon' => 'hard-hat', 'work' => 'A warehouse, shop or plant adding equipment, reworking power distribution, or chasing a fault that has stopped a line.',
     'slugs' => ['industrial-electrical', 'panel-upgrades', 'lighting-installation', 'emergency-electrician']],
];
$hubNames = [];
foreach ($services as $hubSvcRow) $hubNames[$hubSvcRow['slug']] = $hubSvcRow['name'];

/* FAQs — research_brief.faqs (cost, license), reworded for this page. */
$pageFaqs = [
    ['q' => 'How much does it cost to hire an electrician in Hagerstown?',
     'a' => 'The price of electrical work in Hagerstown depends on the scope, the age of the building, the materials and whether a permit is needed, so a reliable number comes after the job is seen. When you call All Connected Electric LLC at ' . $phone . ', ask how pricing works for your job and whether a service-call fee applies.'],
    ['q' => 'How can I check an electrician\'s license in Maryland?',
     'a' => 'Maryland requires electrical contractors to hold a license, and you can look one up through the Maryland State Board of Master Electricians, part of the Maryland Department of Labor. Ask any electrician for the license number and for proof of general liability and workers\' compensation coverage before work starts.'],
];

/* Schema: CollectionPage + ItemList of every service page, BreadcrumbList (FAQs are visible text only). Provider = homepage #organization. */
$hubRoot = rtrim($siteUrl, '/');
$hubItems = [];
foreach ($services as $hubIdx => $hubSvc) {
    $hubItemUrl = $hubRoot . '/services/' . $hubSvc['slug'] . '/';
    $hubItem = ['@type' => 'Service', '@id' => $hubItemUrl . '#service-' . $hubSvc['slug'], 'name' => $hubSvc['name'], 'provider' => ['@id' => $hubRoot . '/#organization']];
    if (siteHas('/services/' . $hubSvc['slug'] . '/')) $hubItem['url'] = $hubItemUrl;
    $hubItems[] = ['@type' => 'ListItem', 'position' => $hubIdx + 1, 'item' => $hubItem];
}
$schemaMarkup = [
    ['@type' => 'CollectionPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle,
     'isPartOf' => ['@id' => $hubRoot . '/#website'], 'about' => ['@id' => $hubRoot . '/#organization'],
     'mainEntity' => ['@type' => 'ItemList', 'name' => $siteName . ' electrical services', 'numberOfItems' => $hubCount, 'itemListElement' => $hubItems],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Services', 'url' => $canonicalUrl],
    ]),
];
/* Lead form: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Services hub — page-specific: full 11-card grid, sector matrix (signature), coverage band.
   Tokens only.
   ========================================================================== */
.hub-grid-section { background: var(--color-paper); }
.hub-grid-section .section-title { max-width: 66ch; }
.hub-grid-section .hero-answer { color: var(--color-ink-2); max-width: 64ch; }
.hub-grid-section .services-grid { counter-reset: hub; }
.hub-grid-section .service-card-with-image { counter-increment: hub; }
.hub-grid-section .service-card-with-image::after {
  content: counter(hub, decimal-leading-zero);
  position: absolute;
  top: var(--space-md);
  right: var(--space-md);
  font-family: var(--font-accent);
  font-size: .85rem;
  letter-spacing: .1em;
  color: var(--color-muted);
}
.hub-grid-section .service-card-with-image::before {
  content: "";
  position: absolute;
  inset: 0 0 auto 0;
  height: 3px;
  background: var(--color-accent);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform var(--transition-slow);
}
.hub-grid-section .service-card-with-image:hover::before,
.hub-grid-section .service-card-with-image:focus-within::before { transform: scaleX(1); }
.hub-grid-section .service-card__icon { width: var(--space-12); height: var(--space-12); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); box-shadow: var(--shadow-sm); }
.hub-grid-section .service-card__cta { color: var(--color-ink); }
.hub-grid-section .service-card__cta:hover { color: var(--color-accent-dark); }

/* Sector matrix: three columns read like a switchboard — sector tab, the job, the services that cover it */
.hub-sectors { background: var(--color-surface); }
.hub-matrix { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; padding: 0; list-style: none; }
.hub-matrix > li {
  position: relative;
  display: grid;
  grid-template-rows: auto auto 1fr;
  gap: var(--space-sm);
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  background: linear-gradient(180deg, var(--color-paper) 0%, var(--color-surface) 60%);
  box-shadow: var(--shadow-sm);
}
.hub-matrix > li::before {
  content: "";
  position: absolute;
  inset: 0 auto 0 0;
  width: var(--space-1);
  border-radius: var(--radius-lg) 0 0 var(--radius-lg);
  background: linear-gradient(180deg, var(--color-accent), color-mix(in srgb, var(--color-accent) 20%, transparent));
}
.hub-matrix h3 { display: flex; align-items: center; gap: var(--space-sm); font-size: 1.15rem; }
.hub-matrix h3 svg { color: var(--color-accent-dark); }
.hub-matrix p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
.hub-matrix__svc { display: flex; flex-wrap: wrap; align-content: flex-start; gap: var(--space-xs); margin: var(--space-xs) 0 0; padding: var(--space-md) 0 0; list-style: none; border-top: 1px dashed var(--color-line); }
.hub-matrix__svc a, .hub-matrix__svc span {
  display: inline-flex;
  align-items: center;
  min-height: 36px;
  padding: var(--space-1) var(--space-sm);
  border-radius: var(--radius-full);
  border: 1px solid var(--color-line);
  background: var(--color-card-tint-3);
  font-size: .82rem;
  font-weight: 600;
  color: var(--color-ink);
  text-decoration: none;
  transition: border-color var(--transition), background var(--transition);
}
.hub-matrix__svc a:hover { border-color: var(--color-ink); background: var(--color-surface); }

/* Coverage band (dark, slant edge) */
.hub-area .hub-area__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.hub-area .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 86%, transparent); margin-top: var(--space-md); }
.hub-area__card {
  display: grid;
  gap: var(--space-sm);
  padding: var(--space-lg);
  border-radius: var(--radius-lg);
  border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent);
  background: color-mix(in srgb, var(--color-white) 5%, transparent);
  backdrop-filter: blur(6px);
}
.hub-area__card div { display: flex; gap: var(--space-sm); align-items: flex-start; color: color-mix(in srgb, var(--color-white) 84%, transparent); font-size: .95rem; }
.hub-area__card svg { color: var(--color-accent-bright); flex: 0 0 auto; margin-top: 2px; }
.hub-area__card a { color: var(--color-white); }

.hub-note { margin-top: var(--space-xl); }
.hub-note p { margin: 0; color: var(--color-ink-2); }
.hub-note a { color: var(--color-ink); font-weight: 600; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }

@media (max-width: 1000px) { .hub-matrix { grid-template-columns: 1fr; } }
@media (max-width: 900px) { .hub-area .hub-area__grid { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO ============ -->
<section class="hero hero--interior sp-hero" aria-labelledby="sp-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Services</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <span class="eyebrow">Residential &middot; Commercial &middot; Industrial</span>
        <h1 class="hero-title" id="sp-hero-title">Electrical services in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC handles <?php echo (int) $hubCount; ?> kinds of electrical work for houses, commercial buildings and industrial sites in Hagerstown, MD: panel upgrades, EV chargers, lighting, wiring and rewiring, ceiling fans, generator hookups, outlet and switch repair, and troubleshooting when the power goes wrong. Pick a service below or describe the problem.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('house', 16); ?>Homes</li>
          <li><?php echo icon('building-2', 16); ?>Commercial buildings</li>
          <li><?php echo icon('hard-hat', 16); ?>Industrial sites</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an electrician in Hagerstown?</h2>
        <p class="hero-form-tagline">Pick the service, or leave it blank and tell us on the call.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 2. ALL SERVICES (required services-grid component) ============ -->
<section class="section hub-grid-section" id="all-services" aria-labelledby="hub-grid-title">
  <div class="container-wide">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="hub-grid-title">Which electrical services does <span class="text-accent">All Connected Electric</span> offer in Hagerstown?</h2>
      <p class="hero-answer">All Connected Electric LLC offers <?php echo (int) $hubCount; ?> electrical services in Hagerstown: commercial, residential and industrial work, panel upgrades, EV charger installation, lighting, wiring and rewiring, ceiling fans, generator installation, outlet and switch repair, and emergency troubleshooting. Each card below opens a page with the signs, the scope, the options and how the job runs.</p>
    </div>

    <div class="services-grid">
<?php foreach ($services as $hubIdx => $hubSvc):
    $hubCard = $hubCards[$hubSvc['slug']];
    $hubTint = ($hubIdx % 3) + 1;
    $hubUrl  = serviceUrl($hubSvc['slug']); ?>
      <article class="service-card-with-image card-tint-<?php echo $hubTint; ?> reveal-up reveal-delay-<?php echo $hubTint; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php echo icon($hubCard['icon'], 24); ?></div>
          <h3><?php echo esc($hubSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($hubCard['desc']); ?></p>
          <ul>
<?php foreach ($hubCard['bullets'] as $hubBullet): ?>
            <li><?php echo esc($hubBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($hubUrl !== ''): ?>
          <a href="<?php echo esc($hubUrl); ?>" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc($hubSvc['name']); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta" data-open-estimate>Ask about this<span class="sr-only">: <?php echo esc($hubSvc['name']); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 3. SIGNATURE: SECTOR MATRIX ============ -->
<section class="section hub-sectors" aria-labelledby="hub-sectors-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Start here</span>
      <h2 id="hub-sectors-title">Which service fits a home, a business or an industrial site?</h2>
    </div>
    <p class="answer-block reveal-up">Start with the kind of building, then the problem. A home usually needs residential repairs, a panel, an EV charger or rewiring; a commercial building needs circuits, lighting and panels planned around opening hours; an industrial site needs equipment circuits, power distribution and fault finding. The three columns below map each to the right page.</p>
    <ul class="hub-matrix">
<?php foreach ($hubSectors as $hubSectorIdx => $hubSector): ?>
      <li class="reveal-up reveal-delay-<?php echo $hubSectorIdx + 1; ?>">
        <h3><?php echo icon($hubSector['icon'], 22); ?><?php echo esc($hubSector['sector']); ?></h3>
        <p><?php echo esc($hubSector['work']); ?></p>
        <ul class="hub-matrix__svc" aria-label="Services for <?php echo esc(strtolower($hubSector['sector'])); ?>">
<?php foreach ($hubSector['slugs'] as $hubSecSlug): $hubSecUrl = serviceUrl($hubSecSlug); ?>
          <li><?php if ($hubSecUrl !== ''): ?><a href="<?php echo esc($hubSecUrl); ?>"><?php echo esc($hubNames[$hubSecSlug]); ?></a><?php else: ?><span><?php echo esc($hubNames[$hubSecSlug]); ?></span><?php endif; ?></li>
<?php endforeach; ?>
        </ul>
      </li>
<?php endforeach; ?>
    </ul>
    <div class="hub-note prose reveal-up">
      <p>Not sure what the problem is? Most calls start with a symptom: a breaker that will not reset, an outlet that went dead, lights that flicker when the furnace starts. Describe what you notice and the building it is in, and the right service follows from there. A breaker that trips again and again is often a capacity question, which is why <?php echo serviceLink('panel-upgrades', 'panel upgrades start with a load calculation'); ?>. A burning smell is different: read <?php echo serviceLink('emergency-electrician', 'what to do first in an electrical emergency'); ?> before anything else.</p>
    </div>
  </div>
</section>

<!-- ============ 4. COVERAGE (dark band) ============ -->
<section class="section hub-area texture-grain slant-top" aria-labelledby="hub-area-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="hub-area__grid">
      <div class="reveal-left">
        <span class="eyebrow">Where we work</span>
        <h2 id="hub-area-title">Where does All Connected Electric work around Hagerstown?</h2>
        <p class="answer-block">All Connected Electric LLC works in Hagerstown and the surrounding area of Washington County, Maryland, from its office at <?php echo esc($address['street']); ?>. Permit rules differ between the City of Hagerstown and unincorporated Washington County, so the address decides which office a permitted job goes through.</p>
        <p>That split matters more than people expect. Two houses a few minutes apart can fall under different permit offices, and a service upgrade at the panel usually involves Potomac Edison, the utility, as well. Ask which applies to your address when you call. Owner <?php echo esc($ownerName); ?> has run the company since <?php echo (int) $yearEstablished; ?>.</p>
      </div>
      <div class="hub-area__card reveal-right">
        <div><?php echo icon('map-pin', 20); ?><span><?php echo esc($address['street']); ?><br><?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?></span></div>
        <div><?php echo icon('phone', 20); ?><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a></div>
        <div><?php echo icon('mail', 20); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
        <div><?php echo icon('route', 20); ?><a href="<?php echo esc($directionsUrl); ?>" target="_blank" rel="noopener">Get directions to the office</a></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. FAQ (research-brief questions) ============ -->
<section class="section sp-faq" aria-labelledby="sp-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sp-faq-title">What should you ask before hiring an electrician in Hagerstown?</h2>
      <p>Two questions are worth asking any electrician in Hagerstown before work starts: how the job will be priced, and how to confirm the electrician's Maryland license. Here is what All Connected Electric LLC tells people who ask.</p>
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

<!-- ============ 6. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Estimate request</span>
      <h2 id="sp-cta-title">Have electrical work in Hagerstown that needs a price?</h2>
      <p>Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a> or send the form with what is going on and where. All Connected Electric LLC will follow up to set a time to look at the job.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Send the details</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
