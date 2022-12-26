<?php AccountLoginControl(true); ?>
<style type="text/css">
@media (max-width: 1200px) {
  .mobile-label-south {
    margin-left: 15rem;
  }
}
@media (max-width: 720px) {
  .mobile-label-south {
    margin-left: 3rem;
  }
}
</style>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
  <div class="grid grid-4-8 mobile-prefer-content">
    <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("login", "words", $languageType); ?></p>
          <div class="widget-box-content">
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
                            $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' gün';
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
            <form action="" method="POST">
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input small <?php if (isset($_POST["username"])) { echo "active"; } ?>">
                    <label for="account-username"><?php echo languageVariables("username", "words", $languageType); ?></label>
                    <input type="text" id="account-username" name="username" value="<?php echo post("username"); ?>">
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-current-password"><?php echo languageVariables("password", "words", $languageType); ?></label>
                    <input type="password" id="account-current-password" name="password">
                  </div>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <input type="checkbox" id="login-remember" name="remember">
                    <div class="checkbox-box">
                      <svg class="icon-cross">
                        <use xlink:href="#svg-cross"></use>
                      </svg>
                    </div>
                    <label for="login-remember"><?php echo languageVariables("remember", "words", $languageType); ?></label>
                  </div>
                </div>
                <div class="form-item">
                  <a href="<?php echo urlConverter("recovery", $languageType); ?>" id="password-recovery" style="font-weight: 400;"><?php echo languageVariables("forgotPassword", "words", $languageType); ?></a>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("accountsLoginToken"); ?>
                  <button class="button full primary" type="submit" name="accountsLogin"><?php echo languageVariables("login", "words", $languageType); ?></button>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <br><label class="mobile-label-south"><?php echo languageVariables("footerText", "login", $languageType); ?> <a href="<?php echo urlConverter("register", $languageType); ?>" class="text-primary"><?php echo languageVariables("register", "words", $languageType); ?></a></label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
    <div class="grid-column">
        <div class="col-lg-8 col-12 py-5 pl-5 d-flex justify-content-center align-items-lg-start align-items-center flex-column text-center text-lg-left">
          <h1 style="color: <?php if ($_SESSION["themeModeType"] == "dark") { echo "white"; } else if ($_SESSION["themeModeType"] == "light") { echo "#3e3f5e"; } ?>;">
            <span style="font-weight: 100;"><?php echo languageVariables("sectionTitle", "login", $languageType); ?></span> <br>
            <span style="font-weight: 500;"><?php echo languageVariables("sectionInfo", "login", $languageType); ?></span>
          </h1><br>
          <p class="o-75 w-75" style="font-weight: 100; font-size: 24px; color: <?php if ($_SESSION["themeModeType"] == "dark") { echo "white"; } else if ($_SESSION["themeModeType"] == "light") { echo "#3e3f5e"; } ?>;"><?php echo languageVariables("sectionText", "login", $languageType); ?></p>
		</div>
    </div>
  </div>
</div>