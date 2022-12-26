<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "remove") {
  if (post("cartID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $shoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE id = ? AND userID = ? ORDER BY id ASC");
      $shoppingCart->execute(array(post("cartID"), $readAccount["id"]));
      if ($shoppingCart->rowCount() > 0) {
        $readCart = $shoppingCart->fetch();
        $deleteShoppingCart = $db->prepare("DELETE FROM shoppingCart WHERE id = ? AND userID = ?");
        $deleteShoppingCart->execute(array($readCart["id"], $readAccount["id"]));
        if ($deleteShoppingCart) {
          exit('{"code": "successyfull"}');
        } else {
          exit('{"code": "notCart"}');
        }
      } else {
        exit('{"code": "notCart"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else if (get("action") == "checkout") {
  if (post("proccess") == "checkOut") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchShoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ?");
      $searchShoppingCart->execute(array($readAccount["id"]));
      if ($searchShoppingCart->rowCount() > 0) {
        $searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
        $searchCouponHistory->execute(array($readAccount["id"], 0));
        if ($searchCouponHistory->rowCount() > 0) {
          $readCouponHistory = $searchCouponHistory->fetch();
          $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
          $searchCoupon->execute(array($readCouponHistory["couponID"], 1));
          if ($searchCoupon->rowCount() > 0) {
            $readCoupon = $searchCoupon->fetch();
            $promoDiscount = (100-$readCoupon["discount"])/100;
          } else {
            $promoDiscount = "0";
          }
        } else {
          $promoDiscount = "0";
        }
        foreach ($searchShoppingCart as $readShoppingCart) {
          $priceProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
          $priceProduct->execute(array($readShoppingCart["productID"]));
          if ($priceProduct->rowCount() > 0) {
            $priceProduct = $priceProduct->fetch();
            if ($priceProduct["productType"] == 1 && $priceProduct["productDiscount"] > 0) {
              $productDiscount = floor($priceProduct["price"]*(100-$priceProduct["productDiscount"])/100);
              $priceProduct["price"] = $productDiscount;
            } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
              $productDiscount = floor($priceProduct["price"]*(100-$readModule["storeDiscount"])/100);
              $priceProduct["price"] = $productDiscount;
            }
            $totalAmount = $totalAmount + ($priceProduct["price"]*$readShoppingCart["productCount"]);
          } else {
            $totalAmount = $totalAmount + 0;
          }
        }
        if ($promoDiscount !== "0") {
          $totalAmount = $totalAmount*$promoDiscount;
        }
        if ($readAccount["credit"] >= $totalAmount) {
          $stockControl = "SUCCESSFULL";
          $checkOutCartStockControl = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ?");
          $checkOutCartStockControl->execute(array($readAccount["id"]));
          foreach ($checkOutCartStockControl as $readStockControl) {
            $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
            $searchProduct->execute(array($readStockControl["productID"]));
            if ($searchProduct->rowCount() > 0) {
              $readProduct = $searchProduct->fetch();
              $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?");
              $searchProductStockHistory->execute(array($readProduct["id"]));
              $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount();
              if ($readProduct["productCount"] > 0 && $readStockControl["productCount"] > $productCountPiece) {
                $stockControl = "UNSUCCESSFULL";
              }
            }
          }
          if ($stockControl == "SUCCESSFULL") {
            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit - ? WHERE id = ?");
            $updateAccount->execute(array($totalAmount, $readAccount["id"]));
            $checkOutCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ?");
            $checkOutCart->execute(array($readAccount["id"]));
            foreach ($checkOutCart as $readCheckOut) {
              $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
              $searchProduct->execute(array($readCheckOut["productID"]));
              if ($searchProduct->rowCount() > 0) {
                $readProduct = $searchProduct->fetch();
                for ($i = 1; $i <= $readCheckOut["productCount"]; $i++) {
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
                }
              }
            }
            $clearShoppingCart = $db->prepare("DELETE FROM shoppingCart WHERE userID = ?");
            $clearShoppingCart->execute(array($readAccount["id"]));
            if ($promoDiscount !== "0") {
              $updateCoupon = $db->prepare("UPDATE discountCouponHistory SET status = ? WHERE id = ? AND status = ? AND couponID = ? AND userID = ?");
              $updateCoupon->execute(array(1, $readCouponHistory["id"], 0, $readCoupon["id"], $readAccount["id"]));
            }
            exit('{"code": "successyfull"}');
          } else {
            exit('{"code": "stockNot"}');
          }
        } else {
          exit('{"code": "insufficientCredit", "credit": "'.$readAccount["credit"].'", "total": "'.$totalAmount.'"}');
        }
      } else {
        exit('{"code": "emptyCart"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else {
  exit('{"code": "notData"}');
}
?>