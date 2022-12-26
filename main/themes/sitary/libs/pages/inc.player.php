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
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
  <br>
    <div class="profile-header">
      <figure class="profile-header-cover liquid">
        <img src="<?php echo $readPlayer["imageAvatar"]; ?>" alt="Avatar Image">
      </figure>
      <div class="profile-header-info">
        <div class="user-short-description big">
          <img class="profile-avatar-img-xc" src="https://minotar.net/bust/<?php echo $readPlayer["username"]; ?>/100.png">
          <p class="user-short-description-title">
            <a href="<?php echo urlConverter("profile", $languageType); ?>">
            <span class="mc-player-tag text-tooltip-tft" style="<?php echo "background-color: ".$readPlayerPermission["permColorBG"]."; color: ".$readPlayerPermission["permColorText"].";"; ?>" data-title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readPlayerPermission["permName"]; ?></span>
            <?php echo $readPlayer["username"]; ?>
            </a>
          </p>
          <p class="user-short-description-text"><a href="#"><?php echo languageVariables("emailProtection", "player", $languageType); ?></a></p>
        </div>
        <div class="profile-header-social-links-wrap">
          <div id="profile-header-social-links-slider" class="<?php echo urlConverter("profile", $languageType); ?>">
            <div class="profile-header-social-link">
              <a class="social-link discord" href="<?php echo $readPlayer["discord"]; ?>">
                <svg class="icon-discord">
                  <use xlink:href="#svg-discord"></use>
                </svg>
              </a>
            </div>
            <div class="profile-header-social-link">
              <a class="social-link instagram" href="<?php echo $readPlayer["instagram"]; ?>">
                <svg class="icon-instagram">
                  <use xlink:href="#svg-instagram"></use>
                </svg>
              </a>
            </div>
            <div class="profile-header-social-link">
              <a class="social-link twitter" href="<?php echo $readPlayer["twitter"]; ?>">
                <svg class="icon-twitter">
                  <use xlink:href="#svg-twitter"></use>
                </svg>
              </a>
            </div>
            <div class="profile-header-social-link">
              <a class="social-link facebook" href="<?php echo $readPlayer["skype"]; ?>">
                <svg class="icon-facebook">
                  <i class="faj fa-skype" style="margin-right: 0.80rem; color: white; font-weight: 500;"></i>
                </svg>
              </a>
            </div>
            <div class="profile-header-social-link">
              <a class="social-link youtube" href="<?php echo $readPlayer["youtube"]; ?>">
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
            <p class="user-stat-title"><?php echo $rowCountPlayerProduct; ?></p>
            <p class="user-stat-text"><?php echo languageVariables("chest", "words", $languageType); ?></p>
          </div>
          <div class="user-stat big">
            <p class="user-stat-title"><?php echo $readPlayer["credit"]; ?></p>
            <p class="user-stat-text"><?php echo languageVariables("credi", "words", $languageType); ?></p>
          </div>
          <div class="user-stat big">
            <p class="user-stat-title"><?php echo $rowCountPlayerInvent."/".$readPlayer["inventorySlot"]; ?></p>
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
                <p class="sidebar-menu-header-text"><?php echo languageVariables("profileDetailText", "player", $languageType); ?></p>
              </div>
              <div class="sidebar-menu-body accordion-content-linked accordion-open">
                <a class="sidebar-menu-link <?php if (get("action") == "info") { echo "active"; } ?>" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>"><?php echo languageVariables("detail", "words", $languageType); ?></a>
                <a class="sidebar-menu-link <?php if (get("action") == "message") { echo "active"; } ?>" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>/<?php echo (($languageType == "tr") ? "mesajlar" : "messages"); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if (get("action") == "info") { ?>
          <div class="account-hub-content">
            <div class="section-header">
              <div class="section-header-info">
                <p class="section-pretitle"><?php echo languageVariables("profile", "words", $languageType); ?></p>
                <h2 class="section-title"><?php echo languageVariables("detail", "words", $languageType); ?></h2>
              </div>
            </div>
            <div class="grid-column">
              <!-- TABLE -->
              <?php $searchBannedHistory = $db->prepare("SELECT * FROM banned WHERE username = ? ORDER BY id DESC"); ?>
              <?php $searchBannedHistory->execute(array($readPlayer["username"])); ?>
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
                        <a class="table-title"><span class="highlighted"><?php if ($readBannedHistory["type"] == "login") { echo "Site"; } else if ($readBannedHistory["type"] == "support") { echo "Destek"; } else if ($readBannedHistory["type"] == "comment") { echo "Yorum"; } ?></span></a>
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
              <?php } else { echo alert(languageVariables("alertBannedNot", "player", $languageType), "danger", "0", "/"); }?>
              <!-- /TABLE -->
              <div class="widget-box">
                <p class="widget-box-title"><?php echo languageVariables("bannedTitle", "player", $languageType); ?></p>
                <div class="widget-box-content">
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
          </div>
      <?php } else if (get("action") == "message") { ?>
          <div class="account-hub-content">
            <div class="section-header">
              <div class="section-header-info">
                <p class="section-pretitle"><?php echo languageVariables("profile", "words", $languageType); ?></p>
                <h2 class="section-title"><?php echo languageVariables("messages", "words", $languageType); ?></h2>
              </div>
            </div>
            <div class="grid-column">
              <?php if ($readAccount["profileMessageStatus"] == "1") { ?>
              <div class="widget-box">
                <p class="widget-box-title"><?php echo languageVariables("messageSend", "words", $languageType); ?></p>
                <div class="widget-box-content">
                <?php
                if (isset($_SESSION["incAccountLogin"])) {
                require_once(__DR__."/main/includes/packages/class/csrf/class.php");
                $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                if (isset($_POST["goMessage"])) {
                  if ($safeCsrfToken->validate('messageToken')) {
                    if (post("message") !== "") {
                      $safeMessage = arghMessage(post("message"));
                      $insertMessage = $db->prepare("INSERT INTO accountsMessage SET userID = ?, messageAuthorUsername = ?, message = ?, date = ?");
                      $insertMessage->execute(array($readPlayer["id"], $readAccount["username"], $safeMessage, date("d.m.Y H:i:s")));
                      echo alert(languageVariables("alertMessageSendSuccess", "player", $languageType), "success", "3", "");
                      if ($readPlayer["notificationStatus"] == "1") {
                        $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                        $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("notificationMessage", "profile", $languageType), '{"iconType":"messages","username":"'.$readAccount["username"].'"}', "profileMessage", date("d.m.Y H:i:s"), "unread"));
                      }
                    } else {
                      echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
                  }
                }
                ?>
              	<form action="" method="POST">
                    <div class="form-row">
                      <div class="form-item">
                        <div class="form-input small">
                          <label for="post-reply"><?php echo languageVariables("youMessage", "words", $languageType); ?></label>
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
                <?php } else { echo alert(languageVariables("alertMessageNotLogin", "player", $languageType), "warning", "0", "/"); }?>
                </div>
              </div>
              <?php
              $searchAccountsMessage = $db->prepare("SELECT * FROM accountsMessage WHERE userID = ? ORDER BY id DESC");
              $searchAccountsMessage->execute(array($readPlayer["id"]));
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
                        <div class="user-status-icon"><p class="user-status-timestamp small-space"><?php echo checkTime($readAccountsMessage["date"]); ?></p></div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
              <?php } else { echo alert(languageVariables("alertNotMessage", "player", $languageType), "danger", "0", "/"); } ?>
              <?php } else { echo alert(languageVariables("alertFeatureDisable", "player", $languageType), "warning", "0", "/"); } ?>
            </div>
          </div>
      <?php } ?>
    </div>
</div>
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