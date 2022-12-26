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
<?php if ($readModule["homeBarType"] == "1") { ?>
<style type="text/css">
.m-card{width:100%;height:230px;background:linear-gradient(90deg,#5266bf 0,rgba(55,66,122,.7723320117895154) 100%,#00d4ff 100%);border-bottom:4px solid #36427b;border-radius:10px;color:#cbd1e5}.m-card img{width:75px;height:80px;margin-left:6.5rem;text-align:center;justify-content:center;align-items:center;margin-top:-2rem}.m-card .m-card-title{text-align:center;align-items:center;justify-content:center;margin-top:1rem;padding-left:15px;padding-right:15px;font-size:24px;font-weight:700;color:#cbd1e5}.m-card .m-card-description{text-align:center;align-items:center;justify-content:center;margin-top:1rem;padding-left:15px;padding-right:15px;font-size:18px;font-weight:500;color:#cbd1e5}@media (max-width: 780px){.m-card img{margin-left:9rem;}}
</style>
<?php } ?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
  <!-- BROADCAST -->
  <?php if ($readModule["homeBarType"] == "0") { ?>
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
  <?php } else if ($readModule["homeBarType"] == "1") { ?>
  <?php
    // TOP DONATION 
    $secondsPassed = time()-date('d')*86400;
    $topDonation = $db->prepare("SELECT amount, username FROM creditHistory WHERE timeStamp > ? AND type = ? GROUP BY username ORDER BY amount DESC LIMIT 1");
    $topDonation->execute(array($secondsPassed, 0));
    $readTopDonation = $topDonation->fetch();
    
    // TOP DONATOR   
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
    $searchLastRegister = $db->query("SELECT * FROM accounts ORDER BY id DESC LIMIT 1");
  ?>
  <?php if ($topDonation->rowCount() > 0 || $topTotalCredit->rowCount() > 0 || $productRatesTop->rowCount() > 0 || $searchLastRegister->rowCount() > 0) { ?>
  <div class="grid grid-3-3-3-3 centered">
    <?php if ($topDonation->rowCount() > 0) { ?>
    <div class="m-card">
      <img src="https://minotar.net/bust/<?php echo $readTopDonation["username"]; ?>/100.png" alt="Avatar - <?php echo $readTopDonation["username"]; ?>">
      <p class="m-card-title"><?php echo $readTopDonation["username"]; ?></p>
      <p class="m-card-description"><?php echo str_replace("&amount", $readTopDonation["amount"], languageVariables("topDonationText", "home", $languageType)); ?></p>
    </div>
    <?php } ?>
    <?php if ($topTotalCredit->rowCount() > 0) { ?>
    <div class="m-card">
      <img src="https://minotar.net/bust/<?php echo $readTopTotalCredit["username"]; ?>/100.png" alt="Avatar - <?php echo $readTopTotalCredit["username"]; ?>">
      <p class="m-card-title"><?php echo $readTopTotalCredit["username"]; ?></p>
      <p class="m-card-description"><?php echo str_replace(array("&total", "&amount"), array($topDonatorAmount, $readTopTotalCredit["amount"]), languageVariables("monthTopCreditText", "home", $languageType)); ?></p>
    </div> 
    <?php } ?>
    <?php if ($productRatesTop->rowCount() > 0) { ?>
    <?php $readPRT = $productRatesTop->fetch(); ?>
    <div class="m-card">
      <img src="<?php echo $readPRT["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readPRT["name"]; ?>">
      <p class="m-card-title"><?php echo $readPRT["name"]; ?></p>
      <p class="m-card-description"><?php echo str_replace("&product", $readPRT["name"], languageVariables("topProductText", "home", $languageType)); ?></p>
    </div> 
    <?php } ?>
    <?php if ($searchLastRegister->rowCount() > 0) { ?>
    <?php $readLastRegister = $searchLastRegister->fetch(); ?>
    <div class="m-card">
      <img src="https://minotar.net/bust/<?php echo $readLastRegister["username"]; ?>/100.png" alt="Avatar - <?php echo $readLastRegister["username"]; ?>">
      <p class="m-card-title"><?php echo $readLastRegister["username"]; ?></p>
      <p class="m-card-description"><?php echo str_replace("&serverName", $rSettings["serverName"], languageVariables("registerHistoryText", "home", $languageType)); ?></p>
    </div>
    <?php } ?>
  </div>
  <?php } ?>
  <?php } ?>
  <!-- /BROADCAST -->
  <div class="grid <?php echo (($readModule["sidebarStatus"] == "1") ? "grid-9-3" : "grid-12"); ?> mobile-prefer-content">
    <!-- NEWS -->
    <div class="grid-column">
    
      <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT $newsPageItemCount, $newsPageSubCount"); ?>
      <?php if ($searchNews->rowCount() > 0) { ?>
      <?php foreach ($searchNews as $readNews) { ?>
      <div class="m-article">
        <div class="m-article-thumbnail" style="background: url('<?php echo $readNews["image"]; ?>');">
        </div>
        <div class="m-article-info">
          <div class="m-article-info-detail">
            <p class="m-article-date"><?php echo checkTime($readNews["date"], 2, true); ?></p>
            <p class="m-article-title"><?php echo $readNews["title"]; ?></p>
            <p class="m-article-description"><?php echo contentShort(strip_tags($readNews["text"]), 200); ?></p>
            <div class="m-article-detail">
              <?php $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?"); ?>
              <?php $searchNewsComments->execute(array($readNews["id"], 1)); ?>
              <?php $newsCommentsRow = $searchNewsComments->rowCount(); ?>
              <p class="m-article-icon"><i class="mdi mdi-eye"></i><?php echo $readNews["newsDisplay"]; ?></p>
              <p class="m-article-icon"><i class="mdi mdi-message"></i><?php echo $newsCommentsRow; ?></p>
              <p class="m-article-icon"><i class="mdi mdi-heart"></i><?php echo $readNews["newsHearts"]; ?></p>
            </div>
          </div>
          <div class="m-article-footer">
            <a class="m-article-footer-text" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>"><i class="mdi mdi-arrow-right"></i><?php echo languageVariables("moreRead", "words", $languageType); ?></a>
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
    <div class="grid-column" id="mobile-sidebar-m">
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchStoreHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <p class="widget-box-title"><?php echo languageVariables("storeHistoryTitle", "home", $languageType); ?> <img class="widget-box-title-icon" src="/main/themes/sitary/theme/assets/img/landing/steve.png"></p>
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
        <p class="widget-box-title"><?php echo languageVariables("creditHistoryTitle", "home", $languageType); ?> <img class="widget-box-title-icon" src="/main/themes/sitary/theme/assets/img/landing/steve4.png"></p>
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
      
      <div class="discordbn">
        <i class="mdi mdi-discord"></i>
        <span server-command="discordServerName">DISCORD</span>
        <div class="dcbn">
          <span server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</span><?php echo languageVariables("onlineUser", "words", $languageType); ?>
        </div>
        <a class="button secondary w-50 btn-orta dc" server-command="discordInstantInvite"><?php echo languageVariables("nowJoin", "words", $languageType); ?></a>
      </div>
    </div>
    <!-- /SIDEBAR LEFT -->
    <?php } ?>
  </div>
</div>