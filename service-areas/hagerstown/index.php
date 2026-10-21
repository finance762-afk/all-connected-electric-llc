<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/hagerstown/ — Electrician in Hagerstown, MD (Phase 6, the only area in config.php $serviceAreas).
 *
 * RESEARCH (2026-10-21) — sources for every local fact on this page:
 *   Founding 1762 as Elizabethtown, Hub City nickname, Commercial Core / Historic District / Oak Hill / Potomac-Broadway /
 *     South Prospect Street / City Park / Lehman's Mill districts, local limestone buildings, January mean daily minimum
 *     25.3 F, record low -27 F on Jan 13 1912 ......... https://en.wikipedia.org/wiki/Hagerstown,_Maryland
 *   Hagerstown Historic District: original 1760s plat, National Register 1994 ...... https://apps.mht.maryland.gov/nr/NRDetail.aspx?NRID=1117
 *   Oak Hill: c.1908-1941, ~76 acres, Colonial/Georgian Revival, Tudor, Foursquare, Bungalow, garages, NR 1987 ..... https://apps.mht.maryland.gov/nr/NRDetail.aspx?NRID=999
 *   Population more than doubled in the first four decades of the 1900s (railroad hub) ........ same NRID=999 record
 *   City Park (bought 1916, Lower Lake 1921, museum of fine arts, Hager House) ........ https://en.wikipedia.org/wiki/Hagerstown_City_Park
 *   Leitersburg Pike = MD 60, runs north from Northern Ave / Eastern Blvd / Potomac Ave ........ https://en.wikipedia.org/wiki/Maryland_Route_60
 *   Permit offices: City Hall, 1 East Franklin Street (electrical permit application, hagerstownmd.org DocumentCenter/View/20685);
 *     Washington County Permits and Inspections, Administrative Annex, 747 Northern Avenue ........ https://www.washco-md.net/permits-and-inspections/permits-issue/
 *   Potomac Edison serves Washington County (FirstEnergy subsidiary) ........ https://opc.maryland.gov/Consumer-Learning/Electricity
 * Elevation is deliberately NOT stated (sources conflict; the page does not need it). USDA zone not stated (not verified for 21742).
 * Unverifiable names from the research brief (Williamsport, Smithsburg, ...) are not used. No frequency-of-past-work claims,
 * no license/insurance/price/hours/"free estimate"/24-7 claims — see /content-confirmations.json.
 */
$pageSlug        = 'hagerstown';
$areaName        = 'Hagerstown';
$pageTitle       = 'Hagerstown Electrician | Older Homes & Shops | All Connected';
$pageDescription = 'All Connected Electric LLC, on Leitersburg Pike in Hagerstown, MD: electrician for older homes, businesses and industrial sites. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/service-areas/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'areas';
$pageType        = 'city';
$citySlug        = $pageSlug;
$dialogService   = '';
$heroPreload     = [];
$heroFormTitle   = 'Electrical estimate in ' . $areaName;

$areaRoot = rtrim($siteUrl, '/');

/* Building-era table: every "Built" cell is sourced above; every "Inside the walls" cell is general electrical knowledge, hedged. */
$areaEras = [
    ['place' => 'Downtown and the original town plat', 'icon' => 'landmark',
     'built' => 'The plat dates to the 1760s, and the Hagerstown Historic District has been on the National Register since 1994. Many older buildings downtown are local limestone.',
     'inside' => 'Thick masonry walls limit where new cable can be fished, so rewiring there often means careful routing or surface raceway. Storefront and upper-floor circuits get traced before any new load is added.',
     'slugs' => ['wiring-rewiring', 'commercial-electrical', 'lighting-installation']],
    ['place' => 'Oak Hill, the north-end garden district', 'icon' => 'trees',
     'built' => 'About 76 acres built c. 1908 to 1941 (National Register, 1987): Colonial and Georgian Revival, Tudor Revival, Foursquare and Bungalow houses, most with a garage from the same decades.',
     'inside' => 'Houses wired in that era were sized for a few lights and an iron. Knob-and-tube wiring can still be found in houses that old, and an original garage often has one circuit or none, which matters for a charger or a workshop.',
     'slugs' => ['wiring-rewiring', 'panel-upgrades', 'ev-charger-installation']],
    ['place' => 'South Prospect Street, Potomac-Broadway and City Park', 'icon' => 'house',
     'built' => 'Each is its own National Register historic district in Hagerstown. City Park itself was bought by the city in 1916 and holds the Washington County Museum of Fine Arts and the Hager House.',
     'inside' => 'A house that has been updated in stages carries new and old wiring on one panel. A walk-through that traces which circuits are which comes before any quote, so what stays and what goes is decided on facts.',
     'slugs' => ['residential-electrical', 'outlet-switch-repair', 'wiring-rewiring']],
    ['place' => 'Newer houses and additions, anywhere in the city', 'icon' => 'layers',
     'built' => 'Anything built after the mid-1900s, plus additions and finished basements on older houses.',
     'inside' => 'The wiring is newer, but it was planned for fewer devices than a household runs now. The usual problem is capacity, not age: an EV charger, a heat pump or a second refrigerator pushes the panel past what it was sized for.',
     'slugs' => ['panel-upgrades', 'ev-charger-installation', 'generator-installation']],
];

/* Icon per service for the "available in Hagerstown" list (same icons as the services hub). */
$areaSvcIcons = [
    'commercial-electrical' => 'building-2', 'residential-electrical' => 'house', 'industrial-electrical' => 'hard-hat',
    'panel-upgrades' => 'zap', 'ev-charger-installation' => 'battery-charging', 'lighting-installation' => 'lightbulb',
    'wiring-rewiring' => 'waypoints', 'ceiling-fan-installation' => 'wind', 'generator-installation' => 'power',
    'outlet-switch-repair' => 'plug', 'emergency-electrician' => 'flame',
];
$areaSvcNames = [];
foreach ($services as $areaSvcRow) $areaSvcNames[$areaSvcRow['slug']] = $areaSvcRow['name'];

$pageFaqs = [
    ['q' => 'Do I need a permit for electrical work in Hagerstown?',
     'a' => 'Many electrical jobs in Hagerstown need a permit and an inspection, including new circuits, panel and service upgrades, and most generator and EV charger installations. Which office issues it depends on whether the address is inside the City of Hagerstown or in unincorporated Washington County, so confirm that first and ask All Connected Electric LLC how the permit fits into your job.'],
    ['q' => 'Can All Connected Electric LLC rewire an older Hagerstown house?',
     'a' => 'Wiring and rewiring for older homes and renovations is one of the eleven services All Connected Electric LLC lists. In a house from the early 1900s the first step is looking at what wiring is there and what it feeds, so the quote covers what actually needs replacing rather than a whole-house guess.'],
    ['q' => 'Who do I call when the power goes out in Hagerstown: the utility or an electrician?',
     'a' => 'Potomac Edison delivers electricity in Washington County, so a neighborhood-wide outage goes to Potomac Edison. A tripping breaker, a dead outlet or a warm panel inside your building is an electrician\'s job. A service upgrade involves both, because the utility has to disconnect and reconnect the service.'],
];

$schemaMarkup = [
    /* Same @id as the homepage Electrician node: JSON-LD merges by @id, so this adds areaServed without a second business entity. */
    ['@type' => 'Electrician', '@id' => $areaRoot . '/#organization', 'name' => $siteName, 'url' => $areaRoot . '/', 'telephone' => $phoneRaw,
     'areaServed' => [['@type' => 'City', 'name' => $areaName . ', ' . $address['state'], 'sameAs' => 'https://en.wikipedia.org/wiki/Hagerstown,_Maryland',
                       'containedInPlace' => ['@type' => 'AdministrativeArea', 'name' => 'Washington County, Maryland']]]],
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle,
     'about' => ['@id' => $areaRoot . '/#organization'], 'isPartOf' => ['@id' => $areaRoot . '/#website'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Service Areas', 'url' => $siteUrl . '/service-areas/'],
        ['name' => $areaName . ', ' . $address['state'], 'url' => $canonicalUrl],
    ]),
    generateFAQSchema($pageFaqs),
];
/* Lead form: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Hagerstown area page — page-specific: building-era ledger (signature), permit pair, winter band, service list.
   Tokens only.
   ========================================================================== */
.ar-era { display: grid; gap: var(--space-md); margin: var(--space-xl) 0 0; padding: 0; list-style: none; }
.ar-era > li {
  display: grid;
  grid-template-columns: minmax(0, .8fr) minmax(0, 1.1fr) minmax(0, 1.1fr);
  gap: var(--space-lg);
  padding: var(--space-lg);
  border: 1px solid var(--color-line);
  border-left: var(--space-1) solid var(--color-accent);
  border-radius: var(--radius-lg);
  background: var(--color-surface);
  box-shadow: var(--shadow-sm);
  transition: transform var(--transition), box-shadow var(--transition);
}
.ar-era > li:nth-child(odd) { background: var(--color-card-tint-1); }
.ar-era > li:nth-child(even) { background: var(--color-card-tint-2); }
.ar-era > li:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.ar-era__place { display: grid; gap: var(--space-xs); align-content: start; }
.ar-era__place svg { color: var(--color-accent-dark); }
.ar-era__place h3 { font-size: 1.1rem; }
.ar-era__col h4 { margin: 0 0 var(--space-xs); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.ar-era__col p { margin: 0; font-size: .93rem; color: var(--color-ink-2); }
.ar-era__links { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: var(--space-sm) 0 0; padding: 0; list-style: none; }
.ar-era__links a { display: inline-flex; align-items: center; min-height: 44px; padding: 0 var(--space-sm); border: 1px solid var(--color-line); border-radius: var(--radius-full); background: var(--color-surface); font-size: var(--fs-small); font-weight: 600; color: var(--color-ink); }
.ar-era__links a:hover { border-color: var(--color-accent-dark); color: var(--color-accent-dark); }

.ar-permit__pair { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 var(--space-md); }
.ar-office { display: grid; gap: var(--space-xs); padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.ar-office svg { color: var(--color-accent-dark); }
.ar-office h3 { font-size: 1.1rem; }
.ar-office p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
.ar-office address { font-style: normal; font-weight: 600; color: var(--color-ink); }

.ar-winter__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: clamp(2rem, 6vw, 5rem); align-items: start; }
.ar-winter__temp { display: grid; gap: var(--space-xs); padding-top: var(--space-md); border-top: 3px solid var(--color-accent); }
.ar-winter__temp b { font-family: var(--font-accent); font-size: clamp(3.2rem, 2rem + 4vw, 5.5rem); line-height: .9; color: var(--color-white); }
.ar-winter__temp b small { font-size: .45em; color: var(--color-accent-bright); }
.ar-winter__temp span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 70%, transparent); max-width: 32ch; }
.ar-winter .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 86%, transparent); border-left-color: var(--color-accent); }
.ar-winter a { color: var(--color-white); text-decoration-color: var(--color-accent); }

.ar-svc { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 var(--space-xl); margin: var(--space-lg) 0 0; padding: 0; list-style: none; }
.ar-svc li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-sm); align-items: start; padding: var(--space-md) 0; border-top: 1px solid var(--color-line); }
.ar-svc svg { color: var(--color-accent-dark); margin-top: 3px; }
.ar-svc a, .ar-svc b { font-family: var(--font-heading); font-weight: 700; color: var(--color-ink); }
.ar-svc a:hover { color: var(--color-accent-dark); }
.ar-svc span { display: block; font-size: .92rem; color: var(--color-ink-2); }

.ar-why { margin: var(--space-lg) 0 0; padding: 0; list-style: none; display: grid; gap: var(--space-md); }
.ar-why li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-md); padding-top: var(--space-md); border-top: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); }
.ar-why svg { color: var(--color-accent-bright); margin-top: 3px; }
.ar-why b { display: block; color: var(--color-white); font-family: var(--font-heading); }
.ar-why span { color: color-mix(in srgb, var(--color-white) 78%, transparent); font-size: .95rem; }

@media (max-width: 900px) {
  .ar-era > li { grid-template-columns: 1fr; }
  .ar-permit__pair, .ar-winter__grid, .ar-svc { grid-template-columns: 1fr; }
}
</style>

<!-- ============ 1. HERO ============ -->
<section class="hero hero--interior sp-hero" aria-labelledby="ar-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/service-areas/">Service Areas</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page"><?php echo esc($areaName); ?>, <?php echo esc($address['state']); ?></span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <span class="eyebrow">Washington County seat &middot; Leitersburg Pike office</span>
        <h1 class="hero-title" id="ar-hero-title">Electrician in <span class="text-accent"><?php echo esc($areaName); ?>, <?php echo esc($address['state']); ?></span></h1>
        <p class="hero-answer">All Connected Electric LLC is an electrical contractor based on Leitersburg Pike in Hagerstown, MD, doing residential, commercial and industrial electrical work for the city and Washington County.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an estimate in <?php echo esc($areaName); ?></button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('house', 16); ?>Residential</li>
          <li><?php echo icon('building-2', 16); ?>Commercial</li>
          <li><?php echo icon('hard-hat', 16); ?>Industrial</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title"><?php echo esc($heroFormTitle); ?></h2>
        <p class="hero-form-tagline">Tell us what you need and where. The request goes to the Hagerstown office.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(''); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="ar-hero-title">

<!-- ============ 2. WHO + WHERE (identity answer) ============ -->
<section class="section ar-who" aria-labelledby="ar-who-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Who works in Hagerstown</span>
      <h2 id="ar-who-title">Who is the <span class="text-accent">electrician near me in Hagerstown</span>?</h2>
    </div>
    <p class="answer-block reveal-up">All Connected Electric LLC is a Hagerstown electrical contractor owned by <?php echo esc($ownerName); ?>, in business since <?php echo (int) $yearEstablished; ?> and based at <?php echo esc($address['street']); ?>. The company takes residential, commercial and industrial jobs in Hagerstown and the surrounding Washington County area, from a dead outlet to a panel upgrade.</p>
    <div class="prose reveal-up">
      <p>Hagerstown has been a crossroads since the railroads made it the &ldquo;Hub City,&rdquo; and its buildings show it: a downtown laid out in the 1760s with many limestone buildings, early-1900s neighborhoods built as the city's population more than doubled, and newer houses and shops around them. Electrical work here rarely starts from a blank slate. Most calls begin with equipment from a different decade than the load it now carries.</p>
      <p>The office sits on Leitersburg Pike, the name MD 60 takes as it heads north out of Hagerstown. That is where calls, emails and website requests arrive. If you are looking for an electrician near you in Hagerstown, the sections below explain what the city's older building stock means for the work, which permit office to expect, and which of the eleven services fit.</p>
    </div>
  </div>
</section>

<!-- ============ 3. SIGNATURE: BUILDING-ERA LEDGER ============ -->
<section class="section ar-eras" aria-labelledby="ar-eras-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Hagerstown by building era</span>
      <h2 id="ar-eras-title">What does an electrician find in Hagerstown's older neighborhoods?</h2>
    </div>
    <p class="answer-block reveal-up">The answer depends on when the building went up. Downtown's masonry buildings, Oak Hill's 1908 to 1941 houses and newer construction each hide a different problem: hard-to-reach routes, original wiring that predates today's loads, or a panel that is simply too small. This ledger pairs each part of Hagerstown with what to plan for.</p>
    <ul class="ar-era">
<?php foreach ($areaEras as $areaEraIdx => $areaEra): ?>
      <li class="reveal-<?php echo $areaEraIdx % 2 === 0 ? 'left' : 'right'; ?>">
        <div class="ar-era__place">
          <?php echo icon($areaEra['icon'], 24); ?>
          <h3><?php echo esc($areaEra['place']); ?></h3>
        </div>
        <div class="ar-era__col">
          <h4>When it was built</h4>
          <p><?php echo esc($areaEra['built']); ?></p>
        </div>
        <div class="ar-era__col">
          <h4>What to plan for inside the walls</h4>
          <p><?php echo esc($areaEra['inside']); ?></p>
          <ul class="ar-era__links">
<?php foreach ($areaEra['slugs'] as $areaEraSlug): $areaEraUrl = serviceUrl($areaEraSlug); if ($areaEraUrl === '') continue; ?>
            <li><a href="<?php echo esc($areaEraUrl); ?>"><?php echo esc($areaSvcNames[$areaEraSlug] ?? $areaEraSlug); ?></a></li>
<?php endforeach; ?>
          </ul>
        </div>
      </li>
<?php endforeach; ?>
    </ul>
    <p class="sp-table-note">Era notes describe what is typical of buildings from each period, not a finding about any one address. A house is only assessed once it has been looked at.</p>
  </div>
</section>

<!-- ============ 4. PERMITS: CITY VS COUNTY ============ -->
<section class="section ar-permit" aria-labelledby="ar-permit-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Permits and inspections</span>
      <h2 id="ar-permit-title">Which office handles electrical permits in Hagerstown?</h2>
    </div>
    <p class="answer-block reveal-up">It depends on the address. A property inside the City of Hagerstown deals with the city's permit office at City Hall, and a property in unincorporated Washington County deals with the county's Permits and Inspections office on Northern Avenue. Panel upgrades, new circuits and most generator and EV charger jobs usually need a permit and an inspection from one of them.</p>
    <div class="ar-permit__pair">
      <div class="ar-office reveal-left">
        <?php echo icon('landmark', 24); ?>
        <h3>City of Hagerstown</h3>
        <p>Permit office at City Hall for addresses inside city limits.</p>
        <address>1 East Franklin Street<br>Hagerstown, MD</address>
      </div>
      <div class="ar-office reveal-right">
        <?php echo icon('building-2', 24); ?>
        <h3>Washington County Permits and Inspections</h3>
        <p>Administrative Annex, for addresses in unincorporated Washington County.</p>
        <address>747 Northern Avenue<br>Hagerstown, MD 21742</address>
      </div>
    </div>
    <p class="sp-table-note">Hagerstown mailing addresses can sit in either jurisdiction. Confirm the office, current hours and fees with it directly before a permit is filed; both offices publish their own application forms. Ask <?php echo esc($siteName); ?> how the permit fits into your job when you call <?php echo esc(formatPhone($phone)); ?>.</p>
  </div>
</section>

<!-- ============ 5. WINTER + UTILITY (dark band) ============ -->
<section class="section ar-winter texture-grain slant-top" aria-labelledby="ar-winter-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="ar-winter__grid">
      <div class="ar-winter__temp reveal-left">
        <b>25.3<small>&deg;F</small></b>
        <span>Average January daily low in Hagerstown. The record low is &minus;27&deg;F, set January 13, 1912.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Winter and outages</span>
        <h2 id="ar-winter-title">How does a Hagerstown winter change electrical planning?</h2>
        <p class="answer-block">Hagerstown winters push electrical load up and make an outage more than an inconvenience. Heat pumps, space heaters and electric heat draw hard on an older panel, and a long outage in January leaves a house without heat or a sump pump. All Connected Electric LLC plans panel, generator and heating circuits with that cold season in mind.</p>
        <ul class="ar-why">
          <li><?php echo icon('zap', 20); ?><div><b>Heating loads on older panels</b><span>A heat pump or a run of space heaters is the kind of added load that shows up as a tripping breaker. A load calculation says whether <?php echo serviceLink('panel-upgrades', 'a panel upgrade'); ?> is needed first.</span></div></li>
          <li><?php echo icon('power', 20); ?><div><b>Backup power done safely</b><span>A generator belongs on a transfer switch so it never feeds back onto the utility's lines. See <?php echo serviceLink('generator-installation', 'generator installation'); ?> for how chosen circuits are kept on.</span></div></li>
          <li><?php echo icon('route', 20); ?><div><b>The utility side</b><span>Potomac Edison delivers electricity in Washington County. It handles neighborhood outages and the service connection; the wiring inside the building is the electrician's side of the meter.</span></div></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. SERVICES AVAILABLE IN HAGERSTOWN ============ -->
<section class="section ar-services" aria-labelledby="ar-services-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="ar-services-title">Which electrical services does All Connected Electric offer in Hagerstown?</h2>
    </div>
    <p class="answer-block reveal-up">All Connected Electric LLC offers eleven electrical services in Hagerstown, MD, split across homes, commercial buildings and industrial sites: panel upgrades, EV chargers, lighting, wiring and rewiring, ceiling fans, generators, outlet and switch repair, and emergency troubleshooting. Each one has its own page.</p>
    <ul class="ar-svc reveal-up">
<?php foreach ($services as $areaSvcItem): $areaSvcUrl = serviceUrl($areaSvcItem['slug']); ?>
      <li>
        <?php echo icon($areaSvcIcons[$areaSvcItem['slug']] ?? 'zap', 22); ?>
        <div>
<?php if ($areaSvcUrl !== ''): ?>
          <a href="<?php echo esc($areaSvcUrl); ?>"><?php echo esc($areaSvcItem['name']); ?> in <?php echo esc($areaName); ?></a>
<?php else: ?>
          <b><?php echo esc($areaSvcItem['name']); ?></b>
<?php endif; ?>
          <span><?php echo esc($areaSvcItem['description']); ?></span>
        </div>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ 7. WHY THIS COMPANY (company facts only) ============ -->
<section class="section ar-company" aria-labelledby="ar-company-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Why call the Leitersburg Pike office</span>
        <h2 id="ar-company-title">Why choose All Connected Electric for work in Hagerstown?</h2>
        <p class="answer-block">All Connected Electric LLC is based in Hagerstown, has worked since <?php echo (int) $yearEstablished; ?>, and covers residential, commercial and industrial work under one owner, <?php echo esc($ownerName); ?>. A homeowner with a failing panel and a shop owner adding equipment call the same office, and the permit question is explained for both.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Local office.</b> The business operates from <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Three sectors, one company.</b> <?php echo serviceLink('residential-electrical', 'Residential'); ?>, <?php echo serviceLink('commercial-electrical', 'commercial'); ?> and <?php echo serviceLink('industrial-electrical', 'industrial'); ?> work.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Permit explained up front.</b> You are told which Hagerstown or Washington County office applies to your address.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Look first, price second.</b> The panel and wiring are checked before a number is given.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a Hagerstown job go from first call to finished?</h3>
        <ol class="sp-steps">
          <li><b>You call or send the form</b><span>Say what is happening and give the address, which also tells us which permit office applies.</span></li>
          <li><b>The panel and wiring are looked at</b><span>Older houses get the wiring traced before any price is given.</span></li>
          <li><b>Scope and permit</b><span>You get the work described and what it needs from the City or the County.</span></li>
          <li><b>The work, then inspection</b><span>Circuits are installed or repaired, then inspected where a permit applies.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 8. REVIEWS (renders nothing until GBP has written reviews) ============ -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$areaReviews = p1_google_reviews($slug, ['heading' => 'What Hagerstown customers say about All Connected Electric']);
if ($areaReviews !== ''): ?>
<section class="section sp-reviews" aria-label="Google reviews">
  <div class="container"><?php echo $areaReviews; ?></div>
</section>
<?php endif; ?>

<!-- ============ 9. FAQ ============ -->
<section class="section sp-faq" aria-labelledby="ar-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="ar-faq-title">What do Hagerstown customers ask an electrician?</h2>
      <p>Three questions come up before most Hagerstown jobs: whether a permit is needed, whether an older house can be rewired, and who to call when the power goes out. Here is how All Connected Electric LLC answers them.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($pageFaqs as $areaFaqIdx => $areaFaq): ?>
      <details class="faq"<?php echo $areaFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($areaFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo esc($areaFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> &middot; <a href="/service-areas/">All service areas</a></p></div>
</article>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="ar-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Estimate in <?php echo esc($areaName); ?></span>
      <h2 id="ar-cta-title">Get an estimate for electrical work in <?php echo esc($areaName); ?></h2>
      <p>Call <?php echo esc(formatPhone($phone)); ?> or send the details, and <?php echo esc($siteName); ?> will follow up to set a time to look at the job. If a panel is hot or something smells of burning, switch off the main if it is safe to do so and call right away.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Send the details</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
