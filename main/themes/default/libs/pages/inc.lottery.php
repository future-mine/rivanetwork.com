<link href="https://unpkg.com/@pqina/flip/dist/flip.min.css" rel="stylesheet">
<link href="/main/includes/packages/layouts/lottery/css/edit.css" rel="stylesheet">
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
        if ($totalTickets > 0) {
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
        }
        $updateLottery = $db->prepare("UPDATE lotterySettings SET status = ? WHERE lotteryPass = ?");
        $updateLottery->execute(array(0, $readLottery["lotteryPass"]));
        go("/lottery");
      }
?>
<div class="row md:p-10 mt-5 mb-10">
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
          <a lottery-ticket="purchase" class="btn btn-primary" style="padding: 1.2rem 2rem 1.2rem 2rem; font-size: 1.3rem;"><?php echo languageVariables("purchaseTicket", "lottery", $languageType); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else { ?>
  <!-- STARTER DATE -->
<div class="row md:p-10 mt-5 mb-10">
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
<div class="relative bg-indigo-600 py-32 overflow-hidden opacity-90">
  <div class="absolute top-0 left-0 w-full h-full bg-indigo-400 opacity-50"></div>
  <div class="relative z-30 container mx-auto">
    <h2 class="font-bold text-4xl text-white ml-3"><?php echo languageVariables("winnerTitle", "lottery", $languageType); ?></h2>
    <div class="flex justify-between gap-6 p-10 mt-5">
      <div class="flex gap-8">
        <div class="bg-indigo-400 h-fit rounded-md relative">
          <div class="relative py-6 px-12 overflow-hidden">
            <div class="w-40 h-72 bg-cover bg-top z-10 overflow-hidden relative" style="background-image: url('https://mc-heads.net/body/<?php echo $readLotteryWinnerOne["username"]; ?>');"></div>
            <div class="absolute bottom-0 left-1/2 shadow-3xl shadow-indigo-600"></div>
          </div>
          <div class="bg-center bg-cover absolute w-20 h-20 bottom-6 -left-10">
            <img alt="lucky-block" src="/assets/uploads/images/upload/lucky-block.png" style="margin-top: 4rem; margin-left: -3rem;" />
          </div>
        </div>
        <div class="py-4 relative z-20">
          <div class="text-lg font-medium text-white/75"><?php echo languageVariables("player", "words", $languageType); ?> <span class="block text-xl font-bold text-white"><?php echo $readLotteryWinnerOne["username"]; ?></span></div>
          <div class="text-lg font-medium text-white/75 mt-4"><?php echo languageVariables("amount", "words", $languageType); ?> <span class="block text-xl font-bold text-white"><?php echo $readLotteryWinnerOne["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></span></div>
          <div class="text-lg font-medium text-white/75 mt-4"><?php echo languageVariables("lucky", "lottery", $languageType); ?> <span class="block text-xl font-bold text-white"><?php echo number_format($readLotteryWinnerOne["chance"], 2)."%"; ?></span></div>
        </div>
      </div>
      <div class="text-right">
        <p class="text-white/75 text-lg"><?php echo languageVariables("orTitle", "lottery", $languageType); ?></p>
        <div class="mt-5">
          <span class="font-semibold text-white text-lg"><?php echo languageVariables("prevs", "lottery", $languageType); ?></span>
          <div class="mt-2 flex flex-col items-end gap-6">
            <!---->
            <?php foreach($searchLotteryWinners as $readLotteryWinner) { ?>
            <div class="rounded-md bg-indigo-400 py-2 px-4 flex justify-home gap-2 overflow-hidden w-48">
              <img class="rounded-lg" alt="avatar" src="https://minotar.net/avatar/<?php echo $readLotteryWinner["username"]; ?>/35.png" />
              <span class="font-medium text-white mt-1"><?php echo $readLotteryWinner["username"]; ?></span>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { echo alert(languageVariables("alertWinnerHistory", "lottery", $languageType), "danger", "0", "/"); } ?>
<?php } ?>