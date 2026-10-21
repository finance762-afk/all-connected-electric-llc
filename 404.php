<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * 404.php — served by .htaccess "ErrorDocument 404 /404.php". A root-level file by design (the only page besides the
 * homepage and thank-you that is not a directory/index.php). Sends a real 404 status and is noindexed.
 * Links render only for pages that exist on disk (siteHas / serviceUrl), so this page can never point at another 404.
 */
http_response_code(404);
$pageTitle       = 'Page Not Found | ' . $siteName;
$pageDescription = 'That page could not be found. Find an electrical service from ' . $siteName . ' in Hagerstown, MD, or call ' . $phone . '.';
$canonicalUrl    = $siteUrl . '/404';
$ogImage         = '';
$currentPage     = '404';
$pageType        = 'other';
$noindex         = true;
$heroPreload     = [];

$notFoundPages = [];
foreach ([
    ['/services/',                          'All electrical services',  'layers',          'Residential, commercial and industrial work, all in one list.'],
    ['/services/panel-upgrades/',           'Panel upgrades',           'zap',             'Panel replacement, service upgrades and breaker repair.'],
    ['/services/ev-charger-installation/',  'EV charger installation',  'battery-charging','Level 2 chargers on a dedicated circuit.'],
    ['/services/emergency-electrician/',    'Emergency electrician',    'flame',           'Power loss, tripping breakers and burning smells.'],
    ['/about/',                             'About the company',        'users',           'Who owns and runs ' . $siteName . '.'],
    ['/faq/',                               'Electrician FAQ',          'info',            'Permits, pricing and how a job runs.'],
    ['/contact/',                           'Contact the office',       'mail',            'Call, email or send a request.'],
] as $notFoundRow) {
    if (siteHas($notFoundRow[0])) $notFoundPages[] = $notFoundRow;
}

// "Search suggestion": what people usually came looking for, matched to the page that answers it.
$notFoundIdeas = [];
foreach ([
    ['A breaker that keeps tripping',          '/services/panel-upgrades/'],
    ['A dead or warm outlet',                  '/services/outlet-switch-repair/'],
    ['Charging an electric car at home',       '/services/ev-charger-installation/'],
    ['Power back-up during an outage',         '/services/generator-installation/'],
    ['New or replacement light fixtures',      '/services/lighting-installation/'],
    ['Old wiring in an older house',           '/services/wiring-rewiring/'],
] as $notFoundIdea) {
    if (siteHas($notFoundIdea[1])) $notFoundIdeas[] = $notFoundIdea;
}

$schemaMarkup = [];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   404 — page-specific: oversized condensed numeral, "find it fast" link grid, search suggestions. Tokens only.
   ========================================================================== */
.nf-hero { position: relative; overflow: clip; }
.nf-hero::before { content: ""; position: absolute; inset: -30% -10% auto 50%; height: 160%; z-index: -1; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 72%); pointer-events: none; }
.nf-hero .grain { z-index: -1; opacity: .28; }
.nf-hero__grid { display: grid; grid-template-columns: auto minmax(0, 1fr); gap: clamp(1.5rem, 5vw, 4rem); align-items: center; }
.nf-code { margin: 0; font-family: var(--font-accent); font-size: clamp(5rem, 3rem + 10vw, 11rem); line-height: .85; letter-spacing: .01em; color: var(--color-accent-bright); }
.nf-hero .hero-title { letter-spacing: -.03em; }
.nf-hero .text-accent { color: var(--color-accent-bright); }
.nf-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 62%, transparent); }
.nf-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.nf-hero .link-call svg { color: var(--color-accent-bright); }
.nf-find__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.nf-find__grid a { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-sm); min-height: 100%; padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); text-decoration: none; transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition); }
.nf-find__grid li:nth-child(3n+1) a { background: var(--color-card-tint-1); }
.nf-find__grid li:nth-child(3n+2) a { background: var(--color-card-tint-2); }
.nf-find__grid li:nth-child(3n) a { background: var(--color-card-tint-3); }
.nf-find__grid a:hover { transform: translateY(calc(var(--space-1) * -1)); box-shadow: var(--shadow); border-color: color-mix(in srgb, var(--color-ink) 30%, var(--color-line)); }
.nf-find__icon { display: grid; place-items: center; width: var(--space-10); height: var(--space-10); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); }
.nf-find__grid b { font-family: var(--font-heading); color: var(--color-ink); align-self: center; }
.nf-find__grid span.nf-find__text { grid-column: 1 / -1; color: var(--color-ink-2); font-size: .93rem; }
.nf-ideas__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.nf-ideas h2 { margin-bottom: var(--space-sm); }
.nf-ideas__list { display: grid; margin: 0; padding: 0; list-style: none; border-top: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.nf-ideas__list a { display: flex; justify-content: space-between; align-items: center; gap: var(--space-md); min-height: 52px; padding: var(--space-xs) 0; border-bottom: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); color: var(--color-white); text-decoration: none; font-weight: 600; }
.nf-ideas__list a svg { color: var(--color-accent-bright); transition: transform var(--transition); }
.nf-ideas__list a:hover svg { transform: translateX(var(--space-1)); }
@media (max-width: 900px) { .nf-hero__grid, .nf-ideas__grid { grid-template-columns: 1fr; } .nf-find__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .nf-find__grid { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO ============ -->
<section class="hero hero--interior sp-hero nf-hero" aria-labelledby="nf-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="nf-hero__grid">
      <p class="nf-code" aria-hidden="true">404</p>
      <div class="hero-copy">
        <span class="eyebrow">Page not found</span>
        <h1 class="hero-title" id="nf-title">That page has <span class="text-accent">tripped</span> a breaker</h1>
        <p class="hero-answer">The page you tried to open is not on this site, or it has moved. Pick one of the pages below, or call <?php echo esc($siteName); ?> at <?php echo esc(formatPhone($phone)); ?> and ask for what you need.</p>
        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="/"><?php echo icon('house', 18); ?>Back to the homepage</a>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 2. POPULAR PAGES ============ -->
<section class="section nf-find" aria-labelledby="nf-find-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Popular pages</span>
      <h2 id="nf-find-title">Where would you like to go instead?</h2>
      <p>These pages cover most of what visitors to <?php echo esc($siteName); ?> are looking for.</p>
    </div>
    <ul class="nf-find__grid">
<?php foreach ($notFoundPages as $nfIdx => $nfPage): $nfDelay = ($nfIdx % 3) + 1; ?>
      <li class="reveal-up reveal-delay-<?php echo $nfDelay; ?>">
        <a href="<?php echo esc($nfPage[0]); ?>">
          <span class="nf-find__icon"><?php echo icon($nfPage[2], 22); ?></span>
          <b><?php echo esc($nfPage[1]); ?></b>
          <span class="nf-find__text"><?php echo esc($nfPage[3]); ?></span>
        </a>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<?php if ($notFoundIdeas): ?>
<!-- ============ 3. SEARCH SUGGESTIONS ============ -->
<section class="section nf-ideas texture-grain slant-top" aria-labelledby="nf-ideas-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="nf-ideas__grid">
      <div class="reveal-left">
        <span class="eyebrow">Looking for something specific?</span>
        <h2 id="nf-ideas-title">What were you trying to fix or add?</h2>
        <p>If you followed an old link or typed the address by hand, the page you wanted may be one of these. Check the spelling of the address if you typed it.</p>
      </div>
      <ul class="nf-ideas__list reveal-right">
<?php foreach ($notFoundIdeas as $nfIdea): ?>
        <li><a href="<?php echo esc($nfIdea[1]); ?>"><span><?php echo esc($nfIdea[0]); ?></span><?php echo icon('arrow-right', 18); ?></a></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 4. CTA ============ -->
<section class="section cta-banner edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <div class="container">
    <div class="reveal-up">
      <span class="eyebrow-label">Still stuck?</span>
      <h2 id="sp-cta-title">Tell the office what you were looking for</h2>
      <p>Call <?php echo esc(formatPhone($phone)); ?> or send a request, and <?php echo esc($siteName); ?> will point you to the right answer or set a time to look at your electrical work in <?php echo esc($address['city']); ?>.</p>
    </div>
    <div class="actions reveal-up">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
<?php if (siteHas('/contact/')): ?>
      <a class="btn btn-secondary btn-lg" href="/contact/">Send a request</a>
<?php endif; ?>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
