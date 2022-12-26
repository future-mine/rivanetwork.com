<?php
AccountLoginControl(false);
$countReply = $db->prepare("SELECT R.id FROM supportReply R INNER JOIN supportList L ON R.supportID = L.id WHERE L.username = ? AND R.type = ? ORDER BY R.id");
$countReply->execute(array($readAccount["username"], 1));
$countSupport = $db->prepare("SELECT * FROM supportList WHERE username = ?");
$countSupport->execute(array($readAccount["username"]));
if (get("action") == "get") {
} else if (get("action") == "create") {
} else if (get("action") == "update") {
  if (isset($_GET["id"])) {
    $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ? AND username = ?");
    $searchSupport->execute(array(get("id"), $readAccount["username"]));
    if ($searchSupport->rowCount() > 0) {
      $readSupport = $searchSupport->fetch();
    } else {
      go(urlConverter("support", $languageType));
    }
  } else {
    go(urlConverter("support", $languageType));
  }
}
?>
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
            <a href="<?php echo urlConverter("support", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("support", "words", $languageType); ?></a>
          </div>
        </li>
        <?php if (get("action") == "get") { ?>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("support", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><strong><?php echo languageVariables("myTicket", "words", $languageType); ?></strong></a>
          </div>
        </li>
        <?php } else if (get("action") == "create") { ?>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><strong><?php echo languageVariables("create", "words", $languageType); ?></strong></a>
          </div>
        </li>
        <?php } else if (get("action") == "update") { ?>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupport["title"])."/".$readSupport["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><strong><?php echo $readSupport["id"]."# ".$readSupport["title"]; ?></strong></a>
          </div>
        </li>
        <?php } ?>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto lg:grid lg:grid-cols-10 gap-16 px-4 md:px-0">
    <?php if (get("action") == "get") { ?>
    <div class="lg:col-span-7 flex flex-col gap-16">
      <div class="mt-10">
        <div class="text-gray-400">
          <?php $searchSupportHistory = $db->prepare("SELECT * FROM supportList WHERE username = ? ORDER BY id DESC"); ?>
          <?php $searchSupportHistory->execute(array($readAccount["username"])); ?>
          <?php if ($searchSupportHistory->rowCount() > 0) { ?>
          <div class="card overflow-x-auto w-full">
            <table class="w-full text-left relative z-10">
              <thead>
                <tr class="text-xs uppercase text-white font-medium bg-indigo-400/25 !text-indigo-700 relative">
                  <th class="py-4 px-3 relative z-10">ID</th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("title", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("category", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("status", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach ($searchSupportHistory as $readSupportHistory) { ?>
                <tr class="hover:bg-gray-100">
                  <td class="font-normal p-3">#<?php echo $readSupportHistory["id"]; ?></td>
                  <td class="font-normal p-3"><a href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"])."/".$readSupportHistory["id"]; ?>"><?php echo $readSupportHistory["title"]; ?></a></td>
                  <td class="font-normal p-3"><?php echo $readSupportHistory["category"]; ?></td>
                  <td class="font-normal p-3"><?php echo $readSupportHistory["serverName"]; ?></td>
                  <td class="font-normal p-3"><?php echo checkTime($readSupportHistory["lastUpdate"], 2, true); ?></td>
                  <td class="font-normal p-3">
                    <?php if ($readSupportHistory["status"] == 0) { ?>
                    <div class="rounded-md w-fit bg-indigo-400/10 text-warning py-1 px-2 text-xs"><?php echo languageVariables("notAnswered", "words", $languageType); ?></div>
                    <?php } else if ($readSupportHistory["status"] == 1) { ?>
                    <div class="rounded-md w-fit bg-indigo-400/10 text-emerald-500 py-1 px-2 text-xs"><?php echo languageVariables("answered", "words", $languageType); ?></div>
                    <?php } else if ($readSupportHistory["status"] == 2) { ?>
                    <div class="rounded-md w-fit bg-indigo-400/10 text-dark py-1 px-2 text-xs"><?php echo languageVariables("closed", "words", $languageType); ?></div>
                    <?php } ?>
                  </td>
                  <td class="font-normal p-3 flex gap-3">
                    <a href="<?php echo urlConverter("support", $languageType); ?>/<?php echo createSlug($readSupportHistory["title"])."/".$readSupportHistory["id"]; ?>" class="cursor-pointer bg-indigo-600 text-white py-1 px-2 rounded-xl">
                      <i class="fas fa-eye text-sm"></i>
                    </a>
                    <div onclick="deletedSupport('<?php echo $readSupportHistory["id"]; ?>');" class="cursor-pointer bg-red-500 text-white py-1 px-2 rounded-xl">
                      <i class="fas fa-trash text-sm"></i>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } else { echo alert(languageVariables("alertHistory", "support", $languageType), "danger", "0", "/"); } ?>
        </div>
      </div>
    </div>
    <?php } else if (get("action") == "create") { ?>
    <script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
    <div class="card lg:col-span-7 flex flex-col gap-16 mt-10">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("createTicketTitle", "support", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
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
            <div class="grid">
              <label for="title" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("title", "words", $languageType); ?></label>
              <input id="title" type="text" name="title" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>">
            </div>
            <div class="grid mt-4 relative z-30">
              <label for="category" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("category", "words", $languageType); ?></label>
              <select id="category" name="category" class="custom-select form-control mt-2">
                <?php $searchSupportCategory = $db->query("SELECT * FROM supportCategory ORDER BY id DESC"); ?>
                <?php foreach ($searchSupportCategory as $readCategory) { ?>
                <option value="<?php echo $readCategory["title"]; ?>"><?php echo $readCategory["title"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="grid mt-4 relative">
              <label for="server" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("server", "words", $languageType); ?></label>
              <select id="server" name="server" class="custom-select form-control mt-2">
                <?php $searchServer = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
                <?php if ($searchServer->rowCount() > 0) { ?>
                <?php foreach ($searchServer as $readServer) { ?>
                <option value="<?php echo $readServer["name"]; ?>"><?php echo $readServer["name"]; ?></option>
                <?php } } else { ?>
                <option value="<?php echo languageVariables("none", "words", $languageType); ?>"><?php echo languageVariables("none", "words", $languageType); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="grid mt-4">
              <label for="message" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("message", "words", $languageType); ?></label>
              <textarea id="message" name="message" class="form-control mt-2 w-full min-h-[10rem]" placeholder="<?php echo languageVariables("messagePlaceholder", "support", $languageType); ?>"></textarea>
            </div>
            <div class="grid mt-4">
              <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
            </div>
            <?php echo $safeCsrfToken->input("supportCreateToken"); ?>
            <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
              <button type="submit" name="supportCreate" class="btn btn-primary"><?php echo languageVariables("create", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php } else if (get("action") == "update") { ?>
    <div class="col-span-7">
      <div class="card mt-6">
        <div class="py-3 px-6 flex justify-between items-center border-b border-gray-200/50">
          <div class="h4 text-gray-600"><?php echo languageVariables("messages", "words", $languageType); ?></div>
          <?php if ($readSupport["status"] == 0) { ?>
          <div class="rounded-md w-fit bg-indigo-400/10 text-warning py-1 px-2 text-xs"><?php echo languageVariables("notAnswered", "words", $languageType); ?></div>
          <?php } else if ($readSupport["status"] == 1) { ?>
          <div class="rounded-md w-fit bg-indigo-400/10 text-emerald-500 py-1 px-2 text-xs"><?php echo languageVariables("answered", "words", $languageType); ?></div>
          <?php } else if ($readSupport["status"] == 2) { ?>
          <div class="rounded-md w-fit bg-indigo-400/10 text-dark py-1 px-2 text-xs"><?php echo languageVariables("closed", "words", $languageType); ?></div>
          <?php } ?>
        </div>
        <div id="support-message-box" class="fs-7 py-14 px-12 space-y-8 relative z-10" style="height: 400px; background: none; overflow: scroll; overflow-x: hidden;">
          <?php
            $searchMessage = $db->prepare("SELECT * FROM supportReply WHERE supportID = ? ORDER BY id ASC");
            $searchMessage->execute(array(get("id")));
            echo '<div class="flex gap-2 justify-end"><div class="text-right relative bg-gray-100 rounded-xl p-4 max-w-3/4 right-2" style="min-width: 16rem"><div class="absolute top-2 -right-3 w-4 overflow-hidden inline-block"><div class="h-16 bg-gray-100 rotate-45 transform origin-top-left"></div></div><div class="flex justify-between"><span class="text-gray-400 text-xs">'.checkTime($readSupport["date"]).'</span><a href="'.urlConverter("player", $languageType).'/'.$readAccount["username"].'" class="transition hover:text-green-500 text-gray-800 font-medium">'.$readAccount["username"].'</a></div><p class="text-gray-500 p-1">'.$readSupport["message"].'</p></div><img class="rounded-xl h-fit" src="http://cravatar.eu/avatar/'.$readAccount["username"].'" alt=""></div>';
            if ($searchMessage->rowCount() > 0) {
              foreach ($searchMessage as $readMessage) {
                if ($readMessage["type"] == 0) {
                    echo '<div class="flex gap-2 justify-end"><div class="text-right relative bg-gray-100 rounded-xl p-4 max-w-3/4 right-2" style="min-width: 16rem"><div class="absolute top-2 -right-3 w-4 overflow-hidden inline-block"><div class="h-16 bg-gray-100 rotate-45 transform origin-top-left"></div></div><div class="flex justify-between"><span class="text-gray-400 text-xs">'.checkTime($readMessage["date"]).'</span><a href="'.urlConverter("player", $languageType).'/'.$readMessage["username"].'" class="transition hover:text-green-500 text-gray-800 font-medium">'.$readMessage["username"].'</a></div><p class="text-gray-500 p-1">'.$readMessage["message"].'</p></div><img class="rounded-xl h-fit" src="http://cravatar.eu/avatar/'.$readAccount["username"].'" alt=""></div>';
                } else {
                  $values = array($readAccount["username"], $readMessage["message"], $rSettings["serverName"], $readMessage["username"], $rSettings["IPAdres"]);
                  $textvalues = array("[username]", "[message]", "[serverName]", "[admin]", "[serverIP]");
                  $readMessage["message"] = str_replace($textvalues, $values, $rSettings['supportMessageTemplate']);
                  echo '<div class="flex gap-2 justify-start"><img class="rounded-xl h-fit" src="http://cravatar.eu/avatar/'.$readMessage["username"].'" alt=""><div class="text-white/75 relative bg-indigo-900 rounded-xl p-4 max-w-3/4 left-2" style="min-width: 16rem"><div class="absolute top-2 -left-3 w-4 overflow-hidden inline-block"><div class=" h-16 bg-indigo-900 -rotate-45 transform origin-top-right"></div></div><div class="flex justify-between"><a href="'.urlConverter("player", $languageType).'/'.$readMessage["username"].'" class="text-white font-medium">'.$readMessage["username"].'</a><span class="text-white/75 fs-7">'.checkTime($readMessage["date"], 2, true).'</span></div><p class="text-white/75 p-1">'.$readMessage["message"].'</p></div></div>';
                }
              }
            }
          ?>
        </div>
      </div>
      <?php if ($readSupport["lockStatus"] == "0") { ?>
      <div class="card mt-10 p-4 fs-7">
        <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
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
        <form action="" method="POST">
          <label for="message" class="text-gray-500 fw-bolder"><?php echo languageVariables("messageSend", "words", $languageType); ?></label>
          <textarea id="message" name="message" class="form-control w-full min-w-[6rem] mt-2" placeholder="<?php echo languageVariables("replyPlaceholder", "support", $languageType); ?>"></textarea>
          <div class="flex justify-end mt-4">
            <?php echo $safeCsrfToken->input("messageSendToken"); ?>
            <button type="submit" name="messageSend" class="btn btn-success btn-sm"><?php echo languageVariables("send", "words", $languageType); ?></button>
          </div>
        </form>
        <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
          <div class="h-4 w-6 rounded-sm bg-white border-gray-200/50 rotate-45 transform origin-bottom-left"></div>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="lg:col-span-3 flex flex-col gap-12">
      <?php if (get("action") == "create") { ?>
      <div class="h-fit mt-10">
        <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
          <span><?php echo languageVariables("helpCenter", "words", $languageType); ?></span>
          <i class="fas fa-question group-hover:ml-3 transition-all"></i>
        </a>
      </div>
      <?php } else if (get("action") == "update") { ?>
      <div class="h-fit mt-10">
        <a href="<?php echo urlConverter("support", $languageType); ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
          <span><?php echo languageVariables("myTickets", "words", $languageType); ?></span>
          <i class="fas fa-life-ring group-hover:ml-3 transition-all"></i>
        </a>
      </div>
      <div class="card">
        <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
          <i class="fas fa-star text-indigo-500 fs-4"></i>
        </div>
        <div class="grid divide-y divide-gray-200/25">
          <div class="p-4 overflow-hidden relative">
            <div class="absolute top-0 left-0 h-full flex items-center">
              <span class="h-12 w-2 bg-primary rounded-r-2xl"></span>
            </div>
            <div class="absolute right-0 top-0 shadow-3xl h-full shadow-indigo-400/10"></div>
            <div class="py-2 px-8 relative z-10">
              <dt class="fs-5 text-dark fw-bolder"><?php echo languageVariables("server", "words", $languageType); ?></dt>
              <dd class="text-gray-400 mt-1"><?php echo $readSupport["serverName"]; ?></dd>
              <span class="absolute select-none bottom-0 right-10 fs-3 fw-bolder text-indigo-100/75"><?php echo $readSupport["serverName"]; ?></span>
            </div>
          </div>
          <div class="p-4 overflow-hidden relative">
            <div class="absolute top-0 left-0 h-full flex items-center">
              <span class="h-12 w-2 bg-success rounded-r-2xl"></span>
            </div>
            <div class="absolute right-0 top-0 shadow-3xl h-full shadow-emerald-400/10"></div>
            <div class="py-2 px-8 relative z-10">
              <dt class="fs-5 text-dark fw-bolder"><?php echo languageVariables("category", "words", $languageType); ?></dt>
              <dd class="text-gray-400 mt-1"><?php echo $readSupport["category"]; ?></dd>
              <span class="absolute select-none bottom-0 right-10 fs-3 fw-bolder text-emerald-100/75"><?php echo $readSupport["category"]; ?></span>
            </div>
          </div>
          <div class="p-4 overflow-hidden relative">
            <div class="absolute top-0 left-0 h-full flex items-center">
              <span class="h-12 w-2 bg-warning rounded-r-2xl"></span>
            </div>
            <div class="absolute right-0 top-0 shadow-3xl h-full shadow-yellow-400/10"></div>
            <div class="py-2 px-8 relative z-10">
              <dt class="fs-5 text-dark fw-bolder"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></dt>
              <dd class="text-gray-400 mt-1"><?php echo checkTime($readSupport["lastUpdate"]); ?></dd>
              <span class="absolute select-none bottom-0 right-10 fs-3 fw-bolder text-yellow-100/75"><?php echo checkTime($readSupport["lastUpdate"]); ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php } else { ?>
      <div class="h-fit mt-10">
        <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
          <span><?php echo languageVariables("createTicket", "words", $languageType); ?></span>
          <i class="fas fa-arrow-right group-hover:ml-3 transition-all"></i>
        </a>
      </div>
      <?php } ?>
      <div class="card py-6 px-8">
        <div class="relative flex gap-5 border-b-2 border-gray-200/50 py-4">
          <div class="absolute top-0 right-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $countReply->rowCount(); ?></div>
          <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-20 h-20">
            <i class="fas fa-comment-dots fs-4 text-primary"></i>
          </div>
          <div class="flex justify-center flex-col">
            <dt class="fw-medium text-gray-500"><?php echo languageVariables("replys", "words", $languageType); ?></dt>
            <dd class="text-primary fs-3 fw-bold"><?php echo $countReply->rowCount(); ?></dd>
          </div>
        </div>
        <div class="relative flex gap-5 justify-end py-4">
          <div class="absolute top-0 left-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $countSupport->rowCount(); ?></div>
          <div class="text-right flex justify-center flex-col">
            <dt class="fw-medium text-gray-500"><?php echo languageVariables("myTicket", "words", $languageType); ?></dt>
            <dd class="text-success fw-bold fs-3"><?php echo $countSupport->rowCount(); ?></dd>
          </div>
          <div class="rounded-2xl flex items-center justify-center bg-emerald-400/25 w-20 h-20">
            <i class="fas fa-clipboard-list fs-4 text-success"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>