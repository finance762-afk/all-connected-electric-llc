<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/ — service areas hub, All Connected Electric LLC (Phase 6). URL is /service-areas/ (plural) everywhere.
 * config.php $serviceAreas holds ONE area (Hagerstown). The research brief's other towns (Williamsport, Smithsburg, ...)
 * are unconfirmed by the client and therefore not listed; add a town to config.php and build its page, and this grid,
 * the nav, the footer, the schema and the sitemap all pick it up. Every area card links only when its page exists.
 * No map embed or geo coordinates were supplied (gbp_map_embed / geo are null), so the coverage visual is a labeled
 * schematic, with the GBP directions link for the real map. Sources for the permit-office facts are in
 * /service-areas/hagerstown/index.php.
 */
$pageTitle       = 'Electrician Service Areas | Hagerstown & Washington County';
$pageDescription = 'Where All Connected Electric LLC works: Hagerstown, MD and the surrounding Washington County area. See the Hagerstown page or call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$ogImage         = '';
$currentPage     = 'areas';
$pageType        = 'city';
$citySlug        = '';
$dialogService   = '';
$heroPreload     = [];
$heroFormTitle   = 'Electrical estimate in Hagerstown';

$hubRoot = rtrim($siteUrl, '/');
$hubPrimary = $serviceAreas[0]['name'];

/* Card copy per area slug: exactly 3 short bullets. Areas in config.php without an entry here fall back to a plain card. */
$hubAreaCopy = [
    'hagerstown' => [
        'tag'     => 'Home base',
        'desc'    => 'The Leitersburg Pike office, and the city whose older neighborhoods shape most of the work.',
        'bullets' => ['Older-house wiring and panels', 'City or County permit explained', 'Homes, shops and industrial sites'],
    ],
];

$pageFaqs = [
    ['q' => 'What areas does All Connected Electric LLC serve?',
     'a' => 'All Connected Electric LLC is based on Leitersburg Pike in Hagerstown, MD and serves Hagerstown and the surrounding area of Washington County. Hagerstown has its own page today. If your address is outside the city, call ' . $phone . ' and ask whether the company can take the job.'],
    ['q' => 'How do I tell whether my address is inside Hagerstown city limits or in the county?',
     'a' => 'A Hagerstown mailing address can sit either inside the city or in unincorporated Washington County, and the answer decides which office issues an electrical permit. The City of Hagerstown permit office at City Hall can confirm it, and Washington County Permits and Inspections handles county addresses from the Administrative Annex on Northern Avenue.'],
];

$hubItems = [];
foreach ($serviceAreas as $hubIdx => $hubArea) {
    $hubItem = ['@type' => 'City', 'name' => $hubArea['name'] . ', ' . $address['state']];
    if (areaUrl($hubArea['slug']) !== '') $hubItem['url'] = $hubRoot . areaUrl($hubArea['slug']);
    $hubItems[] = ['@type' => 'ListItem', 'position' => $hubIdx + 1, 'item' => $hubItem];
}
$hubAreaServed = [];
foreach ($serviceAreas as $hubArea) $hubAreaServed[] = ['@type' => 'City', 'name' => $hubArea['name'] . ', ' . $address['state']];

$schemaMarkup = [
    /* Same @id as the homepage Electrician node: merges by @id, adds areaServed without a second business entity. */
    ['@type' => 'Electrician', '@id' => $hubRoot . '/#organization', 'name' => $siteName, 'url' => $hubRoot . '/', 'telephone' => $phoneRaw, 'areaServed' => $hubAreaServed],
    ['@type' => 'CollectionPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle,
     'isPartOf' => ['@id' => $hubRoot . '/#website'], 'about' => ['@id' => $hubRoot . '/#organization'],
     'mainEntity' => ['@type' => 'ItemList', 'name' => $siteName . ' service areas', 'numberOfItems' => count($serviceAreas), 'itemListElement' => $hubItems],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Service Areas', 'url' => $canonicalUrl],
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
   Service areas hub — page-specific: area cards, coverage schematic (signature), jurisdiction pair.
   Tokens only.
   ========================================================================== */
.sa-areas { background: var(--color-paper); }
.sa-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; }
.sa-card {
  position: relative;
  display: grid;
  gap: var(--space-sm);
  align-content: start;
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  background: var(--color-card-tint-1);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  transition: transform var(--transition), box-shadow var(--transition);
}
.sa-card::before { content: ""; position: absolute; inset: 0 0 auto 0; height: 3px; background: var(--color-accent); }
.sa-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.sa-card--call { background: var(--color-card-tint-3); }
.sa-card__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.sa-card__icon { display: grid; place-items: center; width: var(--space-12); height: var(--space-12); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); }
.sa-card h3 { font-size: 1.25rem; }
.sa-card p { margin: 0; color: var(--color-ink-2); font-size: .95rem; }
.sa-card ul { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-xs); }
.sa-card li { position: relative; padding-left: var(--space-lg); font-size: .93rem; color: var(--color-ink-2); }
.sa-card li::before { content: ""; position: absolute; left: 0; top: .55em; width: var(--space-sm); height: 2px; background: var(--color-accent-dark); }
.sa-card__cta { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; font-weight: 700; color: var(--color-ink); }
.sa-card__cta:hover { color: var(--color-accent-dark); }

.sa-cover__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 6vw, 5rem); align-items: center; }
.sa-rings { width: 100%; max-width: 420px; margin-inline: auto; display: block; }
.sa-rings .ring { fill: none; stroke: color-mix(in srgb, var(--color-white) 22%, transparent); stroke-width: 1.5; stroke-dasharray: 3 6; }
.sa-rings .ring--inner { stroke: var(--color-accent); stroke-dasharray: none; stroke-width: 2; fill: color-mix(in srgb, var(--color-accent) 10%, transparent); }
.sa-rings .cross { stroke: color-mix(in srgb, var(--color-white) 12%, transparent); stroke-width: 1; }
.sa-rings .pin { fill: var(--color-accent); }
.sa-rings text { font-family: var(--font-accent); font-size: 11px; letter-spacing: .14em; text-transform: uppercase; fill: color-mix(in srgb, var(--color-white) 80%, transparent); }
.sa-rings .label-main { fill: var(--color-white); font-size: 13px; }
.sa-cover .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); color: color-mix(in srgb, var(--color-white) 86%, transparent); border-left-color: var(--color-accent); }
.sa-cover__note { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 65%, transparent); }
.sa-cover .actions { display: flex; flex-wrap: wrap; gap: var(--space-sm); margin-top: var(--space-lg); }

.sa-jur__pair { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-lg); margin: var(--space-xl) 0 0; }
.sa-jur__item { padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); display: grid; gap: var(--space-xs); }
.sa-jur__item svg { color: var(--color-accent-dark); }
.sa-jur__item h3 { font-size: 1.1rem; }
.sa-jur__item p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }

@media (max-width: 900px) { .sa-cover__grid, .sa-jur__pair { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO ============ -->
<section class="hero hero--interior sp-hero" aria-labelledby="sa-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Service Areas</span></li>
      </ol>
    </nav>
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <span class="eyebrow">Service areas &middot; Washington County, MD</span>
        <h1 class="hero-title" id="sa-hero-title">Electrician in <span class="text-accent"><?php echo esc($hubPrimary); ?>, <?php echo esc($address['state']); ?></span> &amp; Surrounding Communities</h1>
        <p class="hero-answer">All Connected Electric LLC works out of its Leitersburg Pike office in Hagerstown, MD and takes residential, commercial and industrial jobs in Hagerstown and the surrounding Washington County area.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get an estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('map-pin', 16); ?>Hagerstown office</li>
          <li><?php echo icon('house', 16); ?>Homes</li>
          <li><?php echo icon('building-2', 16); ?>Businesses</li>
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

<article class="sp-article" aria-labelledby="sa-hero-title">

<!-- ============ 2. AREA CARDS ============ -->
<section class="section sa-areas" aria-labelledby="sa-areas-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Where We Work</span>
      <h2 id="sa-areas-title">Which communities does All Connected Electric <span class="text-accent">serve around Hagerstown</span>?</h2>
    </div>
    <p class="answer-block reveal-up">All Connected Electric LLC serves Hagerstown, MD and the surrounding area of Washington County from its office on Leitersburg Pike. Hagerstown has a dedicated page below covering its older neighborhoods, permit offices and winter conditions. For an address elsewhere in the county, a phone call settles whether the company can take the job.</p>
    <div class="sa-grid">
<?php foreach ($serviceAreas as $hubIdx => $hubArea):
    $hubCopy = $hubAreaCopy[$hubArea['slug']] ?? ['tag' => 'Service area', 'desc' => 'Electrical work in ' . $hubArea['name'] . ', ' . $address['state'] . '.', 'bullets' => []];
    $hubAreaHref = areaUrl($hubArea['slug']); ?>
      <article class="sa-card reveal-up reveal-delay-<?php echo ($hubIdx % 3) + 1; ?>">
        <span class="sa-card__icon"><?php echo icon('map-pin', 24); ?></span>
        <span class="sa-card__tag"><?php echo esc($hubCopy['tag']); ?></span>
        <h3>Electrician in <?php echo esc($hubArea['name']); ?>, <?php echo esc($address['state']); ?></h3>
        <p><?php echo esc($hubCopy['desc']); ?></p>
<?php if ($hubCopy['bullets']): ?>
        <ul>
<?php foreach ($hubCopy['bullets'] as $hubBullet): ?>
          <li><?php echo esc($hubBullet); ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
<?php if ($hubAreaHref !== ''): ?>
        <a class="sa-card__cta" href="<?php echo esc($hubAreaHref); ?>">Electrical services in <?php echo esc($hubArea['name']); ?> <?php echo icon('arrow-right', 16); ?></a>
<?php endif; ?>
      </article>
<?php endforeach; ?>
      <article class="sa-card sa-card--call reveal-up reveal-delay-<?php echo (count($serviceAreas) % 3) + 1; ?>">
        <span class="sa-card__icon"><?php echo icon('phone', 24); ?></span>
        <span class="sa-card__tag">Elsewhere in the county</span>
        <h3>Address outside Hagerstown?</h3>
        <p>Other Washington County communities do not have their own pages yet. Call the office with the address and ask whether All Connected Electric LLC can take the job.</p>
        <a class="sa-card__cta" href="tel:<?php echo esc($phoneRaw); ?>">Call <?php echo esc(formatPhone($phone)); ?> <?php echo icon('arrow-right', 16); ?></a>
      </article>
    </div>
  </div>
</section>

<!-- ============ 3. SIGNATURE: COVERAGE SCHEMATIC (dark) ============ -->
<section class="section sa-cover texture-grain slant-top" aria-labelledby="sa-cover-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="sa-cover__grid">
      <div class="reveal-left">
        <svg class="sa-rings" viewBox="0 0 400 400" role="img" aria-labelledby="sa-rings-title sa-rings-desc">
          <title id="sa-rings-title">Coverage schematic: Hagerstown office at the center</title>
          <desc id="sa-rings-desc">Concentric rings centered on the Hagerstown office on Leitersburg Pike, with the city innermost and Washington County surrounding it. Not to scale.</desc>
          <line class="cross" x1="200" y1="10" x2="200" y2="390"/>
          <line class="cross" x1="10" y1="200" x2="390" y2="200"/>
          <circle class="ring" cx="200" cy="200" r="185"/>
          <circle class="ring" cx="200" cy="200" r="135"/>
          <circle class="ring ring--inner" cx="200" cy="200" r="80"/>
          <circle class="pin" cx="200" cy="200" r="7"/>
          <text class="label-main" x="200" y="232" text-anchor="middle">Hagerstown</text>
          <text x="200" y="120" text-anchor="middle">Washington County</text>
          <text x="200" y="372" text-anchor="middle">Call to confirm</text>
        </svg>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Coverage</span>
        <h2 id="sa-cover-title">Where does the Hagerstown office send its electricians?</h2>
        <p class="answer-block">The office at <?php echo esc($address['street']); ?> in Hagerstown is the center of the coverage area. Hagerstown is the core, the rest of Washington County is the surrounding area, and an address near the edge is a quick call. The schematic shows the idea, not exact distances.</p>
        <p class="sa-cover__note">Schematic only, not to scale. For the real map and driving directions to the office, use the directions link.</p>
        <div class="actions">
          <a class="btn btn-accent btn-lg" href="<?php echo esc($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('map-pin', 18); ?>Get directions to the office</a>
          <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 4. CITY VS COUNTY ============ -->
<section class="section sa-jur" aria-labelledby="sa-jur-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Before the permit</span>
      <h2 id="sa-jur-title">Is my Hagerstown address in the city or the county?</h2>
    </div>
    <p class="answer-block reveal-up">A Hagerstown mailing address can fall inside the City of Hagerstown or in unincorporated Washington County, and that decides which office handles an electrical permit. Panel upgrades, new circuits and most generator and EV charger jobs usually need a permit and inspection, so the answer comes up on the first call.</p>
    <div class="sa-jur__pair">
      <div class="sa-jur__item reveal-left">
        <?php echo icon('landmark', 24); ?>
        <h3>Inside the city</h3>
        <p>The City of Hagerstown permit office at City Hall, 1 East Franklin Street, handles electrical permits for addresses within city limits.</p>
      </div>
      <div class="sa-jur__item reveal-right">
        <?php echo icon('building-2', 24); ?>
        <h3>Elsewhere in the county</h3>
        <p>Washington County Permits and Inspections, in the Administrative Annex at 747 Northern Avenue, handles unincorporated county addresses.</p>
      </div>
    </div>
    <p class="sp-table-note">Confirm the office, hours and fees directly before a permit is filed. <a href="<?php echo esc(areaUrl('hagerstown') ?: '/service-areas/'); ?>">The Hagerstown page</a> covers what each office means for your job.</p>
  </div>
</section>

<!-- ============ 5. FAQ ============ -->
<section class="section sp-faq" aria-labelledby="sa-faq-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Questions</span>
      <h2 id="sa-faq-title">What do people ask about where All Connected Electric works?</h2>
      <p>Two questions come first: which communities All Connected Electric LLC covers, and how to tell whether an address is in Hagerstown or the county. Both answers are below.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($pageFaqs as $hubFaqIdx => $hubFaq): ?>
      <details class="faq"<?php echo $hubFaqIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo esc($hubFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo esc($hubFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></p></div>
</article>

<!-- ============ 6. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sa-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Estimate</span>
      <h2 id="sa-cta-title">Get an estimate for electrical work in Hagerstown and Washington County</h2>
      <p>Call <?php echo esc(formatPhone($phone)); ?> or send the details, and <?php echo esc($siteName); ?> will follow up to set a time to look at the job.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Send the details</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
