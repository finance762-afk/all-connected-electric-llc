<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * thank-you.php — the leads endpoint redirects here ($siteUrl/thank-you, the `_next` value p1_lead_hidden_fields() emits).
 * Noindexed. No form on this page, so the estimate dialog is switched off.
 * Callback time is NOT promised: intake has no answer yet (see /content-confirmations.json), so "what to expect" says
 * the office follows up by phone or email and nothing about how fast.
 */
$pageTitle       = 'Thank You | ' . $siteName;
$pageDescription = 'Your request reached ' . $siteName . ' in Hagerstown, MD. Here is what happens next, and how to reach the office sooner.';
$canonicalUrl    = $siteUrl . '/thank-you';
$ogImage         = '';
$currentPage     = 'thank-you';
$pageType        = 'other';
$noindex         = true;
$noEstimateDialog = true;
$heroPreload     = [];
$schemaMarkup    = [];

$thanksServices = [];
foreach ([
    ['panel-upgrades',          'zap'],
    ['ev-charger-installation', 'battery-charging'],
    ['lighting-installation',   'lightbulb'],
    ['wiring-rewiring',         'waypoints'],
    ['generator-installation',  'power'],
    ['outlet-switch-repair',    'plug'],
] as $thanksRow) {
    $thanksUrl = serviceUrl($thanksRow[0]);
    if ($thanksUrl === '') continue;
    foreach ($services as $thanksSvc) {
        if ($thanksSvc['slug'] === $thanksRow[0]) $thanksServices[] = ['name' => $thanksSvc['name'], 'url' => $thanksUrl, 'icon' => $thanksRow[1], 'desc' => $thanksSvc['description']];
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   Thank-you — page-specific: confirmation tick, "what happens next" rail, safety note, service links. Tokens only.
   ========================================================================== */
.ty-hero { position: relative; overflow: clip; }
.ty-hero::before { content: ""; position: absolute; inset: -30% -10% auto 45%; height: 160%; z-index: -1; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 72%); pointer-events: none; }
.ty-hero .grain { z-index: -1; opacity: .28; }
.ty-hero .hero-title { letter-spacing: -.03em; }
.ty-hero .text-accent { color: var(--color-accent-bright); }
.ty-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ty-hero .link-call svg { color: var(--color-accent-bright); }
.ty-tick { display: grid; place-items: center; width: var(--space-16); height: var(--space-16); margin-bottom: var(--space-md); border-radius: var(--radius-full); background: var(--color-accent); color: var(--color-ink); box-shadow: 0 0 0 var(--space-2) color-mix(in srgb, var(--color-accent) 25%, transparent); }
.ty-next__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.ty-steps { display: grid; gap: 0; margin: var(--space-md) 0 0; padding: 0; list-style: none; counter-reset: ty; }
.ty-steps li { counter-increment: ty; position: relative; display: grid; gap: var(--space-1); padding: 0 0 var(--space-lg) var(--space-3xl); }
.ty-steps li::before { content: counter(ty, decimal-leading-zero); position: absolute; left: 0; top: 0; display: grid; place-items: center; width: var(--space-10); height: var(--space-10); border-radius: var(--radius-full); background: var(--color-primary); color: var(--color-accent); font-family: var(--font-accent); font-size: 1.05rem; }
.ty-steps li::after { content: ""; position: absolute; left: calc(var(--space-10) / 2 - 1px); top: var(--space-10); bottom: 0; width: 2px; background: var(--color-line); }
.ty-steps li:last-child::after { display: none; }
.ty-steps b { font-family: var(--font-heading); color: var(--color-ink); }
.ty-steps span { font-size: .95rem; color: var(--color-ink-2); }
.ty-safety { padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); border-left: var(--space-1) solid var(--color-danger); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.ty-safety h3 { display: flex; align-items: center; gap: var(--space-xs); font-size: 1.05rem; margin-bottom: var(--space-xs); }
.ty-safety h3 svg { color: var(--color-danger); }
.ty-safety p { margin: 0 0 var(--space-xs); color: var(--color-ink-2); font-size: .95rem; }
.ty-safety p:last-child { margin-bottom: 0; }
.ty-safety a { color: var(--color-ink); font-weight: 600; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.ty-more__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ty-more__grid a { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-sm); height: 100%; padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); text-decoration: none; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ty-more__grid li:nth-child(3n+1) a { background: var(--color-card-tint-1); }
.ty-more__grid li:nth-child(3n+2) a { background: var(--color-card-tint-2); }
.ty-more__grid li:nth-child(3n) a { background: var(--color-card-tint-3); }
.ty-more__grid a:hover { transform: translateY(calc(var(--space-1) * -1)); box-shadow: var(--shadow); }
.ty-more__icon { display: grid; place-items: center; width: var(--space-10); height: var(--space-10); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); }
.ty-more__grid b { align-self: center; font-family: var(--font-heading); color: var(--color-ink); }
.ty-more__grid span.ty-more__text { grid-column: 1 / -1; font-size: .9rem; color: var(--color-ink-2); }
.ty-more__links { display: flex; flex-wrap: wrap; gap: var(--space-sm) var(--space-lg); margin: var(--space-xl) 0 0; }
.ty-more__links a { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; color: var(--color-ink); font-weight: 600; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
@media (max-width: 900px) { .ty-next__grid { grid-template-columns: 1fr; } .ty-more__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .ty-more__grid { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. CONFIRMATION ============ -->
<section class="hero hero--interior sp-hero ty-hero" aria-labelledby="ty-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <span class="ty-tick" aria-hidden="true"><?php echo icon('check', 32); ?></span>
      <span class="eyebrow">Request received</span>
      <h1 class="hero-title" id="ty-title">Thank you. Your request is <span class="text-accent">in</span>.</h1>
      <p class="hero-answer"><?php echo esc($siteName); ?> received your request in Hagerstown, MD. The office will follow up by phone or email about the job. If you would rather talk now, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
        <a class="link-call" href="/"><?php echo icon('house', 18); ?>or go back to the homepage</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ 2. WHAT TO EXPECT ============ -->
<section class="section ty-next" aria-labelledby="ty-next-title">
  <div class="container">
    <div class="ty-next__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">What to expect</span>
        <h2 id="ty-next-title">What happens after you send a request to All Connected Electric?</h2>
        <p class="answer-block">Your request goes straight to the <?php echo esc($siteName); ?> office, not to a lead marketplace. The office follows up by phone or email to ask about the job and where it is, and for most jobs the electrician then needs to see the panel and wiring before giving a price.</p>
        <ol class="ty-steps">
          <li><b>Your request reaches the office</b><span>The details you typed, along with the phone number and email you gave, are delivered to <a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a>.</span></li>
          <li><b>The office follows up</b><span>Expect a call or an email to ask about the job, where it is, and when it needs to happen. Keep your phone nearby.</span></li>
          <li><b>The job gets looked at</b><span>The panel, wiring and what is connected to them are checked before a price is given, so the number matches the work.</span></li>
        </ol>
      </div>
      <div class="reveal-right">
        <aside class="ty-safety" aria-labelledby="ty-safety-title">
          <h3 id="ty-safety-title"><?php echo icon('flame', 20); ?>If this is an emergency</h3>
          <p>If you see smoke or flames, smell burning plastic, or the panel is hot to the touch, leave the building and call 911 first.</p>
          <p>For a dead outlet, a breaker that will not stay on or a loss of power, do not wait for the form follow-up: call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a> and say it is urgent.</p>
        </aside>
        <p class="footnote">Need to add something to your request? Reply to the follow-up email, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>, or email <a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a>.</p>
      </div>
    </div>
  </div>
</section>

<?php if ($thanksServices): ?>
<!-- ============ 3. WHILE YOU WAIT: SERVICES ============ -->
<section class="section ty-more section--light" aria-labelledby="ty-more-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">While you wait</span>
      <h2 id="ty-more-title">What other electrical work does All Connected Electric LLC do?</h2>
      <p>Read about the work behind your request, or about the jobs that often go with it.</p>
    </div>
    <ul class="ty-more__grid">
<?php foreach ($thanksServices as $thanksIdx => $thanksCard): $thanksDelay = ($thanksIdx % 3) + 1; ?>
      <li class="reveal-up reveal-delay-<?php echo $thanksDelay; ?>">
        <a href="<?php echo esc($thanksCard['url']); ?>">
          <span class="ty-more__icon"><?php echo icon($thanksCard['icon'], 22); ?></span>
          <b><?php echo esc($thanksCard['name']); ?></b>
          <span class="ty-more__text"><?php echo esc($thanksCard['desc']); ?></span>
        </a>
      </li>
<?php endforeach; ?>
    </ul>
    <p class="ty-more__links reveal-up">
<?php if (siteHas('/services/')): ?>
      <a href="/services/">See all <?php echo count($services); ?> services <?php echo icon('arrow-right', 16); ?></a>
<?php endif; ?>
<?php if (siteHas('/faq/')): ?>
      <a href="/faq/">Read the electrician FAQ <?php echo icon('arrow-right', 16); ?></a>
<?php endif; ?>
      <a href="/">Back to the homepage <?php echo icon('arrow-right', 16); ?></a>
    </p>
  </div>
</section>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
