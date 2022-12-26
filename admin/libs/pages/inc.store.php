<?php if (AccountPermControl($readAccount["id"], "store") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "server") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_server") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_server", $languageType); ?>"><?php echo languageVariables("server", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("serverAddCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addServer"])) {
            if ($safeCsrfToken->validate('addServerToken')) {
              if (post("serverAddTitle") !== "" && post("serverAddIP") !== "" && post("serverAddConnectPort") !== "" && post("serverAddConnectPassword") !== "" && $_FILES["serverAddImage"] !== "") {
                if ($_FILES["serverAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["serverAddImage"], "/assets/uploads/images/store/server/");
                  if ($imageUpload !== false) {
                    $insertServer = $db->prepare("INSERT INTO serverList (`name`, `status`, `image`, `connectIP`, `connectPort`, `connectPassword`, `connectType`) VALUES (?,?,?,?,?,?,?)");
                    $insertServer->execute(array(post("serverAddTitle"), post("serverAddStatus"), "/assets/uploads/images/store/server/".$imageUpload["name"], post("serverAddIP"), post("serverAddConnectPort"), post("serverAddConnectPassword"), post("serverAddConnectType")));
                    echo alert(languageVariables("alertServerAddSuccess", "store", $languageType), "success", "3", urlConverter("admin_store_server", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-server-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("serverTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-add-title" name="serverAddTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-server-add-status" name="serverAddStatus">
                    <option value="1"><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="2"><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="0"><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-ip" class="col-sm-3 col-form-label"><?php echo languageVariables("serverIP", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-add-ip" data-toggle="connectIP" name="serverAddIP" placeholder="<?php echo languageVariables("serverIPPlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-connect-type" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-server-add-connect-type" data-toggle="connectType" name="serverAddConnectType">
                    <option value="websend">Websend</option>
                    <option value="websender">Websender</option>
                    <option value="rcon">RCON</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-connect-port" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectPort", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="store-server-add-connect-pass" data-toggle="connectPort" name="serverAddConnectPort" placeholder="<?php echo languageVariables("consoleConnectPortPlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-connect-pass" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectPassword", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-add-connect-pass" data-toggle="connectPassword" name="serverAddConnectPassword" placeholder="<?php echo languageVariables("consoleConnectPasswordPlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-add-connect-pass" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-server-add-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-server-add-image" name="serverAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertServerControlSuccess", "store", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertServerControlFail", "store", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addServerToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addServer"><?php echo languageVariables("add", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="serverConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["serverID"])) { ?>
      <?php
      $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
      $searchServer->execute(array(get("serverID")));
      if (mysqlCount($searchServer) > 0) {
        $readServer = fetch($searchServer);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_server", $languageType); ?>"><?php echo languageVariables("server", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readServer["id"]."# ".$readServer["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("serverEditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editServer"])) {
            if ($safeCsrfToken->validate('editServerToken')) {
              if (post("serverEditTitle") !== "" && post("serverEditIP") !== "" && post("serverEditConnectPort") !== "" && post("serverEditConnectPassword") !== "" && $_FILES["serverEditImage"] !== "") {
                if ($_FILES["serverEditImage"]["name"] != null) {
                  $imageUpload = imageUpload($_FILES["serverEditImage"], "/assets/uploads/images/store/server/");
                  if ($imageUpload !== false) {
                    $updateServer = $db->prepare("UPDATE serverList SET name = ?, status = ?, image = ?, connectIP = ?, connectPort = ?, connectPassword = ?, connectType = ? WHERE id = ?");
                    $updateServer->execute(array(post("serverEditTitle"), post("serverEditStatus"), "/assets/uploads/images/store/server/".$imageUpload["name"], post("serverEditIP"), post("serverEditConnectPort"), post("serverEditConnectPassword"), post("serverEditConnectType"), $readServer["id"]));
                    echo alert(languageVariables("alertServerEditSuccess", "store", $languageType), "success", "3", "");
                  } else {
                    echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  $updateServer = $db->prepare("UPDATE serverList SET name = ?, status = ?, connectIP = ?, connectPort = ?, connectPassword = ?, connectType = ? WHERE id = ?");
                  $updateServer->execute(array(post("serverEditTitle"), post("serverEditStatus"), post("serverEditIP"), post("serverEditConnectPort"), post("serverEditConnectPassword"), post("serverEditConnectType"), $readServer["id"]));
                  echo alert(languageVariables("alertServerEditSuccess", "store", $languageType), "success", "3", "");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-server-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("serverTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-edit-title" name="serverEditTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>" value="<?php echo $readServer["name"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-server-edit-status" name="serverEditStatus">
                    <option value="1" <?php echo (($readServer["status"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="2" <?php echo (($readServer["status"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="0" <?php echo (($readServer["status"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-ip" class="col-sm-3 col-form-label"><?php echo languageVariables("serverIP", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-edit-ip" data-toggle="connectIP" name="serverEditIP" placeholder="<?php echo languageVariables("serverIPPlaceholder", "store", $languageType); ?>" value="<?php echo $readServer["connectIP"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-connect-type" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-server-edit-connect-type" data-toggle="connectType" name="serverEditConnectType">
                    <option value="websend" <?php if ($readServer["connectType"] == "websend") { echo "selected"; } ?>>Websend</option>
                    <option value="websender" <?php if ($readServer["connectType"] == "websender") { echo "selected"; } ?>>Websender</option>
                    <option value="rcon" <?php if ($readServer["connectType"] == "rcon") { echo "selected"; } ?>>RCON</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-connect-port" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectPort", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="store-server-edit-connect-port" data-toggle="connectPort" name="serverEditConnectPort" placeholder="<?php echo languageVariables("consoleConnectPortPlaceholder", "store", $languageType); ?>" value="<?php echo $readServer["connectPort"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-connect-pass" class="col-sm-3 col-form-label"><?php echo languageVariables("consoleConnectPassword", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-server-edit-connect-pass" data-toggle="connectPassword" name="serverEditConnectPassword" placeholder="<?php echo languageVariables("consoleConnectPasswordPlaceholder", "store", $languageType); ?>" value="<?php echo $readServer["connectPassword"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-server-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readServer["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-server-edit-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-server-edit-image" name="serverEditImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div id="connectAlertSuccess" style="display: none;">
                <div class="alert alert-icon-success" role="alert">
                  <i data-feather="disc"></i>
                  <?php echo languageVariables("alertServerControlSuccess", "store", $languageType); ?>
                </div>
              </div>
              <div id="connectAlertError" style="display: none;">
                <div class="alert alert-icon-danger" role="alert">
                  <i data-feather="x-circle"></i>
                  <?php echo languageVariables("alertServerControlFail", "store", $languageType); ?>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editServerToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editServer"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_server_delete", $languageType); ?>/<?php echo $readServer["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
                <button type="button" class="btn btn-light" id="serverConnectControl"><?php echo languageVariables("control", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
      <?php } else { go(urlConverter("admin_store_server", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("serverList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_server", $languageType); ?>"><?php echo languageVariables("server", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_server_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_server_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_server_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchServers) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["serversID", "serversTitle", "serversIP", "serversStatus", "serversConnectType", "serversConnectPort", "serversEarn", "serversEarnMonth"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_store_server_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="serverID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversTitle"><?php echo languageVariables("tableServerTitle", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversStatus"><?php echo languageVariables("tableViews", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversIP"><?php echo languageVariables("tableServerIP", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversConnectType"><?php echo languageVariables("tableConsoleType", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversConnectPort"><?php echo languageVariables("tableConsolePort", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversEarn"><?php echo languageVariables("tableTotalSales", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="serversEarnMonth"><?php echo languageVariables("tableTotalMonthSales", "store", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchServers as $readServers) { ?>
               <?php 
               $readServersEarn = 0;
               $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE serverID = ? ORDER BY id DESC");
               $searchStoreHistory->execute(array($readServers["id"]));
               foreach ($searchStoreHistory as $readStoreHistory) {
                 $readServersEarn += $readStoreHistory["productPrice"];
               }
               $readServersEarnMonth = 0;
               $searchStoreHistoryMonth = $db->prepare("SELECT * FROM storeHistory WHERE serverID = ? AND date LIKE ? ORDER BY id DESC");
               $searchStoreHistoryMonth->execute(array($readServers["id"], "%".date("m.Y")."%"));
               foreach ($searchStoreHistoryMonth as $readStoreHistoryMonth) {
                 $readServersEarnMonth += $readStoreHistoryMonth["productPrice"];
               }
               ?>
                <tr>
                  <td class="serversID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_server", $languageType); ?>/<?php echo $readServers["id"]; ?>">#<?php echo $readServers["id"]; ?></a></td>
                  <td class="serversTitle text-center"><a href="<?php echo urlConverter("admin_store_server", $languageType); ?>/<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></a></td>
                  <td class="serversStatus text-center"><?php if ($readServers["status"] == "0") { echo languageVariables("viewPrivate", "store", $languageType); } else if ($readServers["status"] == "1") { echo languageVariables("viewEveryone", "store", $languageType); } else { echo languageVariables("viewUrl", "store", $languageType); } ?></td>
                  <td class="serversIP text-center"><?php echo $readServers["connectIP"]; ?></td>
                  <td class="serversConnectType text-center" style="text-transform: capitalize;"><?php echo $readServers["connectType"]; ?></td>
                  <td class="serversConnectPort text-center"><?php echo $readServers["connectPort"]; ?></td>
                  <td class="serversEarn text-center"><?php echo $readServersEarn." ".languageVariables("currency", "words", $languageType); ?></td>
                  <td class="serversEarn text-center"><?php echo $readServersEarnMonth." ".languageVariables("currency", "words", $languageType); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_server", $languageType); ?>/<?php echo $readServers["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_server_delete", $languageType); ?>/<?php echo $readServers["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["serverID"])) { ?>
    <?php
    $removeServer = $db->prepare("DELETE FROM serverList WHERE id = ?");
    $removeServer->execute(array(get("serverID")));
    $removeCategory = $db->prepare("DELETE FROM serverCategory WHERE serverID = ?");
    $removeCategory->execute(array(get("serverID")));
    $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?");
    $searchProduct->execute(array(get("serverID")));
    foreach ($searchProduct as $readProduct) {
      $removeProductPosters = $db->prepare("DELETE FROM productPosters WHERE productID = ?");
      $removeProductPosters->execute(array($readProduct["id"]));
    }
    $removeProduct = $db->prepare("DELETE FROM categoryProduct WHERE serverID = ?");
    $removeProduct->execute(array(get("serverID")));
    go(urlConverter("admin_store_server", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_store_server", $languageType)); } ?>
<?php } else if (get("action") == "category") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_category") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryAddCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addCategory"])) {
            if ($safeCsrfToken->validate('addCategoryToken')) {
              if (post("categoryAddTitle") !== "" && $_FILES["categoryAddImage"] !== "" && post("categoryAddServer") > 0) {
                if ($_FILES["categoryAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["categoryAddImage"], "/assets/uploads/images/store/category/");
                  if ($imageUpload !== false) {
                    $insertCategory = $db->prepare("INSERT INTO serverCategory (`name`, `status`, `image`, `serverID`) VALUES (?,?,?,?)");
                    $insertCategory->execute(array(post("categoryAddTitle"), post("categoryAddStatus"), "/assets/uploads/images/store/category/".$imageUpload["name"], post("categoryAddServer")));
                    echo alert(languageVariables("alertCategoryAddSuccess", "store", $languageType), "success", "3", urlConverter("admin_store_category", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-category-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-category-add-title" name="categoryAddTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-add-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-category-add-status" name="categoryAddStatus">
                    <option value="1"><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="2"><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="0"><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-add-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-category-add-server" name="categoryAddServer">
                  <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                  <?php if (mysqlCount($searchServers) > 0) { ?>
                  <?php foreach ($searchServers as $readServers) { ?>
                    <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-add-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-category-add-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-category-add-image" name="categoryAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addCategoryToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addCategory"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["categoryID"])) { ?>
      <?php
      $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?");
      $searchCategory->execute(array(get("categoryID")));
      if (mysqlCount($searchCategory) > 0) {
        $readCategory = fetch($searchCategory);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCategory["id"]."# ".$readCategory["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryEditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editCategory"])) {
            if ($safeCsrfToken->validate('editCategoryToken')) {
              if (post("categoryEditTitle") !== "" && $_FILES["categoryEditImage"] !== "" && post("categoryEditServer") > 0) {
                if ($_FILES["categoryEditImage"]["name"] != null) {
                  $imageUpload = imageUpload($_FILES["categoryEditImage"], "/assets/uploads/images/store/category/");
                  if ($imageUpload !== false) {
                    $updateCategory = $db->prepare("UPDATE serverCategory SET name = ?, status = ?, image = ?, serverID = ? WHERE id = ?");
                    $updateCategory->execute(array(post("categoryEditTitle"), post("categoryEditStatus"), "/assets/uploads/images/store/category/".$imageUpload["name"], post("categoryEditServer"), $readCategory["id"]));
                    if ($readCategory["serverID"] !== post("categoryEditServer")) {
                      $updateCategoryProduct = $db->prepare("UPDATE categoryProduct SET serverID = ? WHERE categoryID = ?");
                      $updateCategoryProduct->execute(array(post("categoryEditServer"), $readCategory["id"]));
                    }
                    echo alert(languageVariables("alertCategoryEditSuccess", "store", $languageType), "success", "3", "");
                  } else {
                    echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  $updateCategory = $db->prepare("UPDATE serverCategory SET name = ?, status = ?, serverID = ? WHERE id = ?");
                  $updateCategory->execute(array(post("categoryEditTitle"), post("categoryEditStatus"), post("categoryEditServer"), $readCategory["id"]));
                  if ($readCategory["serverID"] !== post("categoryEditServer")) {
                    $searchCategoryProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?");
                    $searchCategoryProduct->execute(array($readCategory["id"]));
                    foreach ($searchCategoryProduct as $readCategoryProduct) {
                      $updateCategoryProduct = $db->prepare("UPDATE categoryProduct SET serverID = ? WHERE id = ?");
                      $updateCategoryProduct->execute(array(post("categoryEditServer"), $readCategoryProduct["id"]));
                    }
                  }
                  echo alert(languageVariables("alertCategoryEditSuccess", "store", $languageType), "success", "3", "");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-category-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-category-edit-title" name="categoryEditTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>" value="<?php echo $readCategory["name"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-edit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-category-edit-status" name="categoryEditStatus">
                    <option value="2" <?php echo (($readCategory["status"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="1" <?php echo (($readCategory["status"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="0" <?php echo (($readCategory["status"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-edit-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-category-edit-server" name="categoryEditServer">
                  <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                  <?php if (mysqlCount($searchServers) > 0) { ?>
                  <?php foreach ($searchServers as $readServers) { ?>
                    <option value="<?php echo $readServers["id"]; ?>" <?php if ($readCategory["serverID"] == $readServers["id"]) { echo "selected"; } ?>><?php echo $readServers["name"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-category-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readCategory["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-category-edit-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-category-edit-image" name="categoryEditImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editCategoryToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editCategory"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_category_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
      <?php } else { go(urlConverter("admin_store_category", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("serverCategory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCategorys = $db->query("SELECT * FROM serverCategory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_category_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_category_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_category_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCategorys) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["categorysID", "categorysTitle", "categorysStatus", "categorysServer"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_store_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="categorysID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categorysTitle"><?php echo languageVariables("tableCategoryTitle", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categorysStatus"><?php echo languageVariables("tableViews", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categorysServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCategorys as $readCategorys) { ?>
               <?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
               <?php $searchServer->execute(array($readCategorys["serverID"])); ?>
               <?php if (mysqlCount($searchServer) > 0) { ?>
               <?php $readServer = fetch($searchServer); ?>
                <tr>
                  <td class="categorysID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_category", $languageType); ?>/<?php echo $readCategorys["id"]; ?>">#<?php echo $readCategorys["id"]; ?></a></td>
                  <td class="categorysTitle text-center"><a href="<?php echo urlConverter("admin_store_category", $languageType); ?>/<?php echo $readCategorys["id"]; ?>"><?php echo $readCategorys["name"]; ?></a></td>
                  <td class="categorysStatus text-center"><?php if ($readCategorys["status"] == "0") { echo languageVariables("viewPrivate", "store", $languageType); } else if ($readCategorys["status"] == "1") { echo languageVariables("viewEveryone", "store", $languageType); } else { echo languageVariables("viewUrl", "store", $languageType); } ?></td>
                  <td class="categorysServer text-center"><?php echo $readServer["name"]; ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_category", $languageType); ?>/<?php echo $readCategorys["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_category_delete", $languageType); ?>/<?php echo $readCategorys["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["categoryID"])) { ?>
    <?php
    $removeCategory = $db->prepare("DELETE FROM serverCategory WHERE id = ?");
    $removeCategory->execute(array(get("categoryID")));
    $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?");
    $searchProduct->execute(array(get("categoryID")));
    foreach ($searchProduct as $readProduct) {
      $removeProductPosters = $db->prepare("DELETE FROM productPosters WHERE productID = ?");
      $removeProductPosters->execute(array($readProduct["id"]));
    }
    $removeProduct = $db->prepare("DELETE FROM categoryProduct WHERE categoryID = ?");
    $removeProduct->execute(array(get("categoryID")));
    go(urlConverter("admin_store_category", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_store_category", $languageType)); } ?>
<?php } else if (get("action") == "product") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_product") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("productAddCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addProduct"])) {
            if ($safeCsrfToken->validate('addProductToken')) {
              if (post("productAddTitle") !== "" && (post("productAddServerTypes") == "multiple" || (post("productAddServer") > 0 && post("productAddCategory") >= 0)) && (post("productAddServerTypes") == "single" || (post("productAddServerMultipleCommand") !== null && post("productAddServerMultiple") > 0 && post("productAddCategoryMultiple") >= 0)) && post("productAddPrice") > 0 && $_POST["productAddCommands"] !== "" && post("productAddContent") !== "" && (post("productAddTimeStatus") == 0 || (post("productAddTime") > 0 && $_POST["productAddTimeEndCommands"] !== "")) ) {
                if ($_FILES["productAddImage"]["size"] !== null) {
                  if (post("productAddDiscountStatus") == 0 || (post("productAddDiscount") > 0 && 100 >= post("productAddDiscount"))) {
                    if (post("productAddCountStatus") == 0 || post("productAddCount") > 0) {
                      $productTimeType = post("productAddTimeStatus");
                      if ($productTimeType == 0) {
                        $productTime = 0;
                        $productTimeEndCommands = 0;
                      } else if ($productTimeType == 1) {
                        $productTime = post("productAddTime");
                        $productTimeEndCommands = json_encode($_POST["productAddTimeEndCommands"]);
                      }
                      $productType = post("productAddDiscountStatus");
                      $productDiscount = (($productType == 0) ? 0 : post("productAddDiscount"));
                      $productCountType = post("productAddCountStatus");
                      $productCount = (($productCountType == 0) ? 0 : post("productAddCount"));
                      $productPosters = post("productAddPosterStatus");
                      $productCommandServer = array();
                      if (post("productAddServerTypes") == "single") {
                        array_push($productCommandServer, post("productAddServer"));
                      } else {
                        foreach ($_POST["productAddServerMultipleCommand"] as $key => $value) {
                          array_push($productCommandServer, $_POST["productAddServerMultipleCommand"][$key]);
                        }
                      }
                      $serverType = ((post("productAddServerTypes") == "single") ? "0" : "1");
                      $productServerID = ((post("productAddServerTypes") == "single") ? post("productAddServer") : post("productAddServerMultiple"));
                      $productCategoryID = ((post("productAddServerTypes") == "single") ? post("productAddCategory") : post("productAddCategoryMultiple"));
                      $imageUpload = imageUpload($_FILES["productAddImage"], "/assets/uploads/images/store/product/avatar/");
                      if ($imageUpload !== false) {
                        $insertProduct = $db->prepare("INSERT INTO categoryProduct (`serverID`, `status`, `categoryID`, `name`, `image`, `posters`, `price`, `serverType`, `commandServer`, `productCommand`, `productCount`, `productType`, `productDiscount`, `productTime`, `timeEndCommands`, `text`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insertProduct->execute(array($productServerID, post("productAddStatus"), $productCategoryID, post("productAddTitle"), "/assets/uploads/images/store/product/avatar/".$imageUpload["name"], $productPosters, post("productAddPrice"), $serverType, json_encode($productCommandServer), json_encode($_POST["productAddCommands"]), $productCount, $productType, $productDiscount, $productTime, $productTimeEndCommands, $_POST["productAddContent"], date("d.m.Y H:i:s")));
                        echo alert(languageVariables("alertProductAddSuccess", "store", $languageType), "success", "3", urlConverter("admin_store_product", $languageType));
                      } else {
                        echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertProductCount", "store", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertProductDiscount", "store", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-product-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("productTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-product-add-title" name="productAddTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-status" name="productAddStatus">
                    <option value="1"><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="2"><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="0"><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-server-types" class="col-sm-3 col-form-label"><?php echo languageVariables("productServerType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-server-types" name="productAddServerTypes" data-toggle="productServerTypes">
                    <option value="single"><?php echo languageVariables("productServerTypeSimple", "store", $languageType); ?></option>
                    <option value="multiple"><?php echo languageVariables("productServerTypeMultiple", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductServerTypeOne" style="display: block;">
                <div class="form-group row">
                  <label for="store-product-add-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="store-product-add-server" name="productAddServer" data-toggle="productServerID" product-category-name="productCategory">
                    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchServers) > 0) { ?>
                    <?php foreach ($searchServers as $readServers) { ?>
                      <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-add-category" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div data-toggle="categoryLoader" style="display: none;">
                      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                      <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                    </div>
                    <select class="form-control" id="store-product-add-category" name="productAddCategory" data-toggle="categorySelect" product-category="productCategory">
                      <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                      <?php $searchServersCategory = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                      <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                        <?php $readServersCategory = fetch($searchServersCategory); ?>
                        <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                        <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                        <?php if (mysqlCount($searchCategories) > 0) { ?>
                          <?php foreach ($searchCategories as $readCategory) { ?>
                            <option value="<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div data-toggle="storeProductServerTypeMultiple" style="display: none;">
                <div class="form-group row">
                  <label for="store-product-add-server-multiple-command" class="col-sm-3 col-form-label"><?php echo languageVariables("productCommandGoServer", "store", $languageType); ?></label>
                  <div class="col-sm-9" style="color: #fff;">
                    <select class="form-control js-example-basic-multiple" multiple="multiple" data-width="100%" id="store-product-add-server-multiple-command" name="productAddServerMultipleCommand[]">
                    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchServers) > 0) { ?>
                    <?php foreach ($searchServers as $readServers) { ?>
                      <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-add-server-multiple" class="col-sm-3 col-form-label"><?php echo languageVariables("productViewServer", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="store-product-add-server-multiple" name="productAddServerMultiple" data-toggle="productServerID" product-category-name="productCategoryMultiple">
                    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchServers) > 0) { ?>
                    <?php foreach ($searchServers as $readServers) { ?>
                      <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-add-category-multiple" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div data-toggle="categoryLoader" style="display: none;">
                      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                      <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                    </div>
                    <select class="form-control" id="store-product-add-category-multiple" name="productAddCategoryMultiple" data-toggle="categorySelect" product-category="productCategoryMultiple">
                      <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                      <?php $searchServersCategory = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                      <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                        <?php $readServersCategory = fetch($searchServersCategory); ?>
                        <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                        <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                        <?php if (mysqlCount($searchCategories) > 0) { ?>
                          <?php foreach ($searchCategories as $readCategory) { ?>
                            <option value="<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-price" class="col-sm-3 col-form-label"><?php echo languageVariables("productPrice", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-dollar-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="store-product-add-price" name="productAddPrice" placeholder="<?php echo languageVariables("productPricePlaceholder", "store", $languageType); ?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-count-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productStock", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-count-status" name="productAddCountStatus" data-toggle="productCountStatus">
                    <option value="0"><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("limited", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductCountInput" style="display: none;">
                <div class="form-group row">
                  <label for="store-product-add-count" class="col-sm-3 col-form-label"><?php echo languageVariables("productCount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-cubes"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-add-count" name="productAddCount" placeholder="<?php echo languageVariables("productCountPlaceholder", "store", $languageType); ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-discount-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productDiscount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-discount-status" name="productAddDiscountStatus" data-toggle="productDiscountStatus">
                    <option value="0"><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductDiscountInput" style="display: none;">
                <div class="form-group row">
                  <label for="store-product-add-discount" class="col-sm-3 col-form-label"><?php echo languageVariables("productDiscountCount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-percent"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-add-discount" name="productAddDiscount" placeholder="<?php echo languageVariables("productDiscountCountPlaceholder", "store", $languageType); ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-commands" class="col-sm-3 col-form-label"><?php echo languageVariables("productCommands", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                      <thead>
                        <tr>
                          <th class="text-center align-middle"><?php echo languageVariables("command", "store", $languageType); ?></th>
                          <th class="text-center align-middle">
                            <button type="button" class="btn btn-success btn-icon addTableItemOne">
                              <i data-feather="plus"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span class="fa fa-code"></span>
                                </div>
                              </div>
                              <input type="text" class="form-control form-control-prepended" name="productAddCommands[]" placeholder="<?php echo languageVariables("commandPlaceholder", "store", $languageType); ?>">
                            </div>
                          </td>
                          <td class="text-center align-middle">
                            <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                              <span class="far fa-trash-alt"></span>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <small class="form-text text-muted pb-2"><?php echo languageVariables("commandNote", "store", $languageType); ?></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-time-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productDuration", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-time-status" name="productAddTimeStatus" data-toggle="storeProductTimeStatus">
                    <option value="0"><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("durationis", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductTimeInput" style="display: none;">
                <div class="form-group row">
                  <label for="store-product-add-time" class="col-sm-3 col-form-label"><?php echo languageVariables("productDurationDay", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="far fa-clock"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-add-time" name="productAddTime" placeholder="<?php echo languageVariables("productDurationDayPlaceholder", "store", $languageType); ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDurationDayNote", "store", $languageType); ?></span>
                </div>
                <div class="form-group row">
                  <label for="store-product-add-time-end-commands" class="col-sm-3 col-form-label"><?php echo languageVariables("productDurationCommands", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="table-responsive">
                      <table id="storeProductTimeEndCommandsTable" class="table table-sm table-hover table-nowrap array-table">
                        <thead>
                          <tr>
                            <th class="text-center align-middle"><?php echo languageVariables("command", "store", $languageType); ?></th>
                            <th class="text-center align-middle">
                              <button type="button" class="btn btn-success btn-icon addTableItemOne">
                                <i data-feather="plus"></i>
                              </button>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="ml-2">
                              <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <span class="fa fa-code"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control form-control-prepended" name="productAddTimeEndCommands[]" placeholder="<?php echo languageVariables("commandPlaceholderDuraiton", "store", $languageType); ?>">
                              </div>
                            </td>
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                                <span class="far fa-trash-alt"></span>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <small class="form-text text-muted pb-2"><?php echo languageVariables("commandNote", "store", $languageType); ?></small>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-poster-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productPoster", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-add-poster-status" name="productAddPosterStatus" data-toggle="storeProductPosterStatus">
                    <option value="0"><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-content" class="col-sm-3 col-form-label"><?php echo languageVariables("productDescription", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <textarea class="form-control ckeditor" id="store-product-add-content" name="productAddContent" placeholder="<?php echo languageVariables("productDescriptionPlaceholder", "store", $languageType); ?>" row="2"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-add-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-product-add-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-product-add-image" name="productAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addProductToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addProduct"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["productID"])) { ?>
      <?php
      $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
      $searchProduct->execute(array(get("productID")));
      if (mysqlCount($searchProduct) > 0) {
        $readProduct = fetch($searchProduct);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readProduct["id"]."# ".$readProduct["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("productEditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editProduct"])) {
            if ($safeCsrfToken->validate('editProductToken')) {
              if (post("productEditTitle") !== "" && (post("productEditServerTypes") == "multiple" || (post("productEditServer") > 0 && post("productEditCategory") >= 0)) && (post("productEditServerTypes") == "single" || (post("productEditServerMultipleCommand") !== null && post("productEditServerMultiple") > 0 && post("productEditCategoryMultiple") >= 0)) && post("productEditPrice") > 0 && $_POST["productEditCommands"] !== "" && post("productEditContent") !== "" && (post("productEditTimeStatus") == 0 || (post("productEditTime") > 0 && $_POST["productEditTimeEndCommands"] !== "")) ) {
                if ($_FILES["productEditImage"]["size"] !== null) {
                  if (post("productEditDiscountStatus") == 0 || (post("productEditDiscount") > 0 && 100 >= post("productEditDiscount"))) {
                    if (post("productEditCountStatus") == 0 || post("productEditCount") > 0) {
                      $productTimeType = post("productEditTimeStatus");
                      if ($productTimeType == 0) {
                        $productTime = 0;
                        $productTimeEndCommands = 0;
                      } else if ($productTimeType == 1) {
                        $productTime = post("productEditTime");
                        $productTimeEndCommands = json_encode($_POST["productEditTimeEndCommands"]);
                      }
                      $productType = post("productEditDiscountStatus");
                      $productDiscount = (($productType == 0) ? 0 : post("productEditDiscount"));
                      $productCountType = post("productEditCountStatus");
                      $productCount = (($productCountType == 0) ? 0 : post("productEditCount"));
                      $productPosters = post("productEditPosterStatus");
                      $productCommandServer = array();
                      if (post("productEditServerTypes") == "single") {
                        array_push($productCommandServer, post("productEditServer"));
                      } else {
                        foreach ($_POST["productEditServerMultipleCommand"] as $key => $value) {
                          array_push($productCommandServer, $_POST["productEditServerMultipleCommand"][$key]);
                        }
                      }
                      $serverType = ((post("productEditServerTypes") == "single") ? "0" : "1");
                      $productServerID = ((post("productEditServerTypes") == "single") ? post("productEditServer") : post("productEditServerMultiple"));
                      $productCategoryID = ((post("productEditServerTypes") == "single") ? post("productEditCategory") : post("productEditCategoryMultiple"));
                      $imageUploadStatus = true;
                      if ($_FILES["productEditImage"]["name"] != null) {
                        $imageUpload = imageUpload($_FILES["productEditImage"], "/assets/uploads/images/store/product/avatar/");
                        if ($imageUpload !== false) {
                          $updateProductImage = $db->prepare("UPDATE categoryProduct SET image = ? WHERE id = ?");
                          $updateProductImage->execute(array("/assets/uploads/images/store/product/avatar/".$imageUpload["name"], $readProduct["id"]));
                          $imageUploadStatus = true;
                        } else {
                          $imageUploadStatus = false;
                        }
                      }
                      if ($imageUploadStatus = true) {
                        $updateProduct = $db->prepare("UPDATE categoryProduct SET serverID = ?, status = ?, categoryID = ?, name = ?, posters = ?, price = ?, serverType = ?, commandServer = ?, productCommand = ?, productCount = ?, productType = ?, productDiscount= ?, productTime = ?, timeEndCommands = ?, text = ? WHERE id = ?");
                        $updateProduct->execute(array($productServerID, post("productEditStatus"), $productCategoryID, post("productEditTitle"),  $productPosters, post("productEditPrice"), $serverType, json_encode($productCommandServer), json_encode($_POST["productEditCommands"]), $productCount, $productType, $productDiscount, $productTime, $productTimeEndCommands, $_POST["productEditContent"], $readProduct["id"]));
                        echo alert(languageVariables("alertProductEditSuccess", "store", $languageType), "success", "3", "");
                      } else {
                        echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertProductCount", "store", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertProductDiscount", "store", $languageType), "warning", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-product-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("productTitle", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-product-edit-title" name="productEditTitle" placeholder="<?php echo languageVariables("titlePlaceholder", "store", $languageType); ?>" value="<?php echo $readProduct["name"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("views", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-status" name="productEditStatus">
                    <option value="1" <?php echo (($readProduct["status"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("viewEveryone", "store", $languageType); ?></option>
                    <option value="2" <?php echo (($readProduct["status"] == "2") ? "selected" : ""); ?>><?php echo languageVariables("viewUrl", "store", $languageType); ?></option>
                    <option value="0" <?php echo (($readProduct["status"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("viewPrivate", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-server-types" class="col-sm-3 col-form-label"><?php echo languageVariables("productServerType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-server-types" name="productEditServerTypes" data-toggle="productServerTypes">
                    <option value="single" <?php echo (($readProduct["serverType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("productServerTypeSimple", "store", $languageType); ?></option>
                    <option value="multiple" <?php echo (($readProduct["serverType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("productServerTypeMultiple", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductServerTypeOne" <?php echo (($readProduct["serverType"] == "1") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="store-product-edit-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="store-product-edit-server" name="productEditServer" data-toggle="productServerID" product-category-name="productCategory">
                    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchServers) > 0) { ?>
                    <?php foreach ($searchServers as $readServers) { ?>
                      <option value="<?php echo $readServers["id"]; ?>" <?php echo (($readProduct["serverID"] == $readServers["id"]) ? "selected" : ""); ?>><?php echo $readServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-edit-category" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div data-toggle="categoryLoader" style="display: none;">
                      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                      <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                    </div>
                    <select class="form-control" id="store-product-edit-category" name="productEditCategory" data-toggle="categorySelect" product-category="productCategory">
                      <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                      <?php $searchServersCategory = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                      <?php $searchServersCategory->execute(array($readProduct["serverID"])); ?>
                      <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                        <?php $readServersCategory = fetch($searchServersCategory); ?>
                        <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                        <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                        <?php if (mysqlCount($searchCategories) > 0) { ?>
                          <?php foreach ($searchCategories as $readCategory) { ?>
                            <option value="<?php echo $readCategory["id"]; ?>" <?php if ($readProduct["categoryID"] == $readCategory["id"]) { echo "selected"; } ?>><?php echo $readCategory["name"]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div data-toggle="storeProductServerTypeMultiple" <?php echo (($readProduct["serverType"] == "0") ? "style=\"display: none;\"" : ""); ?>>
                <div class="form-group row">
                  <label for="store-product-edit-server-multiple-command" class="col-sm-3 col-form-label"><?php echo languageVariables("productCommandGoServer", "store", $languageType); ?></label>
                  <div class="col-sm-9" style="color: #fff;">
                    <select class="form-control js-example-basic-multiple" multiple="multiple" data-width="100%" id="store-product-edit-server-multiple-command" name="productEditServerMultipleCommand[]">
                    <?php $searchMultipleServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchMultipleServers) > 0) { ?>
                    <?php foreach ($searchMultipleServers as $readMultipleServers) { ?>
                      <?php 
                      $selectedStatus = "__UNSUCCESSFULL__";
                      $searchCommandServer = json_decode($readProduct["commandServer"], true);
                      foreach ($searchCommandServer as $readCommandServer) {
                        if ($readMultipleServers["id"] == $readCommandServer) {
                          $selectedStatus = "__SUCCESSFULL__";
                        }
                      }
                      ?>
                      <option value="<?php echo $readMultipleServers["id"]; ?>" <?php echo (($selectedStatus == "__SUCCESSFULL__") ? "selected" : ""); ?>><?php echo $readMultipleServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-edit-server-multiple" class="col-sm-3 col-form-label"><?php echo languageVariables("productViewServer", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <select class="form-control" id="store-product-edit-server-multiple" name="productEditServerMultiple" data-toggle="productServerID" product-category-name="productCategoryMultiple">
                    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchServers) > 0) { ?>
                    <?php foreach ($searchServers as $readServers) { ?>
                      <option value="<?php echo $readServers["id"]; ?>" <?php echo (($readProduct["serverID"] == $readServers["id"]) ? "selected" : ""); ?>><?php echo $readServers["name"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="store-product-edit-category-multiple" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div data-toggle="categoryLoader" style="display: none;">
                      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                      <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                    </div>
                    <select class="form-control" id="store-product-edit-category-multiple" name="productEditCategoryMultiple" data-toggle="categorySelect" product-category="productCategoryMultiple">
                      <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                      <?php $searchServersCategory = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                      <?php $searchServersCategory->execute(array($readProduct["serverID"])); ?>
                      <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                        <?php $readServersCategory = fetch($searchServersCategory); ?>
                        <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                        <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                        <?php if (mysqlCount($searchCategories) > 0) { ?>
                          <?php foreach ($searchCategories as $readCategory) { ?>
                            <option value="<?php echo $readCategory["id"]; ?>" <?php if ($readProduct["categoryID"] == $readCategory["id"]) { echo "selected"; } ?>><?php echo $readCategory["name"]; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-price" class="col-sm-3 col-form-label"><?php echo languageVariables("productPrice", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-dollar-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="store-product-edit-price" name="productEditPrice" placeholder="<?php echo languageVariables("productPricePlaceholder", "store", $languageType); ?>" value="<?php echo $readProduct["price"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-count-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productStock", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-count-status" name="productEditCountStatus" data-toggle="productCountStatus">
                    <option value="0" <?php if ($readProduct["productCount"] == "0") { echo "selected"; } ?>><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1" <?php if ($readProduct["productCount"] > 0) { echo "selected"; } ?>><?php echo languageVariables("limited", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductCountInput" <?php if ($readProduct["productCount"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-product-edit-count" class="col-sm-3 col-form-label"><?php echo languageVariables("productCount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-cubes"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-edit-count" name="productEditCount" placeholder="<?php echo languageVariables("productCountPlaceholder", "store", $languageType); ?>" value="<?php echo $readProduct["productCount"]; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-discount-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productDiscount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-discount-status" name="productEditDiscountStatus" data-toggle="productDiscountStatus">
                    <option value="0" <?php if ($readProduct["productType"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readProduct["productType"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductDiscountInput" <?php if ($readProduct["productType"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-product-edit-discount" class="col-sm-3 col-form-label"><?php echo languageVariables("productDiscountCount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-percent"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-edit-discount" name="productEditDiscount" placeholder="<?php echo languageVariables("productDiscountCountPlaceholder", "store", $languageType); ?>" value="<?php echo $readProduct["productDiscount"]; ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-commands" class="col-sm-3 col-form-label"><?php echo languageVariables("productCommands", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                      <thead>
                        <tr>
                          <th class="text-center align-middle"><?php echo languageVariables("command", "store", $languageType); ?></th>
                          <th class="text-center align-middle">
                            <button type="button" class="btn btn-success btn-icon addTableItemOne">
                              <i data-feather="plus"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $productCommands = json_decode($readProduct["productCommand"], true); ?>
                      <?php foreach ($productCommands as $readCommands) { ?>
                        <tr>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span class="fa fa-code"></span>
                                </div>
                              </div>
                              <input type="text" class="form-control form-control-prepended" name="productEditCommands[]" placeholder="<?php echo languageVariables("commandPlaceholder", "store", $languageType); ?>" value="<?php echo $readCommands; ?>">
                            </div>
                          </td>
                          <td class="text-center align-middle">
                            <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                              <span class="far fa-trash-alt"></span>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <small class="form-text text-muted pb-2"><?php echo languageVariables("commandNote", "store", $languageType); ?></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-time-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productDuration", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-time-status" name="productEditTimeStatus" data-toggle="storeProductTimeStatus">
                    <option value="0" <?php if ($readProduct["productTime"] == 0) { echo "selected"; } ?>><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1" <?php if ($readProduct["productTime"] > 0) { echo "selected"; } ?>><?php echo languageVariables("durationis", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeProductTimeInput" <?php if ($readProduct["productTime"] == "0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-product-edit-time" class="col-sm-3 col-form-label"><?php echo languageVariables("productDurationDay", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="far fa-clock"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-product-edit-time" name="productEditTime" placeholder="<?php echo languageVariables("productDurationDayPlaceholder", "store", $languageType); ?>" value="<?php echo $readProduct["productTime"]; ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDurationDayNote", "store", $languageType); ?></span>
                </div>
                <div class="form-group row">
                  <label for="store-product-edit-time-end-commands" class="col-sm-3 col-form-label"><?php echo languageVariables("productDurationCommands", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="table-responsive">
                      <table id="storeProductTimeEndCommandsTable" class="table table-sm table-hover table-nowrap array-table">
                        <thead>
                          <tr>
                            <th class="text-center align-middle"><?php echo languageVariables("command", "store", $languageType); ?></th>
                            <th class="text-center align-middle">
                              <button type="button" class="btn btn-success btn-icon addTableItemOne">
                                <i data-feather="plus"></i>
                              </button>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $productTimeEndCommands = json_decode($readProduct["timeEndCommands"], true); ?>
                        <?php foreach ($productTimeEndCommands as $readTimeEndCommands) { ?>
                          <tr>
                            <td class="ml-2">
                              <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <span class="fa fa-code"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control form-control-prepended" name="productEditTimeEndCommands[]" placeholder="<?php echo languageVariables("commandPlaceholderDuraiton", "store", $languageType); ?>" value="<?php echo $readTimeEndCommands; ?>">
                              </div>
                            </td>
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                                <span class="far fa-trash-alt"></span>
                              </button>
                            </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <small class="form-text text-muted pb-2"><?php echo languageVariables("commandNote", "store", $languageType); ?></small>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-poster-status" class="col-sm-3 col-form-label"><?php echo languageVariables("productPoster", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-edit-poster-status" name="productEditPosterStatus" data-toggle="storeProductPosterStatus">
                    <option value="0" <?php if ($readProduct["posters"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readProduct["posters"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-content" class="col-sm-3 col-form-label"><?php echo languageVariables("productDescription", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <textarea class="form-control ckeditor" id="store-product-edit-content" name="productEditContent" placeholder="<?php echo languageVariables("productDescriptionPlaceholder", "store", $languageType); ?>" row="2"><?php echo $readProduct["text"]; ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-product-edit-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-product-edit-image" name="productEditImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editProductToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editProduct"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_produc_delete", $languageType); ?>/<?php echo $readProduct["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
      <?php } else { go(urlConverter("admin_store_product", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("categoryProduct", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchProducts = $db->query("SELECT * FROM categoryProduct ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchProducts) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["productsID", "productsName", "productsStatus", "productsServer", "productsCategory", "productsPrice", "productsTime", "productsCount", "productsCountPiece", "productsDiscount"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_store_product_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="productsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsName"><?php echo languageVariables("tableProductName", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsStatus"><?php echo languageVariables("tableViews", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsPrice"><?php echo languageVariables("price", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsTime"><?php echo languageVariables("duration", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsCount"><?php echo languageVariables("stock", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsCountPiece"><?php echo languageVariables("lastCount", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="productsDiscount"><?php echo languageVariables("discount", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchProducts as $readProducts) { ?>
               <?php $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
               <?php $searchCategory->execute(array($readProducts["categoryID"])); ?>
               <?php if (mysqlCount($searchCategory) > 0 || $readProducts["categoryID"] == "0") { ?>
               <?php if (mysqlCount($searchCategory) > 0) { ?>
               <?php $readCategory = fetch($searchCategory); ?>
               <?php } ?>
               <?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
               <?php $searchServer->execute(array($readProducts["serverID"])); ?>
               <?php if (mysqlCount($searchServer) > 0) { ?>
               <?php $readServer = fetch($searchServer); ?>
               <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
               <?php $searchProductStockHistory->execute(array($readProducts["id"])); ?>
                <tr>
                  <td class="productsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>/<?php echo $readProducts["id"]; ?>">#<?php echo $readProducts["id"]; ?></a></td>
                  <td class="productsName text-center"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>/<?php echo $readProducts["id"]; ?>"><?php echo $readProducts["name"]; ?></a></td>
                  <td class="productsStatus text-center"><?php if ($readProducts["status"] == "0") { echo languageVariables("viewPrivate", "store", $languageType); } else if ($readProducts["status"] == "1") { echo languageVariables("viewEveryone", "store", $languageType); } else { echo languageVariables("viewUrl", "store", $languageType); } ?></td>
                  <td class="productsServer text-center"><?php echo $readServer["name"]; ?></td>
                  <td class="productsCategory text-center"><?php echo (($readProducts["categoryID"] == "0") ? languageVariables("notCategory", "store", $languageType) : $readCategory["name"]); ?></td>
                  <td class="productsPrice text-center"><?php echo $readProducts["price"]; ?> <?php echo languageVariables("credit", "words", $languageType); ?></td>
                  <td class="productsTime text-center"><?php if ($readProducts["productTime"] > 0) { echo $readProducts["productTime"]." ".languageVariables("day", "words", $languageType); } else { echo languageVariables("unlimited", "store", $languageType); } ?></td>
                  <td class="productsCount text-center"><?php if ($readProducts["productCount"] > 0) { echo $readProducts["productCount"]." ".languageVariables("count", "words", $languageType); } else { echo languageVariables("unlimited", "store", $languageType); } ?></td>
                  <td class="productsCountPiece text-center">
                  <?php 
                  if ($readProducts["productCount"] > 0) {
                    $productCountPiece = $readProducts["productCount"] - mysqlCount($searchProductStockHistory);
                    echo (($productCountPiece == "0") ? languageVariables("notStock", "words", $languageType) : $productCountPiece." ".languageVariables("count", "words", $languageType));
                  } else {
                    echo languageVariables("unlimited", "store", $languageType);
                  }
                  ?>
                  </td>
                  <td class="productsDiscount text-center"><?php if ($readProducts["productType"] == 1) { echo "%".$readProducts["productDiscount"]; } else { echo languageVariables("notDiscount", "words", $languageType); } ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_product", $languageType); ?>/<?php echo $readProducts["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_produc_delete", $languageType); ?>/<?php echo $readProducts["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["productID"])) { ?>
    <?php
    $removeProductPosters = $db->prepare("DELETE FROM productPosters WHERE productID = ?");
    $removeProductPosters->execute(array(get("productID")));
    $removeProduct = $db->prepare("DELETE FROM categoryProduct WHERE id = ?");
    $removeProduct->execute(array(get("productID")));
    go(urlConverter("admin_store_product", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_store_product", $languageType)); } ?>
<?php } else if (get("action") == "productPoster") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_product") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>"><?php echo languageVariables("poster", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("productPosterAddCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addPoster"])) {
            if ($safeCsrfToken->validate('addPosterToken')) {
              if (post("posterAddServer") > 0 && post("posterAddCategory") >= 0 && post("posterAddProduct") > 0) {
                if ($_FILES["posterAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["posterAddImage"], "/assets/uploads/images/store/product/poster/");
                  if ($imageUpload !== false) {
                    $insertPoster = $db->prepare("INSERT INTO productPosters SET productID = ?, image = ?, date = ?");
                    $insertPoster->execute(array(post("posterAddProduct"), "/assets/uploads/images/store/product/poster/".$imageUpload["name"], date("d.m.Y H:i:s")));
                    echo alert(languageVariables("alertProductPosterAddSuccess", "store", $languageType), "success", "3", urlConverter("admin_store_product_poster", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-product-poster-add-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-poster-add-server" name="posterAddServer" data-toggle="productServerID" product-category-name="productCategory">
                  <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                  <?php if (mysqlCount($searchServers) > 0) { ?>
                  <?php foreach ($searchServers as $readServers) { ?>
                    <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-add-category" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="categoryLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-poster-add-category" name="posterAddCategory" data-toggle="categorySelect" product-category="productCategory">
                  <?php $searchServersCategory = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                  <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                    <?php $readServersCategory = fetch($searchServersCategory); ?>
                    <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                    <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                    <?php if (mysqlCount($searchCategories) > 0) { ?>
                      <option value="0"><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                      <?php foreach ($searchCategories as $readCategory) { ?>
                        <option value="<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="0"><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="-1" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-add-product" class="col-sm-3 col-form-label"><?php echo languageVariables("product", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="productLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-poster-add-product" name="posterAddProduct" data-toggle="productSelect">
                  <?php $searchServersProduct = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                  <?php if (mysqlCount($searchServersProduct) > 0) { ?>
                    <?php $readServersProduct = fetch($searchServersProduct); ?>
                    <?php $searchCategoriesProduct = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC LIMIT 1"); ?>
                    <?php $searchCategoriesProduct->execute(array($readServersProduct["id"])); ?>
                      <?php $readCategoryProduct = fetch($searchCategoriesProduct); ?>
                      <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE (categoryID = ? OR categoryID = ?) AND serverID = ? ORDER BY id DESC"); ?>
                      <?php $searchProducts->execute(array($readCategoryProduct["id"], "0", $readServersProduct["id"])); ?>
                      <?php if (mysqlCount($searchCategoriesProduct) > 0) { ?>
                        <?php foreach ($searchProducts as $readProducts) { ?>
                          <option value="<?php echo $readProducts["id"]; ?>"><?php echo $readProducts["name"]; ?></option>
                        <?php } ?>
                      <?php } else { ?>
                        <option value="0" selected><?php echo languageVariables("selectCategoryNotProduct", "store", $languageType); ?></option>
                      <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-add-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-product-poster-add-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-product-poster-add-image" name="posterAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addPosterToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addPoster"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["posterID"])) { ?>
      <?php
      $searchPoster = $db->prepare("SELECT * FROM productPosters WHERE id = ?");
      $searchPoster->execute(array(get("posterID")));
      if (mysqlCount($searchPoster) > 0) {
        $readPoster = fetch($searchPoster);
        $searchPosterProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
        $searchPosterProduct->execute(array($readPoster["productID"]));
        if (mysqlCount($searchPosterProduct) > 0) {
          $readPosterProduct = fetch($searchPosterProduct);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>"><?php echo languageVariables("poster", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readPoster["id"]."# ".$readPosterProduct["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("productPosterEditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editPoster"])) {
            if ($safeCsrfToken->validate('editPosterToken')) {
              if (post("posterEditServer") > 0 && post("posterEditCategory") >= 0 && post("posterEditProduct") > 0) {
                if ($_FILES["posterEditImage"]["size"] !== null) {
                  if ($_FILES["posterEditImage"]["name"] != null) {
                    $imageUpload = imageUpload($_FILES["posterEditImage"], "/assets/uploads/images/store/product/poster/");
                    if ($imageUpload !== false) {
                      $updatePoster = $db->prepare("UPDATE productPosters SET productID = ?, image = ? WHERE id = ?");
                      $updatePoster->execute(array(post("posterEditProduct"), "/assets/uploads/images/store/product/poster/".$imageUpload["name"], $readPoster["id"]));
                      echo alert(languageVariables("alertProductPosterEditSuccess", "store", $languageType), "success", "3", "");
                    } else {
                      echo alert(languageVariables("alertImageUpload", "store", $languageType), "danger", "0", "/");
                    }
                  } else {
                    $updatePoster = $db->prepare("UPDATE productPosters SET productID = ? WHERE id = ?");
                    $updatePoster->execute(array(post("posterEditProduct"), $readPoster["id"]));
                    echo alert(languageVariables("alertProductPosterEditSuccess", "store", $languageType), "success", "3", "");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-product-poster-edit-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-poster-edit-server" name="posterEditServer" data-toggle="productServerID" product-category-name="productCategory">
                  <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                  <?php if (mysqlCount($searchServers) > 0) { ?>
                  <?php foreach ($searchServers as $readServers) { ?>
                    <option value="<?php echo $readServers["id"]; ?>" <?php if ($readPosterProduct["serverID"] == $readServers["id"]) { echo "selected"; } ?>><?php echo $readServers["name"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-edit-category" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="categoryLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-poster-edit-category" name="posterEditCategory" data-toggle="categorySelect" product-category="productCategory">
                  <?php $searchServersCategory = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                  <?php $searchServersCategory->execute(array($readPosterProduct["serverID"])); ?>
                  <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                    <?php $readServersCategory = fetch($searchServersCategory); ?>
                    <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                    <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                    <?php if (mysqlCount($searchCategories) > 0) { ?>
                      <?php foreach ($searchCategories as $readCategory) { ?>
                        <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                        <option value="<?php echo $readCategory["id"]; ?>" <?php if ($readPosterProduct["categoryID"] == $readCategory["id"]) { echo "selected"; } ?>><?php echo $readCategory["name"]; ?></option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="0" selected><?php echo languageVariables("notCategory", "store", $languageType); ?></option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="-1" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-edit-product" class="col-sm-3 col-form-label"><?php echo languageVariables("product", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="productLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-poster-edit-product" name="posterEditProduct" data-toggle="productSelect">
                  <?php $searchServersProduct = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                  <?php $searchServersProduct->execute(array($readPosterProduct["serverID"])); ?>
                  <?php if (mysqlCount($searchServersProduct) > 0) { ?>
                    <?php $readServersProduct = fetch($searchServersProduct); ?>
                    <?php $searchCategoriesProduct = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
                    <?php $searchCategoriesProduct->execute(array($readPosterProduct["categoryID"])); ?>
                      <?php $readCategoryProduct = fetch($searchCategoriesProduct); ?>
                      <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE (categoryID = ? OR categoryID = ?) AND serverID = ? ORDER BY id DESC"); ?>
                      <?php $searchProducts->execute(array($readCategoryProduct["id"], "0", $readPosterProduct["serverID"])); ?>
                      <?php if (mysqlCount($searchCategoriesProduct) > 0) { ?>
                        <?php foreach ($searchProducts as $readProducts) { ?>
                          <option value="<?php echo $readProducts["id"]; ?>" <?php if ($readPosterProduct["id"] == $readProducts["id"]) { echo "selected"; } ?>><?php echo $readProducts["name"]; ?></option>
                        <?php } ?>
                      <?php } else { ?>
                        <option value="0" selected><?php echo languageVariables("selectCategoryNotProduct", "store", $languageType); ?></option>
                      <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-poster-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readPoster["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="store-product-poster-edit-image"><?php echo languageVariables("imagePlaceholder", "store", $languageType); ?></label>
                      <input type="file" id="store-product-poster-edit-image" name="posterEditImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editPosterToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editPoster"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_product_poster_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
      <?php } else { go(urlConverter("admin_store_product_poster", $languageType)); } ?>
      <?php } else { go(urlConverter("admin_store_product_poster", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("productPosters", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchPosters = $db->query("SELECT * FROM productPosters ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("product", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>"><?php echo languageVariables("poster", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_poster_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_poster_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_product_poster_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchPosters) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["postersID", "postersProduct", "postersProductServer", "postersProductCategory", "postersCrateDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>/ekle"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="postersID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="postersProduct"><?php echo languageVariables("tableProductName", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="postersProductServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="postersProductCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="postersCrateDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPosters as $readPosters) { ?>
                 <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?>
                 <?php $searchProduct->execute(array($readPosters["productID"])); ?>
                 <?php if (mysqlCount($searchProduct) > 0) { ?>
                   <?php $readProducts = fetch($searchProduct); ?>
                   <?php $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
                   <?php $searchCategory->execute(array($readProducts["categoryID"])); ?>
                   <?php if (mysqlCount($searchCategory) > 0 || $readProducts["categoryID"] == "0") { ?>
                     <?php if (mysqlCount($searchCategory) > 0) { ?>
                     <?php $readCategory = fetch($searchCategory); ?>
                     <?php } ?>
                     <?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
                     <?php $searchServer->execute(array($readProducts["serverID"])); ?>
                     <?php if (mysqlCount($searchServer) > 0) { ?>
                        <?php $readServer = fetch($searchServer); ?>
                <tr>
                  <td class="postersID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>/<?php echo $readPosters["id"]; ?>">#<?php echo $readPosters["id"]; ?></a></td>
                  <td class="postersProduct text-center"><a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>/<?php echo $readPosters["id"]; ?>"><?php echo $readProducts["name"]; ?></a></td>
                  <td class="postersProductServer text-center"><?php echo $readServer["name"]; ?></td>
                  <td class="postersProductCategory text-center"><?php echo (($readProducts["categoryID"] == "0") ? languageVariables("notCategory", "store", $languageType) : $readCategory["name"]); ?></td>
                  <td class="postersCrateDate text-center"><?php echo checkTime($readPosters["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>/<?php echo $readPosters["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_product_poster_delete", $languageType); ?>/<?php echo $readPosters["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["posterID"])) { ?>
    <?php
    $removeProductPosters = $db->prepare("DELETE FROM productPosters WHERE id = ?");
    $removeProductPosters->execute(array(get("posterID")));
    go(urlConverter("admin_store_product_poster", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_store_product_poster", $languageType)); } ?>
<?php } else if (get("action") == "coupon") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_coupon") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>"><?php echo languageVariables("coupon", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("couponAddCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addCoupon"])) {
            if ($safeCsrfToken->validate('addCouponToken')) {
              if (post("couponAddCode") !== "" && isset($_POST["couponAddType"]) && (post("couponAddCountType") == 0 || post("couponAddCount") !== "")) {
                if (post("couponAddDiscount") > 0 && 100 > post("couponAddDiscount")) {
                  $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE code = ? AND type = ?");
                  $searchCoupon->execute(array(post("couponAddCode"), post("couponAddType")));
                  if (mysqlCount($searchCoupon) == 0) {
                    if (post("couponAddCountType") == 0) {
                      $couponCount = "0-0-0-0";
                    } else if (post("couponAddCountType") == 1) {
                      $couponCount = floor(post("couponAddCount"));
                    } else {
                      $couponCount = "0-0-0-0";
                    }
                    $insertCoupon = $db->prepare("INSERT INTO discountCoupon SET code = ?, type = ?, discount = ?, couponCount = ?, date = ?");
                    $insertCoupon->execute(array(post("couponAddCode"), post("couponAddType"), post("couponAddDiscount"), $couponCount, date("d.m.Y H:i:s")));
                    echo alert(languageVariables("alertDiscountCouponAddSuccess", "store", $languageType), "success", "3", urlConverter("admin_store_coupon", $languageType));
                  } else {
                    echo alert(languageVariables("alertDiscountCouponCodeAlready", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertDiscountCouponAmount", "store", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-coupon-add-code" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCode", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-coupon-add-code" name="couponAddCode" placeholder="<?php echo languageVariables("couponCodePlaceholder", "store", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-add-type" class="col-sm-3 col-form-label"><?php echo languageVariables("couponType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-coupon-add-type" name="couponAddType">
                    <option value="0"><?php echo languageVariables("couponTypeOption0", "store", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("couponTypeOption1", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-add-count-type" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-coupon-add-count-type" name="couponAddCountType" data-toggle="storeCouponCountType">
                    <option value="0"><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("limited", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeCouponCountInput" style="display: none;">
                <div class="form-group row">
                  <label for="store-coupon-add-count" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCountRand", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="store-coupon-add-count" name="couponAddCount" placeholder="<?php echo languageVariables("couponCountRandPlaceholder", "store", $languageType); ?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-add-discount" class="col-sm-3 col-form-label"><?php echo languageVariables("couponDiscount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-percent"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="store-coupon-add-discount" name="couponAddDiscount" placeholder="<?php echo languageVariables("couponDiscountPlaceholder", "store", $languageType); ?>">
                  </div>
                </div>
                <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addCouponToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addCoupon"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["couponID"])) { ?>
      <?php
      $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ?");
      $searchCoupon->execute(array(get("couponID")));
      if (mysqlCount($searchCoupon) > 0) {
        $readCoupon = fetch($searchCoupon);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>"><?php echo languageVariables("coupon", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCoupon["id"]."# ".$readCoupon["code"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("couponEditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editCoupon"])) {
            if ($safeCsrfToken->validate('editCouponToken')) {
              if (post("couponEditCode") !== "" && isset($_POST["couponEditType"]) && (post("couponEditCountType") == 0 || post("couponEditCount") !== "")) {
                if (post("couponEditDiscount") > 0 && 100 > post("couponEditDiscount")) {
                  $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE code = ? AND type = ?");
                  $searchCoupon->execute(array(post("couponEditCode"), post("couponEditType")));
                  if (mysqlCount($searchCoupon) == 0 || $readCoupon["code"] == post("couponEditCode")) {
                    if (post("couponEditCountType") == 0) {
                      $couponCount = "0-0-0-0";
                    } else if (post("couponEditCountType") == 1) {
                      $couponCount = floor(post("couponEditCount"));
                    } else {
                      $couponCount = "0-0-0-0";
                    }
                    $insertCoupon = $db->prepare("UPDATE discountCoupon SET code = ?, type = ?, discount = ?, couponCount = ? WHERE id = ?");
                    $insertCoupon->execute(array(post("couponEditCode"), post("couponEditType"), post("couponEditDiscount"), $couponCount, $readCoupon["id"]));
                    echo alert(languageVariables("alertDiscountCouponEditSuccess", "store", $languageType), "success", "3", "");
                  } else {
                    echo alert(languageVariables("alertDiscountCouponCodeAlready", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertDiscountCouponAmount", "store", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-coupon-edit-code" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCode", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-coupon-edit-code" name="couponEditCode" placeholder="<?php echo languageVariables("couponCodePlaceholder", "store", $languageType); ?>" value="<?php echo $readCoupon["code"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-edit-type" class="col-sm-3 col-form-label"><?php echo languageVariables("couponType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-coupon-edit-type" name="couponEditType">
                    <option value="0" <?php if ($readCoupon["type"] == 0) { echo "selected"; } ?>><?php echo languageVariables("couponTypeOption0", "store", $languageType); ?></option>
                    <option value="1" <?php if ($readCoupon["type"] == 1) { echo "selected"; } ?>><?php echo languageVariables("couponTypeOption1", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-edit-count-type" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-coupon-edit-count-type" name="couponEditCountType" data-toggle="storeCouponCountType">
                    <option value="0" <?php if ($readCoupon["couponCount"] == "0-0-0-0") { echo "selected"; } ?>><?php echo languageVariables("unlimited", "store", $languageType); ?></option>
                    <option value="1" <?php if ($readCoupon["couponCount"] !== "0-0-0-0") { echo "selected"; } ?>><?php echo languageVariables("limited", "store", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div data-toggle="storeCouponCountInput" <?php if ($readCoupon["couponCount"] == "0-0-0-0") { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-coupon-edit-count" class="col-sm-3 col-form-label"><?php echo languageVariables("couponCountRand", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="store-coupon-edit-count" name="couponEditCount" placeholder="<?php echo languageVariables("couponCountRandPlaceholder", "store", $languageType); ?>" value="<?php echo $readCoupon["couponCount"]; ?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-coupon-edit-discount" class="col-sm-3 col-form-label"><?php echo languageVariables("couponDiscount", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-percent"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="store-coupon-edit-discount" name="couponEditDiscount" placeholder="<?php echo languageVariables("couponDiscountPlaceholder", "store", $languageType); ?>" value="<?php echo $readCoupon["discount"]; ?>">
                  </div>
                </div>
                <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editCouponToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editCoupon"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_coupon_delete", $languageType); ?>/<?php echo $readCoupon["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
      <?php } else { go(urlConverter("admin_store_coupon", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("discountCoupon", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCoupons = $db->query("SELECT * FROM discountCoupon ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>"><?php echo languageVariables("coupon", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_coupon_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_coupon_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_coupon_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCoupons) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["couponsID", "couponsCode", "couponsType", "couponsCount", "couponsOver", "couponsDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_store_coupon_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="couponsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponsCodd"><?php echo languageVariables("tableCode", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponsType"><?php echo languageVariables("tableType", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponsCount"><?php echo languageVariables("tableCount", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponsOver"><?php echo languageVariables("tableLast", "store", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="couponsDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCoupons as $readCoupons) { ?>
               <?php $activeCouponCount = $db->prepare("SELECT * FROM discountCouponHistory WHERE couponID = ?"); ?>
               <?php $activeCouponCount->execute(array($readCoupons["id"])); ?>
                <tr>
                  <td class="couponsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>/<?php echo $readCoupons["id"]; ?>">#<?php echo $readCoupons["id"]; ?></a></td>
                  <td class="couponsCode text-center"><a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>/<?php echo $readCoupons["id"]; ?>"><?php echo $readCoupons["code"]; ?></a></td>
                  <td class="couponsType text-center"><?php if ($readCoupons["type"] == 0) { echo languageVariables("couponTypeOption0", "store", $languageType); } else { echo languageVariables("couponTypeOption1", "store", $languageType); } ?></td>
                  <td class="couponsCount text-center"><?php if ($readCoupons["couponCount"] == "0-0-0-0") { echo languageVariables("unlimited", "store", $languageType); } else { echo $readCoupons["couponCount"]; } ?></td>
                  <td class="couponsOver text-center"><?php if ($readCoupons["couponCount"] == "0-0-0-0") { echo languageVariables("unlimited", "store", $languageType); } else { echo $readCoupons["couponCount"] - mysqlCount($activeCouponCount); } ?></td>
                  <td class="couponsDate text-center"><?php echo $readCoupons["date"]; ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>/<?php echo $readCoupons["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_coupon_delete", $languageType); ?>/<?php echo $readCoupons["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["couponID"])) { ?>
    <?php
    $removeCoupon = $db->prepare("DELETE FROM discountCoupon WHERE id = ?");
    $removeCoupon->execute(array(get("couponID")));
    $removeCouponHistory = $db->prepare("DELETE FROM discountCouponHistory WHERE couponID = ?");
    $removeCouponHistory->execute(array(get("couponID")));
    go(urlConverter("admin_store_coupon", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_store_coupon", $languageType)); } ?>
<?php } else if (get("action") == "general") { ?>
<?php if (AccountPermControl($readAccount["id"], "store_public") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "giftSend") { ?>
    <?php $activeUserType = false; ?>
    <?php if (isset($_GET["userID"])) { ?>
    <?php
    $searchGiftUser = $db->prepare("SELECT * FROM accounts WHERE id = ?");
    $searchGiftUser->execute(array(get("userID")));
    if (mysqlCount($searchGiftUser) > 0) {
      $readGiftUser = fetch($searchGiftUser);
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
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>"><?php echo languageVariables("send", "words", $languageType); ?></a></li>
      <?php if ($activeUserType == true) { ?>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>"><?php echo languageVariables("ivent", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readGiftUser["id"]."# ".$readGiftUser["username"]; ?></li>
      <?php } else { ?>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("ivent", "words", $languageType); ?></li>
      <?php } ?>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("sendIventCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["giftSend"])) {
            if ($safeCsrfToken->validate('addGiftToken')) {
              if (post("giftAddUsername") !== "" && post("giftAddServer") > 0 && post("giftAddCategory") > 0 && post("giftAddProduct") > 0) {
                $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                $searchPlayer->execute(array(post("giftAddUsername")));
                if (mysqlCount($searchPlayer) > 0) {
                  $readPlayer = fetch($searchPlayer);
                  $searchGiftProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                  $searchGiftProduct->execute(array(post("giftAddProduct")));
                  if (mysqlCount($searchGiftProduct) > 0) {
                    $readGiftProduct = fetch($searchGiftProduct);
                    $insertChest = $db->prepare("INSERT INTO userChest SET userID = ?, productID = ?, status = ?, date = ?");
                    $insertChest->execute(array($readPlayer["id"], $readGiftProduct["id"], 0, date("d.m.Y H:i:s")));
                    if ($readPlayer["notificationStatus"] == 1) {
                      $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                      $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("notificationMessageSend", "store", $languageType), '{"iconType":"item","username":"'.$readAccount["username"].'", "product": "'.$readGiftProduct["name"].'"}', "giftSenderAdmin", date("d.m.Y H:i:s"), "unread"));
                    }
                    echo alert(str_replace("&username", $readPlayer["username"], languageVariables("alertGiftIventSuccess", "store", $languageType)), "success", "3", "");
                  } else {
                    echo alert(languageVariables("alertGiftIventNotProduct", "store", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNotUsernameUser", "store", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-product-gift-add-username" class="col-sm-3 col-form-label"><?php echo languageVariables("username", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-product-gift-add-username" name="giftAddUsername" placeholder="<?php echo languageVariables("usernamePlaceholder", "store", $languageType); ?>" <?php if ($activeUserType == true) { ?>value="<?php echo $readGiftUser["username"]; ?>" readonly<?php } ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-gift-add-server" class="col-sm-3 col-form-label"><?php echo languageVariables("server", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-product-gift-add-server" name="giftAddServer" data-toggle="productServerID" product-category-name="productCategory">
                  <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id DESC"); ?>
                  <?php if (mysqlCount($searchServers) > 0) { ?>
                  <?php foreach ($searchServers as $readServers) { ?>
                    <option value="<?php echo $readServers["id"]; ?>"><?php echo $readServers["name"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("nowNotServerAdd", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-gift-add-category" class="col-sm-3 col-form-label"><?php echo languageVariables("productCategory", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="categoryLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-gift-add-category" name="giftAddCategory" data-toggle="categorySelect" product-category="productCategory">
                  <?php $searchServersCategory = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                  <?php if (mysqlCount($searchServersCategory) > 0) { ?>
                    <?php $readServersCategory = fetch($searchServersCategory); ?>
                    <?php $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC"); ?>
                    <?php $searchCategories->execute(array($readServersCategory["id"])); ?>
                    <?php if (mysqlCount($searchCategories) > 0) { ?>
                      <?php foreach ($searchCategories as $readCategory) { ?>
                        <option value="<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="0" selected><?php echo languageVariables("selectServerNotCategory", "store", $languageType); ?></option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-product-gift-add-product" class="col-sm-3 col-form-label"><?php echo languageVariables("product", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div data-toggle="productLoader" style="display: none;">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="text-muted"><?php echo languageVariables("loading", "store", $languageType); ?></span>
                  </div>
                  <select class="form-control" id="store-product-gift-add-product" name="giftAddProduct" data-toggle="productSelect">
                  <?php $searchServersProduct = $db->query("SELECT * FROM serverList ORDER BY id DESC LIMIT 1"); ?>
                  <?php if (mysqlCount($searchServersProduct) > 0) { ?>
                    <?php $readServersProduct = fetch($searchServersProduct); ?>
                    <?php $searchCategoriesProduct = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC LIMIT 1"); ?>
                    <?php $searchCategoriesProduct->execute(array($readServersProduct["id"])); ?>
                    <?php if (mysqlCount($searchCategoriesProduct) > 0) { ?>
                      <?php $readCategoryProduct = fetch($searchCategoriesProduct); ?>
                      <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? ORDER BY id DESC"); ?>
                      <?php $searchProducts->execute(array($readCategoryProduct["id"])); ?>
                      <?php if (mysqlCount($searchCategoriesProduct) > 0) { ?>
                        <?php foreach ($searchProducts as $readProducts) { ?>
                          <option value="<?php echo $readProducts["id"]; ?>"><?php echo $readProducts["name"]; ?></option>
                        <?php } ?>
                      <?php } else { ?>
                        <option value="0" selected><?php echo languageVariables("selectCategoryNotProduct", "store", $languageType); ?></option>
                      <?php } ?>
                    <?php } else { ?>
                      <option value="0" selected><?php echo languageVariables("selectServerNotCategory", "store", $languageType); ?></option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("pleaseAddAgoServer", "store", $languageType); ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addGiftToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="giftSend"><?php echo languageVariables("send", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "creditSend") { ?>
    <?php $activeUserType = false; ?>
    <?php if (isset($_GET["userID"])) { ?>
    <?php
    $searchGiftUser = $db->prepare("SELECT * FROM accounts WHERE id = ?");
    $searchGiftUser->execute(array(get("userID")));
    if (mysqlCount($searchGiftUser) > 0) {
      $readGiftUser = fetch($searchGiftUser);
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
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>"><?php echo languageVariables("send", "words", $languageType); ?></a></li>
      <?php if ($activeUserType == true) { ?>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>"><?php echo languageVariables("credit", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readGiftUser["id"]."# ".$readGiftUser["username"]; ?></li>
      <?php } else { ?>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("credit", "words", $languageType); ?></li>
      <?php } ?>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("sendCreditCardTitle", "store", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["creditSend"])) {
            if ($safeCsrfToken->validate('addCreditToken')) {
              if (post("creditSendUsername") !== "" && post("creditSendAmount") > 0) {
                $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                $searchPlayer->execute(array(post("creditSendUsername")));
                if (mysqlCount($searchPlayer) > 0) {
                  $readPlayer = fetch($searchPlayer);
                  $updateAccount = $db->prepare("UPDATE accounts SET credit = credit + ? WHERE id = ?");
                  $updateAccount->execute(array(post("creditSendAmount"), $readPlayer["id"]));
                  $insertHistory = $db->prepare("INSERT INTO creditHistory SET username = ?, usernameTo = ?, method = ?, type = ?, transID = ?, amount = ?, date = ?, timeStamp = ?");
                  $insertHistory->execute(array($readPlayer["username"], $readPlayer["username"], post("creditSendMethod"), 0, 0, floor(post("creditSendAmount")), date("d.m.Y H:i"), time()));
                  
                  $webhookDescription = str_replace(array("[username]", "[credit]"), array($readPlayer["username"], floor(post("creditSendAmount"))), $readWebhooks["webhookCreditDescription"]);
                  $hookObject = json_encode([
                    "username" => str_replace(array("[username]"), array($readPlayer["username"]), $readWebhooks["webhookCreditName"]),
                    "avatar_url" => avatarAPI($readPlayer["username"], 100),
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
                  if ($readPlayer["notificationStatus"] == 1) {
                    $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                    $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("sendCreditNotifications", "store", $languageType), '{"iconType":"item", "amount": "'.post("creditSendAmount").'"}', "creditUpload", date("d.m.Y H:i:s"), "unread"));
                  }
                  echo alert(str_replace(array("&username", "&credit"), array($readPlayer["username"], post("creditSendAmount")), languageVariables("alertSendCreditSuccess", "store", $languageType)), "success", "3", "");
                } else {
                  echo alert(languageVariables("alertNotUsernameUser", "store", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-credit-send-username" class="col-sm-3 col-form-label"><?php echo languageVariables("username", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="store-credit-send-username" name="creditSendUsername" placeholder="<?php echo languageVariables("usernamePlaceholder", "store", $languageType); ?>" <?php if ($activeUserType == true) { ?>value="<?php echo $readGiftUser["username"]; ?>" readonly<?php } ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-credit-send-amount" class="col-sm-3 col-form-label"><?php echo languageVariables("credit", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fa fa-dollar-sign"></span>
                      </div>
                    </div>
                    <input type="number" class="form-control" id="store-credit-send-amount" name="creditSendAmount" placeholder="<?php echo languageVariables("creditPlaceholder", "store", $languageType); ?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="store-credit-send-method" class="col-sm-3 col-form-label"><?php echo languageVariables("paymentType", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-credit-send-method" name="creditSendMethod">
                    <option value="0"><?php echo languageVariables("paymentMobile", "words", $languageType); ?></option>
                    <option value="1"><?php echo languageVariables("paymentCredit", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addCreditToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="creditSend"><?php echo languageVariables("send", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "discount") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("totalDiscount", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("discountCardTitle", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["discountSave"])) {
            if ($safeCsrfToken->validate('discountSaveToken')) {
              if (post("discountStatus") == 0 || (post("discountCount") !== "" && post("discountText") !== "")) {
                if (post("discountStatus") == 0 || post("discountCount") > 0 && 100 > post("discountCount")) {
                  if (post("discountStatus") == 0) {
                    $discountCount = 0;
                    $discountText = $readModule["storeDiscountText"];
                  } else if (post("discountStatus") == 1) {
                    $discountCount = post("discountCount");
                    $discountText = post("discountText");
                  }
                  $updateModule = $db->prepare("UPDATE module SET storeDiscount = ?, storeDiscountStatus = ?, storeDiscountText = ? WHERE id = ?");
                  $updateModule->execute(array($discountCount, post("discountStatus"), $discountText, 0));
                  echo alert(languageVariables("alertSaveChanges", "store", $languageType), "success", "3", "");
                } else {
                  echo alert(languageVariables("alertDiscountCouponAmount", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-discount-status" class="col-sm-3 col-form-label"><?php echo languageVariables("discountStatus", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-discount-status" name="discountStatus" store-discount="status">
                    <option value="0" <?php if ($readModule["storeDiscountStatus"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readModule["storeDiscountStatus"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div store-discount="input" <?php if ($readModule["storeDiscountStatus"] == 0) { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-discount-count" class="col-sm-3 col-form-label"><?php echo languageVariables("couponDiscount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-percent"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-discount-count" name="discountCount" placeholder="<?php echo languageVariables("couponDiscountPlaceholder", "store", $languageType); ?>" value="<?php echo $readModule["storeDiscount"]; ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
                </div>
                <div class="form-group row">
                  <label for="store-discount-text" class="col-sm-3 col-form-label"><?php echo languageVariables("discountText", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="store-discount-text" name="discountText" placeholder="<?php echo languageVariables("discountTextPlaceholder", "store", $languageType); ?>"><?php echo $readModule["storeDiscountText"]; ?></textarea>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("discountTextNote", "store", $languageType); ?></span>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("discountSaveToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="discountSave"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "extraCredit") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("extraCredit", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("extraCreditCardTitle", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["extraCreditSave"])) {
            if ($safeCsrfToken->validate('extraCreditSaveToken')) {
              if (post("extraCreditStatus") == 0 || (post("extraCreditCount") !== "" && post("extraCreditText") !== "")) {
                if (post("extraCreditStatus") == 0 || post("extraCreditCount") > 0) {
                  if (post("extraCreditStatus") == 0) {
                    $extraCreditCount = 0;
                    $extraCreditText = $readModule["extraCreditText"];
                  } else if (post("extraCreditStatus") == 1) {
                    $extraCreditCount = post("extraCreditCount");
                    $extraCreditText = post("extraCreditText");
                  }
                  $updateModule = $db->prepare("UPDATE module SET extraCredit = ?, extraCreditStatus = ?, extraCreditText = ? WHERE id = ?");
                  $updateModule->execute(array($extraCreditCount, post("extraCreditStatus"), $extraCreditText, 0));
                  echo alert(languageVariables("alertSaveChanges", "store", $languageType), "success", "3", "");
                } else {
                  echo alert(languageVariables("alertExtraCreditBounce", "store", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "store", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "store", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="store-extra-credit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("extraCreditStatus", "store", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" id="store-extra-credit-status" name="extraCreditStatus" store-extra-credit="status">
                    <option value="0" <?php if ($readModule["extraCreditStatus"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readModule["extraCreditStatus"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div store-extra-credit="input" <?php if ($readModule["extraCreditStatus"] == 0) { echo "style=\"display: none;\""; } ?>>
                <div class="form-group row">
                  <label for="store-extra-credit-count" class="col-sm-3 col-form-label"><?php echo languageVariables("extraCreditCount", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fa fa-percent"></span>
                        </div>
                      </div>
                      <input type="number" class="form-control" id="store-extra-credit-count" name="extraCreditCount" placeholder="<?php echo languageVariables("extraCreditCountPlaceholder", "store", $languageType); ?>" value="<?php echo $readModule["extraCredit"]; ?>">
                    </div>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("productDiscountCountNote", "store", $languageType); ?></span>
                </div>
                <div class="form-group row">
                  <label for="store-extra-credit-text" class="col-sm-3 col-form-label"><?php echo languageVariables("extraCreditText", "store", $languageType); ?></label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="store-extra-credit-text" name="extraCreditText" placeholder="<?php echo languageVariables("extraCreditTextPlaceholder", "store", $languageType); ?>"><?php echo $readModule["extraCreditText"]; ?></textarea>
                  </div>
                  <span class="col-sm-12 mt-2"><?php echo languageVariables("extraCreditTextNote", "store", $languageType); ?></span>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("extraCreditSaveToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="extraCreditSave"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } else if (get("target") == "history") { ?>
    <?php if (get("category") == "store") { ?>
      <?php
      if (isset($_GET["id"])) {
        $removeHistory = $db->prepare("DELETE FROM storeHistory WHERE id = ?");
        $removeHistory->execute(array(get("id")));
        go(urlConverter("admin_store_history_store", $languageType));
      }
      ?>
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
      $pageItemCount = pageItemCount("storeHistory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_history_store", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("store", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_store_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_store_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_store_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchStoreHistory) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "historiesUserName", "historiesProductName", "historiesProductCategory", "historiesProductServer", "historiesProductPrice", "historiesDate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductName"><?php echo languageVariables("product", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductPrice"><?php echo languageVariables("price", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
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
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>">#<?php echo $readStoreHistory["id"]; ?></a></td>
                  <td class="historiesUserName text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>"><?php echo $readStoreHistory["username"]; ?></a></td>
                  <td class="historiesProductName text-center"><?php echo $readProducts["name"]; ?></td>
                  <td class="historiesProductCategory text-center"><?php echo $readCategory["name"]; ?></td>
                  <td class="historiesProductServer text-center"><?php echo $readServer["name"]; ?></td>
                  <td class="historiesProductPrice text-center"><?php echo $readStoreHistory["productPrice"]; ?> <?php echo languageVariables("credit", "words", $languageType); ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readStoreHistory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_history_store_delete", $languageType); ?>/<?php echo $readStoreHistory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } else if (get("category") == "credit") { ?>
      <?php
      if (isset($_GET["id"])) {
        $removeHistory = $db->prepare("DELETE FROM creditHistory WHERE id = ?");
        $removeHistory->execute(array(get("id")));
        go(urlConverter("admin_store_history_credit", $languageType));
      }
      ?>
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
      $pageItemCount = pageItemCount("creditHistory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCreditHistory = $db->query("SELECT * FROM creditHistory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_history_credit", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("credit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_credit_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_credit_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_credit_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCreditHistory) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "historiesUserName", "historiesMethod", "historiesAmount", "historiesType", "historiesDate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesMethod"><?php echo languageVariables("method", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesAmount"><?php echo languageVariables("amount", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesType"><?php echo languageVariables("trans", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <tr>
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>">#<?php echo $readCreditHistory["id"]; ?></a></td>
                  <td class="historiesUserName text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>"><?php echo $readCreditHistory["username"]; ?></a></td>
                  <td class="historiesMethod text-center"><?php if ($readCreditHistory["type"] == 0) { if ($readCreditHistory["method"] == 0) { echo "<span class=\"fa fa-mobile\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("paymentMobile", "words", $languageType)."\"></span>"; } else { echo "<span class=\"far fa-credit-card\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("paymentCredit", "words", $languageType)."\"></span>"; } } else { echo "<span class=\"far fa-paper-plane\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".str_replace("&username", $readCreditHistory["usernameTo"], languageVariables("sendText", "store", $languageType))."\"></span>"; } ?></td>
                  <td class="historiesAmount text-center"><?php echo $readCreditHistory["amount"]; ?></td>
                  <td class="historiesType text-center"><?php if ($readCreditHistory["type"] == 0) { echo languageVariables("uplaoding", "words", $languageType); } else { echo languageVariables("sending", "words", $languageType); } ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readCreditHistory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_history_credit_delete", $languageType); ?>/<?php echo $readCreditHistory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } else if (get("category") == "chest") { ?>
      <?php
      if (isset($_GET["id"])) {
        $removeHistory = $db->prepare("DELETE FROM chestHistory WHERE id = ?");
        $removeHistory->execute(array(get("id")));
        go(urlConverter("admin_store_history_credit", $languageType));
      }
      ?>
      <?php
      if (isset($_GET["id"])) {
        $removeHistory = $db->prepare("DELETE FROM creditHistory WHERE id = ?");
        $removeHistory->execute(array(get("id")));
        go(urlConverter("admin_store_history_credit", $languageType));
      }
      ?>
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
      $pageItemCount = pageItemCount("chestHistory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchChestHistory = $db->query("SELECT * FROM chestHistory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_history_chest", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("chest", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_chest_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_chest_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_history_chest_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchChestHistory) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "historiesUserName", "historiesMethod", "historiesProductName", "historiesProductServer", "historiesProductPrice", "historiesDate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesMethod"><?php echo languageVariables("trans", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductName"><?php echo languageVariables("product", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesProductPrice"><?php echo languageVariables("productPrice", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchChestHistory as $readChestHistory) { ?>
                <tr>
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readChestHistory["username"]; ?>">#<?php echo $readChestHistory["id"]; ?></a></td>
                  <td class="historiesUserName text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readChestHistory["username"]; ?>"><?php echo $readChestHistory["username"]; ?></a></td>
                  <td class="historiesMethod text-center"><?php if ($readChestHistory["type"] == 0) { echo "<span class=\"fa fa-check\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".languageVariables("productCheck", "words", $languageType)."\"></span>"; } else { echo "<span class=\"fa fa-gift\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".str_replace("&username", $readChestHistory["usernameTo"], languageVariables("sendText", "store", $languageType))."\"></span>"; } ?></td>
                  <td class="historiesProductName text-center"><?php echo $readChestHistory["productName"]; ?></td>
                  <td class="historiesProductServer text-center"><?php echo $readChestHistory["serverName"]; ?></td>
                  <td class="historiesProductPrice text-center"><?php echo $readChestHistory["productPrice"]." ".languageVariables("credit", "words", $languageType); ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readChestHistory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_history_chest_delete", $languageType); ?>/<?php echo $readChestHistory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "payments") { ?>
    <?php if (isset($_GET["id"])) { ?>
      <?php 
        $searchPaymentTransaction = $db->prepare("SELECT * FROM paymentTransactions WHERE id = ?");
        $searchPaymentTransaction->execute(array(get("id")));
        if ($searchPaymentTransaction->rowCount() == 0) {
          go(urlConverter("admin_store_payments", $languageType));
        }
        $readPaymentTransaction = $searchPaymentTransaction->fetch();
        $readPaymentTransactionData = json_decode($readPaymentTransaction["variables"], true);
        $searchPaymentTransactionAccount = $db->prepare("SELECT id, username, email FROM accounts WHERE id = ?");
        $searchPaymentTransactionAccount->execute(array($readPaymentTransactionData["userID"]));
        $readPaymentTransactionAccount = $searchPaymentTransactionAccount->fetch();
        $readPaymentTransactionSafeAmount = $readPaymentTransactionData["amount"];
        if (isset($readPaymentTransactionData["vat"]) && $readPaymentTransactionData["vat"] > 0) {
          $readPaymentTransactionData["amount"] = number_format($readPaymentTransactionData["amount"]+($readPaymentTransactionData["amount"]*($readPaymentTransactionData["vat"]/100)), 2);
        }
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_store_payments", $languageType); ?>"><?php echo languageVariables("payments", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo "#INV-".$readPaymentTransaction["id"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <p style="position: absolute; left: 5rem; top: 15rem; color: rgba(209, 213, 219, 0.2); font-size: 10rem; transform: rotate(315deg);"><?php echo $rSettings["serverName"]; ?></p>
          <div class="container-fluid d-flex justify-content-between row">
            <div class="col-12 col-md-6 col-lg-6 ps-0">
              <a class="noble-ui-logo d-block mt-3"><img src="<?php echo $rSettings["serverLogo"]; ?>" width="100"></a>
              <h5 class="mt-5 mb-2 text-muted"><?php echo languageVariables("invoiceTo", "words", $languageType); ?>:</h5>
              <p><span class="text-muted"><?php echo languageVariables("username", "words", $languageType); ?>: </span> <?php echo $readPaymentTransactionAccount["username"]; ?> <br> <span class="text-muted"><?php echo languageVariables("email", "words", $languageType); ?>: </span> <?php echo $readPaymentTransactionAccount["email"]; ?></p>
            </div>
            <div class="col-12 col-md-6 col-lg-6 pe-0">
              <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"><?php echo languageVariables("invoice", "words", $languageType); ?></h4>
              <h6 class="text-end mb-5 pb-4"># INV-<?php echo $readPaymentTransaction["id"]; ?></h6>
              <p class="text-end mb-1"><?php echo languageVariables("paidAmount", "words", $languageType); ?></p>
              <h4 class="text-end fw-normal"><?php echo $readPaymentTransactionData["amount"].$rSettings["currency"]; ?></h4>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("status", "words", $languageType); ?> :</span> <?php echo (($readPaymentTransaction["status"] == "0") ? "<span class=\"badge badge-pill badge-danger mr-2\">".languageVariables("unpaid", "words", $languageType)."</span>" : "<span class=\"badge badge-pill badge-success mr-2\">".languageVariables("paid", "words", $languageType)."</span>"); ?></h6>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("method", "words", $languageType); ?> :</span> <?php echo (($readPaymentTransactionData["method"] == "0") ? languageVariables("paymentMobile", "words", $languageType) : languageVariables("paymentCredit", "words", $languageType)); ?></h6>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("paymentAPIType", "words", $languageType); ?> :</span> <?php echo $readPaymentTransaction["paymentAPIType"]; ?></h6>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("paymentID", "words", $languageType); ?> :</span> <?php echo $readPaymentTransaction["paymentID"]; ?></h6>
              <?php if ($readPaymentTransactionData["txn_id"] !== NULL) { ?>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo "PayPal ID"; ?> :</span> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=<?php echo $readPaymentTransactionData["txn_id"]; ?>" target="_blank"><?php echo $readPaymentTransactionData["txn_id"]; ?></a></h6>
              <?php } ?>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("transactionID", "words", $languageType); ?> :</span> <?php echo $readPaymentTransactionData["transID"]; ?></h6>
              <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted"><?php echo languageVariables("invoiceDate", "words", $languageType); ?> :</span> <?php echo checkTime($readPaymentTransaction["date"], 2, true); ?></h6>
            </div>
          </div>
          <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th><?php echo languageVariables("description", "words", $languageType); ?></th>
                    <th class="text-end"><?php echo languageVariables("count", "words", $languageType); ?></th>
                    <th class="text-end"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-end">
                    <td class="text-start">1</td>
                    <td class="text-start"><?php echo $rSettings["serverName"]." Credit Upload"; ?></td>
                    <td>01</td>
                    <td><?php echo number_format($readPaymentTransactionSafeAmount, 2); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="container-fluid mt-5 w-100">
            <div class="row">
              <div class="col"></div>
              <div class="col-auto ms-auto">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td><?php echo languageVariables("subTotal", "words", $languageType); ?></td>
                        <td class="text-end"><?php echo number_format($readPaymentTransactionSafeAmount, 2).$rSettings["currency"]; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo languageVariables("tax", "words", $languageType); ?> (<?php echo ((isset($readPaymentTransactionData["vat"])) ? $readPaymentTransactionData["vat"] : 0); ?>%)</td>
                        <?php if (isset($readPaymentTransactionData["vat"]) && $readPaymentTransactionData["vat"] > 0) { ?>
                        <td class="text-end"><?php echo number_format($readPaymentTransactionSafeAmount*($readPaymentTransactionData["vat"]/100), 2).$rSettings["currency"]; ?></td>
                        <?php } else { ?>
                        <td class="text-end"><?php echo "0.00".$rSettings["currency"]; ?></td>
                        <?php } ?>
                      </tr>
                      <tr>
                        <td class="text-bold-800"><?php echo languageVariables("paidAmount", "words", $languageType); ?></td>
                        <td class="text-bold-800 text-end"> <?php echo number_format($readPaymentTransactionData["amount"], 2).$rSettings["currency"]; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } else if (isset($_GET["removeID"])) { ?>
      <?php 
        $removePayment = $db->prepare("DELETE FROM paymentTransactions WHERE id = ?");
        $removePayment->execute(array(get("removeID")));
        go(urlConverter("admin_store_payments", $languageType));
      ?>
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
      $pageItemCount = pageItemCount("paymentTransactions", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
    <?php
    if (get("status") == "paid") {
      $searchPaymentTransactions = $db->prepare("SELECT * FROM paymentTransactions WHERE status = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
      $searchPaymentTransactions->execute(array(1));
    } else if (get("status") == "unpaid") {
      $searchPaymentTransactions = $db->prepare("SELECT * FROM paymentTransactions WHERE status = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
      $searchPaymentTransactions->execute(array(0));
    } else {
      $searchPaymentTransactions = $db->query("SELECT * FROM paymentTransactions ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount");
    }
    ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("payments", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_payments_p", $languageType)."/".get("status")."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_payments_p", $languageType)."/".get("status")."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_store_payments_p", $languageType)."/".get("status")."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
      <div class="row flex-grow">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("allTime", "words", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="allEarn"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart4" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("thisYear", "words", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="yearEarn"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("thisMonth", "words", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="monthEarn"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("today", "words", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="todayEarn"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card" data-toggle="lists" data-lists-values='["historiesID", "username", "status", "amount", "method, "paymentType", "paymentID", "transID", "historiesDate"]'>
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
              <a class="nav-link dropdown-toggle" id="statusDropdowns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo languageVariables(get("status"), "words", $languageType); ?></a>
              <div class="dropdown-menu" aria-labelledby="statusDropdowns">
			          <a href="<?php echo urlConverter("admin_store_payments", $languageType)."/all"; ?>" class="dropdown-item py-2"><?php echo languageVariables("all", "words", $languageType); ?></a>
			          <a href="<?php echo urlConverter("admin_store_payments", $languageType)."/paid"; ?>" class="dropdown-item py-2"><?php echo languageVariables("paid", "words", $languageType); ?></a>
			          <a href="<?php echo urlConverter("admin_store_payments", $languageType)."/unpaid"; ?>" class="dropdown-item py-2"><?php echo languageVariables("unpaid", "words", $languageType); ?></a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <?php if (mysqlCount($searchPaymentTransactions) > 0) { ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="historiesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="username"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="status"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="amount"><?php echo languageVariables("amount", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="method"><?php echo languageVariables("method", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="paymentType"><?php echo languageVariables("paymentAPIType", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="paymentID"><?php echo languageVariables("paymentID", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="transID"><?php echo languageVariables("transactionID", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="historiesDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPaymentTransactions as $readPaymentTransaction) { ?>
                <?php
                  $readPaymentTransactionData = json_decode($readPaymentTransaction["variables"], true);
                  $searchPaymentTransactionAccount = $db->prepare("SELECT id, username FROM accounts WHERE id = ?");
                  $searchPaymentTransactionAccount->execute(array($readPaymentTransactionData["userID"]));
                  $readPaymentTransactionAccount = $searchPaymentTransactionAccount->fetch();
                  if (isset($readPaymentTransactionData["vat"]) && $readPaymentTransactionData["vat"] > 0) {
                    $readPaymentTransactionData["amount"] = number_format($readPaymentTransactionData["amount"]+($readPaymentTransactionData["amount"]*($readPaymentTransactionData["vat"]/100)), 2);
                  }
                ?>
                <tr>
                  <td class="historiesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_store_payments", $languageType); ?>/<?php echo $readPaymentTransaction["id"]; ?>"><?php echo "#INV-".$readPaymentTransaction["id"]; ?></a></td>
                  <td class="username text-center"><a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readPaymentTransactionAccount["username"]; ?>"><?php echo $readPaymentTransactionAccount["username"]; ?></a></td>
                  <td class="status text-center"><?php echo (($readPaymentTransaction["status"] == "0") ? "<span class=\"badge badge-pill badge-danger mr-2\">".languageVariables("unpaid", "words", $languageType)."</span>" : "<span class=\"badge badge-pill badge-success mr-2\">".languageVariables("paid", "words", $languageType)."</span>"); ?></td>
                  <td class="amount text-center"><?php echo $readPaymentTransactionData["amount"].languageVariables("currencyIcon", "words", $languageType); ?></td>
                  <td class="method text-center"><?php echo (($readPaymentTransactionData["method"] == "0") ? languageVariables("paymentMobile", "words", $languageType) : languageVariables("paymentCredit", "words", $languageType)); ?></td>
                  <td class="paymentType text-center"><?php echo $readPaymentTransaction["paymentAPIType"]; ?></td>
                  <td class="paymentID text-center"><?php echo $readPaymentTransaction["paymentID"]; ?></td>
                  <td class="transID text-center"><?php echo $readPaymentTransactionData["transID"]; ?></td>
                  <td class="historiesDate text-center"><?php echo checkTime($readPaymentTransaction["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-primary btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_store_payment", $languageType); ?>/<?php echo $readPaymentTransaction["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_store_payment_delete", $languageType); ?>/<?php echo $readPaymentTransaction["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } else { echo "<div class=\"p-3\">".alert(languageVariables("alertPageNone", "store", $languageType), "danger", "0", "/")."</div>"; } ?>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } ?>
<?php } ?>