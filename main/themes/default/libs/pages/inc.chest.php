<?php
AccountLoginControl(false);
$searchUserChest = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
$searchUserChest->execute(array($readAccount["id"], 0));
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
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("chest", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><strong><?php echo languageVariables("chest", "words", $languageType); ?></strong> (<?php echo $searchUserChest->rowCount(); ?>)</a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto lg:grid lg:grid-cols-10 gap-16 px-4 md:px-0">
    <div class="lg:col-span-7 flex flex-col gap-16">
      <div class="mt-10">
        <div class="text-gray-400">
          <?php if ($searchUserChest->rowCount() > 0) { ?>
          <div class="card overflow-x-auto w-full">
            <table class="w-full text-left relative z-10">
              <thead>
                <tr class="text-xs uppercase text-white font-medium bg-indigo-400/25 !text-indigo-700 relative">
                  <th class="py-4 px-3 relative z-10">ID</th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("product", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="py-4 px-3 relative z-10"><?php echo languageVariables("transactions", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                <?php
                foreach ($searchUserChest as $readChest) {
                    $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                    $searchProduct->execute(array($readChest["productID"]));
                    if ($searchProduct->rowCount() > 0) {
                      $readProduct = $searchProduct->fetch();
                      $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                      $searchServer->execute(array($readProduct["serverID"]));
                    if ($searchServer->rowCount() > 0) {
                      $readServer = $searchServer->fetch();
                ?>
                <tr class="hover:bg-gray-100">
                  <td class="font-normal p-3">#<?php echo $readChest["id"]; ?></td>
                  <td class="font-normal p-3"><?php echo $readProduct["name"]; ?></td>
                  <td class="font-normal p-3"><?php echo $readServer["name"]; ?></td>
                  <td class="font-normal p-3"><?php echo checkTime($readChest["date"], 2, true); ?></td>
                  <td class="font-normal p-3 flex gap-3">
                    <a onclick="proccessChest('<?php echo $readChest["id"]; ?>');" class="cursor-pointer bg-emerald-600 text-white py-1 px-2 rounded-xl">
                      <i class="fas fa-check text-sm"></i>
                    </a>
                    <div onclick="productGift('<?php echo $readChest["id"]; ?>', '<?php echo $readProduct["name"]; ?>');" class="cursor-pointer bg-pink-500/25 text-pink-500 py-1 px-2 rounded-xl">
                      <i class="fas fa-gift text-sm"></i>
                    </div>
                  </td>
                </tr>
                <?php } } } ?>
              </tbody>
            </table>
          </div>
          <?php } else { echo alert(languageVariables("alertNotProduct", "chest", $languageType), "danger", "0", "/"); } ?>
        </div>
      </div>
    </div>
    <div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="mt-10 card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-basket-shopping !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("chestHistory", "profile", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
            <?php $searchChestHistory->execute(array($readAccount["username"])); ?>
            <?php if ($searchChestHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">ID</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("product", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("transactions", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                  <?php foreach ($searchChestHistory as $readChestHistory) { ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3">#<?php echo $readChest["id"]; ?></td>
                    <td class="font-normal p-3 w-100"><?php echo $readChestHistory["productName"]; ?></td>
                    <?php if ($readChestHistory["username"] == $readAccount["username"]) { ?>
                    <?php $giftText = languageVariables("outComing", "words", $languageType).' -> '.$readChestHistory["usernameTo"]; ?>
                    <?php } else if ($readChestHistory["usernameTo"] == $readAccount["username"]) { ?>
                    <?php $giftText = languageVariables("inComing", "words", $languageType).' -> '.$readChestHistory["username"]; ?>
                    <?php } ?>
                    <td class="font-normal p-3"><?php echo (($readChestHistory["type"] == "0") ? languageVariables("receipt", "words", $languageType) : $giftText); ?></td>
                    <td class="font-normal p-3"><?php echo checkTime($readChestHistory["date"], 2, true); ?></td>
                    <td class="font-normal p-3 flex gap-3">
                      <?php if($readChestHistory["type"] == "0") { ?>
                      <i class="fas fa-check text-sm"></i>
                      <?php } else if($readChestHistory["type"] == "1") { ?>
                      <i class="fas fa-gift text-sm"></i>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "chest", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>