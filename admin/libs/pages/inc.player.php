<?php if (AccountPermControl($readAccount["id"], "player") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "account") { ?>
<?php if (AccountPermControl($readAccount["id"], "player_detail") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "player") { ?>
    <?php if (isset($_GET["username"])) { ?>
      <?php
        $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
        $searchPlayer->execute(array(get("username")));
        if (mysqlCount($searchPlayer) > 0) {
          $readPlayer = fetch($searchPlayer);
          $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
          $searchPlayerPermission->execute(array($readPlayer["permission"]));
          $readPlayerPermission = $searchPlayerPermission->fetch();
      ?>
      <?php if (get("proccess") == "all") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("players", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readPlayer["id"]."# ".$readPlayer["username"]; ?></li>
    </ol>
  </nav>
  <?php $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?"); ?>
  <?php $rowCountUserProduct->execute(array($readPlayer["id"], "0")); ?>
  <?php $rowCountUserProduct = mysqlCount($rowCountUserProduct); ?>
  <?php $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?"); ?>
  <?php $rowCountUserInvent->execute(array($readPlayer["id"])); ?>
  <?php $rowCountUserInvent = mysqlCount($rowCountUserInvent); ?>
  <?php $rowCountUserSupport = $db->prepare("SELECT * FROM supportList WHERE username = ?"); ?>
  <?php $rowCountUserSupport->execute(array($readPlayer["username"])); ?>
  <?php $rowCountUserSupport = mysqlCount($rowCountUserSupport); ?>
  <div class="profile-page tx-13">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="profile-header">
          <div class="cover">
            <div class="gray-shade"></div>
            <figure>
              <img src="<?php echo $readPlayer["imageAvatar"]; ?>" class="img-fluid" alt="profile cover" style="height: 200px;">
            </figure>
            <div class="cover-body d-flex justify-content-between align-items-center">
              <div>
                <img class="profile-pic" src="<?php echo avatarAPI($readPlayer["username"], 40); ?>" alt="profile">
                <span class="profile-name"><?php echo $readPlayer["username"]; ?></span>
              </div>
              <div class="d-md-block">
                <button type="button" class="btn btn-primary btn-icon-text btn-edit-profile" direct-element="direct" direct-href="<?php echo str_replace("&username", $readPlayer["username"], urlConverter("admin_player_edit", $languageType)); ?>">
                  <i data-feather="edit" class="btn-icon-prepend"></i> <?php echo languageVariables("edit", "words", $languageType); ?>
                </button>
              </div>
            </div>
          </div>
          <div class="header-links">
            <ul class="links d-flex align-items-center mt-3 mt-md-0">
              <li class="header-link-item d-flex align-items-center">
                <a class="pt-1px d-md-block" href="#"><?php echo languageVariables("chest", "words", $languageType); ?> (<?php echo $rowCountUserProduct; ?>)</a>
              </li>
              <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                <a class="pt-1px d-md-block" href="#"><?php echo languageVariables("inventory", "words", $languageType); ?> (<?php echo $rowCountUserInvent."/".$readPlayer["inventorySlot"]; ?>)</a>
              </li>
              <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                <a class="pt-1px d-md-block" href="#"><?php echo languageVariables("support", "words", $languageType); ?> (<?php echo $rowCountUserSupport; ?>)</a>
              </li>
              <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                <a class="pt-1px d-md-block" href="#"><?php echo languageVariables("credit", "words", $languageType); ?> (<?php echo $readPlayer["credit"]; ?>)</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row profile-body">
      <div class=" d-md-block col-md-4 col-xl-3 left-wrapper mb-4">
        <div class="card rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="card-title mb-0"><?php echo languageVariables("detail", "words", $languageType); ?></h6>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo str_replace("&username", $readPlayer["username"], urlConverter("admin_player_edit", $languageType)); ?>"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class=""><?php echo languageVariables("edit", "words", $languageType); ?></span></a>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>/<?php echo $readPlayer["id"]; ?>"><i data-feather="dollar-sign" class="icon-sm mr-2"></i> <span class=""><?php echo languageVariables("sendCredit", "words", $languageType); ?></span></a>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>/<?php echo $readPlayer["id"]; ?>"><i data-feather="archive" class="icon-sm mr-2"></i> <span class=""><?php echo languageVariables("sendIvent", "words", $languageType); ?></span></a>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>/<?php echo $readPlayer["id"]; ?>"><i data-feather="slash" class="icon-sm mr-2"></i> <span class=""><?php echo languageVariables("banned", "words", $languageType); ?></span></a>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo urlConverter("admin_player_delete", $languageType); ?>/<?php echo $readPlayer["id"]; ?>"><i data-feather="x" class="icon-sm mr-2"></i> <span class=""><?php echo languageVariables("remove", "words", $languageType); ?></span></a>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase"><?php echo languageVariables("username", "words", $languageType); ?>:</label>
              <p class="text-muted"><?php echo $readPlayer["username"]; ?></p>
            </div>
            <div class="mt-3">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase"><?php echo languageVariables("email", "words", $languageType); ?>:</label>
              <p class="text-muted"><?php echo $readPlayer["email"]; ?></p>
            </div>
            <div class="mt-3">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase"><?php echo languageVariables("permission", "words", $languageType); ?>:</label>
              <p class="text-muted">
                <span class="badge badge-pill mr-2" style="background-color: <?php echo $readPlayerPermission["permColorBG"]; ?>; color: <?php echo $readPlayerPermission["permColorText"]; ?>;" data-toggle="tooltip" title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readPlayerPermission["permName"]; ?></span>
              </p>
            </div>
            <div class="mt-3">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase"><?php echo languageVariables("registerDate", "words", $languageType); ?>:</label>
              <p class="text-muted"><?php echo checkTime($readPlayer["registerDate"], 2, true); ?></p>
            </div>
            <div class="mt-3">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase"><?php echo languageVariables("lastLogin", "words", $languageType); ?>:</label>
              <p class="text-muted"><?php if ($readPlayer["lastLogin"] == "Hiç giriş yapılmadı") { echo languageVariables("notLogin", "words", $languageType); } else { echo checkTime($readAccount["lastLogin"], 2, true); } ?></p>
            </div>
            <div class="mt-3 d-flex social-links">
              <a href="javascript:;" class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon text-primary">
                <i class="fab fa-discord" data-toggle="tooltip" title="<?php echo $readPlayer["discord"]; ?>"></i>
              </a>
              <a href="javascript:;" class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon text-info">
                <i class="fab fa-skype" data-toggle="tooltip" title="<?php echo $readPlayer["skype"]; ?>"></i>
              </a>
              <a href="<?php echo $readPlayer["instagram"]; ?>" target="_blank" class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon instagram">
                <i class="fab fa-instagram" data-toggle="tooltip" title="Instagram"></i>
              </a>
              <a href="<?php echo $readPlayer["twitter"]; ?>" target="_blank" class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon twitter">
                <i class="fab fa-twitter" data-toggle="tooltip" title="Twitter"></i>
              </a>
              <a href="<?php echo $readPlayer["youtube"]; ?>" target="_blank" class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon text-danger">
                <i class="fab fa-youtube" data-toggle="tooltip" title="Youtube"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php
      $searchUserChest = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ? ORDER BY id DESC");
      $searchUserChest->execute(array($readPlayer["id"], 0));
      $inventoryAscLimit = $readPlayer["inventorySlot"];
      $searchUserInventory = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ? ORDER BY id ASC LIMIT $inventoryAscLimit");
      $searchUserInventory->execute(array($readPlayer["id"]));
      $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE username = ? ORDER BY id DESC");
      $searchStoreHistory->execute(array($readPlayer["username"]));
      $searchCreditHistory = $db->prepare("SELECT * FROM creditHistory WHERE username = ? ORDER BY id DESC");
      $searchCreditHistory->execute(array($readPlayer["username"]));
      $searchChestHistory = $db->prepare("SELECT * FROM chestHistory WHERE username = ? ORDER BY id DESC");
      $searchChestHistory->execute(array($readPlayer["username"]));
      $searchCardHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE userID = ? ORDER BY id DESC");
      $searchCardHistory->execute(array($readPlayer["id"]));
      $searchCouponHistory = $db->prepare("SELECT * FROM couponHistory WHERE userID = ? ORDER BY id DESC");
      $searchCouponHistory->execute(array($readPlayer["id"]));
      $searchBannedHistory = $db->prepare("SELECT * FROM banned WHERE username = ? ORDER BY id DESC");
      $searchBannedHistory->execute(array($readPlayer["username"]));
      ?>
      <div class="col-md-8 col-xl-6 middle-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="card">
              <div class="card-header"><?php echo languageVariables("chest", "words", $languageType); ?> (<?php echo $rowCountUserProduct; ?>)</div>
              <div class="card-body p-0">
              <?php if (mysqlCount($searchUserChest) > 0) { ?>
                <div class="table-responsive" >
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("product", "words", $languageType); ?></a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                        <th class="text-right">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($searchUserChest as $readUserChest) { ?>
                    <?php $searchChestProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?>
                    <?php $searchChestProduct->execute(array($readUserChest["productID"])); ?>
                    <?php if (mysqlCount($searchChestProduct) > 0) { ?>
                    <?php $readChestProduct = fetch($searchChestProduct); ?>
                    <?php $searchChestCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
                    <?php $searchChestCategory->execute(array($readChestProduct["categoryID"])); ?>
                    <?php if (mysqlCount($searchChestCategory) > 0) { ?>
                    <?php $readChestCategory = fetch($searchChestCategory); ?>
                    <?php $searchChestServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                    <?php $searchChestServer->execute(array($readChestProduct["serverID"])); ?>
                    <?php if (mysqlCount($searchChestServer) > 0) { ?>
                    <?php $readChestServer = fetch($searchChestServer); ?>
                      <tr>
                        <td class=" text-center" style="width: 40px;">#<?php echo $readUserChest["id"]; ?></td>
                        <td class=" text-center"><?php echo $readChestProduct["name"]; ?></td>
                        <td class=" text-center"><?php echo $readChestCategory["name"]; ?></td>
                        <td class=" text-center"><?php echo $readChestServer["name"]; ?></td>
                        <td class=" text-center"><?php echo checkTime($readUserChest["date"]); ?></td>
                        <td class="text-right">
                          <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_chest_delete", $languageType); ?>/<?php echo $readUserChest["id"]; ?>/<?php echo $readPlayer["username"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                        </td>
                      </tr>
                    <?php } } } } ?>
                    </tbody>
                  </table>
                </div>
              <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertNotChest", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
              </div>
            </div>
          </div>
          <div class="col-md-12 grid-margin">
            <div class="card">
              <div class="card-header">Envanter (<?php echo $rowCountUserInvent."/".$readPlayer["inventorySlot"]; ?>)</div>
              <div class="card-body p-0">
              <?php if (mysqlCount($searchUserInventory) > 0) { ?>
                <div class="table-responsive" >
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("ivent", "words", $languageType); ?></a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("iventType", "words", $languageType); ?></a></th>
                        <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                        <th class="text-right">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($searchUserInventory as $readUserInventory) { ?>
                    <?php $inventoryData = json_decode($readUserInventory["variables"],true); ?>
                      <tr>
                        <td class=" text-center" style="width: 40px;">#<?php echo $readUserInventory["id"]; ?></td>
                        <?php if ($readUserInventory["type"] == "1") { ?>
                        <td class=" text-center"><?php echo $inventoryData["credit"]; ?> <?php echo languageVariables("credit", "words", $languageType); ?></td>
                        <td class=" text-center"><?php echo languageVariables("credit", "words", $languageType); ?></td>
                        <?php } else if ($readUserInventory["type"] == "2") { ?>
                        <?php
                        $searchInventoryProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                        $searchInventoryProduct->execute(array($inventoryData["productID"]));
                        $readInventoryProduct = fetch($searchInventoryProduct);
                        ?>
                        <td class=" text-center"><?php echo $readInventoryProduct["name"]; ?></td>
                        <td class=" text-center"><?php echo languageVariables("product", "words", $languageType); ?></td>
                        <?php } ?>
                        <td class=" text-center"><?php echo checkTime($readUserInventory["date"]); ?></td>
                        <td class="text-right">
                          <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_inventory_delete", $languageType); ?>/<?php echo $readUserInventory["id"]; ?>/<?php echo $readPlayer["username"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertNotInventory", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
              </div>
            </div>
          </div>
          <div class="col-md-12 grid-margin">
            <div class="card">
              <div class="card-body p-0">
                <nav>
                  <div class="nav nav-tabs nav-fill" id="nav-profile-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-chest-history-tab" data-toggle="tab" href="#nav-chest-history" role="tab" aria-controls="nav-chest-history" aria-selected="true"><?php echo languageVariables("chestHistory", "words", $languageType); ?></a>
                    <a class="nav-item nav-link" id="nav-store-history-tab" data-toggle="tab" href="#nav-store-history" role="tab" aria-controls="nav-store-history" aria-selected="false"><?php echo languageVariables("storeHistory", "words", $languageType); ?></a>
                    <a class="nav-item nav-link" id="nav-credit-history-tab" data-toggle="tab" href="#nav-credit-history" role="tab" aria-controls="nav-credit-history" aria-selected="false"><?php echo languageVariables("creditTransHistory", "words", $languageType); ?></a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-chest-history" role="tabpanel" aria-labelledby="nav-chest-history-tab">
                  <?php if (mysqlCount($searchChestHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("trans", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("product", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("productPrice", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchChestHistory as $readChestHistory) { ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readChestHistory["id"]; ?></td>
                            <td class=" text-center"><?php if ($readChestHistory["type"] == 0) { echo "<span class=\"fa fa-check\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("productCheck", "words", $languageType)."\"></span>"; } else { echo "<span class=\"fa fa-gift\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".str_replace("&username", $readChestHistory["usernameTo"], languageVariables("sendProductText", "player", $languageType))."\"></span>"; } ?></td>
                            <td class=" text-center"><?php echo $readChestHistory["productName"]; ?></td>
                            <td class=" text-center"><?php echo $readChestHistory["serverName"]; ?></td>
                            <td class=" text-center"><?php echo $readChestHistory["productPrice"]." ".languageVariables("credit", "words", $languageType); ?></td>
                            <td class=" text-center"><?php echo checkTime($readChestHistory["date"]); ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                  <div class="tab-pane fade" id="nav-store-history" role="tabpanel" aria-labelledby="nav-store-history-tab">
                  <?php if (mysqlCount($searchStoreHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("product", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("price", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
                        <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?>
                        <?php $searchProduct->execute(array($readStoreHistory["productID"])); ?>
                        <?php if (mysqlCount($searchProduct) > 0) { ?>
                        <?php $readProducts = fetch($searchProduct); ?>
                        <?php $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
                        <?php $searchCategory->execute(array($readProducts["categoryID"])); ?>
                        <?php if (mysqlCount($searchCategory) > 0) { ?>
                        <?php $readCategory = fetch($searchCategory); ?>
                        <?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                        <?php $searchServer->execute(array($readProducts["serverID"])); ?>
                        <?php if (mysqlCount($searchServer) > 0) { ?>
                        <?php $readServer = fetch($searchServer); ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readStoreHistory["id"]; ?></td>
                            <td class=" text-center"><?php echo $readProducts["name"]; ?></td>
                            <td class=" text-center"><?php echo $readCategory["name"]; ?></td>
                            <td class=" text-center"><?php echo $readServer["name"]; ?></td>
                            <td class=" text-center"><?php echo $readStoreHistory["productPrice"]; ?> <?php echo languageVariables("credit", "words", $languageType); ?></td>
                            <td class=" text-center"><?php echo checkTime($readStoreHistory["date"]); ?></td>
                          </tr>
                        <?php } } } } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                  <div class="tab-pane fade" id="nav-credit-history" role="tabpanel" aria-labelledby="nav-credit-history-tab">
                  <?php if (mysqlCount($searchCreditHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("method", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("amount", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("trans", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readCreditHistory["id"]; ?></td>
                            <td class=" text-center"><?php if ($readCreditHistory["type"] == 0) { if ($readCreditHistory["method"] == 0) { echo "<span class=\"fa fa-mobile\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("paymentMobile", "words", $languageType)."\"></span>"; } else { echo "<span class=\"far fa-credit-card\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("paymentCredit", "words", $languageType)."\"></span>"; } } else { echo "<span class=\"far fa-paper-plane\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".str_replace("&username", $readCreditHistory["usernameTo"], languageVariables("sendProductText", "player", $languageType))."\"></span>"; } ?></td>
                            <td class=" text-center"><?php echo $readCreditHistory["amount"]; ?></td>
                            <td class=" text-center"><?php if ($readCreditHistory["type"] == 0) { echo languageVariables("uploading", "words", $languageType); } else { echo languageVariables("sending", "words", $languageType); } ?></td>
                            <td class=" text-center"><?php echo checkTime($readCreditHistory["date"]); ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 grid-margin">
            <div class="card">
              <div class="card-body p-0">
                <nav>
                  <div class="nav nav-tabs nav-fill" id="nav-profile-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-card-game-history-tab" data-toggle="tab" href="#nav-card-game-history" role="tab" aria-controls="nav-card-game-history" aria-selected="true"><?php echo languageVariables("cardGameHistoryTitle", "player", $languageType); ?></a>
                    <a class="nav-item nav-link" id="nav-coupon-history-tab" data-toggle="tab" href="#nav-coupon-history" role="tab" aria-controls="nav-coupon-history" aria-selected="false"><?php echo languageVariables("giftCouponHistoryTitle", "player", $languageType); ?></a>
                    <a class="nav-item nav-link" id="nav-banned-history-tab" data-toggle="tab" href="#nav-banned-history" role="tab" aria-controls="nav-banned-history" aria-selected="false"><?php echo languageVariables("bannedHistoryTitle", "player", $languageType); ?></a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-card-game-history" role="tabpanel" aria-labelledby="nav-card-game-history-tab">
                  <?php if (mysqlCount($searchCardHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("reward", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("game", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("gameType", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("gamePriceHours", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchCardHistory as $readCardHistory) { ?>
                        <?php $searchCard = $db->prepare("SELECT * FROM cardGame WHERE id = ?"); ?>
                        <?php $searchCard->execute(array($readCardHistory["cardID"])); ?>
                        <?php $readCard = fetch($searchCard); ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readCardHistory["id"]; ?></td>
                            <td class=" text-center"><?php echo $readCardHistory["reward"]; ?></td>
                            <td class=" text-center"><?php echo $readCard["name"]; ?></td>
                            <td class=" text-center"><?php if ($readCard["type"] == "1") { echo languageVariables("paid", "words", $languageType); } else if ($readCard["type"] == "0") { echo languageVariables("free", "words", $languageType); } ?></td>
                            <td class=" text-center"><?php if ($readCard["type"] == "1") { echo $readCard["price"]." ".languageVariables("credit", "words", $languageType); } else if ($readCard["type"] == "0") { echo $readCard["hours"]." ".languageVariables("hours", "words", $languageType); } ?></td>
                            <td class=" text-center"><?php echo checkTime($readCardHistory["date"]); ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                  <div class="tab-pane fade" id="nav-coupon-history" role="tabpanel" aria-labelledby="nav-coupon-history-tab">
                  <?php if (mysqlCount($searchCouponHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("rewards", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("couponCode", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
                        <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
                        <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
                        <?php $readCoupon = $searchCoupon->fetch(); ?>
                        <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
                        <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
                        <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readCouponHistory["id"]; ?></td>
                            <td class=" text-center"><?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." "; } else { echo $readCouponItem["reward"]." ".languageVariables("credit", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?></td>
                            <td class=" text-center"><?php echo $readCoupon["code"]; ?></td>
                            <td class=" text-center"><?php echo checkTime($readCouponHistory["date"]); ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                  <div class="tab-pane fade" id="nav-banned-history" role="tabpanel" aria-labelledby="nav-banned-history-tab">
                  <?php if (mysqlCount($searchBannedHistory) > 0) { ?>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center" style="width: 40px;"><a href="#" class="text-muted">#ID</a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("reason", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("lastDuration", "words", $languageType); ?></a></th>
                            <th class="text-center"><a href="#" class="text-muted"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
                        <?php if ($readBannedHistory["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDate = languageVariables("indefinite", "words", $languageType); } else { if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) { $userBannedBackDate = max(round((strtotime($readBannedHistory["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } else { $userBannedBackDate = languageVariables("endBan", "words", $languageType); } } ?>
                          <tr>
                            <td class=" text-center" style="width: 40px;">#<?php echo $readBannedHistory["id"]; ?></td>
                            <td class=" text-center"><?php if ($readBannedHistory["type"] == "login") { echo languageVariables("site", "words", $languageType); } else if ($readBannedHistory["type"] == "support") { echo languageVariables("support", "words", $languageType); } else if ($readBannedHistory["type"] == "comment") { echo languageVariables("comment", "words", $languageType); } ?></td>
                            <td class=" text-center"><?php echo $readBannedHistory["reason"]; ?></td>
                            <td class=" text-center"><?php echo $userBannedBackDate; ?></td>
                            <td class=" text-center"><?php echo checkTime($readBannedHistory["date"]); ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } else { echo "<div class=\"p-4\">".alert(languageVariables("alertPartDataNone", "player", $languageType), "danger", "0", "/")."</div>"; } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else if (get("proccess") == "change") { ?>
<?php if (AccountPermControl($readAccount["id"], "player_update") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("players", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readPlayer["id"]."# ".$readPlayer["username"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("playersEditCardTitle", "player", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editPlayer"])) {
            if ($safeCsrfToken->validate('editPlayerToken')) {
              if (post("accountEditUsername") !== "" && post("accountEditCredit") !== "" && post("accountEditEmail") !== "") {
                $searchControlEmail = $db->prepare("SELECT * FROM accounts WHERE email = ?");
                $searchControlEmail->execute(array(post("accountEditEmail")));
                if (mysqlCount($searchControlEmail) == 0 || $readPlayer["email"] == post("accountEditEmail")) {
                  $searchControlUsername = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                  $searchControlUsername->execute(array(post("accountEditUsername")));
                  if (mysqlCount($searchControlUsername) == 0 || $readPlayer["username"] == post("accountEditUsername")) {
                    $passwordChangeStatus = true;
                    if (post("accountEditPassword") !== "") {
                      if (post("accountEditPasswordRe") !== "") {
                        if (post("accountEditPassword") == post("accountEditPasswordRe")) {
                          $updateAccountPassword = $db->prepare("UPDATE accounts SET password = ? WHERE id = ?");
                          $updateAccountPassword->execute(array(generateSHA256(post("accountEditPassword")), $readPlayer["id"]));
                        } else {
                          echo alert(languageVariables("alertPasswordNoRePassword", "player", $languageType), "danger", "0", "/");
                          $passwordChangeStatus = false;
                        }
                      } else {
                        echo alert(languageVariables("alertRePasswordNot", "player", $languageType), "danger", "0", "/");
                        $passwordChangeStatus = false;
                      }
                    }
                    if ($passwordChangeStatus == true) {
                      $updateAccount = $db->prepare("UPDATE accounts SET username = ?, realname = ?, email = ?, credit = ?, permission = ?, notificationStatus = ?, profileMessageStatus = ?, inventorySlot = ? WHERE id = ?");
                      $updateAccount->execute(array(post("accountEditUsername"), $_POST["accountEditUsername"], post("accountEditEmail"), post("accountEditCredit"), post("accountEditPermission"), post("accountEditNotifications"), post("accountEditMessages"), post("accountEditInventory"), $readPlayer["id"]));
                      echo alert(languageVariables("alertPlayerEditSuccess", "player", $languageType), "success", "3", "");
                    }
                  } else {
                    echo alert(languageVariables("alertPlayerAlreadyUsername", "player", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertPlayerAlreadyEmail", "player", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="player-account-edit-username" class="col-sm-3 col-form-label"><?php echo languageVariables("username", "words", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-account-edit-username" name="accountEditUsername" placeholder="<?php echo languageVariables("playerUsernamePlaceholder", "player", $languageType); ?>" value="<?php echo $readPlayer["realname"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-email" class="col-sm-3 col-form-label"><?php echo languageVariables("playerEmail", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="player-account-edit-email" name="accountEditEmail" placeholder="<?php echo languageVariables("playerEmailPlaceholder", "player", $languageType); ?>" value="<?php echo $readPlayer["email"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-password" class="col-sm-3 col-form-label"><?php echo languageVariables("playerPassword", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="player-account-edit-password" name="accountEditPassword" placeholder="<?php echo languageVariables("playerPasswordPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-password-re" class="col-sm-3 col-form-label"><?php echo languageVariables("playerRePassword", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="player-account-edit-password-re" name="accountEditPasswordRe" placeholder="<?php echo languageVariables("playerRePasswordPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-credit" class="col-sm-3 col-form-label"><?php echo languageVariables("playerCredit", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span class="fa fa-lira-sign"></span>
                    </div>
                  </div>
                  <input type="number" class="form-control" id="player-account-edit-credit" name="accountEditCredit" placeholder="<?php echo languageVariables("playerCreditPlaceholder", "player", $languageType); ?>" value="<?php echo $readPlayer["credit"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-permission" class="col-sm-3 col-form-label"><?php echo languageVariables("playerPermission", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-edit-permission" name="accountEditPermission">
                  <?php $searchPermissions = $db->query("SELECT * FROM accountsPermission ORDER BY id ASC"); ?>
                  <?php foreach ($searchPermissions as $readPermission) { ?>
                    <option value="<?php echo $readPermission["id"]; ?>" <?php echo (($readPlayer["permission"] == $readPermission["id"]) ? "selected" : ""); ?>><?php echo $readPermission["permName"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="store-extra-credit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("playerInventorySlot", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-edit-inventory" name="accountEditInventory">
                  <option value="12" <?php if ($readPlayer["inventorySlot"] == 12) { echo "selected"; } ?>>12 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="18" <?php if ($readPlayer["inventorySlot"] == 18) { echo "selected"; } ?>>18 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="24" <?php if ($readPlayer["inventorySlot"] == 24) { echo "selected"; } ?>>24 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="30" <?php if ($readPlayer["inventorySlot"] == 30) { echo "selected"; } ?>>30 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-notifications" class="col-sm-3 col-form-label"><?php echo languageVariables("playerNotifications", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-edit-notifications" name="accountEditNotifications">
                  <option value="0" <?php if ($readPlayer["notificationStatus"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readPlayer["notificationStatus"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-edit-messages" class="col-sm-3 col-form-label"><?php echo languageVariables("playerProfileMessage", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-edit-messages" name="accountEditMessages">
                  <option value="0" <?php if ($readPlayer["profileMessageStatus"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readPlayer["profileMessageStatus"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editPlayerToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editPlayer"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="button" class="btn btn-info btn-icon text-white" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
              <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("sendCredit", "words", $languageType); ?>"><i data-feather="dollar-sign"></i></button>
              <button type="button" class="btn btn-secondary btn-icon" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("sendIvent", "words", $languageType); ?>"><i data-feather="archive"></i></button>
              <button type="button" class="btn btn-warning btn-icon text-white" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("banned", "words", $languageType); ?>"><i data-feather="slash"></i></button>
              <button type="button" class="btn btn-danger btn-icon mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_delete", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="x"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } ?>
      <?php } else { go(urlConverter("admin_player", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("accounts", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchPlayers = $db->query("SELECT * FROM accounts ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("players", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchPlayers) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["accountsID", "accountsUsername", "accountsEmail", "accountsCredit", "accountsPermission", "accountsLastLogin", "accountsRegisterDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_player_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="accountsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsUsername"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsEmail"><?php echo languageVariables("email", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsCredit"><?php echo languageVariables("credit", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsPermission"><?php echo languageVariables("permission", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsLastLogin"><?php echo languageVariables("lastLogin", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsRegisterDate"><?php echo languageVariables("registerDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPlayers as $readPlayer) { ?>
               <?php 
                 $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
                 $searchPlayerPermission->execute(array($readPlayer["permission"]));
                 $readPlayerPermission = $searchPlayerPermission->fetch();
               ?>
                <tr>
                  <td class="accountsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>">#<?php echo $readPlayer["id"]; ?></a></td>
                  <td class="accountsUsername text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>"><?php echo $readPlayer["username"]; ?></a></td>
                  <td class="accountsEmail text-center"><?php echo $readPlayer["email"]; ?></td>
                  <td class="accountsCredit text-center"><?php echo $readPlayer["credit"]; ?></td>
                  <td class="accountsPermission text-center">
                    <span class="badge badge-pill mr-2" style="background-color: <?php echo $readPlayerPermission["permColorBG"]; ?>; color: <?php echo $readPlayerPermission["permColorText"]; ?>;" data-toggle="tooltip" title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readPlayerPermission["permName"]; ?></span>
                  </td>
                  <td class="accountsLastLogin text-center"><?php echo checkTime($readPlayer["lastLogin"]); ?></td>
                  <td class="accountsRegisterDate text-center"><?php echo checkTime($readPlayer["registerDate"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo str_replace("&username", $readPlayer["username"], urlConverter("admin_player_edit", $languageType)); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-primary btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i class="far fa-eye"></i></button>
                    <button type="button" class="btn btn-info btn-icon text-white" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("sendCredit", "words", $languageType); ?>"><i class="fas fa-dollar-sign"></i></button>
                    <button type="button" class="btn btn-secondary btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("sendIvent", "words", $languageType); ?>"><i class="fas fa-archive"></i></button>
                    <button type="button" class="btn btn-warning btn-icon text-white" direct-element="direct" direct-href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("banned", "words", $languageType); ?>"><i class="fas fa-minus-circle"></i></button>
                    <button type="button" class="btn btn-danger btn-icon mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_delete", $languageType); ?>/<?php echo $readPlayer["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageDataNone", "player", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "create") { ?>
<?php if (AccountPermControl($readAccount["id"], "player_add") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("playerAddCardTitle", "player", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["accountCreate"])) {
            if ($safeCsrfToken->validate('createAccountToken')) {
              if (post("accountCreateUsername") !== "" && post("accountCreateEmail") !== "" && post("accountCreatePassword") !== "" && post("accountCreatePasswordRe") !== "" && post("accountCreateCredit") !== "") {
                if (strlen(post("accountCreateUsername")) < 16) {
                  if (strlen(post("accountCreateUsername")) > 3) {
                    if (!usernameControl(post("accountCreateUsername"))) {
                      if (strstr(post("accountCreateEmail"), "@")) {
                        $searchControlEmail = $db->prepare("SELECT * FROM accounts WHERE email = ?");
                        $searchControlEmail->execute(array(post("accountCreateEmail")));
                        if (mysqlCount($searchControlEmail) == 0) {
                          $searchControlUsername = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                          $searchControlUsername->execute(array(post("accountCreateUsername")));
                          if (mysqlCount($searchControlUsername) == 0) {
                            if (post("accountCreatePassword") == post("accountCreatePasswordRe")) {
                              $password = generateSHA256(post("accountCreatePassword"));
                              $insertAccounts = $db->prepare("INSERT INTO accounts (username, realname, email, password, ip, permission, credit, registerDate, lastLogin, imageAvatar, discord, skype, twitter, instagram, youtube, totalCredit, notificationStatus, profileMessageStatus, inventorySlot) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                              $insertAccounts->execute(array(post("accountCreateUsername"), $_POST["accountCreateUsername"], post("accountCreateEmail"), $password, GetIP(), "0", "0", date("d.m.Y H:m"), "Hiç giriş yapılmadı", "/main/themes/south/libs/includes/images/avatar/default-background.png", "-", "-", "-", "-", "-", "0", post("accountCreateNotifications"), post("accountCreateMessages"), post("accountCreateInventory")));
                              echo alert(languageVariables("alertPlayerAddSuccess", "player", $languageType), "success", "3", urlConverter("admin_player", $languageType)."/".post("accountCreateUsername"));
                            } else {
                              echo alert(paslanguageVariables("alertPasswordNoRePassword", "player", $languageType), "danger", "0", "/");
                            }
                          } else {
                            echo alert(userlanguageVariables("alertPlayerAlreadyUsername", "player", $languageType), "danger", "0", "/");
                          }
                        } else {
                          echo alert(emaillanguageVariables("alertPlayerAlreadyEmail", "player", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertPlayerEmailNot", "player", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertPlayerUsername", "player", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertPlayerUsernameCharacter", "player", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertPlayerUsernameMax", "player", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="player-account-create-username" class="col-sm-3 col-form-label"><?php echo languageVariables("username", "words", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-account-create-username" name="accountCreateUsername" placeholder="<?php echo languageVariables("playerUsernamePlaceholder", "player", $languageType); ?>.">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-email" class="col-sm-3 col-form-label"><?php echo languageVariables("playerEmail", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="player-account-create-email" name="accountCreateEmail" placeholder="<?php echo languageVariables("playerEmailPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-password" class="col-sm-3 col-form-label"><?php echo languageVariables("playerPassword", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="player-account-edit-password" name="accountCreatePassword" placeholder="<?php echo languageVariables("playerPasswordPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-password-re" class="col-sm-3 col-form-label"><?php echo languageVariables("playerRePassword", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="player-account-create-password-re" name="accountCreatePasswordRe" placeholder="<?php echo languageVariables("playerRePasswordPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-credit" class="col-sm-3 col-form-label"><?php echo languageVariables("playerCredit", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span class="fa fa-lira-sign"></span>
                    </div>
                  </div>
                  <input type="number" class="form-control" id="player-account-create-credit" name="accountCreateCredit" placeholder="<?php echo languageVariables("playerCreditPlaceholder", "player", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-permission" class="col-sm-3 col-form-label"><?php echo languageVariables("playerPermission", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-create-permission" name="accountCreatePermission">
                  <?php $searchPermissions = $db->query("SELECT * FROM accountsPermission ORDER BY id ASC"); ?>
                  <?php foreach ($searchPermissions as $readPermission) { ?>
                    <option value="<?php echo $readPermission["id"]; ?>"><?php echo $readPermission["permName"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-inventory" class="col-sm-3 col-form-label"><?php echo languageVariables("playerInventorySlot", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-create-inventory" name="accountCreateInventory">
                  <option value="12">12 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="18">18 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="24">24 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                  <option value="30">30 <?php echo languageVariables("slot", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-notifications" class="col-sm-3 col-form-label"><?php echo languageVariables("playerNotifications", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-create-notifications" name="accountCreateNotifications">
                  <option value="0"><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-account-create-messages" class="col-sm-3 col-form-label"><?php echo languageVariables("playerProfileMessage", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-account-create-messages" name="accountCreateMessages">
                  <option value="0"><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("createAccountToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="accountCreate"><?php echo languageVariables("create", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "permissions") { ?>
  <?php if (AccountPermControl($readAccount["id"], "player_permissions") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php $searchPlayers = $db->query("SELECT id,username,email,credit,permission,lastLogin,registerDate FROM accounts WHERE permission != 1 ORDER BY id DESC"); ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("authorities", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchPlayers) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["accountsID", "accountsUsername", "accountsEmail", "accountsCredit", "accountsPermission", "accountsLastLogin", "accountsRegisterDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_player_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="accountsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsUsername"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsEmail"><?php echo languageVariables("email", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsCredit"><?php echo languageVariables("credit", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsPermission"><?php echo languageVariables("permission", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsLastLogin"><?php echo languageVariables("lastLogin", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="accountsRegisterDate"><?php echo languageVariables("registerDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPlayers as $readPlayer) { ?>
               <?php 
                 $searchPlayerPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
                 $searchPlayerPermission->execute(array($readPlayer["permission"]));
                 $readPlayerPermission = $searchPlayerPermission->fetch();
                 $permissionVariables = json_decode($readPlayerPermission["variables"], true);
                 if ($permissionVariables["panel_login"] == "TRUE") {
               ?>
                <tr>
                  <td class="accountsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>">#<?php echo $readPlayer["id"]; ?></a></td>
                  <td class="accountsUsername text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>"><?php echo $readPlayer["username"]; ?></a></td>
                  <td class="accountsEmail text-center"><?php echo $readPlayer["email"]; ?></td>
                  <td class="accountsCredit text-center"><?php echo $readPlayer["credit"]; ?></td>
                  <td class="accountsPermission text-center">
                    <span class="badge badge-pill mr-2" style="background-color: <?php echo $readPlayerPermission["permColorBG"]; ?>; color: <?php echo $readPlayerPermission["permColorText"]; ?>;" data-toggle="tooltip" title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readPlayerPermission["permName"]; ?></span>
                  </td>
                  <td class="accountsLastLogin text-center"><?php echo checkTime($readPlayer["lastLogin"]); ?></td>
                  <td class="accountsRegisterDate text-center"><?php echo checkTime($readPlayer["registerDate"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo str_replace("&username", $readPlayer["username"], urlConverter("admin_player_edit", $languageType)); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-primary btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPlayer["username"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                  </td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageDataNone", "player", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "remove") { ?>
  <?php if (AccountPermControl($readAccount["id"], "player_remove") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php
  $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE id = ?");
  $searchPlayer->execute(array(get("userID")));
  if (mysqlCount($searchPlayer) > 0) {
    $readPlayer = fetch($searchPlayer);
    $removeAccount = $db->prepare("DELETE FROM accounts WHERE id = ?");
    $removeAccount->execute(array($readPlayer["id"]));
    $removeAccountInventory = $db->prepare("DELETE FROM accountsInventory WHERE userID = ?");
    $removeAccountInventory->execute(array($readPlayer["id"]));
    $removeAccountMessages = $db->prepare("DELETE FROM accountsMessages WHERE userID = ? OR messageAuthorUsername = ?");
    $removeAccountMessages->execute(array($readPlayer["id"], $readPlayer["username"]));
    $removeAccountNotifications = $db->prepare("DELETE FROM accountsNotifications WHERE userID = ?");
    $removeAccountNotifications->execute(array($readPlayer["id"]));
    $removeAccountBanned = $db->prepare("DELETE FROM banned WHERE username = ?");
    $removeAccountBanned->execute(array($readPlayer["username"]));
    $removeAccountCardGameHistory = $db->prepare("DELETE FROM cardGameHistory WHERE userID = ?");
    $removeAccountCardGameHistory->execute(array($readPlayer["id"]));
    $removeAccountComments = $db->prepare("DELETE FROM comments WHERE username = ?");
    $removeAccountComments->execute(array($readPlayer["username"]));
    $removeAccountCreditHistory = $db->prepare("DELETE FROM creditHistory WHERE username = ?");
    $removeAccountCreditHistory->execute(array($readPlayer["username"]));
    $removeAccountStoreHistory = $db->prepare("DELETE FROM storeHistory WHERE username = ?");
    $removeAccountStoreHistory->execute(array($readPlayer["username"]));
    $removeAccountChest = $db->prepare("DELETE FROM userChest WHERE userID = ?");
    $removeAccountChest->execute(array($readPlayer["id"]));
    $removeAccountChestHistory = $db->prepare("DELETE FROM chestHistory WHERE username = ?");
    $removeAccountChestHistory->execute(array($readPlayer["username"]));
    $removeAccountShoppingCart = $db->prepare("DELETE FROM shoppingCart WHERE userID = ?");
    $removeAccountShoppingCart->execute(array($readPlayer["id"]));
  }
  go(urlConverter("admin_player", $languageType));
  ?>
  <?php } else if (get("target") == "chestRemove") { ?>
  <?php 
    $removeChestItem = $db->prepare("DELETE FROM userChest WHERE id = ?");
    $removeChestItem->execute(array(get("removeID")));
    go(urlConverter("admin_player", $languageType)."/".get("username"));
  ?>
  <?php } else if (get("target") == "inventoryRemove") { ?>
  <?php 
    $removeInventoryItem = $db->prepare("DELETE FROM accountsInventory WHERE id = ?");
    $removeInventoryItem->execute(array(get("removeID")));
    go(urlConverter("admin_player", $languageType)."/".get("username"));
  ?>
  <?php } ?>
<?php } else if (get("action") == "banned") { ?>
<?php if (AccountPermControl($readAccount["id"], "player_ban") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "create") { ?>
    <?php $activeUserType = false; ?>
    <?php if (isset($_GET["userID"])) { ?>
    <?php
    $searchBannedUser = $db->prepare("SELECT * FROM accounts WHERE id = ?");
    $searchBannedUser->execute(array(get("userID")));
    if (mysqlCount($searchBannedUser) > 0) {
      $readBannedUser = fetch($searchBannedUser);
      $activeUserType = true;
    } else {
      go(urlConverter("admin_player", $languageType));
    }
    ?>
    <?php } ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_banned_all", $languageType); ?>"><?php echo languageVariables("ban", "words", $languageType); ?></a></li>
      <?php if ($activeUserType == true) { ?>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readBannedUser["id"]."# ".$readBannedUser["username"]; ?></li>
      <?php } else { ?>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
      <?php } ?>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("banAddCardTitle", "player", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["bannedCreate"])) {
            if ($safeCsrfToken->validate('bannedCreateToken')) {
              if (post("bannedCreateUsername") !== "" && post("bannedCreateCategory") !== "" && post("bannedCreateReason") !== "" && (post("bannedCreateType") == "0" || post("bannedCreateDuration") > 0)) {
                $searchAccounts = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                $searchAccounts->execute(array(post("bannedCreateUsername")));
                if (mysqlCount($searchAccounts) > 0) {
                  $searchBanneds = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                  $searchBanneds->execute(array(post("bannedCreateUsername"), post("bannedCreateCategory"), date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                  if (mysqlCount($searchBanneds) == 0) {
                    if (post("bannedCreateType") == "0") {
                      $bannedDuration = "1000-01-01 00:00:00";
                    } else {
                      $bannedDuration = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + post("bannedCreateDuration") * 86400);
                    }
                    $insertBanned = $db->prepare("INSERT INTO banned (`username`,`type`, `bannedDate`, `reason`, `date`) VALUES (?,?,?,?,?)");
                    $insertBanned->execute(array(post("bannedCreateUsername"),post("bannedCreateCategory"),$bannedDuration,post("bannedCreateReason"),date("Y.m.d H:i:s")));
                    echo alert(str_replace("&username", post("bannedCreateUsername"), languageVariables("alertBannedAddSuccess", "player", $languageType)), "success", "3", urlConverter("admin_player_banned_all", $languageType));
                  } else {
                    echo alert(languageVariables("alertBannedCategoryAlready", "player", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertBannedNotUser", "player", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="player-banned-create-username" class="col-sm-3 col-form-label"><?php echo languageVariables("username", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-banned-create-username" name="bannedCreateUsername" placeholder="<?php echo languageVariables("playerUsernamePlaceholder", "player", $languageType); ?>" <?php if ($activeUserType == true) { ?>value="<?php echo $readBannedUser["username"]; ?>" readonly<?php } ?>>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-banned-create-category" class="col-sm-3 col-form-label"><?php echo languageVariables("category", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <select class="form-control" id="player-banned-create-category" name="bannedCreateCategory">
                  <option value="login" selected><?php echo languageVariables("site", "words", $languageType); ?></option>
                  <option value="support"><?php echo languageVariables("support", "words", $languageType); ?></option>
                  <option value="comment"><?php echo languageVariables("comment", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-banned-create-reason" class="col-sm-3 col-form-label"><?php echo languageVariables("reason", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <select class="form-control" id="player-banned-create-reason" name="bannedCreateReason">
                  <option value="<?php echo languageVariables("bannedReasonOption0", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption0", "player", $languageType); ?></option>
                  <option value="<?php echo languageVariables("bannedReasonOption1", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption1", "player", $languageType); ?></option>
                  <option value="<?php echo languageVariables("bannedReasonOption2", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption2", "player", $languageType); ?></option>
                  <option value="<?php echo languageVariables("bannedReasonOption3", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption3", "player", $languageType); ?></option>
                  <option value="<?php echo languageVariables("bannedReasonOption4", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption4", "player", $languageType); ?></option>
                  <option value="<?php echo languageVariables("bannedReasonOption5", "player", $languageType); ?>"><?php echo languageVariables("bannedReasonOption5", "player", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-banned-create-type" class="col-sm-3 col-form-label"><?php echo languageVariables("duration", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <select class="form-control" id="player-banned-create-type" name="bannedCreateType" data-toggle="bannedDurationStatus">
                  <option value="0"><?php echo languageVariables("indefinite", "words", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("temporary", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: none;" data-toggle="bannedDuration">
              <div class="form-group row">
                <label for="player-banned-create-value" class="col-sm-3 col-form-label"><?php echo languageVariables("bannedDurationTitle", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-clock"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="player-banned-create-value" name="bannedCreateDuration" placeholder="<?php echo languageVariables("bannedDurationPlaceholder", "player", $languageType); ?>">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("bannedCreateToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="bannedCreate"><?php echo languageVariables("banned", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("banned", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
    <?php
      if (get("category") == "web") {
        $searchBanned = $db->prepare("SELECT * FROM banned WHERE type = ? AND (bannedDate > ? OR bannedDate = ?) ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
        $searchBanned->execute(array("login", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
        $bannedType = languageVariables("site", "words", $languageType);
        $requestURLS = urlConverter("admin_player_banned_site_p", $languageType);
      } else if (get("category") == "support") {
        $searchBanned = $db->prepare("SELECT * FROM banned WHERE type = ? AND (bannedDate > ? OR bannedDate = ?) ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
        $searchBanned->execute(array("support", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
        $bannedType = languageVariables("support", "words", $languageType);
        $requestURLS = urlConverter("admin_player_banned_support_p", $languageType);
      } else if (get("category") == "comment") {
        $searchBanned = $db->prepare("SELECT * FROM banned WHERE type = ? AND (bannedDate > ? OR bannedDate = ?) ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
        $searchBanned->execute(array("comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
        $bannedType = languageVariables("comment", "words", $languageType);
        $requestURLS = urlConverter("admin_player_banned_comment_p", $languageType);
      } else if (get("category") == "all") {
        $searchBanned = $db->prepare("SELECT * FROM banned WHERE bannedDate > ? OR bannedDate = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
        $searchBanned->execute(array(date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
        $bannedType = languageVariables("all", "words", $languageType);
        $requestURLS = urlConverter("admin_player_banned_all_p", $languageType);
      }
    ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_banned_all", $languageType); ?>"><?php echo languageVariables("ban", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $bannedType; ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo $requestURLS."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo $requestURLS."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo $requestURLS."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchBanned) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["accountsID", "accountsUsername", "accountsEmail", "accountsCredit", "accountsPermission", "accountsLastLogin", "accountsRegisterDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="bannedID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="bannedUsername"><?php echo languageVariables("player", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="bannedCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="bannedReason"><?php echo languageVariables("reason", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="bannedDuration"><?php echo languageVariables("lastDuration", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="bannedDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchBanned as $readBanned) { ?>
               <?php
                 if ($readBanned["type"] == "login") {
                   $userBannedType = languageVariables("site", "words", $languageType);
                 } else if ($readBanned["type"] == "support") {
                   $userBannedType = languageVariables("support", "words", $languageType);
                 } else if ($readBanned["type"] == "comment") {
                   $userBannedType = languageVariables("comment", "words", $languageType);
                 }
                 if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") {
                   $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                 } else {
                   $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType);
                 }
                ?>
                <tr>
                  <td class="bannedID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readBanned["username"]; ?>">#<?php echo $readBanned["id"]; ?></a></td>
                  <td class="bannedUsername text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readBanned["username"]; ?>"><?php echo $readBanned["username"]; ?></a></td>
                  <td class="bannedCategory text-center"><?php echo $userBannedType; ?></td>
                  <td class="bannedReason text-center"><?php echo $readBanned["reason"]; ?></td>
                  <td class="bannedDuration text-center"><?php echo $userBannedBackDate; ?></td>
                  <td class="bannedDate text-center"><?php echo $readBanned["bannedDate"]; ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_banned_delete", $languageType); ?>/<?php echo $readBanned["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="x"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageDataNone", "player", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "remove" && isset($_GET["bannedID"])) { ?>
    <?php
      $removeBanned = $db->prepare("DELETE FROM banned WHERE id = ?");
      $removeBanned->execute(array(get("bannedID")));
      go(urlConverter("admin_player_banned_all", $languageType));

    ?>
  <?php } ?>
<?php } else if (get("action") == "permission") { ?>
<?php if (AccountPermControl($readAccount["id"], "player_perm") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "update") { ?>
    <?php if (isset($_GET["permID"])) { ?>
      <?php 
        $searchPermissions = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
        $searchPermissions->execute(array(get("permID")));
        if ($searchPermissions->rowCount() > 0) {
          $readPermission = $searchPermissions->fetch();
          $readPermissionVariables = json_decode($readPermission["variables"], true);
        } else {
          go(urlConverter("admin_player_permission_delete", $languageType));
        }
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_permission", $languageType); ?>"><?php echo languageVariables("permission", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readPermission["id"]."# ".$readPermission["permName"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("edit", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["permissionEdit"])) {
            if ($safeCsrfToken->validate('permissionEditToken')) {
              if (post("permissionEditName") !== "" && post("permissionEditBGColor") !== "" && post("permissionEditTextColor") !== "") {
                $permissionsVariables = json_encode(array(
                  "panel_login" => (post("permissionEditType") == "1") ? "TRUE" : "FALSE",
                  "maintance" => (post("permMaintance") == "1") ? "TRUE" : "FALSE",
                  "statistics" => (post("permStatistics") == "1") ? "TRUE" : "FALSE",
                  "forum" => (post("permForum") == "1") ? "TRUE" : "FALSE",
                  "store" => (post("permStore") == "1") ? "TRUE" : "FALSE",
                  "store_server" => (post("permStoreServer") == "1") ? "TRUE" : "FALSE",
                  "store_category" => (post("permStoreCategory") == "1") ? "TRUE" : "FALSE",
                  "store_product" => (post("permStoreProduct") == "1") ? "TRUE" : "FALSE",
                  "store_coupon" => (post("permStoreCoupon") == "1") ? "TRUE" : "FALSE",
                  "store_public" => (post("permStorePublic") == "1") ? "TRUE" : "FALSE",
                  "support" => (post("permSupport") == "1") ? "TRUE" : "FALSE",
                  "support_category" => (post("permSupportCategory") == "1") ? "TRUE" : "FALSE",
                  "support_answer" => (post("permSupportAnswer") == "1") ? "TRUE" : "FALSE",
                  "support_public" => (post("permSupportPublic") == "1") ? "TRUE" : "FALSE",
                  "public" => (post("permPublic") == "1") ? "TRUE" : "FALSE",
                  "public_news" => (post("permPublicNews") == "1") ? "TRUE" : "FALSE",
                  "public_news_category" => (post("permPublicNewsCategory") == "1") ? "TRUE" : "FALSE",
                  "public_broadcast" => (post("permPublicBroadcast") == "1") ? "TRUE" : "FALSE",
                  "public_page" => (post("permPublicPage") == "1") ? "TRUE" : "FALSE",
                  "player" => (post("permPlayer") == "1") ? "TRUE" : "FALSE",
                  "player_detail" => (post("permPlayerDetail") == "1") ? "TRUE" : "FALSE",
                  "player_update" => (post("permPlayerUpdate") == "1") ? "TRUE" : "FALSE",
                  "player_add" => (post("permPlayerAdd") == "1") ? "TRUE" : "FALSE",
                  "player_remove" => (post("permPlayerRemove") == "1") ? "TRUE" : "FALSE",
                  "player_permissions" => (post("permPlayerPermissions") == "1") ? "TRUE" : "FALSE",
                  "player_ban" => (post("permPlayerBan") == "1") ? "TRUE" : "FALSE",
                  "player_perm" => (post("permPlayerPermission") == "1") ? "TRUE" : "FALSE",
                  "settings" => (post("permSettings") == "1") ? "TRUE" : "FALSE",
                  "settings_public" => (post("permSettingsPublic") == "1") ? "TRUE" : "FALSE",
                  "settings_system" => (post("permSettingsSystem") == "1") ? "TRUE" : "FALSE",
                  "settings_smtp" => (post("permSettingsSMTP") == "1") ? "TRUE" : "FALSE",
                  "settings_payment" => (post("permSettingsPayment") == "1") ? "TRUE" : "FALSE",
                  "modules" => (post("permModules") == "1") ? "TRUE" : "FALSE",
                  "modules_card_game" => (post("permModulesCardGame") == "1") ? "TRUE" : "FALSE",
                  "modules_gift_coupon" => (post("permModulesCoupon") == "1") ? "TRUE" : "FALSE",
                  "modules_theme" => (post("permModulesTheme") == "1") ? "TRUE" : "FALSE",
                  "modules_webhooks" => (post("permModulesWebhooks") == "1") ? "TRUE" : "FALSE",
                  "modules_image" => (post("permModulesImage") == "1") ? "TRUE" : "FALSE",
                  "modules_module" => (post("permModulesModule") == "1") ? "TRUE" : "FALSE",
                  "modules_backups" => (post("permModulesBackups") == "1") ? "TRUE" : "FALSE",
                  "modules_lottery" => (post("permModulesLottery") == "1") ? "TRUE" : "FALSE",
                  "updates" => (post("permUpdates") == "1") ? "TRUE" : "FALSE"
                ));
                $updatePermission = $db->prepare("UPDATE accountsPermission SET permName = ?, variables = ?, permColorBG = ?, permColorText = ? WHERE id = ?");
                $updatePermission->execute(array(post("permissionEditName"), $permissionsVariables, post("permissionEditBGColor"), post("permissionEditTextColor"), $readPermission["id"]));
                echo alert(languageVariables("alertSaveChanges", "player", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="player-permission-edit-name" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionName", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-eidt-name" name="permissionEditName" placeholder="<?php echo languageVariables("permissionNamePlaceholder", "player", $languageType); ?>" value="<?php echo $readPermission["permName"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-edit-color-bg" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionBackgroundColor", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-edit-color-bg" name="permissionEditBGColor" placeholder="<?php echo languageVariables("permissionBackgroundColorPlaceholder", "player", $languageType); ?>" value="<?php echo $readPermission["permColorBG"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-edit-color-text" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionTextColor", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-edit-color-text" name="permissionEditTextColor" placeholder="<?php echo languageVariables("permissionTextColorPlaceholder", "player", $languageType); ?>" value="<?php echo $readPermission["permColorText"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-edit-perm" class="col-sm-3 col-form-label"><?php echo languageVariables("permDashboard", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-permission-edit-perm" name="permissionEditType" view-command="permissionView" view-code="permissions">
                  <option value="0" <?php echo (($readPermissionVariables["panel_login"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                  <option value="1" <?php echo (($readPermissionVariables["panel_login"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-edit-perm-maintance" class="col-sm-3 col-form-label"><?php echo languageVariables("permMaintance", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-permission-edit-perm-maintance" name="permMaintance">
                  <option value="0" <?php echo (($readPermissionVariables["maintance"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                  <option value="1" <?php echo (($readPermissionVariables["maintance"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div id="permissions" <?php echo (($readPermissionVariables["panel_login"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
              <div class="form-group row">
                <label for="player-permission-edit-perm-forum" class="col-sm-3 col-form-label"><?php echo languageVariables("forum", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-forum" name="permForum">
                    <option value="0" <?php echo (($readPermissionVariables["forum"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["forum"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-statistics" class="col-sm-3 col-form-label"><?php echo languageVariables("permStat", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-statistics" name="permStatistics">
                    <option value="0" <?php echo (($readPermissionVariables["statistics"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["statistics"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-updates" class="col-sm-3 col-form-label"><?php echo languageVariables("permUpdates", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-updates" name="permUpdates">
                    <option value="0" <?php echo (($readPermissionVariables["updates"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["updates"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-store" class="col-sm-3 col-form-label"><?php echo languageVariables("permStore", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-store" name="permStore" view-command="permissionView" view-code="permissionsStore">
                    <option value="0" <?php echo (($readPermissionVariables["store"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["store"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsStore" <?php echo (($readPermissionVariables["store"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-store-server" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreServer", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-store-server" name="permStoreServer">
                      <option value="0" <?php echo (($readPermissionVariables["store_server"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["store_server"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-store-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-store-category" name="permStoreCategory">
                      <option value="0" <?php echo (($readPermissionVariables["store_category"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["store_category"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-store-product" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreProduct", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-store-product" name="permStoreProduct">
                      <option value="0" <?php echo (($readPermissionVariables["store_product"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["store_product"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-store-coupon" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreCoupon", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-store-coupon" name="permStoreCoupon">
                      <option value="0" <?php echo (($readPermissionVariables["store_coupon"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["store_coupon"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-store-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-store-public" name="permStorePublic">
                      <option value="0" <?php echo (($readPermissionVariables["store_public"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["store_public"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-support" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupport", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-support" name="permSupport" view-command="permissionView" view-code="permissionsSupport">
                    <option value="0" <?php echo (($readPermissionVariables["support"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["support"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsSupport" <?php echo (($readPermissionVariables["support"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-support-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-support-category" name="permSupportCategory">
                      <option value="0" <?php echo (($readPermissionVariables["support_category"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["support_category"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-support-answer" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportReadyAnswer", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-support-answer" name="permSupportAnswer">
                      <option value="0" <?php echo (($readPermissionVariables["support_answer"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["support_answer"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-support-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-support-public" name="permSupportPublic">
                      <option value="0" <?php echo (($readPermissionVariables["support_public"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["support_public"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneral", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-public" name="permPublic" view-command="permissionView" view-code="permissionsPublic">
                    <option value="0" <?php echo (($readPermissionVariables["public"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["public"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsPublic" <?php echo (($readPermissionVariables["public"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-public-news" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralNews", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-public-news" name="permPublicNews">
                      <option value="0" <?php echo (($readPermissionVariables["public_news"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["public_news"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-public-news-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralNewsCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-public-news-category" name="permPublicNewsCategory">
                      <option value="0" <?php echo (($readPermissionVariables["public_news_category"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["public_news_category"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-public-broadcast" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralAnnouncement", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-public-broadcast" name="permPublicBroadcast">
                      <option value="0" <?php echo (($readPermissionVariables["public_broadcast"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["public_broadcast"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-public-page" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralPage", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-public-page" name="permPublicPage">
                      <option value="0" <?php echo (($readPermissionVariables["public_page"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["public_page"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-player" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayer", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-player" name="permPlayer" view-command="permissionView" view-code="permissionsPlayer">
                    <option value="0" <?php echo (($readPermissionVariables["player"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["player"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsPlayer" <?php echo (($readPermissionVariables["player"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-detail" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayers", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-detail" name="permPlayerDetail">
                      <option value="0" <?php echo (($readPermissionVariables["player_detail"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_detail"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-update" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayersEdit", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-update" name="permPlayerUpdate">
                      <option value="0" <?php echo (($readPermissionVariables["player_update"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_update"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-remove" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayersRemove", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-remove" name="permPlayerRemove">
                      <option value="0" <?php echo (($readPermissionVariables["player_remove"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_remove"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-add" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerAdd", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-add" name="permPlayerAdd">
                      <option value="0" <?php echo (($readPermissionVariables["player_add"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_add"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-permissions" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayerAuthorities", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-permissions" name="permPlayerPermissions">
                      <option value="0" <?php echo (($readPermissionVariables["player_permissions"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_permissions"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-ban" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerBanned", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-ban" name="permPlayerBan">
                      <option value="0" <?php echo (($readPermissionVariables["player_ban"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_ban"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-player-permission" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPermission", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-player-permission" name="permPlayerPermission">
                      <option value="0" <?php echo (($readPermissionVariables["player_perm"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["player_perm"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-settings" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettings", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-settings" name="permSettings" view-command="permissionView" view-code="permissionsSettings">
                    <option value="0" <?php echo (($readPermissionVariables["settings"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["settings"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsSettings" <?php echo (($readPermissionVariables["settings"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-settings-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-settings-public" name="permSettingsPublic">
                      <option value="0" <?php echo (($readPermissionVariables["settings_public"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["settings_public"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-settings-system" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsSystem", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-settings-system" name="permSettingsSystem">
                      <option value="0" <?php echo (($readPermissionVariables["settings_system"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["settings_system"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-settings-smtp" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsSmtp", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-settings-smtp" name="permSettingsSMTP">
                      <option value="0" <?php echo (($readPermissionVariables["settings_smtp"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["settings_smtp"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-settings-payment" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsPayment", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-settings-payment" name="permSettingsPayment">
                      <option value="0" <?php echo (($readPermissionVariables["settings_payment"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["settings_payment"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-edit-perm-modules" class="col-sm-3 col-form-label"><?php echo languageVariables("permModules", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-edit-perm-modules" name="permModules" view-command="permissionView" view-code="permissionsModules">
                    <option value="0" <?php echo (($readPermissionVariables["modules"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1" <?php echo (($readPermissionVariables["modules"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsModules" <?php echo (($readPermissionVariables["modules"] == "FALSE") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-cardgame" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesCardGame", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-cardgame" name="permModulesCardGame">
                      <option value="0" <?php echo (($readPermissionVariables["modules_card_game"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_card_game"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-coupon" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesGiftCoupon", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-coupon" name="permModulesCoupon">
                      <option value="0" <?php echo (($readPermissionVariables["modules_gift_coupon"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_gift_coupon"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-theme" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesTheme", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-theme" name="permModulesTheme">
                      <option value="0" <?php echo (($readPermissionVariables["modules_theme"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_theme"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-webhooks" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesWebhooks", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-webhooks" name="permModulesWebhooks">
                      <option value="0" <?php echo (($readPermissionVariables["modules_webhooks"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_webhooks"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-image" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesImage", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-image" name="permModulesImage">
                      <option value="0" <?php echo (($readPermissionVariables["modules_image"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_image"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-module" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesModule", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-module" name="permModulesModule">
                      <option value="0" <?php echo (($readPermissionVariables["modules_module"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_module"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-backups" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesBackups", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-backups" name="permModulesBackups">
                      <option value="0" <?php echo (($readPermissionVariables["modules_backups"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_backups"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-edit-perm-modules-lottery" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesLottery", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-edit-perm-modules-lottery" name="permModulesLottery">
                      <option value="0" <?php echo (($readPermissionVariables["modules_lottery"] == "FALSE") ? "selected" : ""); ?>><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1" <?php echo (($readPermissionVariables["modules_lottery"] == "TRUE") ? "selected" : ""); ?>><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("permissionEditToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="permissionEdit"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("accountsPermission", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchPermissions = $db->query("SELECT * FROM accountsPermission ORDER BY id ASC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_permissions", $languageType); ?>"><?php echo languageVariables("permission", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_permission_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_permission_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_player_permission_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchPermissions) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["permissionID", "permissionName", "permissionColorBG", "permissionColorText", "permissionDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_player_permission_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="permissionID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="permissionName"><?php echo languageVariables("permName", "player", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="permissionColorBG"><?php echo languageVariables("permBackgroundColor", "player", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="permissionColorText"><?php echo languageVariables("permTextColor", "player", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="permissionDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPermissions as $readPermission) { ?>
                <tr>
                  <td class="permissionID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player_permission", $languageType); ?>/<?php echo $readPermission["id"]; ?>">#<?php echo $readPermission["id"]; ?></a></td>
                  <td class="permissionName text-center"><span class="badge badge-pill mr-2" style="background-color: <?php echo $readPermission["permColorBG"]; ?>; color: <?php echo $readPermission["permColorText"]; ?>;" data-toggle="tooltip" title="<?php echo languageVariables("permission", "words", $languageType); ?>"><?php echo $readPermission["permName"]; ?></span></td>
                  <td class="permissionColorBG text-center"><?php echo $readPermission["permColorBG"]; ?></td>
                  <td class="permissionColorText text-center"><?php echo $readPermission["permColorText"]; ?></td>
                  <td class="permissionDate text-center"><?php echo checkTime($readPermission["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_player_permission", $languageType); ?>/<?php echo $readPermission["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <?php if ($readPermission["removeStatus"] == "1") { ?>
                    <button type="button" class="btn btn-danger btn-icon mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_player_permission_delete", $languageType); ?>/<?php echo $readPermission["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageDataNone", "player", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("player", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_player_permissions", $languageType); ?>"><?php echo languageVariables("permission", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("add", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["permissionAdd"])) {
            if ($safeCsrfToken->validate('permissionAddToken')) {
              if (post("permissionAddName") !== "" && post("permissionAddBGColor") !== "" && post("permissionAddTextColor") !== "") {
                $permissionsVariables = json_encode(array(
                  "panel_login" => (post("permissionAddType") == "1") ? "TRUE" : "FALSE",
                  "maintance" => (post("permMaintance") == "1") ? "TRUE" : "FALSE",
                  "statistics" => (post("permStatistics") == "1") ? "TRUE" : "FALSE",
                  "forum" => (post("permForum") == "1") ? "TRUE" : "FALSE",
                  "store" => (post("permStore") == "1") ? "TRUE" : "FALSE",
                  "store_server" => (post("permStoreServer") == "1") ? "TRUE" : "FALSE",
                  "store_category" => (post("permStoreCategory") == "1") ? "TRUE" : "FALSE",
                  "store_product" => (post("permStoreProduct") == "1") ? "TRUE" : "FALSE",
                  "store_coupon" => (post("permStoreCoupon") == "1") ? "TRUE" : "FALSE",
                  "store_public" => (post("permStorePublic") == "1") ? "TRUE" : "FALSE",
                  "support" => (post("permSupport") == "1") ? "TRUE" : "FALSE",
                  "support_category" => (post("permSupportCategory") == "1") ? "TRUE" : "FALSE",
                  "support_answer" => (post("permSupportAnswer") == "1") ? "TRUE" : "FALSE",
                  "support_public" => (post("permSupportPublic") == "1") ? "TRUE" : "FALSE",
                  "public" => (post("permPublic") == "1") ? "TRUE" : "FALSE",
                  "public_news" => (post("permPublicNews") == "1") ? "TRUE" : "FALSE",
                  "public_news_category" => (post("permPublicNewsCategory") == "1") ? "TRUE" : "FALSE",
                  "public_broadcast" => (post("permPublicBroadcast") == "1") ? "TRUE" : "FALSE",
                  "public_page" => (post("permPublicPage") == "1") ? "TRUE" : "FALSE",
                  "player" => (post("permPlayer") == "1") ? "TRUE" : "FALSE",
                  "player_detail" => (post("permPlayerDetail") == "1") ? "TRUE" : "FALSE",
                  "player_update" => (post("permPlayerUpdate") == "1") ? "TRUE" : "FALSE",
                  "player_add" => (post("permPlayerAdd") == "1") ? "TRUE" : "FALSE",
                  "player_remove" => (post("permPlayerRemove") == "1") ? "TRUE" : "FALSE",
                  "player_permissions" => (post("permPlayerPermissions") == "1") ? "TRUE" : "FALSE",
                  "player_ban" => (post("permPlayerBan") == "1") ? "TRUE" : "FALSE",
                  "player_perm" => (post("permPlayerPermission") == "1") ? "TRUE" : "FALSE",
                  "settings" => (post("permSettings") == "1") ? "TRUE" : "FALSE",
                  "settings_public" => (post("permSettingsPublic") == "1") ? "TRUE" : "FALSE",
                  "settings_system" => (post("permSettingsSystem") == "1") ? "TRUE" : "FALSE",
                  "settings_smtp" => (post("permSettingsSMTP") == "1") ? "TRUE" : "FALSE",
                  "settings_payment" => (post("permSettingsPayment") == "1") ? "TRUE" : "FALSE",
                  "modules" => (post("permModules") == "1") ? "TRUE" : "FALSE",
                  "modules_card_game" => (post("permModulesCardGame") == "1") ? "TRUE" : "FALSE",
                  "modules_gift_coupon" => (post("permModulesCoupon") == "1") ? "TRUE" : "FALSE",
                  "modules_theme" => (post("permModulesTheme") == "1") ? "TRUE" : "FALSE",
                  "modules_webhooks" => (post("permModulesWebhooks") == "1") ? "TRUE" : "FALSE",
                  "modules_image" => (post("permModulesImage") == "1") ? "TRUE" : "FALSE",
                  "modules_module" => (post("permModulesModule") == "1") ? "TRUE" : "FALSE",
                  "modules_backups" => (post("permModulesBackups") == "1") ? "TRUE" : "FALSE",
                  "modules_lottery" => (post("permModulesLottery") == "1") ? "TRUE" : "FALSE",
                  "updates" => (post("permUpdates") == "1") ? "TRUE" : "FALSE"
                ));
                $insertPermission = $db->prepare("INSERT INTO accountsPermission (`permName`, `variables`, `permColorBG`, `permColorText`, `removeStatus`, `date`) VALUES (?, ?, ?, ?, ?, ?)");
                $insertPermission->execute(array(post("permissionAddName"), $permissionsVariables, post("permissionAddBGColor"), post("permissionAddTextColor"), 1, date("d.m.Y H:i:s")));
                echo alert(languageVariables("alertPermAddSuccess", "player", $languageType), "success", "3", urlConverter("admin_player_permission_delete", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="player-permission-create-name" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionName", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-create-name" name="permissionAddName" placeholder="<?php echo languageVariables("permissionNamePlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-create-color-bg" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionBackgroundColor", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-create-color-bg" name="permissionAddBGColor" placeholder="<?php echo languageVariables("permissionBackgroundColorPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-create-color-text" class="col-sm-3 col-form-label"><?php echo languageVariables("permissionTextColor", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="player-permission-create-color-text" name="permissionAddTextColor" placeholder="<?php echo languageVariables("permissionTextColorPlaceholder", "player", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-create-perm" class="col-sm-3 col-form-label"><?php echo languageVariables("permDashboard", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-permission-create-perm" name="permissionAddType" view-command="permissionView" view-code="permissions">
                  <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="player-permission-create-perm-maintance" class="col-sm-3 col-form-label"><?php echo languageVariables("permMaintance", "player", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="player-permission-create-perm-maintance" name="permMaintance">
                  <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                  <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div id="permissions" style="display: none;">
              <div class="form-group row">
                <label for="player-permission-create-perm-forum" class="col-sm-3 col-form-label"><?php echo languageVariables("forum", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-forum" name="permForum">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-statistics" class="col-sm-3 col-form-label"><?php echo languageVariables("permStat", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-statistics" name="permStatistics">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-updates" class="col-sm-3 col-form-label"><?php echo languageVariables("permUpdates", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-updates" name="permUpdates">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-store" class="col-sm-3 col-form-label"><?php echo languageVariables("permStore", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-store" name="permStore" view-command="permissionView" view-code="permissionsStore">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsStore" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-store-server" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreServer", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-store-server" name="permStoreServer">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-store-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-store-category" name="permStoreCategory">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-store-product" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreProduct", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-store-product" name="permStoreProduct">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-store-coupon" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreCoupon", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-store-coupon" name="permStoreCoupon">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-store-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permStoreGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-store-public" name="permStorePublic">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-support" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupport", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-support" name="permSupport" view-command="permissionView" view-code="permissionsSupport">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsSupport" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-support-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-support-category" name="permSupportCategory">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-support-answer" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportReadyAnswer", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-support-answer" name="permSupportAnswer">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-support-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permSupportGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-support-public" name="permSupportPublic">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneral", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-public" name="permPublic" view-command="permissionView" view-code="permissionsPublic">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsPublic" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-public-news" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralNews", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-public-news" name="permPublicNews">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-public-news-category" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralNewsCategory", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-public-news-category" name="permPublicNewsCategory">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-public-broadcast" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralAnnouncement", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-public-broadcast" name="permPublicBroadcast">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-public-page" class="col-sm-3 col-form-label"><?php echo languageVariables("permGeneralPage", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-public-page" name="permPublicPage">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-player" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayer", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-player" name="permPlayer" view-command="permissionView" view-code="permissionsPlayer">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsPlayer" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-detail" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayers", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-detail" name="permPlayerDetail">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-update" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayersEdit", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-update" name="permPlayerUpdate">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-remove" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayersRemove", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-remove" name="permPlayerRemove">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-add" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerAdd", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-add" name="permPlayerAdd">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-permissions" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPlayerAuthorities", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-permissions" name="permPlayerPermissions">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-ban" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerBanned", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-ban" name="permPlayerBan">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-player-permission" class="col-sm-3 col-form-label"><?php echo languageVariables("permPlayerPermission", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-player-permission" name="permPlayerPermission">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-settings" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettings", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-settings" name="permSettings" view-command="permissionView" view-code="permissionsSettings">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsSettings" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-settings-public" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsGeneral", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-settings-public" name="permSettingsPublic">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-settings-system" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsSystem", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-settings-system" name="permSettingsSystem">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-settings-smtp" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsSmtp", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-settings-smtp" name="permSettingsSMTP">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-settings-payment" class="col-sm-3 col-form-label"><?php echo languageVariables("permSettingsPayment", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-settings-payment" name="permSettingsPayment">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="player-permission-create-perm-modules" class="col-sm-3 col-form-label"><?php echo languageVariables("permModules", "player", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="player-permission-create-perm-modules" name="permModules" view-command="permissionView" view-code="permissionsModules">
                    <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div id="permissionsModules" style="display: none;">
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-cardgame" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesCardGame", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-cardgame" name="permModulesCardGame">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-coupon" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesGiftCoupon", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-coupon" name="permModulesCoupon">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-theme" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesTheme", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-theme" name="permModulesTheme">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-webhooks" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesWebhooks", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-webhooks" name="permModulesWebhooks">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-image" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesImage", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-image" name="permModulesImage">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-module" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesModule", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-module" name="permModulesModule">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-backups" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesBackups", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-backups" name="permModulesBackups">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="player-permission-create-perm-modules-lottery" class="col-sm-3 col-form-label"><?php echo languageVariables("permModulesLottery", "player", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="player-permission-create-perm-modules-lottery" name="permModulesLottery">
                      <option value="0"><?php echo languageVariables("permFalse", "player", $languageType); ?></option>
                      <option value="1"><?php echo languageVariables("permTrue", "player", $languageType); ?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("permissionAddToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="permissionAdd"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "remove") { ?>
    <?php 
        $searchPermissions = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
        $searchPermissions->execute(array(get("permID")));
        if ($searchPermissions->rowCount() > 0) {
          $readPermission = $searchPermissions->fetch();
          if ($readPermission["removeStatus"] == "1") {
            $deletePerm = $db->prepare("DELETE FROM accountsPermission WHERE id = ?");
            $deletePerm->execute(array($readPermission["id"]));
            go(urlConverter("admin_player_permission_delete", $languageType));
          } else {
            go(urlConverter("admin_player_permission_delete", $languageType));
          }
        } else {
          go(urlConverter("admin_player_permission_delete", $languageType));
        }
      ?>
  <?php } ?>
<?php } ?>