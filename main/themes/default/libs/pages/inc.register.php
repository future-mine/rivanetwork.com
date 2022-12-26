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
        <h1 class="text-gray-800 text-3xl font-bold"><?php echo languageVariables("register", "words", $languageType); ?></h1>
        <p class="text-gray-400 mt-4 font-medium mb-4"><?php echo languageVariables("sectionText", "register", $languageType); ?></p>
        <?php
        $usernameControlListOne = array("allah", "tanri", "ataturk", "peygamber", "sikici", "sokucu", "anani", "anan", "orospu", "sikis", "yarak", "yarrak");
        $usernameControlListTwo = array("allah", "tanri", "ataturk", "peygamber");
        require_once(__DR__."/main/includes/packages/class/csrf/class.php");
        $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
        if (isset($_POST["accountsRegister"])) {
          if ($safeCsrfToken->validate('accountsRegisterToken')) {
            if (isset($_POST['g-recaptcha-response'])) {
              $loginRecaptcha = $_POST['g-recaptcha-response'];
            }
            if ($rSettings['recaptchaStatus'] == 0 || $loginRecaptcha) {
              if (post("rules")) {
                if (post("username") !== "" && post("email") !== "" && post("password") !== "" && post("passwordRe") !== "") {
                  if (16 >= strlen(post("username"))) {
                    if (strlen(post("username")) >= 3) {
                      if (!usernameControl(post("username")) && forbiddenWordControl(post("username"), $usernameControlListTwo) == "OK" && !in_array(post("username"), $usernameControlListOne)) {
                        if (strstr(post("email"), "@")) {
                          $usernameControlMysql = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                          $usernameControlMysql->execute(array(post("username")));
                          $emailControlMysql = $db->prepare("SELECT * FROM accounts WHERE email = ?");
                          $emailControlMysql->execute(array(post("email")));
                          if ($usernameControlMysql->rowCount() == 0) {
                            if ($emailControlMysql->rowCount() == 0) {
                              if (strlen(post("password")) >= 4) {
                                if (post("password") == post("passwordRe")) {
                                  $searchPreviousAccounts = $db->prepare("SELECT * FROM accounts WHERE ip = ?");
                                  $searchPreviousAccounts->execute(array(GetIP()));
                                  if ($rSettings["registerLimit"] == "0" || $rSettings["registerLimit"] > $searchPreviousAccounts->rowCount()) {
                                    $password = generateSHA256(post("password"));
                                    $insertAccounts = $db->prepare("INSERT INTO accounts SET username = ?, realname = ?, email = ?, password = ?, ip = ?, permission = ?, credit = ?, registerDate = ?, lastLogin = ?, imageAvatar = ?, discord = ?, skype = ?, twitter = ?, instagram = ?, youtube = ?, totalCredit = ?, notificationStatus = ?");
                                    $insertAccounts->execute(array(post("username"), $_POST["username"], post("email"), $password, GetIP(), "1", "0", date("d.m.Y H:i:s"), date("d.m.Y H:i:s"), "/main/themes/south/libs/includes/images/avatar/default-background.png", "-", "-", "-", "-", "-", "0", "1"));
                                    if ($insertAccounts) {
                                      $searchAccountNewRegister = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                                      $searchAccountNewRegister->execute(array(post("username")));
                                      if ($searchAccountNewRegister->rowCount() > 0) {
                                        $readAccountNewRegister = $searchAccountNewRegister->fetch();
                                        if ($readAccountNewRegister["notificationStatus"] == "1") {
                                          $notificationText = str_replace("&serverName", $rSettings["serverName"], languageVariables("welcome", "notifications", $languageType));
                                          $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                                          $insertNotifications->execute(array($readAccountNewRegister["username"], $readAccountNewRegister["id"], $notificationText, '{"iconType":"small-arrow","userIP":"'.GetIP().'"}', "register", date("d.m.Y H:i:s"), "unread"));
                                        }
                                        $loginSessionsToken = md5(uniqid(mt_rand(), true));
                                        $insertAccountSessions = $db->prepare("INSERT INTO accountLoginSessions (`accountID`, `sessionToken`, `sessionIP`, `date`, `time`) VALUES (?,?,?,?,?)");
                                        $insertAccountSessions->execute(array($readAccountNewRegister["id"], $loginSessionsToken, GetIP(), date("d.m.Y H:i:s"), time()));
                                        $_SESSION["incAccountLogin"] = $loginSessionsToken;
                                        echo alert(languageVariables("alertSuccess", "register", $languageType), "success", "3", urlConverter("profile", $languageType));
                                      } else {
                                        echo alert(languageVariables("alertError", "register", $languageType), "danger", "0", "/");
                                      }
                                    } else {
                                      echo alert(languageVariables("alertSystem", "register", $languageType), "danger", "0", "/");
                                    }
                                  } else {
                                    echo alert(languageVariables("alertRegisterLimit", "register", $languageType), "danger", "0", "/");
                                  }
                                } else {
                                  echo alert(languageVariables("alertPassword2", "register", $languageType), "danger", "0", "/");
                                }
                              } else {
                                echo alert(languageVariables("alertPassword1", "register", $languageType), "danger", "0", "/");
                              }
                            } else {
                              echo alert(str_replace("&email", post("email"), languageVariables("alertEmailAlready", "register", $languageType)), "danger", "0", "/");
                            }
                          } else {
                            echo alert(str_replace("&username", post("username"), languageVariables("alertUsernameAlready", "register", $languageType)), "danger", "0", "/");
                          }
                        } else {
                          echo alert(languageVariables("alertEmail", "register", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertUsername3", "register", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertUsername2", "register", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertUsername1", "register", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNone", "register", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertRules", "register", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertRobot", "register", $languageType), "danger", "0", "/");
            }
          } else {
            echo alert(languageVariables("alertSystem", "register", $languageType), "danger", "0", "/");
          }
        }
        ?>
        <form action="" method="POST" class="mt-16">
          <div class=" items-center">
            <label for="username" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("username", "words", $languageType); ?></label>
            <input type="text" id="username" name="username" class="w-full form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="email" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("email", "words", $languageType); ?></label>
            <input type="text" id="email" name="email" class="w-full form-control" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="password" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("password", "words", $languageType); ?></label>
            <input type="password" id="password" name="password" class="w-full form-control" placeholder="<?php echo languageVariables("password", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="passwordRe" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("rePassword", "words", $languageType); ?></label>
            <input type="password" id="passwordRe" name="passwordRe" class="w-full form-control" placeholder="<?php echo languageVariables("rePassword", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="checkbox" class="flex items-center gap-3">
              <input id="checkbox" type="checkbox" name="rules" class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded-md">
              <span class="text-gray-400 text-sm"><?php echo languageVariables("rulesConfirm", "words", $languageType); ?></span>
            </label>
          </div>
          <div class="mt-6">
            <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
          </div>
          <?php echo $safeCsrfToken->input("accountsRegisterToken"); ?>
          <div class="mt-12 flex gap-6 items-center">
            <button type="submit" name="accountsRegister" class="btn btn-white btn-lg w-40"><?php echo languageVariables("register", "words", $languageType); ?></button>
            <a href="<?php echo urlConverter("login", $languageType); ?>" class="p-2 relative overflow-hidden text-gray-400 font-medium text-sm transition hover:text-gray-500 group">
              <?php echo languageVariables("login", "words", $languageType); ?>
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
          <a href="<?php echo urlConverter("login", $languageType); ?>" class="text-gray-700 text-lg font-semibold transition hover:text-indigo-400"><?php echo languageVariables("footerText", "register", $languageType); ?></a>
          <div class="text-gray-400"><?php echo languageVariables("login", "words", $languageType); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>