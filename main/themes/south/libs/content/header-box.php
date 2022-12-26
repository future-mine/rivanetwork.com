<style type="text/css">
<?php if (isset($_SESSION["incAccountLogin"])) { $avatarImage = "https://mc-heads.net/body/".$readAccount["username"]."/110"; } else { $avatarImage = "https://mc-heads.net/body/demo/110"; } ?>
.product-category-box.category-featured.category-minecraft {
    background: url('<?php echo $avatarImage; ?>') no-repeat 90% 5px, linear-gradient(90deg, #006fb5, #3af0d4);
}
</style>
<?php
if ($incRequirePage == "home") {
  $headerBoxTitle = languageVariables("homeTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("homeText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-info.png";
} else if ($incRequirePage == "login") {
  $headerBoxTitle = languageVariables("loginTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("loginText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-sign.png";
} else if ($incRequirePage == "register") {
  $headerBoxTitle = languageVariables("registerTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("registerText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-sign.png";
} else if ($incRequirePage == "recovery") {
  $headerBoxTitle = languageVariables("recoveryTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("recoveryText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/verifieds-b.png";
} else if ($incRequirePage == "rules") {
  $headerBoxTitle = languageVariables("rulesTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("rulesText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-info.png";
} else if ($incRequirePage == "abouts") {
  $headerBoxTitle = languageVariables("aboutsTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("aboutsText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-info.png";
} else if ($incRequirePage == "privacy") {
  $headerBoxTitle = languageVariables("privacyTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("privacyText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-info.png";
} else if ($incRequirePage == "contact") {
  $headerBoxTitle = languageVariables("contactTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("contactText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/libs/includes/images/landing/badge-info.png";
} else if ($incRequirePage == "bans") {
  $headerBoxTitle = languageVariables("bansTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("bansText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/villain-b.png";
} else if ($incRequirePage == "player") {
  $headerBoxTitle = languageVariables("playerTitle", "header-box", $languageType).$readPlayer["username"];
  $headerBoxText = str_replace("&username", $readPlayer["username"], languageVariables("playerText", "header-box", $languageType));
  $headerBoxImage = "/main/themes/south/theme/img/badge/gempost-b.png";
} else if ($incRequirePage == "chest") {
  $headerBoxTitle = languageVariables("chestTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("chestText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/tycoon-b.png";
} else if ($incRequirePage == "card") {
  if ($readCardGame["type"] == "1") {
    $headerBoxTitle = languageVariables("cardGameTitle", "header-box", $languageType).$readCardGame["name"]." (".$readCardGame["price"]." ".languageVariables("credi", "words", $languageType).")";
  } else if ($readCardGame["type"] == "0") {
    $headerBoxTitle = languageVariables("cardGameTitle", "header-box", $languageType).$readCardGame["name"]." (".$readCardGame["hours"]." ".languageVariables("hours", "words", $languageType).")";
  }
  $headerBoxText = languageVariables("cardGameText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/scientist-b.png";
} else if ($incRequirePage == "credit") {
  if (get("action") == "proccess") {
    $headerBoxTitle = languageVariables("creditUploadTitle", "header-box", $languageType);
    $headerBoxText = languageVariables("creditUploadText", "header-box", $languageType);
    $headerBoxImage = "/main/includes/packages/layouts/inventory/image/credit/default.png";
  } else if (get("action") == "transfer") {
    $headerBoxTitle = languageVariables("creditSendTitle", "header-box", $languageType);
    $headerBoxText = languageVariables("creditSendText", "header-box", $languageType);
    $headerBoxImage = "/main/themes/south/theme/img/badge/upowered-b.png";
  }
} else if ($incRequirePage == "inventory") {
  $headerBoxTitle = languageVariables("inventoryTitle", "header-box", $languageType)." (".$searchInventoryItem->rowCount()."/".$readAccount["inventorySlot"].")";
  $headerBoxText = languageVariables("inventoryText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/ncreature-b.png";
} else if ($incRequirePage == "coupon") {
  $headerBoxTitle = languageVariables("giftCouponTitle", "header-box", $languageType);
  $headerBoxText = languageVariables("giftCouponText", "header-box", $languageType);
  $headerBoxImage = "/main/themes/south/theme/img/badge/tstruck-b.png";
} else if ($incRequirePage == "support") {
  if (get("action") == "get") {
    $headerBoxTitle = languageVariables("supportTitle", "header-box", $languageType);
    $headerBoxText = languageVariables("supportText", "header-box", $languageType);
    $headerBoxImage = "/main/themes/south/theme/img/badge/platinum-b.png";
  } else if (get("action") == "create") {
    $headerBoxTitle = languageVariables("supportCreateTitle", "header-box", $languageType);
    $headerBoxText = languageVariables("supportCreateText", "header-box", $languageType);
    $headerBoxImage = "/main/themes/south/theme/img/badge/platinum-b.png";
  } else if (get("action") == "update") {
    $headerBoxTitle = languageVariables("supportIsTitle", "header-box", $languageType).$readSupport["title"];
    $headerBoxText = str_replace("&lastUpdate", checkTime($readSupport["lastUpdate"]), languageVariables("supportIsText", "header-box", $languageType));
    $headerBoxImage = "/main/themes/south/theme/img/badge/platinum-b.png";
  }
} else if ($incRequirePage == "pages") {
  $headerBoxTitle = languageVariables("pageTitle", "header-box", $languageType).$readPage["title"];
  $headerBoxText = str_replace("&title", $readPage["title"], languageVariables("pageText", "header-box", $languageType));
  $headerBoxImage = "/main/themes/south/theme/img/badge/mightiers-b.png";
}
?>
  <div class="grid grid-9-3 change-on-desktop">
    <div class="achievement-box <?php if ($_SESSION["themeModeType"] == "dark") { echo "secondary"; } else if ($_SESSION["themeModeType"] == "light") { echo "primary"; } ?>">
      <div class="achievement-box-info-wrap">
        <img class="achievement-box-image" src="<?php echo $headerBoxImage; ?>" alt="<?php echo $headerBoxTitle; ?>">
        <div class="achievement-box-info">
          <p class="achievement-box-title"><?php echo $headerBoxTitle; ?></p>
          <p class="achievement-box-text"><?php echo $headerBoxText; ?></p>
        </div>
      </div>
      <?php if ($incRequirePage == "home") { ?>
      <a class="button white-solid" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("goStore", "words", $languageType); ?></a>
      <?php } else { ?>
      <a class="button white-solid" href="<?php echo urlConverter("home", $languageType); ?>"><?php echo languageVariables("backHome", "words", $languageType); ?></a>
      <?php } ?>
    </div>
    <a class="product-category-box category-featured category-minecraft" server-command="serverIPCopy" data-clipboard-action="copy" data-clipboard-text="<?php echo $rSettings['IPAdres']; ?>">
        <p class="product-category-box-title"><?php echo $rSettings["IPAdres"]; ?></p>
        <p class="product-category-box-text"><?php echo languageVariables("skinTitle", "header-box", $languageType); ?></p>
        <p class="product-category-box-tag"><span server-command="serverOnlineStatus" server-ip="<?php echo $rSettings['IPAdres']; ?>">-/-</span> <?php echo languageVariables("serverOnlineText", "words", $languageType); ?></p>
      </a>
  </div>