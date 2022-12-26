<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/main/includes/php/settings.php");
  
  $languageType = $rSettings["defaultLanguage"];

  $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
  $readPayments = $searchPayments->fetch();
  $readPaymentVariables = json_decode($readPayments["variables"], true);
  
  function PaymentTransactionComplete ($paymentID)
  {
      global $db, $readPayments, $readPaymentVariables, $readModule, $readWebhooks;
      
      $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE id = ?");
      $searchPaymentTransaction->execute(array($paymentID));
      
      if ($searchPaymentTransaction->rowCount() > 0) {
        $readPaymentTransaction = $searchPaymentTransaction->fetch();
        $transactionVariables = json_decode($readPaymentTransaction["variables"], true);
        $searchTransaction = $db->prepare("SELECT * FROM creditHistory WHERE transID = ?");
        $searchTransaction->execute(array($transactionVariables["transID"]));
        if ($searchTransaction->rowCount() == 0) {
          $searchAccount = $db->prepare("SELECT * FROM accounts WHERE id = ?");
          $searchAccount->execute(array($transactionVariables["userID"]));
          if ($searchAccount->rowCount() > 0) {
            $readAccount = $searchAccount->fetch();

            $addCredit = 0;
            if ($readPayments["creditType"] == "0") {
              $creditMultiplier = (($readModule["creditMultiplier"] > 0) ? $readModule["creditMultiplier"] : 1);;
              $addCredit = $transactionVariables["amount"]*$creditMultiplier;
              if ($readModule["extraCreditStatus"] == "1") {
                if ($readModule["extraCredit"] > 0) {
                  $extraCredit = ($readModule["extraCredit"]/100)+1;
                  $addCredit = $addCredit*$extraCredit;
                }
              }
            } else {
              $searchCreditPackets = json_decode($readPayments["creditPackets"], true);
              foreach ($searchCreditPackets as $readCreditPackets) {
                if ($readCreditPackets["price"] == $transactionVariables["amount"]) {
                  $addCredit = $readCreditPackets["amount"];
                  break;
                }
              }
            }
            
            $insertCreditHistory = $db->prepare("INSERT INTO creditHistory (`username`, `usernameTo`, `method`, `type`, `transID`, `amount`, `date`, `timeStamp`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insertCreditHistory->execute(array($readAccount["username"], $readAccount["username"], $transactionVariables["method"], 0, $transactionVariables["transID"], $transactionVariables["amount"], date("d.m.Y H:i:s"), time()));
            
            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit + ? WHERE id = ?");
            $updateAccount->execute(array($addCredit, $readAccount["id"]));
            
            $updatePaymentTransactions = $db->prepare("UPDATE paymentTransactions SET status = ? WHERE id = ?");
            $updatePaymentTransactions->execute(array(1, $readPaymentTransaction["id"]));
            
            if ($readAccount["notificationStatus"] == "1") {
              $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
              $insertNotifications->execute(array($readAccount["username"], $readAccount["id"], languageVariables("myCreditUpload", "notifications", $languageType), '{"iconType":"item", "amount": "'.$addCredit.'"}', "creditUpload", date("d.m.Y H:i:s"), "unread"));
            }
            
            $insertSystemNotifications = $db->prepare("INSERT INTO systemNotifications (`userID`, `text`, `variables`, `type`, `date`) VALUES (?, ?, ?, ?, ?)");
            $insertSystemNotifications->execute(array($readAccount["id"], languageVariables("systemCreditUpload", "notifications", $languageType), '{"credit": "'.$transactionVariables["amount"].'"}', 1, date("d.m.Y H:i:s")));
            
            $webhookDescription = str_replace(array("[username]", "[credit]"), array($readAccount["username"], $transactionVariables["amount"]), $readWebhooks["webhookCreditDescription"]);
            $hookObject = json_encode([
              "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookCreditName"]),
              "avatar_url" => avatarAPI($readAccount["username"], 100),
              "tts" => false,
              "embeds" => [
                 [
                      "title" => $readWebhooks["webhookCreditTitle"],
                      "type" => "rich",
                      "image" => ($readWebhooks["webhookCreditImage"] !== "0") ? [
                        "url" => $readWebhooks["webhookCreditImage"]
                      ] : [],
                      "description" => $webhookDescription,
                      "color" => hexdec(rand_color()),
                      "footer" => ($readWebhooks["webhookCreditSignature"] == "1") ? [
                          "text" => "Powered by MineXON",
                          "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                      ] : []
                  ]
              ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
            $sendWebhook = (($readWebhooks["webhookCreditStatus"] == "1") ? webhooks($readWebhooks["webhookCreditAPI"], $hookObject) : "OK");
            return "OK";
          } else {
            return false;
          }
        } else {
          return "OK";
        }
      } else {
        return false;
      }
  }
  
  if (!isset($_GET["paymentAPI"]) && $readPaymentVariables["paypalClientID"] !== "" && $readPaymentVariables["paypalClientSecret"] !== "" && isset($_GET["paymentId"]) && isset($_GET["PayerID"])) {
    require_once(__DR__."/main/includes/packages/class/functions/curl.php");
    $curlURL = $siteURL."/odeme/callback/paypal";
    $postFields = array(
      "paymentId" => get("paymentId"),
      "PayerID" => get("PayerID")
    );
    $generateCurl = new \MineXON\Http\CurlPost($curlURL);
    try {
      $response = $generateCurl($postFields);
      if ($response == "OK") {
        go(urlConverter("credit_upload_success", $languageType));
      } else {
        go(urlConverter("credit_upload_fail", $languageType));
      }
    } catch (\RuntimeException $ex) {
      die(languageVariables("systemError", "payments", $languageType));
    }
  }
  
  if ($_GET["paymentAPI"] == "stripeGET" && $readPaymentVariables["stripePublishKey"] !== "" && $readPaymentVariables["stripeSecretKey"] !== "" && $_GET["session_id"] !== "" && $_GET["getID"] !== "") {
    require_once(__DR__."/main/includes/packages/class/functions/curl.php");
    $curlURL = $siteURL."/odeme/callback/stripe";
    $postFields = array(
      "getID" => get("getID"),
      "session_id" => get("session_id")
    );
    $generateCurl = new \MineXON\Http\CurlPost($curlURL);
    try {
      $response = $generateCurl($postFields);
      if ($response == "OK") {
        go(urlConverter("credit_upload_success", $languageType));
      } else {
        go(urlConverter("credit_upload_fail", $languageType));
      }
    } catch (\RuntimeException $ex) {
      die(languageVariables("systemError", "payments", $languageType));
    }
  }

  if ($_POST && isset($_GET["paymentAPI"])) {
    $paymentType = get("paymentAPI");
    $paymentToolStatus = false;
    $searchPaymentTools = json_decode($readPayments["payments"], true);
    foreach ($searchPaymentTools as $readPaymentTool) {
      if ($readPaymentTool["api"] == $paymentType) {
        $paymentToolStatus = true;
      }
    }
    if ($paymentToolStatus == true) {
      if ($paymentType == "paypal") {
        if ($readPaymentVariables["paypalClientID"] !== "" && $readPaymentVariables["paypalClientSecret"] !== "") {
          if ($_POST["paymentId"] !== "" && $_POST["PayerID"] !== "") {
            require_once(__DR__."/main/includes/packages/class/paypal/init.php");

            $paypalPaymentID = post("paymentId");
            $paypalAPIContext = new \PayPal\Rest\ApiContext(
              new \PayPal\Auth\OAuthTokenCredential($readPaymentVariables["paypalClientID"], $readPaymentVariables["paypalClientSecret"])
            );
            $paypalAPIContext->setConfig([
              "mode" => ($readPaymentVariables["paypalMode"] == "0") ? "sandbox" : "live"
            ]);
            $paypalPaymentCall = new \PayPal\Api\Payment();
            $paypalPayment = $paypalPaymentCall->get($paypalPaymentID, $paypalAPIContext);
            $paypalExecution = new \PayPal\Api\PaymentExecution();
            $paypalExecution->setPayerId(post("PayerID"));
            try {
              $paypalPayment->execute($paypalExecution, $paypalAPIContext);
              try {
                $paypalPayment = $paypalPaymentCall->get($paypalPaymentID, $paypalAPIContext);
                if ($paypalPayment->getState() == "approved") {
                  $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
                  $searchPaymentTransaction->execute(array($paypalPayment->transactions[0]->item_list->items[0]->sku, $paymentType, 0));
                  if ($searchPaymentTransaction->rowCount() > 0) {
                    $readPaymentTransaction = $searchPaymentTransaction->fetch();
                    $transactionVariablesPayPal = json_decode($readPaymentTransaction["variables"], true);
                    $transactionVariablesPayPal["txn_id"] = $paypalPayment->getId();
                    $updatePaymentTransactionsPayPal = $db->prepare("UPDATE paymentTransactions SET variables = ? WHERE id = ?");
                    $updatePaymentTransactionsPayPal->execute(array(json_encode($transactionVariablesPayPal), $readPaymentTransaction["id"]));
                    $completePaymentID = $readPaymentTransaction["id"];
                  } else {
                    exit("OK");
                  }
                } else {
                  exit(languageVariables("paymentCancelError", "payments", $languageType));
                }
              } catch (Exception $e) {
                exit(languageVariables("paymentFailError", "payments", $languageType));
              }
            } catch (Exception $e) {
              exit(languageVariables("paymentFailError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "paypalipn") {
        if ($readPaymentVariables["paypalEmail"] !== "") {
          if ($_POST["custom"] !== "" && $_POST["txn_id"] !== "") {
            $paypalData = $_POST;
            $curlURL = (($readPaymentVariables["paypalIPNType"] == "1") ? "https://ipnpb.paypal.com/cgi-bin/webscr" : "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr");
            $request = 'cmd=_notify-validate';
            foreach ($paypalData as $key => $value) {
              $value = urlencode(stripslashes($value));
              $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value);
              $request .= "&$key=$value";
            }
            $paypalCurl = curl_init($curlURL);
            curl_setopt($paypalCurl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($paypalCurl, CURLOPT_POST, 1);
            curl_setopt($paypalCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($paypalCurl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($paypalCurl, CURLOPT_SSLVERSION, 6);
            curl_setopt($paypalCurl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($paypalCurl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($paypalCurl, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($paypalCurl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($paypalCurl, CURLOPT_HTTPHEADER, array(
              'User-Agent: PHP-IPN-Verification-Script',
              'Connection: Close',
            ));
            $response = curl_exec($paypalCurl);
            if (!$response) {
              $errno = curl_errno($paypalCurl);
              $errstr = curl_error($paypalCurl);
              curl_close($paypalCurl);
              throw new Exception("cURL error: [$errno] $errstr");
            }
            $curlInfo = curl_getinfo($paypalCurl);
            $httpCode = $curlInfo["http_code"];
            if ($httpCode != 200) {
              exit("PayPal IPN Error: ".$httpCode);
            }
            curl_close($ch);
            $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
            $searchPaymentTransaction->execute(array(post("custom"), $paymentType, 0));
            if ($searchPaymentTransaction->rowCount() > 0) {
              $readPaymentTransaction = $searchPaymentTransaction->fetch();
              $transactionVariablesPayPal = json_decode($readPaymentTransaction["variables"], true);
              $transactionVariablesPayPal["txn_id"] = post("txn_id");
              $updatePaymentTransactionsPayPal = $db->prepare("UPDATE paymentTransactions SET variables = ? WHERE id = ?");
              $updatePaymentTransactionsPayPal->execute(array(json_encode($transactionVariablesPayPal), $readPaymentTransaction["id"]));
              $completePaymentID = $readPaymentTransaction["id"];
            } else {
              exit("OK");
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "stripe") {
        if ($readPaymentVariables["stripePublishKey"] !== "" && $readPaymentVariables["stripeSecretKey"] !== "") {
          if ($_POST["getID"] !== "" && $_POST["session_id"] !== "") {
            require_once(__DR__."/main/includes/packages/class/stripe/init.php");

            $stripePaymentID = post("getID");
            $stripeAPIKEY = \Stripe\Stripe::setApiKey($readPaymentVariables["stripeSecretKey"]);
            $paymentSession = \Stripe\Checkout\Session::retrieve($_POST["session_id"]);
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentSession->payment_intent);
            $paymentCustomer = \Stripe\Customer::retrieve($paymentSession->customer);
            if ($paymentIntent->status == "succeeded") {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array($stripePaymentID, $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentCancelError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "paymax") {
        if ($readPaymentVariables["paymaxUserID"] !== "" && $readPaymentVariables["paymaxAPIKey"] !== "" && $readPaymentVariables["paymaxMerchantCode"] !== "" && $readPaymentVariables["paymaxHash"] !== "") {
          if (isset($_POST['status']) && isset($_POST['paymentStatus']) && isset($_POST['hash']) && isset($_POST['paymentCurrency']) && isset($_POST['paymentAmount']) && isset($_POST['paymentType']) && isset($_POST['orderId']) && isset($_POST['shopCode']) && isset($_POST['orderPrice']) && isset($_POST['productsTotalPrice']) && isset($_POST['productType']) && isset($_POST['callbackOkUrl']) && isset($_POST['callbackFailUrl'])) {
            $securityProtocolHash = post("orderId").post("paymentCurrency").post("orderPrice").post("productsTotalPrice").post("productType").$readPaymentVariables["paymaxMerchantCode"].$readPaymentVariables["paymaxHash"];
            $securityProtocolHash64 = base64_encode(pack('H*', sha1($securityProtocolHash)));
            if (post("hash") == $securityProtocolHash64) {
              if (post("paymentStatus") == "paymentOk") {
                $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
                $searchPaymentTransaction->execute(array(post("conversationId"), $paymentType, 0));
                if ($searchPaymentTransaction->rowCount() > 0) {
                  $readPaymentTransaction = $searchPaymentTransaction->fetch();
                  $completePaymentID = $readPaymentTransaction["id"];
                } else {
                  exit("OK");
                }
              } else {
                exit(languageVariables("paymentCancelError", "payments", $languageType));
              }
            } else {
              exit(languageVariables("paymentSecurityError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "paytr") {
        if ($readPaymentVariables["paytrID"] !== "" && $readPaymentVariables["paytrAPIKey"] !== "" && $readPaymentVariables["paytrAPISecretKey"] !== "") {
          if (isset($_POST["status"]) && isset($_POST["merchant_oid"]) && isset($_POST["total_amount"])) {
            $securityProtocolHash = base64_encode(hash_hmac('SHA256', post("merchant_oid").$readPaymentVariables["paytrAPISecretKey"].post("status").post("total_amount"), $readPaymentVariables["paytrAPIKey"], true));
            if (post("hash") == $securityProtocolHash) {
              if (post("status") == "success") {
                $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
                $searchPaymentTransaction->execute(array(post("merchant_oid"), $paymentType, 0));
                if ($searchPaymentTransaction->rowCount() > 0) {
                  $readPaymentTransaction = $searchPaymentTransaction->fetch();
                  $completePaymentID = $readPaymentTransaction["id"];
                } else {
                  exit("OK");
                }
              } else {
                exit(languageVariables("paymentCancelError", "payments", $languageType));
              }
            } else {
              exit(languageVariables("paymentSecurityError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "paywant") {
        if ($readPaymentVariables["paywantAPIKey"] !== "" && $readPaymentVariables["paywantAPISecretKey"] !== "") {
          $securityProtocolHash = base64_encode(hash_hmac('sha256', post("SiparisID").'|'.post("ExtraData").'|'.post("UserID").'|'.post("ReturnData").'|'.post("Status").'|'.post("OdemeKanali").'|'.post("OdemeTutari").'|'.post("NetKazanc").$readPaymentVariables["paywantAPIKey"], $readPaymentVariables["paywantAPISecretKey"], true));
          if (post("Hash") == $securityProtocolHash) {
            if (post("Status") == '100') {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array(post("ReturnData"), $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentCancelError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentSecurityError", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "shipy") {
        if ($readPaymentVariables["shipyAPIKey"] !== "") {
          if (GetIP() == "144.91.111.2") {
            $securityProtocolHashTR = post("paymentID").post("returnID").post("paymentType").post("paymentAmount").post("paymentCurrency").$readPaymentVariables["shipyAPIKey"];
            $securityProtocolHashBytes = mb_convert_encoding($securityProtocolHashTR, "ISO-8859-9");
            $securityProtocolHash = base64_encode(sha1($securityProtocolHashBytes, true));
            if (post("paymentHash") == $securityProtocolHash) {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array(post("returnID"), $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentSecurityError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentNotIPAdress", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "paylith") {
        if ($readPaymentVariables["paylithAPIKey"] !== "" && $readPaymentVariables["paylithAPISecretKey"] !== "") {
          $conversationId = post("conversationId");
          $orderId = post("orderId");
          $paymentAmount = post("paymentAmount");
          $status = post("status");
          $userId = post("userId");
          $securityProtocolHash = hash_hmac('md5', hash_hmac('sha256', "$conversationId|$orderId|$paymentAmount|$status|$userId".$readPaymentVariables["paylithAPISecretKey"], $readPaymentVariables["paylithAPIKey"]), $readPaymentVariables["paylithAPIKey"]);
          if (post("status") == "SUCCESS") {
            if ($securityProtocolHash == $_POST["hash"]) {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array(post("conversationId"), $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentSecurityError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentCancelError", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "shopier") {
        if ($readPaymentVariables["shopierAPIKey"] !== "" && $readPaymentVariables["shopierAPISecretKey"] !== "") {
          $securityProtocolHashTR = base64_decode($_POST["signature"]);
          $securityProtocolHashBytes = $_POST["random_nr"].$_POST["platform_order_id"].$_POST["total_order_value"].$_POST["currency"];
          $securityProtocolHash = hash_hmac('SHA256', $securityProtocolHashBytes, $readPaymentVariables["shopierAPISecretKey"], true);
          if (strcmp($securityProtocolHashTR, $securityProtocolHash) == 0) {
            if (post("status") == "success") {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array(post("platform_order_id"), $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentCancelError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentSecurityError", "payments", $languageType));
          }
		    } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "batihost") {
        if ($readPaymentVariables["batihostID"] !== "" && $readPaymentVariables["batihostToken"] !== "" && $readPaymentVariables["batihostEmail"] !== "") {
          if (post("guvenlik") == $readPaymentVariables["batihostToken"]) {
            $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
            $searchPaymentTransaction->execute(array(post("user"), $paymentType, 0));
            if ($searchPaymentTransaction->rowCount() > 0) {
              $readPaymentTransaction = $searchPaymentTransaction->fetch();
              $completePaymentID = $readPaymentTransaction["id"];
            } else {
              exit("OK");
            }
          } else {
            exit(languageVariables("paymentSecurityError", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "keyubu") {
        if ($readPaymentVariables["keyubuID"] !== "" && $readPaymentVariables["keyubuToken"] !== "") {
          if (post("token") == $readPaymentVariables["keyubuToken"]) {
            if (post("status") == 'success') {
              $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
              $searchPaymentTransaction->execute(array(post("return_id"), $paymentType, 0));
              if ($searchPaymentTransaction->rowCount() > 0) {
                $readPaymentTransaction = $searchPaymentTransaction->fetch();
                $completePaymentID = $readPaymentTransaction["id"];
              } else {
                exit("OK");
              }
            } else {
              exit(languageVariables("paymentCancelError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentSecurityError", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "rabisu") {
        if ($readPaymentVariables["rabisuID"] !== "" && $readPaymentVariables["rabisuToken"] !== "") {
          if (post("bayi_token") == $readPaymentVariables["rabisuToken"]) {
            $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
            $searchPaymentTransaction->execute(array(post("oyuncu_adi"), $paymentType, 0));
            if ($searchPaymentTransaction->rowCount() > 0) {
              $readPaymentTransaction = $searchPaymentTransaction->fetch();
              $completePaymentID = $readPaymentTransaction["id"];
            } else {
              exit("OK");
            }
          } else {
            exit(languageVariables("paymentSecurityError", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else if ($paymentType == "anksoft") {
        if ($readPaymentVariables["anksoftMerchantKey"] !== "" && $readPaymentVariables["anksoftMerchantSecretKey"] !== "") {
          if (isset($_POST["status"]) && isset($_POST["order_id"]) && isset($_POST["merchant_id"]) && isset($_POST['hash']) && isset($_POST['amount']) && isset($_POST['full_name'])) {
            $hash = base64_encode(hash_hmac('sha256', true.post('order_id').$readPaymentVariables["anksoftMerchantKey"], $readPaymentVariables["anksoftMerchantSecretKey"], true));
            if (post("hash") == $hash) {
              if ($_POST["status"] == true) {
                $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentID = ? AND paymentAPIType = ? AND status = ?");
                $searchPaymentTransaction->execute(array(post("ExtraInfo"), $paymentType, 0));
                if ($searchPaymentTransaction->rowCount() > 0) {
                  $readPaymentTransaction = $searchPaymentTransaction->fetch();
                  $completePaymentID = $readPaymentTransaction["id"];
                } else {
                  exit("OK");
                }
              } else {
                exit(languageVariables("paymentCancelError", "payments", $languageType));
              }
            } else {
              exit(languageVariables("paymentSecurityError", "payments", $languageType));
            }
          } else {
            exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
          }
        } else {
          exit(languageVariables("paymentMethodDataError", "payments", $languageType));
        }
      } else {
        exit(languageVariables("paymentNotMethod", "payments", $languageType));
      }
      // Payment Transactions Complete
      if ($paymentType == "shopier") {
        if (PaymentTransactionComplete($completePaymentID) == "OK") {
          go(urlConverter("credit_upload_success", $languageType));
        } else {
          go(urlConverter("credit_upload_fail", $languageType));
        }
      } else {
        exit(PaymentTransactionComplete($completePaymentID));
      }
    } else {
      exit(languageVariables("paymentActiveError", "payments", $languageType));
    }
  } else {
    exit(languageVariables("paymentTransactionNotData", "payments", $languageType));
  }
?>