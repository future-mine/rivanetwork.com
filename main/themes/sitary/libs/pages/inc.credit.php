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
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- CREDIT TRANSFER -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("upload", "words", $languageType); ?></h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-box-content">
            <div credit="html"></div>
            <form action="" method="POST">
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small active">
                    <div class="social-link no-hover patreon">
                      <svg class="icon-patreon">
                        <use xlink:href="#svg-members"></use>
                      </svg>
                    </div>
                    <label for="credit-username"><?php echo languageVariables("username", "words", $languageType); ?></label>
                    <input type="text" id="credit-username" name="username" value="<?php echo $readAccount["username"]; ?>" readonly>
                  </div>
                </div>
              </div>
              <?php if ($readPayments["creditType"] == "1" && !empty($readPayments["creditPackets"])) { ?>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-select">
                    <label for="upload-credit"><?php echo languageVariables("amount", "words", $languageType); ?></label>
                    <select id="upload-credit" credit="amount" name="amount">
                      <?php if (!empty($readPayments["creditPackets"])) { ?>
                      <?php 
                        $searchCreditPackets = json_decode($readPayments["creditPackets"], true);
                        foreach ($searchCreditPackets as $readCreditPackets) {
                          echo "<option value=\"".$readCreditPackets["price"]."\">".$readCreditPackets["title"]."</option>";
                        }
                      ?>
                      <?php } ?>
                    </select>
                    <svg class="form-select-icon icon-small-arrow">
                      <use xlink:href="#svg-small-arrow"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } else { ?>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small">
                    <div class="social-link no-hover youtube">
                      <svg class="icon-youtube">
                        <use xlink:href="#svg-revenue"></use>
                      </svg>
                    </div>
                    <label for="upload-credit"><?php echo languageVariables("amount", "words", $languageType); ?></label>
                    <input type="text" credit="amount" id="upload-credit" name="amount">
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-select">
                    <label for="support-category"><?php echo languageVariables("paymentMethod", "words", $languageType); ?></label>
                    <select id="support-category" credit="method" name="method">
                      <?php if ($readPayments["payments"] !== "disabled" && $readPayments["payments"] !== "[]" && $readPayments["payments"] !== "") { ?>
                      <?php 
                        $searchPaymentTools = json_decode($readPayments["payments"], true);
                        foreach ($searchPaymentTools as $readPaymentTool) {
                          echo "<option value=\"".$readPaymentTool["api"]."-".$readPaymentTool["method"]."\">".$readPaymentTool["title"]."</option>";
                        }
                      ?>
                      <?php } ?>
                    </select>
                    <svg class="form-select-icon icon-small-arrow">
                      <use xlink:href="#svg-small-arrow"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small <?php if ($paymentInformationStatus == true) { echo "active"; } ?>">
                    <div class="social-link no-hover facebook">
                      <svg class="icon-facebook">
                        <use xlink:href="#svg-members"></use>
                      </svg>
                    </div>
                    <label for="credit-firstname"><?php echo languageVariables("name", "words", $languageType); ?></label>
                    <input type="text" credit="name" id="credit-firstname" name="firstName" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["firstName"]; } ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small <?php if ($paymentInformationStatus == true) { echo "active"; } ?>">
                    <div class="social-link no-hover facebook">
                      <svg class="icon-facebook">
                        <use xlink:href="#svg-members"></use>
                      </svg>
                    </div>
                    <label for="credit-surname"><?php echo languageVariables("surname", "words", $languageType); ?></label>
                    <input type="text" credit="surname" id="credit-surname" name="surName" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["surName"]; } ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small <?php if ($paymentInformationStatus == true) { echo "active"; } ?>">
                    <div class="social-link no-hover facebook">
                      <svg class="icon-facebook">
                        <use xlink:href="#svg-pinned"></use>
                      </svg>
                    </div>
                    <label for="credit-phone"><?php echo languageVariables("phoneNumber", "words", $languageType); ?></label>
                    <input type="text" id="credit-phone" credit="phoneNumber" name="phoneNumber" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["phoneNumber"]; } ?>">
                  </div>
                </div>
              </div>
              <?php if ($rSettings["salesAgreementType"] == "1") { ?>
              <input type="hidden" credit="salesAgreementInput" value="0">
              <div class="form-row space-between">
                <div class="form-item">
                  <div class="checkbox-wrap">
                    <input type="checkbox" id="credit-salesAgreement" name="salesAgreement" credit="salesAgreement">
                    <div class="checkbox-box">
                      <svg class="icon-cross">
                        <use xlink:href="#svg-cross"></use>
                      </svg>
                    </div>
                    <label for="credit-salesAgreement"><?php echo languageVariables("salesAgreement", "credit", $languageType); ?></label>
                  </div>
                </div>
              </div>
              <?php } ?>
              <input type="hidden" credit="userID" value="<?php echo $readAccount["id"]; ?>">
              <div class="form-row split mt-3">
                <div class="form-item active">
                  <button class="button w-25 primary" style="float:right;" type="button" credit="upload"><?php echo languageVariables("upload", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /CREDIT TRANSFER -->
      
      <div class="grid-column">
        <?php
        $extraCreditValue = array($readModule['extraCredit']);
        $textValue = array("[credit]");
        $extraCreditText = str_replace($textValue, $extraCreditValue, $readModule['extraCreditText']);
        if($readModule['extraCreditStatus'] == "1"){
          if ($readModule['extraCredit'] > 0) {
            echo "<div class=\"section-header\"><div class=\"section-header-info\"><p class=\"section-pretitle\">".languageVariables("creditTrans", "words", $languageType)."</p><h2 class=\"section-title\">".languageVariables("infois", "words", $languageType)."</h2></div></div><div class=\"extra-credit-card\">".$extraCreditText."</div>";
          }
        }
        ?>
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("historyTitle", "words", $languageType); ?></h2>
          </div>
        </div>
        <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
        <?php if ($searchCreditHistory->rowCount() > 0) { ?>
        <div class="widget-box">
          <div class="widget-box-content">
            <div class="user-status-list">
              <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
              <div class="user-status">
                <a class="user-status-avatar" href="/oyuncu/<?php echo $readCreditHistory["username"]; ?>">
                	<img src="https://minotar.net/bust/<?php echo $readCreditHistory["username"]; ?>/100.png" width="40" height="40">
                </a>
                <?php if ($readCreditHistory["method"] == 0) { $paymentMethodText = languageVariables("paymentMobile", "words", $languageType); } else if ($readCreditHistory["method"] == 1) { $paymentMethodText = languageVariables("paymentCredit", "words", $languageType); } ?>
                <p class="user-status-title"><?php echo str_replace(array("&username", "&method", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readCreditHistory["username"]."\">".$readCreditHistory["username"]."</a>", $paymentMethodText, $readCreditHistory["amount"]), languageVariables("historyText", "credit", $languageType)); ?></p>
                <p class="user-status-timestamp"><?php echo checkTime($readCreditHistory["date"]); ?></p>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "warning", "0", "/"); } ?>
      </div>
    </div>
</div>
<?php } else if (get("action") == "transactions") { ?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- CREDIT TRANSFER -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php if (get("target") == "successyfull") { echo languageVariables("uploadSuccess", "words", $languageType); } else { echo languageVariables("uploadUnsuccess", "words", $languageType); } ?></h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-box-content">
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
      <!-- /CREDIT TRANSFER -->
      
      <div class="grid-column">
        <?php
        $extraCreditValue = array($readModule['extraCredit']);
        $textValue = array("[credit]");
        $extraCreditText = str_replace($textValue, $extraCreditValue, $readModule['extraCreditText']);
        if($readModule['extraCreditStatus'] == "1"){
          if ($readModule['extraCredit'] > 0) {
            echo "<div class=\"section-header\"><div class=\"section-header-info\"><p class=\"section-pretitle\">".languageVariables("creditTrans", "words", $languageType)."</p><h2 class=\"section-title\">".languageVariables("infois", "words", $languageType)."</h2></div></div><div class=\"extra-credit-card\">".$extraCreditText."</div>";
          }
        }
        ?>
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></h2>
          </div>
        </div>
        <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
        <?php if ($searchCreditHistory->rowCount() > 0) { ?>
        <div class="widget-box">
          <div class="widget-box-content">
            <div class="user-status-list">
              <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
              <div class="user-status">
                <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>">
                	<img src="https://minotar.net/bust/<?php echo $readCreditHistory["username"]; ?>/100.png" width="40" height="40">
                </a>
                <?php if ($readCreditHistory["method"] == 0) { $paymentMethodText = languageVariables("paymentMobile", "words", $languageType); } else if ($readCreditHistory["method"] == 1) { $paymentMethodText = languageVariables("paymentCredit", "words", $languageType); } ?>
                <p class="user-status-title"><?php echo str_replace(array("&username", "&method", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readCreditHistory["username"]."\">".$readCreditHistory["username"]."</a>", $paymentMethodText, $readCreditHistory["amount"]), languageVariables("historyText", "credit", $languageType)); ?></p>
                <p class="user-status-timestamp"><?php echo checkTime($readCreditHistory["date"]); ?></p>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "warning", "0", "/"); } ?>
      </div>
    </div>
</div>
<?php } else if (get("action") == "transfer") { ?>
<?php if ($readModule["creditTransferStatus"] == "0") { go(urlConverter("credit_upload", $languageType)); } ?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-9-3 mobile-prefer-content">
      <!-- CREDIT TRANSFER -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("send", "words", $languageType); ?></h2>
          </div>
        </div>
        <?php if ($readModule["creditTransferStatus"] == "1") { ?>
        <div class="widget-box">
          <div class="widget-box-content">
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
            <form action="" method="POST">
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small <?php if (isset($_POST["username"])) { echo "active"; } ?>">
                    <div class="social-link no-hover patreon">
                      <svg class="icon-patreon">
                        <use xlink:href="#svg-members"></use>
                      </svg>
                    </div>
                    <label for="credit-username"><?php echo languageVariables("username", "words", $languageType); ?></label>
                    <input type="text" id="credit-username" name="username" value="<?php if (isset($_POST["username"])) { echo post("username"); } ?>">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small">
                    <div class="social-link no-hover youtube">
                      <svg class="icon-youtube">
                        <use xlink:href="#svg-revenue"></use>
                      </svg>
                    </div>
                    <label for="transfer-credit"><?php echo languageVariables("amount", "words", $languageType); ?></label>
                    <input type="text" id="transfer-credit" name="credit">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("creditTransferToken"); ?>
                  <button class="button w-25 primary" style="float:right;" type="submit" name="creditTransfer"><?php echo languageVariables("send", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertSendStatusFalse", "coupon", $languageType), "danger", "0", "/"); } ?>
      </div>
      <!-- /CREDIT TRANSFER -->
      
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></h2>
          </div>
        </div>
        <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
        <?php if ($searchCreditHistory->rowCount() > 0) { ?>
        <div class="widget-box">
          <div class="widget-box-content">
            <div class="user-status-list">
              <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
              <div class="user-status">
                <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>">
                	<img src="https://minotar.net/bust/<?php echo $readCreditHistory["username"]; ?>/100.png" width="40" height="40">
                </a>
                <?php if ($readCreditHistory["method"] == 0) { $paymentMethodText = languageVariables("paymentMobile", "words", $languageType); } else if ($readCreditHistory["method"] == 1) { $paymentMethodText = languageVariables("paymentCredit", "words", $languageType); } ?>
                <p class="user-status-title"><?php echo str_replace(array("&username", "&method", "&amount"), array("<a class=\"bold\" href=\"".urlConverter("player", $languageType)."/".$readCreditHistory["username"]."\">".$readCreditHistory["username"]."</a>", $paymentMethodText, $readCreditHistory["amount"]), languageVariables("historyText", "credit", $languageType)); ?></p>
                <p class="user-status-timestamp"><?php echo checkTime($readCreditHistory["date"]); ?></p>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "warning", "0", "/"); } ?>
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
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
  <div class="grid grid-12 mobile-prefer-content">
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("creditTrans", "words", $languageType); ?></p>
          <h2 class="section-title">PayTR</h2>
        </div>
      </div>
      <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
      <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $readPaymentTransactionVariables["paytrToken"]; ?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
      <script>iFrameResize({},'#paytriframe');</script>
    </div>
  </div>
</div>
  <?php } else { go(urlConverter("credit_upload", $languageType)); } ?>
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
      
      $paidAmount = $readPaymentTransactionVariables["amount"];
      if ($readModule["KDVStatus"] == "1") {
        if ($readModule["KDVValue"] > 0) {
          $extraCredit = ($readModule["KDVValue"]/100)+1;
          $paidAmount = $paidAmount*$extraCredit;
        }
      }

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
      die($shopier->run($readPaymentTransaction["paymentID"], $paidAmount, ("/odeme/callback/shopier")));
    } else {
      go(urlConverter("credit_upload", $languageType));
    }
  ?>
<?php } ?>