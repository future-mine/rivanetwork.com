<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/main/includes/php/settings.php");
  
  $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
  $readPayments = $searchPayments->fetch();
  $readPaymentVariables = json_decode($readPayments["variables"], true);
  
  if ($_POST) {
    if (is_numeric(post("amount")) && post("amount") > 0 && isset($_POST["method"]) && post("userID") !== "") {
      $searchAccount = $db->prepare("SELECT * FROM accounts WHERE id = ?");
      $searchAccount->execute(array(post("userID")));
      if ($searchAccount->rowCount() > 0) {
        $readAccount = $searchAccount->fetch();
        $searchAccountPaymentInformation = $db->prepare("SELECT * FROM accountPaymentInformation WHERE accountID = ?");
        $searchAccountPaymentInformation->execute(array($readAccount["id"]));
        $readAccountPaymentInformation = $searchAccountPaymentInformation->fetch();
        $paymentMethod = ((post("method") == "0") ? "mobile" : "creditCard");
        $paymentAPIType = post("api");
        $paidAmount = post("amount");
        if ($readModule["KDVStatus"] == "1") {
          if ($readModule["KDVValue"] > 0) {
            $vatValue = $readModule["KDVValue"]/100;
            $paidAmount = $paidAmount+($paidAmount*$vatValue);
          }
        }
        $paymentID = strtoupper(md5(uniqid(mt_rand(), true)))."MLB";
        require_once(__DR__."/main/includes/packages/class/functions/curl.php");
        if ($paymentAPIType == "paypal") {
          // PayPal Payment Transactions
          
          include __DR__."/main/includes/packages/class/paypal/init.php";
          
          $transactionID = createSalt(12);
          $paypalAPIContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($readPaymentVariables["paypalClientID"], $readPaymentVariables["paypalClientSecret"])
          );
          $paypalAPIContext->setConfig([
            "mode" => ($readPaymentVariables["paypalMode"] == "0") ? "sandbox" : "live"
          ]);
          $paypalPayer = new \PayPal\Api\Payer();
          $paypalPayer->setPaymentMethod('paypal');
          $paypalItems = array(
            array(
              "name" => $rSettings["serverName"]." - ".post("amount")." ".languageVariables("credi", "words", $languageType), 
              "quantity" => 1, 
              "price" => $paidAmount, 
              "sku" => $paymentID, 
              "currency" => $rSettings["currency"]
            )
          );
          $paypalAmount = new \PayPal\Api\Amount();
          $paypalAmount->setCurrency($rSettings["currency"])->setTotal($paidAmount);
          $paypalItemList = new \PayPal\Api\ItemList();
          $paypalItemList->setItems($paypalItems);
          $paypalTransaction = new \PayPal\Api\Transaction();
          $paypalTransaction->setAmount($paypalAmount)->setDescription($rSettings["serverName"]." ".languageVariables("creditUploadText", "words", $languageType))->setInvoiceNumber($transactionID)->setItemList($paypalItemList);
          $paypalRedirectURL = new \PayPal\Api\RedirectUrls();
          $paypalRedirectURL->setReturnUrl($siteURL."/main/includes/packages/payments/callback.php")->setCancelUrl($siteURL.urlConverter("credit_upload_fail", $languageType));
          $paypalPayment = new \PayPal\Api\Payment();
          $paypalPayment->setIntent('sale')->setPayer($paypalPayer)->setTransactions([$paypalTransaction])->setRedirectUrls($paypalRedirectURL);
          try {
            $paypalPayment->create($paypalAPIContext);
            $transactionVariables = json_encode([
              "userID" => $readAccount["id"],
              "amount" => post("amount"),
              "method" => post("method"),
              "vat" => $readModule["KDVValue"],
              "transID" => $transactionID
            ]);
            $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
            $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $paypalPayment->getApprovalLink()]));
          } catch (Exception $e) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "paypalipn") {
          $curlURL = (($readPaymentVariables["paypalIPNType"] == "1") ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr");
          $postFields = array(
            "cmd" => "_xclick",
            "no_rate" => "1",
            "bn" => "PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest",
            "first_name" => $readAccountPaymentInformation["firstName"],
            "last_name" => $readAccountPaymentInformation["surName"],
            "payer_email" => $readAccount["email"],
            "business" => $readPaymentVariables["paypalEmail"],
            "return" => $siteURL.urlConverter("credit_upload_success", $languageType),
            "cancel_return" => $siteURL.urlConverter("credit_upload_fali", $languageType),
            "notify_url" => $siteURL."/callback/paypalipn",
            "item_name" => $rSettings["serverName"]." - Purchase Credit",
            "amount" => $paidAmount,
            "currency_code" => $rSettings["currency"],
            "custom" => $paymentID,
          );
          $redirectURL = $curlURL."?".http_build_query($postFields);
          $transactionVariables = json_encode([
            "userID" => $readAccount["id"],
            "amount" => post("amount"),
            "method" => post("method"),
            "vat" => $readModule["KDVValue"],
            "transID" => createSalt(12)
          ]);
          $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
          $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
          die(json_encode(["status" => true, "type" => "alert", "redirect" => $redirectURL]));
        } else if ($paymentAPIType == "stripe") {
          require_once(__DR__."/main/includes/packages/class/stripe/init.php");

          $stripeAPIKEY = \Stripe\Stripe::setApiKey($readPaymentVariables["stripeSecretKey"]);
          $stripeAmount = round($paidAmount*100, 2);
          $transactionID = createSalt(12);
          $stripeSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'product_data' => [
                        'name' => $rSettings["serverName"]." Credit Upload",
                        'description' => $rSettings["serverName"]." Credit Upload",
                        'metadata' => [
                            'pro_id' => $paymentID
                        ]
                    ],
                    'unit_amount' => $stripeAmount,
                    'currency' => $rSettings["currency"],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $siteURL."/main/includes/packages/payments/callback.php?paymentAPI=stripeGET&session_id={CHECKOUT_SESSION_ID}&getID=".$paymentID,
            'cancel_url' => $siteURL.urlConverter("credit_upload_fail", $languageType),
          ]);
          $transactionVariables = json_encode([
            "userID" => $readAccount["id"],
            "amount" => post("amount"),
            "method" => post("method"),
            "vat" => $readModule["KDVValue"],
            "transID" => createSalt(12)
          ]);
          $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
          $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
          die(json_encode(["status" => true, "type" => "alert", "redirect" => $stripeSession->url]));
        } else if ($paymentAPIType == "paymax") {
          require_once(__DR__."/main/includes/packages/class/paymax/class.php");
              
          $paymaxAPI = new PaymaxAPI($readPaymentVariables["paymaxUserID"], $readPaymentVariables["paymaxAPIKey"], $readPaymentVariables["paymaxMerchantCode"], $readPaymentVariables["paymaxHash"]);
          $postFields = array(
            "productName" => $rSettings["serverName"]." Credit Upload",
            "productData" => array(
              array(
                "productName"=> $rSettings["serverName"]." Credit Upload",
                "productPrice"=> $paidAmount,
                "productType"=> "DIJITAL_URUN",
              ),
            ),
            "productType" => "DIJITAL_URUN",
            "productsTotalPrice" => $paidAmount,
            "orderPrice" => $paidAmount,
            "currency" => "TRY",
            "orderId" => "PM-".rand(100000, 999999),
            "locale" => "tr",
            "conversationId" => $paymentID,
            "buyerName" => $readAccountPaymentInformation["firstName"],
            "buyerSurName" => $readAccountPaymentInformation["surName"],
            "buyerGsmNo" => $readAccountPaymentInformation["phoneNumber"],
            "buyerIp" => GetIP(),
            "buyerMail" => $readAccount["email"],
            "buyerAdress" => "",
            "buyerCountry" => "",
            "buyerCity" => "",
            "buyerDistrict" => "",
            "callbackOkUrl" => $siteURL.urlConverter("credit_upload_success", $languageType),
            "callbackFailUrl" => $siteURL.urlConverter("credit_upload_fail", $languageType)
          );
          $response = $paymaxAPI->create_payment_link($postFields);
  
          if ($response["status"] == "success" && isset($response["payment_page_url"])) {
            $transactionVariables = json_encode([
              "userID" => $readAccount["id"],
              "amount" => post("amount"),
              "method" => post("method"),
              "vat" => $readModule["KDVValue"],
              "transID" => createSalt(12)
            ]);
            $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
            $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $response["payment_page_url"]]));
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "paytr") {
          // PayTR Payment Transactions
          $paymentAmount = $paidAmount * 100;
          $noInstallment = 0;
          $maxInstallment = 0;
          $timeoutLimit = "30";
          $currency = "TL";
          $debugStatus = 0;
          $testModeStatus = 0;
          $paymentProducts = base64_encode(json_encode(array(array(substr($rSettings["serverName"]." Credit Upload", 0, 50),$paidAmount,1))));
          $paytrHash 	= $readPaymentVariables["paytrID"] . $readAccount["ip"] . $paymentID . $readAccount["email"] . $paymentAmount . $paymentProducts . $noInstallment . $maxInstallment . $currency . $testModeStatus;
          $paytrToken = base64_encode(hash_hmac('SHA256', $paytrHash.$readPaymentVariables["paytrAPISecretKey"], $readPaymentVariables["paytrAPIKey"], true));
          $curlURL = "https://www.paytr.com/odeme/api/get-token";
          $postFields = array(
              "merchant_id"  => $readPaymentVariables["paytrID"],
              "merchant_oid"  => $paymentID,
              "payment_amount"  => $paymentAmount,
              "paytr_token"  => $paytrToken,
              "user_basket"  => $paymentProducts,
              "no_installment"  => $noInstallment,
              "max_installment"  => $maxInstallment,
              "email"  => $readAccount["email"],
              "user_name"  => $readAccountPaymentInformation["firstName"]." ".$readAccountPaymentInformation["surName"],
              "user_address"  => "Konya Meram Kozağaç Mh. Aralık Sk. No: 4",
              "user_phone"  => $readAccountPaymentInformation["phoneNumber"],
              "user_ip"  => $readAccount["ip"],
              "merchant_ok_url"  => $siteURL.urlConverter("credit_upload_success", $languageType),
              "merchant_fail_url"  => $siteURL.urlConverter("credit_upload_fail", $languageType),
              "timeout_limit"  => $timeoutLimit,
              "currency"  => $currency,
              "debug_on"  => $debugStatus,
              "test_mode"  => $testModeStatus
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = json_decode($generateCurl($postFields), true);
            if ($response["status"] == 'success') {
              $transactionVariables = json_encode([
                "userID" => $readAccount["id"],
                "amount" => post("amount"),
                "method" => post("method"),
                "vat" => $readModule["KDVValue"],
                "transID" => createSalt(12),
                "paytrToken" => $response["token"]
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => $siteURL.urlConverter("payment_paytr", $languageType)."/".$paymentID]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "paywant") {
          // Paywant Payment Transactions 
          $paywantMethod = ((post("method") == "0") ? "1" : "2");
          $paymentHash = base64_encode(hash_hmac('sha256', $paymentID.'|'.$readAccount["email"].'|'.$readAccount["id"].$readPaymentVariables['paywantAPIKey'], $readPaymentVariables['paywantAPISecretKey'], true));
          $curlURL = "http://api.paywant.com/gateway.php";
          $postFields = array(
              "proApi"        => true,
              "apiKey"        => $readPaymentVariables["paywantAPIKey"],
              "hash"          => $paymentHash,
              "userID"        => $readAccount["id"],
              "returnData"    => $paymentID,
              "userEmail"     => $readAccount["email"],
              "userIPAddress" => $readAccount["ip"],
              "productData"   => array(
                "name"            => post("amount")." Kredi Yükleme",
                "amount"          => $paidAmount*100,
                "extraData"       => $paidAmount,
                "paymentChannel"  => $paywantMethod,
                "commissionType"  => $readPaymentVariables["paywantCommissionType"]
              )
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = json_decode($generateCurl($postFields), true);
            if ($response["Status"] == "100") {
              $transactionVariables = json_encode([
                "userID" => $readAccount["id"],
                "amount" => post("amount"),
                "method" => post("method"),
                "vat" => $readModule["KDVValue"],
                "transID" => createSalt(12)
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => $response["Message"]]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "shipy") {
          // Shipy Payment Transactions 
          $curlURL = ((post("method") == "0") ? "https://api.shipy.dev/pay/mobile" : "https://api.shipy.dev/pay/credit_card");
          $postFields = array(
              "usrIp"       => $readAccount["ip"],
              "usrEmail"    => $readAccount["email"],
              "usrName"     => $readAccountPaymentInformation["firstName"]." ".$readAccountPaymentInformation["surName"],
              "usrAddress"  => "Konya Meram Kozağaç Mh. Aralık Sk. No: ".rand(100000,999999),
              "usrPhone"    => $readAccountPaymentInformation["phoneNumber"],
              "apiKey"      => $readPaymentVariables["shipyAPIKey"],
              "amount"      => $paidAmount,
              "returnID"    => $paymentID,
              "currency"    => "TRY",
              "pageLang"    => "TR",
              "mailLang"    => "TR",
              "installment" => 0
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            if (post("method") == "0") {
              $response = $generateCurl($postFields);
              $transactionVariables = json_encode([
                "userID" => $readAccount["id"],
                "amount" => post("amount"),
                "method" => post("method"),
                "vat" => $readModule["KDVValue"],
                "transID" => createSalt(12)
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => str_replace(array('<head/>', '<script type="text/javascript">window.onload=function(){window.location.href="', '";}</script>'), array("", "", ""), $response)]));
            } else {
              $response = json_decode($generateCurl($postFields), true);
              if ($response["status"] == "success") {
                $transactionVariables = json_encode([
                  "userID" => $readAccount["id"],
                  "amount" => post("amount"),
                  "method" => post("method"),
                  "transID" => createSalt(12)
                ]);
                $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
                $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
                die(json_encode(["status" => true, "type" => "alert", "redirect" => $response["link"]]));
              } else {
                die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
              }
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "paylith") {
          // Paylith Payment Transactions
          $curlURL = "https://api.paylith.com/v1/token";
          $hashStr = [
            "apiKey" => $readPaymentVariables["paylithAPIKey"],
            "conversationId" => $paymentID,
            "userId" => $readAccount["id"],
            "userEmail" => $readAccount["email"],
            "userIpAddress" => $readAccount["ip"]
          ];
          ksort($hashStr);
          $hash = hash_hmac('sha256', implode('|', $hashStr) . $readPaymentVariables["paylithAPISecretKey"], $readPaymentVariables["paylithAPIKey"]);
          $hashToken = hash_hmac('md5', $hash, $readPaymentVariables["paylithAPIKey"]);
          $postFields = array(
              "apiKey" => $readPaymentVariables["paylithAPIKey"],
              "productApi" => true,
              "productData" => array(
                "name" => post("amount")."TL Kredi Yükleme",
                "amount" => $paidAmount*100
              ),
              "token" => $hashToken,
              "conversationId" => $paymentID,
              "userId" => $readAccount["id"],
              "userEmail" => $readAccount["email"],
              "userIpAddress" => $readAccount["ip"],
              "redirectUrl" => $siteURL.urlConverter("credit_upload_success", $languageType)
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = json_decode($generateCurl($postFields), true);
            if ($response["status"] == "success") {
              $transactionVariables = json_encode([
                "userID" => $readAccount["id"],
                "amount" => post("amount"),
                "method" => post("method"),
                "vat" => $readModule["KDVValue"],
                "transID" => createSalt(12)
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => $response["paymentLink"]]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "shopier") {
          // Shopier Payment Transactions 
          $transactionVariables = json_encode([
            "userID" => $readAccount["id"],
            "amount" => post("amount"),
            "method" => post("method"),
            "vat" => $readModule["KDVValue"],
            "transID" => createSalt(12)
          ]);
          $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
          $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
          die(json_encode(["status" => true, "type" => "alert", "redirect" => $siteURL.urlConverter("payment_shopier", $languageType)."/".$paymentID,]));
        } else if ($paymentAPIType == "batihost") {
          // Batihost Payment Transactions 
          $curlURL = 'https://batigame.com/vipgateway/viprec.php';
          $postFields = array(
            "oyuncu"          => $paymentID,
            "amount"          => $paidAmount,
            "vipname"         => post("amount")." TL Kredi",
            "batihostid"      => $readPaymentVariables["batihostID"],
            "raporemail"      => $readPaymentVariables["batihostEmail"],
            "odemeolduurl"    => $siteURL.urlConverter("credit_upload_success", $languageType),
            "odemeolmadiurl"  => $siteURL.urlConverter("credit_upload_fail", $languageType),
            "posturl"         => $siteURL.urlConverter("payment_callback", $languageType)."/batihost"
          );
          if (post("method") == "1") {
            $postFields = array_merge($postFields, array(
              'odemeturu' => 'kredikarti'
            ));
          }
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = $generateCurl($postFields);
            $transactionVariables = json_encode([
              "userID" => $readAccount["id"],
              "amount" => post("amount"),
              "method" => post("method"),
              "vat" => $readModule["KDVValue"],
              "transID" => createSalt(12)
            ]);
            $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
            $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
            die(json_encode(["status" => true, "type" => "print_r", "redirect" => $response]));
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "keyubu") {
          // Keyubu Payment Transactions
          $curlURL = "https://musteri.keyubu.com/gateway/odeme.php";
          $postFields = array(
            "odemeID"   => $readPaymentVariables["keyubuID"],
            "user_ip"   => $readAccount["ip"],
            "amount"    => $paidAmount,
            "return_id" => $paymentID,
            "method"    => ((post("method") == "0") ? "2" : "1"),
            "callback"  => urlConverter("payment_callback", $languageType)."/keyubu"
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = json_decode($generateCurl($postFields), true);
            if ($response["status"] == "success") {
              $transactionVariables = json_encode([
                "userID" => $readAccount["id"],
                "amount" => post("amount"),
                "method" => post("method"),
                "vat" => $readModule["KDVValue"],
                "transID" => createSalt(12)
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => "https://musteri.keyubu.com/gateway/odeme.php?token=".$response["token"]]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "rabisu") {
          // Rabisu Payment Transactions
          $curlURL = 'https://odeme.rabisu.com/odeme.php';
          $postFields = array(
              "oyuncu_adi"      => $paymentID,
              "fiyat"           => $paidAmount,
              "urun_adi"        => post("amount")." TL Kredi",
              "bayi_id"         => $readPaymentVariables["rabisuID"],
              "yontem"          => ((post("method") == "0") ? "mobil" : "kart"),
              "basarili_url"    => $siteURL.urlConverter("credit_upload_success", $languageType),
              "basarisiz_url"   => $siteURL.urlConverter("credit_upload_fail", $languageType),
              "post_url"        => $siteURL.urlConverter("payment_callback", $languageType)."/rabisu"
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = $generateCurl($postFields);
            $transactionVariables = json_encode([
              "userID" => $readAccount["id"],
              "amount" => post("amount"),
              "method" => post("method"),
              "vat" => $readModule["KDVValue"],
              "transID" => createSalt(12)
            ]);
            $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
            $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
            die(json_encode(["status" => true, "type" => "print_r", "redirect" => $response]));
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "anksoft") {
          // AnkSOFT Payment Transactions
          $curlURL = "https://www.anksoft.net/odeme/payment.php";
          $postFields = array(
            "merchantId" => $readPaymentVariables["anksoftMerchantKey"],
            "merchantPassword" => $readPaymentVariables["anksoftMerchantSecretKey"],
            'amount' => $paidAmount,
            'orderId' => $paymentID,
            'full_name' => $readAccountPaymentInformation["firstName"]." ".$readAccountPaymentInformation["surName"],
            "email" => $readAccount["email"],
            "phone" => $readAccountPaymentInformation["phoneNumber"],
            'user_ip' => $readAccount["ip"],
            'success_url' => $siteURL.urlConverter("credit_upload_success", $languageType),
            'fail_url' => $siteURL.urlConverter("credit_upload_fail", $languageType),
            'callback_url' => $siteURL.urlConverter("payment_callback", $languageType)."/anksoft",
            'method' => "credit",
            'ExtraInfo' => $paymentID
          );
          $generateCurl = new \MineXON\Http\CurlPost($curlURL);
          try {
            $response = json_decode($generateCurl($postFields));
            if ($response->status == true) {
              $transactionVariables = json_encode([
                  "userID" => $readAccount["id"],
                  "amount" => post("amount"),
                  "method" => post("method"),
                  "vat" => $readModule["KDVValue"],
                  "transID" => createSalt(12)
              ]);
              $insertPaymentTransactions = $db->prepare("INSERT INTO paymentTransactions (`paymentAPIType`, `paymentID`, `variables`, `status`, `date`) VALUES (?, ?, ?, ?, ?)");
              $insertPaymentTransactions->execute(array($paymentAPIType, $paymentID, $transactionVariables, 0, date("d.m.Y H:i:s")));
              die(json_encode(["status" => true, "type" => "alert", "redirect" => $response->link]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType).$response->message]));
            }
          } catch (\RuntimeException $ex) {
            die(json_encode(["status" => false, "type" => "alert", "reason" => sprintf('HTTP: %s Code: %d', $ex->getMessage(), $ex->getCode())]));
          }
        } else if ($paymentAPIType == "ininal") {
          // Ininal Payment Transactions 
          if ($readPaymentVariables["ininal"] !== "0") {
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $readPaymentVariables["ininal"]]));
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("paymentDisableError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "papara") {
          // Papara Payment Transactions
          if ($readPaymentVariables["papara"] !== "0") {
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $readPaymentVariables["papara"]]));
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("paymentDisableError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "tosla") {
          // Tosla Payment Transactions
          if ($readPaymentVariables["tosla"] !== "0") {
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $readPaymentVariables["tosla"]]));
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("paymentDisableError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "transfer") {
          // Tosla Payment Transactions
          if ($readPaymentVariables["transfer"] !== "0") {
            die(json_encode(["status" => true, "type" => "alert", "redirect" => $readPaymentVariables["transfer"]]));
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("paymentDisableError", "payments", $languageType)]));
          }
        } else if ($paymentAPIType == "disabled") {
          // Disabled Payment Transactions 
          die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("paymentDisableError", "payments", $languageType)]));
        } else {
          die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
        }
      } else {
        die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("errorLogin", "payments", $languageType)]));
      }
    } else {
      die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("errorNone", "payments", $languageType)]));
    }
  } else {
    die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
  }
?>