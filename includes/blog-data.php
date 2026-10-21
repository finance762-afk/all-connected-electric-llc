<?php
/**
 * includes/blog-data.php — single source of truth for all blog post metadata.
 * Newest post FIRST. Every consumer (blog index, homepage preview, related articles, sitemap.php) reads this array.
 * Never hardcode post lists elsewhere. Adding a post = one entry here + one /blog/{slug}/index.php.
 *
 * 'image' / 'alt': a path under /assets/images/ (use the -960.webp variant) once the client uploads job photos. NO photos are
 *   on disk yet (build-plan assets.images is empty), so both are '' and every consumer renders the typeset 'icon' tile instead.
 *   Consumers must never print an <img> for an empty 'image'.
 * 'icon': Lucide name in references/lucide-icons/ for the typeset tile. 'title' stays <= 60 chars, no brand suffix.
 */
$blogPosts = [
    [
        'slug'     => 'panel-upgrade-cost-hagerstown',
        'title'    => 'What Decides the Cost of a Panel Upgrade in Hagerstown?',
        'excerpt'  => 'The price of a panel upgrade turns on the panel, the service size, the meter base and the permit. Here is what moves it and how to get a number you can rely on.',
        'image'    => '',
        'alt'      => '',
        'icon'     => 'zap',
        'date'     => 'October 21, 2026',
        'dateISO'  => '2026-10-21',
        'category' => 'Panels & Service',
        'readtime' => '5 min read',
        'keywords' => ['panel upgrade cost Hagerstown', 'electrical panel replacement MD', 'service upgrade', 'electrician Hagerstown MD'],
    ],
    [
        'slug'     => 'portable-generator-transfer-switch-hagerstown',
        'title'    => 'Does a Portable Generator Need a Transfer Switch?',
        'excerpt'  => 'Anything wired into the house needs a transfer switch or listed interlock so generator power cannot flow back onto the utility lines. What to plan before a Hagerstown winter outage.',
        'image'    => '',
        'alt'      => '',
        'icon'     => 'power',
        'date'     => 'October 21, 2026',
        'dateISO'  => '2026-10-21',
        'category' => 'Generators & Outages',
        'readtime' => '5 min read',
        'keywords' => ['transfer switch', 'portable generator hookup', 'generator installation Hagerstown', 'power outage Washington County MD'],
    ],
];

if (!function_exists('blogPostUrl')) {
    /** "/blog/<slug>/" for a registry row. */
    function blogPostUrl(array $post): string {
        return '/blog/' . $post['slug'] . '/';
    }
}

if (!function_exists('blogPostBySlug')) {
    function blogPostBySlug(string $slug): ?array {
        global $blogPosts;
        foreach ((array) $blogPosts as $blogRow) if ($blogRow['slug'] === $slug) return $blogRow;
        return null;
    }
}

if (!function_exists('blogRelated')) {
    /** Up to $limit other posts: same category first, then most recent. Built posts only (the page must exist on disk). */
    function blogRelated(string $slug, int $limit = 3): array {
        global $blogPosts;
        $current = blogPostBySlug($slug);
        $same = $other = [];
        foreach ((array) $blogPosts as $blogRow) {
            if ($blogRow['slug'] === $slug || !siteHas('/blog/' . $blogRow['slug'] . '/')) continue;
            if ($current && $blogRow['category'] === $current['category']) $same[] = $blogRow; else $other[] = $blogRow;
        }
        return array_slice(array_merge($same, $other), 0, $limit);
    }
}

if (!function_exists('blogCardImage')) {
    /** The card's top block: <img> when the registry has a file that exists on disk AND a descriptive alt, else the typeset icon tile. */
    function blogCardImage(array $post, string $sizes = '(max-width: 600px) 100vw, 360px'): string {
        $file = !empty($post['image']) && !empty($post['alt']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $post['image'] : '';
        ob_start();
        if ($file !== '' && is_file($file)) { ?>
<div class="blog-card__image"><img src="<?php echo esc($post['image']); ?>" alt="<?php echo esc($post['alt']); ?>" width="960" height="600" loading="lazy" decoding="async"></div>
<?php } else { ?>
<div class="blog-card__image blog-card__image--type" aria-hidden="true"><?php echo icon($post['icon'] ?? 'zap', 40); ?><span><?php echo esc($post['category']); ?></span></div>
<?php }
        return trim((string) ob_get_clean());
    }
}
