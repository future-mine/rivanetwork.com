<?php if (get("action") == "category") { ?>
<?php
if (!isset($_GET["category"])) {
  go(urlConverter("home", $languageType));
}
$searchNewsCategory = $db->prepare("SELECT * FROM newsCategory WHERE name = ?");
$searchNewsCategory->execute(array(get("category")));
if ($searchNewsCategory->rowCount() > 0) {
  $readNewsCategory = $searchNewsCategory->fetch();
  $searchNews = $db->prepare("SELECT * FROM newsList WHERE categoryName = ? ORDER BY id DESC");
  $searchNews->execute(array($readNewsCategory["name"]));
} else {
  go(urlConverter("home", $languageType));
}
?>
<div class="content-grid">
    <div class="section-header">
      <div class="section-header-info">
        <p class="section-pretitle"><?php echo languageVariables("news", "words", $languageType); ?></p>
        <h2 class="section-title"><?php echo $readNewsCategory["name"]; ?></h2>
      </div>
      <div class="section-header-actions">
        <a class="section-header-subsection" href="<?php echo urlConverter("home", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a>
        <a class="section-header-subsection" href="<?php echo urlConverter("news_category", $languageType); ?>/<?php echo $readNewsCategory["name"]; ?>"><?php echo languageVariables("category", "words", $languageType); ?></a>
        <p class="section-header-subsection"><?php echo $readNewsCategory["name"]; ?></p>
      </div>
    </div>
    <div class="grid grid-4-4 centered">
       <div class="grid-column">
        <?php if ($searchNews->rowCount() > 0) { ?>
        <?php foreach ($searchNews as $readNews) { ?>
        <div class="post-preview">
          <figure class="post-preview-image liquid">
            <img src="<?php echo $readNews["image"]; ?>" alt="<?php echo languageVariables("news", "words", $languageType); ?> - <?php echo $readNews["title"]; ?>">
          </figure>
          <div class="post-preview-info fixed-height">
            <div class="post-preview-info-top">
              <p class="post-preview-timestamp"><?php echo checkTime($readNews["date"]); ?></p>
              <p class="post-preview-title"><?php echo $readNews["title"]; ?></p>
            </div>
            <div class="post-preview-info-bottom">
              <p class="post-preview-text"><?php echo $readNews["text"]; ?></p>
              <a class="post-preview-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>"><?php echo languageVariables("moreRead", "words", $languageType); ?></a>
            </div>
          </div>
          <div class="content-actions">
            <div class="content-action">
            </div>
            <div class="content-action">
              <div class="meta-line">
                <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>"><?php echo $readNews["newsHearts"]; ?> <?php echo languageVariables("like", "words", $languageType); ?></a>
              </div>
              <?php $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?"); ?>
              <?php $searchNewsComments->execute(array($readNews["id"], 1)); ?>
              <?php $newsCommentsRow = $searchNewsComments->rowCount(); ?>
              <div class="meta-line">
                <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>"><?php echo $newsCommentsRow; ?> <?php echo languageVariables("comment", "words", $languageType); ?></a>
              </div>
              <div class="meta-line">
                <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>"><?php echo $readNews["newsDisplay"]; ?> <?php echo languageVariables("views", "words", $languageType); ?></a>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php } else { echo alert(languageVariables("alertNotNews", "home", $languageType), "warning", "0", "/"); } ?>
      </div>
    </div>
</div>
<?php } ?>