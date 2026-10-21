<?php
/**
 * includes/legal-hero.php — shared 40vh solid-colour hero + breadcrumb for the four legal pages.
 * Set before including (after header.php):
 *   $legalTitle    — H1 and breadcrumb label        $legalLede     — one plain sentence under the H1
 *   $legalUpdated  — "Last Updated" date string      $legalEyebrow  — optional, default "Legal"
 * Loop/scratch variables are prefixed $legal*. No image, no reveal classes (legal pages are plain by design).
 */
$legalEyebrow = $legalEyebrow ?? 'Legal';
?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.css'; ?></style>

<section class="hero hero--legal" aria-labelledby="legal-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page"><?php echo esc($legalTitle); ?></span></li>
      </ol>
    </nav>
    <span class="eyebrow"><?php echo esc($legalEyebrow); ?></span>
    <h1 id="legal-hero-title"><?php echo esc($legalTitle); ?></h1>
    <p class="legal-lede"><?php echo esc($legalLede); ?></p>
    <p class="legal-updated">Last Updated: <time datetime="<?php echo esc(date('Y-m-d', strtotime($legalUpdated))); ?>"><?php echo esc($legalUpdated); ?></time></p>
  </div>
</section>
