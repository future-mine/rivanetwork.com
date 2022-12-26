<link rel="stylesheet" href="/main/includes/packages/layouts/card/css/themes/sitary/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
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
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
  <?php if ($cardGameRowCount > 1) { ?>
  <div class="grid grid-4-4 centered">
    <div class="grid-column">
      <nav class="section-navigation">
        <center>
          <div id="section-navigation-slider" class="section-menu">
            <?php foreach ($searchCardGames as $readCardGames) { ?>
            <a class="section-menu-item <?php if ($readCardGames["id"] == $readCardGame["id"]) { echo "active"; } ?>" href="<?php echo urlConverter("card_game", $languageType); ?>/<?php echo createSlug($readCardGames["name"]); ?>/<?php echo $readCardGames["id"]; ?>">
              <svg class="section-menu-item-icon icon-<?php if ($readCardGames["type"] == "1") { echo "revenue"; } else if ($readCardGames["type"] == "0") { echo "clock"; } ?>">
                <use xlink:href="#svg-<?php if ($readCardGames["type"] == "1") { echo "revenue"; } else if ($readCardGames["type"] == "0") { echo "clock"; } ?>"></use>
              </svg>
              <p class="section-menu-item-text"><?php if ($readCardGames["type"] == "1") { echo $readCardGames["name"]." (".$readCardGames["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGames["type"] == "0") { echo $readCardGames["name"]." (".$readCardGames["hours"]." ".languageVariables("hours", "words", $languageType).")"; } ?></p>
            </a>
            <?php } ?>
          </div>
        </center>
        <div id="section-navigation-slider-controls" class="slider-controls">
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
      </nav>
    </div>
  </div>
  <?php } ?>
  <div class="grid grid-9-3">
    <!-- CARD GAME -->
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("cardGame", "words", $languageType); ?></p>
          <h2 class="section-title"><?php if ($readCardGame["type"] == "1") { echo $readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGame["type"] == "0") { echo $readCardGame["name"]." (".$readCardGame["hours"]." ".languageVariables("onceHour", "cardGame", $languageType).")"; } ?></h2>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-box-content">
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
            <p class="widget-box-text"><?php echo str_replace(["&credit"], [$readCardGame["price"]], languageVariables("gameTextCredit", "cardGame", $languageType)); ?></p>
            <?php } else if ($readCardGame["type"] == "0") { ?>
            <p class="widget-box-text"><?php echo str_replace(["&hours"], [$readCardGame["hours"]], languageVariables("gameTextHours", "cardGame", $languageType)); ?></p>
            <?php } ?>
            <button type="button" id="play-button" class="mt-2 button w-25 primary"><?php echo languageVariables("game", "words", $languageType); ?></button>
          </center>
        </div>
      </div>
    </div>
    <!-- /CARD GAME -->
      
    <!-- CARD GAME HISTORY -->
    <?php
    $searchCardGameHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE cardID = ? ORDER BY id DESC LIMIT 6");
    $searchCardGameHistory->execute(array($readCardGame["id"]));
    ?>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("cardGame", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("historyTitle", "cardGame", $languageType); ?></h2>
        </div>
      </div>
      <?php if ($searchCardGameHistory->rowCount() > 0) { ?>
  	<div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchCardGameHistory as $readCardGameHistory) { ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readCardGameHistory["username"]; ?>">
              	<img src="https://minotar.net/bust/<?php echo $readCardGameHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <?php if ($readCardGameHistory["rewardType"] == "winner") { ?>
              <p class="user-status-title"><?php echo str_replace(["&username", "&reward"], [$readCardGameHistory["username"],$readCardGameHistory["reward"]], languageVariables("historyWinnerText", "cardGame", $languageType)); ?></p>
              <?php } else if ($readCardGameHistory["rewardType"] == "loser") { ?>
              <p class="user-status-title"><?php echo str_replace(["&username", "&reward"], [$readCardGameHistory["username"],$readCardGameHistory["reward"]], languageVariables("historyLoserText", "cardGame", $languageType)); ?></p>
              <?php } ?>
              <p class="user-status-timestamp"><?php echo checkTime($readCardGameHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertNotGame", "cardGame", $languageType), "warning", "0", "/"); } ?>
    </div>
    <!-- /CARD GAME HISTORY -->
  </div>
</div>
<script type="text/javascript">
var cardID = "<?php echo $readCardGame["id"]; ?>";
<?php if ($_SESSION["themeModeType"] == "light") { ?>
var cardGameBackground = "#fff";
<?php } else if ($_SESSION["themeModeType"] == "dark") { ?>
var cardGameBackground = "#1d2333";
<?php } ?>
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