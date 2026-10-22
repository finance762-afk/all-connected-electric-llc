<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/panel-upgrade-cost-hagerstown/ — cost-factors guide (Phase 6 launch post 1 of 2).
 * NO dollar figures: the client has not supplied pricing (see /content-confirmations.json) and blog-standard.md section 7
 * bans guessed numbers. The post explains what moves the price and how to get a real quote.
 * Local specifics: City of Hagerstown vs Washington County permit offices, Potomac Edison service disconnect.
 * Author = Page One Insights LLC (organization), publisher = client #organization.
 */
$postSlug        = 'panel-upgrade-cost-hagerstown';
$post            = blogPostBySlug($postSlug);
$pageTitle       = $post['title'];
$pageDescription = 'Panel upgrade cost in Hagerstown, MD depends on the service size, meter base, code work and permit. See what moves the price and how to get a firm quote.';
$canonicalUrl    = $siteUrl . blogPostUrl($post);
$ogImage         = $post['image'];
$currentPage     = 'blog';
$pageType        = 'blog';
$heroPreload     = [];
$dialogService   = 'Panel Upgrades';

$pageFaqs = [
    ['q' => 'Why will an electrician not quote a panel upgrade over the phone?',
     'a' => 'The panel, main breaker, meter base and service cable all affect the price, and none of them can be judged from a description. A quote given before someone has seen them is a guess. Sending a photo of the open panel door helps, but a written estimate normally follows a look at the equipment.'],
    ['q' => 'Does a panel upgrade in Hagerstown always need a permit?',
     'a' => 'A panel replacement or service upgrade almost always needs an electrical permit and an inspection in Maryland. The City of Hagerstown and Washington County run separate permit offices, so the address decides which one applies. Ask the electrician which office handles your property and what it adds to the job.'],
];
$postToc = [
    'cost-factors'   => 'What makes one panel upgrade cost more than another?',
    'swap-vs-service' => 'Is a panel replacement the same as a service upgrade?',
    'permit'         => 'What does the permit add in Hagerstown?',
    'real-quote'     => 'How do you get a price you can rely on?',
    'faq'            => 'Questions about panel upgrade pricing',
];

$bpRoot = rtrim($siteUrl, '/');
$bpPost = ['@type' => 'BlogPosting', '@id' => $canonicalUrl . '#post', 'headline' => $post['title'], 'description' => $pageDescription,
    'datePublished' => $post['dateISO'], 'dateModified' => $post['dateISO'], 'keywords' => implode(', ', $post['keywords']),
    'articleSection' => $post['category'], 'inLanguage' => 'en-US', 'mainEntityOfPage' => $canonicalUrl,
    'author' => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
    'publisher' => ['@id' => $bpRoot . '/#organization'], 'about' => ['@id' => $bpRoot . '/services/panel-upgrades/#service-panel-upgrades']];
if ($post['image'] !== '' && is_file(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $post['image'])) $bpPost['image'] = absoluteUrl($post['image']);
$schemaMarkup = [
    $bpPost,
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Blog', 'url' => $siteUrl . '/blog/'],
        ['name' => $post['title'], 'url' => $canonicalUrl],
    ]),
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog.css'; ?></style>

<!-- ============ 1. HERO (no hero form on posts; one cta-band follows the first content section) ============ -->
<section class="hero hero--interior sp-hero bp-hero" aria-labelledby="bp-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/blog/">Blog</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Panel upgrade cost</span></li>
      </ol>
    </nav>
    <header class="blog-post__header">
      <span class="eyebrow"><?php echo esc($post['category']); ?></span>
      <h1 class="hero-title" id="bp-title"><?php echo esc($post['title']); ?></h1>
      <p class="blog-post__meta"><span><?php echo icon('calendar', 16); ?><time datetime="<?php echo esc($post['dateISO']); ?>"><?php echo esc($post['date']); ?></time></span><span><?php echo icon('clock', 16); ?><?php echo esc($post['readtime']); ?></span></p>
    </header>
  </div>
</section>

<article class="blog-post" aria-labelledby="bp-title">

<!-- ============ 2. FIRST CONTENT SECTION ============ -->
<section class="section bp-body">
  <div class="container">
    <div class="bp-wrap">
      <div class="blog-post__content">
        <p class="answer-block">The cost of a panel upgrade in Hagerstown depends on four things: whether the job is a panel swap or a larger service, the condition of the meter base and service cable, any code work the old installation needs, and the permit. A written estimate after someone has looked at the panel is the only number worth planning around.</p>
        <p>No honest price list exists for this job, and this article does not invent one. <?php echo esc($siteName); ?> has not published prices, so what follows explains what moves the number, which is what you need in order to compare quotes.</p>

        <h2 id="cost-factors">What makes one panel upgrade cost more than another?</h2>
        <p>Four things set the price, and they are the same four in a 1920s Oak Hill house and a 1990s ranch house:</p>
        <ul class="bp-list">
          <li><strong>Panel swap or service upgrade.</strong> Replacing a panel at the same size is a smaller job than raising the service from, say, 100 to 200 amps, which also touches the meter base and the cable from the utility.</li>
          <li><strong>What the old equipment needs.</strong> A corroded panel, a brand with a poor safety record such as Federal Pacific or Zinsco, or crowded wiring inside the old panel adds time before the new one can go in.</li>
          <li><strong>Code work the upgrade triggers.</strong> Grounding and bonding, arc-fault or ground-fault protection and surge protection are checked against current code when the panel is replaced, and anything missing is added.</li>
          <li><strong>Access and layout.</strong> A panel in a finished basement, a tight closet or on an exterior masonry wall takes longer to work on than one in an open utility room.</li>
        </ul>
      </div>

      <aside class="bp-aside" aria-label="Article tools">
        <nav class="bp-toc" aria-label="In this article">
          <h2>In this article</h2>
          <ol>
<?php foreach ($postToc as $tocId => $tocLabel): ?>
            <li><a href="#<?php echo esc($tocId); ?>"><?php echo esc($tocLabel); ?></a></li>
<?php endforeach; ?>
          </ol>
        </nav>
        <div class="bp-side-cta">
          <h2>Want a panel looked at?</h2>
          <p>Call the Leitersburg Pike office, or send the main breaker size and what you plan to add.</p>
          <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
          <button type="button" class="btn btn-outline-white" data-open-estimate>Get a panel estimate</button>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 3. MID-PAGE LEAD FORM (the one cta-band) ============ -->
<?php
$ctaBandTitle   = 'Have a panel that needs a look?';
$ctaBandCopy    = 'Tell ' . $siteName . ' what the panel is doing and where the house is. The request goes to the Hagerstown office, which follows up by phone or email.';
$ctaBandService = 'Panel Upgrades';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
?>

<!-- ============ 4. REMAINDER ============ -->
<section class="section bp-body">
  <div class="container">
    <div class="bp-wrap">
      <div class="blog-post__content">
        <h2 id="swap-vs-service">Is a panel replacement the same as a service upgrade?</h2>
        <p>No, and the difference is most of the price gap. A panel replacement swaps the box and breakers at the size you already have. A service upgrade raises the size of the supply into the building. <?php echo serviceLink('panel-upgrades', 'The panel upgrade page'); ?> sets the two side by side.</p>
        <div class="bp-compare">
          <div>
            <h3>Panel replacement</h3>
            <p>Same service size. New panel and breakers, every circuit relabeled. Right when the panel is full, damaged or an unsafe brand but the building is not short of power.</p>
          </div>
          <div>
            <h3>Service upgrade</h3>
            <p>Larger service. New panel, usually a new meter base and service cable, and the utility has to disconnect and reconnect. Right when a load calculation shows the building needs more than it gets.</p>
          </div>
        </div>
        <p>The load calculation is what decides which one you need. Planning an EV charger, a heat pump or a finished basement is the usual reason it comes back short, and <?php echo serviceLink('ev-charger-installation', 'sizing an EV charger circuit'); ?> starts with the same math.</p>

        <h2 id="permit">What does the permit add in Hagerstown?</h2>
        <p>A panel replacement or service upgrade almost always needs an electrical permit and an inspection. Which office handles it depends on the address: the City of Hagerstown permit office at City Hall for properties inside city limits, or Washington County Permits and Inspections for unincorporated addresses. The <a href="<?php echo esc(areaUrl('hagerstown') ?: '/service-areas/'); ?>">Hagerstown service area page</a> lists both offices.</p>
        <p>The permit fee is set by whichever office issues it, so it is a line to ask about rather than a number to assume. A service upgrade also involves Potomac Edison, the utility that delivers electricity in Washington County, because the service is disconnected and reconnected as part of the job. Ask how that sequence will work for your address before a date is set.</p>

        <h2 id="real-quote">How do you get a price you can rely on?</h2>
        <p>Get the quote after the equipment has been seen, and ask for it in writing. Three steps make it faster:</p>
        <ol class="bp-list">
          <li><strong>Photograph the open panel door.</strong> Include the main breaker number, the brand label and the circuit list. It lets the electrician arrive prepared.</li>
          <li><strong>Say what you plan to add.</strong> An EV charger, a generator transfer switch or an addition changes the size of panel worth installing. If backup power is on your list, <a href="/blog/portable-generator-transfer-switch-hagerstown/">this guide to portable generators and transfer switches</a> explains how that circuit fits.</li>
          <li><strong>Ask about a service-call or diagnostic fee.</strong> Ask whether one applies and whether it is credited toward the work, so two quotes can be compared on the same basis.</li>
        </ol>
        <p>Then compare scope, not just the total: which parts are replaced, whether the permit and inspection are included, and who deals with the utility.</p>

        <section class="bp-faq" aria-labelledby="faq">
          <h2 id="faq">Questions about panel upgrade pricing</h2>
<?php foreach ($pageFaqs as $faqIdx => $faqItem): ?>
          <details class="faq"<?php echo $faqIdx === 0 ? ' open' : ''; ?>>
            <summary><?php echo esc($faqItem['q']); ?></summary>
            <p class="faq-answer"><?php echo linkContacts(esc($faqItem['a'])); ?></p>
          </details>
<?php endforeach; ?>
        </section>

        <p class="bp-byline">Published by Page One Insights LLC for <?php echo esc($siteName); ?> &middot; <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> &middot; Last updated <?php echo esc($post['date']); ?>. General information, not an estimate for any particular property.</p>
      </div>
      <aside class="bp-aside" aria-label="Contact">
        <div class="bp-side-cta">
          <h2>Talk to the Hagerstown office</h2>
          <p><?php echo esc($siteName); ?> will look at the panel before giving a price.</p>
          <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
          <button type="button" class="btn btn-outline-white" data-open-estimate>Get a panel estimate</button>
        </div>
      </aside>
    </div>
  </div>
</section>
</article>

<?php
$relatedSlug     = $postSlug;
$relatedServices = ['panel-upgrades' => 'Panel Upgrades', 'ev-charger-installation' => 'EV Charger Installation', 'generator-installation' => 'Generator Installation'];
include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-related.php';
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
