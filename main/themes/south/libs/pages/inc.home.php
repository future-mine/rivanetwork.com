<?php
if (isset($_GET["news"])) {
  if (!is_numeric(get("news"))) {
    $_GET["news"] = 1;
  }
  $newsPage = intval(get("news"));
} else {
  $newsPage = 1;
}

$newsCount = $db->prepare("SELECT * FROM newsList ORDER BY id");
$newsCount->execute();
$newsItemsCount = $newsCount->rowCount();
$sectionPageItemCount = ceil($newsItemsCount/3);

if ($newsPage > $sectionPageItemCount) {
  $newsPage = 1;
}

$newsPageSubCount = 3;
$newsPageItemCount = $newsPage * $newsPageSubCount - $newsPageSubCount;
// PC
if ($newsPage == $sectionPageItemCount || $newsPage == 1) {
  $sectionMaxPageItemCount = 5;
} else {
  $sectionMaxPageItemCount = 4;
}

// MOBILE
if ($newsPage == $sectionPageItemCount || $newsPage == 1) {
  $sectionMaxPageItemCountMobile = 2;
} else {
  $sectionMaxPageItemCountMobile = 1;
}
?>
<style type="text/css">
  #section-page-bar-pc {
    display: block;
  }

  #section-page-bar-mobile {
    display: none;
  }

  @media (max-width: 720px) {
    #section-page-bar-pc {
      display: none;
    }

    #section-page-bar-mobile {
      display: block;
    }
  }
</style>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
  <!-- BROADCAST -->
  <?php 
  if ($readModule["broadcastStatus"] == "1") {
    $searchBroadcast = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT 4");
    if ($searchBroadcast->rowCount() > 0) {
  ?>
  <div class="grid grid-3-3-3-3 centered">
    <?php foreach ($searchBroadcast as $readBroadcast) { ?>
    <a class="album-preview" href="<?php echo $readBroadcast["url"]; ?>" onclick="broadcastHits('<?php echo $readBroadcast["id"]; ?>')">
      <figure class="album-preview-image liquid">
        <img src="<?php echo $readBroadcast["image"]; ?>" alt="<?php echo $readBroadcast["title"]; ?>">
      </figure>
      <p class="text-sticker small negative"><?php echo $readBroadcast["hits"]; ?></p>
      <div class="album-preview-info">
        <p class="album-preview-title"><?php echo $readBroadcast["title"]; ?></p>
        <p class="album-preview-text"><?php echo checkTime($readBroadcast["date"]); ?></p>
      </div>
    </a>
    <?php } ?>
  </div>
  <?php } } ?>
  <!-- /BROADCAST -->
  <div class="grid <?php echo (($readModule["sidebarStatus"] == "1") ? "grid-3-6-3" : "grid-12"); ?> mobile-prefer-content">
    <?php
    // TOP DONATION
    $topDonation = $db->query("SELECT * FROM creditHistory ORDER BY amount DESC LIMIT 1");
    $readTopDonation = $topDonation->fetch();
    
    // TOP DONATOR    
    $secondsPassed = time()-date('d')*86400;
    $topTotalCredit = $db->prepare("SELECT SUM(amount) as amount, username FROM creditHistory WHERE timeStamp > ? AND type = ? GROUP BY username ORDER BY amount DESC LIMIT 1");
    $topTotalCredit->execute(array($secondsPassed, 0));
    if ($topTotalCredit->rowCount() > 0) {
      $readTopTotalCredit = $topTotalCredit->fetch();
      $topDonatorCreditAmount = $db->prepare("SELECT * FROM creditHistory WHERE timeStamp > ? AND username = ? AND type = ?");
      $topDonatorCreditAmount->execute(array($secondsPassed, $readTopTotalCredit["username"], 0));
      $topDonatorAmount = $topDonatorCreditAmount->rowCount();
    }
    
    // TOP PRODUCT RATES
    $productRatesTop = $db->query("SELECT P.*, COUNT(*) AS rates FROM productRates R INNER JOIN categoryProduct P ON R.productID = P.id GROUP BY P.id ORDER BY rates DESC LIMIT 1");
    ?>
    <?php if ($readModule["sidebarStatus"] == "1") { ?>
    <!-- SIDEBAR LEFT -->
    <div class="grid-column">
      <div class="widget-box">
        <div class="widget-box-controls">
          <div id="badge-stat-slider-controls" class="slider-controls">
            <div class="slider-control left">
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
            <div class="slider-control right">
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
          </div>
        </div>
        <p class="widget-box-title"><?php echo languageVariables("topTitle", "home", $languageType); ?></p>
        <div class="widget-box-content">
          <?php if ($topDonation->rowCount() > 0 || $topTotalCredit->rowCount() > 0 || $productRatesTop->rowCount() > 0) { ?>
          <div id="badge-stat-slider-items" class="widget-box-content-slider">
            <?php if ($topDonation->rowCount() > 0) { ?>
            <div class="widget-box-content-slider-item">
              <div class="badge-item-stat void">
                <p class="text-sticker">
                  <svg class="text-sticker-icon icon-plus-small">
                    <use xlink:href="#svg-plus-small"></use>
                  </svg>
                  <?php echo $readTopDonation["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?>
                </p>
                <img class="badge-item-stat-image" src="https://minotar.net/bust/<?php echo $readTopDonation["username"]; ?>/100.png" width="80" height="80" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readTopDonation["username"]; ?>">
                <p class="badge-item-stat-title"><?php echo $readTopDonation["username"]; ?></p>
                <p class="badge-item-stat-text"><?php echo str_replace("&amount", $readTopDonation["amount"], languageVariables("topDonationText", "home", $languageType)); ?></p>
                <div class="progress-stat medium">
                  <div class="bar-progress-wrap">
                    <p class="bar-progress-info negative center"><span class="bar-progress-text no-space"></span></p>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if ($productRatesTop->rowCount() > 0) { ?>
            <?php $readPRT = $productRatesTop->fetch(); ?>
            <div class="widget-box-content-slider-item">
              <div class="badge-item-stat void">
                <p class="text-sticker">
                  <svg class="text-sticker-icon icon-plus-small">
                    <use xlink:href="#svg-plus-small"></use>
                  </svg>
                  <?php echo $readPRT["price"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?>
                </p>
                <img class="badge-item-stat-image" src="<?php echo $readPRT["image"]; ?>" width="120" height="120" alt="Popüler Ürün - <?php echo $readPRT["name"]; ?>">
                <p class="badge-item-stat-title"><?php echo $readPRT["name"]; ?></p>
                <p class="badge-item-stat-text"><?php echo str_replace("&product", $readPRT["name"], languageVariables("topProductText", "home", $languageType)); ?></p>
                <div class="progress-stat medium">
                  <div class="bar-progress-wrap">
                    <p class="bar-progress-info negative center"><span class="bar-progress-text no-space"></span></p>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if ($topTotalCredit->rowCount() > 0) { ?>
            <div class="widget-box-content-slider-item">
              <div class="badge-item-stat void">
                <p class="text-sticker">
                  <svg class="text-sticker-icon icon-plus-small">
                    <use xlink:href="#svg-plus-small"></use>
                  </svg>
                  <?php echo $readTopTotalCredit["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?>
                </p>
                <img class="badge-item-stat-image" src="https://minotar.net/bust/<?php echo $readTopTotalCredit["username"]; ?>/100.png" width="80" height="80" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readTopTotalCredit["username"]; ?>">
                <p class="badge-item-stat-title"><?php echo $readTopTotalCredit["username"]; ?></p>
                <p class="badge-item-stat-text"><?php echo str_replace(array("&total", "&amount"), array($topDonatorAmount, $readTopTotalCredit["amount"]), languageVariables("monthTopCreditText", "home", $languageType)); ?></p>
                <div class="progress-stat medium">
                  <div class="bar-progress-wrap">
                    <p class="bar-progress-info negative center"><span class="bar-progress-text no-space"></span></p>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php } else { echo alert(languageVariables("alertNotTop", "home", $languageType), "warning", "0", "/"); } ?>
        </div>
      </div>
      <iframe src="https://discordapp.com/widget?id=<?php echo $rMedia["widget"]; ?>&theme=<?php echo $_SESSION["themeModeType"]; ?>" width="100%" height="500" frameborder="0" allowtransparency="true"></iframe>
    </div>
    <!-- /SIDEBAR LEFT -->
    <?php } ?>

    <!-- NEWS -->
    <div class="grid-column">
      <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT $newsPageItemCount, $newsPageSubCount"); ?>
      <?php if ($searchNews->rowCount() > 0) { ?>
      <?php foreach ($searchNews as $readNews) { ?>
      <div class="post-preview">
        <figure class="post-preview-image liquid">
          <img src="<?php echo $readNews["image"]; ?>" alt="<?php echo languageVariables("blog", "words", $languageType); ?> - <?php echo $readNews["title"]; ?>">
        </figure>
        <div class="post-preview-info fixed-height">
          <div class="post-preview-info-top">
            <p class="post-preview-timestamp"><?php echo checkTime($readNews["date"]); ?></p>
            <p class="post-preview-title"><?php echo $readNews["title"]; ?></p>
          </div>
          <div class="post-preview-info-bottom">
            <p class="post-preview-text"><?php echo contentShort(strip_tags($readNews["text"]), 300); ?></p>
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
      <?php if ($searchNews->rowCount() > 0) { ?>
      <div id="section-page-bar-pc">
        <div class="section-pager-bar" style="width: <?php if ($sectionPageItemCount == "1") { echo "175px"; } else if ($sectionPageItemCount == "2") { echo "250px"; } else if ($sectionPageItemCount == "3") { echo "305px"; } else if ($sectionPageItemCount == "4") { echo "370px"; } else if ($sectionPageItemCount == "5") { echo "435px"; } else if ($sectionPageItemCount == "6") { echo "495px"; } ?>;">
          <div class="section-pager">
            <?php
            for ($i = $newsPage - $sectionMaxPageItemCount; $i < $newsPage + $sectionMaxPageItemCount + $newsPage; $i++) {
              if ($i > 0 and $sectionPageItemCount >= $i) {
            ?>
            <a class="section-pager-item <?php if ($newsPage == $i) { echo "active"; } ?>" href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $i; ?>">
              <p class="section-pager-item-text"><?php if (9 >= $i) { echo "0".$i; } else { echo $i; } ?></p>
            </a>
            <?php } } ?>
          </div>
          <div class="section-pager-controls">
            <button type="button" class="slider-control left" <?php if ($newsPage !== 1) { ?>onclick="window.location.href='<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage-1; ?>'" <?php } else { echo "disable='disabled'"; } ?>>
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </button>
            <button type="button" class="slider-control right" <?php if ($sectionPageItemCount == $newsPage) { echo "disable='disabled'"; } else { ?>onclick="window.location.href='<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage+1; ?>'" <?php } ?>>
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <div id="section-page-bar-mobile">
        <div class="section-pager-bar" style="width: <?php if ($sectionPageItemCount == "1") { echo "175px"; } else if ($sectionPageItemCount == "2") { echo "250px"; } ?>;">
          <div class="section-pager">
            <?php
            for ($i = $newsPage - $sectionMaxPageItemCountMobile; $i < $newsPage + $sectionMaxPageItemCountMobile + $newsPage; $i++) {
              if ($i > 0 and $sectionPageItemCount >= $i) {
            ?>
            <a class="section-pager-item <?php if ($newsPage == $i) { echo "active"; } ?>" href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $i; ?>">
              <p class="section-pager-item-text"><?php if (9 >= $i) { echo "0".$i; } else { echo $i; } ?></p>
            </a>
            <?php } } ?>
          </div>
          <div class="section-pager-controls">
            <button type="button" class="slider-control left" <?php if ($newsPage !== 1) { ?>onclick="window.location.href='<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage-1; ?>'" <?php } else { echo "disable='disabled'"; } ?>>
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </button>
            <button type="button" class="slider-control right" <?php if ($sectionPageItemCount == $newsPage) { echo "disable='disabled'"; } else { ?>onclick="window.location.href='<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage+1; ?>'" <?php } ?>>
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <!-- /NEWS -->
    
    <?php if ($readModule["sidebarStatus"] == "1") { ?>
    <!-- SIDEBAR LEFT -->
    <div class="grid-column">
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchStoreHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <p class="widget-box-title"><?php echo languageVariables("storeHistoryTitle", "home", $languageType); ?></p>
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
            <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
            <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
            <?php $readServerList = $searchServerList->fetch(); ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readStoreHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&serverID", "&serverName", "&productName"), array($readStoreHistory["username"], $readStoreHistory["serverID"], $readServerList["name"], $readStoreHistory["productName"]), languageVariables("storeHistoryText", "home", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkTime($readStoreHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("storeHistoryAlert", "home", $languageType), "warning", "0", "/"); } ?>

      <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchCreditHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <p class="widget-box-title"><?php echo languageVariables("creditHistoryTitle", "home", $languageType); ?></p>
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readCreditHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <?php if ($readCreditHistory["method"] == 0) { $paymentMethodText = languageVariables("paymentMobile", "words", $languageType); } else if ($readCreditHistory["method"] == 1) { $paymentMethodText = languageVariables("paymentCredit", "words", $languageType); } ?>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&method", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readCreditHistory["username"]."\">".$readCreditHistory["username"]."</a>", $paymentMethodText, $readCreditHistory["amount"]), languageVariables("creditHistoryText", "home", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkTime($readCreditHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("creditHistoryAlert", "home", $languageType), "warning", "0", "/"); } ?>
    </div>
    <!-- /SIDEBAR LEFT -->
    <?php } ?>
  </div>
</div>