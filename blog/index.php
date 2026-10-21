<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/ — registry-driven article index, All Connected Electric LLC (Phase 6).
 * Every card comes from $blogPosts (includes/blog-data.php); nothing here lists a post by hand. No photos on disk yet,
 * so cards use the typeset icon tile (blogCardImage()). The full topic cluster grows post-launch via the design-portal Blogs tab.
 */
$pageTitle       = 'Electrical Advice for Hagerstown, MD Homeowners | Blog';
$pageDescription = 'Plain-language electrical articles from All Connected Electric LLC in Hagerstown, MD: panel upgrade costs, generator hookups and what to ask before you hire.';
$canonicalUrl    = $siteUrl . '/blog/';
$ogImage         = '';
$currentPage     = 'blog';
$pageType        = 'blog';
$heroPreload     = [];

$blogRoot  = rtrim($siteUrl, '/');
$blogItems = [];
foreach ($blogPosts as $blogIdx => $blogRow) {
    $blogItems[] = ['@type' => 'ListItem', 'position' => $blogIdx + 1, 'url' => $blogRoot . blogPostUrl($blogRow), 'name' => $blogRow['title']];
}
$schemaMarkup = [
    ['@type' => 'CollectionPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle,
     'isPartOf' => ['@id' => $blogRoot . '/#website'], 'about' => ['@id' => $blogRoot . '/#organization'],
     'mainEntity' => ['@type' => 'ItemList', 'name' => $siteName . ' articles', 'numberOfItems' => count($blogItems), 'itemListElement' => $blogItems]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'Blog', 'url' => $canonicalUrl],
    ]),
];

$blogFeatured = $blogPosts[0] ?? null;
$blogRest     = array_slice($blogPosts, 1);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/blog.css'; ?></style>

<!-- ============ 1. HERO (no lead form on the blog index) ============ -->
<section class="hero hero--interior sp-hero bl-hero" aria-labelledby="bl-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Blog</span></li>
      </ol>
    </nav>
    <span class="eyebrow">Electrical advice &middot; Hagerstown, MD</span>
    <h1 class="hero-title" id="bl-hero-title">Electrical advice for <span class="text-accent">Hagerstown, MD</span> homes and businesses</h1>
    <p class="hero-answer">Plain-language answers from All Connected Electric LLC on panel upgrades, generators and the questions to ask before an electrician starts work in Hagerstown and Washington County.</p>
  </div>
</section>

<!-- ============ 2. ARTICLES (registry-driven) ============ -->
<section class="section bl-articles" aria-labelledby="bl-articles-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Latest articles</span>
      <h2 id="bl-articles-title">What are Hagerstown homeowners asking about electrical work?</h2>
    </div>
<?php if ($blogFeatured): ?>
    <a class="bl-feature reveal-up" href="<?php echo esc(blogPostUrl($blogFeatured)); ?>">
      <?php echo blogCardImage($blogFeatured, '(max-width: 960px) 100vw, 600px'); ?>
      <div class="blog-card__body">
        <span class="blog-card__badge"><?php echo esc($blogFeatured['category']); ?></span>
        <span class="blog-card__meta"><?php echo esc($blogFeatured['date']); ?> &middot; <?php echo esc($blogFeatured['readtime']); ?></span>
        <h3 class="blog-card__title"><?php echo esc($blogFeatured['title']); ?></h3>
        <p class="blog-card__excerpt"><?php echo esc($blogFeatured['excerpt']); ?></p>
        <span class="blog-card__cta">Read Article &rarr;</span>
      </div>
    </a>
<?php endif; ?>
<?php if ($blogRest): ?>
    <div class="blog-grid bl-grid">
<?php foreach ($blogRest as $blogCardIdx => $blogCard): ?>
      <a class="blog-card reveal-<?php echo ['up', 'left', 'right'][$blogCardIdx % 3]; ?>" href="<?php echo esc(blogPostUrl($blogCard)); ?>">
        <?php echo blogCardImage($blogCard); ?>
        <div class="blog-card__body">
          <span class="blog-card__category"><?php echo esc($blogCard['category']); ?></span>
          <h3 class="blog-card__title"><?php echo esc($blogCard['title']); ?></h3>
          <p class="blog-card__excerpt"><?php echo esc($blogCard['excerpt']); ?></p>
          <span class="blog-card__meta"><?php echo esc($blogCard['date']); ?> &middot; <?php echo esc($blogCard['readtime']); ?></span>
          <span class="blog-card__cta">Read Article &rarr;</span>
        </div>
      </a>
<?php endforeach; ?>
    </div>
<?php endif; ?>
    <p class="bl-note">Articles describe general electrical practice and local permit offices. They are not a quote or a substitute for having an electrician look at your panel and wiring. Published by Page One Insights LLC on behalf of <?php echo esc($siteName); ?>.</p>
  </div>
</section>

<!-- ============ 3. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="bl-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Have a question of your own?</span>
      <h2 id="bl-cta-title">Ask an electrician in Hagerstown about your panel or wiring</h2>
      <p>Call <?php echo esc(formatPhone($phone)); ?> or send the details, and <?php echo esc($siteName); ?> will follow up to set a time to look at the job.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Get an estimate</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
