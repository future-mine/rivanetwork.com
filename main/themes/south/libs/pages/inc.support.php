<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/support/css/themes/south/<?php echo $_SESSION["themeModeType"]; ?>/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<?php if (get("action") == "get") { ?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- SUPPORT -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("myTickets", "words", $languageType); ?></h2>
          </div>
        </div>
        <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="button full primary"><?php echo languageVariables("createTicket", "words", $languageType); ?></a>
        <!-- TABLE -->
        <?php $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC"); ?>
        <?php $searchSupportHistory->execute(array($readAccount["username"])); ?>
        <?php if ($searchSupportHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("title", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("server", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("status", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
            </div>
            <div class="table-body same-color-rows">
              <?php foreach ($searchSupportHistory as $readSupportHistory) { ?>
              <div class="table-row micro">
                <div class="table-column centered padded">
                  <p class="table-text">#<?php echo $readSupportHistory["id"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <a class="table-title" href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"])."/".$readSupportHistory["id"]; ?>"><span class="highlighted"><?php echo $readSupportHistory["title"]; ?></span></a>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readSupportHistory["category"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title"><?php echo $readSupportHistory["serverName"]; ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-text"><?php echo checkTime($readSupportHistory["lastUpdate"]); ?></p>
                </div>
                <div class="table-column centered padded">
                  <p class="table-title">
                    <?php if ($readSupportHistory["status"] == 0) { ?>
                    <span class="support-tag status-open"><?php echo languageVariables("notAnswered", "words", $languageType); ?></span>
                    <?php } else if ($readSupportHistory["status"] == 1) { ?>
                    <span class="support-tag status-reply"><?php echo languageVariables("answered", "words", $languageType); ?></span>
                    <?php } else if ($readSupportHistory["status"] == 2) { ?>
                    <span class="support-tag status-disabled"><?php echo languageVariables("closed", "words", $languageType); ?></span>
                    <?php } ?>
                  </p>
                </div>
                <div class="table-column padded-left">
                  <a href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"])."/".$readSupportHistory["id"]; ?>" class="percentage-diff-icon-wrap positive mb-2 text-tooltip-tft" data-title="<?php echo languageVariables("view", "words", $languageType); ?>">
                    <svg class="percentage-diff-icon icon-tags">
                      <use xlink:href="#svg-tags"></use>
                    </svg>
                  </a>
                  <div class="percentage-diff-icon-wrap negative text-tooltip-tft" data-title="<?php echo languageVariables("ticketClosed", "words", $languageType); ?>" onclick="deletedSupport('<?php echo $readSupportHistory["id"]; ?>');">
                    <svg class="percentage-diff-icon icon-cross">
                      <use xlink:href="#svg-cross"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertHistory", "support", $languageType), "warning", "0", "/"); } ?>
        <!-- /TABLE -->
      </div>
      <!-- /SUPPORT -->
      
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("stats", "words", $languageType); ?></h2>
          </div>
        </div>
        <?php
        $countReply = $db->prepare("SELECT R.id FROM supportReply R INNER JOIN supportList L ON R.supportID = L.id WHERE L.username = ? AND R.type = ? ORDER BY R.id");
        $countReply->execute(array($readAccount["username"], 1));
        $countSupport = $db->prepare("SELECT * FROM supportList WHERE username = ?");
        $countSupport->execute(array($readAccount["username"])); 
        ?>
        <div class="stats-decoration secondary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-comment">
              <use xlink:href="#svg-comment"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countReply->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("replys", "words", $languageType); ?></p>
        </div>
        <div class="stats-decoration primary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-pinned">
              <use xlink:href="#svg-pinned"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countSupport->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("myTicket", "words", $languageType); ?></p>
        </div>
      </div>
    </div>
</div>
<?php } else if (get("action") == "create") { ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- SUPPORT -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("createTicketTitle", "support", $languageType); ?></h2>
          </div>
		  </div>
        <div class="widget-box">
          <div class="widget-box-content">
            <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["supportCreate"])) {
              if ($safeCsrfToken->validate('supportCreateToken')) {
                if (post("title") !== "" && post("message") !== "") {
                  if (isset($_POST['g-recaptcha-response'])) {
                    $supportRecaptcha = $_POST['g-recaptcha-response'];
                  }
                  if ($rSettings['recaptchaStatus'] == 0 || $supportRecaptcha) {
                    $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                    $bannedQuery->execute(array($readAccount["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                    if ($bannedQuery->rowCount() == 0) {
                      $searchAccountsSupport = $db->prepare("SELECT * FROM supportList WHERE username = ? AND status = ?");
                      $searchAccountsSupport->execute(array($readAccount["username"], 0));
                      if ($readModule["maxSupportLimit"] == "0" || $readModule["maxSupportLimit"] > $searchAccountsSupport->rowCount()) {
                        $supportCreate = $db->prepare("INSERT INTO supportList SET username = ?, title = ?, category = ?, message = ?, status = ?, lastUpdate = ?, date = ?, serverName = ?");
                        $supportCreate->execute(array($readAccount["username"], post("title"), post("category"), str_replace("/n", "<br>", strip_tags($_POST["message"])), 0, date("d.m.Y H:i:s"), date("d.m.Y H:i:s"), post("server")));
                        if ($supportCreate) {
                          $searchSupport = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC LIMIT 1");
                          $searchSupport->execute(array($readAccount["username"]));
                          if ($searchSupport->rowCount() > 0) {
                            $readSupport = $searchSupport->fetch();
                            $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL."admin/destek/goruntule/".$readSupport["id"]), $readWebhooks["webhookSupportDescription"]);
                            $hookObject = json_encode([
                              "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookSupportName"]),
                              "avatar_url" => avatarAPI($readAccount["username"], 100),
                              "tts" => false,
                              "embeds" => [
                                 [
                                      "title" => $readWebhooks["webhookSupportTitle"],
                                      "type" => "rich",
                                      "image" => ($readWebhooks["webhookSupportImage"] !== "0") ? [
                                        "url" => $readWebhooks["webhookSupportImage"]
                                      ] : [],
                                      "description" => $webhookDescription,
                                      "color" => hexdec(rand_color()),
                                      "footer" => ($readWebhooks["webhookSupportSignature"] == "1") ? [
                                          "text" => "Powered by MineXON",
                                          "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                                      ] : []
                                  ]
                              ]
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                            $sendWebhook = (($readWebhooks["webhookSupportStatus"] == "1") ? webhooks($readWebhooks["webhookSupportAPI"], $hookObject) : "OK");
                          }
                        }
                        echo alert(languageVariables("alertTicketSuccess", "support", $languageType), "success", "3", urlConverter("support", $languageType));
                      } else {
                        echo alert(languageVariables("alertLimitTicket", "support", $languageType), "danger", "0", "/");
                      }
                    } else {
                      $readBanned = $bannedQuery->fetch();
                      if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") { 
                        $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                      } else {
                        $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType);
                      }
                      echo alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBanned", "support", $languageType)), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertRobot", "support", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
              }
            }
            ?>
            <form action="" method="POST">
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="support-title"><?php echo languageVariables("title", "words", $languageType); ?></label>
                    <input type="text" id="support-title" name="title">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-select">
                    <label for="support-category"><?php echo languageVariables("category", "words", $languageType); ?></label>
                    <select id="support-category" name="category">
                      <?php $searchSupportCategory = $db->query("SELECT * FROM supportCategory ORDER BY id DESC"); ?>
                      <?php foreach ($searchSupportCategory as $readCategory) { ?>
                      <option value="<?php echo $readCategory["title"]; ?>"><?php echo $readCategory["title"]; ?></option>
                      <?php } ?>
                    </select>
                    <svg class="form-select-icon icon-small-arrow">
                      <use xlink:href="#svg-small-arrow"></use>
                    </svg>
                  </div>
                </div>
                <div class="form-item">
                  <div class="form-select">
                    <label for="support-category"><?php echo languageVariables("server", "words", $languageType); ?></label>
                    <select id="support-category" name="server">
                      <?php $searchServer = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                      <?php if ($searchServer->rowCount() > 0) { ?>
                      <?php foreach ($searchServer as $readServer) { ?>
                      <option value="<?php echo $readServer["name"]; ?>"><?php echo $readServer["name"]; ?></option>
                      <?php } } else { ?>
                      <option value="<?php echo languageVariables("none", "words", $languageType); ?>"><?php echo languageVariables("none", "words", $languageType); ?></option>
                      <?php } ?>
                    </select>
                    <svg class="form-select-icon icon-small-arrow">
                      <use xlink:href="#svg-small-arrow"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <textarea id="support-message" name="message" placeholder="<?php echo languageVariables("messagePlaceholder", "support", $languageType); ?>"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("supportCreateToken"); ?>
                  <button class="button w-25 primary" style="float:right;" type="submit" name="supportCreate"><?php echo languageVariables("create", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /SUPPORT -->
      
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("stats", "words", $languageType); ?></h2>
          </div>
        </div>
        <?php
        $countReply = $db->prepare("SELECT R.id FROM supportReply R INNER JOIN supportList L ON R.supportID = L.id WHERE L.username = ? AND R.type = ? ORDER BY R.id");
        $countReply->execute(array($readAccount["username"], 1));
        $countSupport = $db->prepare("SELECT * FROM supportList WHERE username = ?");
        $countSupport->execute(array($readAccount["username"])); 
        ?>
        <div class="stats-decoration secondary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-comment">
              <use xlink:href="#svg-comment"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countReply->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("replys", "words", $languageType); ?></p>
        </div>
        <div class="stats-decoration primary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-pinned">
              <use xlink:href="#svg-pinned"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countSupport->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("myTicket", "words", $languageType); ?></p>
        </div>
      </div>
    </div>
</div>
<?php } else if (get("action") == "update") { ?>
  <?php if (isset($_GET["id"])) { ?>
  <?php $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ? AND username = ?"); ?>
  <?php $searchSupport->execute(array(get("id"), $readAccount["username"])); ?>
  <?php if ($searchSupport->rowCount() > 0) { ?>
  <?php $readSupport = $searchSupport->fetch(); ?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- SUPPORT -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title">
              <?php if ($readSupport["status"] == 0) { ?>
              <span class="support-tag status-open" style="bottom: .3rem;"><?php echo languageVariables("notAnswered", "words", $languageType); ?></span>
              <?php } else if ($readSupport["status"] == 1) { ?>
              <span class="support-tag status-reply mb-2" style="bottom: .3rem;"><?php echo languageVariables("answered", "words", $languageType); ?></span>
              <?php } else if ($readSupport["status"] == 2) { ?>
              <span class="support-tag status-disabled mb-2" style="bottom: .3rem;"><?php echo languageVariables("closed", "words", $languageType); ?></span>
              <?php } ?>
              <?php echo $readSupport["title"]; ?>
            </h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-box-content">
            <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["messageSend"]) && $readSupport["lockStatus"] == "0") {
              if ($safeCsrfToken->validate('messageSendToken')) {
                if (post("message") !== "") {
                  $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                  $bannedQuery->execute(array($readAccount["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                  if ($bannedQuery->rowCount() == 0) {
                    $insertSupportMessage = $db->prepare("INSERT INTO supportReply SET username = ?, message = ?, supportID = ?, type = ?, date = ?");
                    $insertSupportMessage->execute(array($readAccount["username"], post("message"), $readSupport["id"], 0, date("d.m.Y H:i:s")));
                    $updateSupport = $db->prepare("UPDATE supportList SET status = ?, lastUpdate = ? WHERE id = ?");
                    $updateSupport->execute(array(0, date("d.m.Y H:i:s"), $readSupport["id"]));
                    $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL."admin/destek/goruntule/".$readSupport["id"]), $readWebhooks["webhookSupportDescription"]);
                    $hookObject = json_encode([
                      "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookSupportName"]),
                      "avatar_url" => avatarAPI($readAccount["username"], 100),
                      "tts" => false,
                      "embeds" => [
                         [
                              "title" => $readWebhooks["webhookSupportTitle"],
                              "type" => "rich",
                              "image" => ($readWebhooks["webhookSupportImage"] !== "0") ? [
                                "url" => $readWebhooks["webhookSupportImage"]
                              ] : [],
                              "description" => $webhookDescription,
                              "color" => hexdec(rand_color()),
                              "footer" => ($readWebhooks["webhookSupportSignature"] == "1") ? [
                                  "text" => "Powered by MineXON",
                                  "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                              ] : []
                          ]
                      ]
                    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                    $sendWebhook = (($readWebhooks["webhookSupportStatus"] == "1") ? webhooks($readWebhooks["webhookSupportAPI"], $hookObject) : "OK");
                    echo alert(languageVariables("alertSuccessMessage", "support", $languageType), "success", "3", "");
                  } else {
                    $readBanned = $bannedQuery->fetch();
                    if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") { 
                      $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                    } else {
                      $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' gün';
                    }
                    echo alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBanned", "support", $languageType)), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
              }
            }
            ?>
            <div id="support-message-box" class="chat-widget-conversation" style="height: 400px; background: none; overflow: scroll; overflow-x: hidden;">
            <?php
            $searchMessage = $db->prepare("SELECT * FROM supportReply WHERE supportID = ? ORDER BY id ASC");
            $searchMessage->execute(array(get("id")));
            echo "<div class=\"chat-widget-speaker right\"><p class=\"chat-widget-speaker-message\" style=\"display: flex; flex-wrap: wrap;\">" . $readSupport["message"] . "</p><p class=\"chat-widget-speaker-timestamp\">" . checkTime($readSupport["date"]) . "</p></div>";
            if ($searchMessage->rowCount() > 0) {
              foreach ($searchMessage as $readMessage) {
                if ($readMessage["type"] == 0) {
                  echo "<div class=\"chat-widget-speaker right\"><div class=\"chat-widget-speaker-message\">" . $readMessage["message"] . "</div><p class=\"chat-widget-speaker-timestamp\">" . checkTime($readMessage["date"]) . "</p></div>";
                } else {
                  $values = array($readAccount["username"], $readMessage["message"], $rSettings["serverName"], $readMessage["username"], $rSettings["IPAdres"]);
                  $textvalues = array("[username]", "[message]", "[serverName]", "[admin]", "[serverIP]");
                  $readMessage["message"] = str_replace($textvalues, $values, $rSettings['supportMessageTemplate']);
                  echo "<div class=\"chat-widget-speaker left\"><div class=\"chat-widget-speaker-avatar\"><div class=\"user-avatar tiny no-border\"><a class=\"user-avatar-content\" href=\"".urlConverter("player", $languageType)."/" . $readMessage["username"] . "\" target=\"_blank\"><img src=\"https://minotar.net/bust/" . $readMessage["username"] . "/100.png\" width=\"30\" height=\"30\"></a></div></div><div class=\"chat-widget-speaker-message\">" . $readMessage["message"] . "</div><p class=\"chat-widget-speaker-timestamp\">" . checkTime($readMessage["date"]) . " ".str_replace("&username", "<a href=\"".urlConverter("support", $languageType)."/" . $readMessage["username"] . "\" target=\"_blank\">" . $readMessage["username"] . "</a>", languageVariables("messageBy", "support", $languageType))."</p></div>";
                }
              }
            }
            ?>
            </div>
            <br>
            <?php if ($readSupport["lockStatus"] == "0") { ?>
            <form method="POST" action="">
              <div class="form-row split">
                <div class="form-item">
                  <div class="interactive-input small">
                    <textarea id="support-message" name="message" placeholder="<?php echo languageVariables("replyPlaceholder", "support", $languageType); ?>" rows="1"></textarea>
                  </div>
                </div>
                <div class="support-mobile-button">
                  <div class="form-item active">
                    <button class="button full primary" style="margin-top: 4rem;" type="submit" name="messageSend"><?php echo languageVariables("send", "words", $languageType); ?></button>
                  </div>
                </div>
                <?php echo $safeCsrfToken->input("messageSendToken"); ?>
                <div class="support-pc-button">
                  <div class="form-item auto-width">
                    <button type="submit" name="messageSend" class="button primary padded">
                      <svg class="button-icon no-space icon-send-message">
                        <use xlink:href="#svg-send-message"></use>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- /SUPPORT -->
      
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("detail", "words", $languageType); ?></h2>
          </div>
        </div>
        <div class="support-sidebar category">
          <div class="support-sidebar-icon support-icon-category">
            <svg class="support-sidebar-icon-text icon-list-grid-view">
              <use xlink:href="#svg-list-grid-view"></use>
            </svg>
          </div>
          <span class="support-sidebar-title"><?php echo languageVariables("category", "words", $languageType); ?></span>
          <br>
          <span class="support-sidebar-text"><?php echo $readSupport["category"]; ?></span>
        </div>
        <div class="support-sidebar server">
          <div class="support-sidebar-icon support-icon-server">
            <svg class="support-sidebar-icon-text icon-poll">
              <use xlink:href="#svg-poll"></use>
            </svg>
          </div>
          <span class="support-sidebar-title"><?php echo languageVariables("server", "words", $languageType); ?></span>
          <br>
          <span class="support-sidebar-text"><?php echo $readSupport["serverName"]; ?></span>
        </div>
        <div class="support-sidebar update">
          <div class="support-sidebar-icon support-icon-update">
            <svg class="support-sidebar-icon-text icon-clock">
              <use xlink:href="#svg-clock"></use>
            </svg>
          </div>
          <span class="support-sidebar-title"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></span>
          <br>
          <span class="support-sidebar-text"><?php echo checkTime($readSupport["lastUpdate"]); ?></span>
        </div>
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("support", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("stats", "words", $languageType); ?></h2>
          </div>
        </div>
        <?php
        $countReply = $db->prepare("SELECT R.id FROM supportReply R INNER JOIN supportList L ON R.supportID = L.id WHERE L.username = ? AND R.type = ? ORDER BY R.id");
        $countReply->execute(array($readAccount["username"], 1));
        $countSupport = $db->prepare("SELECT * FROM supportList WHERE username = ?");
        $countSupport->execute(array($readAccount["username"])); 
        ?>
        <div class="stats-decoration secondary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-comment">
              <use xlink:href="#svg-comment"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countReply->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("replys", "words", $languageType); ?></p>
        </div>
        <div class="stats-decoration primary">
          <div class="stats-decoration-icon-wrap">
            <svg class="stats-decoration-icon icon-pinned">
              <use xlink:href="#svg-pinned"></use>
            </svg>
          </div>
          <p class="stats-decoration-title"><?php echo $countSupport->rowCount(); ?></p>
          <p class="stats-decoration-text"><?php echo languageVariables("myTicket", "words", $languageType); ?></p>
        </div>
      </div>
    </div>
</div>
  <?php } else { go(rlConverter("support", $languageType)); } ?>
  <?php } else { go(urlConverter("support", $languageType)); } ?>
<?php } ?>