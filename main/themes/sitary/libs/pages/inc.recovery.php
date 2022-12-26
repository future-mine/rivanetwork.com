<?php AccountLoginControl(true); ?>
<?php
  $passwordChange = "TRANSACTIONS";
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  
  if (isset($_GET["token"])) {
    $searchPasswordRecovery = $db->prepare("SELECT * FROM passwordRecovery WHERE token = ? AND status = ?");
    $searchPasswordRecovery->execute(array(get("token"), 0));
    if ($searchPasswordRecovery->rowCount() > 0) {
      $readPasswordRecovery = $searchPasswordRecovery->fetch();
      $passwordChange = "READY_PASSWORD_CHANGE";
    } else {
      go(urlConverter("recovery", $languageType));
    }
  }
?>
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
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
  <div class="grid grid-4-8 mobile-prefer-content">
    <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo (($passwordChange == "TRANSACTIONS") ? languageVariables("passwordForgot", "words", $languageType) : languageVariables("passwordChange", "words", $languageType)); ?></p>
          <div class="widget-box-content">
          <?php if ($passwordChange == "TRANSACTIONS") { ?>
            <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["passwordRecovery"])) {
              if ($safeCsrfToken->validate('passwordRecoveryToken')) {
                if (isset($_POST['g-recaptcha-response'])) {
                 $loginRecaptcha = $_POST['g-recaptcha-response'];
                }
                if ($rSettings['recaptchaStatus'] == 0 || $loginRecaptcha) {
                  if (post("username") !== "" && post("email") !== "") {
                    $searchAccounts = $db->prepare("SELECT * FROM accounts WHERE username = ? AND email = ?");
                    $searchAccounts->execute(array(post("username"), post("email")));
                    if ($searchAccounts->rowCount() > 0) {
                      $readAccount = $searchAccounts->fetch();
                      $searchPasswordRecovery = $db->prepare("SELECT * FROM passwordRecovery WHERE username = ? AND status = ?");
                      $searchPasswordRecovery->execute(array($readAccount["username"], 0));
                      if ($searchPasswordRecovery->rowCount() == 0) {
                        $recoveryToken = strtoupper(md5(uniqid(mt_rand(), true)));
                        
                        // SMTP SETTİNGS
                        $url = $siteURL."/sifremi-unuttum/".$recoveryToken;
                        
                        require_once(__DR__."/main/includes/packages/class/phpmailer/exception.php");
                        require_once(__DR__."/main/includes/packages/class/phpmailer/phpmailer.php");
                        require_once(__DR__."/main/includes/packages/class/phpmailer/smtp.php");
                        $phpMailer = new PHPMailer(true);
                        try {
                          $phpMailer->IsSMTP();
                          $phpMailer->setLanguage('tr', __DR__.'/main/includes/packages/class/phpmailer/lang/');
                          $phpMailer->SMTPAuth = true;
                          $phpMailer->Host = $rSettings["smtpServer"];
                          $phpMailer->Port = $rSettings["smtpPort"];
                          if ($rSettings["smtpSecure"] == 2) {
                            $phpMailer->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
                          } else {
                            $phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                          }
                          $phpMailer->Username = $rSettings["smtpUsername"];
                          $phpMailer->Password = $rSettings["smtpPassword"];
                          $phpMailer->SetFrom($phpMailer->Username, $rSettings["serverName"]);
                          $phpMailer->AddAddress($readAccount["email"], $readAccount["username"]);
                          $phpMailer->isHTML(true);
                          $phpMailer->CharSet = 'UTF-8';
                          $phpMailer->Subject = $rSettings["serverName"]." - Şifre Sıfırlama Bağlantısı";
                          $phpMailer->Body = str_replace(array("[username]", "[url]", "[domain]"), array($readAccount["username"], $url, "www.".str_replace('www.','', $_SERVER["HTTP_HOST"])), $rSettings["smtpTemplate"]);
                          $phpMailer->send();
                          $insertPasswordRecovery = $db->prepare("INSERT INTO passwordRecovery (`username`, `email`, `token`, `status`) VALUES (?, ?, ?, ?)");
                          $insertPasswordRecovery->execute(array($readAccount["username"], $readAccount["email"], $recoveryToken, 0));
                          echo alert(languageVariables("alertRecoverySuccess", "recovery", $languageType), "success", "0", "/");
                        } catch (Exception $ex) {
                          echo alert(languageVariables("alertSystem", "recovery", $languageType).": ".$ex->errorMessage(), "danger", "0", "/");
                        }
                        // SMTP SETTİNGS END
                      } else {
                        echo alert(languageVariables("alertAlreadyRecovery", "recovery", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertNotAccount", "recovery", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertNone", "recovery", $languageType), "warning", "0", "/");
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
                    <input type="text" id="account-username" name="username" value="<?php if (isset($_POST["username"])) { echo post("username"); } ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input small <?php if (isset($_POST["email"])) { echo "active"; } ?>">
                    <label for="account-email"><?php echo languageVariables("email", "words", $languageType); ?></label>
                    <input type="text" id="account-email" name="email" value="<?php if (isset($_POST["email"])) { echo post("email"); } ?>">
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
                  <?php echo $safeCsrfToken->input("passwordRecoveryToken"); ?>
                  <button class="button full primary" type="submit" name="passwordRecovery"><?php echo languageVariables("send", "words", $languageType); ?></button>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <br><label class="mobile-label-south"><?php echo languageVariables("footerText", "recovery", $languageType); ?> <a href="<?php echo urlConverter("login", $languageType); ?>" class="text-primary"><?php echo languageVariables("login", "words", $languageType); ?></a></label>
                  </div>
                </div>
              </div>
            </form>
          <?php } else if ($passwordChange == "READY_PASSWORD_CHANGE") { ?>
            <?php 
              require_once(__DR__."/main/includes/packages/class/csrf/class.php");
              $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
              if (isset($_POST["passwordChange"])) {
                if ($safeCsrfToken->validate('passwordChangeToken')) {
                  if (isset($_POST['g-recaptcha-response'])) {
                   $loginRecaptcha = $_POST['g-recaptcha-response'];
                  }
                  if ($rSettings['recaptchaStatus'] == 0 || $loginRecaptcha) {
                    if (post("password") !== "" && post("passwordRe") !== "") {
                      if (post("password") == post("passwordRe")) {
                        if (strlen(post("password")) >= 4) {
                          $generatePassword = generateSHA256(post("password"));
                          $updateAccountPassword = $db->prepare("UPDATE accounts SET password = ? WHERE username = ?");
                          $updateAccountPassword->execute(array($generatePassword, $readPasswordRecovery["username"]));
                          $updatePasswordRecovery = $db->prepare("UPDATE passwordRecovery SET status = ? WHERE id = ?");
                          $updatePasswordRecovery->execute(array(1, $readPasswordRecovery["id"]));
                          echo alert(languageVariables("alertPasswordSuccess", "recovery", $languageType), "success", "3", urlConverter("login", $languageType));
                        } else {
                          echo alert(languageVariables("alertPassword3", "recovery", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertPassword2", "recovery", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertPassword1", "recovery", $languageType), "warning", "0", "/");
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
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="recovery-password"><?php echo languageVariables("newPassword", "words", $languageType); ?>:</label>
                    <input type="password" id="recovery-password" name="password">
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="recovery-password-re"><?php echo languageVariables("newPasswordRe", "words", $languageType); ?>:</label>
                    <input type="password" id="recovery-password-re" name="passwordRe">
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
                  <?php echo $safeCsrfToken->input("passwordChangeToken"); ?>
                  <button class="button full primary" type="submit" name="passwordChange"><?php echo languageVariables("change", "words", $languageType); ?></button>
                </div>
              </div>
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <br><label class="mobile-label-south"><?php echo languageVariables("footerText", "recovery", $languageType); ?> <a href="<?php echo urlConverter("login", $languageType); ?>" class="text-primary"><?php echo languageVariables("login", "words", $languageType); ?></a></label>
                  </div>
                </div>
              </div>
            </form>
          <?php } ?>
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