<?php AccountLoginControl(false); ?>
<div class="content-grid">
  <div class="profile-header">
    <figure class="profile-header-cover liquid">
      <img src="<?php echo $readAccount["imageAvatar"]; ?>" alt="Avatar Image">
    </figure>
    <div class="profile-header-info">
      <div class="user-short-description big">
        <img class="profile-avatar-img-xc" src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png">
        <p class="user-short-description-title">
          <a href="<?php echo urlConverter("profile", $languageType); ?>">
            <span class="mc-player-tag text-tooltip-tft" style="<?php echo "background-color: ".$readAccountPermission["permColorBG"]."; color: ".$readAccountPermission["permColorText"].";"; ?>" data-title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readAccountPermission["permName"]; ?></span>
            <?php echo $readAccount["username"]; ?>
          </a>
        </p>
        <p class="user-short-description-text"><a href="#"><?php echo $readAccount["email"]; ?></a></p>
      </div>
      <div class="profile-header-social-links-wrap">
        <div id="profile-header-social-links-slider" class="<?php echo urlConverter("profile", $languageType); ?>">
          <div class="profile-header-social-link">
            <a class="social-link discord text-tooltip-tfr" data-title="<?php echo $readAccount["discord"]; ?>">
              <svg class="icon-discord">
                <use xlink:href="#svg-discord"></use>
              </svg>
            </a>
          </div>
          <div class="profile-header-social-link">
            <a class="social-link instagram" href="<?php echo $readAccount["instagram"]; ?>">
              <svg class="icon-instagram">
                <use xlink:href="#svg-instagram"></use>
              </svg>
            </a>
          </div>
          <div class="profile-header-social-link">
            <a class="social-link twitter" href="<?php echo $readAccount["twitter"]; ?>">
              <svg class="icon-twitter">
                <use xlink:href="#svg-twitter"></use>
              </svg>
            </a>
          </div>
          <div class="profile-header-social-link">
            <a class="social-link facebook text-tooltip-tfr" data-title="<?php echo $readAccount["skype"]; ?>">
              <svg class="icon-facebook">
                <i class="faj fa-skype" style="margin-right: 0.80rem; color: white; font-weight: 500;"></i>
              </svg>
            </a>
          </div>
          <div class="profile-header-social-link">
            <a class="social-link youtube" href="<?php echo $readAccount["youtube"]; ?>">
              <svg class="icon-youtube">
                <use xlink:href="#svg-youtube"></use>
              </svg>
            </a>
          </div>
        </div>

        <div id="profile-header-social-links-slider-controls" class="slider-controls">
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
      </div>
      <div class="user-stats">
        <div class="user-stat big">
          <p class="user-stat-title"><?php echo $rowCountUserProduct; ?></p>
          <p class="user-stat-text"><?php echo languageVariables("chest", "words", $languageType); ?></p>
        </div>
        <div class="user-stat big">
          <p class="user-stat-title"><?php echo $readAccount["credit"]; ?></p>
          <p class="user-stat-text"><?php echo languageVariables("credi", "words", $languageType); ?></p>
        </div>
        <div class="user-stat big">
          <p class="user-stat-title"><?php echo $rowCountUserInvent."/".$readAccount["inventorySlot"]; ?></p>
          <p class="user-stat-text"><?php echo languageVariables("inventory", "words", $languageType); ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="grid grid-3-9 medium-space">
    <div class="account-hub-sidebar">
      <div class="sidebar-box no-padding">
        <div class="sidebar-menu">
          <div class="sidebar-menu-item">
            <div class="sidebar-menu-header accordion-trigger-linked">
              <svg class="sidebar-menu-header-icon icon-settings">
                <use xlink:href="#svg-profile"></use>
              </svg>
              <div class="sidebar-menu-header-control-icon">
                <svg class="sidebar-menu-header-control-icon-open icon-minus-small">
                  <use xlink:href="#svg-minus-small"></use>
                </svg>
                <svg class="sidebar-menu-header-control-icon-closed icon-plus-small">
                  <use xlink:href="#svg-plus-small"></use>
                </svg>
              </div>
              <p class="sidebar-menu-header-title"><?php echo languageVariables("profile", "words", $languageType); ?></p>
              <p class="sidebar-menu-header-text"><?php echo languageVariables("profileBarTitle", "profile", $languageType); ?></p>
            </div>
            <div class="sidebar-menu-body accordion-content-linked <?php if (get("action") == "profile") { echo "accordion-open"; } ?>">
              <a class="sidebar-menu-link <?php if (get("action") == "profile" && get("proccess") == "profile") { echo "active"; } ?>" href="<?php echo urlConverter("profile", $languageType); ?>"><?php echo languageVariables("profileDetail", "words", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "profile" && get("proccess") == "message") { echo "active"; } ?>" href="<?php echo urlConverter("profile_message", $languageType); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "profile" && get("proccess") == "notifications") { echo "active"; } ?>" href="<?php echo urlConverter("profile_notifications", $languageType); ?>"><?php echo languageVariables("notifications", "words", $languageType); ?></a>
            </div>
          </div>
          <div class="sidebar-menu-item">
            <div class="sidebar-menu-header accordion-trigger-linked">
              <svg class="sidebar-menu-header-icon icon-settings">
                <use xlink:href="#svg-settings"></use>
              </svg>
              <div class="sidebar-menu-header-control-icon">
                <svg class="sidebar-menu-header-control-icon-open icon-minus-small">
                  <use xlink:href="#svg-minus-small"></use>
                </svg>
                <svg class="sidebar-menu-header-control-icon-closed icon-plus-small">
                  <use xlink:href="#svg-plus-small"></use>
                </svg>
              </div>
              <p class="sidebar-menu-header-title"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
              <p class="sidebar-menu-header-text"><?php echo languageVariables("accountBarTitle", "profile", $languageType); ?></p>
            </div>
            <div class="sidebar-menu-body accordion-content-linked <?php if (get("action") == "account") { echo "accordion-open"; } ?>">
              <a class="sidebar-menu-link <?php if (get("action") == "account" && get("proccess") == "change") { echo "active"; } ?>" href="<?php echo urlConverter("profile_prepare", $languageType); ?>"><?php echo languageVariables("accountInfo", "words", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "account" && get("proccess") == "password") { echo "active"; } ?>" href="<?php echo urlConverter("profile_change_password", $languageType); ?>"><?php echo languageVariables("passwordChange", "words", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "account" && get("proccess") == "settings") { echo "active"; } ?>" href="<?php echo urlConverter("profile_settings", $languageType); ?>"><?php echo languageVariables("generalSettings", "words", $languageType); ?></a>
            </div>
          </div>
          <div class="sidebar-menu-item">
            <div class="sidebar-menu-header accordion-trigger-linked">
              <svg class="sidebar-menu-header-icon icon-settings">
                <use xlink:href="#svg-streams"></use>
              </svg>
              <div class="sidebar-menu-header-control-icon">
                <svg class="sidebar-menu-header-control-icon-open icon-minus-small">
                  <use xlink:href="#svg-minus-small"></use>
                </svg>
                <svg class="sidebar-menu-header-control-icon-closed icon-plus-small">
                  <use xlink:href="#svg-plus-small"></use>
                </svg>
              </div>
              <p class="sidebar-menu-header-title"><?php echo languageVariables("history", "words", $languageType); ?></p>
              <p class="sidebar-menu-header-text"><?php echo languageVariables("historyBarTitle", "profile", $languageType); ?></p>
            </div>
            <div class="sidebar-menu-body accordion-content-linked <?php if (get("action") == "history") { echo "accordion-open"; } ?>">
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "chest") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_chest", $languageType); ?>"><?php echo languageVariables("chestTrans", "profile", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "store") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_store", $languageType); ?>"><?php echo languageVariables("storeTrans", "profile", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "credit") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_credit", $languageType); ?>"><?php echo languageVariables("creditTrans", "profile", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "card") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_card_game", $languageType); ?>"><?php echo languageVariables("cardGameTrans", "profile", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "coupon") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCouponTrans", "profile", $languageType); ?></a>
              <a class="sidebar-menu-link <?php if (get("action") == "history" && get("proccess") == "banned") { echo "active"; } ?>" href="<?php echo urlConverter("profile_history_ban", $languageType); ?>"><?php echo languageVariables("bannedTrans", "profile", $languageType); ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if (get("action") == "profile") { ?>
    <?php if (get("proccess") == "profile") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("profile", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("profileDetail", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <?php
          $searchNewsLike = $db->prepare("SELECT * FROM newsLike WHERE userID = ? ORDER BY id DESC");
          $searchNewsLike->execute(array($readAccount["id"]));
        ?>
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("likes", "words", $languageType); ?> (<?php echo $searchNewsLike->rowCount(); ?>)</p>
          <div class="widget-box-content">
            <?php if ($searchNewsLike->rowCount() > 0) { ?>
            <div class="dropdown-box-list scroll-small no-hover" data-simplebar>
              <?php foreach ($searchNewsLike as $readNewsLike) { ?>
              <?php $searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?"); ?>
              <?php $searchNews->execute(array($readNewsLike["newsID"])); ?>
              <?php if ($searchNews->rowCount() > 0) { ?>
              <?php $readNews = $searchNews->fetch(); ?>
              <div class="dropdown-box-list-item">
                <div class="cart-item-preview">
                  <a class="cart-item-preview-image" href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNews["title"]) . "/" . $readNews["id"]; ?>">
                    <figure class="picture medium round liquid">
                      <img src="<?php echo $readNews["image"]; ?>" alt="<?php echo languageVariables("blog", "words", $languageType); ?> - <?php echo $readNews["title"]; ?>">
                    </figure>
                  </a>
                  <p class="cart-item-preview-title" style="top: .7rem;"><a href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNews["title"]) . "/" . $readNews["id"]; ?>"><?php echo $readNews["title"]; ?></a></p>
                  <p class="cart-item-preview-text"><?php echo $readNews["categoryName"]; ?></p>
                  <p class="cart-item-preview-price"><?php echo checkTime($readNewsLike["date"]); ?></p>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
            <?php } else { echo alert(languageVariables("alertNotLikeTrans", "profile", $languageType), "warning", "0", "/"); } ?>
          </div>
        </div>

        <?php
              $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE username = ? ORDER BY id DESC");
              $searchNewsComments->execute(array($readAccount["username"]));
            ?>
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("comments", "words", $languageType); ?> (<?php echo $searchNewsComments->rowCount(); ?>)</p>
          <div class="widget-box-content">
            <?php if ($searchNewsComments->rowCount() > 0) { ?>
            <div class="dropdown-box-list scroll-small no-hover" data-simplebar>
              <?php foreach ($searchNewsComments as $readNewsComments) { ?>
              <?php $searchNewsC = $db->prepare("SELECT * FROM newsList WHERE id = ?"); ?>
              <?php $searchNewsC->execute(array($readNewsComments["newsID"])); ?>
              <?php if ($searchNewsC->rowCount() > 0) { ?>
              <?php $readNewsC = $searchNewsC->fetch(); ?>
              <div class="dropdown-box-list-item">
                <div class="cart-item-preview">
                  <a class="cart-item-preview-image" href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNewsC["title"]) . "/" . $readNewsC["id"]; ?>">
                    <figure class="picture medium round liquid">
                      <img src="<?php echo $readNewsC["image"]; ?>" alt="<?php echo languageVariables("blog", "words", $languageType); ?> - <?php echo $readNewsC["title"]; ?>">
                    </figure>
                  </a>
                  <p class="cart-item-preview-title" style="top: .7rem;"><a href="<?php echo urlConverter("blog", $languageType)."/" . createSlug($readNewsC["title"]) . "/" . $readNewsC["id"]; ?>"><?php echo $readNewsC["title"]; ?></a></p>
                  <p class="cart-item-preview-text"><?php if ($readNewsComments["status"] == "0") { echo languageVariables("notApproved", "words", $languageType); } else if ($readNewsComments["status"] == "1") { echo languageVariables("approved", "words", $languageType); } ?></p>
                  <p class="cart-item-preview-price"><?php echo checkTime($readNewsComments["date"]); ?></p>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
            <?php } else { echo alert(languageVariables("alertNotCommentTrans", "profile", $languageType), "warning", "0", "/"); } ?>
          </div>
        </div>

        <?php
              $searchProductRates = $db->prepare("SELECT * FROM productRates WHERE userID = ? ORDER BY id DESC");
              $searchProductRates->execute(array($readAccount["id"]));
        ?>
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("starProducts", "words", $languageType); ?> (<?php echo $searchProductRates->rowCount(); ?>)</p>
          <div class="widget-box-content">
            <?php if ($searchProductRates->rowCount() > 0) { ?>
            <div class="dropdown-box-list scroll-small no-hover" data-simplebar>
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
              <div class="dropdown-box-list-item">
                <div class="cart-item-preview">
                  <a class="cart-item-preview-image" href="<?php echo urlConverter("store", $languageType)."/".createSlug($readRatesProductServer["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readRatesProductCategory["name"]))."/".createSlug($readRatesProduct["name"])."/".$readRatesProduct["id"]; ?>">
                    <figure class="picture medium round liquid">
                      <img src="<?php echo $readRatesProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readRatesProduct["name"]; ?>">
                    </figure>
                  </a>
                  <p class="cart-item-preview-title" style="top: .7rem;"><a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readRatesProductServer["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readRatesProductCategory["name"]))."/".createSlug($readRatesProduct["name"])."/".$readRatesProduct["id"]; ?>"><?php echo $readRatesProduct["name"]; ?></a></p>
                  <p class="cart-item-preview-text"><?php echo $readRatesProductServer["name"]; ?></p>
                  <p class="cart-item-preview-price"><?php echo checkTime($readProductRates["date"]); ?></p>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
            <?php } else { echo alert(languageVariables("alertStarAddProduct", "profile", $languageType), "warning", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
    <?php } else if (get("proccess") == "message") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("profile", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("messages", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("messageSend", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <?php
                if ($readAccount["profileMessageStatus"] == "1") {
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
            <form action="" method="POST">
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="post-reply"><?php echo languageVariables("messagePlaceholder", "profile", $languageType); ?></label>
                    <input type="text" id="post-reply" name="message">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("messageToken"); ?>
                  <button class="button small primary right" type="submit" name="goMessage"><?php echo languageVariables("send", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
            <?php } else { echo alert(languageVariables("alertProfileMessageDisable", "profile", $languageType), "warning", "0", "/"); }?>
          </div>
        </div>
        <?php
              $searchAccountsMessage = $db->prepare("SELECT * FROM accountsMessage WHERE userID = ? ORDER BY id DESC");
              $searchAccountsMessage->execute(array($readAccount["id"]));
              if ($searchAccountsMessage->rowCount() > 0) {
        ?>
        <div class="notification-box-list">
          <?php foreach ($searchAccountsMessage as $readAccountsMessage) { ?>
          <div class="notification-box">
            <div class="user-status notification">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readAccountsMessage["messageAuthorUsername"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readAccountsMessage["messageAuthorUsername"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><a class="bold" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readAccountsMessage["messageAuthorUsername"]; ?>" target="_blank"><?php echo $readAccountsMessage["messageAuthorUsername"]; ?></a><br><span class="ml-2"><?php echo $readAccountsMessage["message"]; ?></span></p>
              <div class="user-status-icon">
                <p class="user-status-timestamp small-space"><?php echo checkTime($readAccountsMessage["date"]); ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } else { echo alert(languageVariables("alertNotProfileMessage", "profile", $languageType), "danger", "0", "/"); } ?>
      </div>
    </div>
    <?php } else if (get("proccess") == "notifications") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("profile", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("notifications", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box" style="height: 600px; overflow: scroll; overflow-x: hidden; background: none; border: none;">
          <?php
              $searchAccountsNotification = $db->prepare("SELECT * FROM accountsNotifications WHERE userID = ? ORDER BY id DESC");
              $searchAccountsNotification->execute(array($readAccount["id"]));
              if ($searchAccountsNotification->rowCount() > 0) {
          ?>
          <div class="notification-box-list">
            <?php foreach ($searchAccountsNotification as $readAccountsNotification) { ?>
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
            <div class="notification-box">
              <div class="user-status notification">
                <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $notificationUsername; ?>">
                  <img src="https://minotar.net/bust/<?php echo $notificationUsername; ?>/100.png" width="40" height="40">
                </a>
                <p class="user-status-title"><?php echo $readNotificationsText; ?></p>
                <p class="user-status-timestamp small-space"><?php echo checkTime($readAccountsNotification["date"]); ?></p>
                <div class="user-status-icon">
                  <svg class="icon-<?php echo $readNotificationData["iconType"]; ?>">
                    <use xlink:href="#svg-<?php echo $readNotificationData["iconType"]; ?>"></use>
                  </svg>
                </div>
              </div>
              <?php if ($readAccountsNotification["status"] == "unread") { ?>
              <div class="mark-unread-button"></div>
              <?php } ?>
            </div>
            <?php } ?>
          </div>
          <?php } else { echo alert(languageVariables("alertNotificationHistory", "profile", $languageType), "danger", "0", "/"); } ?>
        </div>
      </div>
    </div>
    <?php $updateNotificationRead = $db->prepare("UPDATE accountsNotifications SET status = ? WHERE userID = ? AND status = ?"); ?>
    <?php $updateNotificationRead->execute(array("read", $readAccount["id"], "unread")); ?>
    <?php } ?>
    <?php } else if (get("action") == "account") { ?>
    <?php if (get("proccess") == "change") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("accountInfo", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("edit", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <!-- FORM -->
            <?php
                  require_once(__DR__."/main/includes/packages/class/csrf/class.php");
                  $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                  if (isset($_POST["updateAccount"])) {
                    if ($safeCsrfToken->validate('updateAccountToken')) {
                      if (post("currentPassword") !== "" && post("accountEmail") !== "" && post("accountDiscord") !== "" && post("accountSkype") !== "" && post("accountInstagram") !== "" && post("accountTwitter") !== "" && post("accountYoutube") !== "") {
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
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-current-password"><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                    <input type="password" id="account-current-password" name="currentPassword">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input small active">
                    <label for="account-username"><?php echo languageVariables("username", "words", $languageType); ?></label>
                    <input type="text" id="account-username" value="<?php echo $readAccount["username"]; ?>" readonly>
                  </div>
                </div>
                <div class="form-item">
                  <div class="form-input small active">
                    <label for="account-email"><?php echo languageVariables("email", "words", $languageType); ?></label>
                    <input type="text" id="account-email" name="accountEmail" value="<?php echo $readAccount["email"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover discord">
                      <svg class="icon-discord">
                        <use xlink:href="#svg-discord"></use>
                      </svg>
                    </div>
                    <label for="account-discord"><?php echo languageVariables("discordUsername", "profile", $languageType); ?></label>
                    <input type="text" id="account-discord" name="accountDiscord" value="<?php echo $readAccount["discord"]; ?>">
                  </div>
                </div>
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover facebook">
                      <svg class="icon-facebook">
                        <i class="faj fa-skype" style="margin-right: 0.80rem; color: white; font-weight: 500;"></i>
                      </svg>
                    </div>
                    <label for="account-skype"><?php echo languageVariables("skypeUsername", "profile", $languageType); ?></label>
                    <input type="text" id="account-skype" name="accountSkype" value="<?php echo $readAccount["skype"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover instagram">
                      <svg class="icon-instagram">
                        <use xlink:href="#svg-instagram"></use>
                      </svg>
                    </div>
                    <label for="account-instagram"><?php echo languageVariables("instagramUsername", "profile", $languageType); ?></label>
                    <input type="text" id="account-instagram" name="accountInstagram" value="<?php echo $readAccount["instagram"]; ?>">
                  </div>
                </div>
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover twitter">
                      <svg class="icon-twitter">
                        <use xlink:href="#svg-twitter"></use>
                      </svg>
                    </div>
                    <label for="account-twitter"><?php echo languageVariables("twitterUsername", "profile", $languageType); ?></label>
                    <input type="text" id="account-twitter" name="accountTwitter" value="<?php echo $readAccount["twitter"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover youtube">
                      <svg class="icon-youtube">
                        <use xlink:href="#svg-youtube"></use>
                      </svg>
                    </div>
                    <label for="account-twitter"><?php echo languageVariables("youtubeUsername", "profile", $languageType); ?></label>
                    <input type="text" id="account-twitter" name="accountYoutube" value="<?php echo $readAccount["youtube"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("updateAccountToken"); ?>
                  <button class="button full primary" type="submit" name="updateAccount"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
            <!-- /FORM -->
          </div>
        </div>
      </div>
    </div>
    <?php } else if (get("proccess") == "password") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("passwordChange", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("passwordChange", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <!-- FORM -->
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
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-current-password"><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                    <input type="password" id="account-current-password" name="currentPassword">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-new-password"><?php echo languageVariables("newPassword", "words", $languageType); ?></label>
                    <input type="password" id="account-new-password" name="newPassword">
                  </div>
                </div>
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-new-password-confirm"><?php echo languageVariables("newPasswordRe", "words", $languageType); ?></label>
                    <input type="password" id="account-new-password-confirm" name="newPasswordRe">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <?php echo $safeCsrfToken->input("changePasswordToken"); ?>
                  <button class="button full primary" type="submit" name="changePassword"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
            <!-- /FORM -->
          </div>
        </div>
      </div>
    </div>
    <?php } else if (get("proccess") == "settings") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("generalSettings", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("edit", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <!-- FORM -->
            <?php
                  require_once(__DR__."/main/includes/packages/class/csrf/class.php");
                  $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                  if (isset($_POST["accountSettings"])) {
                    if ($safeCsrfToken->validate('accountSettingsToken')) {
                      if (post("currentPassword") !== "") {
                        if (controlSHA256(post("currentPassword"), $readAccount["password"]) == "OK") {
                          if ($_FILES["avatarImage"]["name"] != null) {
                            if ($_FILES["avatarImage"]["size"]<1024*1024*1024*1024) {
                              if ($_FILES["avatarImage"]["type"]=="image/png" or $_FILES["avatarImage"]["type"]=="image/jpeg" or $_FILES["avatarImage"]["type"]=="image/gif") {
                                require_once(__DR__."/main/includes/packages/class/upload/upload.php");
                                $imageUpload = new Upload($_FILES["avatarImage"], "tr_TR");
							               	  $generateBigCharacter = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
								                $generateSmallCharacter = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
								                $randImageCode = $generateSmallCharacter[rand(0,26)].rand(1,10).$generateBigCharacter[rand(0,26)].rand(1,10).$generateBigCharacter[rand(0,26)].rand(1,10);
                                $avatarImageName = $readAccount["username"]."-".$readAccount["id"]."-".$randImageCode;
                                if ($imageUpload->uploaded) {
                                  $imageUpload->allowed = array("image/*");
                                  $imageUpload->file_overwrite = true;
                                  $imageUpload->file_new_name_body = $avatarImageName;
                                  $imageUpload->Process(__DR__."/main/themes/south/libs/includes/images/avatar/");
                                  if ($imageUpload->processed) {
                                    $avatarImageNameAccount = "/main/themes/south/libs/includes/images/avatar/".$avatarImageName.".".$imageUpload->file_dst_name_ext;
                                    $updateAccountSettings = $db->prepare("UPDATE accounts SET imageAvatar = ?, notificationStatus = ?, profileMessageStatus = ? WHERE id = ?");
                                    $updateAccountSettings->execute(array($avatarImageNameAccount, post("notificationStatus"), post("profileMessageStatus"), $readAccount["id"]));
                                    echo alert(languageVariables("alertSaveChanges", "profile", $languageType), "success", "5", "");
                                  } else {
                                    echo alert(languageVariables("alertSystem", "profile", $languageType), "danger", "0", "/");
                                  }
                                } else {
                                  echo alert(languageVariables("alertSystem", "profile", $languageType), "danger", "0", "/");
                                }
                              } else {
                                echo alert(languageVariables("alertImageType", "profile", $languageType), "danger", "0", "/");
                              }
                            } else {
                              echo alert(languageVariables("alertImageSize", "profile", $languageType), "danger", "0", "/");
                            }
                          } else {
                            $updateAccountSettings = $db->prepare("UPDATE accounts SET notificationStatus = ?, profileMessageStatus = ? WHERE id = ?");
                            $updateAccountSettings->execute(array(post("notificationStatus"), post("profileMessageStatus"), $readAccount["id"]));
                            echo alert(languageVariables("alertSaveChanges", "profile", $languageType), "success", "3", "");
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
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-current-password"><?php echo languageVariables("currentPassword", "words", $languageType); ?></label>
                    <input type="password" id="account-current-password" name="currentPassword">
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readAccount["imageAvatar"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="account-current-avatar-image"><?php echo languageVariables("imagePlaceholder", "profile", $languageType); ?></label>
                      <input type="file" id="account-current-avatar-image" name="avatarImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div class="switch-option-list">
                    <div class="switch-option">
                      <p class="switch-option-title"><?php echo languageVariables("notifications", "words", $languageType); ?></p>
                      <p class="switch-option-text"><?php echo languageVariables("notificationsPlaceholder", "profile", $languageType); ?></p>
                      <div class="form-switch <?php if ($readAccount["notificationStatus"] == "1") { echo "active"; }?>">
                        <div onclick="changeSwitch('notificationStatus')" class="form-switch-button"></div>
                        <input type="hidden" name="notificationStatus" id="notificationStatus" value="<?php echo $readAccount["notificationStatus"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div class="switch-option-list">
                    <div class="switch-option">
                      <p class="switch-option-title"><?php echo languageVariables("profileMessage", "words", $languageType); ?></p>
                      <p class="switch-option-text"><?php echo languageVariables("profileMessagePlaceholder", "profile", $languageType); ?></p>
                      <div class="form-switch <?php if ($readAccount["profileMessageStatus"] == "1") { echo "active"; }?>">
                        <div onclick="changeSwitch('profileMessageStatus')" class="form-switch-button"></div>
                        <input type="hidden" name="profileMessageStatus" id="profileMessageStatus" value="<?php echo $readAccount["profileMessageStatus"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <?php echo $safeCsrfToken->input("accountSettingsToken"); ?>
                  <button class="button full primary" type="submit" name="accountSettings"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
            <!-- /FORM -->
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php } else if (get("action") == "history") { ?>
    <?php if (get("proccess") == "chest") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("chest", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
        <?php $searchChestHistory->execute(array($readAccount["username"])); ?>
        <?php if ($searchChestHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("product", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("trans", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("username", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("price", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("server", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchChestHistory as $readChestHistory) { ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readChestHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title"><span class="highlighted"><?php echo $readChestHistory["productName"]; ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php if($readChestHistory["type"] == "0") { ?><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("productActive", "words", $languageType); ?>"></i> <?php } else if($readChestHistory["type"] == "1") { if ($readChestHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftSender", "words", $languageType); ?>"></i><?php } else if ($readChestHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-gift" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("giftTransfer", "words", $languageType); ?>"></i><?php } } ?></p>
                </div>
                <?php if($readChestHistory["type"] == "0") { ?>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readChestHistory["username"]; ?></p>
                </div>
                <?php } else if($readChestHistory["type"] == "1") { ?>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readChestHistory["usernameTo"]; ?></p>
                </div>
                <?php } ?>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readChestHistory["productPrice"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readChestHistory["serverName"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readChestHistory["date"]; ?></p>
                </div>
                <?php if($readChestHistory["type"] == "0") { ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } else if($readChestHistory["type"] == "1") { ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap negative">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-minus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertChestHistory", "profile", $languageType), "danger", "0", "/"); } ?>
        <!-- /TABLE -->
      </div>
    </div>
    <?php } else if (get("proccess") == "store") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("store", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
        <?php $searchStoreHistory->execute(array($readAccount["username"])); ?>
        <?php if ($searchStoreHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("product", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("price", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("server", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
              <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
              <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
              <?php $readServerList = $searchServerList->fetch(); ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readStoreHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title"><span class="highlighted"><?php echo $readStoreHistory["productName"]; ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readStoreHistory["productPrice"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readServerList["name"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readStoreHistory["date"]; ?></p>
                </div>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertStoreHistory", "profile", $languageType), "danger", "0", "/"); } ?>
        <!-- /TABLE -->
      </div>
    </div>
    <?php } else if (get("proccess") == "credit") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("credi", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchCreditHistory = $db->prepare("SELECT * FROM creditHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
        <?php $searchCreditHistory->execute(array($readAccount["username"])); ?>
        <?php if ($searchCreditHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("username", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("trans", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("amount", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readCreditHistory["id"]; ?></p>
                </div>
                <?php if($readCreditHistory["type"] == "0") { ?>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readCreditHistory["username"]; ?></p>
                </div>
                <?php } else if($readCreditHistory["type"] == "1") { ?>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readCreditHistory["usernameTo"]; ?></p>
                </div>
                <?php } ?>
                <div class="table-column centered padded">
                  <p class="table-title"><?php if($readCreditHistory["type"] == "0") { if($readCreditHistory["method"] == "0") { ?><i class="fa fa-mobile" data-toggle="tooltip" data-placement="top" title="Mobil Ödeme"></i><?php } else { ?><i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Kredi Kartı İle Ödeme"></i><?php } } else if($readCreditHistory["type"] == "1") { if ($readCreditHistory["username"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Kredi (Gönderen)"></i><?php } else if ($readCreditHistory["usernameTo"] == $readAccount["username"]) { ?><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Kredi (Alan)"></i><?php } } ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readCreditHistory["amount"]; ?> <?php echo languageVariables("credi", "words", $languageType); ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readCreditHistory["date"]; ?></p>
                </div>
                <?php if($readCreditHistory["type"] == "0") { ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } else if($readCreditHistory["type"] == "1") { ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap negative">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-minus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertCreditHistory", "profile", $languageType), "danger", "0", "/"); } ?>
        <!-- /TABLE -->
      </div>
    </div>
    <?php } else if (get("proccess") == "card") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("cardGame", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchCardHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
        <?php $searchCardHistory->execute(array($readAccount["id"])); ?>
        <?php if ($searchCardHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("reward", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("games", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("gameType", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("gamePrice", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchCardHistory as $readCardHistory) { ?>
              <?php $searchCard = $db->prepare("SELECT * FROM cardGame WHERE id = ?"); ?>
              <?php $searchCard->execute(array($readCardHistory["cardID"])); ?>
              <?php $readCard = $searchCard->fetch(); ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readCardHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title"><span class="highlighted"><?php echo $readCardHistory["reward"]; ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readCard["name"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php if ($readCard["type"] == "1") { echo languageVariables("paid", "words", $languageType); } else if ($readCard["type"] == "0") { echo languageVariables("free", "words", $languageType); } ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php if ($readCard["type"] == "1") { echo $readCard["price"]." ".languageVariables("credi", "words", $languageType); } else if ($readCard["type"] == "0") { echo $readCard["hours"]." ".languageVariables("hours", "words", $languageType); } ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readCardHistory["date"]; ?></p>
                </div>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertCardGameHistory", "profile", $languageType), "danger", "0", "/"); }?>
        <!-- /TABLE -->
      </div>
    </div>
    <?php } else if (get("proccess") == "coupon") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchCouponHistory = $db->prepare("SELECT * FROM couponHistory WHERE userID = ? ORDER BY id DESC LIMIT 6"); ?>
        <?php $searchCouponHistory->execute(array($readAccount["id"])); ?>
        <?php if ($searchCouponHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("rewards", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("couponCode", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
              <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
              <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
              <?php $readCoupon = $searchCoupon->fetch(); ?>
              <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
              <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
              <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readCouponHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title"><span class="highlighted"><?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." "; } else { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readCoupon["code"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readCouponHistory["date"]; ?></p>
                </div>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertCouponHistory", "profile", $languageType), "danger", "0", "/"); } ?>
        <!-- /TABLE -->
      </div>
    </div>
    <?php } else if (get("proccess") == "banned") { ?>
    <div class="account-hub-content">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("transHistory", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("bannedTitle", "profile", $languageType); ?></h2>
        </div>
      </div>
      <div class="grid-column">
        <!-- TABLE -->
        <?php $searchBannedHistory = $db->prepare("SELECT * FROM banned WHERE username = ? ORDER BY id DESC"); ?>
        <?php $searchBannedHistory->execute(array($readAccount["username"])); ?>
        <?php if ($searchBannedHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("reason", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("expiryDate", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readBannedHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title"><span class="highlighted"><?php if ($readBannedHistory["type"] == "login") { echo languageVariables("site", "words", $languageType); } else if ($readBannedHistory["type"] == "support") { echo languageVariables("support", "words", $languageType); } else if ($readBannedHistory["type"] == "comment") { echo languageVariables("comment", "words", $languageType); } ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readBannedHistory["reason"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <?php if ($readBannedHistory["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDate = languageVariables("indefinite", "words", $languageType); } else { if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) { $userBannedBackDate = max(round((strtotime($readBannedHistory["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } else { $userBannedBackDate = languageVariables("end", "words", $languageType); } } ?>
                  <p class="table-title"><?php echo $userBannedBackDate; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo $readBannedHistory["date"]; ?></p>
                </div>
                <?php if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) {  ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap positive">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-plus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } else { ?>
                <div class="table-column padded-left">
                  <div class="percentage-diff-icon-wrap negative">
                    <svg class="percentage-diff-icon icon-plus-small">
                      <use xlink:href="#svg-minus-small"></use>
                    </svg>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("bannedHistoryAlert", "profile", $languageType), "danger", "0", "/"); }?>
        <!-- /TABLE -->
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("activeBans", "profile", $languageType); ?></p>
          <div class="widget-box-content">
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
    <?php } ?>
    <?php } ?>
  </div>
</div>