<?php AccountLoginControl(true); ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="xl:py-24 xl:px-24 relative min-h-screen flex">
  <div class="absolute inset-0 w-full h-full bg-cover bg-center opacity-50" style="background-image: url('<?php echo $rSettings["headerLogo"]; ?>')">
    <div class="backdrop-blur-sm bg-indigo-500/40 w-full h-full"></div>
  </div>
  <div class="relative z-10 bg-indigo-50 xl:rounded-2xl grid w-full xl:grid-cols-2 gap-8">
    <div class="relative py-8 px-12 xl:py-24 xl:px-32 col-span-">
      <a href="/" class="rounded-xl flex items-center gap-4 absolute top-10 right-6 text-sm text-indigo-600 font-medium bg-indigo-100 py-3 px-6 transition hover:bg-indigo-200">
        <i class="fas fa-angle-left"></i>
        <?php echo languageVariables("home", "words", $languageType); ?>
      </a>
      <div class="flex gap-3 items-center mt-16 lg:mt-6">
        <img class="w-32" src="<?php echo $rSettings["serverLogo"]; ?>" alt="">
        <div class="text-md font-semibold text-gray-800 max-w-xs border-l-2 border-gray-200 pl-6"><?php echo $rSettings["metaTitle"]; ?></div>
      </div>
      <?php 
      $broadcastStatus = false;
      if ($readModule["broadcastStatus"] == "1") {
        $searchBroadcastOne = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT 4");
        if ($searchBroadcastOne->rowCount() > 0) {
        $broadcastStatus = true;
      ?>
      <div class="mt-24 hidden lg:block">
        <h3 class="text-xl font-semibold"><?php echo languageVariables("notice", "words", $languageType); ?></h3>
        <div class="mt-10 space-y-8">
        <?php foreach ($searchBroadcastOne as $readBroadcastOne) { ?>
          <a href="<?php echo $readBroadcastOne["url"]; ?>" target="_blank" class="cursor-pointer group rounded-xl bg-white py-4 px-6 flex justify-between items-center">
            <div>
              <p class="font-semibold text-gray-500 group-hover:text-gray-700 transition"><?php echo $readBroadcastOne["title"]; ?></p>
              <span class="transition group-hover:text-indigo-400 text-gray-400 text-sm"><?php echo languageVariables("click", "words", $languageType); ?></span>
            </div>
            <div>
              <i class="fas fa-angle-right text-gray-700 text-lg py-2 px-4 bg-gray-100/75 rounded-xl transition group-hover:text-indigo-400"></i>
            </div>
          </a>
        <?php } ?>
        </div>
      </div>
      <?php } } ?>
      <?php if ($broadcastStatus == false) { ?>
      <div class="mt-24 hidden lg:block">
        <h3 class="text-xl font-semibold"><?php echo languageVariables("links", "words", $languageType); ?></h3>
        <div class="mt-10 space-y-8">
          <a href="<?php echo urlConverter("help_center", $languageType); ?>" target="_blank" class="cursor-pointer group rounded-xl bg-white py-4 px-6 flex justify-between items-center">
            <div>
              <p class="font-semibold text-gray-500 group-hover:text-gray-700 transition"><?php echo languageVariables("helpCenter", "words", $languageType); ?></p>
              <span class="transition group-hover:text-indigo-400 text-gray-400 text-sm"><?php echo languageVariables("click", "words", $languageType); ?></span>
            </div>
            <div>
              <i class="fas fa-angle-right text-gray-700 text-lg py-2 px-4 bg-gray-100/75 rounded-xl transition group-hover:text-indigo-400"></i>
            </div>
          </a>
          <a href="<?php echo urlConverter("banned", $languageType); ?>" target="_blank" class="cursor-pointer group rounded-xl bg-white py-4 px-6 flex justify-between items-center">
            <div>
              <p class="font-semibold text-gray-500 group-hover:text-gray-700 transition"><?php echo languageVariables("bans", "words", $languageType); ?></p>
              <span class="transition group-hover:text-indigo-400 text-gray-400 text-sm"><?php echo languageVariables("click", "words", $languageType); ?></span>
            </div>
            <div>
              <i class="fas fa-angle-right text-gray-700 text-lg py-2 px-4 bg-gray-100/75 rounded-xl transition group-hover:text-indigo-400"></i>
            </div>
          </a>
          <a href="<?php echo urlConverter("rules", $languageType); ?>" target="_blank" class="cursor-pointer group rounded-xl bg-white py-4 px-6 flex justify-between items-center">
            <div>
              <p class="font-semibold text-gray-500 group-hover:text-gray-700 transition"><?php echo languageVariables("rules", "words", $languageType); ?></p>
              <span class="transition group-hover:text-indigo-400 text-gray-400 text-sm"><?php echo languageVariables("click", "words", $languageType); ?></span>
            </div>
            <div>
              <i class="fas fa-angle-right text-gray-700 text-lg py-2 px-4 bg-gray-100/75 rounded-xl transition group-hover:text-indigo-400"></i>
            </div>
          </a>
          <a href="<?php echo urlConverter("privacy", $languageType); ?>" target="_blank" class="cursor-pointer group rounded-xl bg-white py-4 px-6 flex justify-between items-center">
            <div>
              <p class="font-semibold text-gray-500 group-hover:text-gray-700 transition"><?php echo languageVariables("privacy", "words", $languageType); ?></p>
              <span class="transition group-hover:text-indigo-400 text-gray-400 text-sm"><?php echo languageVariables("click", "words", $languageType); ?></span>
            </div>
            <div>
              <i class="fas fa-angle-right text-gray-700 text-lg py-2 px-4 bg-gray-100/75 rounded-xl transition group-hover:text-indigo-400"></i>
            </div>
          </a>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="rounded-r-2xl rounded-l-3xl bg-white flex flex-col">
      <div class="py-8 px-8 xl:py-16 xl:px-16 mb-4 mt-4">
        <h1 class="text-gray-800 text-3xl font-bold"><?php echo languageVariables("login", "words", $languageType); ?></h1>
        <p class="text-gray-400 mt-4 font-medium mb-4"><?php echo languageVariables("sectionText", "login", $languageType); ?></p>
        <?php 
        require_once(__DR__."/main/includes/packages/class/csrf/class.php");
        $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
        if (isset($_POST["accountsLogin"])) {
          if ($safeCsrfToken->validate("accountsLoginToken")) {
            if (isset($_POST['g-recaptcha-response'])) {
             $loginRecaptcha = $_POST['g-recaptcha-response'];
            }
            if ($rSettings['recaptchaStatus'] == 0 || $loginRecaptcha) {
              if (post("username") !== "" && post("password") !== "") {
                $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                $searchPlayer->execute(array(post("username")));
                if ($searchPlayer->rowCount() > 0) {
                  $readPlayer = $searchPlayer->fetch();
                  $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
                  $searchPlayerPermission->execute(array($readPlayer["permission"]));
                  $readPlayerPermission = $searchPlayerPermission->fetch();
                  $readPlayerPermissionVariables = json_decode($readPlayerPermission["variables"], true);
                  if (controlSHA256(post("password"), $readPlayer["password"]) == "OK") {
                    $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                    $bannedQuery->execute(array(post("username"), "login", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                    if ($bannedQuery->rowCount() == 0) {
                      if ($rSettings["maintanceStatus"] == "0" || $readPlayerPermissionVariables["maintance"] == "TRUE") {
                        $loginSessionsToken = md5(uniqid(mt_rand(), true));
                        $removeAccountSessions = $db->prepare("DELETE FROM accountLoginSessions WHERE accountID = ?");
                        $removeAccountSessions->execute(array($readPlayer["id"]));
                        $insertAccountSessions = $db->prepare("INSERT INTO accountLoginSessions (`accountID`, `sessionToken`, `sessionIP`, `date`, `time`) VALUES (?,?,?,?,?)");
                        $insertAccountSessions->execute(array($readPlayer["id"], $loginSessionsToken, GetIP(), date("d.m.Y H:i:s"), time()));
                        $_SESSION["incAccountLogin"] = $loginSessionsToken;
                        if (isset($_POST["remember"])) {
                          generateCookie("rememberToken", $loginSessionsToken, 90, $systemSSLStatus);
                        }
                        if ($readPlayer["notificationStatus"] == "1") {
                          $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                          $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("newLogin", "notifications", $languageType), '{"iconType":"login","userIP":"'.GetIP().'"}', "successLogin", date("d.m.Y H:i:s"), "unread"));
                        }
                        $updateAccounts = $db->prepare("UPDATE accounts SET ip = ?, lastLogin = ? WHERE id = ?");
                        $updateAccounts->execute(array(GetIP(), date("d.m.Y H:i:s"), $readPlayer["id"]));
                        if (isset($_GET["return"])) {
                          go(get("return"));
                        } else {
                          go(urlConverter("profile", $languageType));
                        }
                      } else {
                        echo alert(languageVariables("alertMaintance", "login", $languageType), "danger", "0", "/");
                      }
                    } else {
                      $readBanned = $bannedQuery->fetch();
                      if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") { 
                        $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                      } else {
                        $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType);
                      }
                      echo alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBan", "login", $languageType)), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertPassword", "login", $languageType), "danger", "0", "/");
                    if ($readPlayer["notificationStatus"] == "1") {
                      $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                      $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("errorLogin", "notifications", $languageType), '{"iconType":"login","userIP":"'.GetIP().'"}', "errorLogin", date("d.m.Y H:i:s"), "unread"));
                    }
                  }
                } else {
                  echo alert(str_replace(["&username"], [post("username")], languageVariables("alertNotUser", "login", $languageType)), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "login", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertRobot", "login", $languageType), "danger", "0", "/");
            }
          } else {
            echo alert(languageVariables("alertSystem", "login", $languageType), "danger", "0", "/");
          }
        }
        ?>
        <form action="" method="POST" class="mt-16">
          <div class=" items-center">
            <label for="username" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("username", "words", $languageType); ?></label>
            <input type="text" id="username" name="username" class="w-full form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="password" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("password", "words", $languageType); ?></label>
            <input type="password" id="password" name="password" class="w-full form-control" placeholder="<?php echo languageVariables("password", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="checkbox" class="flex items-center gap-3">
              <input id="checkbox" type="checkbox" name="remember" class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded-md">
              <span class="text-gray-400 text-sm"><?php echo languageVariables("remember", "words", $languageType); ?></span>
            </label>
          </div>
          <div class="mt-6">
            <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
          </div>
          <?php echo $safeCsrfToken->input("accountsLoginToken"); ?>
          <div class="mt-12 flex gap-6 items-center">
            <button type="submit" name="accountsLogin" class="btn btn-white btn-lg w-40"><?php echo languageVariables("login", "words", $languageType); ?></button>
            <a href="<?php echo urlConverter("register", $languageType); ?>" class="p-2 relative overflow-hidden text-gray-400 font-medium text-sm transition hover:text-gray-500 group">
              <?php echo languageVariables("register", "words", $languageType); ?>
              <span class="h-0.5 w-full bg-gray-400 rounded absolute bottom-0 -left-full group-hover:left-0 transition-all"></span>
            </a>
          </div>
        </form>
      </div>
      <div class="mt-auto bg-gray-50/50 py-8 px-12 xl:px-32 flex gap-8 items-center">
        <div class="rounded-2xl w-16 h-16 bg-indigo-100/50 flex items-center justify-center">
          <i class="fas fa-question text-xl text-indigo-600"></i>
        </div>
        <div>
          <a href="<?php echo urlConverter("recovery", $languageType); ?>" class="text-gray-700 text-lg font-semibold transition hover:text-indigo-400"><?php echo languageVariables("forgotPassword", "words", $languageType); ?></a>
          <div class="text-gray-400"><?php echo languageVariables("sectionTitle", "recovery", $languageType); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>