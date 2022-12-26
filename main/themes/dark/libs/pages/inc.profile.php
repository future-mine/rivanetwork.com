<?php AccountLoginControl(false); ?>
<style type="text/css">.instagram{background-color: #8a3ab9;}.twitter{background-color: #1DA1F2;}.youtube{background-color:#FF0000;}</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("myProfile", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-12 pb-5 pt-3">
            <div class="row">
              <div class="col-12 col-lg-9 pr-lg-2">
                <div class="profile-header bg-dark--5 d-flex align-items-center position-relative overflow-hidden">
                  <div class="mc-skin left mr-0 pl-3 pt-3 profile-skin">
                    <div class="mc-skin-img-wrapper js-mirror">
                      <div class="mc-skin-img">
                        <img src="https://minotar.net/body/<?php echo $readAccount["username"]; ?>/100.png" alt="<?php echo $readAccount["username"]; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-sm-5 px-4 py-3 mb-1">
                    <div class="block">
                      <h1 class="d-block username font-size-12 text-white font-100 mb-0"><?php echo $readAccount["username"]; ?></h1>
                      <h2 class="d-block mail font-size-7 text-white font-100 mb-2 mt-0 o-25"><?php echo $readAccount["email"]; ?></h2>
                      <span class="d-inline-block role font-size-6 text-uppercase">
                        <span class="badge font-100 letter-spacing-2 line-height-1" style="<?php echo "background-color: ".$readAccountPermission["permColorBG"]."; color: ".$readAccountPermission["permColorText"].";"; ?>"><?php echo $readAccountPermission["permName"]; ?></span>
                      </span>
                      <span class="d-inline-block credit font-size-6 text-uppercase">
                        <span class="badge badge-warning font-900 letter-spacing-2 line-height-1 turkish-lira"><?php echo $readAccount['credit']; ?></span>
                      </span>
                    </div>
                  </div>
                  <div class="details pr-5 o-75">
                    <div class="last-login text-white mb-3">
                      <span class="title font-100 font-size-6 text-right w-100 line-height-1 d-block o-25"><?php echo languageVariables("lastLogin", "profile", $languageType); ?></span>
                      <span class="text-nowrap font-100 font-size-7 text-right"><?php echo checkTime($readAccount['lastLogin']); ?></span>
                    </div>
                    <div class="reg-date text-white">
                      <span class="title font-100 font-size-6 text-right w-100 line-height-1 d-block o-25"><?php echo languageVariables("registerDate", "profile", $languageType); ?></span>
                      <span class="text-nowrap font-100 font-size-7 text-right"><?php echo checkTime($readAccount['registerDate']); ?></span>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-3  pt-2 pt-lg-0 mb-2">
                <div class="actions mb-5">
                  <a href="<?php echo urlConverter("profile_prepare", $languageType); ?>" class="btn mr-2 mb-3 text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary">
                    <i class="fas fa-user fa-sm mr-1 btn-icon"></i>
                    <span class="btn-text">
                    <?php echo languageVariables("profilePrepare", "profile", $languageType); ?>
                    </span>
                  </a>
                  <a href="<?php echo urlConverter("profile_password_change", $languageType); ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary" style="">
                    <i class="fas fa-star-of-life fa-sm mr-1 btn-icon"></i>
                    <span class="btn-text">
                    <?php echo languageVariables("changePassword", "profile", $languageType); ?>
                    </span>
                  </a>
                </div>
              </div>
              <div class="col-12 mb-2 d-flex">
                <div class="discord contact-card bg-discord text-white font-100 font-size-7 line-height-1 align-items-center" style="max-width: 166px;">
                  <i class="fab fa-discord mr-2"></i>
                  <span><?php echo $readAccount["discord"]; ?></span>
                </div>
                <div class="skype contact-card bg-primary mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-skype mr-2"></i>
                  <span><?php echo $readAccount["skype"]; ?></span>
                </div>
                <div class="instagram contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-instagram mr-2"></i>
                  <span><?php echo $readAccount["instagram"]; ?></span>
                </div>
                <div class="twitter contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-twitter mr-2"></i>
                  <span><?php echo $readAccount["twitter"]; ?></span>
                </div>
                <div class="youtube contact-card mb-2 text-white font-100 font-size-7 line-height-1 align-items-center position-relative overflow-hidden" style="max-width: 166px;">
                  <i class="fab fa-youtube mr-2"></i>
                  <span><?php echo $readAccount["youtube"]; ?></span>
                </div>
              </div>
              <?php if(get("action") == "profile"):?>
              <?php if(get("proccess") == "profile"):?>
              <div class="col-12">
                <ul class="nav nav-pills nav-fill nav-tabs border-0">
                  <li class="nav-item">
                    <a href="#tab1_bildiri" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("notificationHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#tab1_destek" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("supportHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane overflow-auto active" id="tab1_bildiri">
                    <div class="table-responsive">
                    <?php $searchNotifications = $db->prepare("SELECT * FROM accountsNotifications WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchNotifications->execute(array($readAccount["id"])); ?>
                    <?php if ($searchNotifications->rowCount() > 0) : ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-50 border-0">
                          <?php echo languageVariables("trans", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchNotifications as $readAccountsNotification) : ?>
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
                        <tr class="font-size-6 products bg-dark--3">
                          <th class="p-3 border-bottom font-100 line-height-1 w-10 text-white pl-4" scope="row"><?php echo $readAccountsNotification["id"]; ?></th>
                          <td class="p-3 border-bottom font-100 line-height-1 w-70 text-white"><?php echo $readNotificationsText; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-white"><?php echo checkTime($readAccountsNotification["date"], 2, true); ?></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <?php else:?>
                    <?php echo alert(languageVariables("alertNotificationHistory", "profile", $languageType), "danger", "0", "/");?>
                    <?php endif;?>
                    </div>
                  </div>
                  <div class="tab-pane overflow-auto" id="tab1_destek">
                    <div class="table-responsive">
                    <?php $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC"); ?>
                    <?php $searchSupportHistory->execute(array($readAccount["username"])); ?>
                    <?php if ($searchSupportHistory->rowCount() > 0) { ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-40 border-0">
                          <?php echo languageVariables("title", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("category", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("server", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("lastUpdate", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("status", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-10 border-0">

                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchSupportHistory as $readSupportHistory) { ?>
                        <tr class="font-size-6 products bg-dark--3">
                          <th class="p-3 border-bottom font-100 pl-4 line-height-1 text-white w-10"><?php echo $readSupportHistory["id"]; ?></th>
                          <td class="p-3 border-bottom font-100 line-height-1 w-40 text-white"><?php echo $readSupportHistory["title"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-white"><?php echo $readSupportHistory["category"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-white"><?php echo $readSupportHistory["serverName"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-white"><?php echo checkTime($readSupportHistory["lastUpdate"]); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-white table-badge-wrapper">
                            <?php if ($readSupportHistory["status"] == 0) { ?>
                            <span class="text-white"><?php echo languageVariables("notAnswered", "words", $languageType); ?></span>
                            <?php } else if ($readSupportHistory["status"] == 1) { ?>
                            <span class="text-muted"><?php echo languageVariables("answered", "words", $languageType); ?></span>
                            <?php } else if ($readSupportHistory["status"] == 2) { ?>
                            <span class="text-danger"><?php echo languageVariables("closed", "words", $languageType); ?></span>
                            <?php } ?>
                          </td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-white text-right">
                            <div class="d-flex align-items-center justify-content-end">
                              <a data-toggle="tooltip" data-title="<?php echo languageVariables("ticketClosed", "words", $languageType); ?>" onclick="deletedSupport('<?php echo $readSupportHistory['id']; ?>');" class="mr-2">
                                <i class="fas fa-times-circle text-danger"></i>
                              </a>
                              <a data-toggle="tooltip" data-title="<?php echo languageVariables("view", "words", $languageType); ?>" href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"])."/".$readSupportHistory["id"]; ?>">
                                <i class="fas fa-arrow-right fa-sm text-white"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php }?>
                      </tbody>
                    </table>
                    <?php } else { echo alert(languageVariables("alertSupportHistory", "profile", $languageType), "danger", "0", "/"); } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5">
                <ul class="nav nav-pills nav-fill nav-tabs border-0">
                  <li class="nav-item">
                    <a href="#tab1_kredi" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("creditHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#tab1_magaza" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("storeHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#sandik_gecmis" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("chestHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane overflow-auto active" id="tab1_kredi">
                    <div class="table-responsive">
                    <?php $searchCreditHistory = $db->prepare("SELECT * FROM creditHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchCreditHistory->execute(array($readAccount["username"])); ?>
                    <?php if ($searchCreditHistory->rowCount() > 0) : ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-30 border-0">
                          <?php echo languageVariables("user", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("trans", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("amount", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-10 border-0">
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchCreditHistory as $readCreditHistory) : ?>
                        <tr class="text-white font-size-7">
                          <th class="p-3 border-bottom font-100 pl-4 line-height-1 w-10 o-25" scope="row"><?php echo $readCreditHistory["id"]; ?></th>
                          <th class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate" scope="row">
                            <?php if($readCreditHistory["type"] == "0"):?>
                            <?php echo $readCreditHistory["username"]; ?>
                            <?php else:?>
                            <?php echo $readCreditHistory["usernameTo"]; ?>
                            <?php endif;?>
                          </th>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php if($readCreditHistory["type"] == "0") { if($readCreditHistory["method"] == "0") { ?><i class="fa fa-mobile" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("paymentMobile", "words", $languageType); ?>"></i><?php } else { ?><i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("paymentCredit", "words", $languageType); ?>"></i><?php } } else if($readCreditHistory["type"] == "1") { if ($readCreditHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("creditSender", "words", $languageType); ?>"></i><?php } else if ($readCreditHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("creditTransfer", "words", $languageType); ?>"></i><?php } } ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo $readCreditHistory["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo checkTime($readCreditHistory["date"]);?></td>
                          <td class="p-3 border-bottom font-100 pr-4 line-height-1 w-10">
                            <div class=" d-flex align-items-center justify-content-end">
                              <?php if($readCreditHistory["type"] == "0"):?>
                              <a href="#">
                                <i class="fas fa-arrow-right fa-sm text-white" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("inComing", "words", $languageType); ?>"></i>
                              </a>
                              <?php else:?>
                              <a href="#">
                                <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("outComing", "words", $languageType); ?>"></i>
                              </a>
                              <?php endif;?>
                            </div>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <?php else:?>
                    <?php echo alert(languageVariables("alertCreditHistory", "profile", $languageType), "danger", "0", "/");?>
                    <?php endif;?>
                    </div>
                  </div>
                  <div class="tab-pane overflow-auto" id="tab1_magaza">
                    <div class="table-responsive">
                    <?php $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchStoreHistory->execute(array($readAccount["username"])); ?>
                    <?php if ($searchStoreHistory->rowCount() > 0) : ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-30 border-0">
                          <?php echo languageVariables("product", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("price", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("server", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-10 border-0">
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchStoreHistory as $readStoreHistory) : ?>
                        <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                        <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
                        <?php $readServerList = $searchServerList->fetch(); ?>
                        <tr class="text-white font-size-7">
                          <th class="p-3 border-bottom font-100 pl-4 line-height-1 w-10 o-25" scope="row"><?php echo $readStoreHistory["id"]; ?></th>
                          <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo $readStoreHistory["productName"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $readStoreHistory["productPrice"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo $readServerList["name"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo checkTime($readStoreHistory["date"]);?></td>
                          <td class="p-3 border-bottom font-100 pr-4 line-height-1 w-10">
                            <div class=" d-flex align-items-center justify-content-end">
                              <a href="#">
                                <i class="fas fa-arrow-right fa-sm text-white"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <?php else:?>
                    <?php echo alert(languageVariables("alertStoreHistory", "profile", $languageType), "danger", "0", "/");?>
                    <?php endif;?>
                    </div>
                  </div>
                  <div class="tab-pane overflow-auto" id="sandik_gecmis">
                    <div class="table-responsive">
                    <?php $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchChestHistory->execute(array($readAccount["username"])); ?>
                    <?php if ($searchChestHistory->rowCount() > 0) : ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("product", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("trans", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("user", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("price", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("server", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-10 border-0">
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchChestHistory as $readChestHistory) : ?>
                        <tr class="text-white font-size-7">
                          <th class="p-3 border-bottom font-100 pl-4 line-height-1 w-10 o-25" scope="row"><?php echo $readChestHistory["id"]; ?></th>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo $readChestHistory["productName"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap o-25 text-truncate"><?php if($readChestHistory["type"] == "0") { ?><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("productActive", "words", $languageType); ?>"></i> <?php } else if($readChestHistory["type"] == "1") { if ($readChestHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftSender", "words", $languageType); ?>"></i><?php } else if ($readChestHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftTransfer", "words", $languageType); ?>"></i><?php } } ?></td>
                          <?php if($readChestHistory["type"] == "0") : ?>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate">
                            <?php echo $readChestHistory["username"]; ?>
                          </td>
                          <?php elseif($readChestHistory["type"] == "1"):?>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate">
                            <?php echo $readChestHistory["usernameTo"]; ?>
                          </td>
                          <?php endif;?>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $readChestHistory["productPrice"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $readChestHistory["serverName"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo checkTime($readChestHistory["date"]);?></td>
                          <td class="p-3 border-bottom font-100 pr-4 line-height-1">
                            <?php if($readChestHistory["type"] == "0") :?>
                            <div class=" d-flex align-items-center justify-content-end">
                              <a href="#">
                                <i class="fas fa-arrow-right fa-sm text-white"></i>
                              </a>
                            </div>
                            <?php elseif($readChestHistory["type"] == "1"):?>
                            <div class=" d-flex align-items-center justify-content-end">
                              <a href="#" class="mr-2">
                                <i class="fas fa-times-circle text-danger"></i>
                              </a>
                            </div>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                    <?php else:?>
                    <?php echo alert(languageVariables("alertChestHistory", "profile", $languageType), "danger", "0", "/"); ?>
                    <?php endif;?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-5">
                <ul class="nav nav-pills nav-fill nav-tabs border-0">
                  <li class="nav-item">
                    <a href="#tab1_kart" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("cardGameHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#tab1_hediye" class="nav-link text-center w-100 text-white font-100 font-size-6 text-uppercase letter-spacing-1 p-3" data-toggle="tab">
                    <?php echo languageVariables("couponHistory", "profile", $languageType); ?>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane overflow-auto active" id="tab1_kart">
                    <div class="table-responsive">
                    <?php $searchCardHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchCardHistory->execute(array($readAccount["id"])); ?>
                    <?php if ($searchCardHistory->rowCount() > 0) { ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-30 border-0">
                          <?php echo languageVariables("reward", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("games", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("gameType", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("gamePrice", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-20 border-0">
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchCardHistory as $readCardHistory) { ?>
                        <?php $searchCard = $db->prepare("SELECT * FROM cardGame WHERE id = ?"); ?>
                        <?php $searchCard->execute(array($readCardHistory["cardID"])); ?>
                        <?php $readCard = $searchCard->fetch(); ?>
                        <tr class="text-white font-size-7">
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate">#<?php echo $readCardHistory["id"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo $readCardHistory["reward"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo $readCard["name"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php if ($readCard["type"] == "1") { echo languageVariables("paid", "words", $languageType); } else if ($readCard["type"] == "0") { echo languageVariables("free", "words", $languageType); } ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php if ($readCard["type"] == "1") { echo $readCard["price"]." ".languageVariables("credi", "words", $languageType); } else if ($readCard["type"] == "0") { echo $readCard["hours"]." ".languageVariables("hours", "words", $languageType); } ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo checkTime($readCardHistory["date"], 2, true); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 text-nowrap text-truncate">
                            <div class=" d-flex align-items-center justify-content-end">
                              <a href="#">
                                <i class="fas fa-arrow-right fa-sm text-white"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <?php } else { echo alert(languageVariables("alertCardGameHistory", "profile", $languageType), "danger", "0", "/"); }?>
                    </div>
                  </div>
                  <div class="tab-pane overflow-auto" id="tab1_hediye">
                    <div class="table-responsive">
                    <?php $searchCouponHistory = $db->prepare("SELECT * FROM couponHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
                    <?php $searchCouponHistory->execute(array($readAccount["id"])); ?>
                    <?php if ($searchCouponHistory->rowCount() > 0) { ?>
                    <table class="default-table w-100 table table-hover mb-0">
                      <thead class="bg-dark--5">
                        <tr class="text-secondary font-size-6">
                          <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                            #
                          </th>
                          <th class="font-100 p-3 line-height-1 w-40 border-0">
                          <?php echo languageVariables("rewards", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-10 border-0">
                          <?php echo languageVariables("coupon", "words", $languageType); ?>
                          </th>
                          <th class="font-100 p-3 line-height-1 w-20 border-0">
                          <?php echo languageVariables("date", "words", $languageType); ?>
                          </th>
                          <th class="p-3 pr-4 w-20 border-0">
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-dark--4">
                        <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
                        <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
                        <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
                        <?php $readCoupon = $searchCoupon->fetch(); ?>
                        <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
                        <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
                        <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
                        <tr class="text-white font-size-7">
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate">#<?php echo $readCouponHistory["id"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-40 text-nowrap text-truncate"><?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." "; } else { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $readCoupon["code"]; ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate"><?php echo checkTime($readCouponHistory["date"], 2, true); ?></td>
                          <td class="p-3 border-bottom font-100 line-height-1 text-nowrap text-truncate">
                            <div class=" d-flex align-items-center justify-content-end">
                              <a href="#">
                                <i class="fas fa-arrow-right fa-sm text-white"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <?php } else { echo alert(languageVariables("alertCouponHistory", "profile", $languageType), "danger", "0", "/"); }?>
                    </div>
                  </div>
                </div>
                <div class="container-fluid mt-5">
                  <div class="row">
                    <div class="col-12 p-0">
                      <div class="container">
                        <div class="row">
                          <div class="col-lg-12 col-12 pb-2 pt-3 px-3 mt-5">
                            <div class="bg-dark--3 p-5 row">
                              <h3 class="text-secondary mb-3 font-100 col-12 p-0 font-size-6 letter-spacing-1 text-uppercase">
                              <?php echo languageVariables("bannedTitle", "profile", $languageType); ?>
                              </h3>
                              <div style="width: 100%">
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
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif;?>
                <?php endif;?>
                <?php if(get("action") == "account"):?>
                <?php if(get("proccess") == "change"):?>
                <div class="container-fluid login-container justify-content-center" style="">
                  <div class="row h-100">
                    <div class="col-12 p-0 h-100">
                      <div class="container h-100">
                        <div class="row h-100 " style="align-items:center; justify-content:center;">
                          <div class="col-lg-4 col-12 py-5">
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
                            <form action="" method="POST" class="login-form bg-dark--4 h-100 p-5 row">
                              <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                                <span class="font-800">
                                <?php echo languageVariables("profilePrepare", "profile", $languageType); ?>
                                </span>
                              </h2>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                <label for="account-current-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                                <input type="password" placeholder="<?php echo languageVariables("currentPassword", "words", $languageType); ?>" name="currentPassword" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("currentPassword", "words", $languageType); ?>" id="account-current-password" aria-describedby="change-password-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("username", "words", $languageType); ?></label>
                                <input type="text" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" value="<?php echo $readAccount["username"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="username" readonly disabled>
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="email" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("email", "words", $languageType); ?></label>
                                <input type="text" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>" name="accountEmail" value="<?php echo $readAccount["email"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="email">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="discord-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fab fa-discord fa-xs mr-1"></i><?php echo languageVariables("discordUsername", "profile", $languageType); ?></label>
                                <input type="text" placeholder="Discord" name="accountDiscord" value="<?php echo $readAccount["discord"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="discord-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="skype-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fab fa-skype fa-xs mr-1"></i><?php echo languageVariables("skypeUsername", "profile", $languageType); ?></label>
                                <input type="text" placeholder="Skype" name="accountSkype" value="<?php echo $readAccount["skype"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="skype-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="twitter-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fab fa-twitter fa-xs mr-1"></i><?php echo languageVariables("twitterUsername", "profile", $languageType); ?></label>
                                <input type="text" placeholder="Twitter" name="accountTwitter" value="<?php echo $readAccount["twitter"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="twitter-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="instagram-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fab fa-instagram fa-xs mr-1"></i><?php echo languageVariables("instagramUsername", "profile", $languageType); ?></label>
                                <input type="text" placeholder="Instagram" name="accountInstagram" value="<?php echo $readAccount["instagram"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="instagram-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 input-focused">
                                <label for="youtube-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fab fa-youtube fa-xs mr-1"></i><?php echo languageVariables("youtubeUsername", "profile", $languageType); ?></label>
                                <input type="text" placeholder="Youtube" name="accountYoutube" value="<?php echo $readAccount["youtube"]; ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="youtube-username">
                              </div>
                              <button type="submit" name="updateAccount" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                <?php echo $safeCsrfToken->input("updateAccountToken"); ?>
                                <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                                <span class="btn-text">
                                <?php echo languageVariables("saveChanges", "words", $languageType); ?>
                                </span>
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php elseif(get("proccess") == "password"): ?>
                <div class="container-fluid login-container justify-content-center" style="">
                  <div class="row h-100">
                    <div class="col-12 p-0 h-100">
                      <div class="container h-100">
                        <div class="row h-100 " style="align-items:center; justify-content:center;">
                          <div class="col-lg-4 col-12 py-5">
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
                            <form action="" method="POST" class="login-form bg-dark--4 h-100 p-5 row">
                              <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                                <span class="font-800">
                                <?php echo languageVariables("changePassword", "profile", $languageType); ?>
                                </span>
                              </h2>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                <label for="account-current-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                                <input type="password" placeholder="<?php echo languageVariables("currentPassword", "words", $languageType); ?>" name="currentPassword" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("currentPassword", "words", $languageType); ?>" id="account-current-password" aria-describedby="change-password-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                <label for="account-new-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("newPassword", "words", $languageType); ?></label>
                                <input type="password" placeholder="<?php echo languageVariables("newPassword", "words", $languageType); ?>" name="newPassword" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("newPassword", "words", $languageType); ?>" id="account-new-password" aria-describedby="account-new-username">
                              </div>
                              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                <label for="account-new-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("newPasswordRe", "words", $languageType); ?></label>
                                <input type="password" placeholder="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>" name="newPasswordRe" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>" id="account-new-password" aria-describedby="account-new-username">
                              </div>
                              <button type="submit" name="changePassword" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                <?php echo $safeCsrfToken->input("changePasswordToken"); ?>
                                <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                                <span class="btn-text">
                                <?php echo languageVariables("saveChanges", "words", $languageType); ?>
                                </span>
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif;?>
                <?php endif;?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>