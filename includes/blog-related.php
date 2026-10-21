<?php
/**
 * includes/blog-related.php — "Related services" + "Related articles" block closing every blog post.
 * Set before including: $relatedSlug (this post's registry slug), $relatedServices = [slug => lead-in sentence, ...].
 * Articles come from the $blogPosts registry (same category first). Service and area links render only when the page exists.
 * Loop variables are prefixed ($relSvc*, $relArt*) so they never collide with the post's own.
 */
require_once __DIR__ . '/blog-data.php';
$relArticles = blogRelated($relatedSlug, 3);
?>
<section class="section bp-related" aria-labelledby="bp-related-title">
  <div class="container">
    <div class="blog-post__related-services reveal-up">
      <span class="eyebrow-label">Related services</span>
      <h2 id="bp-related-title">Which All Connected Electric services go with this topic?</h2>
      <ul class="bp-svc-links">
<?php foreach ((array) $relatedServices as $relSvcSlug => $relSvcLabel): $relSvcUrl = serviceUrl($relSvcSlug); if ($relSvcUrl === '') continue; ?>
        <li><a href="<?php echo esc($relSvcUrl); ?>"><?php echo icon('arrow-right', 16); ?><?php echo esc($relSvcLabel); ?></a></li>
<?php endforeach; ?>
<?php if (areaUrl('hagerstown') !== ''): ?>
        <li><a href="<?php echo esc(areaUrl('hagerstown')); ?>"><?php echo icon('map-pin', 16); ?>Electrician in Hagerstown, MD</a></li>
<?php endif; ?>
<?php if (siteHas('/contact/')): ?>
        <li><a href="/contact/"><?php echo icon('phone', 16); ?>Contact the Hagerstown office</a></li>
<?php endif; ?>
      </ul>
    </div>
<?php if ($relArticles): ?>
    <div class="blog-post__related-articles reveal-up">
      <span class="eyebrow-label">Keep reading</span>
      <h2>What else should you read before calling an electrician?</h2>
      <div class="blog-grid">
<?php foreach ($relArticles as $relArt): ?>
        <a class="blog-card" href="<?php echo esc(blogPostUrl($relArt)); ?>">
          <?php echo blogCardImage($relArt); ?>
          <div class="blog-card__body">
            <span class="blog-card__category"><?php echo esc($relArt['category']); ?></span>
            <h3 class="blog-card__title"><?php echo esc($relArt['title']); ?></h3>
            <p class="blog-card__excerpt"><?php echo esc($relArt['excerpt']); ?></p>
            <span class="blog-card__meta"><?php echo esc($relArt['date']); ?> &middot; <?php echo esc($relArt['readtime']); ?></span>
            <span class="blog-card__cta">Read article</span>
          </div>
        </a>
<?php endforeach; ?>
      </div>
    </div>
<?php endif; ?>
  </div>
</section>
