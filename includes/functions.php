<?php
/**
 * includes/functions.php — shared helpers for All Connected Electric LLC.
 * Every page: require_once config.php THEN functions.php, before any helper call.
 * Helpers read config.php globals ($siteName, $siteUrl, $address, $services, ...).
 * Loop variables inside shared includes are prefixed ($navSvc, $footArea) — never $svc/$area/$c/$card.
 */

// Lead-form helpers (p1_lead_hidden_fields, p1_consent_row, p1_service_options) — pages with a hero/estimate form call these before footer.php
require_once __DIR__ . '/p1-form-helpers.php';

if (!function_exists('esc')) {
    /** HTML-escape for text and attribute output. */
    function esc($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

/* ---------------------------------------------------------------------------
 * Navigation / state
 * ------------------------------------------------------------------------- */

if (!function_exists('isActivePage')) {
    /** True when $page matches the page's $currentPage (set before head.php). */
    function isActivePage(string $page): bool {
        global $currentPage;
        return isset($currentPage) && $currentPage === $page;
    }
}

if (!function_exists('ariaCurrent')) {
    /** ' aria-current="page"' when active, else ''. */
    function ariaCurrent(string $page): string {
        return isActivePage($page) ? ' aria-current="page"' : '';
    }
}

if (!function_exists('siteHas')) {
    /**
     * Link integrity: true only when the page exists on disk.
     * siteHas('/about/') → /about/index.php · siteHas('/thank-you') → /thank-you.php · siteHas('/') → /index.php
     */
    function siteHas(string $path): bool {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $path = '/' . trim($path, '/');
        if ($path === '/') return is_file($root . '/index.php');
        return is_file($root . $path . '/index.php') || is_file($root . $path . '.php');
    }
}

if (!function_exists('serviceUrl')) {
    /** "/services/<slug>/" when that page is built, else ''. */
    function serviceUrl(string $slug): string {
        return siteHas('/services/' . $slug . '/') ? '/services/' . $slug . '/' : '';
    }
}

if (!function_exists('serviceLink')) {
    /** Contextual body link to a service page: <a> when the page is built, plain anchor text otherwise (never a 404). */
    function serviceLink(string $slug, string $anchor): string {
        $url = serviceUrl($slug);
        return $url !== '' ? '<a href="' . esc($url) . '">' . esc($anchor) . '</a>' : esc($anchor);
    }
}

if (!function_exists('areaUrl')) {
    /**
     * Built area page for a city slug, else ''. Area pages live at /service-areas/<slug>/ (Phase 4 hub URL) or
     * /areas/<slug>/ (scaffold dir) — whichever exists on disk wins, so a link can never point at a 404.
     */
    function areaUrl(string $slug): string {
        foreach (['/service-areas/', '/areas/'] as $base) {
            if (siteHas($base . $slug . '/')) return $base . $slug . '/';
        }
        return '';
    }
}

if (!function_exists('siteLogo')) {
    /**
     * Image-first logo lookup in /assets/images/ (cut-out, version-suffixed marks first). Returns
     * ['src','width','height','class'] sized to the LARGE-LOGO STANDARD by aspect ratio, or null when no logo
     * file exists (header/footer then fall back to the text logo).
     */
    function siteLogo(): ?array {
        static $logo = false;
        if ($logo !== false) return $logo;
        $dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/';
        $files = [];
        foreach (['logo-mark-v*.png', 'logo-mark-v*.webp', 'logo-mark.png', 'logo.svg', 'logo.png', 'logo.webp'] as $pattern) {
            $hits = glob($dir . $pattern) ?: [];
            natsort($hits);
            $files = array_merge($files, array_reverse(array_values($hits)));
        }
        foreach ($files as $file) {
            $w = $h = 0;
            if (substr($file, -4) === '.svg') {
                $svg = (string) file_get_contents($file);
                if (preg_match('/viewBox="[\d.\-]+[ ,]+[\d.\-]+[ ,]+([\d.]+)[ ,]+([\d.]+)"/', $svg, $m)) { $w = (float) $m[1]; $h = (float) $m[2]; }
            } else {
                $info = @getimagesize($file);
                if ($info) { $w = $info[0]; $h = $info[1]; }
            }
            if ($w <= 0 || $h <= 0) continue;
            $ratio = $w / $h;
            [$rh, $cls] = $ratio > 3 ? [120, 'logo--wordmark'] : ($ratio >= 1.5 ? [96, ''] : [88, 'logo--square']);
            return $logo = ['src' => '/assets/images/' . basename($file), 'width' => (int) round($rh * $ratio), 'height' => $rh, 'class' => $cls];
        }
        return $logo = null;
    }
}

if (!function_exists('formatPhone')) {
    /** "(301) 704-6333" from any 10/11-digit US number. */
    function formatPhone(string $phone): string {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 11 && $digits[0] === '1') $digits = substr($digits, 1);
        if (strlen($digits) !== 10) return $phone;
        return sprintf('(%s) %s-%s', substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6));
    }
}

if (!function_exists('linkContacts')) {
    /** Turn the site phone number and email inside already-escaped text (FAQ answers, data strings) into tel:/mailto: links. */
    function linkContacts(string $escaped): string {
        global $phone, $phoneRaw, $email;
        $escaped = str_replace(esc(formatPhone($phone)), '<a href="tel:' . esc($phoneRaw) . '">' . esc(formatPhone($phone)) . '</a>', $escaped);
        return $email !== '' ? str_replace(esc($email), '<a href="mailto:' . esc($email) . '">' . esc($email) . '</a>', $escaped) : $escaped;
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $text = strtolower(str_replace('&', ' ', $text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}

if (!function_exists('getServiceSlug')) {
    /** "Wiring & Rewiring" → "wiring-rewiring" (matches config.php slugs). */
    function getServiceSlug(string $name): string {
        return slugify($name);
    }
}

if (!function_exists('getAreaSlug')) {
    /** "Hagerstown" → "hagerstown". */
    function getAreaSlug(string $city): string {
        return slugify($city);
    }
}

/* ---------------------------------------------------------------------------
 * Icons — inline SVG at build/render time (no runtime injection, no CDN)
 * ------------------------------------------------------------------------- */

if (!function_exists('icon')) {
    /**
     * Inline Lucide SVG from references/lucide-icons/<name>.svg, with aria-hidden + width/height.
     * Returns '' for an unknown name. Memoised per request.
     */
    function icon(string $name, int $size = 20, string $class = ''): string {
        static $cache = [];
        $key = $name . '|' . $size . '|' . $class;
        if (isset($cache[$key])) return $cache[$key];
        if (!preg_match('/^[a-z0-9-]+$/', $name)) return '';
        $file = $_SERVER['DOCUMENT_ROOT'] . '/references/lucide-icons/' . $name . '.svg';
        if (!is_file($file)) return $cache[$key] = '';
        $svg = preg_replace('/<!--.*?-->\s*/s', '', (string) file_get_contents($file));
        $svg = preg_replace('/\s+(width|height)="[^"]*"/', '', $svg, 2);
        $cls = 'lucide lucide-' . $name . ($class !== '' ? ' ' . $class : '');
        $svg = preg_replace('/class="[^"]*"/', 'class="' . $cls . '"', $svg, 1);
        $svg = preg_replace('/<svg\b/', '<svg aria-hidden="true" focusable="false" width="' . $size . '" height="' . $size . '"', $svg, 1);
        $svg = trim(preg_replace('/\s+/', ' ', $svg));
        return $cache[$key] = $svg;
    }
}

if (!function_exists('boltMark')) {
    /** The lightning-bolt brand mark (Lucide "zap" geometry) used by the text logo until a client logo exists. */
    function boltMark(int $size = 26): string {
        return '<svg aria-hidden="true" focusable="false" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>';
    }
}

/* ---------------------------------------------------------------------------
 * SEO helpers
 * ------------------------------------------------------------------------- */

if (!function_exists('requestCanonical')) {
    /** Self-referencing canonical from the request path on $siteUrl: directories get a trailing slash, index.php is dropped. */
    function requestCanonical(): string {
        global $siteUrl;
        $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = preg_replace('#/index\.php$#', '/', $path);
        $path = preg_replace('#\.php$#', '', $path);
        if ($path === '' || $path === false) $path = '/';
        if ($path[0] !== '/') $path = '/' . $path;
        if (substr($path, -1) !== '/' && !preg_match('/\.[a-z0-9]{2,4}$/i', $path)) $path .= '/';
        return rtrim($siteUrl, '/') . $path;
    }
}

if (!function_exists('absoluteUrl')) {
    function absoluteUrl(string $path): string {
        global $siteUrl;
        if (preg_match('#^https?://#i', $path)) return $path;
        return rtrim($siteUrl, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('defaultPageTitle')) {
    /** "Electrician in Hagerstown, MD | All Connected Electric LLC" — from $primaryKeyword + city/state + $siteName. */
    function defaultPageTitle(): string {
        global $siteName, $primaryKeyword, $address;
        $base = trim(preg_replace('/\s+/', ' ', str_ireplace([$address['city'], $address['state']], '', (string) $primaryKeyword)));
        $base = $base !== '' ? ucfirst($base) : 'Electrician';
        return $base . ' in ' . $address['city'] . ', ' . $address['state'] . ' | ' . $siteName;
    }
}

if (!function_exists('defaultMetaDescription')) {
    /** Plain offering + CTA from config. No insurance, "free", 24/7 or same-day claim — none is in the intake. */
    function defaultMetaDescription(): string {
        global $siteName, $address, $phone;
        return $siteName . ': electrician in ' . $address['city'] . ', ' . $address['state']
            . ' for commercial, residential and industrial work, panel upgrades and EV chargers. Call ' . $phone . '.';
    }
}

if (!function_exists('ogImageUrl')) {
    /** Absolute OG image URL: page's $ogImage → /assets/images/og-default.jpg → logo; '' when none exists on disk. */
    function ogImageUrl(): string {
        global $ogImage;
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $candidates = [];
        if (!empty($ogImage)) $candidates[] = (string) $ogImage;
        foreach (['og-default.jpg', 'og-default.png', 'logo.png', 'logo.webp'] as $f) $candidates[] = '/assets/images/' . $f;
        foreach ($candidates as $c) {
            if (preg_match('#^https?://#i', $c)) return $c;
            if (is_file($root . '/' . ltrim($c, '/'))) return absoluteUrl($c);
        }
        return '';
    }
}

if (!function_exists('generateMetaTags')) {
    /**
     * <title>, description, canonical, robots and Open Graph tags.
     * Emits no keywords meta and no Twitter/X Card tags (both forbidden).
     */
    function generateMetaTags(string $title, string $description, string $canonical): string {
        global $siteName, $noindex;
        $out  = '<title>' . esc($title) . "</title>\n";
        $out .= '<meta name="description" content="' . esc($description) . "\">\n";
        $out .= '<link rel="canonical" href="' . esc($canonical) . "\">\n";
        $out .= !empty($noindex)
            ? "<meta name=\"robots\" content=\"noindex,nofollow\">\n"
            : "<meta name=\"robots\" content=\"index,follow,max-image-preview:large\">\n";
        $out .= "<meta property=\"og:type\" content=\"website\">\n";
        $out .= '<meta property="og:title" content="' . esc($title) . "\">\n";
        $out .= '<meta property="og:description" content="' . esc($description) . "\">\n";
        $out .= '<meta property="og:url" content="' . esc($canonical) . "\">\n";
        $img = ogImageUrl();
        if ($img !== '') $out .= '<meta property="og:image" content="' . esc($img) . "\">\n";
        $out .= '<meta property="og:site_name" content="' . esc($siteName) . "\">\n";
        $out .= "<meta property=\"og:locale\" content=\"en_US\">\n";
        return $out;
    }
}

/* ---------------------------------------------------------------------------
 * Schema (JSON-LD). Self-serving review-rating markup is forbidden here (real GBP counts go in visible content).
 * ------------------------------------------------------------------------- */

if (!function_exists('jsonLd')) {
    function jsonLd($data): string {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    }
}

if (!function_exists('generateLocalBusinessSchema')) {
    /** Homepage Electrician node (@id #organization). Every field comes from config.php; empty values are omitted, never guessed. */
    function generateLocalBusinessSchema(): array {
        global $siteName, $siteUrl, $phone, $phoneRaw, $email, $address, $addressPublic, $geo, $gbpMapsUrl,
               $yearEstablished, $services, $serviceAreas, $socialLinks, $openingHoursSpec, $licenseLabel, $gbpName;
        $root = rtrim($siteUrl, '/');
        $postal = ['@type' => 'PostalAddress', 'addressLocality' => $address['city'], 'addressRegion' => $address['state'], 'postalCode' => $address['zip'], 'addressCountry' => 'US'];
        if (!empty($addressPublic) && !empty($address['street'])) $postal = ['@type' => 'PostalAddress', 'streetAddress' => $address['street']] + array_slice($postal, 1);

        $node = [
            '@type' => 'Electrician',
            '@id' => $root . '/#organization',
            'name' => $siteName,
            'legalName' => $siteName,
            'url' => $root . '/',
            'telephone' => $phoneRaw,
            'email' => $email,
            'description' => defaultMetaDescription(),
            'address' => $postal,
        ];
        if (!empty($geo['lat']) && !empty($geo['lng'])) $node['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $geo['lat'], 'longitude' => $geo['lng']];
        if (!empty($yearEstablished)) $node['foundingDate'] = (string) $yearEstablished;
        if (!empty($openingHoursSpec)) $node['openingHoursSpecification'] = $openingHoursSpec;
        if (!empty($licenseLabel)) $node['hasCredential'] = ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => 'license', 'name' => $licenseLabel];
        $logoUrl = '';
        foreach (['logo.png', 'logo.webp', 'logo.svg'] as $f) if (is_file($_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $f)) { $logoUrl = $root . '/assets/images/' . $f; break; }
        $img = ogImageUrl();
        if ($img !== '') $node['image'] = $img;
        if ($logoUrl !== '') $node['logo'] = $logoUrl;
        if (!empty($gbpMapsUrl)) $node['hasMap'] = $gbpMapsUrl;
        if (!empty($gbpName) && $gbpName !== $siteName) $node['alternateName'] = $gbpName;

        $areaNodes = [];
        foreach ((array) $serviceAreas as $schemaArea) {
            $areaNodes[] = ['@type' => 'City', 'name' => $schemaArea['name'] . ', ' . $address['state']];
        }
        if ($areaNodes) $node['areaServed'] = $areaNodes;

        $offers = [];
        foreach ((array) $services as $schemaSvc) {
            $item = ['@type' => 'Service', 'name' => $schemaSvc['name'], 'description' => $schemaSvc['description']];
            if (siteHas('/services/' . $schemaSvc['slug'] . '/')) $item['url'] = $root . '/services/' . $schemaSvc['slug'] . '/';
            $offers[] = ['@type' => 'Offer', 'itemOffered' => $item];
        }
        if ($offers) $node['hasOfferCatalog'] = ['@type' => 'OfferCatalog', 'name' => $siteName . ' electrical services', 'itemListElement' => $offers];
        if (!empty($socialLinks)) $node['sameAs'] = array_values(array_filter((array) $socialLinks));
        return $node;
    }
}

if (!function_exists('generateWebSiteSchema')) {
    function generateWebSiteSchema(): array {
        global $siteName, $siteUrl;
        $root = rtrim($siteUrl, '/');
        return ['@type' => 'WebSite', '@id' => $root . '/#website', 'url' => $root . '/', 'name' => $siteName, 'publisher' => ['@id' => $root . '/#organization']];
    }
}

if (!function_exists('generateServiceSchema')) {
    /**
     * Service node for a service page. $service is a config.php $services row (name, slug, description) —
     * optionally with 'url' to override. Provider references the homepage #organization node.
     */
    function generateServiceSchema(array $service): array {
        global $siteUrl, $address, $serviceAreas;
        $root = rtrim($siteUrl, '/');
        $url = $service['url'] ?? ($root . '/services/' . ($service['slug'] ?? getServiceSlug($service['name'])) . '/');
        $areas = [];
        foreach ((array) $serviceAreas as $schemaArea) $areas[] = ['@type' => 'City', 'name' => $schemaArea['name'] . ', ' . $address['state']];
        $node = [
            '@type' => 'Service',
            '@id' => $url . '#service',
            'name' => $service['name'],
            'serviceType' => $service['name'],
            'description' => $service['description'] ?? '',
            'url' => $url,
            'provider' => ['@id' => $root . '/#organization'],
        ];
        if ($areas) $node['areaServed'] = $areas;
        return $node;
    }
}

if (!function_exists('generateBreadcrumbSchema')) {
    /** BreadcrumbList from [['name' => 'Home', 'url' => 'https://…/'], ...] (last item = current page). */
    function generateBreadcrumbSchema(array $crumbs): array {
        $items = [];
        foreach (array_values($crumbs) as $i => $crumb) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['name'], 'item' => absoluteUrl($crumb['url'])];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
}

if (!function_exists('schemaGraph')) {
    /** Wrap nodes in one @context/@graph JSON-LD <script>. Returns '' for no nodes. */
    function schemaGraph(array $nodes): string {
        $nodes = array_values(array_filter($nodes));
        if (!$nodes) return '';
        return '<script type="application/ld+json">' . jsonLd(['@context' => 'https://schema.org', '@graph' => $nodes]) . "</script>\n";
    }
}
