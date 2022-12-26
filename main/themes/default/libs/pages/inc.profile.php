<?php AccountLoginControl(false); ?>
<section class="">
  <div class="relative h-60 px-4 md:px-0">
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center" style="background-image: url('<?php echo $readAccount["imageAvatar"]; ?>')"></div>
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-black/50"></div>
    <div class="profile-mobile relative z-20 container mx-auto flex h-full items-end justify-between">
      <div class="flex gap-5 items-end">
        <div class="rounded-[2rem] bg-cover bg-center w-28 h-28 relative top-6" style="background-image: url('https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png')"></div>
        <div class="mb-4">
          <p class="fs-5 fw-bold text-white"><?php echo $readAccount["username"]; ?></p>
          <span class="text-white/75 -mt-1"><?php echo $readAccount["email"]; ?></span>
        </div>
      </div>
      <div class="flex flex-col lg:flex-row gap-3 mb-6">
        <a href="<?php echo urlConverter("profile_prepare", $languageType); ?>" class="btn btn-primary"><?php echo languageVariables("profilePrepare", "profile", $languageType); ?></a>
        <a href="<?php echo urlConverter("profile_password_change", $languageType); ?>" class="btn btn-white"><?php echo languageVariables("changePassword", "profile", $languageType); ?></a>
      </div>
    </div>
  </div>
  <?php
    $searchNewsLike = $db->prepare("SELECT * FROM newsLike WHERE userID = ? ORDER BY id DESC");
    $searchNewsLike->execute(array($readAccount["id"]));
    $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE username = ? ORDER BY id DESC");
    $searchNewsComments->execute(array($readAccount["username"]));
    $searchProductRates = $db->prepare("SELECT * FROM productRates WHERE userID = ? ORDER BY id DESC");
    $searchProductRates->execute(array($readAccount["id"]));
    $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC");
    $searchSupportHistory->execute(array($readAccount["username"]));
    $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
    $rowCountUserProduct->execute(array($readAccount["id"], "0"));
    $rowCountUserProduct = $rowCountUserProduct->rowCount();
    $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?");
    $rowCountUserInvent->execute(array($readAccount["id"]));
    $rowCountUserInvent = $rowCountUserInvent->rowCount();
  ?>
  <div class="container mx-auto py-16 grid lg:grid-cols-10 gap-6 px-4 md:px-0">
    <div class="lg:col-span-7 flex flex-col gap-8" style="overflow: overlay;">
    <?php if (get("proccess") == "message") { ?>
      <?php if ($readAccount["profileMessageStatus"] == "1") { ?>
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
                  $insertMessage->execute(array($readAccount["id"], $readAccount["username"], $safeMessage, date("d.m.Y H:i:s")));
                  echo alert(languageVariables("alertMessageSendSuccess", "profile", $languageType), "success", "3", "");
                  if ($readAccount["notificationStatus"] == "1") {
                    $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                    $insertNotifications->execute(array($readAccount["username"], $readAccount["id"], languageVariables("notificationMessage", "profile", $languageType), '{"iconType":"messages","username":"'.$readAccount["username"].'"}', "profileMessage", date("d.m.Y H:i:s"), "unread"));
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
              <img class="rounded-2xl h-fit" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/100.png" width="40" height="40" alt="">
              <textarea name="message" class="form-control w-full h-20" placeholer="<?php echo languageVariables("messagePlaceholder", "profile", $languageType); ?>"></textarea>
              <button type="submit" name="goMessage" class="btn btn-primary w-20"><i class="fas fa-arrow-right"></i></button>
            </div>
          </form>
        </div>
        <div class="mt-6 divide-y divide-gray-200/25 border-t-2 border-gray-200/50">
          <?php
            $searchAccountsMessage = $db->prepare("SELECT * FROM accountsMessage WHERE userID = ? ORDER BY id DESC");
            $searchAccountsMessage->execute(array($readAccount["id"]));
            if ($searchAccountsMessage->rowCount() > 0) {
            foreach ($searchAccountsMessage as $readAccountsMessage) {
          ?>
          <div class="flex gap-3 py-4">
            <img class="rounded-2xl h-fit" src="https://minotar.net/avatar/<?php echo $readAccountsMessage["messageAuthorUsername"]; ?>/100.png" width="40" height="40" alt="">
            <div class="grow">
              <div class="flex justify-between items-center">
                <span class="fw-medium text-gray-600"><?php echo $readAccountsMessage["messageAuthorUsername"]; ?></span>
                <span class="uppercase text-xs text-gray-400"><?php echo checkTime($readAccountsMessage["date"]); ?></span>
              </div>
              <p class="text-gray-400 text-sm"><?php echo $readAccountsMessage["message"]; ?></p>
            </div>
          </div>
          <?php } } else { echo alert(languageVariables("alertNotProfileMessage", "profile", $languageType), "danger", "0", "/"); } ?>
        </div>
      </div>
      <?php } ?>
    <?php } else if (get("action") == "account" && get("proccess") == "change") { ?>
      <div class="card lg:col-span-7 flex flex-col gap-16">
        <div class="px-6 py-8">
          <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("profilePrepare", "profile", $languageType); ?></h3>
          <div class="text-gray-400 mt-4">
            <?php
              require_once(__DR__."/main/includes/packages/class/csrf/class.php");
              $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
              if (isset($_POST["updateAccount"])) {
                if ($safeCsrfToken->validate('updateAccountToken')) {
                    if (!empty($_POST["currentPassword"]) && !empty($_POST["accountEmail"]) && !empty($_POST["accountDiscord"]) && !empty($_POST["accountSkype"]) && !empty($_POST["accountInstagram"]) && !empty($_POST["accountTwitter"]) && !empty($_POST["accountYoutube"])) {
                    if (controlSHA256(post("currentPassword"), $readAccount["password"]) == "OK") {
                      $searchEmailRow = $db->prepare("SELECT * FROM accounts WHERE email = ?");
                      $searchEmailRow->execute(array(post("accountEmail")));
                      if (post("accountEmail") == $readAccount["email"] || $searchEmailRow->rowCount() == 0) {
                        if (strstr(post("accountEmail"), "@")) {
                          $updateAccount = $db->prepare("UPDATE accounts SET email = ?, discord = ?, skype = ?, twitter = ?, instagram = ?, youtube = ? WHERE id = ?");
                          $updateAccount->execute(array(post("accountEmail"), post("accountDiscord"), post("accountSkype"), post("accountTwitter"), post("accountInstagram"), post("accountYoutube"), $readAccount["id"]));
                          echo alert(languageVariables("alertSaveChanges", "profile", $languageType), "success", "3", "");
                        } else {
                          echo alert(languageVariables("alertEmailError", "profile", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(str_replace("&email", post("accountEmail"), languageVariables("alertAlreadyEmail", "profile", $languageType)), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertCurrentPassword", "profile", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertNone", "profile", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertSystem", "profile", $languageType), "danger", "0", "/");
                }
              }
            ?>
            <form action="" method="POST">
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-6 flex flex-col">
                  <label for="currentPassword" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                  <input id="currentPassword" type="password" name="currentPassword" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("currentPassword", "words", $languageType); ?>">
                </div>
                <div class="lg:col-span-6 flex flex-col">
                  <label for="username" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("username", "words", $languageType); ?></label>
                  <input id="username" type="text" name="username" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" value="<?php echo $readAccount["username"]; ?>" readonly>
                </div>
              </div>
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-6 flex flex-col">
                  <label for="email" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("email", "words", $languageType); ?></label>
                  <input id="email" type="email" name="accountEmail" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>" value="<?php echo $readAccount["email"]; ?>">
                </div>
                <div class="lg:col-span-6 flex flex-col">
                  <label for="accountDiscord" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("discordUsername", "profile", $languageType); ?></label>
                  <input id="accountDiscord" type="text" name="accountDiscord" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("discordUsername", "profile", $languageType); ?>" value="<?php echo $readAccount["discord"]; ?>">
                </div>
              </div>
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-6 flex flex-col">
                  <label for="accountSkype" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("skypeUsername", "profile", $languageType); ?></label>
                  <input id="accountSkype" type="text" name="accountSkype" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("skypeUsername", "profile", $languageType); ?>" value="<?php echo $readAccount["skype"]; ?>">
                </div>
                <div class="lg:col-span-6 flex flex-col">
                  <label for="accountTwitter" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("twitterUsername", "profile", $languageType); ?></label>
                  <input id="accountTwitter" type="text" name="accountTwitter" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("twitterUsername", "profile", $languageType); ?>" value="<?php echo $readAccount["twitter"]; ?>">
                </div>
              </div>
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-6 flex flex-col">
                  <label for="accountInstagram" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("instagramUsername", "profile", $languageType); ?></label>
                  <input id="accountInstagram" type="text" name="accountInstagram" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("instagramUsername", "profile", $languageType); ?>" value="<?php echo $readAccount["instagram"]; ?>">
                </div>
                <div class="lg:col-span-6 flex flex-col">
                  <label for="accountYoutube" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("youtubeUsername", "profile", $languageType); ?></label>
                  <input id="accountYoutube" type="text" name="accountYoutube" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("youtubeUsername", "profile", $languageType); ?>" value="<?php echo $readAccount["youtube"]; ?>">
                </div>
              </div>
              <?php echo $safeCsrfToken->input("updateAccountToken"); ?>
              <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
                <button type="submit" name="updateAccount" class="btn btn-primary"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } else if (get("action") == "account" && get("proccess") == "password") { ?>
      <div class="card lg:col-span-7 flex flex-col gap-16">
        <div class="px-6 py-8">
          <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("changePassword", "profile", $languageType); ?></h3>
          <div class="text-gray-400 mt-4">
            <?php
              require_once(__DR__."/main/includes/packages/class/csrf/class.php");
              $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
              if (isset($_POST["changePassword"])) {
                if ($safeCsrfToken->validate('changePasswordToken')) {
                  if (post("currentPassword") !== "" && post("newPassword") !== "" && post("newPasswordRe") !== "") {
                    if (controlSHA256(post("currentPassword"), $readAccount["password"]) == "OK") {
                      if (post("newPassword") == post("newPasswordRe")) {
                        if (strlen(post("newPassword")) >= 4) {
                          $generatePassword = generateSHA256(post("newPassword"));
                          $updateAccountPassword = $db->prepare("UPDATE accounts SET password = ? WHERE id = ?");
                          $updateAccountPassword->execute(array($generatePassword, $readAccount["id"]));
                          echo alert(languageVariables("alertPasswordSuccess", "profile", $languageType), "success", "3", "");
                        } else {
                          echo alert(languageVariables("alertNewPasswordLimit", "profile", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertNewPasswordNot", "profile", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertCurrentPassword", "profile", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertNone", "profile", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertSystem", "profile", $languageType), "danger", "0", "/");
                }
              }
            ?>
            <form action="" method="POST">
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-12 flex flex-col">
                  <label for="currentPassword" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                  <input id="currentPassword" type="password" name="currentPassword" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("currentPassword", "words", $languageType); ?>">
                </div>
              </div>
              <div class="grid lg:grid-cols-12 gap-16 mt-4">
                <div class="lg:col-span-6 flex flex-col">
                  <label for="newPassword" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("newPassword", "words", $languageType); ?></label>
                  <input id="newPassword" type="password" name="newPassword" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("newPassword", "words", $languageType); ?>">
                </div>
                <div class="lg:col-span-6 flex flex-col">
                  <label for="newPasswordRe" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("newPasswordRe", "words", $languageType); ?></label>
                  <input id="newPasswordRe" type="password" name="newPasswordRe" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>">
                </div>
              </div>
              <?php echo $safeCsrfToken->input("changePasswordToken"); ?>
              <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
                <button type="submit" name="changePassword" class="btn btn-primary"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="tabs" id="tabs-profile">
        <div class="tabs-head">
          <span href="#content-likes" class="tabs-link active" tab-name="tabs-profile">
            <?php echo languageVariables("likes", "words", $languageType); ?> (<?php echo $searchNewsLike->rowCount(); ?>)
            <div><span></span></div>
          </span>
          <span href="#content-comments" class="tabs-link" tab-name="tabs-profile">
            <?php echo languageVariables("comments", "words", $languageType); ?> (<?php echo $searchNewsComments->rowCount(); ?>)
            <div><span></span></div>
          </span>
          <span href="#content-products" class="tabs-link" tab-name="tabs-profile">
            <?php echo languageVariables("starProducts", "words", $languageType); ?> (<?php echo $searchProductRates->rowCount(); ?>)
            <div><span></span></div>
          </span>
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
            <?php $searchNewsC = $db->prepare("SELECT * FROM newsList WHERE id = ?"); ?>
            <?php $searchNewsC->execute(array($readNewsComments["newsID"])); ?>
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
      <div class="tabs w-full" id="tabs-history">
        <div class="tabs-head">
          <span href="#content-notifications" class="tabs-link active" tab-name="tabs-history">
            <?php echo languageVariables("notificationHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
          <span href="#content-support" class="tabs-link" tab-name="tabs-history">
            <?php echo languageVariables("supportHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
        </div>
        <div class="tabs-content overflow-hdn relative" tab-content-name="tabs-history">
          <div class="tabs-pane show" id="content-notifications">
            <?php $searchNotifications = $db->prepare("SELECT * FROM accountsNotifications WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchNotifications->execute(array($readAccount["id"])); ?>
            <?php if ($searchNotifications->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75 relative">
                  <th class="text-left">#</th>
                  <th class="text-left"><?php echo languageVariables("trans", "words", $languageType); ?></th>
                  <th class="text-left"><?php echo languageVariables("date", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchNotifications as $readAccountsNotification) { ?>
                <?php $readNotificationData = json_decode($readAccountsNotification["data"],true); ?>
                <?php
                  $notificationUsername = $readAccountsNotification["username"];
                  if ($readAccountsNotification["type"] == "changePassword") {
                    $readNotificationsText = str_replace("&userIP", "<span class=\"bold\">".$readNotificationData["userIP"]."</span>", languageVariables("profileLoginError", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "creditTransfer") {
                    $readNotificationsText = str_replace(array("&username", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readNotificationData["senderUsername"]."\" target=\"_blank\" rel=\"external\">".$readNotificationData["senderUsername"]."</a>", "<span class=\"bold\">".$readNotificationData["amount"]."</span>"), languageVariables("profileSendCreditMy", "notifications", $languageType));
                    $notificationUsername = $readNotificationData["senderUsername"];
                  } else if ($readAccountsNotification["type"] == "errorLogin") {
                    $readNotificationsText = "<span class=\"bold\">".$readNotificationData["userIP"]."</span> sayısal IP adresi üzerinden hesabınıza hatalı giriş tespit edildi şifrenizi değiştirmeniz öneriliyor!";
                  } else if ($readAccountsNotification["type"] == "creditSender") {
                    $readNotificationsText = str_replace(array("&username", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readNotificationData["transferUsername"]."\" target=\"_blank\" rel=\"external\">".$readNotificationData["senderUsername"]."</a>", "<span class=\"bold\">".$readNotificationData["amount"]."</span>"), languageVariables("profileSendCreditTo", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "successLogin") {
                    $readNotificationsText = str_replace("&userIP", "<span class=\"bold\">".$readNotificationData["userIP"]."</span>", languageVariables("profileLogin", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "register") {
                    $readNotificationsText = str_replace("&username", "<span class=\"bold\">".$readAccountsNotification["username"]."</span>", languageVariables("profileRegister", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "profileMessage") {
                    $notificationUsername = $readNotificationData["username"];
                    $readNotificationsText = str_replace("&username", "<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$notificationUsername."\" target=\"_blank\" rel=\"external\">".$readNotificationData["username"]."</a>", languageVariables("profileMessage", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "giftSender") {
                    $notificationUsername = $readNotificationData["username"];
                    $readNotificationsText = str_replace(array("&username", "&product"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$notificationUsername."\" target=\"_blank\" rel=\"external\">".$readNotificationData["username"]."</a>", "<a class=\"bold\">".$readNotificationData["product"]."</a>"), languageVariables("profileGiftSender", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "giftTransfer") {
                    $notificationUsername = $readNotificationData["username"];
                    $readNotificationsText = str_replace(array("&username", "&product"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$notificationUsername."\" target=\"_blank\" rel=\"external\">".$readNotificationData["username"]."</a>", "<a class=\"bold\">".$readNotificationData["product"]."</a>"), languageVariables("profileGiftTransfer", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "giftSenderInventory") {
                    $notificationUsername = $readNotificationData["username"];
                    $readNotificationsText = str_replace(array("&username", "&product"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$notificationUsername."\" target=\"_blank\" rel=\"external\">".$readNotificationData["username"]."</a>", "<a class=\"bold\">".$readNotificationData["product"]."</a>"), languageVariables("profileGiftSenderInventory", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "giftTransferInventory") {
                    $notificationUsername = $readNotificationData["username"];
                    $readNotificationsText = str_replace(array("&username", "&product"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$notificationUsername."\" target=\"_blank\" rel=\"external\">".$readNotificationData["username"]."</a>", "<a class=\"bold\">".$readNotificationData["product"]."</a>"), languageVariables("profileGiftTransferInventory", "notifications", $languageType));
                  } else if ($readAccountsNotification["type"] == "creditUpload") {
                    $readNotificationsText = str_replace("&amount", "<span class=\"bold\">".$readNotificationData["amount"]."</span>", languageVariables("profileCreditUpload", "notifications", $languageType));
                  }
                ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-left">#<?php echo $readAccountsNotification["id"]; ?></td>
                  <td class="text-left"><?php echo $readNotificationsText; ?></td>
                  <td class="text-left"><?php echo checkTime($readAccountsNotification["date"], 2, true); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertNotificationHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-support" class="">
            <?php if ($searchSupportHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("title", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("category", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("status", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchSupportHistory as $readSupportHistory) { ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readSupportHistory["id"]; ?></td>
                  <td class="text-center"><?php echo $readSupportHistory["title"]; ?></td>
                  <td class="text-center"><?php echo $readSupportHistory["category"]; ?></td>
                  <td class="text-center"><?php echo $readSupportHistory["serverName"]; ?></td>
                  <td class="text-center"><?php echo checkTime($readSupportHistory["lastUpdate"]); ?></td>
                  <td class="text-center">
                    <?php if ($readSupportHistory["status"] == 0) { ?>
                    <span class="text-muted"><?php echo languageVariables("notAnswered", "words", $languageType); ?></span>
                    <?php } else if ($readSupportHistory["status"] == 1) { ?>
                    <span class="text-success"><?php echo languageVariables("answered", "words", $languageType); ?></span>
                    <?php } else if ($readSupportHistory["status"] == 2) { ?>
                    <span class="text-danger"><?php echo languageVariables("closed", "words", $languageType); ?></span>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertSupportHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <div class="tabs w-full" id="tabs-history-store">
        <div class="tabs-head">
          <span href="#content-credit" class="tabs-link active" tab-name="tabs-history-store">
            <?php echo languageVariables("creditHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
          <span href="#content-store" class="tabs-link" tab-name="tabs-history-store">
            <?php echo languageVariables("storeHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
          <span href="#content-chest" class="tabs-link" tab-name="tabs-history-store">
            <?php echo languageVariables("chestHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
        </div>
        <div class="tabs-content overflow-hdn relative" tab-content-name="tabs-history-store">
          <div class="tabs-pane show" id="content-credit">
            <?php $searchCreditHistory = $db->prepare("SELECT * FROM creditHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchCreditHistory->execute(array($readAccount["username"])); ?>
            <?php if ($searchCreditHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75 relative">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("user", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("trans", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readCreditHistory["id"]; ?></td>
                  <td class="text-center"><?php echo (($readCreditHistory["type"] == "0") ? $readCreditHistory["username"] : $readCreditHistory["usernameTo"]); ?></td>
                  <td class="text-center text-center"><?php if($readCreditHistory["type"] == "0") { if($readCreditHistory["method"] == "0") { ?><i class="fa fa-mobile" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("paymentMobile", "words", $languageType); ?>"></i><?php } else { ?><i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("paymentCredit", "words", $languageType); ?>"></i><?php } } else if($readCreditHistory["type"] == "1") { if ($readCreditHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("creditSender", "words", $languageType); ?>"></i><?php } else if ($readCreditHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("creditTransfer", "words", $languageType); ?>"></i><?php } } ?></td>
                  <td class="text-center"><?php echo $readCreditHistory["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></td>
                  <td class="text-center"><?php echo checkTime($readAccountsNotification["date"], 2, true); ?></td>
                  <td class="text-center">
                    <div class=" d-flex align-items-center justify-content-end">
                      <?php if ($readCreditHistory["type"] == "0") { ?>
                      <span>
                        <i class="fas fa-arrow-right fa-sm" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("inComing", "words", $languageType); ?>"></i>
                      </span>
                      <?php } else { ?>
                      <span>
                        <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("outComing", "words", $languageType); ?>"></i>
                      </span>
                      <?php } ?>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertCreditHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-store" class="">
            <?php $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchStoreHistory->execute(array($readAccount["username"])); ?>
            <?php if ($searchStoreHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("product", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("price", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
                <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
                <?php $readServerList = $searchServerList->fetch(); ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readStoreHistory["id"]; ?></td>
                  <td class="text-center"><?php echo $readStoreHistory["productName"]; ?></td>
                  <td class="text-center"><?php echo $readStoreHistory["productPrice"]; ?></td>
                  <td class="text-center"><?php echo $readServerList["name"]; ?></td>
                  <td class="text-center"><?php echo checkTime($readStoreHistory["date"], 2, true); ?></td>
                  <td class="text-center">
                    <div class=" d-flex align-items-center justify-content-end">
                      <span>
                        <i class="fas fa-arrow-right fa-sm"></i>
                      </span>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertStoreHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-chest">
            <?php $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchChestHistory->execute(array($readAccount["username"])); ?>
            <?php if ($searchChestHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("product", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("trans", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("user", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("price", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchChestHistory as $readChestHistory) { ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readChestHistory["id"]; ?></td>
                  <td class="text-center"><?php echo $readChestHistory["productName"]; ?></td>
                  <td class="text-center"><?php if($readChestHistory["type"] == "0") { ?><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("productActive", "words", $languageType); ?>"></i> <?php } else if($readChestHistory["type"] == "1") { if ($readChestHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftSender", "words", $languageType); ?>"></i><?php } else if ($readChestHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftTransfer", "words", $languageType); ?>"></i><?php } } ?></td>
                  <td class="text-center"><?php echo (($readChestHistory["type"] == "0") ? $readChestHistory["username"] : $readChestHistory["usernameTo"]); ?></td>
                  <td class="text-center"><?php echo $readChestHistory["productPrice"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></td>
                  <td class="text-center"><?php echo $readChestHistory["serverName"]; ?></td>
                  <td class="text-center"><?php echo checkTime($readChestHistory["date"], 2, true); ?></td>
                  <td class="text-center">
                    <?php if ($readChestHistory["type"] == "0") { ?>
                    <div class=" d-flex align-items-center justify-content-end">
                      <span>
                        <i class="fas fa-arrow-right fa-sm"></i>
                      </span>
                    </div>
                    <?php } else if ($readChestHistory["type"] == "1") { ?>
                    <div class="d-flex align-items-center justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-times-circle text-danger"></i>
                      </span>
                    </div>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertChestHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <div class="tabs w-full" id="tabs-history-game">
        <div class="tabs-head">
          <span href="#content-card-game" class="tabs-link active" tab-name="tabs-history-game">
            <?php echo languageVariables("cardGameHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
          <span href="#content-coupon" class="tabs-link" tab-name="tabs-history-game">
            <?php echo languageVariables("couponHistory", "profile", $languageType); ?>
            <div><span></span></div>
          </span>
        </div>
        <div class="tabs-content overflow-hdn relative" tab-content-name="tabs-history-game">
          <div class="tabs-pane show" id="content-card-game">
            <?php $searchCardHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchCardHistory->execute(array($readAccount["id"])); ?>
            <?php if ($searchCardHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75 relative">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("reward", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("games", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("gameType", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("gamePrice", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchCardHistory as $readCardHistory) { ?>
                <?php $searchCard = $db->prepare("SELECT * FROM cardGame WHERE id = ?"); ?>
                <?php $searchCard->execute(array($readCardHistory["cardID"])); ?>
                <?php $readCard = $searchCard->fetch(); ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readCardHistory["id"]; ?></td>
                  <td class="text-center"><?php echo $readCardHistory["reward"]; ?></td>
                  <td class="text-center"><?php echo $readCard["name"]; ?></td>
                  <td class="text-center"><?php if ($readCard["type"] == "1") { echo languageVariables("paid", "words", $languageType); } else if ($readCard["type"] == "0") { echo languageVariables("free", "words", $languageType); } ?></td>
                  <td class="text-center"><?php if ($readCard["type"] == "1") { echo $readCard["price"]." ".languageVariables("credi", "words", $languageType); } else if ($readCard["type"] == "0") { echo $readCard["hours"]." ".languageVariables("hours", "words", $languageType); } ?></td>
                  <td class="text-center"><?php echo checkTime($readCardHistory["date"], 2, true); ?></td>
                  <td class="text-center">
                    <div class=" d-flex align-items-center justify-content-end">
                      <span>
                        <i class="fas fa-arrow-right fa-sm"></i>
                      </span>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertCardGameHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
          <div class="tabs-pane" id="content-coupon" class="">
            <?php $searchCouponHistory = $db->prepare("SELECT * FROM couponHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchCouponHistory->execute(array($readAccount["id"])); ?>
            <?php if ($searchCouponHistory->rowCount() > 0) { ?>
            <table class="table table-hover">
              <thead>
                <tr class="text-xs uppercase text-gray-600 bg-gray-100/75">
                  <th class="text-center">#</th>
                  <th class="text-center"><?php echo languageVariables("rewards", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("coupon", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 text-sm">
                <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
                <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
                <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
                <?php $readCoupon = $searchCoupon->fetch(); ?>
                <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
                <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
                <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
                <tr class="hover:bg-gray-100/25">
                  <td class="text-center">#<?php echo $readCouponHistory["id"]; ?></td>
                  <td class="text-center"><?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." "; } else { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?></td>
                  <td class="text-center"><?php echo $readCoupon["code"]; ?></td>
                  <td class="text-center"><?php echo checkTime($readCouponHistory["date"], 2, true); ?></td>
                  <td class="text-center">
                    <div class=" d-flex align-items-center justify-content-end">
                      <span>
                        <i class="fas fa-arrow-right fa-sm"></i>
                      </span>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { echo alert(languageVariables("alertCouponHistory", "profile", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <div class="card lg:col-span-7 flex flex-col gap-16">
        <div class="px-6 py-8">
          <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("bannedTitle", "profile", $languageType); ?></h3>
          <div class="text-gray-400 mt-4">
            <?php $searchBannedHistoryWeb = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistoryWeb->execute(array($readAccount["username"], "login", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
            <?php if ($searchBannedHistoryWeb->rowCount() > 0) { ?>
            <?php $readBHW = $searchBannedHistoryWeb->fetch(); ?>
            <?php if ($readBHW["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateWeb = "Süresiz"; } else { $userBannedBackDateWeb = max(round((strtotime($readBHW["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
            <?php echo alert(languageVariables("webBanned", "player", $languageType),": ".$userBannedBackDateWeb." / ".$readBHW["reason"], "success", "0", "/"); ?>
            <?php } else { echo alert(languageVariables("webNotBanned", "player", $languageType), "success", "0", "/"); } ?>
            <?php $searchBannedHistorySupport = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistorySupport->execute(array($readAccount["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
            <?php if ($searchBannedHistorySupport->rowCount() > 0) { ?>
            <?php $readBHS = $searchBannedHistorySupport->fetch(); ?>
            <?php if ($readBHS["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDateSupport = "Süresiz"; } else { $userBannedBackDateSupport = max(round((strtotime($readBHS["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } ?>
            <?php echo alert(languageVariables("supportBanned", "player", $languageType).": ".$userBannedBackDateSupport." / ".$readBHS["reason"], "success", "0", "/"); ?>
            <?php } else { echo alert(languageVariables("supportNotBanned", "player", $languageType), "success", "0", "/"); } ?>
            <?php $searchBannedHistoryComment = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)"); ?>
            <?php $searchBannedHistoryComment->execute(array($readAccount["username"], "comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00")); ?>
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
      <a onclick="openProfileMenu()" class="cursor-pointer transition hover:bg-indigo-500/20 bg-indigo-500/10 rounded-2xl p-6 fw-medium text-indigo-500">
        <i class="fas fa-bars-staggered mr-3"></i>
        <?php echo languageVariables("menus", "words", $languageType); ?>
      </a>
      <div class="card overflow-hidden">
        <div class="flex flex-col gap-3 absolute top-12 left-4 z-50" data-toggle="3dskin" skin-username="<?php echo $readAccount["username"]; ?>">
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
                <?php echo $readAccount["credit"]; ?><span class="text-sm"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span>
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
                <?php echo $rowCountUserInvent; ?><span class="text-sm text-pink-300 fw-normal"><?php echo "/".$readAccount["inventorySlot"]; ?></span>
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
              <p class="fw-normal text-gray-500 ml-2"><?php echo checkTime($readAccount['registerDate']); ?></p>
            </div>
            <div class="fw-bolder text-gray-800 px-3 mt-3">
              <?php echo languageVariables("lastLogin", "profile", $languageType); ?>
              <p class="fw-normal text-gray-500 ml-2"><?php echo checkTime($readAccount['lastLogin']); ?></p>
            </div>
            <div class="fw-bolder text-gray-800 px-3 mt-3">
              <?php echo languageVariables("email", "words", $languageType); ?>
              <p class="fw-normal text-gray-500 ml-2"><?php echo $readAccount["email"]; ?></p>
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
            <a class="icon bg-blue-500 bg-opacity-25 text-blue-500" href="<?php echo $readAccount["discord"]; ?>">
              <i class="fab fa-discord"></i>
            </a>
            <a class="icon bg-teal-400 bg-opacity-25 text-teal-600" href="<?php echo $readAccount["instagram"]; ?>">
              <i class="fab fa-skype"></i>
            </a>
            <a class="icon bg-pink-400 bg-opacity-25 text-pink-500" href="<?php echo $readAccount["instagram"]; ?>">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="icon bg-blue-300 bg-opacity-25 text-blue-400" href="<?php echo $readAccount["twitter"]; ?>">
              <i class="fab fa-twitter"></i>
            </a>
            <a class="icon bg-red-400 bg-opacity-25 text-red-500" href="<?php echo $readAccount["youtube"]; ?>">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>