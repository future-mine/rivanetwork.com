<link rel="stylesheet" href="/main/includes/packages/layouts/card/css/themes/dark/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]-213; ?>">
<?php
$cardGame = $db->query("SELECT * FROM cardGame ORDER BY id ASC LIMIT 1");
$searchCardGames = $db->query("SELECT * FROM cardGame ORDER BY id");
$readGame = $cardGame->fetch();
$cardGameRowCount = $searchCardGames->rowCount();
if (isset($_GET["id"])) {
  $searchCardGame = $db->prepare("SELECT * FROM cardGame WHERE id = ?");
  $searchCardGame->execute(array(get("id")));
  if ($searchCardGame->rowCount() > 0) {
    $readCardGame = $searchCardGame->fetch();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("card_game", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php if ($readCardGame["type"] == "1") { echo $readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGame["type"] == "0") { echo $readCardGame["name"]." (".$readCardGame["hours"]." ".languageVariables("onceHour", "cardGame", $languageType).")"; } ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-2 col-12 pt-3 pb-5">
            <ul class="navbar-nav sidebar-nav">
              <?php foreach ($searchCardGames as $readCardGames) { ?>
              <li class="nav-item bg-dark--2 mb-2">
                <a href="<?php echo urlConverter("card_game", $languageType); ?>/<?php echo createSlug($readCardGames["name"]); ?>/<?php echo $readCardGames["id"]; ?>" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100" style="height: auto;">
                  <span class="nav-link-text">
                    <?php echo contentShort($readCardGames["name"], 7); ?>
                  </span>
                  <span class="product-count font-size-5 o-25 mt-1 position-relative">
                    <?php if ($readCardGames["type"] == "1") { echo $readCardGames["price"]." ".languageVariables("credi", "words", $languageType); } else if ($readCardGames["type"] == "0") { echo "".$readCardGames["hours"]." ".languageVariables("hours", "words", $languageType); } ?>
                  </span>
                </a>
              </li>
              <?php } ?>
            </ul>
          </div>
          <div class="col-lg-10 col-12 pt-3 pb-5">
            <div class="bg-dark--3 p-5">
              <div class="d-flex mb-3 justify-content-between align-items-center">
                <h3 class="text-secondary mb-0 font-500 font-size-6 letter-spacing-1 text-uppercase">
                  <?php if ($readCardGame["type"] == "1") { echo $readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGame["type"] == "0") { echo $readCardGame["name"]." (".$readCardGame["hours"]." ".$readCardGame["price"]." ".languageVariables("onceHour", "cardGame", $languageType).")"; } ?>
                </h3>
              </div>
              <div class="row card-game">
                <div id="card-game-visible" class="visible"></div>
                <?php for ($i = 1; $i <= 8; $i++) { ?>
                <div class="col-sm-3">
                  <div class="card-game-card">
                    <p class="text-sticker"><?php echo $i; ?></p>
                    <div class="card-game-back">
                      <img src="<?php echo $rSettings["serverLogo"]; ?>" alt="<?php echo $rSettings["servername"]; ?> - Logo">
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <center class="mt-5" id="card-game-info">
                <?php if ($readCardGame["type"] == "1") { ?>
                <p><?php echo str_replace(["&credit"], [$readCardGame["price"]], languageVariables("gameTextCredit", "cardGame", $languageType)); ?></p>
                <?php } else if ($readCardGame["type"] == "0") { ?>
                <p><?php echo str_replace(["&hours"], [$readCardGame["hours"]], languageVariables("gameTextHours", "cardGame", $languageType)); ?></p></p>
                <?php } ?>
                <button type="button" id="play-button" class="mt-2 btn text-white col-12 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary w-25"><?php echo languageVariables("game", "words", $languageType); ?></button>
              </center>
            </div>
          </div>
          <div class="col-12 p-0">
            <?php
            $searchCardGameHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE cardID = ? ORDER BY id DESC LIMIT 5");
            $searchCardGameHistory->execute(array($readCardGame["id"]));
            ?>
            <?php if ($searchCardGameHistory->rowCount() > 0) { ?>
              <section class="leaderboards p-1 py-5">
                <div class="container">
                  <div class="row">
                    <div class="col-12 col-lg-3 p-0 pr-lg-5 pt-lg-5">
                    </div>
                    <div class="col-12 col-lg-6 p-0 pl-lg-5 pt-5">
                      <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                        <?php echo languageVariables("cardGameHistory", "words", $languageType); ?>
                      </div>
                      <div class="card-wrapper w-100 mx-auto mt-5 row">
                      <?php foreach ($searchCardGameHistory as $readCardGameHistory) { ?>
                        <div class="col-12 p-1">
                          <div class="card text-white card-leaderboard pt-5">
                            <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                              <div class="mc-skin position-absolute mb-4 center">
                                <div class="mc-skin-img-wrapper mx-auto js-mirror">
                                  <div class="mc-skin-img">
                                    <img src="https://minotar.net/body/<?php echo $readCardGameHistory["username"]; ?>/100.png" alt="<?php echo $readStoreHistory["username"]; ?>">
                                  </div>
                                </div>
                              </div>
                              <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readCardGameHistory["username"]; ?></h5>
                              <?php if ($readCardGameHistory["rewardType"] == "winner") { ?>
                              <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"><?php echo str_replace(["&username", "&reward"], [$readCardGameHistory["username"],$readCardGameHistory["reward"]], languageVariables("historyWinnerText", "cardGame", $languageType)); ?></p>
                              <?php } else if ($readCardGameHistory["rewardType"] == "loser") { ?>
                              <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary"><?php echo str_replace(["&username", "&reward"], [$readCardGameHistory["username"],$readCardGameHistory["reward"]], languageVariables("historyLoserText", "cardGame", $languageType)); ?></p>
                              <?php } ?>
                              <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                                <div class="id position-relative font-900 text-secondary">
                                  <span>
                                    1
                                  </span>
                                </div>
                                <div class="date text-secondary">
                                  <?php echo checkTime($readCardGameHistory["date"]); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="col-12 col-lg-3 p-0 pl-lg-5 pt-5">
                    </div>
                  </div>
                </div>
              </section>
              <?php } else { echo alert(languageVariables("alertNotGame", "cardGame", $languageType), "warning", "0", "/"); } ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var cardID = "<?php echo $readCardGame["id"]; ?>";
  var cardGameBackground = "#111";
</script>
<?php
} else { 
  if ($cardGameRowCount > 0) {
    go(urlConverter("card_game", $languageType)."/".createSlug($readGame["name"])."/".$readGame["id"]);
  } else {
    go(urlConverter("home", $languageType));
  }
}
} else {
  if ($cardGameRowCount > 0) {
    go(urlConverter("card_game", $languageType)."/".createSlug($readGame["name"])."/".$readGame["id"]);
  } else {
    go(urlConverter("home", $languageType));
  }
}
?>