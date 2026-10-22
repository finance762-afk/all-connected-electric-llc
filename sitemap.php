<?php
/**
 * sitemap.php — dynamic sitemap; .htaccess rewrites /sitemap.xml to this file. No static sitemap.xml / sitemap-images.xml.
 * Nothing here lists a page by hand: URLs come from config.php ($services, $serviceAreas), the blog registry ($blogPosts)
 * and a fixed list of top-level pages that is filtered by siteHas() so an unbuilt page can never appear.
 * Priorities: home 1.0 · services hub + service pages 0.8 · other content pages 0.6 · legal pages 0.3 (yearly).
 * lastmod = the page file's mtime (blog posts use their registry dateISO). Image entries come from registry photos that exist on disk.
 * Canonicals use the trailing-slash form, identical to the on-page canonicals.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';

$smRoot = rtrim($siteUrl, '/');
$smDocRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

/** lastmod from the page's own file. */
$smMtime = function (string $path) use ($smDocRoot): string {
    $path = '/' . trim($path, '/');
    $file = $path === '/' ? $smDocRoot . '/index.php' : $smDocRoot . $path . '/index.php';
    if (!is_file($file)) $file = $smDocRoot . $path . '.php';
    return date('Y-m-d', is_file($file) ? (int) filemtime($file) : time());
};

$smUrls = [];   // [loc path, lastmod, changefreq, priority, images[]]
$smUrls[] = ['/', $smMtime('/'), 'weekly', '1.0', []];
foreach ([['/services/', 'monthly', '0.8'], ['/service-areas/', 'monthly', '0.6'], ['/about/', 'yearly', '0.6'], ['/faq/', 'monthly', '0.6'], ['/contact/', 'yearly', '0.6'], ['/blog/', 'weekly', '0.6']] as $smTop) {
    if (siteHas($smTop[0])) $smUrls[] = [$smTop[0], $smMtime($smTop[0]), $smTop[1], $smTop[2], []];
}
foreach ($services as $smSvc) {
    $smPath = '/services/' . $smSvc['slug'] . '/';
    if (siteHas($smPath)) $smUrls[] = [$smPath, $smMtime($smPath), 'monthly', '0.8', []];
}
foreach ($serviceAreas as $smArea) {
    $smPath = areaUrl($smArea['slug']);
    if ($smPath !== '') $smUrls[] = [$smPath, $smMtime($smPath), 'monthly', '0.6', []];
}
foreach ($blogPosts as $smPost) {
    $smPath = blogPostUrl($smPost);
    if (!siteHas($smPath)) continue;
    $smImages = [];
    if (!empty($smPost['image']) && is_file($smDocRoot . $smPost['image'])) $smImages[] = [$smPost['image'], $smPost['alt'], $smPost['title']];
    $smUrls[] = [$smPath, $smPost['dateISO'], 'monthly', '0.6', $smImages];
}
foreach ([['/privacy-policy/'], ['/terms/'], ['/cookie-policy/'], ['/accessibility/']] as $smLegal) {
    if (siteHas($smLegal[0])) $smUrls[] = [$smLegal[0], $smMtime($smLegal[0]), 'yearly', '0.3', []];
}

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($smUrls as $smUrl): ?>
  <url>
    <loc><?php echo esc($smRoot . $smUrl[0]); ?></loc>
    <lastmod><?php echo esc($smUrl[1]); ?></lastmod>
    <changefreq><?php echo esc($smUrl[2]); ?></changefreq>
    <priority><?php echo esc($smUrl[3]); ?></priority>
<?php foreach ($smUrl[4] as $smImg): ?>
    <image:image>
      <image:loc><?php echo esc($smRoot . $smImg[0]); ?></image:loc>
      <image:caption><?php echo esc($smImg[1]); ?></image:caption>
      <image:title><?php echo esc($smImg[2]); ?></image:title>
    </image:image>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>
