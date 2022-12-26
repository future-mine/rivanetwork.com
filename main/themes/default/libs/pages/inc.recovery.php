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
        <h1 class="text-gray-800 text-3xl font-bold"><?php echo (($passwordChange == "TRANSACTIONS") ? languageVariables("passwordForgot", "words", $languageType) : languageVariables("passwordChange", "words", $languageType)); ?></h1>
        <p class="text-gray-400 mt-4 font-medium mb-4"><?php echo languageVariables("sectionTitle", "recovery", $languageType); ?></p>
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
        <form action="" method="POST" class="mt-16">
          <div class=" items-center">
            <label for="username" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("username", "words", $languageType); ?></label>
            <input type="text" id="username" name="username" class="w-full form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="email" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("email", "words", $languageType); ?></label>
            <input type="email" id="email" name="email" class="w-full form-control" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
          </div>
          <?php echo $safeCsrfToken->input("passwordRecoveryToken"); ?>
          <div class="mt-12 flex gap-6 items-center">
            <button type="submit" name="passwordRecovery" class="btn btn-white btn-lg w-40"><?php echo languageVariables("send", "words", $languageType); ?></button>
            <a href="<?php echo urlConverter("login", $languageType); ?>" class="p-2 relative overflow-hidden text-gray-400 font-medium text-sm transition hover:text-gray-500 group">
              <?php echo languageVariables("login", "words", $languageType); ?>
              <span class="h-0.5 w-full bg-gray-400 rounded absolute bottom-0 -left-full group-hover:left-0 transition-all"></span>
            </a>
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
        <form action="" method="POST" class="mt-16">
          <div class=" items-center">
            <label for="password" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("newPassword", "words", $languageType); ?></label>
            <input type="text" id="password" name="password" class="w-full form-control" placeholder="<?php echo languageVariables("newPassword", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <label for="passwordRe" class="text-gray-500 font-medium mb-2 block"><?php echo languageVariables("newPasswordRe", "words", $languageType); ?></label>
            <input type="password" id="passwordRe" name="passwordRe" class="w-full form-control" placeholder="<?php echo languageVariables("newPasswordRe", "words", $languageType); ?>">
          </div>
          <div class="mt-6">
            <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
          </div>
          <?php echo $safeCsrfToken->input("passwordChangeToken"); ?>
          <div class="mt-12 flex gap-6 items-center">
            <button type="submit" name="passwordChange" class="btn btn-white btn-lg w-40"><?php echo languageVariables("change", "words", $languageType); ?></button>
            <a href="<?php echo urlConverter("login", $languageType); ?>" class="p-2 relative overflow-hidden text-gray-400 font-medium text-sm transition hover:text-gray-500 group">
              <?php echo languageVariables("login", "words", $languageType); ?>
              <span class="h-0.5 w-full bg-gray-400 rounded absolute bottom-0 -left-full group-hover:left-0 transition-all"></span>
            </a>
          </div>
        </form>
        <?php } ?>
      </div>
      <div class="mt-auto bg-gray-50/50 py-8 px-12 xl:px-32 flex gap-8 items-center">
        <div class="rounded-2xl w-16 h-16 bg-indigo-100/50 flex items-center justify-center">
          <i class="fas fa-question text-xl text-indigo-600"></i>
        </div>
        <div>
          <a href="<?php echo urlConverter("login", $languageType); ?>" class="text-gray-700 text-lg font-semibold transition hover:text-indigo-400"><?php echo languageVariables("footerText", "recovery", $languageType); ?></a>
          <div class="text-gray-400"><?php echo languageVariables("login", "words", $languageType); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>