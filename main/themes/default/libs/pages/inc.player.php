<?php
if (isset($_GET["player"])) {
  $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
  $searchPlayer->execute(array(get("player")));
  if ($searchPlayer->rowCount() > 0) {
    $readPlayer = $searchPlayer->fetch();
    $rowCountPlayerProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
    $rowCountPlayerProduct->execute(array($readPlayer["id"], "0"));
    $rowCountPlayerProduct = $rowCountPlayerProduct->rowCount();
    $rowCountPlayerInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?");
    $rowCountPlayerInvent->execute(array($readPlayer["id"]));
    $rowCountPlayerInvent = $rowCountPlayerInvent->rowCount();
    $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
    $searchPlayerPermission->execute(array($readPlayer["permission"]));
    $readPlayerPermission = $searchPlayerPermission->fetch();
?>
<section class="">
  <div class="relative h-60 px-4 md:px-0">
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center" style="background-image: url('<?php echo $readPlayer["imageAvatar"]; ?>')"></div>
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-black/50"></div>
    <div class="profile-mobile relative z-20 container mx-auto flex h-full items-end justify-between">
      <div class="flex gap-5 items-end">
        <div class="rounded-[2rem] bg-cover bg-center w-28 h-28 relative top-6" style="background-image: url('https://minotar.net/bust/<?php echo $readPlayer["username"]; ?>/100.png')"></div>
        <div class="mb-4">
          <p class="fs-5 fw-bold text-white"><?php echo $readPlayer["username"]; ?></p>
          <span class="text-white/75 -mt-1"><?php echo languageVariables("emailProtection", "player", $languageType); ?></span>
        </div>
      </div>
      <div class="flex flex-col lg:flex-row gap-3 mb-6">
        <a href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>" class="btn btn-primary"><?php echo languageVariables("detail", "words", $languageType); ?></a>
        <a href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>/<?php echo (($languageType == "tr") ? "mesajlar" : "messages"); ?>" class="btn btn-white"><?php echo languageVariables("messages", "words", $languageType); ?></a>
      </div>
    </div>
  </div>
  <?php
    $searchNewsLike = $db->prepare("SELECT * FROM newsLike WHERE userID = ? ORDER BY id DESC");
    $searchNewsLike->execute(array($readPlayer["id"]));
    $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE username = ? ORDER BY id DESC");
    $searchNewsComments->execute(array($readPlayer["username"]));
    $searchProductRates = $db->prepare("SELECT * FROM productRates WHERE userID = ? ORDER BY id DESC");
    $searchProductRates->execute(array($readPlayer["id"]));
    $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC");
    $searchSupportHistory->execute(array($readPlayer["username"]));
    $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
    $rowCountUserProduct->execute(array($readPlayer["id"], "0"));
    $rowCountUserProduct = $rowCountUserProduct->rowCount();
    $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?");
    $rowCountUserInvent->execute(array($readPlayer["id"]));
    $rowCountUserInvent = $rowCountUserInvent->rowCount();
  ?>
  <div class="container mx-auto py-16 grid lg:grid-cols-10 gap-6 px-4 md:px-0">
    <div class="lg:col-span-7 flex flex-col gap-8" style="overflow: overlay;">
    <?php if (get("action") == "message") { ?>
      <?php if ($readPlayer["profileMessageStatus"] == "1") { ?>
      <div class="card p-6">
        <div class="">
          <h3 class="h4"><?php echo languageVariables("messages", "words", $languageType); ?></h3>
        </div>
        <div class="mt-6">
          <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["goMessage"])) {
              if ($safeCsrfToken->validate('messageToken')) {
                if (post("message") !== "") {
                  $safeMessage = arghMessage(post("message"));
                  $insertMessage = $db->prepare("INSERT INTO accountsMessage SET userID = ?, messageAuthorUsername = ?, message = ?, date = ?");
                  $insertMessage->execute(array($readPlayer["id"], $readAccount["username"], $safeMessage, date("d.m.Y H:i:s")));
                  echo alert(languageVariables("alertMessageSendSuccess", "profile", $languageType), "success", "3", "");
                  if ($readPlayer["notificationStatus"] == "1") {
                    $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                    $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("notificationMessage", "profile", $languageType), '{"iconType":"messages","username":"'.$readPlayer["username"].'"}', "profileMessage", date("d.m.Y H:i:s"), "unread"));
                  }
                } else {
                  echo alert(languageVariables("alertNone", "profile", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "profile", $languageType), "danger", "0", "/");
              }
            }
          ?>
          <h5 class="fw-bolder fs-6"><?php echo languageVariables("messageSend", "words", $languageType); ?></h5>
          <form action="" method="POST">
            <div class="flex gap-3 mt-4">
              <?php echo $safeCsrfToken->input("messageToken"); ?>
              <img class="rounded-2xl h-fit" src="https://minotar.net/avatar/<?php echo $readPlayer["username"]; ?>/100.png" width="40" height="40" alt="">
              <textarea name="message" class="form-control w-full h-20" placeholer="<?php echo languageVariables("messagePlaceholder", "profile", $languageType); ?>"></textarea>
              <button type="submit" name="goMessage" class="btn btn-primary w-20"><i class="fas fa-arrow-right"></i></button>
            </div>
          </form>
        </div>
        <div class="mt-6 divide-y divide-gray-200/25 border-t-2 border-gray-200/50">
          <?php
            $searchAccountsMessage = $db->prepare("SELECT * FROM accountsMessage WHERE userID = ? ORDER BY id DESC");
            $searchAccountsMessage->execute(array($readPlayer["id"]));
            if ($searchAccountsMessage->rowCount() > 0) {
            foreach ($searchAccountsMessage as $readPlayersMessage) {
          ?>
          <div class="flex gap-3 py-4">
            <img class="rounded-2xl h-fit" src="https://minotar.net/avatar/<?php echo $readPlayersMessage["messageAuthorUsername"]; ?>/100.png" width="40" height="40" alt="">
            <div class="grow">
              <div class="flex justify-between items-center">
                <span class="fw-medium text-gray-600"><?php echo $readPlayersMessage["messageAuthorUsername"]; ?></span>
                <span class="uppercase text-xs text-gray-400"><?php echo checkTime($readPlayersMessage["date"]); ?></span>
              </div>
              <p class="text-gray-400 text-sm"><?php echo $readPlayersMessage["message"]; ?></p>
            </div>
          </div>
          <?php } } else { echo alert(languageVariables("alertNotProfileMessage", "profile", $languageType), "danger", "0", "/"); } ?>
        </div>
      </div>
      <?php } ?>
    <?php } else if (get("action") == "info") { ?>
      <div class="tabs" id="tabs-profile">
        <div class="tabs-head">
          <a href="#content-likes" class="tabs-link active" tab-name="tabs-profile">
            <?php echo languageVariables("likes", "words", $languageType); ?> (<?php echo $searchNewsLike->rowCount(); ?>)
            <div><span></span></div>
          </a>
          <a href="#content-comments" class="tabs-link" tab-name="tabs-profile">
            <?php echo languageVariables("comments", "words", $languageType); ?> (<?php echo $searchNewsComments->rowCount(); ?>)
            <div><span></span></div>
          </a>
          <a href="#content-products" class="tabs-link" tab-name="tabs-profile">
            <?php echo languageVariables("starProducts", "words", $languageType); ?> (<?php echo $searchProductRates->rowCount(); ?>)
            <div><span></span></div>
          </a>
        </div>
        <div class="tabs-content" tab-content-name="tabs-profile">
          <div class="tabs-pane show" id="content-likes">
            <?php if ($searchNewsLike->rowCount() > 0) { ?>
            <?php foreach ($searchNewsLike as $readNewsLike) { ?>
            <?php $searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?"); ?>
            <?php $searchNews->execute(array($readNewsLike["newsID"])); ?>
            <?php if ($searchNews->rowCount() > 0) { ?>
            <?php $readNews = $searchNews->fetch(); ?>
            <div class="p-6 grid gap-4">
              <a href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNews["title"]) . "/" . $readNews["id"]; ?>" class="relative overflow-hidden bg-gray-50/75 rounded-xl flex gap-3 group">
                <div class="relative overflow-hidden w-fit flex-shrink-0">
                  <div class="w-36 h-24 bg-cover bg-center transform -rotate-3 scale-110 transition-all group-hover:scale-100 group-hover:rotate-0" style="background-image: url('<?php echo $readNews["image"]; ?>')"></div>
                </div>
                <div class="py-3 px-1 grow flex justify-between">
                  <div>
                    <h3 class="fw-bolder text-gray-800"><?php echo $readNews["title"]; ?></h3>
                    <span class="text-gray-400 text-sm"><?php echo checkTime($readNewsLike["date"]); ?></span>
                  </div>
                  <div class="relative overflow-hidden m-2 flex items-center justify-center rounded-xl bg-gray-100 w-14 h-14">
                    <span class="bg-gray-900 absolute top-0 w-full h-full -right-full group-hover:right-0 transition-all"></span>
                    <i class="relative z-10 fas fa-angle-right group-hover:text-white transition"></i>
                  </div>
                </div>
              </a>
            </div>
            <?php } } ?>
            <?php } else { echo alert(languageVariables("alertNotLikeTrans", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-comments">
            <?php if ($searchNewsComments->rowCount() > 0) { ?>
            <?php foreach ($searchNewsComments as $readNewsComments) { ?>
            <?php $searchNewsC = $db->prepare("SELECT * FROM newsList WHERE id = ? AND status = ?"); ?>
            <?php $searchNewsC->execute(array($readNewsComments["newsID"], 1)); ?>
            <?php if ($searchNewsC->rowCount() > 0) { ?>
            <?php $readNewsC = $searchNewsC->fetch(); ?>
            <div class="p-6 grid gap-4">
              <a href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNewsC["title"]) . "/" . $readNewsC["id"]; ?>" class="relative overflow-hidden bg-gray-50/75 rounded-xl flex gap-3 group">
                <div class="relative overflow-hidden w-fit flex-shrink-0">
                  <div class="w-36 h-24 bg-cover bg-center transform -rotate-3 scale-110 transition-all group-hover:scale-100 group-hover:rotate-0" style="background-image: url('<?php echo $readNewsC["image"]; ?>')"></div>
                </div>
                <div class="py-3 px-1 grow flex justify-between">
                  <div>
                    <h3 class="fw-bolder text-gray-800"><?php echo $readNewsC["title"]; ?></h3>
                    <span class="text-emerald-400 text-sm"><?php if ($readNewsComments["status"] == "0") { echo languageVariables("notApproved", "words", $languageType); } else if ($readNewsComments["status"] == "1") { echo languageVariables("approved", "words", $languageType); } ?></span>
                  </div>
                  <div class="relative overflow-hidden m-2 flex items-center justify-center rounded-xl bg-gray-100 w-14 h-14">
                    <span class="bg-gray-900 absolute top-0 w-full h-full -right-full group-hover:right-0 transition-all"></span>
                    <i class="relative z-10 fas fa-angle-right group-hover:text-white transition"></i>
                  </div>
                </div>
              </a>
            </div>
            <?php } } ?>
            <?php } else { echo alert(languageVariables("alertNotCommentTrans", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-products">
            <?php if ($searchProductRates->rowCount() > 0) { ?>
            <?php foreach ($searchProductRates as $readProductRates) { ?>
            <?php $searchRatesProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?>
            <?php $searchRatesProduct->execute(array($readProductRates["productID"])); ?>
            <?php if ($searchRatesProduct->rowCount() > 0) { ?>
            <?php $readRatesProduct = $searchRatesProduct->fetch(); ?>
            <?php $ratesProductServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
            <?php $ratesProductServer->execute(array($readRatesProduct["serverID"])); ?>
            <?php $ratesProductCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
            <?php $ratesProductCategory->execute(array($readRatesProduct["categoryID"])); ?>
            <?php $readRatesProductCategory = $ratesProductCategory->fetch(); ?>
            <?php $readRatesProductServer = $ratesProductServer->fetch(); ?>
            <div class="p-6 grid gap-4">
              <a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readRatesProductServer["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readRatesProductCategory["name"]))."/".createSlug($readRatesProduct["name"])."/".$readRatesProduct["id"]; ?>" class="relative overflow-hidden bg-gray-50/75 rounded-xl flex gap-3 group">
                <div class="relative overflow-hidden w-fit flex-shrink-0 flex items-center justify-center ml-3">
                  <img class="w-16" src="<?php echo $readRatesProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readRatesProduct["name"]; ?>">
                </div>
                <div class="py-3 px-1 grow flex justify-between">
                  <div class="flex flex-col">
                    <h3 class="fw-bolder text-gray-800"><?php echo $readRatesProduct["name"]; ?></h3>
                    <span class="text-gray-400 text-sm fw-medium"><?php echo $readRatesProductServer["name"]; ?></span>
                    <span class="mt-auto text-gray-400 text-sm"><?php echo checkTime($readProductRates["date"]); ?></span>
                  </div>
                  <div class="relative overflow-hidden m-2 flex items-center justify-center rounded-xl bg-gray-100 w-14 h-14">
                    <span class="bg-gray-900 absolute top-0 w-full h-full -right-full group-hover:right-0 transition-all"></span>
                    <i class="relative z-10 fas fa-angle-right group-hover:text-white transition"></i>
                  </div>
                </div>
              </a>
            </div>
            <?php } } ?>
            <?php } else { echo alert(languageVariables("alertStarAddProduct", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <div class="card lg:col-span-7 flex flex-col gap-16">
        <div class="px-6 py-8">
          <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("bannedTitle", "profile", $languageType); ?></h3>
          <div class="text-gray-400 mt-4">
            <?php $searchBannedHistoryWeb = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistoryWeb->execute(array($readPlayer["username"], "login", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
            <?php if ($searchBannedHistoryWeb->rowCount() > 0) { ?>
            <?php $readBHW = $searchBannedHistoryWeb->fetch(); ?>
            <?php if ($readBHW["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateWeb = "Süresiz"; } else { $userBannedBackDateWeb = max(round((strtotime($readBHW["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
            <?php echo alert(languageVariables("webBanned", "player", $languageType),": ".$userBannedBackDateWeb." / ".$readBHW["reason"], "success", "0", "/"); ?>
            <?php } else { echo alert(languageVariables("webNotBanned", "player", $languageType), "success", "0", "/"); } ?>
            <?php $searchBannedHistorySupport = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistorySupport->execute(array($readPlayer["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
            <?php if ($searchBannedHistorySupport->rowCount() > 0) { ?>
            <?php $readBHS = $searchBannedHistorySupport->fetch(); ?>
            <?php if ($readBHS["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateSupport = "Süresiz"; } else { $userBannedBackDateSupport = max(round((strtotime($readBHS["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
            <?php echo alert(languageVariables("supportBanned", "player", $languageType).": ".$userBannedBackDateSupport." / ".$readBHS["reason"], "success", "0", "/"); ?>
            <?php } else { echo alert(languageVariables("supportNotBanned", "player", $languageType), "success", "0", "/"); } ?>
            <?php $searchBannedHistoryComment = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistoryComment->execute(array($readPlayer["username"], "comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
            <?php if ($searchBannedHistoryComment->rowCount() > 0) { ?>
            <?php $readBHC = $searchBannedHistoryComment->fetch(); ?>
            <?php if ($readBHC["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateComment = "Süresiz"; } else { $userBannedBackDateComment = max(round((strtotime($readBHC["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
            <?php echo alert(languageVariables("commentBanned", "player", $languageType).": ".$userBannedBackDateComment." / ".$readBHC["reason"], "success", "0", "/"); ?>
            <?php } else { echo alert(languageVariables("commentNotBanned", "player", $languageType), "success", "0", "/"); } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
    <div class="lg:col-span-3 flex flex-col gap-4">
      <div class="card overflow-hidden">
        <div class="flex flex-col gap-3 absolute top-12 left-4 z-50" data-toggle="3dskin" skin-username="<?php echo $readPlayer["username"]; ?>">
          <div id="skinPause" onclick="skinPause()" class="cursor-pointer icon bg-red-400 bg-opacity-25 text-red-500">
            <i class="fas fa-pause"></i>
          </div>
          <div id="skinUnPause" onclick="skinUnPause()" class="!hidden cursor-pointer icon bg-green-400 bg-opacity-25 text-green-500">
            <i class="fas fa-play"></i>
          </div>
          <div id="skinWalk" onclick="skinIdle()" class="cursor-pointer bg-yellow-400 bg-opacity-25 text-yellow-500 icon">
            <i class="fas fa-person-running"></i>
          </div>
          <div id="skinIdle" onclick="skinWalk()" class="!hidden cursor-pointer bg-stone-400 bg-opacity-25 text-stone-500 icon">
            <i class="fas fa-person"></i>
          </div>
        </div>
        <div class="flex items-center justify-center py-10">
          <div>
            <canvas id="skin_container"></canvas>
          </div>
        </div>
        <div class="absolute bottom-0 w-full shadow-3xl shadow-indigo-400/25"></div>
        <div class="relative border-t-2 border-gray-500 z-10 px-4 py-4 fs-5 text-center fw-bold text-white bg-white">
          <div class="grid grid-cols-2 gap-3 px-4">
            <div class="rounded-xl bg-emerald-400/10 transition hover:bg-emerald-400/20 p-4 flex flex-col items-center justify-center">
              <div class="text-2xl fw-bolder text-emerald-400 mt-2">
                <?php echo $readPlayer["credit"]; ?><span class="text-sm"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span>
              </div>
              <span class="text-emerald-400 text-sm fw-bolder uppercase mt-2"><?php echo languageVariables("credi", "words", $languageType); ?></span>
            </div>
            <div class="rounded-xl bg-blue-400/10 transition hover:bg-blue-400/20 p-4 flex flex-col items-center justify-center">
              <div class="text-2xl fw-bolder text-blue-400 mt-2">
                <?php echo $rowCountUserProduct; ?><span class="text-sm text-blue-300 fw-normal"><?php echo languageVariables("count", "words", $languageType); ?></span>
              </div>
              <span class="text-blue-400 text-sm fw-bolder uppercase mt-2"><?php echo languageVariables("chest", "words", $languageType); ?></span>
            </div>
            <div class="rounded-xl bg-pink-400/10 transition hover:bg-pink-400/20 p-4 flex flex-col items-center justify-center">
              <div class="text-2xl fw-bolder text-pink-400 mt-2">
                <?php echo $rowCountUserInvent; ?><span class="text-sm text-pink-300 fw-normal"><?php echo "/".$readPlayer["inventorySlot"]; ?></span>
              </div>
              <span class="text-pink-400 text-sm fw-bolder uppercase mt-2"><?php echo languageVariables("inventory", "words", $languageType); ?></span>
            </div>
            <div class="rounded-xl bg-purple-400/10 transition hover:bg-purple-400/20 p-4 flex flex-col items-center justify-center">
              <div class="text-2xl fw-bolder text-purple-400 mt-2">
                <?php echo $searchSupportHistory->rowCount(); ?>
              </div>
              <span class="text-purple-400 text-sm fw-bolder uppercase mt-2"><?php echo languageVariables("support", "words", $languageType); ?></span>
            </div>
          </div>
          <div class="h-px my-5 mx-4 bg-gray-200"></div>
          <div class="mx-4 rounded-xl bg-gray-100 py-6 px-4">
            <div class="fw-bolder text-gray-800 px-3">
              <?php echo languageVariables("registerDate", "profile", $languageType); ?>
              <p class="fw-normal text-gray-500 ml-2"><?php echo checkTime($readPlayer['registerDate']); ?></p>
            </div>
            <div class="fw-bolder text-gray-800 px-3 mt-3">
              <?php echo languageVariables("lastLogin", "profile", $languageType); ?>
              <p class="fw-normal text-gray-500 ml-2"><?php echo checkTime($readPlayer['lastLogin']); ?></p>
            </div>
            <div class="fw-bolder text-gray-800 px-3 mt-3">
              <?php echo languageVariables("email", "words", $languageType); ?>
              <p class="fw-normal text-gray-500 ml-2"><?php echo languageVariables("emailProtection", "player", $languageType); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card p-6">
        <div class="relative mb-2 px-4">
          <h3 class="h4"><?php echo languageVariables("socialMedia", "words", $languageType); ?></h3>
          <span class="absolute -bottom-2 left-4 h-1 w-20 rounded-full bg-indigo-400"></span>
        </div>
        <div class="px-4 pt-6">
          <div class="flex gap-4">
            <a class="icon bg-blue-500 bg-opacity-25 text-blue-500" href="<?php echo $readPlayer["discord"]; ?>">
              <i class="fab fa-discord"></i>
            </a>
            <a class="icon bg-teal-400 bg-opacity-25 text-teal-600" href="<?php echo $readPlayer["instagram"]; ?>">
              <i class="fab fa-skype"></i>
            </a>
            <a class="icon bg-pink-400 bg-opacity-25 text-pink-500" href="<?php echo $readPlayer["instagram"]; ?>">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="icon bg-blue-300 bg-opacity-25 text-blue-400" href="<?php echo $readPlayer["twitter"]; ?>">
              <i class="fab fa-twitter"></i>
            </a>
            <a class="icon bg-red-400 bg-opacity-25 text-red-500" href="<?php echo $readPlayer["youtube"]; ?>">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
  } else {
    go(urlConverter("home", $languageType));
  }
} else if (isset($_POST["searchPlayer"])) {
  $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
  $searchPlayer->execute(array(post("searchPlayer")));
  if ($searchPlayer->rowCount() > 0) {
    $readPlayer = $searchPlayer->fetch();
    go(urlConverter("player", $languageType)."/".$readPlayer["username"]);
  } else {
    go(urlConverter("home", $languageType));
  }
} else {
  go(urlConverter("home", $languageType));
}
?>