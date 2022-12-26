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
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("credi", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("upload", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col">
      <div credit="html"></div>
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("creditUpload", "words", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
          <form action="">
            <div class="grid">
              <label for="username" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("username", "words", $languageType); ?></label>
              <input id="username" type="text" name="username" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>" value="<?php echo $readAccount["username"]; ?>" readonly>
            </div>
            <?php if ($readPayments["creditType"] == "1" && !empty($readPayments["creditPackets"])) { ?>
            <div class="grid mt-4 relative z-30">
              <label for="amount" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("amount", "words", $languageType); ?></label>
              <select id="amount" credit="amount" class="custom-select form-control mt-2" name="amount">
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
            <div class="grid mt-4">
              <label for="amount" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("amount", "words", $languageType); ?></label>
              <input id="amount" credit="amount" type="text" name="amount" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("amount", "words", $languageType); ?>">
            </div>
            <?php } ?>
            <div class="grid mt-4 relative z-20">
              <label for="method" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("paymentType", "words", $languageType); ?></label>
              <select id="method" credit="method" class="custom-select form-control mt-2" name="method">
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
            <div class="mt-4 border-t-2 border-gray-200/50 pt-4">
              <div class="grid">
                <label for="name" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("name", "words", $languageType); ?></label>
                <input id="name" credit="name" type="text" name="name" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("name", "words", $languageType); ?>" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["firstName"]; } ?>">
              </div>
              <div class="grid mt-4">
                <label for="surname" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("surname", "words", $languageType); ?></label>
                <input id="surname" credit="surname" type="text" name="surname" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("surname", "words", $languageType); ?>" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["surName"]; } ?>">
              </div>
              <div class="grid mt-4">
                <label for="phoneNumber" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("phoneNumber", "words", $languageType); ?></label>
                <input id="phoneNumber" credit="phoneNumber" type="text" name="phoneNumber" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("phoneNumber", "words", $languageType); ?>" value="<?php if ($paymentInformationStatus == true) { echo $readAccountPaymentInformation["phoneNumber"]; } ?>">
              </div>
            </div>
            <?php if ($rSettings["salesAgreementType"] == "1") { ?>
            <input type="hidden" credit="salesAgreementInput" value="0">
            <div class="grid mt-6">
              <label for="checkbox" class="flex items-center gap-3">
                <input id="checkbox" type="checkbox" name="salesAgreement" credit="salesAgreement" class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded-md">
                <span class="text-gray-400 text-sm"><?php echo languageVariables("salesAgreement", "credit", $languageType); ?></span>
              </label>
            </div>
            <?php } ?>
            <input type="hidden" credit="userID" value="<?php echo $readAccount["id"]; ?>">
            <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
              <button type="button" class="btn btn-primary" credit="upload"><?php echo languageVariables("pay", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
	  <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-coins !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
            <?php if ($searchCreditHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("paymentType", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCreditHistory["username"]; ?>/28" alt="<?php echo languageVariables("creditUpload", "words", $languageType); ?> - <?php echo $readCreditHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCreditHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readCreditHistory["amount"]; ?></td>
                    <td class="font-normal p-3"><?php echo (($readCreditHistory["method"] == 0) ? "<i class=\"fas fa-mobile\"></i>" : "<i class=\"fas fa-credit-card\"></i>"); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } else if (get("action") == "transactions") { ?>
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("credi", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("upload", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php if (get("target") == "successyfull") { echo languageVariables("success", "words", $languageType); } else { echo languageVariables("unsuccess", "words", $languageType); } ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("creditTrans", "words", $languageType); ?> <?php if (get("target") == "successyfull") { echo languageVariables("uploadSuccess", "words", $languageType); } else { echo languageVariables("uploadUnsuccess", "words", $languageType); } ?></h3>
        <div class="text-gray-400 mt-4">
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
	  <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-coins !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
            <?php if ($searchCreditHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("paymentType", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCreditHistory["username"]; ?>/28" alt="<?php echo languageVariables("creditUpload", "words", $languageType); ?> - <?php echo $readCreditHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCreditHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readCreditHistory["amount"]; ?></td>
                    <td class="font-normal p-3"><?php echo (($readCreditHistory["method"] == 0) ? "<i class=\"fas fa-mobile\"></i>" : "<i class=\"fas fa-credit-card\"></i>"); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } else if (get("action") == "transfer") { ?>
  <section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("credi", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_send", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("send", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("send", "words", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
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
            <div class="grid">
              <label for="username" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("username", "words", $languageType); ?></label>
              <input id="username" type="text" name="username" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("username", "words", $languageType); ?>">
            </div>
            <div class="grid mt-4">
              <label for="amount" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("amount", "words", $languageType); ?></label>
              <input id="amount" type="text" name="credit" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("amount", "words", $languageType); ?>">
            </div>
            <?php echo $safeCsrfToken->input("creditTransferToken"); ?>
            <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
              <button type="submit" name="creditTransfer" class="btn btn-primary"><?php echo languageVariables("send", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
	  <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-coins !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
            <?php if ($searchCreditHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("paymentType", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCreditHistory["username"]; ?>/28" alt="<?php echo languageVariables("creditUpload", "words", $languageType); ?> - <?php echo $readCreditHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCreditHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readCreditHistory["amount"]; ?></td>
                    <td class="font-normal p-3"><?php echo (($readCreditHistory["method"] == 0) ? "<i class=\"fas fa-mobile\"></i>" : "<i class=\"fas fa-credit-card\"></i>"); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } else if (get("action") == "paytr") { ?>
<?php
$searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE paymentAPIType = ? AND paymentID = ?");
$searchPaymentTransaction->execute(array("paytr", get("paymentID")));
if ($searchPaymentTransaction->rowCount() > 0) {
    $readPaymentTransaction = $searchPaymentTransaction->fetch();
    $readPaymentTransactionVariables = json_decode($readPaymentTransaction["variables"], true);
?>
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("credi", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("upload", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">PayTR</a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("creditTrans", "words", $languageType); ?> (PayTR)</h3>
        <div class="text-gray-400 mt-4">
          <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
          <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $readPaymentTransactionVariables["paytrToken"]; ?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
          <script>
            iFrameResize({}, '#paytriframe');
          </script>
        </div>
      </div>
    </div>
	  <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-coins !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("historyTitle", "credit", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 5"); ?>
            <?php if ($searchCreditHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("paymentType", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCreditHistory["username"]; ?>/28" alt="<?php echo languageVariables("creditUpload", "words", $languageType); ?> - <?php echo $readCreditHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCreditHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php echo $readCreditHistory["amount"]; ?></td>
                    <td class="font-normal p-3"><?php echo (($readCreditHistory["method"] == 0) ? "<i class=\"fas fa-mobile\"></i>" : "<i class=\"fas fa-credit-card\"></i>"); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "credit", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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
<?php } ?>