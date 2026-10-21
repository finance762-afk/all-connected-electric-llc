<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ceiling-fan-installation/ — Ceiling Fan Installation, All Connected Electric LLC (Phase 4, premium editorial structure).
 * No client photos are on disk (build-plan assets.images is empty): type-led hero, no gallery, no before/after.
 * Every fact traces to build-plan.json / config.php or is general electrical / manufacturer guidance stated as such;
 * prices, timeframes, fan brands and credentials are NOT claimed — see /content-confirmations.json.
 * No FAQ section: the research brief has no ceiling-fan customer question.
 */
$pageSlug        = 'ceiling-fan-installation';
$pageService     = 'Ceiling Fan Installation';
$pageTitle       = 'Ceiling Fan Installation Hagerstown MD | All Connected Electric LLC';
$pageDescription = 'Ceiling fan installation and repair in Hagerstown, MD: fan-rated ceiling boxes, new wiring where no fixture exists, and wall controls. Call (301) 704-6333.';
$canonicalUrl    = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage         = '';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = $pageSlug;
$dialogService   = $pageService;
$heroPreload     = [];

$pageFaqs = [];

$svcRow = null;
foreach ($services as $svcCandidate) if ($svcCandidate['slug'] === $pageSlug) $svcRow = $svcCandidate;
$svcNode = generateServiceSchema($svcRow + ['url' => $canonicalUrl]);
$svcNode['@id'] = $canonicalUrl . '#service-' . $pageSlug;
$svcNode['serviceType'] = 'Ceiling fan installation';
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
    ['slug' => 'lighting-installation',  'icon' => 'lightbulb', 'desc' => 'Light fixtures, recessed lights and outdoor lighting installed.', 'bullets' => ['Recessed lights added', 'Fixtures swapped or repaired', 'Outdoor lights wired']],
    ['slug' => 'outlet-switch-repair',   'icon' => 'plug',      'desc' => 'Switches, dimmers and smart controls that match the load.',       'bullets' => ['Fan-rated wall controls', 'Smart switches checked', 'Worn switches replaced']],
    ['slug' => 'residential-electrical', 'icon' => 'house',     'desc' => 'Repairs, circuits and upgrades anywhere in the house.',           'bullets' => ['Bedroom and attic circuits', 'Whole-home surge protection', 'Safety inspections']],
];
/* Lead forms: p1_lead_hidden_fields('hero') emits _next, _honey, form_location, consent fields,
   p1_attribution_fields('hero') and the spam shield in one call (includes/p1-form-helpers.php). */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Ceiling Fan Installation — page-specific: fan size by room (scaled blade-span bars)
   beside the "is your box fan-rated?" card (signature section). Tokens only.
   ========================================================================== */
.cf-size__grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; margin-top: var(--space-xl); }
.cf-sizes { display: grid; gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.cf-size { display: grid; grid-template-columns: minmax(8rem, .8fr) 2fr; gap: var(--space-md); align-items: center; }
.cf-size__room b { display: block; font-family: var(--font-heading); color: var(--color-ink); }
.cf-size__room span { font-size: var(--fs-small); color: var(--color-muted); }
.cf-size__bar { position: relative; height: var(--space-10); border-radius: var(--radius-full); background: var(--color-paper-2); overflow: hidden; }
.cf-size__bar i {
  position: absolute;
  inset: 0 auto 0 0;
  width: var(--cf-span);
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding-right: var(--space-md);
  border-radius: var(--radius-full);
  background: linear-gradient(90deg, var(--color-primary) 0%, color-mix(in srgb, var(--color-primary) 70%, var(--color-accent)) 100%);
  color: var(--color-accent-bright);
  font-family: var(--font-accent);
  font-style: normal;
  font-size: 1.05rem;
  letter-spacing: .04em;
  white-space: nowrap;
}
.cf-size--1 { --cf-span: 52%; } .cf-size--2 { --cf-span: 64%; } .cf-size--3 { --cf-span: 78%; } .cf-size--4 { --cf-span: 92%; }
.cf-size--5 .cf-size__bar i { width: 100%; background: repeating-linear-gradient(90deg, var(--color-primary) 0 46%, transparent 46% 54%, var(--color-primary) 54% 100%); }
.cf-box {
  position: relative;
  padding: var(--space-xl) var(--space-lg) var(--space-lg);
  border-radius: var(--radius-lg);
  background: var(--color-dark);
  color: color-mix(in srgb, var(--color-white) 84%, transparent);
  box-shadow: var(--shadow-lg);
  clip-path: polygon(0 0, calc(100% - var(--space-xl)) 0, 100% var(--space-xl), 100% 100%, 0 100%);
}
.cf-box__ring { position: absolute; top: var(--space-lg); right: var(--space-lg); width: var(--space-16); height: var(--space-16); border-radius: var(--radius-full); border: var(--space-2) solid color-mix(in srgb, var(--color-accent) 30%, transparent); opacity: .5; }
.cf-box h3 { color: var(--color-white); max-width: 18ch; margin-bottom: var(--space-md); }
.cf-box ul { display: grid; gap: var(--space-sm); margin: 0; padding: 0; list-style: none; }
.cf-box li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-sm); font-size: .92rem; }
.cf-box li svg { color: var(--color-accent-bright); margin-top: 3px; }
.cf-box b { color: var(--color-white); }
.cf-box__stamp {
  display: inline-block;
  margin-top: var(--space-lg);
  padding: var(--space-xs) var(--space-sm);
  border: 2px dashed var(--color-accent);
  border-radius: var(--radius-sm);
  font-family: var(--font-accent);
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--color-accent-bright);
  transform: rotate(-2deg);
}
@media (max-width: 900px) { .cf-size__grid { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .cf-size { grid-template-columns: 1fr; gap: var(--space-xs); } }
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
        <span class="eyebrow">Ceiling fans &middot; Hagerstown, MD</span>
        <h1 class="hero-title" id="sp-hero-title">Ceiling fan installation in <span class="text-accent">Hagerstown, MD</span></h1>
        <p class="hero-answer">All Connected Electric LLC installs and repairs ceiling fans in Hagerstown homes and businesses, including fan-rated ceiling boxes, new wiring where no fixture exists, and wall controls. The box is checked first, because a fan hung from an ordinary light-fixture box can work loose over time.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a fan install estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('wind', 16); ?>New fan installs</li>
          <li><?php echo icon('ruler', 16); ?>Fan-rated boxes</li>
          <li><?php echo icon('wrench', 16); ?>Fan repair</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a ceiling fan installed?</h2>
        <p class="hero-form-tagline">Tell us the room, and whether a light or fan is there now.</p>
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
      <h2 id="sp-signs-title">When does a ceiling fan job need an electrician?</h2>
    </div>
    <p class="answer-block reveal-up">A ceiling fan job needs an electrician when the box above it may not be rated for a fan. The same goes for a room with no ceiling fixture to start from, or a fan and light you want on separate switches. A fan that wobbles, hums or runs on only one speed also deserves a proper look.</p>
    <div class="sp-signs__grid">
      <div class="reveal-left">
        <p class="pull-quote">A fan weighs more than a light fixture, and it moves. The box holding it has to be built for both.</p>
        <p>Hagerstown summers are humid, and a ceiling fan in a bedroom or a sunroom is one of the simplest ways to make the air conditioning feel stronger. In winter, running it slowly in reverse pushes warm air back down from the ceiling.</p>
      </div>
      <ul class="sp-bento reveal-right">
        <li>
          <span class="sp-bento__icon"><?php echo icon('ruler', 20); ?></span>
          <h3>Swapping a light for a fan</h3>
          <p>This is the most common request and the one most often done wrong. A standard light box is held by a couple of screws and is not meant for a heavy, moving load. The box has to be marked for fan support, or a fan-rated box and brace go in between the joists first.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('plus', 20); ?></span>
          <h3>No fixture in the room</h3>
          <p>A new ceiling box needs a power source and a switch, often fished through finished walls.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('wind', 20); ?></span>
          <h3>Wobble, hum or one speed</h3>
          <p>Loose mounting, unbalanced blades or a failed capacitor or control.</p>
        </li>
        <li>
          <span class="sp-bento__icon"><?php echo icon('lightbulb', 20); ?></span>
          <h3>One switch for fan and light</h3>
          <p>Separate wall control usually needs an extra conductor between switch and box.</p>
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
        <b><span><?php echo (int) $yearsInBusiness; ?></span> years</b>
        <span>In business in Hagerstown since <?php echo (int) $yearEstablished; ?>, on homes, commercial buildings and industrial sites.</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Who does the work</span>
        <h2 id="sp-expert-title">Why have All Connected Electric hang your ceiling fan?</h2>
        <p class="answer-block">An electrician hangs a ceiling fan from the structure, not just the wiring. All Connected Electric LLC, a Hagerstown contractor owned by <?php echo esc($ownerName); ?>, checks how the box is fastened, adds a fan-rated box and brace where needed, and wires the controls you want, so the fan stays quiet and tight for years.</p>
        <ul class="sp-points">
          <li><?php echo icon('hammer', 20); ?><div><b>Mounted to framing</b><span>A fan-rated brace spans the joists, so the fan's weight and motion go into the structure, not into a single screw in old plaster.</span></div></li>
          <li><?php echo icon('waypoints', 20); ?><div><b>Wiring for separate controls</b><span>If you want the light dimmable and the fan on its own switch, the cable between the switch and the box may need replacing. That is checked before the fan goes up.</span></div></li>
          <li><?php echo icon('lightbulb', 20); ?><div><b>Light and fan planned together</b><span>Many rooms get a fan and new lighting at the same time. See <?php echo serviceLink('lighting-installation', 'lighting installation'); ?> for the fixture side of the job.</span></div></li>
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
        <h2 id="sp-scope-title">What is included in a ceiling fan installation?</h2>
        <p class="answer-block">A ceiling fan installation includes the ceiling box, the mounting, the wiring to your chosen control, and balancing the blades. The box is checked or replaced first, and the fan is hung at a safe height. Where no fixture exists, it also includes running a new circuit or extending one to a new box and switch.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span><b>Box check</b>: is it marked for fan support and fastened to framing?</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Fan-rated box and brace</b> installed when the existing box is not rated.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Correct height</b>: most manufacturers call for blades at least 7 feet above the floor, with a downrod on high or sloped ceilings.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Controls</b> wired for pull chains, a wall switch, separate fan and light switches, or a remote.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Balance and test</b> at every speed, in both directions.</span></li>
          <li><?php echo icon('check', 18); ?><span><b>Ceiling fan repair</b> for wobble, noise, dead lights or speeds that no longer work.</span></li>
        </ul>
      </div>
      <div class="sp-steps-wrap reveal-right">
        <span class="eyebrow-label">How it goes</span>
        <h3>How does a ceiling fan install go?</h3>
        <ol class="sp-steps">
          <li><b>Room and fan details</b><span>Room size, ceiling height, what is there now, and the fan you picked if you already have one.</span></li>
          <li><b>Check the box and switch</b><span>The box rating, the framing above it and the wiring at the switch are looked at.</span></li>
          <li><b>Mount and wire</b><span>Brace and box go in if needed, then the fan is hung and wired to its control.</span></li>
          <li><b>Balance and walk-through</b><span>Every speed and the light are tested, and you are shown the reverse switch for winter.</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. COMPARISON: CONTROLS ============ -->
<section class="section sp-compare" aria-labelledby="sp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Controls</span>
      <h2 id="sp-compare-title">Which control setup fits your new ceiling fan?</h2>
    </div>
    <p class="answer-block reveal-up">The right fan control depends on the wiring already between the switch and the ceiling. A single wall switch works with the cable most rooms have; separate fan and light switches usually need an extra wire; remotes and some smart controls avoid new wiring altogether. The table compares five common setups side by side.</p>
    <div class="sp-table-wrap reveal-up">
      <table class="sp-table">
        <caption>Ceiling fan control options compared by wiring needed and best use</caption>
        <thead>
          <tr><th scope="col">Control</th><th scope="col">How it works</th><th scope="col">Wiring needed</th><th scope="col">Good for</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Pull chains only</th><td>Power is always on at the fan; chains set speed and light.</td><td>Power to the box, no switch.</td><td>Rooms with no switch loop.</td></tr>
          <tr><th scope="row">Single wall switch</th><td>Switch turns the fan and light on together; chains do the rest.</td><td>The usual two-wire switch cable.</td><td>Straight swaps for a light fixture.</td></tr>
          <tr><th scope="row">Separate fan and light switches</th><td>Two switches, or a fan control plus a dimmer.</td><td>An extra conductor from switch to box.</td><td>Bedrooms and living rooms.</td></tr>
          <tr><th scope="row">Remote and receiver</th><td>A receiver in the canopy takes commands from a handheld or wall remote.</td><td>None beyond power to the box.</td><td>High ceilings, no extra cable.</td></tr>
          <tr><th scope="row">Smart fan control</th><td>App, schedule or voice control.</td><td>Often a neutral wire in the switch box.</td><td>Homes already using smart switches.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="sp-table-note">Older switch boxes in Hagerstown houses often lack a neutral wire. <?php echo serviceLink('outlet-switch-repair', 'How switches and smart controls are matched to your wiring'); ?> explains the switch side.</p>
  </div>
</section>

<!-- ============ 6. SIGNATURE: FAN SIZE BY ROOM + BOX CHECK ============ -->
<section class="section cf-sizing" aria-labelledby="cf-size-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Sizing</span>
      <h2 id="cf-size-title">What size ceiling fan fits your room?</h2>
    </div>
    <p class="answer-block reveal-up">Ceiling fan size follows room area. Roughly: 36 inches or less up to 75 square feet, 36 to 42 inches up to 144, about 44 to 50 inches up to 225, and 50 to 54 inches up to 400 square feet. Bigger rooms usually do better with two fans.</p>
    <div class="cf-size__grid">
      <ol class="cf-sizes reveal-left" aria-label="Fan blade span by room area">
        <li class="cf-size cf-size--1"><div class="cf-size__room"><b>Up to 75 sq ft</b><span>Bath, laundry, walk-in closet</span></div><div class="cf-size__bar"><i>&le; 36&Prime;</i></div></li>
        <li class="cf-size cf-size--2"><div class="cf-size__room"><b>76 to 144 sq ft</b><span>Small bedroom, office</span></div><div class="cf-size__bar"><i>36&ndash;42&Prime;</i></div></li>
        <li class="cf-size cf-size--3"><div class="cf-size__room"><b>145 to 225 sq ft</b><span>Main bedroom, kitchen</span></div><div class="cf-size__bar"><i>44&ndash;50&Prime;</i></div></li>
        <li class="cf-size cf-size--4"><div class="cf-size__room"><b>226 to 400 sq ft</b><span>Living room, sunroom</span></div><div class="cf-size__bar"><i>50&ndash;54&Prime;</i></div></li>
        <li class="cf-size cf-size--5"><div class="cf-size__room"><b>Over 400 sq ft</b><span>Great room, open plan, shop</span></div><div class="cf-size__bar"><i>Two fans</i></div></li>
      </ol>
      <div class="cf-box reveal-right">
        <span class="cf-box__ring" aria-hidden="true"></span>
        <h3>Is the box above your light rated for a fan?</h3>
        <ul>
          <li><?php echo icon('search', 18); ?><span><b>Look inside the box</b> with the power off. A fan-rated box is stamped or labeled for fan support.</span></li>
          <li><?php echo icon('ruler', 18); ?><span><b>Check the weight</b>. Fans over 35 pounds need a box marked for the higher weight.</span></li>
          <li><?php echo icon('hammer', 18); ?><span><b>Check the fastening</b>. It should be screwed to a joist or a brace, not hanging from plaster or a thin metal bar.</span></li>
          <li><?php echo icon('info', 18); ?><span><b>Not sure?</b> A photo of the open box is enough to tell.</span></li>
        </ul>
        <span class="cf-box__stamp">Acceptable for fan support</span>
      </div>
    </div>
    <p class="sp-table-note">Sizes are common manufacturer guidance, not a code rule; ceiling height and room shape matter too. Need the room itself rewired? <?php echo serviceLink('residential-electrical', 'Home electrical work in Hagerstown'); ?> covers new circuits and repairs.</p>
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

<!-- ============ 9. RELATED SERVICES (required services-grid component) ============ -->
<section class="section sp-related" aria-labelledby="sp-related-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="sp-related-title">What pairs well with a new <span class="text-accent">ceiling fan</span>?</h2>
      <p class="hero-answer">A new ceiling fan often leads to the next fix in the same room. People adding a fan tend to want better lighting, a wall control that dims the light without slowing the fan, or a room circuit that is not shared with half the house. All Connected Electric LLC can plan those alongside the fan install.</p>
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
    <p class="sp-related__hub">Ceiling fans are one of eleven services. <a href="/services/">See every electrical service All Connected Electric offers in Hagerstown</a>.</p>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Fan install estimate</span>
      <h2 id="sp-cta-title">Want a ceiling fan up before the next hot spell?</h2>
      <p>Send the room size, the ceiling height and what is in the ceiling now, or call <?php echo esc(formatPhone($phone)); ?>. All Connected Electric LLC will follow up to set a time. A photo of the existing box or fixture helps.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get a fan estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
