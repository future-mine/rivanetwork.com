<?php AccountLoginControl(true); ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="container-fluid login-container" style="background-image: linear-gradient(to right, rgba(30, 30, 30, .9) 50%, rgba(30, 30, 30, 0) 80%)">
  <div class="row h-100">
    <div class="col-12 p-0 h-100">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-4 col-12 py-5">
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
                        echo alert(languageVariables("password", "login", $languageType), "danger", "0", "/");
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
            <form method="post" class="login-form bg-dark--4 h-100 p-5 row">

              <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                <span class="font-800">
                <?php echo languageVariables("login", "words", $languageType); ?>
                </span>
              </h2>

              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                <label for="login-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("username", "words", $languageType); ?></label>
                <input type="text" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" name="username" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("username", "words", $languageType); ?>" id="login-username" aria-describedby="login-username">
              </div>
              <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                <label for="login-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("password", "words", $languageType); ?></label>
                <input type="password" name="password" placeholder="<?php echo languageVariables("password", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("password", "words", $languageType); ?>" id="login-password" aria-describedby="login-username">
              </div>
              <div class="custom-control custom-checkbox align-items-center d-flex col-lg-6 col-12 mb-3">
                <input type="checkbox" class="custom-control-input" id="login-reminder">
                <label class="custom-control-label o-100 d-block mb-0 text-white font-size-6 font-100" name="remember" for="login-reminder"><?php echo languageVariables("remember", "words", $languageType); ?></label>
              </div>
              <a href="/sifremi-unuttum" class="col-lg-6 col-12 p-0 font-size-6 text-nowrap text-white mt-1 o-50">
                <span class="text-white">
                  <?php echo languageVariables("forgotPassword", "words", $languageType); ?>
                </span>
              </a>
              <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
              <?php echo $safeCsrfToken->input("accountsLoginToken"); ?>
              <button type="submit" name="accountsLogin" class="btn text-white w-100 col-12 mb-3 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                <span class="btn-text">
                <?php echo languageVariables("login", "words", $languageType); ?>
                </span>
              </button>
              <div class="col-12 mb-0 p-0">
                <a href="<?php echo urlConverter("register", $languageType); ?>" class="heading-link text-white o-75 font-size-5 text-center text-uppercase font-100 letter-spacing-1 d-block w-100 line-height-0">
                <?php echo languageVariables("register", "words", $languageType); ?>
                </a>
              </div>
            </form>
          </div>
          <div class="col-lg-8 col-12 py-5 pl-5 d-flex justify-content-center align-items-lg-start align-items-center login-title flex-column text-center text-lg-left">
            <h1 class="text-white">
              <span class="font-100"><?php echo languageVariables("sectionTitle", "login", $languageType); ?></span> <br>
              <span class="font-500"><?php echo languageVariables("sectionInfo", "login", $languageType); ?></span>
            </h1>
            <p class="text-white font-100 o-75 w-50 font-size-7">
              <?php echo languageVariables("sectionText", "login", $languageType); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>