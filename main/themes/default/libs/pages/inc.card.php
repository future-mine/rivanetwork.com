<link rel="stylesheet" href="/main/includes/packages/layouts/card/css/themes/default/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]-46; ?>">
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
<?php if ($cardGameRowCount > 1) { ?>
<section class="bg-indigo-100/75">
  <div class="container mx-auto grid grid-cols-2 lg:grid-cols-8">
  <?php foreach ($searchCardGames as $readCardGames) { ?>
    <a href="<?php echo urlConverter("card_game", $languageType); ?>/<?php echo createSlug($readCardGames["name"]); ?>/<?php echo $readCardGames["id"]; ?>" class="<?php echo (($readCardGames["id"] == $readCardGame["id"]) ? "relative py-8 flex flex-col items-center justify-center bg-indigo-500" : "relative py-8 flex flex-col items-center justify-center transition hover:bg-indigo-500 group"); ?>">
      <p class="<?php echo (($readCardGames["id"] == $readCardGame["id"]) ? "fw-bold text-white relative bottom-2" : "fw-bold text-primary transition-all group-hover:text-white relative bottom-0 group-hover:bottom-2"); ?>"><?php echo $readCardGames["name"]; ?></p>
      <span class="<?php echo (($readCardGames["id"] == $readCardGame["id"]) ? "absolute text-white/75 fw-medium bottom-4" : "absolute -bottom-6 text-white/75 fw-medium group-hover:bottom-4 transition-all"); ?>"><?php if ($readCardGames["type"] == "1") { echo $readCardGames["price"]." ".languageVariables("credi", "words", $languageType); } else if ($readCardGames["type"] == "0") { echo $readCardGames["hours"]." ".languageVariables("hours", "words", $languageType); } ?></span>
    </a>
  <?php } ?>
  </div>
</section>
<?php } ?>

<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("card_game", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("cardGame", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php if ($readCardGame["type"] == "1") { echo $readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGame["type"] == "0") { echo $readCardGame["name"]." (".$readCardGame["hours"]." ".languageVariables("onceHour", "cardGame", $languageType).")"; } ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php if ($readCardGame["type"] == "1") { echo $readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")"; } else if ($readCardGame["type"] == "0") { echo $readCardGame["name"]." (".$readCardGame["hours"]." ".languageVariables("onceHour", "cardGame", $languageType).")"; } ?></h3>
        <div class="text-gray-400 mt-4">
          <div class="card-game">
            <div id="card-game-visible" class="visible"></div>
              <div class="grid lg:grid-cols-12 gap-16">
              <?php for ($i = 1; $i <= 8; $i++) { ?>
              <div class="lg:col-span-3 flex flex-col">
               <div class="card-game-card">
                 <p class="text-sticker"><?php echo $i; ?></p>
                 <div class="card-game-back">
                   <img src="<?php echo $rSettings["serverLogo"]; ?>" alt="<?php echo $rSettings["servername"]; ?> - Logo">
                 </div>
               </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <center class="mt-10" id="card-game-info">
            <?php if ($readCardGame["type"] == "1") { ?>
            <p><?php echo str_replace(["&credit"], [$readCardGame["price"]], languageVariables("gameTextCredit", "cardGame", $languageType)); ?></p>
            <?php } else if ($readCardGame["type"] == "0") { ?>
            <p><?php echo str_replace(["&hours"], [$readCardGame["hours"]], languageVariables("gameTextHours", "cardGame", $languageType)); ?></p>
            <?php } ?>
            <button type="button" id="play-button" class="mt-2 btn btn-primary w-25"><?php echo languageVariables("game", "words", $languageType); ?></button>
          </center>
        </div>
      </div>
    </div>
	  <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="mt-10 card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-boxes !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("cardGameHistory", "words", $languageType); ?></p>
          </div>
          <div class="">
            <?php
            $searchCardGameHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE cardID = ? ORDER BY id DESC LIMIT 5");
            $searchCardGameHistory->execute(array($readCardGame["id"]));
            if ($searchCardGameHistory->rowCount() > 0) {
            ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("games", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("status", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("reward", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                  <?php foreach ($searchCardGameHistory as $readCardGameHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCardGameHistory["username"]; ?>/28" alt="<?php echo languageVariables("cardGame", "words", $languageType); ?> - <?php echo $readCardGameHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCardGameHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readCardGame["name"]; ?></td>
                    <td class="font-normal p-3"><?php echo (($readCardGameHistory["rewardType"] == "winner") ? languageVariables("won", "words", $languageType) : languageVariables("loser", "words", $languageType)); ?></td>
                    <td class="font-normal p-3"><?php echo $readCardGameHistory["reward"]; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotGame", "cardGame", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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