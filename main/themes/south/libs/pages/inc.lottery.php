<style type="text/css">
<?php if ($_SESSION["themeModeType"] == "dark") { ?>
<?php if ($readTheme["themeColor"] == "0") { ?>
.row {margin-left: 0 !important;margin-right: 0 !important;}:root {--default-white: 22 22 22;--default-indigo-200: 44 44 44;--default-indigo-300: 33 33 33;--default-indigo-400: 56 56 56;--default-indigo-500: 33 33 33;}.contest-sidebar__cart {color: #fff !important;}.quantity input {background-color: transparent !important;color: #fff !important;}.card {background-color: rgb(var(--default-white)) !important;padding: 4rem 1rem 1rem 1rem !important;margin-bottom: 2.5rem;}.lottery-counter-count-item {background-color: rgb(var(--default-indigo-500)) !important;color: #fff !important;}.lottery-counter-count-item.coin{background-color: transparent !important;color: #fff !important;}.lottery-counter-title {background-color: rgb(var(--default-white)) !important;color: #595858 !important;}.lottery-counter {border: 5px solid #595858 !important;}
<?php } else if ($readTheme["themeColor"] == "1") { ?>
.row {margin-left: 0 !important;margin-right: 0 !important;}:root {--default-white: 19 23 35;--default-indigo-200: 55 65 87;--default-indigo-300: 29 36 51;--default-indigo-400: 7 13 25;--default-indigo-500: 12 15 23;}.contest-sidebar__cart {color: #fff !important;}.quantity input {background-color: transparent !important;color: #fff !important;}.card {background-color: rgb(var(--default-white)) !important;padding: 4rem 1rem 1rem 1rem !important;margin-bottom: 2.5rem;}.lottery-counter-count-item {background-color: rgb(var(--default-indigo-500)) !important;color: rgb(var(--default-indigo-200)) !important;}.lottery-counter-count-item.coin{background-color: transparent !important;color: rgb(var(--default-indigo-200)) !important;}.lottery-counter-title {background-color: rgb(var(--default-white)) !important;color: #6a7aa3 !important;}.lottery-counter {border: 5px solid #6a7aa3 !important;}.tick-flip-panel {background-color: rgb(var(--default-indigo-500)) !important;}
<?php } ?>
<?php } else if ($_SESSION["themeModeType"] == "light") { ?>
.row {margin-left: 0 !important;margin-right: 0 !important;}:root {--default-gray-200: 222 222 222;--default-white: 255 255 255;--default-indigo-200: 240 240 240;--default-indigo-300: 29 36 51;--default-indigo-400: 230 230 230;--default-indigo-500: 182 182 182;}.contest-sidebar__cart {color: #636363 !important;}.quantity input {background-color: transparent !important;color: #000 !important;}.card {background-color: rgb(var(--default-white)) !important;padding: 4rem 1rem 1rem 1rem !important;margin-bottom: 2.5rem;}.lottery-counter-count-item {background-color: rgb(var(--default-indigo-500)) !important;color: #000 !important;}.lottery-counter-count-item.coin{background-color: transparent !important;color: #000 !important;}.lottery-counter-title {background-color: rgb(var(--default-white)) !important;color: #6a7aa3 !important;}.lottery-counter {border: 5px solid #6a7aa3 !important;}
<?php } ?>
</style>
<link href="https://unpkg.com/@pqina/flip/dist/flip.min.css" rel="stylesheet">
<link href="/main/includes/packages/layouts/lottery/css/edit.css" rel="stylesheet">
<style type="text/css">
<?php if ($_SESSION["themeModeType"] == "dark") { ?>
.tick-flip-panel {color: #fff !important;}
<?php } else if ($_SESSION["themeModeType"] == "light") { ?>
.tick-flip-panel {color: #000 !important;}
<?php } ?>
</style>
<?php
  $searchLottery = $db->query("SELECT * FROM lotterySettings ORDER BY id DESC LIMIT 1");
  $readLottery = $searchLottery->fetch();
  if ($readLottery["status"] == "1") {
    if (date("Y-m-d H:i:s") > $readLottery["starterDate"]) {
      $searchLotteryJoins = $db->prepare("SELECT * FROM lotteryJoins WHERE lotteryPass = ?");
      $searchLotteryJoins->execute(array($readLottery["lotteryPass"]));
      $lotteryJoins = "FALSE";
      if ($searchLotteryJoins->rowCount() > 0) {
        $lotteryJoins = "TRUE";
        $lotteryJoinsCount = $searchLotteryJoins->rowCount();
        $searchLotteryTickets = $db->prepare("SELECT SUM(tickets) AS tickets FROM lotteryJoins WHERE lotteryPass = ?");
        $searchLotteryTickets->execute(array($readLottery["lotteryPass"]));
        $readTotalTickets = $searchLotteryTickets->fetch();
        if ($readTotalTickets["tickets"] == null) {
          $readTotalTickets["tickets"] = 0;
        }
        $totalTickets = $readTotalTickets["tickets"];
        $lotteryAmount = floor(($totalTickets*$readLottery["ticketPrice"])-(($totalTickets*$readLottery["ticketPrice"])*(10/100)));
        $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $number = 0;
        for($i=0; $i<count($numbers); $i++){
          $number += substr_count($lotteryAmount, $numbers[$i]);
        }
        $lotteryReward = str_split($lotteryAmount);
        $searchLotteryLastJoins = $db->prepare("SELECT * FROM lotteryJoins WHERE lotteryPass = ? ORDER BY id DESC LIMIT 4");
        $searchLotteryLastJoins->execute(array($readLottery["lotteryPass"]));
        $searchPlayerTickets = $db->prepare("SELECT * FROM lotteryJoins WHERE userID = ? AND lotteryPass = ?");
        $searchPlayerTickets->execute(array($readAccount["id"], $readLottery["lotteryPass"]));
        if ($searchPlayerTickets->rowCount() > 0) {
          $readPlayerTickets = $searchPlayerTickets->fetch();
          $playerChance = ($readPlayerTickets["tickets"]*100)/$totalTickets;
        }
      }
  
      // WINNER
      if (date("Y-m-d H:i:s") > $readLottery["endDate"]) {
        $randomChance = mt_rand(0, 100);
        $totalChance = 0;
        $searchPlayerChance = $db->prepare("SELECT * FROM lotteryJoins WHERE lotteryPass = ? ORDER BY RAND() DESC");
        $searchPlayerChance->execute(array($readLottery["lotteryPass"]));
        foreach ($searchPlayerChance as $readPlayerChance) {
          $winnerPlayerChance = ($readPlayerChance["tickets"]*100)/$totalTickets;
          $totalChance += $winnerPlayerChance;
          if ($totalChance > $randomChance) {
            $winnerID = $readPlayerChance["userID"];
            $winnerUsername = $readPlayerChance["username"];
            $winnerTickets = $readPlayerChance["tickets"];
            $winnerAmount = $lotteryAmount;
            $winnerChance = $winnerPlayerChance;
            break;
          }
        }
        $updateWinnerAccount = $db->prepare("UPDATE accounts SET credit = credit + ? WHERE id = ?");
        $updateWinnerAccount->execute(array($winnerAmount, $winnerID));
        $insertLotteryWinners = $db->prepare("INSERT INTO lotteryWinners (`userID`, `username`, `amount`, `tickets`, `chance`, `lotteryPass`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertLotteryWinners->execute(array($winnerID, $winnerUsername, $winnerAmount, $winnerTickets, $winnerChance, $readLottery["lotteryPass"], date("m.d.Y H:i:s")));
        if ($readLottery["extraGiftStatus"] == "1" && $readLottery["extraGift"] == "[]") {
          $searchLotteryGifts = json_decode($readLottery["extraGift"], true);
          foreach ($searchLotteryGifts as $readLotteryGift) {
            if ($readLotteryGift["type"] == "0") {
              $variables = "{\"credit\": \"".$readLotteryGift["reward"]."\", \"image\": \"/assets/uploads/images/upload/coin.png\"}";
              inventoryAddItem($winnerID, "1", $variables, date("d.m.Y H:i:s"));
            } else if ($readLotteryGift["type"] == "1") {
              $variables = "{\"productID\": \"".$readLotteryGift["reward"]."\", \"image\": \"/assets/uploads/images/upload/gift-box.png\"}";
              inventoryAddItem($winnerID, "2", $variables, date("d.m.Y H:i:s"));
            }
          }
        }
        $updateLottery = $db->prepare("UPDATE lotterySettings SET status = ? WHERE lotteryPass = ?");
        $updateLottery->execute(array(0, $readLottery["lotteryPass"]));
        go("/lottery");
      }
?>
<div class="content-grid row md:p-10 mb-10" style="padding-top: 7rem !important;">
  <div class="col-md-8">
    <div class="card p-10">
      <div class="lottery-counter mt-10">
        <p class="lottery-counter-title"><?php echo languageVariables("title", "lottery", $languageType); ?></p>
        <div class="lottery-counter-count">
          <span class="lottery-counter-count-item coin"><i class="fas fa-coins"></i></span>
          <?php if ($number > 0) { ?>
          <?php for ($i = 0; $i <= $number-1; $i++) { ?>
          <span class="lottery-counter-count-item"><?php echo $lotteryReward[$i]; ?></span>
          <?php } ?>
          <?php } else { ?>
          <span class="lottery-counter-count-item">0</span>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if ($lotteryJoins == "TRUE" && $searchLotteryLastJoins->rowCount() > 0) { ?>
    <div class="card p-10 mt-10 mb-10">
      <div class="lottery-last-joins">
        <p class="lottery-last-joins-title"><?php echo languageVariables("lastTickets", "lottery", $languageType); ?></p>
        <div class="lottery-last-join-items">
          <?php foreach ($searchLotteryLastJoins as $readLotteryLastJoins) { ?>
          <div class="lottery-last-join-item shadow-sm">
            <img src="https://mc-heads.net/body/<?php echo $readLotteryLastJoins["username"]; ?>" width="">
            <div class="lottery-last-join-item-content">
              <p class="lottery-last-join-item-title"><?php echo $readLotteryLastJoins["username"]; ?></p>
              <p class="lottery-last-join-item-text"><?php echo checkTime($readLotteryLastJoins["date"]); ?></p>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-4">
    <?php if (isset($_SESSION["incAccountLogin"])) { ?>
    <div class="lottery-player-tickets">
      <img src="https://cdn-icons-png.flaticon.com/512/1929/1929255.png">
      <p class="lottery-player-ticket-title"><?php echo languageVariables("youTicket", "lottery", $languageType); ?></p>
      <p class="lottery-player-ticket-text"><?php echo (($readPlayerTickets["tickets"] == NULL) ? "0" : $readPlayerTickets["tickets"])." ".languageVariables("count", "words", $languageType); ?></p>
    </div>
    <?php } ?>
    <div class="contest-sidebar">
      <div class="contest-sidebar__cart">
        <div class="clock-wrapper">
          <div class="tick" data-did-init="starterCounter">
            <div data-repeat="true" data-layout="horizontal fit" data-transform="preset(d, h, m, s) -> delay">
              <div class="tick-group">
                <div data-key="value" data-repeat="true" data-transform="pad(00) -> split -> delay">
                  <span data-view="flip"></span>
                </div>
                <span data-key="label" data-view="text" class="tick-label"></span>
              </div>
            </div>
          </div>
        </div>
        <h4 class="title"><?php echo languageVariables("youChance", "lottery", $languageType); ?> (<?php echo number_format($playerChance, 2)."%"; ?>)</h4>
        <div class="ticket-amount">
          <span class="left">0</span>
          <span class="right"><?php echo $totalTickets; ?></span>
          <div class="progressbar" data-perc="<?php echo $playerChance; ?>%">
            <div class="bar" style="width: <?php echo $playerChance; ?>%;"></div>
          </div>
          <p><?php echo (($totalTickets > 0) ? str_replace("&count", $lotteryJoinsCount, languageVariables("totalUsers", "lottery", $languageType)) : ""); ?></p>
        </div>
        <div class="ticket-price text-center">
          <span class="amount"><?php echo languageVariables("currencyIcon", "words", $languageType).number_format($readLottery["ticketPrice"], 2); ?></span>
          <small><?php echo languageVariables("perTicket", "lottery", $languageType); ?></small>
        </div>
        <div class="select-quantity">
          <div class="quantity">
            <input lottery-ticket="number" type="number" min="0" max="1000" step="1" value="5">
            <div class="quantity-nav">
              <div class="quantity-button quantity-down" lottery-ticket="minus"><i class="fas fa-minus"></i></div>
              <div class="quantity-button quantity-up" lottery-ticket="plus"><i class="fas fa-plus"></i></div>
            </div>
          </div>
        </div><!-- select-quantity end -->
        <div class="bottom">
          <a lottery-ticket="purchase" class="button primary w-50 text-white"><?php echo languageVariables("purchaseTicket", "lottery", $languageType); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else { ?>
  <!-- STARTER DATE -->
<div class="content-grid row md:p-10 mb-10" style="padding-top: 7rem !important;">
  <div class="col-md-12 mt-10">
    <div class="tick" data-did-init="starterCounter">
      <div data-repeat="true" data-layout="horizontal fit" data-transform="preset(d, h, m, s) -> delay">
        <div class="tick-group">
          <div data-key="value" data-repeat="true" data-transform="pad(00) -> split -> delay">
            <span data-view="flip"></span>
          </div>
          <span data-key="label" data-view="text" class="tick-label"></span>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } ?>
<script type="text/javascript">
  var $lotteryEndTime = "<?php echo str_replace(" ", "T", $readLottery["endDate"]); ?>";
  var $ticketPrice = "<?php echo $readLottery["ticketPrice"]; ?>";
</script>
<?php } else { ?>
<?php
  $searchLotteryWinnersOne = $db->query("SELECT * FROM lotteryWinners ORDER BY id DESC LIMIT 1");
  if ($searchLotteryWinnersOne->rowCount() > 0) {
    $readLotteryWinnerOne = $searchLotteryWinnersOne->fetch();
    $searchLotteryWinners = $db->prepare("SELECT * FROM lotteryWinners WHERE id != ? ORDER BY id DESC LIMIT 3");
    $searchLotteryWinners->execute(array($readLotteryWinnerOne["id"]));
?>
<div class="content-grid row md:p-10 mb-10" style="padding-top: 7rem !important;">
  <div class="col-md-4">
    <div class="badge-item-stat">
      <p class="text-sticker">
        <svg class="text-sticker-icon icon-plus-small">
          <use xlink:href="#svg-plus-small"></use>
        </svg>
        <?php echo $readLotteryWinnerOne["amount"]." ".$rSettings["creditName"]; ?>
      </p>

      <img class="badge-item-stat-image-preview" src="/assets/uploads/images/upload/lucky-block.png" width="60" alt="badge-bronze-s">

      <img class="badge-item-stat-image" src="https://minotar.net/bust/<?php echo $readLotteryWinnerOne["username"]; ?>/70" alt="badge-bronze-b">

      <p class="badge-item-stat-title"><?php echo $readLotteryWinnerOne["username"]; ?></p>
      <p class="badge-item-stat-text"><?php echo languageVariables("winnerTitle", "lottery", $languageType); ?> (<?php echo languageVariables("lucky", "lottery", $languageType); ?>: <?php echo number_format($readLotteryWinnerOne["chance"], 2)."%"; ?>)</p>

      <div class="progress-stat">
        <div id="badge-bronze" class="progress-stat-bar"></div>

        <div class="bar-progress-wrap">
          <p class="bar-progress-info negative center" style="display: none;"><span class="bar-progress-text no-space"></span></p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="widget-box no-padding">
      <p class="widget-box-title"><?php echo languageVariables("prevs", "lottery", $languageType); ?></p>
      <div class="widget-box-content small-margin-top padded-for-scroll small" data-simplebar>
		<?php if ($searchLotteryWinners->rowCount() > 0) { ?>
        <div class="exp-line-list scroll-content">
		  <?php foreach($searchLotteryWinners as $readLotteryWinner) { ?>
          <div class="exp-line">
            <svg class="exp-line-icon icon-badges">
              <use xlink:href="#svg-badges"></use>
            </svg>

            <p class="text-sticker small-text">
              <svg class="text-sticker-icon icon-plus-small">
                <use xlink:href="#svg-plus-small"></use>
              </svg>
              <?php echo $readLotteryWinner["amount"]." ".$rSettings["creditName"]; ?>
            </p>
            <p class="exp-line-text"><?php echo $readLotteryWinner["username"]; ?></p>

            <p class="exp-line-timestamp"><?php echo checkTime($readLotteryWinner["date"], 2, true); ?></p>
          </div>
		  <?php } ?>
        </div>
		<?php } else { echo "<div style='padding: 1rem;'>".alert(languageVariables("alertWinnerHistory", "lottery", $languageType), "danger", "0", "/")."</div>"; } ?>
      </div>
    </div>
  </div>
</div>
<?php } else { echo alert(languageVariables("alertWinnerHistory", "lottery", $languageType), "danger", "0", "/"); } ?>
<?php } ?>