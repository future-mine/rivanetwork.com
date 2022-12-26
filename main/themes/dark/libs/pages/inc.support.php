<?php AccountLoginControl(false); ?>
<?php if (get("action") == "get") { ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("support", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("myTicket", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-12 col-12 pt-3 pb-5">
            <div class="bg-dark--3 p-5">
              <div class="d-flex mb-3 justify-content-between align-items-center">
                <h3 class="text-secondary mb-0 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <?php echo languageVariables("myTickets", "words", $languageType); ?>
                </h3>
                <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="btn float-right text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                  <i class="fas fa-plus fa-sm mr-2 btn-icon"></i>
                  <span class="btn-text">
                  <?php echo languageVariables("createTicket", "words", $languageType); ?>
                  </span>
                </a>
              </div>
              <?php $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC"); ?>
              <?php $searchSupportHistory->execute(array($readAccount["username"])); ?>
              <?php if ($searchSupportHistory->rowCount() > 0) { ?>
              <div class="overflow-auto">
                <table class="default-table w-100 table table-hover mb-0">
                  <thead class="bg-dark--5">
                    <tr class="text-secondary font-size-6">
                      <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                        #
                      </th>
                      <th class="font-100 p-3 line-height-1 w-40 border-0">
                      <?php echo languageVariables("title", "words", $languageType); ?>
                      </th>
                      <th class="font-100 p-3 line-height-1 w-20 border-0">
                      <?php echo languageVariables("category", "words", $languageType); ?>
                      </th>
                      <th class="font-100 p-3 line-height-1 w-20 border-0">
                      <?php echo languageVariables("server", "words", $languageType); ?>
                      </th>
                      <th class="font-100 p-3 line-height-1 w-20 border-0">
                      <?php echo languageVariables("lastUpdate", "words", $languageType); ?>
                      </th>
                      <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("status", "words", $languageType); ?>
                      </th>
                      <th class="p-3 pr-4 w-20 border-0">
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-dark--4">
                    <?php foreach ($searchSupportHistory as $readSupportHistory) { ?>
                    <tr class="text-white font-size-7">
                      <th class="p-3 border-bottom font-100 pl-4 line-height-1 w-10 o-25" scope="row"><?php echo $readSupportHistory["id"]; ?></th>
                      <td class="p-3 border-bottom font-100 line-height-1 w-40 text-nowrap text-truncate"><?php echo $readSupportHistory["title"]; ?></td>
                      <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap o-25 text-truncate"><?php echo $readSupportHistory["category"]; ?></td>
                      <td class="p-3 border-bottom font-100 line-height-1 w-40 text-nowrap text-truncate"><?php echo $readSupportHistory["serverName"]; ?></td>
                      <td class="p-3 border-bottom font-100 line-height-1 w-40 text-nowrap text-truncate"><?php echo checkTime($readSupportHistory["lastUpdate"]); ?></td>
                      <td class="pl-3 border-bottom font-100 line-height-1 w-10 table-badge-wrapper">
                        <?php if ($readSupportHistory["status"] == 0) { ?>
                        <span class="text-white"><?php echo languageVariables("notAnswered", "words", $languageType); ?></span>
                        <?php } else if ($readSupportHistory["status"] == 1) { ?>
                        <span class="text-muted"><?php echo languageVariables("answered", "words", $languageType); ?></span>
                        <?php } else if ($readSupportHistory["status"] == 2) { ?>
                        <span class="text-danger"><?php echo languageVariables("closed", "words", $languageType); ?></span>
                        <?php } ?>
                      </td>
                      <td class="p-3 border-bottom font-100 pr-4 line-height-1 w-20 text-right">
                        <div class="d-flex align-items-center justify-content-end">
                          <a data-toggle="tooltip" data-title="<?php echo languageVariables("ticketClosed", "words", $languageType); ?>" onclick="deletedSupport('<?php echo $readSupportHistory['id']; ?>');" class="mr-2">
                            <i class="fas fa-times-circle text-danger"></i>
                          </a>
                          <a data-toggle="tooltip" data-title="<?php echo languageVariables("view", "words", $languageType); ?>" href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"]) . "/" . $readSupportHistory["id"]; ?>">
                            <i class="fas fa-arrow-right fa-sm text-white"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <?php } else { echo alert(languageVariables("alertSupportHistory", "profile", $languageType), "warning", "0", "/"); } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "create") { ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("support", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("create", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-12 py-3">
            <div class="bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
              <?php echo languageVariables("createTicket", "words", $languageType); ?>
              </h3>
              <?php
                require_once(__DR__ . "/main/includes/packages/class/csrf/class.php");
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
                                                $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL . "admin/destek/goruntule/" . $readSupport["id"]), $readWebhooks["webhookSupportDescription"]);
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
                                                                "text" => "Powered by MineLAB",
                                                                "icon_url" => "https://www.minelab.web.tr/main/theme/assets/images/brand/favicon.png"
                                                            ] : []
                                                        ]
                                                    ]
                                                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
                                        $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0) . ' '.languageVariables("day", "words", $languageType);
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
              <form action="" method="post">
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                  <label for="open-ticket-title" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-bookmark fa-xs mr-1"></i><?php echo languageVariables("title", "words", $languageType); ?></label>
                  <input type="text" name="title" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="open-ticket-title">
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 select-wrapper input-focused">
                  <label for="open-ticket-server" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-shield-alt fa-xs mr-1"></i><?php echo languageVariables("server", "words", $languageType); ?></label>
                  <select class="js-select2 w-100" id="open-ticket-server" name="server">
                    <?php $searchServer = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                    <?php if ($searchServer->rowCount() > 0) { ?>
                    <?php foreach ($searchServer as $readServer) { ?>
                    <option value="<?php echo $readServer["name"]; ?>"><?php echo $readServer["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                    <option value="<?php echo languageVariables("none", "words", $languageType); ?>"><?php echo languageVariables("notServer", "words", $languageType); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 select-wrapper input-focused">
                  <label for="open-ticket-category" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-bars fa-xs mr-1"></i><?php echo languageVariables("category", "words", $languageType); ?></label>
                  <select class="js-select2 w-100" id="open-ticket-category" name="category">
                    <?php $searchSupportCategory = $db->query("SELECT * FROM supportCategory ORDER BY id DESC"); ?>
                    <?php foreach ($searchSupportCategory as $readCategory) { ?>
                    <option value="<?php echo $readCategory["title"]; ?>"><?php echo $readCategory["title"]; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 textarea-wrapper">
                  <label for="open-ticket-text" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-envelope-open-text fa-xs mr-1"></i><?php echo languageVariables("youMessage", "words", $languageType); ?></label>
                  <textarea name="message" class="form-control mt-3 pt-0 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="open-ticket-text" rows="3"></textarea>
                </div>
                <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                <?php echo $safeCsrfToken->input("supportCreateToken"); ?>
                <button type="submit" name="supportCreate" class="btn text-white col-12 m-0 d-block ml-auto line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                  <i class="fas fa-paper-plane fa-sm mr-2 btn-icon"></i>
                  <span class="btn-text">
                  <?php echo languageVariables("send", "words", $languageType); ?>
                  </span>
                </button>
              </form>
            </div>
          </div>
        </div>
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
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("support", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo $readSupport['title']; ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <div class="bg-dark--3 p-5">
              <div class="ticket-header mb-5">
                <div class="d-flex mb-3 justify-content-between align-items-center">
                  <h3 class="text-secondary mb-0 font-100 font-size-6 letter-spacing-1 text-uppercase">
                  <?php echo languageVariables("meTicket", "words", $languageType); ?>
                  </h3>
                  <?php if ($readSupport["status"] !== "2") { ?>
                  <button type="button" onclick="deletedSupport('<?php echo $readSupport['id']; ?>');" class="btn float-right text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                    <i class="fas fa-times fa-sm mr-2 btn-icon"></i>
                    <span class="btn-text">
                    <?php echo languageVariables("ticketClosed", "words", $languageType); ?>
                    </span>
                  </button>
                  <?php } ?>
                </div>
                <?php if ($readSupport["lockStatus"] == "0") { ?>
                <?php
                  require_once(__DR__ . "/main/includes/packages/class/csrf/class.php");
                  $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
                  if (isset($_POST["messageSend"])) {
                    if ($safeCsrfToken->validate('messageSendToken')) {
                      if (post("message") !== "") {
                        $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                        $bannedQuery->execute(array($readAccount["username"], "support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                        if ($bannedQuery->rowCount() == 0) {
                          $insertSupportMessage = $db->prepare("INSERT INTO supportReply SET username = ?, message = ?, supportID = ?, type = ?, date = ?");
                          $insertSupportMessage->execute(array($readAccount["username"], post("message"), $readSupport["id"], 0, date("d.m.Y H:i:s")));
                          $updateSupport = $db->prepare("UPDATE supportList SET status = ?, lastUpdate = ? WHERE id = ?");
                          $updateSupport->execute(array(0, date("d.m.Y H:i:s"), $readSupport["id"]));
                          $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL . "admin/destek/goruntule/" . $readSupport["id"]), $readWebhooks["webhookSupportDescription"]);
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
                                        "text" => "Powered by MineLAB",
                                        "icon_url" => "https://www.minelab.web.tr/main/theme/assets/images/brand/favicon.png"
                                      ] : []
                                  ]
                              ]
                          ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                          $sendWebhook = (($readWebhooks["webhookSupportStatus"] == "1") ? webhooks($readWebhooks["webhookSupportAPI"], $hookObject) : "OK");
                          echo alert(languageVariables("alertSuccessMessage", "support", $languageType), "success", "3", "");
                        } else {
                          $readBanned = $bannedQuery->fetch();
                          if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") {
                            $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                          } else {
                            $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0) . ' '.languageVariables("day", "words", $languageType);
                          }
                          echo alert(languageVariables("alertBannedMessage", "support", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
                    }
                  }
                ?>
                <form action="" method="post">
                  <div class="input-group mb-3 flex-column bg-dark--5 border w-100 p-0 textarea-wrapper">
                    <label for="ticket" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute" name="message"><i class="fas fa-envelope-open-text fa-xs mr-1"></i><?php echo languageVariables("support", "words", $languageType); ?></label>
                    <textarea class="form-control mt-3 pt-0 text-white font-size-7 py-2 w-100 font-100 rounded-none" id="ticket" name="message" rows="3"></textarea>
                  </div>
                  <?php echo $safeCsrfToken->input("messageSendToken"); ?>
                  <button type="submit" name="messageSend" class="btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary">
                    <i class="fas fa-paper-plane fa-sm mr-2 btn-icon"></i>
                    <span class="btn-text">
                    <?php echo languageVariables("send", "words", $languageType); ?>
                    </span>
                  </button>
                </form>
                <?php } ?>
              </div>
              <?php
                $searchMessage = $db->prepare("SELECT * FROM supportReply WHERE supportID = ? ORDER BY id ASC");
                $searchMessage->execute(array(get("id")));
              ?>
              <div class="ticket-messages">
                <div class="mb-3 w-100 ticket-message text-white font-100 font-size-7">
                  <div class="ticket-message-header bg-dark--5 d-flex align-items-center position-relative overflow-hidden">
                  <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-4 py-3 mb-1">
                      <div class="block">
                        <span class="d-block date font-size-6 mr-lg-3 mt-2 mt-lg-0 o-25"><?php echo checkTime($readSupport["date"]) ?></span>
                      </div>
                      <span class="d-block username font-size-8" data-toggle="tooltip" data-title="Siz"><?php echo $readSupport['username'] ?></span>
                    </div>
                    <div class="mc-skin lefrightt mr-0 pl-3 pt-3 ticket-skin">
                      <div class="mc-skin-img-wrapper js-mirror">
                        <div class="mc-skin-img">
                          <img src="https://minotar.net/body/<?php echo $readSupport['username'] ?>/100.png" alt="oyuncunun skini">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ticket-message-body p-3 bg-dark--4">
                    <p class="p-0 px-md-2 px-lg-1 m-0 font-size-7 font-100"><?php echo $readSupport["message"] ?></p>
                  </div>
                </div>
                <?php if ($searchMessage->rowCount() > 0) : ?>
                <?php foreach ($searchMessage as $readMessage) : ?>
                <div class="mb-3 w-100 ticket-message text-white font-100 font-size-7">
                  <div class="ticket-message-header bg-dark--5 d-flex align-items-center position-relative overflow-hidden">
                    <?php if ($readMessage["type"] == "0") { ?>
                    <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-4 py-3 mb-1">
                      <div class="block">
                        <span class="d-block date font-size-6 mr-lg-3 mt-2 mt-lg-0 o-25"><?php echo checkTime($readMessage["date"]) ?></span>
                      </div>
                      <span class="d-block username font-size-8" data-toggle="tooltip" data-title="Siz"><?php echo $readMessage['username'] ?></span>
                    </div>
					<div class="mc-skin right mr-0 pl-3 pt-3 ticket-skin">
                      <div class="mc-skin-img-wrapper js-mirror">
                        <div class="mc-skin-img">
                          <img src="https://minotar.net/body/<?php echo $readMessage['username'] ?>/100.png" alt="oyuncunun skini">
                        </div>
                      </div>
                    </div>
                    <?php } else if ($readMessage["type"] == "1") { ?>
					<?php $values = array($readAccount["username"], $readMessage["message"], $rSettings["serverName"], $readMessage["username"], $rSettings["IPAdres"]); ?>
                    <?php $textvalues = array("[username]", "[message]", "[serverName]", "[admin]", "[serverIP]"); ?>
					<?php $readMessage["message"] = str_replace($textvalues, $values, $rSettings['supportMessageTemplate']); ?>
                    <div class="mc-skin left mr-0 pl-3 pt-3 ticket-skin">
                      <div class="mc-skin-img-wrapper js-mirror">
                        <div class="mc-skin-img">
                          <img src="https://minotar.net/body/<?php echo $readMessage['username'] ?>/100.png" alt="oyuncunun skini">
                        </div>
                      </div>
                    </div>
                    <div class="user-info d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center w-100 px-4 py-3 mb-1">
                      <div class="block">
                        <span class="d-block username font-size-8" data-toggle="tooltip" data-title="Karşı"><?php echo $readMessage['username'] ?></span>
                      </div>
                      <span class="d-block date font-size-6 mr-lg-3 mt-2 mt-lg-0 o-25"><?php echo checkTime($readMessage["date"]) ?></span>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="ticket-message-body p-3 bg-dark--4">
                    <p class="p-0 px-md-2 px-lg-1 m-0 font-size-7 font-100"><?php echo $readMessage["message"] ?></p>
                  </div>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <div class="sidebar bg-dark--3 p-5 mb-4">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                  <?php echo languageVariables("ticketInfo", "words", $languageType); ?>
                  </span>
                </h2>
                <ul class="navbar-nav sidebar-nav">
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="#" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                        <?php echo $readSupport['category']; ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                      <?php echo languageVariables("category", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="#" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                        <?php if ($readSupport["status"] == 0) { ?>
                          <?php echo languageVariables("notAnswered", "words", $languageType); ?>
                        <?php } else if ($readSupport["status"] == 1) { ?>
                          <?php echo languageVariables("answered", "words", $languageType); ?>
                        <?php } else if ($readSupport["status"] == 2) { ?>
                          <?php echo languageVariables("closed", "words", $languageType); ?>
                        <?php } ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                      <?php echo languageVariables("status", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                  <li class="nav-item bg-dark--2">
                    <a href="#" class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <span class="nav-link-text">
                        <?php echo checkTime($readSupport["date"]) ?>
                      </span>
                      <span class="product-count font-size-6 o-25 mt-1 position-relative">
                      <?php echo languageVariables("date", "words", $languageType); ?>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("support", $languageType)); } ?>
<?php } else { go(urlConverter("support", $languageType)); } ?>
<?php } ?>