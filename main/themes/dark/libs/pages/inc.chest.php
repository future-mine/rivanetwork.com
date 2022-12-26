<?php
AccountLoginControl(false);
$searchUserChest = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
$searchUserChest->execute(array($readAccount["id"], 0));
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" href="#" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("chest", "words", $languageType); ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <strong><?php echo languageVariables("chest", "words", $languageType); ?></strong> - <?php echo $searchUserChest->rowCount(); ?>
              </h3>
              <?php if ($searchUserChest->rowCount() > 0) { ?>
              <div class="overflow-auto">
              <table class="default-table w-100 table table-hover mb-0">
                <thead class="bg-dark--5">
                  <tr class="text-secondary font-size-6">
                    <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">#</th>
                    <th class="font-100 p-3 line-height-1 w-40 border-0"><?php echo languageVariables("product", "words", $languageType); ?></th>
                    <th class="font-100 p-3 line-height-1 w-20 border-0"><?php echo languageVariables("server", "words", $languageType); ?></th>
                    <th class="font-100 p-3 line-height-1 w-30 border-0"><?php echo languageVariables("date", "words", $languageType); ?></th>
                    <th class="p-3 pr-4 w-20 border-0"></th>
                  </tr>
                </thead>
                <tbody class="bg-dark--4">
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
                  <tr class="text-white font-size-7">
                    <td class="p-3 border-bottom font-100 pl-4 line-height-1 w-10 o-25">
                      #<?php echo $readChest["id"]; ?> </td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-45 text-nowrap text-truncate">
                      <?php echo $readProduct["name"]; ?> </td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-20 text-nowrap text-truncate">
                      <?php echo $readServer["name"]; ?> </td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-3 o-25">
                      <?php echo checkTime($readChest["date"], 2, true); ?> </td>
                    <td class="p-3 border-bottom font-100 pr-4 line-height-1 w-20 text-right">
                      <button type="button" class="btn btn-success btn-circle p-0 line-height-1" onclick="proccessChest('<?php echo $readChest["id"]; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("takeDelivery", "words", $languageType); ?>"> <i class="fas fa-check text-success fa-sm"></i>
                      </button>

                      <button type="button" title="<?php echo languageVariables("giveGift", "words", $languageType); ?>" onclick="productGift('<?php echo $readChest["id"]; ?>', '<?php echo $readProduct["name"]; ?>');" class="p-0 ml-2 line-height-1">
                        <i class="fas fa-gift text-white fa-sm"></i>
                      </button>
                    </td>
                  </tr>
                  <?php
                        }
                      } else {
                        $deleteChest = $db->prepare("DELETE FROM userChest WHERE productID = ?");
                        $deleteChest->execute(array($readChest["productID"]));
                      }
                    }
                  ?>
                </tbody>
              </table>
              </div>
              <?php } else { echo alert(languageVariables("alertNotProduct", "chest", $languageType), "warning", "0", "/"); } ?>
            </div>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <div class="sidebar bg-dark--3 p-5 mb-3">
                <h2 class="text-white font-size-9 col-12 p-0 mb-3">
                  <span class="font-800">
                    <?php echo languageVariables("chest", "words", $languageType); ?>
                  </span>
                  <span class="font-100">
                    <?php echo languageVariables("historyd", "words", $languageType); ?>
                  </span>
                </h2>
                <?php $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC LIMIT 6"); ?>
                <?php $searchChestHistory->execute(array($readAccount["username"])); ?>
                <?php if ($searchChestHistory->rowCount() > 0) { ?>
                <ul class="navbar-nav sidebar-nav">
                  <?php foreach ($searchChestHistory as $readChestHistory) { ?>
                  <?php if($readChestHistory["type"] == "0") { ?>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="#" class="nav-link py-0 pt-3 pl-4 font-100 text-white d-flex align-items-center justify-content-between w-100 position-relative">
                      <div class="mb-3">
                        <span class="nav-link-text"><?php echo $readChestHistory["productName"]; ?></span>
                        <span class="font-size-6 d-block o-25 mt-n1 position-relative">
                          <?php echo languageVariables("receipt", "words", $languageType); ?>
                        </span>
                      </div>
                      <div class="sidebar-absolute-icon">
                        <i class="fas fa-check text-success js-mirror"></i>
                      </div>
                    </a>
                  </li>
                  <?php } else if($readChestHistory["type"] == "1") { ?>
                  <li class="nav-item bg-dark--2 mb-2">
                    <a href="#" class="nav-link py-0 pt-3 pl-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                      <div class="mb-3">
                        <span class="nav-link-text"><?php echo $readChestHistory["productName"]; ?></span>
                        <span class="font-size-6 d-block o-25 mt-n1 position-relative">
                          <?php if ($readChestHistory["username"] == $readAccount["username"]) { ?>
                          <i class="fas fa-arrow-right fa-xs text-secondary"></i> <?php echo $readChestHistory["usernameTo"]; ?>
                          <?php } else if ($readChestHistory["usernameTo"] == $readAccount["username"]) { ?>
                          <i class="fas fa-arrow-left fa-xs text-secondary"></i> <?php echo $readChestHistory["username"]; ?>
                          <?php } ?>
                        </span>
                      </div>
                      <div class="sidebar-absolute-icon">
                        <i class="fas fa-gift text-primary js-mirror"></i>
                      </div>
                    </a>
                  </li>
                  <?php } } ?>
                </ul>
                <?php } else { echo alert(languageVariables("alertNotHistory", "chest", $languageType), "danger", "0", "/"); } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>