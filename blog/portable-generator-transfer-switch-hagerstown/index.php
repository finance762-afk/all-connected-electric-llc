<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/portable-generator-transfer-switch-hagerstown/ — storm/seasonal post (Phase 6 launch post 2 of 2).
 * Local specifics (source: https://en.wikipedia.org/wiki/Hagerstown,_Maryland): January mean daily minimum 25.3 F, record low
 * -27 F on Jan 13 1912. Potomac Edison serves Washington County (https://opc.maryland.gov/Consumer-Learning/Electricity).
 * Permit offices as on /service-areas/hagerstown/. No prices, brands or wattage claims about the client's own work.
 * Author = Page One Insights LLC (organization), publisher = client #organization.
 */
$postSlug        = 'portable-generator-transfer-switch-hagerstown';
$post            = blogPostBySlug($postSlug);
$pageTitle       = 'Portable Generator Transfer Switch Rules for Hagerstown, MD';
$pageDescription = 'A portable generator that powers anything wired into the house needs a transfer switch or listed interlock. Plan yours before a Hagerstown, MD winter outage.';
$canonicalUrl    = $siteUrl . blogPostUrl($post);
$ogImage         = $post['image'];
$currentPage     = 'blog';
$pageType        = 'blog';
$heroPreload     = [];
$dialogService   = 'Generator Installation';

$pageFaqs = [
    ['q' => 'Can I plug a generator into a dryer outlet to power the house?',
     'a' => 'No. A cord with a plug on both ends sends generator power backward through the house wiring and out onto the utility lines, which can seriously injure or kill a lineworker repairing the outage, and it bypasses the breaker protection. The safe ways to power house circuits are a transfer switch or a listed interlock installed on the panel.'],
    ['q' => 'How big a generator does a Hagerstown house need?',
     'a' => 'Add up the running watts of everything you want on during an outage, then allow for the higher starting surge of motors such as the furnace blower, sump pump and refrigerator. An electrician can do that count with you and match the transfer switch to the circuits you choose, so the generator is neither undersized nor oversized.'],
];
$postToc = [
    'what-it-does'   => 'What does a transfer switch actually do?',
    'portable-standby' => 'Portable or standby generator for a Hagerstown home?',
    'winter-plan'    => 'What should you plan before the next winter outage?',
    'panel-room'     => 'Does the panel have room for a transfer switch?',
    'faq'            => 'Questions about generator hookups',
];

$bpRoot = rtrim($siteUrl, '/');
$bpPost = ['@type' => 'BlogPosting', '@id' => $canonicalUrl . '#post', 'headline' => $post['title'], 'description' => $pageDescription,
    'datePublished' => $post['dateISO'], 'dateModified' => $post['dateISO'], 'keywords' => implode(', ', $post['keywords']),
    'articleSection' => $post['category'], 'inLanguage' => 'en-US', 'mainEntityOfPage' => $canonicalUrl,
    'author' => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
    'publisher' => ['@id' => $bpRoot . '/#organization'], 'about' => ['@id' => $bpRoot . '/services/generator-installation/#service-generator-installation']];
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
        <li><span aria-current="page">Generator transfer switch</span></li>
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
        <p class="answer-block">Yes, if the generator will power anything wired into the house. A transfer switch or a listed interlock on the panel keeps generator power from flowing back onto the utility lines, which can injure a lineworker, and stops the generator and the utility from feeding the house at the same time. Appliances plugged straight into the generator with their own cords do not need one.</p>

        <h2 id="what-it-does">What does a transfer switch actually do?</h2>
        <p>A transfer switch is a switch between the utility and the house circuits you choose to run on the generator. It lets one source feed those circuits at a time, never both. That is the whole job, and it matters for two reasons:</p>
        <ul class="bp-list">
          <li><strong>It protects utility crews.</strong> Without the switch, generator power can travel backward through the meter and energize lines that a lineworker believes are dead.</li>
          <li><strong>It protects the generator and the house.</strong> If utility power returns while the generator is still connected to the wiring, both sources meet, and equipment can be damaged.</li>
          <li><strong>It puts chosen circuits on a real breaker.</strong> The furnace blower, sump pump and refrigerator run from the panel, not from a tangle of extension cords.</li>
        </ul>
        <p>A transfer switch is wired in at the panel, so it is electrical work that normally needs a permit and an inspection. <?php echo serviceLink('generator-installation', 'The generator installation page'); ?> explains how the circuits are chosen and what the hookup includes.</p>
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
          <h2>Planning backup power?</h2>
          <p>Call the Leitersburg Pike office, or send what you want to keep running during an outage.</p>
          <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
          <button type="button" class="btn btn-outline-white" data-open-estimate>Get a generator estimate</button>
        </div>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 3. MID-PAGE LEAD FORM (the one cta-band) ============ -->
<?php
$ctaBandTitle   = 'Want a generator hookup planned?';
$ctaBandCopy    = 'Tell ' . $siteName . ' what you want to keep running in an outage and where the house is. The request goes to the Hagerstown office, which follows up by phone or email.';
$ctaBandService = 'Generator Installation';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
?>

<!-- ============ 4. REMAINDER ============ -->
<section class="section bp-body">
  <div class="container">
    <div class="bp-wrap">
      <div class="blog-post__content">
        <h2 id="portable-standby">Portable or standby generator for a Hagerstown home?</h2>
        <p>Both need the same safety step; they differ in how much of the house they carry and how they start.</p>
        <div class="bp-compare">
          <div>
            <h3>Portable generator</h3>
            <p>Moved out and started by hand, run outdoors, and connected through an inlet and a transfer switch or interlock. Carries the circuits you chose, within the generator's output.</p>
          </div>
          <div>
            <h3>Standby generator</h3>
            <p>Permanently installed outside, on a fuel supply, with an automatic transfer switch that starts it when the utility drops. Carries more of the house with no one standing in the cold.</p>
          </div>
        </div>
        <p>A portable unit costs less to start with and asks more of you in the dark; a standby unit asks more of the panel and the fuel supply up front. Either way, the load on the panel is worth counting first, and a full panel may point to <?php echo serviceLink('panel-upgrades', 'a panel upgrade'); ?> before the switch goes in. The same pressure on panel capacity is covered in <a href="/blog/panel-upgrade-cost-hagerstown/">what decides the cost of a panel upgrade</a>.</p>

        <h2 id="winter-plan">What should you plan before the next winter outage?</h2>
        <p>Plan around the cold. Hagerstown's average January daily low is about 25&deg;F, and the record low of &minus;27&deg;F was set on January 13, 1912, so a long winter outage means a house without heat, and a basement without a sump pump in a thaw. Potomac Edison delivers electricity in Washington County and restores the lines; the circuits inside the house are the part you can prepare.</p>
        <ol class="bp-list">
          <li><strong>List the circuits that matter.</strong> The furnace or boiler controls, the sump pump, the refrigerator and freezer, a few lights and a phone-charging outlet come first on most lists.</li>
          <li><strong>Count the watts.</strong> Add running watts for each, then allow for the starting surge of motors. This is what sizes the generator and the transfer switch.</li>
          <li><strong>Decide where the generator runs.</strong> Outdoors only, well away from doors, windows and vents. Generator exhaust contains carbon monoxide, which is why a garage with the door open is not outdoors.</li>
          <li><strong>Store fuel safely and test early.</strong> Start the generator before the storm, not during it.</li>
        </ol>

        <h2 id="panel-room">Does the panel have room for a transfer switch?</h2>
        <p>Often it does, but it depends on the panel's size and how many open slots it has. A transfer switch for chosen circuits takes the place of several breakers, and an interlock needs a panel model it is listed for. A full or aging panel is the common reason a generator hookup turns into a panel job. Where the work sits also decides the permit: inside the City of Hagerstown it goes through the city's permit office, and in unincorporated Washington County through the county's. The <a href="<?php echo esc(areaUrl('hagerstown') ?: '/service-areas/'); ?>">Hagerstown service area page</a> lists both.</p>

        <section class="bp-faq" aria-labelledby="faq">
          <h2 id="faq">Questions about generator hookups</h2>
<?php foreach ($pageFaqs as $faqIdx => $faqItem): ?>
          <details class="faq"<?php echo $faqIdx === 0 ? ' open' : ''; ?>>
            <summary><?php echo esc($faqItem['q']); ?></summary>
            <p class="faq-answer"><?php echo linkContacts(esc($faqItem['a'])); ?></p>
          </details>
<?php endforeach; ?>
        </section>

        <p class="bp-byline">Published by Page One Insights LLC for <?php echo esc($siteName); ?> &middot; <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> &middot; Last updated <?php echo esc($post['date']); ?>. General safety information, not a design for any particular property. Climate figures: Hagerstown, Maryland (Wikipedia).</p>
      </div>
      <aside class="bp-aside" aria-label="Contact">
        <div class="bp-side-cta">
          <h2>Talk to the Hagerstown office</h2>
          <p><?php echo esc($siteName); ?> will look at the panel before giving a price.</p>
          <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
          <button type="button" class="btn btn-outline-white" data-open-estimate>Get a generator estimate</button>
        </div>
      </aside>
    </div>
  </div>
</section>
</article>

<?php
$relatedSlug     = $postSlug;
$relatedServices = ['generator-installation' => 'Generator Installation', 'panel-upgrades' => 'Panel Upgrades', 'emergency-electrician' => 'Emergency Electrician'];
include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-related.php';
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
