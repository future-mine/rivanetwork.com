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
$sectionPageItemCount = ceil($newsItemsCount/4);

if ($newsPage > $sectionPageItemCount) {
  $newsPage = 1;
}

$newsPageSubCount = 4;
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

<?php if ($readModule["homeBarType"] == "0") { ?>
<?php 
  if ($readModule["broadcastStatus"] == "1") {
    $searchBroadcast = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT 4");
    if ($searchBroadcast->rowCount() > 0) {
  ?>
<div class="swiper-container hero-swiper">
  <div class="swiper-wrapper">
    <?php foreach($searchBroadcast as $readBroadcast) { ?>
    <div class="swiper-slide position-relative" style="background: linear-gradient(to bottom, rgba(25, 25, 25, .9) 0%,rgba(25, 25, 25, .9)  100%),
      url(<?php echo $readBroadcast["image"]; ?>);">
      <div class="container text-center h-100 d-flex align-items-center justify-content-center flex-column">
        <div class="announce-tag font-900 text-white o-15 d-block text-uppercase">
          <span>
          <?php echo languageVariables("notice", "words", $languageType); ?>
          </span>
        </div>
        <h1 class="announce-title d-block text-white font-500">
        </h1>
        <p class="announce-desc d-block o-75 text-white font-100">
          <?php echo $readBroadcast["title"]; ?>
        </p>
        <a href="<?php echo $readBroadcast["url"]; ?>" class="btn line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary mt-1">
          <i class="fas fa-bookmark fa-sm mr-1 btn-icon"></i>
          <span class="btn-text">
          <?php echo languageVariables("moreRead", "words", $languageType); ?>
          </span>
        </a>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="swiper-pagination-wrapper position-relative bg-dark--3 p-2 w-100 d-flex align-items-center justify-content-between justify-content-lg-center">
    <!-- PREV -->
    <div class="swiper-button-prev position-relative mt-0 mr-lg-3 ml-3 text-white d-flex align-items-center">
      <i class="fas fa-arrow-left fa-xs mr-2"></i>
      <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("prev", "words", $languageType); ?></span>
    </div>
    <!-- / PREV -->

    <!-- NUMBERS -->
    <div class="swiper-pagination position-relative font-900 line-height-1 p-2 mt-1 px-3 d-flex align-items-center text-white d-block text-white"></div>
    <!-- / NUMBERS -->

    <!-- NEXT -->
    <div class="swiper-button-next position-relative mt-0 ml-lg-3 mr-3 text-white d-flex align-items-center">
      <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("next", "words", $languageType); ?></span>
      <i class="fas fa-arrow-right fa-xs ml-2"></i>
    </div>
    <!-- / NEXT -->
  </div>
</div>
<?php } } } ?>
<!-- Ana Sayfa -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <section class="leaderboards bg-dark--1 p-1 py-5">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-4 p-0 pr-lg-5 pt-lg-5">
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("storeHistoryTitle", "home", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
                <?php if($searchStoreHistory->rowCount() > 0) { ?>
                <?php foreach($searchStoreHistory as $readStoreHistory) { ?>
                <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
                <?php $readServerList = $searchServerList->fetch(); ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readStoreHistory["username"]; ?>/100.png" alt="<?php echo $readStoreHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readStoreHistory["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"><?php echo $readStoreHistory["productName"]; ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="id position-relative font-900 text-secondary">
                          <span>
                            1
                          </span>
                        </div>
                        <div class="date text-secondary">
                          <?php echo checkTime($readStoreHistory["date"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } } else { echo alert(languageVariables("storeHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
              </div>
            </div>
            <div class="col-12 col-lg-4 p-0 pl-lg-5 pt-5">
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
              <?php echo languageVariables("registerHistoryTitle", "home", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <?php $searchLastRegister = $db->query("SELECT * FROM accounts ORDER BY id DESC LIMIT 5"); ?>
                <?php if ($searchLastRegister->rowCount() > 0) { ?>
                <?php foreach($searchLastRegister as $readLastRegister) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readLastRegister["username"]; ?>/100.png" alt="<?php echo $readStoreHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readLastRegister["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="id position-relative font-900 text-secondary">
                          <span>
                            1
                          </span>
                        </div>
                        <div class="date text-secondary">
                          <?php echo checkTime($readLastRegister["registerDate"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } } else { echo alert(languageVariables("registerHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
              </div>
              <div class="btn-group w-100 p-1 mt-3">
                <a href="<?php echo urlConverter("banned", $languageType); ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 w-100 btn-primary no-blur">
                  <i class="fas fa-sm mr-1 fa-trophy btn-icon"></i>
                  <span class="btn-text"><?php echo languageVariables("bans", "words", $languageType); ?></span>
                </a>
              </div>
            </div>
            <div class="col-12 col-lg-4 p-0 pl-lg-5 pt-5">
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
              <?php echo languageVariables("creditHistoryTitle", "home", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
                <?php if ($searchCreditHistory->rowCount() > 0) { ?>
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readCreditHistory["username"]; ?>/100.png" alt="<?php echo $readCreditHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readCreditHistory["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary turkish-lira"><?php echo $readCreditHistory["amount"]; ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="id position-relative font-900 text-secondary">
                          <span>
                            1
                          </span>
                        </div>
                        <div class="date text-secondary">
                          <?php echo checkTime($readCreditHistory["date"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } } else { echo alert(languageVariables("creditHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-12 p-0">
      <section class="games bg-dark--1 p-1 py-5">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="text-white mb-0 font-500 text-center line-height-0 heading-title">
                <?php echo languageVariables("news", "words", $languageType); ?>
              </h1>
            </div>
            <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT $newsPageItemCount, $newsPageSubCount"); ?>
            <?php if ($searchNews->rowCount() > 0) { ?>
            <?php foreach($searchNews as $readNews) { ?>
            <div class="col-12 col-lg-6">
              <div class="card text-white card-blog pt-4 mt-1">
                <div class="card-body bg-dark--2 p-5 d-flex flex-row align-items-start font-100" style="background-image: linear-gradient(to top, rgba(38,38,38, .95), rgba(38,38,38, .95)),
                                    url('<?php echo $readNews["image"]; ?>')">
                  <img src="<?php echo $readNews["image"]; ?>" alt="" class="rounded-sm">
                  <div class="text-group">
                    <h5 class="card-title px-4 text-left font-400 w-75 mb-0"><?php echo $readNews["title"]; ?></h5>
                    <p class="card-text font-size-6 text-left text-white mt-1 px-4 line-height-1 font-100 o-75"><?php echo contentShort(strip_tags($readNews["text"]), 200); ?></p>

                    <div class="btn-group pl-4">
                      <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                        <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                        <span class="btn-text">
                        <?php echo languageVariables("moreRead", "words", $languageType); ?>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php  } else { ?>
            <?php echo alert(languageVariables("alertNotNews", "home", $languageType), "danger", "0", "/"); ?>
            <?php } ?>
          </div>
        </div>
        <?php if ($searchNews->rowCount() > 0) { ?>
        <div class="container pagination position-relative overflow-hidden bg-dark--2 p-2 w-100 d-flex align-items-center justify-content-between justify-content-lg-center mt-5">
          <a class="prev position-relative mt-0 mr-lg-3 ml-3 text-white d-flex align-items-center <?php if ($newsPage == 1) { echo "disabled"; } ?>" href="<?php echo $newsPage-1; ?>" tabindex="-1">
            <i class="fas fa-arrow-left fa-xs mr-2"></i>
            <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("prev", "words", $languageType); ?></span>
          </a>
          <div class="numbers position-relative font-900 line-height-1 p-2 mt-1 px-3 d-flex align-items-center text-white d-block text-white ">
            <?php
              for ($i = $newsPage - $sectionMaxPageItemCountMobile; $i < $newsPage + $sectionMaxPageItemCountMobile + $newsPage; $i++) {
                if ($i > 0 and $sectionPageItemCount >= $i) {
            ?>
            <a class="<?php if ($newsPage == $i) { echo "active"; } ?>" href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $i; ?>">
              <span class="ml-3">
                <?php if (9 >= $i) { echo "0".$i; } else { echo $i; } ?> </span>
            </a>
            <?php } } ?>
          </div>
          <a class="next position-relative mt-0 ml-lg-3 mr-3 text-white d-flex align-items-center <?php if ($sectionPageItemCount == $newsPage) { echo "disabled"; } ?>" href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage+1; ?>">
            <span class="text-uppercase font-100 line-height-1 mt-1 o-50"><?php echo languageVariables("next", "words", $languageType); ?></span>
            <i class="fas fa-arrow-right fa-xs ml-2"></i>
          </a>
        </div>
        <?php } ?>
      </section>
    </div>
  </div>
</div>