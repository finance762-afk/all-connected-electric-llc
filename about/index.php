<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /about/ — About All Connected Electric LLC (Phase 5).
 * No client photos or logo are on disk (build-plan assets.images is empty), so the story section pairs the copy with a
 * typeset "company file" card instead of a photo. Swap the card for a split-content photo once the image manifest exists.
 * Every fact traces to build-plan.json / config.php. NOT claimed (no intake answer yet, see /content-confirmations.json):
 * license number, insurance, certifications, owner's pre-2016 background, prices, hours, towns beyond Hagerstown.
 */
$pageTitle       = 'About Us | All Connected Electric LLC | Hagerstown, MD';
$pageDescription = 'All Connected Electric LLC is a Hagerstown, MD electrical contractor owned by Andrew Porter since 2016. Meet the team, then call (301) 704-6333 for an estimate.';
$canonicalUrl    = $siteUrl . '/about/';
$ogImage         = '';
$currentPage     = 'about';
$pageType        = 'about';
$heroPreload     = [];

$aboutFile = [
    ['icon' => 'users',      'label' => 'Owner',             'value' => $ownerName],
    ['icon' => 'map-pin',    'label' => 'Office',            'value' => $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip']],
    ['icon' => 'building-2', 'label' => 'Business type',     'value' => 'Limited Liability Company'],
    ['icon' => 'layers',     'label' => 'Work for',          'value' => 'Residential, commercial and industrial customers'],
    ['icon' => 'zap',        'label' => 'Services',          'value' => count($services) . ' electrical services'],
];

$aboutValues = [
    ['icon' => 'search',        'title' => 'Look before pricing',  'text' => 'A price follows a look at the panel, the wiring and what is plugged into them. A number given without seeing those is a guess, and a guess is how a small job turns into a surprise bill.'],
    ['icon' => 'ruler',         'title' => 'Size it to the load',  'text' => 'Panels, service upgrades and EV charger circuits are sized from a load calculation, the method the National Electrical Code uses, not copied from the label on the old equipment.'],
    ['icon' => 'clipboard-list','title' => 'Explain the permit',   'text' => 'Many electrical jobs need a permit and an inspection, and the City of Hagerstown and unincorporated Washington County handle them differently. You are told which applies to your address.'],
    ['icon' => 'handshake',     'title' => 'Plain answers',        'text' => 'What is probably wrong, which fix fits, and what to ask any electrician before work starts. Electrical terms get explained in the words you would use at the kitchen table.'],
];

$aboutTimeline = [
    ['when' => (string) $yearEstablished, 'title' => 'All Connected Electric LLC starts in Hagerstown',  'text' => 'Andrew Porter opens the company to do electrical work for the Hagerstown area.'],
    ['when' => 'Office',                  'title' => 'The office on Leitersburg Pike',                    'text' => 'Calls, emails and website requests all come into one office at ' . $address['street'] . ', ' . $address['city'] . '.'],
    ['when' => 'Today',                   'title' => count($services) . ' services across three sectors', 'text' => 'Residential, commercial and industrial work, from outlet repair and ceiling fans to panel upgrades, EV chargers and generator hookups.'],
];

$aboutAsk = [
    ['icon' => 'badge-check', 'title' => 'The license number',        'text' => 'Maryland requires electrical contractors to be licensed. Ask for the number and look it up with the Maryland State Board of Master Electricians.'],
    ['icon' => 'shield-check','title' => 'Proof of insurance',        'text' => 'Ask for a certificate showing general liability and workers\' compensation coverage before anyone opens a panel in your building.'],
    ['icon' => 'clipboard-list','title' => 'Who pulls the permit',    'text' => 'For work that needs one, ask who applies for the permit and who schedules the inspection, and get the answer before the day is set.'],
    ['icon' => 'pencil-ruler','title' => 'The scope in writing',      'text' => 'Ask for what is included, what is not, and how a change in scope gets priced, so the price on paper matches the work on site.'],
];

$aboutNodes = [
    ['@type' => 'AboutPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'], 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    ['@type' => 'Person', '@id' => $canonicalUrl . '#owner', 'name' => $ownerName, 'jobTitle' => 'Owner',
     'worksFor' => ['@id' => rtrim($siteUrl, '/') . '/#organization']],
    generateBreadcrumbSchema([
        ['name' => 'Home',  'url' => $siteUrl . '/'],
        ['name' => 'About', 'url' => $canonicalUrl],
    ]),
];
$schemaMarkup = $aboutNodes;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   About — page-specific: the "company file" card (signature section), value tiles, timeline rail. Tokens only.
   ========================================================================== */
.ab-hero .hero-copy { max-width: 62ch; }
.ab-story__grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, .85fr); gap: clamp(2rem, 6vw, 5rem); align-items: start; }
.ab-story .prose p { color: var(--color-ink-2); }
.ab-file {
  position: sticky;
  top: calc(var(--nav-height) + var(--space-lg));
  margin: 0;
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border-radius: var(--radius-lg);
  background: linear-gradient(160deg, color-mix(in srgb, var(--color-secondary) 16%, var(--color-surface)) 0%, var(--color-surface) 70%);
  border: 1px solid var(--color-line);
  border-top: var(--space-1) solid var(--color-accent);
  box-shadow: var(--shadow-lg);
}
.ab-file__head { margin: 0 0 var(--space-md); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .16em; text-transform: uppercase; color: var(--color-muted); }
.ab-file__list { display: grid; gap: 0; margin: 0; padding: 0; list-style: none; }
.ab-file__list li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-sm); padding: var(--space-sm) 0; border-top: 1px solid var(--color-line); }
.ab-file__list li:first-child { border-top: 0; }
.ab-file__list svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
.ab-file__list b { display: block; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); font-weight: 700; }
.ab-file__list span { color: var(--color-ink); font-weight: 600; line-height: 1.35; }
.ab-year { margin: 0 0 var(--space-md); font-family: var(--font-accent); font-size: clamp(3.4rem, 2rem + 5vw, 6rem); line-height: .9; color: var(--color-ink); letter-spacing: .01em; }
.ab-year span { color: var(--color-accent-dark); }

.ab-values__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin-top: var(--space-xl); }
.ab-value { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ab-value:hover { transform: translateY(calc(var(--space-1) * -1)); box-shadow: var(--shadow); }
.ab-value:nth-child(even) { margin-top: var(--space-lg); }
.ab-value__icon { display: grid; place-items: center; width: var(--space-10); height: var(--space-10); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); }
.ab-value h3 { font-size: 1.05rem; }
.ab-value p { margin: 0; font-size: .93rem; color: var(--color-ink-2); }

.ab-history__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 6vw, 5rem); align-items: start; }
.ab-rail { margin: 0; padding: 0 0 0 var(--space-xl); list-style: none; border-left: 2px solid var(--color-line); display: grid; gap: var(--space-xl); }
.ab-rail li { position: relative; display: grid; gap: var(--space-1); }
.ab-rail li::before { content: ""; position: absolute; left: calc(var(--space-xl) * -1 - 7px); top: var(--space-2); width: var(--space-3); height: var(--space-3); border-radius: var(--radius-full); background: var(--color-accent); box-shadow: 0 0 0 var(--space-1) var(--color-paper); }
.ab-rail time, .ab-rail .ab-rail__when { font-family: var(--font-accent); font-size: 1.35rem; letter-spacing: .04em; color: var(--color-accent-dark); line-height: 1; }
.ab-rail b { font-family: var(--font-heading); color: var(--color-ink); }
.ab-rail span.ab-rail__text { color: var(--color-ink-2); font-size: .95rem; max-width: 52ch; }

.ab-creds__grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin-top: var(--space-xl); }
.ab-ask { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-md); padding: var(--space-md) var(--space-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); }
.ab-ask svg { color: var(--color-accent-bright); margin-top: var(--space-1); }
.ab-ask b { display: block; color: var(--color-white); font-family: var(--font-heading); }
.ab-ask span { color: color-mix(in srgb, var(--color-white) 78%, transparent); font-size: .93rem; }
.ab-creds__links { display: flex; flex-wrap: wrap; gap: var(--space-sm) var(--space-lg); margin: var(--space-xl) 0 0; }
.ab-creds__links a { color: var(--color-white); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; }
.ab-creds__links svg { color: var(--color-accent-bright); }

@media (max-width: 1000px) { .ab-values__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .ab-value:nth-child(even) { margin-top: 0; } }
@media (max-width: 900px) { .ab-story__grid, .ab-history__grid { grid-template-columns: 1fr; } .ab-file { position: static; } }
@media (max-width: 640px) { .ab-values__grid, .ab-creds__grid { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO (type-led, no form: the mid-page band carries the lead form) ============ -->
<section class="hero hero--interior sp-hero ab-hero" aria-labelledby="ab-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">About</span></li>
      </ol>
    </nav>
    <div class="hero-copy">
      <span class="eyebrow">About &middot; <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></span>
      <h1 class="hero-title" id="ab-hero-title">About <span class="text-accent">All Connected Electric LLC</span> in Hagerstown, MD</h1>
      <p class="hero-answer"><?php echo esc($siteName); ?> is an electrical contractor owned by <?php echo esc($ownerName); ?> and in business in Hagerstown, MD since <?php echo (int) $yearEstablished; ?>. It works on houses, commercial buildings and industrial sites from an office on Leitersburg Pike.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
        <a class="link-call" href="#estimate"><?php echo icon('send', 18); ?>or send the details</a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('calendar', 16); ?>Since <?php echo (int) $yearEstablished; ?></li>
        <li><?php echo icon('layers', 16); ?>Residential, commercial, industrial</li>
        <li><?php echo icon('map-pin', 16); ?>Leitersburg Pike office</li>
      </ul>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="ab-hero-title">

<!-- ============ 2. COMPANY STORY ============ -->
<section class="section ab-story" aria-labelledby="ab-story-title">
  <div class="container">
    <div class="ab-story__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">The company</span>
        <h2 id="ab-story-title">Who is behind <span class="text-accent">All Connected Electric LLC</span>?</h2>
        <p class="answer-block"><?php echo esc($siteName); ?> is an electrical contractor in Hagerstown, MD, owned by <?php echo esc($ownerName); ?> and in business since <?php echo (int) $yearEstablished; ?>. It handles work for homeowners, commercial owners and industrial sites from an office at <?php echo esc($address['street']); ?>.</p>
        <div class="prose">
          <p><?php echo esc($ownerName); ?> started <?php echo esc($siteName); ?> in <?php echo (int) $yearEstablished; ?> and is still the owner today. Calls to <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>, emails to <a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a> and the request forms on these pages all land at the same Hagerstown office.</p>
          <p>The work splits three ways. Homeowners call about a breaker that keeps tripping, a room with too few outlets or a new EV charger. Commercial customers call about lighting, storefront and office power, and panels that have run out of room. Industrial customers call about circuits for shop and warehouse equipment. <?php echo esc($siteName); ?> takes all three, which is why <?php echo serviceLink('residential-electrical', 'residential'); ?>, <?php echo serviceLink('commercial-electrical', 'commercial'); ?> and <?php echo serviceLink('industrial-electrical', 'industrial'); ?> electrical work each have their own page on this site.</p>
          <p>Hagerstown and the rest of Washington County mix older houses with newer construction, so many jobs start the same way: look at the existing panel and wiring first, then decide what can stay. That is true whether the job is <?php echo serviceLink('panel-upgrades', 'a panel upgrade'); ?>, <?php echo serviceLink('wiring-rewiring', 'rewiring an older house'); ?> or <?php echo serviceLink('ev-charger-installation', 'a Level 2 EV charger'); ?>. The full list of <?php echo count($services); ?> services, from <?php echo serviceLink('ceiling-fan-installation', 'ceiling fans'); ?> to <?php echo serviceLink('generator-installation', 'generator hookups'); ?>, is on the <a href="/services/">services page</a>.</p>
        </div>
      </div>
      <aside class="ab-file reveal-right" aria-label="<?php echo esc($siteName); ?> at a glance">
        <p class="ab-year"><span>Est.</span> <?php echo (int) $yearEstablished; ?></p>
        <p class="ab-file__head">Company file</p>
        <ul class="ab-file__list">
<?php foreach ($aboutFile as $aboutRow): ?>
          <li><?php echo icon($aboutRow['icon'], 18); ?><div><b><?php echo esc($aboutRow['label']); ?></b><span><?php echo esc($aboutRow['value']); ?></span></div></li>
<?php endforeach; ?>
        </ul>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 3. MID-PAGE LEAD BAND (the one form on this page) ============ -->
<?php
$ctaBandTitle = 'Have electrical work that needs a look?';
$ctaBandCopy  = 'Tell ' . $siteName . ' what is going on and where. The request goes to the Hagerstown office, which follows up by phone or email.';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
?>

<!-- ============ 4. VALUES ============ -->
<section class="section ab-values" aria-labelledby="ab-values-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">How the work goes</span>
      <h2 id="ab-values-title">How does All Connected Electric approach a <span class="text-accent">job</span>?</h2>
    </div>
    <p class="answer-block reveal-up">Every job starts with what is already there. The panel, the wiring and the load come first, because a new circuit is only safe if the existing service can carry it, and because most price surprises in electrical work come from something nobody looked at.</p>
    <div class="ab-values__grid">
<?php foreach ($aboutValues as $aboutIdx => $aboutValue): $aboutTint = ($aboutIdx % 3) + 1; $aboutDir = ['reveal-up', 'reveal-down', 'reveal-up', 'reveal-scale'][$aboutIdx]; ?>
      <article class="ab-value card-tint-<?php echo $aboutTint; ?> <?php echo $aboutDir; ?> reveal-delay-<?php echo $aboutTint; ?>">
        <span class="ab-value__icon"><?php echo icon($aboutValue['icon'], 22); ?></span>
        <h3><?php echo esc($aboutValue['title']); ?></h3>
        <p><?php echo esc($aboutValue['text']); ?></p>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 5. HISTORY ============ -->
<section class="section ab-history" aria-labelledby="ab-history-title">
  <div class="container">
    <div class="ab-history__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">History</span>
        <h2 id="ab-history-title">How long has All Connected Electric LLC been working in Hagerstown?</h2>
        <p class="answer-block"><?php echo esc($siteName); ?> has been in business in Hagerstown since <?php echo (int) $yearEstablished; ?>, which is <?php echo (int) $yearsInBusiness; ?> years. Owner <?php echo esc($ownerName); ?> started the company and runs it from the same Leitersburg Pike office that takes calls and requests today.</p>
      </div>
      <ol class="ab-rail reveal-right">
<?php foreach ($aboutTimeline as $aboutStep): ?>
        <li>
<?php if (preg_match('/^\d{4}$/', $aboutStep['when'])): ?>
          <time datetime="<?php echo esc($aboutStep['when']); ?>"><?php echo esc($aboutStep['when']); ?></time>
<?php else: ?>
          <span class="ab-rail__when"><?php echo esc($aboutStep['when']); ?></span>
<?php endif; ?>
          <b><?php echo esc($aboutStep['title']); ?></b>
          <span class="ab-rail__text"><?php echo esc($aboutStep['text']); ?></span>
        </li>
<?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ============ 6. CREDENTIALS: WHAT TO VERIFY (dark band) ============ -->
<section class="section ab-creds texture-grain slant-top" aria-labelledby="ab-creds-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-up">
      <span class="eyebrow">Credentials</span>
      <h2 id="ab-creds-title">How do you check an electrician's license and insurance in Maryland?</h2>
      <p class="answer-block">Maryland requires electrical contractors to be licensed. Look the license up with the Maryland State Board of Master Electricians, part of the Maryland Department of Labor, and ask for proof of general liability and workers' compensation coverage. Ask <?php echo esc($siteName); ?> for its license number and certificate of insurance the same way you would ask any electrician.</p>
    </div>
    <div class="ab-creds__grid">
<?php foreach ($aboutAsk as $aboutAskIdx => $aboutAskItem): ?>
      <div class="ab-ask <?php echo $aboutAskIdx % 2 === 0 ? 'reveal-left' : 'reveal-right'; ?>">
        <?php echo icon($aboutAskItem['icon'], 22); ?>
        <div><b><?php echo esc($aboutAskItem['title']); ?></b><span><?php echo esc($aboutAskItem['text']); ?></span></div>
      </div>
<?php endforeach; ?>
    </div>
    <p class="ab-creds__links reveal-up">
<?php if (!empty($gbpMapsUrl)): ?>
      <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('external-link', 16); ?>See <?php echo esc($siteName); ?> on Google</a>
<?php endif; ?>
      <a href="<?php echo esc($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('route', 16); ?>Get directions to the office</a>
    </p>
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

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></p></div>
</article>

<!-- ============ 8. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Talk to the office</span>
      <h2 id="sp-cta-title">Ready to talk through electrical work in Hagerstown?</h2>
      <p>Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a> and describe the job. <?php echo esc($siteName); ?> will tell you what it would look at first and set a time to see it.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <a class="btn btn-outline-white btn-lg" href="/contact/">Send the details</a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
