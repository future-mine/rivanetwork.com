<?php AccountLoginControl(true); ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $languageType; ?>"></script>
<div class="container-fluid login-container" style="background-image: linear-gradient(to right, rgba(30, 30, 30, .9) 50%, rgba(30, 30, 30, 0) 80%)">
        <div class="row h-100">
            <div class="col-12 p-0 h-100">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-lg-4 col-12 py-5">
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
                            <form action="" method="post" class="login-form bg-dark--4 h-100 p-5 row">
                                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                                    <span class="font-800">
                                      <?php echo languageVariables("register", "words", $languageType); ?>
                                    </span>
                                </h2>
                                
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="register-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("username", "words", $languageType); ?></label>
                                    <input type="text" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" name="username" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("username", "words", $languageType); ?>" id="register-username" aria-describedby="register-username">
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="register-mail" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-at fa-xs mr-1"></i><?php echo languageVariables("email", "words", $languageType); ?></label>
                                    <input type="mail" placeholder="<?php echo languageVariables("email", "words", $languageType); ?>"name="email"  class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("email", "words", $languageType); ?>" id="register-mail" aria-describedby="register-username">
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="register-password" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("password", "words", $languageType); ?></label>
                                    <input type="password" placeholder="<?php echo languageVariables("password", "words", $languageType); ?>" name="password" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("password", "words", $languageType); ?>" id="register-password" aria-describedby="register-username">
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                                    <label for="register-password-verify" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-star-of-life fa-xs mr-1"></i><?php echo languageVariables("rePassword", "words", $languageType); ?></label>
                                    <input type="password" name="passwordRe" placeholder="<?php echo languageVariables("rePassword", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("rePassword", "words", $languageType); ?>" id="register-password-verify" aria-describedby="register-username">
                                </div>
                                <div class="custom-control custom-checkbox align-items-center mb-3 d-flex col-12">
                                    <input type="checkbox" class="custom-control-input" id="register-rules" name="rules" >
                                    <label class="custom-control-label o-100 d-block mb-0 text-white font-size-6 font-100" for="register-rules"><?php echo languageVariables("rulesConfirm", "words", $languageType); ?></label>
                                </div>
                                <div class="input-group mb-3 flex-column bg-dark--5 col-12 p-0">
                                <?php if ($rSettings['recaptchaStatus'] > 0) { ?><div class="g-recaptcha" data-sitekey="<?php echo $rSettings['recaptchaPublicKey']; ?>"></div><br><?php } ?>
                                </div>
                                <?php echo $safeCsrfToken->input("accountsRegisterToken"); ?>
                                <button type="submit"name="accountsRegister" class="btn text-white w-100 col-12 mb-3 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                                    <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>

                                    <span class="btn-text">
                                    <?php echo languageVariables("register", "words", $languageType); ?>
                                </button>
                                <div class="col-12 mb-0 p-0">
                                    <a href="<?php echo urlConverter("login", $languageType); ?>" class="heading-link text-white o-75 font-size-5 text-center text-uppercase font-100 letter-spacing-1 d-block w-100 line-height-0">
                                    <?php echo languageVariables("login", "words", $languageType); ?> 
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8 col-12 py-5 pl-5 d-flex justify-content-center align-items-lg-start align-items-center login-title flex-column text-center text-lg-left">
                            <h1 class="text-white">
                                <span class="font-100"><?php echo languageVariables("sectionTitle", "register", $languageType); ?></span> <br>
                                <span class="font-500"><?php echo languageVariables("sectionInfo", "register", $languageType); ?></span>
                            </h1>
                            <p class="text-white font-100 o-75 w-50 font-size-7">
                            <?php echo languageVariables("sectionText", "register", $languageType); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>