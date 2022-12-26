<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "addCart") {
  if (post("productID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(post("productID")));
      if ($searchProduct->rowCount() > 0) {
        $readProduct = $searchProduct->fetch();
        $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?");
        $searchProductStockHistory->execute(array($readProduct["id"]));
        if ($readProduct["productCount"] == "0" || $readProduct["productCount"] > $searchProductStockHistory->rowCount()) {
          $searchShoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ? AND productID = ?");
          $searchShoppingCart->execute(array($readAccount["id"], $readProduct["id"]));
          if ($searchShoppingCart->rowCount() > 0) {
            $updateCart = $db->prepare("UPDATE shoppingCart SET productCount = productCount + ? WHERE userID = ? AND productID = ?");
            $updateCart->execute(array(1, $readAccount["id"], $readProduct["id"]));
          } else {
            $insertCart = $db->prepare("INSERT INTO shoppingCart SET userID = ?, productID = ?, productCount = ?, date = ?");
            $insertCart->execute(array($readAccount["id"], $readProduct["id"], 1, date("d.m.Y H:i:s")));
          }
          exit('{"code": "successyfull"}');
        } else {
          exit('{"code": "stockNot"}');
        }
      } else {
        exit('{"code": "error"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "error"}');
  }
} else if (get("action") == "directBuy") {
  if (post("productID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(post("productID")));
      if ($searchProduct->rowCount() > 0) {
        $readProduct = $searchProduct->fetch();
        $searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
        $searchCouponHistory->execute(array($readAccount["id"], 0));
        if ($searchCouponHistory->rowCount() > 0) {
          $readCouponHistory = $searchCouponHistory->fetch();
          $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
          $searchCoupon->execute(array($readCouponHistory["couponID"], 0));
          if ($searchCoupon->rowCount() > 0) {
            $readCoupon = $searchCoupon->fetch();
            $promoDiscount = (100-$readCoupon["discount"])/100;
          } else {
            $promoDiscount = "0";
          }
        } else {
          $promoDiscount = "0";
        }
        if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
          $readProduct["price"] = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
        } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
          $readProduct["price"] = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
        }
        if ($promoDiscount !== "0") {
          $readProduct["price"] = $readProduct["price"]*$promoDiscount;
        }
        $readProduct["price"] = floor($readProduct["price"]);
        if ($readAccount["credit"] >= $readProduct["price"]) {
          $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?");
          $searchProductStockHistory->execute(array($readProduct["id"]));
          if ($readProduct["productCount"] == "0" || $readProduct["productCount"] > $searchProductStockHistory->rowCount()) {
            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit - ? WHERE id = ?");
            $updateAccount->execute(array($readProduct["price"], $readAccount["id"]));
            if ($updateAccount) {
              $insertChest = $db->prepare("INSERT INTO userChest SET userID = ?, productID = ?, status = ?, date = ?");
              $insertChest->execute(array($readAccount["id"], $readProduct["id"], 0, date("d.m.Y H:i:s")));
              if ($readProduct["productCount"] > 0) {
                $insertProductStockHistory = $db->prepare("INSERT INTO productStockHistory (`productID`, `accountID`, `date`) VALUES (?, ?, ?)");
                $insertProductStockHistory->execute(array($readProduct["id"], $readAccount["id"], date("d.m.Y H:i:s")));
              }
              $insertStoreHistory = $db->prepare("INSERT INTO storeHistory SET serverID = ?, productName = ?, productPrice = ?, productID = ?, username = ?, date = ?");
              $insertStoreHistory->execute(array($readProduct["serverID"], $readProduct["name"], $readProduct["price"], $readProduct["id"], $readAccount["username"], date("d.m.Y H:i:s")));
              $searchProductServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
              $searchProductServer->execute(array($readProduct["serverID"]));
              $readProductServer = $searchProductServer->fetch();
              $webhookDescription = str_replace(array("[username]", "[server]", "[product]"), array($readAccount["username"], $readProductServer["name"], $readProduct["name"]), $readWebhooks["webhookStoreDescription"]);
              $hookObject = json_encode([
                "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookStoreName"]),
                "avatar_url" => avatarAPI($readAccount["username"], 100),
                "tts" => false,
                "embeds" => [
                   [
                        "title" => $readWebhooks["webhookStoreTitle"],
                        "type" => "rich",
                        "image" => ($readWebhooks["webhookStoreImage"] !== "0") ? [
                          "url" => $readWebhooks["webhookStoreImage"]
                        ] : [],
                        "description" => $webhookDescription,
                        "color" => hexdec(rand_color()),
                        "footer" => ($readWebhooks["webhookStoreSignature"] == "1") ? [
                            "text" => "Powered by MineXON",
                            "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                        ] : []
                    ]
                ]
              ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
              $sendWebhook = (($readWebhooks["webhookStoreStatus"] == "1") ? webhooks($readWebhooks["webhookStoreAPI"], $hookObject) : "OK");
              if ($promoDiscount !== "0") {
                $updateCoupon = $db->prepare("UPDATE discountCouponHistory SET status = ? WHERE id = ? AND status = ? AND couponID = ? AND userID = ?");
                $updateCoupon->execute(array(1, $readCouponHistory["id"], 0, $readCoupon["id"], $readAccount["id"]));
              }
              exit('{"code": "successyfull"}');
            } else {
              exit('{"code": "error"}');
            }
          } else {
            exit('{"code": "stockNot"}');
          }
        } else {
          exit('{"code": "insufficientCredit", "credit": "'.$readAccount["credit"].'", "price": "'.$readProduct["price"].'"}');
        }
      } else {
        exit('{"code": "error"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "error"}');
  }
} else if (get("action") == "rates") {
  if (post("productID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(post("productID")));
      if ($searchProduct->rowCount() > 0) {
        $readProduct = $searchProduct->fetch();
        $searchRates = $db->prepare("SELECT * FROM productRates WHERE userID = ? AND productID = ?");
        $searchRates->execute(array($readAccount["id"], $readProduct["id"]));
        if ($searchRates->rowCount() == 0) {
          $insertStarVote = $db->prepare("INSERT INTO productRates SET userID = ?, username = ?, productName = ?, productID = ?, date = ?");
          $insertStarVote->execute(array($readAccount["id"], $readAccount["username"], $readProduct["name"], $readProduct["id"], date("d.m.Y H:i:s")));
          exit('{"code": "successyfull"}');
        } else {
          exit('{"code": "already"}');
        }
      } else {
        exit('{"code": "error"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "error"}');
  }
} else if (get("action") == "info") {
  if (post("productID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(post("productID")));
      if ($searchProduct->rowCount() > 0) {
        $readProduct = $searchProduct->fetch();
        $searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
        $searchCouponHistory->execute(array($readAccount["id"], 0));
        if ($searchCouponHistory->rowCount() > 0) {
          $readCouponHistory = $searchCouponHistory->fetch();
          $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
          $searchCoupon->execute(array($readCouponHistory["couponID"], 0));
          if ($searchCoupon->rowCount() > 0) {
            $readCoupon = $searchCoupon->fetch();
            $promoDiscount = (100-$readCoupon["discount"])/100;
          } else {
            $promoDiscount = "0";
          }
        } else {
          $promoDiscount = "0";
        }
        if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
          $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
          $readProduct["price"] = $productDiscount;
        } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
          $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
          $readProduct["price"] = $productDiscount;
        }
        if ($promoDiscount !== "0") {
          $readProduct["price"] = $readProduct["price"]*$promoDiscount;
        }
        $readProduct["price"] = floor($readProduct["price"]);
        exit('{"code": "successyfull", "price": "'.$readProduct["price"].'"}');
      } else {
        exit('{"code": "error"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "error"}');
  }
} else if (get("action") == "checkCoupon") {
  if (post("productID") !== "" && post("promoCode") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(post("productID")));
      if ($searchProduct->rowCount() > 0) {
        $readProduct = $searchProduct->fetch();
        $searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
        $searchCouponHistory->execute(array($readAccount["id"], 0));
        if ($searchCouponHistory->rowCount() > 0) {
          $readCouponHistory = $searchCouponHistory->fetch();
          $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
          $searchCoupon->execute(array($readCouponHistory["couponID"], 0));
          if ($searchCoupon->rowCount() > 0) {
            $readCoupon = $searchCoupon->fetch();
            $proccessStatus = "__FALSE__";
          } else {
            $proccessStatus = "__TRUE__";
          }
        } else {
          $proccessStatus = "__TRUE__";
        }
        if ($proccessStatus == "__TRUE__") {
          $searchCoupons = $db->prepare("SELECT * FROM discountCoupon WHERE code = ? AND type = ?");
          $searchCoupons->execute(array(post("promoCode"), 0));
          if ($searchCoupons->rowCount() > 0) {
            $readCoupons = $searchCoupons->fetch();
            $searchCouponHistorys = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND couponID = ?");
            $searchCouponHistorys->execute(array($readAccount["id"], $readCoupons["id"]));
            if ($searchCouponHistorys->rowCount() == 0) {
              $couponCount = $db->prepare("SELECT * FROM discountCouponHistory WHERE couponID = ?");
              $couponCount->execute(array($readCoupons["id"]));
              if ($readCoupons["couponCount"] > $couponCount->rowCount() || $readCoupons["couponCount"] == "0-0-0-0") {
                $insertCouponHistory = $db->prepare("INSERT INTO discountCouponHistory SET userID = ?, couponID = ?, status = ?, date = ?");
                $insertCouponHistory->execute(array($readAccount["id"], $readCoupons["id"], 0, date("d.m.Y H:i:s")));
                exit('{"code": "successyfull", "discount": "'.$readCoupons["discount"].'"}');
              } else {
                exit('{"code": "notCount"}');
              }
            } else {
              exit('{"code": "checkCoupon"}');
            }
          } else {
            exit('{"code": "notCoupon"}');
          }
        } else {
          exit('{"code": "already"}');
        }
      } else {
        exit('{"code": "error"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "error"}');
  }
} else {
  exit('{"code": "error"}');
}
?>