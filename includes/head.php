<?php
/**
 * includes/head.php — doctype, <head>, SEO, Open Graph, fonts, critical CSS, schema. Ends by opening <body>.
 *
 * Page contract — set BEFORE including this file (after config.php + functions.php):
 *   $pageTitle, $pageDescription (alias $metaDescription), $canonicalUrl (optional — computed from the request URI when unset),
 *   $currentPage (nav state), $pageType (home|service|city|blog|about|faq|contact|other), $serviceSlug / $citySlug,
 *   $ogImage (optional), $noindex (thank-you only), $bodyClass (optional),
 *   $schemaMarkup (JSON string, one node array, or a list of node arrays — pushed into the page's @graph),
 *   $heroPreload = ['srcset' => '… 480w, … 960w, … 1600w' (AVIF), 'sizes' => '100vw'] on photo-hero pages.
 * Every page emits the full Electrician (#organization) + WebSite nodes once; page nodes reference them by @id.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$headTitle = !empty($pageTitle) ? $pageTitle : defaultPageTitle();
$headDesc  = !empty($pageDescription) ? $pageDescription : (!empty($metaDescription) ? $metaDescription : defaultMetaDescription());
$headCanon = !empty($canonicalUrl) ? $canonicalUrl : requestCanonical();
// Electrician (#organization) + WebSite on every page (seo-aeo-2026 Part B "Universal schema"); a page node with the same
// @id (area pages' richer areaServed) is merged into it rather than emitted twice.
$headOrg   = generateLocalBusinessSchema();
$headNodes = [$headOrg, generateWebSiteSchema()];
if (!empty($schemaMarkup)) {
    $headExtra = is_string($schemaMarkup) ? json_decode($schemaMarkup, true) : $schemaMarkup;
    if (is_array($headExtra)) {
        // a single node (has @type) or a list of nodes; strip a stray per-node @context
        $headList = isset($headExtra['@type']) || isset($headExtra['@graph']) ? [$headExtra] : $headExtra;
        foreach ($headList as $headNode) {
            if (isset($headNode['@graph'])) { foreach ($headNode['@graph'] as $headGraphNode) $headNodes[] = $headGraphNode; continue; }
            unset($headNode['@context']);
            if (($headNode['@id'] ?? '') === $headOrg['@id']) { $headNodes[0] = array_merge($headNodes[0], $headNode); continue; }
            $headNodes[] = $headNode;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#11151a">
<?php echo generateMetaTags($headTitle, $headDesc, $headCanon); ?>

<!-- Self-hosted fonts (v6.2): only the above-the-fold heading face is preloaded; @font-face lives in framework.css -->
<link rel="preload" href="/assets/fonts/space-grotesk.woff2" as="font" type="font/woff2" crossorigin>

<!-- Critical CSS inlined; framework.css loads non-blocking -->
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo esc($cssVersion); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo esc($cssVersion); ?>"></noscript>
<?php if (!empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo esc($heroPreload['srcset']); ?>" imagesizes="<?php echo esc($heroPreload['sizes'] ?? '100vw'); ?>" fetchpriority="high">
<?php endif; ?>

<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
<?php if (!empty($googleAnalyticsId) && $googleAnalyticsId !== 'G-XXXXXXXXXX'): ?>

<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc($googleAnalyticsId); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo esc($googleAnalyticsId); ?>');</script>
<?php else: ?>

<!-- Google Analytics (GA4) placeholder — replace G-XXXXXXXXXX with the client's measurement ID in config.php ($googleAnalyticsId):
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-XXXXXXXXXX');</script>
-->
<?php endif; ?>

<?php $headNodes = array_values(array_filter($headNodes)); if ($headNodes): ?>
<script type="application/ld+json"><?php echo jsonLd(['@context' => 'https://schema.org', '@graph' => $headNodes]); ?></script>
<?php endif; ?>
</head>
<body class="has-sticky-bar<?php echo !empty($bodyClass) ? ' ' . esc($bodyClass) : ''; ?>">
