<?php AccountLoginControl(true); ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
  <div class="grid grid-4-8 mobile-prefer-content">
    <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("register", "words", $languageType); ?></p>
          <div class="widget-box-content">
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
                                              $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                                              $insertNotifications->execute(array($readAccountNewRegister["username"], $readAccountNewRegister["id"], str_replace("&serverName", $rSettings["serverName"], languageVariables("welcome", "notifications", $languageType)), '{"iconType":"small-arrow","userIP":"'.GetIP().'"}', "register", date("d.m.Y H:i:s"), "unread"));
                                            }
                                            $loginSessionsToken = md5(uniqid(mt_rand(), true));
                                            $insertAccountSessions = $db->prepare("INSERT INTO accountLoginSessions (`accountID`, `sessionToken`, `sessionIP`, `date`, `time`) VALUES (?,?,?,?,?)");
                                            $insertAccountSessions->execute(array($readAccountNewRegister["id"], $loginSessionsToken, GetIP(), date("d.m.Y H:i:s"), time()));
                                            $_SESSION["incAccountLogin"] = $loginSessionsToken;
                                            echo alert(languageVariables("alertSuccess", "recovery", $languageType), "success", "3", urlConverter("profile", $languageType));
                                          } else {
                                            echo alert(languageVariables("alertError", "recovery", $languageType), "danger", "0", "/");
                                          }
                                        } else {
                                          echo alert(languageVariables("alertSystem", "recovery", $languageType), "danger", "0", "/");
                                        }
                                      } else {
                                        echo alert(languageVariables("alertRegisterLimit", "recovery", $languageType), "danger", "0", "/");
                                      }
                                    } else {
                                      echo alert(languageVariables("alertPassword2", "recovery", $languageType), "danger", "0", "/");
                                    }
                                  } else {
                                    echo alert(languageVariables("alertPassword1", "recovery", $languageType), "danger", "0", "/");
                                  }
                                } else {
                                  echo alert(str_replace("&email", post("email"), languageVariables("alertEmailAlready", "register", $languageType)), "danger", "0", "/");
                                }
                              } else {
                                echo alert(str_replace("&username", post("username"), languageVariables("alertUsernameAlready", "register", $languageType)), "danger", "0", "/");
                              }
                            } else {
                              echo alert(languageVariables("alertEmail", "recovery", $languageType), "danger", "0", "/");
                            }
                          } else {
                            echo alert(languageVariables("alertUsername3", "recovery", $languageType), "danger", "0", "/");
                          }
                        } else {
                          echo alert(languageVariables("alertUsername2", "recovery", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertUsername1", "recovery", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertNone", "recovery", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertRules", "recovery", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertRobot", "recovery", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "recovery", $languageType), "danger", "0", "/");
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
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input small <?php if (isset($_POST["email"])) { echo "active"; } ?>">
                    <label for="account-email"><?php echo languageVariables("email", "words", $languageType); ?></label>
                    <input type="text" id="account-email" name="email" value="<?php echo post("email"); ?>">
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
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="account-current-passwordRe"><?php echo languageVariables("rePassword", "words", $languageType); ?></label>
                    <input type="password" id="account-current-passwordRe" name="passwordRe">
                  </div>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <input type="checkbox" id="register-rules" name="rules">
                    <div class="checkbox-box">
                      <svg class="icon-cross">
                        <use xlink:href="#svg-cross"></use>
                      </svg>
                    </div>
                    <label for="register-rules"><?php echo languageVariables("rulesConfirm", "words", $languageType); ?></label>
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
                  <?php echo $safeCsrfToken->input("accountsRegisterToken"); ?>
                  <button class="button full primary" type="submit" name="accountsRegister"><?php echo languageVariables("register", "words", $languageType); ?></button>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <br><label class="mobile-label-south"><?php echo languageVariables("footerText", "register", $languageType); ?> <a href="<?php echo urlConverter("login", $languageType); ?>" class="text-primary"><?php echo languageVariables("login", "words", $languageType); ?></a></label>
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
            <span style="font-weight: 100;"><?php echo languageVariables("sectionTitle", "recovery", $languageType); ?></span> <br>
            <span style="font-weight: 500;"><?php echo languageVariables("sectionInfo", "recovery", $languageType); ?></span>
          </h1><br>
          <p class="o-75 w-75" style="font-weight: 100; font-size: 24px; color: <?php if ($_SESSION["themeModeType"] == "dark") { echo "white"; } else if ($_SESSION["themeModeType"] == "light") { echo "#3e3f5e"; } ?>;"><?php echo languageVariables("sectionText", "recovery", $languageType); ?></p>
		</div>
    </div>
  </div>
</div>