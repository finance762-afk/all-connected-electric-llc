<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * index.php — homepage, All Connected Electric LLC (Phase 3).
 * Archetype minimal-tech, editorial section script. No client photos or logo are on disk yet
 * (build-plan assets.images is empty), so the hero is the type-led .hero--type, service cards use the
 * icon fallback, the about column is a typeset company card, and the recent-work gallery is skipped.
 * Every fact on this page traces to build-plan.json / config.php; anything intake did not supply is
 * listed in /content-confirmations.json instead of being written into the copy.
 */
$pageTitle       = 'Electrician in Hagerstown, MD | All Connected Electric LLC';
$pageDescription = 'All Connected Electric LLC is a Hagerstown, MD electrician for homes, businesses and industrial sites: panel upgrades, EV chargers, wiring and repairs.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '';          // no photo on disk yet; ogImageUrl() falls back to og-default/logo once supplied
$currentPage     = 'home';
$pageType        = 'home';
$heroPreloadImage = '';         // type-led hero: no LCP photo to preload
$heroPreload     = [];

/* Service cards — first 8 services from config.php ($services order). Card copy per slug; the
   description in config.php stays the schema description. No photos exist, so cards are icon-led. */
$homeCardCopy = [
    'commercial-electrical'    => ['icon' => 'building-2',       'desc' => 'Installation, repair and upgrades for offices, storefronts and other commercial buildings.', 'bullets' => ['Offices, storefronts and retail spaces', 'New circuits for added equipment', 'Commercial lighting and repairs']],
    'residential-electrical'   => ['icon' => 'house',            'desc' => 'Repairs, upgrades and new wiring for houses in and around Hagerstown.', 'bullets' => ['Kitchen and bathroom circuits', 'Smart home and surge protection', 'Electrical safety inspections']],
    'industrial-electrical'    => ['icon' => 'hard-hat',         'desc' => 'Power distribution, equipment circuits and repairs for warehouses, shops and plants.', 'bullets' => ['Circuits sized for heavy equipment', 'Power distribution work', 'Fault finding and repairs']],
    'panel-upgrades'           => ['icon' => 'zap',              'desc' => 'Panel replacement, service upgrades and breaker repair when a building needs capacity.', 'bullets' => ['More capacity for new loads', 'Worn or failing breakers replaced', 'Room for chargers and additions']],
    'ev-charger-installation'  => ['icon' => 'battery-charging', 'desc' => 'Level 2 charger installs on a dedicated circuit sized for the charger.', 'bullets' => ['Panel capacity checked first', 'Dedicated circuit for the charger', 'Charge overnight at home']],
    'lighting-installation'    => ['icon' => 'lightbulb',        'desc' => 'Indoor and outdoor fixtures, recessed lighting and exterior lights, installed or repaired.', 'bullets' => ['Recessed and fixture installs', 'Outdoor lighting repair', 'Dead fixtures traced and fixed']],
    'wiring-rewiring'          => ['icon' => 'waypoints',        'desc' => 'New wiring, whole-home rewiring and faulty wiring repair for older homes and renovations.', 'bullets' => ['Rewiring for older houses', 'Faulty wiring found and repaired', 'New circuits for renovations']],
    'ceiling-fan-installation' => ['icon' => 'wind',             'desc' => 'Ceiling fan installs and repairs, with boxes rated for the fan\'s weight.', 'bullets' => ['Fan-rated ceiling boxes', 'Wall controls and switches', 'Wobbling or dead fans repaired']],
];
$homeGridServices  = array_slice($services, 0, 8);
$homeMoreServices  = array_slice($services, 8);
$homeServiceCount  = count($services);
$homeServicesHub   = siteHas('/services/');

/* Signature section: what a symptom usually points to, and which service covers it. */
$homeSignals = [
    ['symptom' => 'Breakers trip again and again',               'meaning' => 'A circuit carrying more than it was sized for, or a breaker that is wearing out.',        'slugs' => ['panel-upgrades', 'outlet-switch-repair']],
    ['symptom' => 'Lights dim when a big appliance starts',      'meaning' => 'The circuit or the whole service is close to its limit.',                                  'slugs' => ['panel-upgrades']],
    ['symptom' => 'The panel feels warm or buzzes',              'meaning' => 'Often a loose connection or a failing breaker. Treat it as urgent.',                       'slugs' => ['emergency-electrician', 'panel-upgrades']],
    ['symptom' => 'An outlet is dead, warm or scorched',         'meaning' => 'Loose or damaged wiring at the device, or a tripped GFCI upstream.',                       'slugs' => ['outlet-switch-repair']],
    ['symptom' => 'You are adding an EV, heat pump or addition', 'meaning' => 'New load the existing panel may not have room for. A load calculation answers it.',        'slugs' => ['ev-charger-installation', 'panel-upgrades']],
    ['symptom' => 'The house still has its original wiring',     'meaning' => 'Insulation and connections age. An inspection shows what can stay and what should go.', 'slugs' => ['wiring-rewiring', 'residential-electrical']],
];
$homeServiceNames = [];
foreach ($services as $homeSvcRow) $homeServiceNames[$homeSvcRow['slug']] = $homeSvcRow['name'];

/* FAQs — from research_brief.faqs (wording tightened), plus one on the sector mix from intake. */
$homeFaqs = [
    ['q' => 'Do I need a permit for electrical work in Hagerstown or Washington County?',
     'a' => 'Many electrical jobs need a permit and an inspection, including new circuits, service or panel upgrades, and most generator and EV charger installations. Requirements differ between the City of Hagerstown and unincorporated Washington County, so ask All Connected Electric LLC which rules apply to your address before the work is scheduled.'],
    ['q' => 'How do I know if my home needs an electrical panel upgrade?',
     'a' => 'Breakers that trip often, lights that dim when large appliances start, a panel that feels warm or buzzes, and outlets that stop working are the common signs. Adding an EV charger, a heat pump or an addition can also need more capacity. A load calculation by an electrician shows whether an upgrade is needed.'],
    ['q' => 'Can an EV charger be installed in an older home?',
     'a' => 'In many cases, yes. The electrician first checks the panel\'s capacity and the condition of the wiring, then sizes a dedicated circuit for the charger. If the service is too small, a panel or service upgrade may be needed before the charger goes in. A permit and inspection are usually required.'],
    ['q' => 'How much does it cost to hire an electrician in Hagerstown?',
     'a' => 'Cost depends on the scope of the work, the age of the building, the materials and whether a permit is needed. The reliable way to get a number is to have the job looked at. Call All Connected Electric LLC at ' . $phone . ' to describe the work and ask how pricing works for your job.'],
    ['q' => 'How can I check an electrician\'s license in Maryland?',
     'a' => 'Maryland requires electrical contractors to be licensed. You can look up a license through the Maryland State Board of Master Electricians, part of the Maryland Department of Labor, and you should ask any electrician for proof of general liability and workers\' compensation coverage before work begins.'],
    ['q' => 'Does All Connected Electric work on businesses and industrial sites, or only homes?',
     'a' => 'All Connected Electric LLC works on all three: houses, commercial buildings such as offices and storefronts, and industrial sites such as warehouses and shops. The same company handles a kitchen circuit, a storefront lighting upgrade and a dedicated circuit for shop equipment in the Hagerstown area.'],
];

$schemaMarkup = [generateFAQSchema($homeFaqs)];

/* Lead forms: p1_lead_hidden_fields('<form id>') (includes/p1-form-helpers.php) emits _next, _honey, form_location,
   consent_version/consent_page, p1_attribution_fields('<form id>') and the _ft/_js spam shield in one call. */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   Homepage — All Connected Electric LLC (minimal-tech, editorial script)
   Tokens only: every color, shadow and spacing value is a framework.css var().
   ========================================================================== */

/* ---- 1. Hero: type-led, layered (accent glow ::before, circuit grid ::after, grain span) ---- */
.home-hero { padding-bottom: var(--space-4xl); }
.home-hero::before {
  content: "";
  position: absolute;
  inset: -25% -12% auto 48%;
  height: 150%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 72%);
  pointer-events: none;
}
.home-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  background-image:
    linear-gradient(color-mix(in srgb, var(--color-white) 5%, transparent) 1px, transparent 1px),
    linear-gradient(90deg, color-mix(in srgb, var(--color-white) 5%, transparent) 1px, transparent 1px);
  background-size: var(--space-3xl) var(--space-3xl);
  -webkit-mask-image: linear-gradient(100deg, transparent 15%, var(--color-black) 65%);
  mask-image: linear-gradient(100deg, transparent 15%, var(--color-black) 65%);
  pointer-events: none;
}
.home-hero .grain { z-index: -1; opacity: .3; }
.home-hero .eyebrow { color: var(--color-accent-bright); }
.home-hero .hero-title { letter-spacing: -.03em; }
.home-hero .text-accent { color: var(--color-accent-bright); }
.home-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.home-hero .hero-actions .btn-primary { background: var(--color-accent); color: var(--color-ink); box-shadow: var(--shadow); }
.home-hero .hero-actions .btn-primary:hover { background: var(--color-accent-bright); filter: brightness(1.05); }
.home-hero .hero-chips li {
  background: color-mix(in srgb, var(--color-white) 7%, transparent);
  border-color: color-mix(in srgb, var(--color-white) 18%, transparent);
  color: var(--color-white);
}
.home-hero .hero-chips svg { color: var(--color-accent-bright); }
.home-hero .hero-form-card { position: relative; }
.home-hero .hero-form-card::before {
  content: "";
  position: absolute;
  inset: 0 0 auto 0;
  height: var(--space-1);
  border-radius: var(--radius-lg) var(--radius-lg) 0 0;
  background: var(--color-accent);
}
.home-hero .hero-form .btn-primary:hover { background: var(--color-primary-deep); }

/* ---- 2. Ticker: services in the accent face ---- */
.home-ticker { padding-block: var(--space-sm); }
.home-ticker .ticker-track svg { color: var(--color-accent-dark); }
.home-ticker .ticker-sep { width: var(--space-1); height: var(--space-1); border-radius: var(--radius-full); background: var(--color-line); }

/* ---- 3. Services: icon-led tinted cards (no client photos on file yet) ---- */
.home-services .section-head { max-width: 64ch; }
.home-services .hero-answer { color: var(--color-ink-2); max-width: 62ch; }
.home-services .service-card-with-image { padding-top: var(--space-xs); }
.home-services .service-card-with-image::before {
  content: "";
  position: absolute;
  inset: 0 0 auto 0;
  height: 3px;
  background: var(--color-accent);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform var(--transition-slow);
}
.home-services .service-card-with-image:hover::before,
.home-services .service-card-with-image:focus-within::before { transform: scaleX(1); }
.home-services .service-card__icon {
  width: var(--space-12);
  height: var(--space-12);
  border-radius: var(--radius);
  background: var(--color-primary);
  color: var(--color-accent);
  box-shadow: var(--shadow-sm);
  transition: transform var(--transition);
}
.home-services .service-card-with-image:hover .service-card__icon { transform: rotate(-6deg) scale(1.06); }
.home-services .service-card__cta { color: var(--color-ink); }
.home-services .service-card__cta:hover { color: var(--color-accent-dark); }
.home-services__foot {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: var(--space-md) var(--space-xl);
  margin-top: var(--space-xl);
  padding-top: var(--space-lg);
  border-top: 1px solid var(--color-line);
}
.home-services__more { margin: 0; color: var(--color-ink-2); font-size: var(--fs-small); max-width: 70ch; }
.home-services__more a { color: var(--color-ink); font-weight: 600; }

/* ---- 4. Proof strip: dark band, slant edge, verifiable facts only ---- */
.home-proof.stats-band {
  background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 130%);
  color: var(--color-white);
  border-block: 0;
}
.home-proof .stat-item { border-left-color: color-mix(in srgb, var(--color-white) 14%, transparent); padding-block: var(--space-md); }
.home-proof .stat-number { color: var(--color-white); font-size: clamp(1.6rem, 1.2rem + 1.4vw, 2.3rem); text-transform: uppercase; }
.home-proof .stat-number span { color: var(--color-accent-bright); }
.home-proof .stat-label { color: color-mix(in srgb, var(--color-white) 70%, transparent); }

/* ---- 5. Signature: symptom table (what the house is telling you) ---- */
.home-signals .section-head { max-width: none; }
.signal-table { width: 100%; border-collapse: collapse; font-size: var(--fs-small); }
.signal-table caption { text-align: left; color: var(--color-muted); font-size: var(--fs-small); padding-bottom: var(--space-sm); }
.signal-table th, .signal-table td { text-align: left; vertical-align: top; padding: var(--space-md) var(--space-sm); border-top: 1px solid var(--color-line); }
.signal-table thead th {
  border-top: 0;
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--color-muted);
  padding-block: var(--space-xs);
}
.signal-table tbody th { font-family: var(--font-heading); font-weight: 700; font-size: 1rem; color: var(--color-ink); width: 34%; }
.signal-table td { color: var(--color-ink-2); }
.signal-table tbody tr { transition: background var(--transition); }
.signal-table tbody tr:hover { background: var(--color-surface); }
.signal-table .signal-svc { display: flex; flex-wrap: wrap; gap: var(--space-1) var(--space-xs); margin: 0; padding: 0; list-style: none; }
.signal-table .signal-svc li a, .signal-table .signal-svc li span {
  display: inline-flex;
  align-items: center;
  font-size: .8rem;
  font-weight: 600;
  color: var(--color-ink);
  background: var(--color-card-tint-3);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-sm);
  text-decoration: none;
  white-space: nowrap;
}
.signal-table .signal-svc li a:hover { border-color: var(--color-ink); }
.signal-warning {
  display: flex;
  gap: var(--space-sm);
  align-items: flex-start;
  margin-top: var(--space-lg);
  padding: var(--space-md) var(--space-lg);
  border-left: 3px solid var(--color-danger);
  background: var(--color-surface);
  border-radius: 0 var(--radius) var(--radius) 0;
  font-size: var(--fs-small);
  color: var(--color-ink-2);
}
.signal-warning svg { color: var(--color-danger); flex: 0 0 auto; margin-top: 2px; }
.signal-warning p { margin: 0; }

/* ---- 6. About + process: the page's asymmetric section ---- */
.home-about { background: var(--color-surface); }
.home-about .floating-ring { top: 45%; right: -9rem; }
.home-about .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; gap: clamp(2rem, 6vw, 5.5rem); }
.home-about .about-copy h2 { max-width: 24ch; }
.home-about .process-steps { margin-top: var(--space-xl); }
.home-about .process-steps li { padding: var(--space-md); border: 1px solid var(--color-line); border-radius: var(--radius); background: var(--color-paper); }
.home-about .about-right { margin-top: var(--space-4xl); }
.company-card {
  position: relative;
  z-index: 1;
  display: grid;
  gap: var(--space-md);
  padding: var(--space-xl) var(--space-xl) var(--space-3xl);
  background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 120%);
  color: color-mix(in srgb, var(--color-white) 84%, transparent);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  clip-path: polygon(0 0, 100% 0, 100% calc(100% - var(--space-2xl)), calc(100% - var(--space-2xl)) 100%, 0 100%);
}
.company-card__mark { display: grid; place-items: center; width: var(--space-12); height: var(--space-12); border-radius: var(--radius); background: var(--color-accent); color: var(--color-primary); }
.company-card__name { font-family: var(--font-heading); font-size: var(--fs-h3); font-weight: 700; color: var(--color-white); margin: 0; }
.company-card dl { display: grid; gap: var(--space-sm); margin: 0; }
.company-card dl div { display: grid; gap: 2px; padding-top: var(--space-sm); border-top: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); }
.company-card dt { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.company-card dd { margin: 0; font-size: .95rem; }
.company-card a { color: var(--color-white); text-decoration: none; }
.company-card a:hover { text-decoration: underline; }
.home-about .about-stat-card { left: auto; right: -1.25rem; bottom: -1.5rem; display: grid; gap: 2px; }
.home-about .about-stat-card b { font-family: var(--font-accent); font-size: 1.35rem; line-height: 1; text-transform: uppercase; color: var(--color-ink); }
.home-about .about-stat-card span { font-size: .78rem; color: var(--color-muted); }

/* ---- 7. Reviews: light band ---- */
.home-reviews { background: var(--color-paper-2); }

/* ---- 8. Mid-page CTA: dark band, curved edge, grain ---- */
.home-urgent .eyebrow { color: var(--color-accent-bright); }
.home-urgent h2 { max-width: 26ch; }
.home-urgent p { max-width: 58ch; margin: 0; }
.home-urgent .actions .btn-accent:hover { background: var(--color-accent-bright); color: var(--color-ink); filter: brightness(1.06); }

/* ---- 9. FAQ ---- */
.home-faq .section-head { max-width: 60ch; }
.home-faq .faq summary { text-wrap: balance; }
.home-faq .faq[open] { border-top-color: var(--color-accent); }

/* ---- 10. Estimate section ---- */
.home-estimate { background: var(--color-paper); }
.home-estimate .estimate > .card { display: grid; gap: var(--space-sm); }
.home-estimate .estimate-aside { display: grid; gap: var(--space-sm); padding-top: var(--space-md); }
.home-estimate .estimate-aside h3 { font-size: var(--fs-h3); }
.home-estimate .area-line { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: var(--color-ink-2); padding-top: var(--space-md); border-top: 1px solid var(--color-line); }
.home-estimate .form-consent-fieldset { margin-top: var(--space-xs); }
.home-estimate .form-consent-item { margin: var(--space-xs) 0; }

/* ---- Responsive ---- */
@media (max-width: 900px) {
  .home-about .about-split { grid-template-columns: 1fr; }
  .home-about .about-right { margin: var(--space-xl) var(--space-lg) var(--space-2xl) var(--space-md); }
  .home-about .about-stat-card { right: -0.5rem; }
}
@media (max-width: 680px) {
  .signal-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0, 0, 0, 0); }
  .signal-table, .signal-table tbody, .signal-table tr, .signal-table th, .signal-table td { display: block; width: 100%; }
  .signal-table tbody tr { padding-block: var(--space-sm); border-top: 1px solid var(--color-line); }
  .signal-table th, .signal-table td { border-top: 0; padding: var(--space-1) 0; }
  .signal-table tbody th { width: 100%; }
  .home-proof .stat-item { padding-inline: var(--space-sm); }
}
</style>

<!-- ============ 1. HERO (minimal-tech: .hero--type) ============ -->
<section class="hero hero--type home-hero" aria-labelledby="home-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-text">
        <span class="eyebrow"><?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> &middot; Washington County</span>
        <h1 class="hero-title" id="home-hero-title">Hagerstown electrician for <span class="text-accent">home and business</span></h1>
        <p class="hero-answer">All Connected Electric LLC wires, repairs and upgrades homes, businesses and industrial sites around Hagerstown, from panel upgrades and EV chargers to tracking down a dead circuit. Call or send the form to get the job looked at.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('zap', 16); ?>Panel &amp; service upgrades</li>
          <li><?php echo icon('battery-charging', 16); ?>Level 2 EV chargers</li>
          <li><?php echo icon('power', 16); ?>Generator hookups</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Get an estimate</h2>
        <p class="hero-form-tagline">Tell us the job and we will get back to you.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 2. TICKER ============ -->
<div class="ticker-strip home-ticker" aria-hidden="true">
  <div class="ticker-track">
<?php
$homeTicker = [['house', 'Residential'], ['building-2', 'Commercial'], ['hard-hat', 'Industrial'], ['zap', 'Panel upgrades'], ['battery-charging', 'EV charger installation'], ['power', 'Generators &amp; transfer switches'], ['lightbulb', 'Lighting'], ['waypoints', 'Wiring &amp; rewiring'], ['plug', 'Outlet &amp; switch repair'], ['map-pin', 'Hagerstown, MD']];
for ($homeLoop = 0; $homeLoop < 2; $homeLoop++):
    foreach ($homeTicker as $homeTick): ?>
    <span><?php echo icon($homeTick[0], 16); ?><?php echo $homeTick[1]; ?></span><span class="ticker-sep"></span>
<?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============ 3. SERVICES ============ -->
<section class="section home-services" id="services" aria-labelledby="home-services-title">
  <div class="container-wide">
    <div class="section-head section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="home-services-title">What electrical work does <span class="text-accent">All Connected Electric</span> handle in Hagerstown?</h2>
      <p class="hero-answer"><?php echo esc($siteName); ?> covers residential, commercial and industrial electrical work in Hagerstown, MD. That means panel and service upgrades, EV charger installs, lighting, wiring and rewiring, ceiling fans, generator hookups, outlet and switch repair, and troubleshooting when something stops working, at a house, a storefront or a shop floor.</p>
    </div>

    <div class="services-grid">
<?php foreach ($homeGridServices as $homeIdx => $homeSvc):
    $homeCard = $homeCardCopy[$homeSvc['slug']];
    $homeTint = ($homeIdx % 3) + 1;
    $homeUrl  = serviceUrl($homeSvc['slug']); ?>
      <article class="service-card-with-image card-tint-<?php echo $homeTint; ?> reveal-up reveal-delay-<?php echo $homeTint; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php echo icon($homeCard['icon'], 24); ?></div>
          <h3><?php echo esc($homeSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($homeCard['desc']); ?></p>
          <ul>
<?php foreach ($homeCard['bullets'] as $homeBullet): ?>
            <li><?php echo esc($homeBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($homeUrl !== ''): ?>
          <a href="<?php echo esc($homeUrl); ?>" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc($homeSvc['name']); ?></span></a>
<?php else: ?>
          <a href="#estimate" class="service-card__cta">Request this service<span class="sr-only">: <?php echo esc($homeSvc['name']); ?></span></a>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>

    <div class="home-services__foot reveal">
<?php
$homeMoreLinks = [];
foreach ($homeMoreServices as $homeMore) {
    $homeMoreUrl  = serviceUrl($homeMore['slug']);
    $homeMoreName = esc(strtolower($homeMore['name']));
    $homeMoreLinks[] = $homeMoreUrl !== '' ? '<a href="' . esc($homeMoreUrl) . '">' . $homeMoreName . '</a>' : $homeMoreName;
}
$homeMoreLast = array_pop($homeMoreLinks);
?>
      <p class="home-services__more">Also from <?php echo esc($siteName); ?>: <?php echo ($homeMoreLinks ? implode(', ', $homeMoreLinks) . ' and ' : '') . $homeMoreLast; ?>.</p>
<?php if ($homeServicesHub): ?>
      <a href="/services/" class="btn btn-secondary">View All <?php echo (int) $homeServiceCount; ?> Services <?php echo icon('arrow-right', 16); ?></a>
<?php else: ?>
      <button type="button" class="btn btn-secondary" data-open-estimate>Ask about any of the <?php echo (int) $homeServiceCount; ?> services <?php echo icon('arrow-right', 16); ?></button>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ 4. PROOF STRIP (verifiable facts only) ============ -->
<section class="stats-band texture-grain slant-top home-proof" aria-label="<?php echo esc($siteName); ?> at a glance">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="stats-row">
      <div class="stat-item reveal-up reveal-delay-1"><span class="stat-number">Est. <span><?php echo (int) $yearEstablished; ?></span></span><span class="stat-label">Electrical contractor in Hagerstown</span></div>
      <div class="stat-item reveal-up reveal-delay-2"><span class="stat-number"><span>3</span> Sectors</span><span class="stat-label">Residential, commercial and industrial</span></div>
      <div class="stat-item reveal-up reveal-delay-3"><span class="stat-number"><span><?php echo (int) $homeServiceCount; ?></span> Services</span><span class="stat-label">From panel upgrades to EV chargers</span></div>
      <div class="stat-item reveal-up reveal-delay-4"><span class="stat-number">Washington <span>Co.</span></span><span class="stat-label">Based on Leitersburg Pike, Hagerstown</span></div>
    </div>
  </div>
</section>

<!-- ============ 5. SIGNATURE: SYMPTOM TABLE ============ -->
<section class="section home-signals" aria-labelledby="home-signals-title">
  <div class="container-narrow">
    <div class="section-head reveal-left">
      <span class="eyebrow-label">Before you call</span>
      <h2 id="home-signals-title">What is your <span class="text-accent">electrical system</span> trying to tell you?</h2>
      <p>Most calls to an electrician start with a symptom, not a service name. This table matches the six problems Hagerstown homeowners and building managers notice most often to what they usually mean and which <?php echo esc($siteName); ?> service covers the fix.</p>
    </div>
    <div class="reveal-up">
      <table class="signal-table">
        <caption>Common electrical symptoms, what they usually point to, and the service that covers them</caption>
        <thead>
          <tr><th scope="col">What you notice</th><th scope="col">What it usually means</th><th scope="col">Service</th></tr>
        </thead>
        <tbody>
<?php foreach ($homeSignals as $homeSignal): ?>
          <tr>
            <th scope="row"><?php echo esc($homeSignal['symptom']); ?></th>
            <td><?php echo esc($homeSignal['meaning']); ?></td>
            <td><ul class="signal-svc">
<?php foreach ($homeSignal['slugs'] as $homeSigSlug): $homeSigUrl = serviceUrl($homeSigSlug); ?>
              <li><?php if ($homeSigUrl !== ''): ?><a href="<?php echo esc($homeSigUrl); ?>"><?php echo esc($homeServiceNames[$homeSigSlug]); ?></a><?php else: ?><span><?php echo esc($homeServiceNames[$homeSigSlug]); ?></span><?php endif; ?></li>
<?php endforeach; ?>
            </ul></td>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
      <div class="signal-warning" role="note">
        <?php echo icon('flame', 20); ?>
        <p><strong>Burning smell, smoke or sparks?</strong> Leave the building and call 911 first. Once everyone is safe, call <?php echo esc($siteName); ?> at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>.</p>
      </div>
    </div>
  </div>
</section>

<hr class="divider-hairline">

<!-- ============ 6. ABOUT + PROCESS (asymmetric) ============ -->
<section class="section home-about" aria-labelledby="home-about-title">
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="about-split">
      <div class="about-left about-copy reveal-left">
        <span class="eyebrow-label">About the company</span>
        <h2 id="home-about-title">A Hagerstown electrical contractor run by <span class="text-accent"><?php echo esc($ownerName); ?></span></h2>
        <p><?php echo esc($siteName); ?> is <?php echo esc($ownerName); ?>'s electrical contracting company, based at <?php echo esc($address['street']); ?> in Hagerstown. The work splits three ways: houses, commercial buildings such as offices and storefronts, and industrial sites such as warehouses and shops.</p>
        <p>Hagerstown has a lot of older houses, and much of the residential work here is bringing panels and wiring up to what a household runs today, from EV chargers and heat pumps to a finished basement. On the commercial and industrial side, it is new circuits for equipment, lighting and finding faults that stop work.</p>

        <ol class="process-steps">
          <li><b>Tell us the problem</b><span>Call <?php echo esc(formatPhone($phone)); ?> or send the form with what is going on and where.</span></li>
          <li><b>We look at the system</b><span>The panel, circuits and wiring involved are checked before anything is quoted.</span></li>
          <li><b>Permit, when it is needed</b><span>City of Hagerstown or Washington County rules are sorted before work starts.</span></li>
          <li><b>Work done, then walked through</b><span>You see what was changed and what to watch for before we leave.</span></li>
        </ol>
      </div>

      <div class="about-right frame reveal-right">
        <div class="company-card">
          <span class="company-card__mark" aria-hidden="true"><?php echo boltMark(26); ?></span>
          <p class="company-card__name"><?php echo esc($siteName); ?></p>
          <dl>
            <div><dt>Office</dt><dd><?php echo esc($address['street']); ?><br><?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?></dd></div>
            <div><dt>Work</dt><dd>Residential &middot; Commercial &middot; Industrial</dd></div>
            <div><dt>Phone</dt><dd><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a></dd></div>
            <div><dt>Email</dt><dd><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></dd></div>
          </dl>
        </div>
        <div class="about-stat-card"><b><?php echo esc($ownerName); ?></b><span>Owner</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 7. GOOGLE REVIEWS (Page One feed; renders nothing until the profile has written reviews) ============ -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$homeReviews = p1_google_reviews($slug, ['heading' => 'What Hagerstown customers say on Google']);
if ($homeReviews !== ''): ?>
<section class="section home-reviews" aria-label="Google reviews">
  <div class="container"><?php echo $homeReviews; ?></div>
</section>
<?php endif; ?>

<!-- ============ 8. MID-PAGE CTA (urgency) ============ -->
<section class="section cta-banner texture-grain edge-curve-top home-urgent" aria-labelledby="home-urgent-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Warning signs</span>
      <h2 id="home-urgent-title">A warm panel or a breaker that will not reset should not wait for next month</h2>
      <p>Heat, buzzing and repeat trips are how a panel tells you a connection or breaker is failing. If you can do it safely, switch off the affected circuit, keep the area clear and call <?php echo esc($siteName); ?> to have it looked at.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Send the details</button>
    </div>
  </div>
</section>

<!-- ============ 9. FAQ ============ -->
<section class="section home-faq" aria-labelledby="home-faq-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="home-faq-title">What do people ask before hiring an <span class="text-accent">electrician in Hagerstown</span>?</h2>
      <p>Six questions come up again and again before someone books an electrician in Hagerstown: permits, panel upgrades, EV chargers in older homes, cost, how to check a Maryland license, and whether <?php echo esc($siteName); ?> works on businesses as well as houses.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($homeFaqs as $homeFaqIdx => $homeFaq): ?>
      <details class="faq"<?php echo $homeFaqIdx < 2 ? ' open' : ''; ?>>
        <summary><?php echo esc($homeFaq['q']); ?></summary>
        <p><?php echo esc($homeFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 10. ESTIMATE SECTION (full form) ============ -->
<section class="section home-estimate" id="estimate" aria-labelledby="home-estimate-title">
  <div class="container estimate">
    <div class="card reveal-left">
      <span class="eyebrow-label">Estimate request</span>
      <h2 id="home-estimate-title">Tell us about the job</h2>
      <form action="<?php echo esc($formAction); ?>" method="POST" class="estimate-form">
        <?php echo p1_lead_hidden_fields('estimate-section'); ?>
        <div class="form-grid">
          <div class="field"><label for="est-name">Your name *</label><input id="est-name" type="text" name="name" autocomplete="name" required></div>
          <div class="field"><label for="est-phone">Phone *</label><input id="est-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="field full"><label for="est-email">Email *</label><input id="est-email" type="email" name="email" autocomplete="email" required></div>
          <div class="field full"><label for="est-service">Service needed</label><select id="est-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <div class="field full"><label for="est-message">What is going on?</label><textarea id="est-message" name="message" rows="4" placeholder="For example: breaker in the kitchen keeps tripping, house built in the 1950s"></textarea></div>
        </div>
        <fieldset class="form-consent-fieldset">
          <legend class="form-consent-legend">Communication consent</legend>
          <label class="form-consent-item" for="est-email-opt-in">
            <input id="est-email-opt-in" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
            <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo esc($email); ?>. Message frequency varies.</span>
          </label>
          <label class="form-consent-item" for="est-sms-opt-in">
            <input id="est-sms-opt-in" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
            <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
          </label>
          <label class="form-consent-item form-consent-required" for="est-terms">
            <input id="est-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
            <span class="consent-label">I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a> and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span></span>
          </label>
        </fieldset>
        <button type="submit" class="btn btn-accent btn-lg btn-block">Send my request</button>
      </form>
    </div>

    <div class="estimate-aside reveal-right">
      <h3>What happens next</h3>
      <ol class="next-steps">
        <li><strong>Your request reaches us directly</strong>The form goes straight to <?php echo esc($siteName); ?>, not a lead marketplace.</li>
        <li><strong>We follow up</strong>Expect a call or an email to ask about the job and where it is.</li>
        <li><strong>We set a time to look at it</strong>For most jobs the electrician needs to see the panel and wiring before giving a price.</li>
      </ol>
      <div class="nap">
        <div><?php echo icon('phone', 18); ?><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a></div>
        <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
        <div><?php echo icon('map-pin', 18); ?><span><?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?></span></div>
      </div>
      <p class="area-line"><?php echo esc($siteName); ?> serves <?php echo esc($address['city']); ?> and the surrounding area of Washington County, Maryland.</p>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
