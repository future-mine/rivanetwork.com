  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">
    var $APIType = "<?php if ($rSettings["serverOnlineStatusAPI"] == "1") { echo "mcAPIUs"; } else if ($rSettings["serverOnlineStatusAPI"] == "2") { echo "mcAPITc"; } else if ($rSettings["serverOnlineStatusAPI"] == "3") { echo "mcAPIEu"; } else if ($rSettings["serverOnlineStatusAPI"] == "4") { echo "mcAPISrvJava"; } else if ($rSettings["serverOnlineStatusAPI"] == "5") { echo "mcAPISrvPocket"; } else if ($rSettings["serverOnlineStatusAPI"] == "6") { echo "mcAPIKeyubu"; } else { echo "mcAPIUs"; } ?>";
    var $tawkToStatus = "<?php echo $rMedia["liveSupportStatus"]; ?>";
    var $tawkToID = "<?php echo $rMedia["liveSupportEmbed"]; ?>";
    var $language = "<?php echo $languageType; ?>";
    var $themeMode = "dark";

    const $dateLang = {
      year: "<?php echo str_replace('"', '\"', languageVariables("year", "date", $languageType)); ?>",
      month: "<?php echo str_replace('"', '\"', languageVariables("month", "date", $languageType)); ?>",
      day: "<?php echo str_replace('"', '\"', languageVariables("day", "date", $languageType)); ?>",
      hours: "<?php echo str_replace('"', '\"', languageVariables("hours", "date", $languageType)); ?>",
      minute: "<?php echo str_replace('"', '\"', languageVariables("minute", "date", $languageType)); ?>",
      second: "<?php echo str_replace('"', '\"', languageVariables("second", "date", $languageType)); ?>"
    };

    const $languages = {
      systemError: "<?php echo str_replace('"', '\"', languageVariables("systemError", "javascript", $languageType)); ?>",
      noneError: "<?php echo str_replace('"', '\"', languageVariables("noneError", "javascript", $languageType)); ?>",
      error: "<?php echo str_replace('"', '\"', languageVariables("error", "javascript", $languageType)); ?>",
      success: "<?php echo str_replace('"', '\"', languageVariables("success", "javascript", $languageType)); ?>",
      warning: "<?php echo str_replace('"', '\"', languageVariables("warning", "javascript", $languageType)); ?>",
      unspecified: "<?php echo str_replace('"', '\"', languageVariables("unspecified", "javascript", $languageType)); ?>",
      okey: "<?php echo str_replace('"', '\"', languageVariables("okey", "javascript", $languageType)); ?>",
      info: "<?php echo str_replace('"', '\"', languageVariables("info", "javascript", $languageType)); ?>",
      giveUp: "<?php echo str_replace('"', '\"', languageVariables("giveUp", "javascript", $languageType)); ?>",
      approve: "<?php echo str_replace('"', '\"', languageVariables("approve", "javascript", $languageType)); ?>",
      check: "<?php echo str_replace('"', '\"', languageVariables("check", "javascript", $languageType)); ?>",
      buy: "<?php echo str_replace('"', '\"', languageVariables("buy", "javascript", $languageType)); ?>",
      login: "<?php echo str_replace('"', '\"', languageVariables("login", "javascript", $languageType)); ?>",
      close: "<?php echo str_replace('"', '\"', languageVariables("close", "javascript", $languageType)); ?>",
      tryagain: "<?php echo str_replace('"', '\"', languageVariables("tryagain", "javascript", $languageType)); ?>",
      creditUpload: "<?php echo str_replace('"', '\"', languageVariables("creditUpload", "javascript", $languageType)); ?>",
      goInventory: "<?php echo str_replace('"', '\"', languageVariables("goInventory", "javascript", $languageType)); ?>",
      goChest: "<?php echo str_replace('"', '\"', languageVariables("goChest", "javascript", $languageType)); ?>",
      goCart: "<?php echo str_replace('"', '\"', languageVariables("goCart", "javascript", $languageType)); ?>",
      shopContinue: "<?php echo str_replace('"', '\"', languageVariables("shopContinue", "javascript", $languageType)); ?>",
      sendGift: "<?php echo str_replace('"', '\"', languageVariables("sendGift", "javascript", $languageType)); ?>",
      username: "<?php echo str_replace('"', '\"', languageVariables("username", "javascript", $languageType)); ?>",
      product: "<?php echo str_replace('"', '\"', languageVariables("product", "javascript", $languageType)); ?>",
      ivent: "<?php echo str_replace('"', '\"', languageVariables("ivent", "javascript", $languageType)); ?>",
      coupon: "<?php echo str_replace('"', '\"', languageVariables("coupon", "javascript", $languageType)); ?>",
      message: "<?php echo str_replace('"', '\"', languageVariables("message", "javascript", $languageType)); ?>",
      areYouSure: "<?php echo str_replace('"', '\"', languageVariables("areYouSure", "javascript", $languageType)); ?>",
      functionJSNotSearch: "<?php echo str_replace('"', '\"', languageVariables("functionJSNotSearch", "javascript", $languageType)); ?>",
      functionJSCopyed: "<?php echo str_replace('"', '\"', languageVariables("functionJSCopyed", "javascript", $languageType)); ?>",
      functionJSNotCopyed: "<?php echo str_replace('"', '\"', languageVariables("functionJSNotCopyed", "javascript", $languageType)); ?>",
      editJSServerIPCopy: "<?php echo str_replace('"', '\"', languageVariables("editJSServerIPCopy", "javascript", $languageType)); ?>",
      editJSConsoleLog: "<?php echo str_replace('"', '\"', languageVariables("editJSConsoleLog", "javascript", $languageType)); ?>",
      <?php if ($incRequirePage == "card") { ?>
        
      cardGameJSWinner: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSWinner", "javascript", $languageType)); ?>",
      cardGameJSReward: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSReward", "javascript", $languageType)); ?>",
      cardGameJSWinnerText: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSWinnerText", "javascript", $languageType)); ?>",
      cardGameJSLoserTitle: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSLoserTitle", "javascript", $languageType)); ?>",
      cardGameJSLoserText: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSLoserText", "javascript", $languageType)); ?>",
      cardGameJSWinnerText0: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSWinnerText0", "javascript", $languageType)); ?>",
      cardGameJSLoserText0: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSLoserText0", "javascript", $languageType)); ?>",
      cardGameJSInfoText: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSInfoText", "javascript", $languageType)); ?>",
      cardGameJSOpenText: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSOpenText", "javascript", $languageType)); ?>",
      cardGameJSLoginError: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSLoginError", "javascript", $languageType)); ?>",
      cardGameJSCreditError: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSCreditError", "javascript", $languageType)); ?>",
      cardGameJSInventoryError: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSInventoryError", "javascript", $languageType)); ?>",
      cardGameJSHoursError: "<?php echo str_replace('"', '\"', languageVariables("cardGameJSHoursError", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "credit") { ?>
      
      alertControl: "<?php echo str_replace('"', '\"', languageVariables("alertControl", "credit", $languageType)); ?>",
      alertPaymentError: "<?php echo str_replace('"', '\"', languageVariables("alertPaymentError", "credit", $languageType)); ?>",
      <?php } else if ($incRequirePage == "chest") { ?>

      chestJSActiveInfoText: "<?php echo str_replace('"', '\"', languageVariables("chestJSActiveInfoText", "javascript", $languageType)); ?>",
      chestJSActiveSuccesAlert: "<?php echo str_replace('"', '\"', languageVariables("chestJSActiveSuccesAlert", "javascript", $languageType)); ?>",
      chestJSActiveLoginError: "<?php echo str_replace('"', '\"', languageVariables("chestJSActiveLoginError", "javascript", $languageType)); ?>",
      chestJSActiveConnectError: "<?php echo str_replace('"', '\"', languageVariables("chestJSActiveConnectError", "javascript", $languageType)); ?>",
      chestJSActiveCheckText: "<?php echo str_replace('"', '\"', languageVariables("chestJSActiveCheckText", "javascript", $languageType)); ?>",
      chestJSGiftLoadingText: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftLoadingText", "javascript", $languageType)); ?>",
      chestJSGiftSuccessText: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftSuccessText", "javascript", $languageType)); ?>",
      chestJSGiftLoginError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftLoginError", "javascript", $languageType)); ?>",
      chestJSGiftStatusError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftStatusError", "javascript", $languageType)); ?>",
      chestJSGiftActiveProductError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftActiveProductError", "javascript", $languageType)); ?>",
      chestJSGiftNotUserError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftNotUserError", "javascript", $languageType)); ?>",
      chestJSGiftYourselfError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftYourselfError", "javascript", $languageType)); ?>",
      chestJSGiftInventoryError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftInventoryError", "javascript", $languageType)); ?>",
      chestJSGiftUsernameError: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftUsernameError", "javascript", $languageType)); ?>",
      chestJSGiftSendSure: "<?php echo str_replace('"', '\"', languageVariables("chestJSGiftSendSure", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "inventory") { ?>

      inventoryJSBuySlotLoading: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotLoading", "javascript", $languageType)); ?>",
      inventoryJSBuySlotSuccess: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotSuccess", "javascript", $languageType)); ?>",
      inventoryJSBuySlotCreditError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotCreditError", "javascript", $languageType)); ?>",
      inventoryJSBuySlotLoginError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotLoginError", "javascript", $languageType)); ?>",
      inventoryJSBuySlotFullError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotFullError", "javascript", $languageType)); ?>",
      inventoryJSSlotNumber: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSlotNumber", "javascript", $languageType)); ?>",
      inventoryJSSlotNumberText: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSlotNumberText", "javascript", $languageType)); ?>",
      inventoryJSBuySlotText: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotText", "javascript", $languageType)); ?>",
      inventoryJSBuySlotAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSBuySlotAreYouSure", "javascript", $languageType)); ?>",
      inventoryJSActiveIvent: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSActiveIvent", "javascript", $languageType)); ?>",
      inventoryJSFullActiveIventSuccess: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSFullActiveIventSuccess", "javascript", $languageType)); ?>",
      inventoryJSFullInventoryCheckAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSFullInventoryCheckAreYouSure", "javascript", $languageType)); ?>",
      inventoryJSCreditActiveIventSuccess: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSCreditActiveIventSuccess", "javascript", $languageType)); ?>",
      inventoryJSProductActiveIventSuccess: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSProductActiveIventSuccess", "javascript", $languageType)); ?>",
      inventoryJSSendGiftLoading: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftLoading", "javascript", $languageType)); ?>",
      inventoryJSSendGiftSuccess: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftSuccess", "javascript", $languageType)); ?>",
      inventoryJSSendGiftStatusError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftStatusError", "javascript", $languageType)); ?>",
      inventoryJSSendGiftUsernameError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftUsernameError", "javascript", $languageType)); ?>",
      inventoryJSSendGiftInventorySlotError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftInventorySlotError", "javascript", $languageType)); ?>",
      inventoryJSSendGiftYourselfError: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftYourselfError", "javascript", $languageType)); ?>",
      inventoryJSCheckIventAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSCheckIventAreYouSure", "javascript", $languageType)); ?>",
      inventoryJSSendGiftUsernamePlease: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftUsernamePlease", "javascript", $languageType)); ?>",
      inventoryJSSendGiftUserAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSSendGiftUserAreYouSure", "javascript", $languageType)); ?>",
      inventoryJSIventControlLoading: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSIventControlLoading", "javascript", $languageType)); ?>",
      inventoryJSIventValue1: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSIventValue1", "javascript", $languageType)); ?>",
      inventoryJSIventValue2: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSIventValue2", "javascript", $languageType)); ?>",
      inventoryJSIventInfo: "<?php echo str_replace('"', '\"', languageVariables("inventoryJSIventInfo", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "support") { ?>

      supportJSRemoveLoading: "<?php echo str_replace('"', '\"', languageVariables("supportJSRemoveLoading", "javascript", $languageType)); ?>",
      supportJSRemoveSuccess: "<?php echo str_replace('"', '\"', languageVariables("supportJSRemoveSuccess", "javascript", $languageType)); ?>",
      supportJSRemoveAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("supportJSRemoveAreYouSure", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "store") { ?>

      storeJSProductBuyLoading: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyLoading", "javascript", $languageType)); ?>",
      storeJSProductBuySuccess: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuySuccess", "javascript", $languageType)); ?>",
      storeJSProductBuyLoginError: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyLoginError", "javascript", $languageType)); ?>",
      storeJSProductBuyNotStock: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyNotStock", "javascript", $languageType)); ?>",
      storeJSProductBuyNotCredit: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyNotCredit", "javascript", $languageType)); ?>",
      storeJSCouponControlLoading: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponControlLoading", "javascript", $languageType)); ?>",
      storeJSCouponCheckSuccess: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckSuccess", "javascript", $languageType)); ?>",
      storeJSCouponCheckAlready: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckAlready", "javascript", $languageType)); ?>",
      storeJSCouponCheckNotLimit: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckNotLimit", "javascript", $languageType)); ?>",
      storeJSCouponCheckNotCoupon: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckNotCoupon", "javascript", $languageType)); ?>",
      storeJSCouponCheckLoginError: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckLoginError", "javascript", $languageType)); ?>",
      storeJSCouponCheckIsCoupon: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckIsCoupon", "javascript", $languageType)); ?>",
      storeJSCouponCheckTitle: "<?php echo str_replace('"', '\"', languageVariables("storeJSCouponCheckTitle", "javascript", $languageType)); ?>",
      storeJSProductBuyControlLoading: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyControlLoading", "javascript", $languageType)); ?>",
      storeJSProductBuyInfoText: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyInfoText", "javascript", $languageType)); ?>",
      storeJSProductBuyInfoTitle: "<?php echo str_replace('"', '\"', languageVariables("storeJSProductBuyInfoTitle", "javascript", $languageType)); ?>",
      storeJSCartAddControlLoading: "<?php echo str_replace('"', '\"', languageVariables("storeJSCartAddControlLoading", "javascript", $languageType)); ?>",
      storeJSCartAddSuccess: "<?php echo str_replace('"', '\"', languageVariables("storeJSCartAddSuccess", "javascript", $languageType)); ?>",
      storeJSCartAddNotStock: "<?php echo str_replace('"', '\"', languageVariables("storeJSCartAddNotStock", "javascript", $languageType)); ?>",
      storeJSCartAddLoginError: "<?php echo str_replace('"', '\"', languageVariables("storeJSCartAddLoginError", "javascript", $languageType)); ?>",
      storeJSCartAddAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("storeJSCartAddAreYouSure", "javascript", $languageType)); ?>",
      storeJSStarAddLoading: "<?php echo str_replace('"', '\"', languageVariables("storeJSStarAddLoading", "javascript", $languageType)); ?>",
      storeJSStarAddSuccess: "<?php echo str_replace('"', '\"', languageVariables("storeJSStarAddSuccess", "javascript", $languageType)); ?>",
      storeJSStarAddAlready: "<?php echo str_replace('"', '\"', languageVariables("storeJSStarAddAlready", "javascript", $languageType)); ?>",
      storeJSStarAddLoginError: "<?php echo str_replace('"', '\"', languageVariables("storeJSStarAddLoginError", "javascript", $languageType)); ?>",
      storeJSStarAddAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("storeJSStarAddAreYouSure", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "forum") { ?>
      
      forumRemoveTopicAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("forumRemoveTopicAreYouSure", "javascript", $languageType)); ?>",
      forumRemoveTopicSuccess: "<?php echo str_replace('"', '\"', languageVariables("forumRemoveTopicSuccess", "javascript", $languageType)); ?>",
      forumNotLogin: "<?php echo str_replace('"', '\"', languageVariables("forumNotLogin", "javascript", $languageType)); ?>",
      forumNotYouTopic: "<?php echo str_replace('"', '\"', languageVariables("forumNotYouTopic", "javascript", $languageType)); ?>",
      forumIsRemoveTopic: "<?php echo str_replace('"', '\"', languageVariables("forumIsRemoveTopic", "javascript", $languageType)); ?>",
      forumRemoveMessageAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("forumRemoveMessageAreYouSure", "javascript", $languageType)); ?>",
      forumRemoveMessageSuccess: "<?php echo str_replace('"', '\"', languageVariables("forumRemoveMessageSuccess", "javascript", $languageType)); ?>",
      forumYouNotMessage: "<?php echo str_replace('"', '\"', languageVariables("forumYouNotMessage", "javascript", $languageType)); ?>",
      forumIsRemoveMessage: "<?php echo str_replace('"', '\"', languageVariables("forumIsRemoveMessage", "javascript", $languageType)); ?>",
      forumPleaseEnterMessage: "<?php echo str_replace('"', '\"', languageVariables("forumPleaseEnterMessage", "javascript", $languageType)); ?>",
      forumMessageNotfound: "<?php echo str_replace('"', '\"', languageVariables("forumMessageNotfound", "javascript", $languageType)); ?>",
      forumAlreadyReport: "<?php echo str_replace('"', '\"', languageVariables("forumAlreadyReport", "javascript", $languageType)); ?>",
      forumMessageReportSuccess: "<?php echo str_replace('"', '\"', languageVariables("forumMessageReportSuccess", "javascript", $languageType)); ?>",
      forumMessageReportTitle: "<?php echo str_replace('"', '\"', languageVariables("forumMessageReportTitle", "javascript", $languageType)); ?>",
      <?php } else if ($incRequirePage == "lottery") { ?>
      
      lotteryAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("lotteryAreYouSure", "javascript", $languageType)); ?>",
      lotteryLoadingText: "<?php echo str_replace('"', '\"', languageVariables("lotteryLoadingText", "javascript", $languageType)); ?>",
      lotteryPurchaseSuccess: "<?php echo str_replace('"', '\"', languageVariables("lotteryPurchaseSuccess", "javascript", $languageType)); ?>",
      lotteryPurchaseNotCredit: "<?php echo str_replace('"', '\"', languageVariables("lotteryPurchaseNotCredit", "javascript", $languageType)); ?>",
      lotteryPurchaseNotLogin: "<?php echo str_replace('"', '\"', languageVariables("lotteryPurchaseNotLogin", "javascript", $languageType)); ?>",
      lotteryPurchaseNotTicketCount: "<?php echo str_replace('"', '\"', languageVariables("lotteryPurchaseNotTicketCount", "javascript", $languageType)); ?>",
      <?php } ?>
      
      shoppingCartJSPaymentLoading: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentLoading", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentSuccess: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentSuccess", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentNotProduct: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentNotProduct", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentNotProductStock: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentNotProductStock", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentNotCredit: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentNotCredit", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentLoginError: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentLoginError", "javascript", $languageType)); ?>",
      shoppingCartJSPaymentInfoText: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSPaymentInfoText", "javascript", $languageType)); ?>",
      shoppingCartJSRemoveProductLoading: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSRemoveProductLoading", "javascript", $languageType)); ?>",
      shoppingCartJSRemoveProductSuccess: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSRemoveProductSuccess", "javascript", $languageType)); ?>",
      shoppingCartJSRemoveProductLoginError: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSRemoveProductLoginError", "javascript", $languageType)); ?>",
      shoppingCartJSRemoveProductAreYouSure: "<?php echo str_replace('"', '\"', languageVariables("shoppingCartJSRemoveProductAreYouSure", "javascript", $languageType)); ?>"
    };

    const $links = {
      home: "<?php echo urlConverter("home", $languageType); ?>",
      install: "<?php echo urlConverter("install", $languageType); ?>",
      maintance: "<?php echo urlConverter("maintance", $languageType); ?>",
      forum: "<?php echo urlConverter("forum", $languageType); ?>",
      lottery: "<?php echo urlConverter("lottery", $languageType); ?>",
      blog: "<?php echo urlConverter("blog", $languageType); ?>",
      news: "<?php echo urlConverter("news", $languageType); ?>",
      news_category: "<?php echo urlConverter("news_category", $languageType); ?>",
      vote: "<?php echo urlConverter("vote", $languageType); ?>",
      rules: "<?php echo urlConverter("rules", $languageType); ?>",
      privacy: "<?php echo urlConverter("privacy", $languageType); ?>",
      abouts: "<?php echo urlConverter("abouts", $languageType); ?>",
      bans: "<?php echo urlConverter("bans", $languageType); ?>",
      register: "<?php echo urlConverter("register", $languageType); ?>",
      login: "<?php echo urlConverter("login", $languageType); ?>",
      logout: "<?php echo urlConverter("logout", $languageType); ?>",
      recovery: "<?php echo urlConverter("recovery", $languageType); ?>",
      player: "<?php echo urlConverter("player", $languageType); ?>",
      chest: "<?php echo urlConverter("chest", $languageType); ?>",
      inventory: "<?php echo urlConverter("inventory", $languageType); ?>",
      gift_coupon: "<?php echo urlConverter("gift_coupon", $languageType); ?>",
      store: "<?php echo urlConverter("store", $languageType); ?>",
      cart: "<?php echo urlConverter("cart", $languageType); ?>",
      support: "<?php echo urlConverter("support", $languageType); ?>",
      support_create: "<?php echo urlConverter("support_create", $languageType); ?>",
      credit_upload: "<?php echo urlConverter("credit_upload", $languageType); ?>",
      credit_upload_success: "<?php echo urlConverter("credit_upload_success", $languageType); ?>",
      credit_upload_fail: "<?php echo urlConverter("credit_upload_fail", $languageType); ?>",
      credit_send: "<?php echo urlConverter("credit_send", $languageType); ?>",
      card_game: "<?php echo urlConverter("card_game", $languageType); ?>",
      profile: "<?php echo urlConverter("profile", $languageType); ?>",
      profile_message: "<?php echo urlConverter("profile_message", $languageType); ?>",
      profile_notifications: "<?php echo urlConverter("profile_notifications", $languageType); ?>",
      profile_prepare: "<?php echo urlConverter("profile_prepare", $languageType); ?>",
      profile_change_password: "<?php echo urlConverter("profile_change_password", $languageType); ?>",
      profile_settings: "<?php echo urlConverter("profile_settings", $languageType); ?>",
      profile_history_chest: "<?php echo urlConverter("profile_history_chest", $languageType); ?>",
      profile_history_store: "<?php echo urlConverter("profile_history_store", $languageType); ?>",
      profile_history_credit: "<?php echo urlConverter("profile_history_credit", $languageType); ?>",
      profile_history_card_game: "<?php echo urlConverter("profile_history_card_game", $languageType); ?>",
      profile_history_gift_coupon: "<?php echo urlConverter("profile_history_gift_coupon", $languageType); ?>",
      profile_history_ban: "<?php echo urlConverter("profile_history_ban", $languageType); ?>",
      payment_paytr: "<?php echo urlConverter("payment_paytr", $languageType); ?>",
      payment_shopier: "<?php echo urlConverter("payment_shopier", $languageType); ?>",
      payment_callback: "<?php echo urlConverter("payment_callback", $languageType); ?>",
      admin: "<?php echo urlConverter("admin", $languageType); ?>",
      help: "<?php echo urlConverter("help", $languageType); ?>"
    };
  </script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/app.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/vendor/simplebar.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/vendor/plugins.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/vendor/tiny-slider.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/global/hexagons.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/global/tooltips.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/global/accordions.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/content.min.js?v=7"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
  <?php if ($incRequirePage == "profile") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/dropimage/js/dropimage.min.js"></script>
  <?php } ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php if ($incRequirePage == "chest") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/chest/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "card") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/card/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "credit") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/credit/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "inventory") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/inventory/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "support") { ?>
  <script type="text/javascript">
    var $supportMessageBoxReload = <?php echo (($incRequirePage == "support") ? 1 : 0); ?>;
  </script>
  <script type="text/javascript" src="/main/includes/packages/layouts/support/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "store") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/store/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "help-center") { ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/help-center/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "forum") { ?>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/js/froala_editor.pkgd.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/js/languages/<?php echo $languageType; ?>.js"></script>
  <script type="text/javascript" src="/main/includes/packages/layouts/forum/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if ($incRequirePage == "lottery") { ?>
  <script type="text/javascript" src="https://unpkg.com/@pqina/flip@1.7.7/dist/flip.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/main/includes/packages/layouts/lottery/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } ?>
  <script type="text/javascript" src="/main/includes/packages/layouts/shopping-cart/js/edit.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php if ($readModule["snowModeStatus"] == "1") { ?>
  <script type="text/javascript" src="/main/themes/sitary/theme/js/snow.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } ?>

  <?php if ($rSettings["googleAI"] !== "0") { ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $rSettings["googleAI"]; ?>"></script>
  <script type="text/javascript">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());

    gtag("config", "<?php echo $rSettings["googleAI"]; ?>");
  </script>
  <?php } ?>
</body>
</html>