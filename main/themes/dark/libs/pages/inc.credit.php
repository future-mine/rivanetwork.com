<?php AccountLoginControl(false); ?>
<?php if (get("action") == "proccess") { ?>
<?php
  $searchAccountPaymentInformation = $db->prepare("SELECT * FROM accountPaymentInformation WHERE accountID = ?");
  $searchAccountPaymentInformation->execute(array($readAccount["id"]));
  if ($searchAccountPaymentInformation->rowCount() > 0) {
    $readAccountPaymentInformation = $searchAccountPaymentInformation->fetch();
    $paymentInformationStatus = true;
  } else {
    $paymentInformationStatus = false;
  }

  $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
  $readPayments = $searchPayments->fetch();
  $readPaymentVariables = json_decode($readPayments["variables"], true);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("credi", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("upload", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div credit="html"></div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <form>
              <div class="bg-dark--3 p-5">
                <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                  <?php echo languageVariables("creditUpload", "words", $languageType); ?>
                </h3>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder <?php if(isset($readAccount["username"])){ echo 'input-focused'; }?>">
                  <label for="credit-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("user", "words", $languageType); ?></label>
                  <input type="text" placeholder="<?php echo languageVariables("user", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("user", "words", $languageType); ?>" id="credit-username" aria-describedby="credit-username" name="username" value="<?php echo $readAccount["username"]; ?>" readonly>
                </div>
                <?php if ($readPayments["creditType"] == "1" && !empty($readPayments["creditPackets"])) { ?>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 select-wrapper input-focused">
                  <label for="amount" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">
                    <?php echo languageVariables("amount", "words", $languageType); ?>
                  </label>
                  <select id="amount" credit="amount" class="js-select2 w-100" name="amount" data-toggle="select2">
                    <?php if (!empty($readPayments["creditPackets"])) { ?>
                    <?php
                      $searchCreditPackets = json_decode($readPayments["creditPackets"], true);
                      foreach ($searchCreditPackets as $readCreditPackets) {
                        echo "<option value=\"".$readCreditPackets["price"]."\">".$readCreditPackets["title"]."</option>";
                      }
                    ?>
                    <?php } ?>
                  </select>
                </div>
                <?php } else { ?>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                  <label for="credit-amount" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><?php echo languageVariables("amount", "words", $languageType); ?> — ₺</label>
                  <input type="text" credit="amount" placeholder="<?php echo languageVariables("amount", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("amount", "words", $languageType); ?>" id="credit-amount" aria-describedby="credit-amount" name="amount">
                </div>
                <?php } ?>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 select-wrapper input-focused">
                  <label for="selectPayment" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">
                    <i class="fas fa-credit-card fa-xs mr-1"></i><?php echo languageVariables("paymentType", "words", $languageType); ?>
                  </label>
                  <select id="selectPayment" credit="method" class="js-select2 w-100" name="method" data-toggle="select2">
                    <?php if ($readPayments["payments"] !== "disabled" && $readPayments["payments"] !== "[]" && $readPayments["payments"] !== "") { ?>
                    <?php 
                      $searchPaymentTools = json_decode($readPayments["payments"], true);
                      foreach ($searchPaymentTools as $readPaymentTool) {
                        echo "<option value=\"".$readPaymentTool["api"]."-".$readPaymentTool["method"]."\">".$readPaymentTool["title"]."</option>";
                      }
                    ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder <?php if(isset($readAccountPaymentInformation["firstName"])){ echo 'input-focused'; }?>">
                  <label for="name" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("name", "words", $languageType); ?></label>
                  <input type="text" credit="name" placeholder="<?php echo languageVariables("name", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("name", "words", $languageType); ?>" id="name" aria-describedby="name" name="firstName" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["firstName"]; } ?>">
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder <?php if(isset($readAccountPaymentInformation["surName"])){ echo 'input-focused'; }?>">
                  <label for="surname" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("surname", "words", $languageType); ?></label>
                  <input type="text" credit="surname" placeholder="<?php echo languageVariables("surname", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("surname", "words", $languageType); ?>" id="surname" aria-describedby="surname" name="surName" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["surName"]; } ?>">
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder <?php if(isset($readAccountPaymentInformation["phoneNumber"])){ echo 'input-focused'; }?>">
                  <label for="phone" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("phoneNumber", "words", $languageType); ?></label>
                  <input type="text" credit="phoneNumber" placeholder="<?php echo languageVariables("phoneNumber", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("phoneNumber", "words", $languageType); ?>" id="phone" aria-describedby="phone" name="phoneNumber" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["phoneNumber"]; } ?>">
                </div>
                <input type="hidden" credit="userID" value="<?php echo $readAccount["id"]; ?>">
                <?php if ($rSettings["salesAgreementType"] == "1") { ?>
                <input type="hidden" credit="salesAgreementInput" value="0">
                <div class="custom-control custom-checkbox align-items-center d-flex col-lg-6 col-12 mb-3">
                  <input type="checkbox" class="custom-control-input" id="credit-reminder" credit="salesAgreement">
                  <label class="custom-control-label o-100 d-block mb-0 text-white font-size-6 font-100" for="credit-reminder"><?php echo languageVariables("salesAgreement", "credit", $languageType); ?></label>
                </div>
                <?php } ?>
                <button type="button" credit="upload" class="btn float-right text-white col-12 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                  <i class="fas fa-credit-card fa-sm mr-2 btn-icon"></i>
                  <span class="btn-text">
                    <?php echo languageVariables("pay", "words", $languageType); ?>
                  </span>
                </button>
              </div>
            </form>
          </div>
          <?php
            $extraCreditValue = array($readModule['extraCredit']);
            $textValue = array("[credit]");
            $extraCreditText = str_replace($textValue, $extraCreditValue, $readModule['extraCreditText']);
            if($readModule['extraCreditStatus'] == "1"){
              if ($readModule['extraCredit'] > 0) {
                echo alert($extraCreditText, "success", "0", "/");
              }
            }
          ?>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
              <?php if ($searchCreditHistory->rowCount() > 0) { ?>
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("historyTitle", "credit", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <!-- CARD -->
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readCreditHistory["username"]; ?>/100.png" alt="<?php echo $readCreditHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readCreditHistory["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary turkish-lira"><?php echo $readCreditHistory["amount"]; ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="date text-secondary">
                          <?php echo checkTime($readCreditHistory["date"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }?>
                <!-- / CARD -->
              </div>
              <?php }else{ ?>
                <?php echo alert(languageVariables("alertNotHistory", "credit", $languageType), "danger", "0", "/"); ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "transactions") { ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="/anasayfa" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="/kredi/yukle" class="text-white font-100"><?php echo languageVariables("payment", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php if (get("target") == "successyfull") { echo languageVariables("success", "words", $languageType); } else { echo languageVariables("unsuccess", "words", $languageType); } ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-12 col-12 pb-5 pt-3">
            <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
              <?php echo languageVariables("creditTrans", "words", $languageType); ?> <?php if (get("target") == "successyfull") { echo languageVariables("uploadSuccess", "words", $languageType); } else { echo languageVariables("uploadUnsuccess", "words", $languageType); } ?>
            </h3>
            <?php 
                if (get("target") == "successyfull") { 
                  echo alert(languageVariables("alertUploadSuccess", "credit", $languageType), "success", "3", urlConverter("profile", $languageType));
                } else {
                  echo alert(languageVariables("alertUploadUnsuccess", "credit", $languageType), "danger", "3", urlConverter("credit_upload", $languageType));
                }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "transfer") { ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("credit", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("send", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["creditTransfer"])) {
              if ($safeCsrfToken->validate('creditTransferToken')) {
                if (post("username") !== "" && post("credit") !== "") {
                  if (post("credit") > 0) {
                    if ($readAccount["credit"] >= post("credit")) {
                      $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                      $searchPlayer->execute(array(post("username")));
                      if ($searchPlayer->rowCount() > 0) {
                        $readPlayer = $searchPlayer->fetch();
                        if ($readAccount["id"] !== $readPlayer["id"]) {
                          if (inventoryItemCount($readPlayer["id"], 1) == true) {
                            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit - ? WHERE id = ?");
                            $updateAccount->execute(array(post("credit"), $readAccount["id"]));
                            $insertHistory = $db->prepare("INSERT INTO creditHistory SET username = ?, usernameTo = ?, method = ?, type = ?, transID = ?, amount = ?, date = ?, timeStamp = ?");
                            $insertHistory->execute(array($readAccount["username"], $readPlayer["username"], 0, 1, 0, post("credit"), date("d.m.Y H:i"), time()));
                            $variables = "{\"credit\": \"".post("credit")."\", \"image\": \"/main/includes/packages/layouts/inventory/image/credit/default.png\"}";
                            inventoryAddItem($readPlayer["id"], "1", $variables, date("d.m.Y H:i:s"));
                            echo alert(str_replace(["&credit","&username"], [post("credit"), post("username")], languageVariables("alertSuccess", "credit", $languageType)), "success", "3", "");
                          } else {
                            echo alert(languageVariables("alertNotInventory", "credit", $languageType), "warning", "0", "/");
                          }
                        } else {
                          echo alert(languageVariables("alertSelf", "credit", $languageType), "warning", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertNotUser", "credit", $languageType), "danger", "0", "/");
                      }
                	} else {
                	  echo alert(languageVariables("alertNotCredit", "credit", $languageType), "danger", "0", "/");
                	}
                  } else {
                    echo alert(languageVariables("alertAmount", "credit", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNone", "credit", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "credit", $languageType), "danger", "0", "/");
              }
            }
            ?>
            <form method="post">
              <div class="bg-dark--3 p-5">
                <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                  <?php echo languageVariables("sendCredit", "credit", $languageType); ?>
                </h3>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder <?php if(isset($_POST["username"])){ echo 'input-focused'; }?>">
                  <label for="credit-username" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("user", "words", $languageType); ?></label>
                  <input type="text" placeholder="<?php echo languageVariables("user", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("user", "words", $languageType); ?>" id="credit-username" aria-describedby="credit-username" name="username" value="<?php if (isset($_POST["username"])) { echo post("username"); } ?>">
                </div>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0">
                  <label for="credit-amount" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><?php echo languageVariables("amount", "words", $languageType); ?> — ₺</label>
                  <input type="text" placeholder="<?php echo languageVariables("amount", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("amount", "words", $languageType); ?>" id="credit-amount" aria-describedby="credit-amount" name="credit">
                </div>
                <?php echo $safeCsrfToken->input("creditTransferToken"); ?>
                <button type="submit" name="creditTransfer" class="btn float-right text-white col-12 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                  <i class="fas fa-credit-card fa-sm mr-2 btn-icon"></i>
                  <span class="btn-text">
                    <?php echo languageVariables("send", "words", $languageType); ?>
                  </span>
                </button>
              </div>
            </form>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
              <?php if ($searchCreditHistory->rowCount() > 0) { ?>
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("historyTitle", "credit", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <!-- CARD -->
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readCreditHistory["username"]; ?>/100.png" alt="<?php echo $readCreditHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readCreditHistory["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary turkish-lira"><?php echo $readCreditHistory["amount"]; ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="date text-secondary">
                          <?php echo checkTime($readCreditHistory["date"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }?>
                <!-- / CARD -->
              </div>
              <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "warning", "0", "/"); } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "paytr") { ?>
<?php
$searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentAPIType = ? AND paymentID = ?");
$searchPaymentTransaction->execute(array("paytr", get("paymentID")));
if ($searchPaymentTransaction->rowCount() > 0) {
    $readPaymentTransaction = $searchPaymentTransaction->fetch();
    $readPaymentTransactionVariables = json_decode($readPaymentTransaction["variables"], true);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("payment", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100">PayTR</a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-12 col-12 pb-5 pt-3">
            <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
              <?php echo languageVariables("creditTrans", "words", $languageType); ?> (PayTR)
            </h3>
            <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
            <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $readPaymentTransactionVariables["paytrToken"]; ?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
            <script>
              iFrameResize({}, '#paytriframe');
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("credit_uplaod", $languageType)); } ?>
<?php } else if (get("action") == "shopier") { ?>
<?php
    $searchAccountPaymentInformation = $db->prepare("SELECT * FROM accountPaymentInformation WHERE accountID = ?");
    $searchAccountPaymentInformation->execute(array($readAccount["id"]));
    $readAccountPaymentInformation = $searchAccountPaymentInformation->fetch();
    $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ?");
    $searchPaymentTransaction->execute(array(get("paymentID")));
    if ($searchPaymentTransaction->rowCount() > 0) {
      $readPaymentTransaction = $searchPaymentTransaction->fetch();
      $readPaymentTransactionVariables = json_decode($readPaymentTransaction["variables"], true);
      
      $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
      $readPayments = $searchPayments->fetch();
      $readPaymentVariables = json_decode($readPayments["variables"], true);
      
      require_once(__DR__."/main/includes/packages/class/shopier/class.php");
      $shopier = new Shopier($readPaymentVariables['shopierAPIKey'], $readPaymentVariables['shopierAPISecretKey']);
      
      $shopier->setBuyer([
          "id" => $readAccount["id"],
          "first_name" => $readAccountPaymentInformation["firstName"],
          "last_name" => $readAccountPaymentInformation["surName"],
          "email" => $readAccount["email"],
          "phone" => $readAccountPaymentInformation["phoneNumber"]
      ]);
      $shopier->setOrderBilling([
          "billing_address" => "Konya Meram Kozağaç Mh. Aralık Sk. No: ".rand(100000,999999),
          "billing_city" => "Konya",
          "billing_country" => "Turkey",
          "billing_postcode" => rand(100000,999999),
      ]);
      $shopier->setOrderShipping([
          "shipping_address" => "Konya Meram Kozağaç Mh. Aralık Sk. No: ".rand(100000,999999),
          "shipping_city" => "Konya",
          "shipping_country" => "Turkey",
          "shipping_postcode" => rand(100000,999999),
      ]);
      die($shopier->run($readPaymentTransaction["paymentID"], $readPaymentTransactionVariables["amount"], (urlConverter("payment_callback", $languageType)."/shopier")));
    } else {
      go(urlConverter("credit_upload", $languageType));
    }
  ?>
<?php }?>