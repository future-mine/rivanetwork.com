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
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="container-fluid login-container" style="background-image: linear-gradient(to right, rgba(30, 30, 30, .9) 50%, rgba(30, 30, 30, 0) 80%),
    url('/main/themes/dark/theme/assets/assets/blog-4.jpg')">
        <div class="row h-100">
            <div class="col-12 p-0 h-100">
                <div class="container h-100">
                    <div class="row h-100">
                    <?php if ($passwordChange == "TRANSACTIONS") { ?>
                        <div class="col-lg-4 col-12 py-5">
                          <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                            <span class="font-800">
                              <?php echo (($passwordChange == "TRANSACTIONS") ? languageVariables("passwordForgot", "words", $languageType) : languageVariables("passwordChange", "words", $languageType)); ?>
                            </span>
                          </h2>
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
                            <form action="" method="post" class="login-form bg-dark--4 h-100 p-5 row">
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="forgot-password-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("username", "words", $languageType); ?></label>
                                    <input type="text" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" name="username" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("username", "words", $languageType); ?>" id="forgot-password-username" aria-describedby="forgot-password-username">
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="forgot-password-mail" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-at fa-xs mr-1"></i><?php echo languageVariables("email", "words", $languageType); ?></label>
                                    <input type="mail" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>" name="email" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("email", "words", $languageType); ?>" id="forgot-password-mail" aria-describedby="forgot-password-username">
                                </div>
                
                                <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                                <?php echo $safeCsrfToken->input("passwordRecoveryToken"); ?>
                                <button type="submit" name="passwordRecovery" class="btn text-white w-100 mb-3 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                    <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                                    <span class="btn-text">
                                      <?php echo languageVariables("send", "words", $languageType); ?>
                                    </span>
                                </button>
                                <div class="col-12 mb-0 p-0">
                                    <a href="<?php echo urlConverter("login", $languageType); ?>" class="heading-link text-white o-75 font-size-5 text-center text-uppercase font-100 letter-spacing-1 d-block w-100 line-height-0">
                                      <?php echo languageVariables("login", "words", $languageType); ?>
                                    </a>
                                </div>
                            </form>
                        </div>
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
                        <div class="col-lg-4 col-12 py-5">
                            <form action="" class="login-form bg-dark--4 h-100 p-5 row" method="post">
                                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                                    <span class="font-800">
                                    <?php echo languageVariables("passwordChange", "words", $languageType); ?>
                                    </span>
                                </h2>
                                
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="change-password-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("newPassword", "words", $languageType); ?></label>
                                    <input type="password" name="password" placeholder="<?php echo languageVariables("newPassword", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("newPassword", "words", $languageType); ?>" id="change-password-password" aria-describedby="change-password-username">
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="change-password-password-verify" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("newPasswordRe", "words", $languageType); ?></label>
                                    <input type="password" name="passwordRe" placeholder="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>" id="change-password-password-verify" aria-describedby="change-password-username">
                                </div>
                                <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                                <?php echo $safeCsrfToken->input("passwordChangeToken"); ?>
                                <button type="submit" name="passwordChange" class="btn text-white w-100 col-12 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                    <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                                    <span class="btn-text">
                                    <?php echo languageVariables("change", "words", $languageType); ?>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <?php } ?>

                        <div class="col-lg-8 col-12 py-5 pl-5 d-flex justify-content-center align-items-lg-start align-items-center login-title flex-column text-center text-lg-left">
                            <h1 class="text-white">
                                <span class="font-100"><?php echo languageVariables("sectionTitle", "recovery", $languageType); ?></span> <br>
                                <span class="font-500"><?php echo languageVariables("sectionInfo", "recovery", $languageType); ?></span>
                            </h1>
                            <p class="text-white font-100 o-75 w-50 font-size-7">
                            <?php echo languageVariables("sectionText", "recovery", $languageType); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>