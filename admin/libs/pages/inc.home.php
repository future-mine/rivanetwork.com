<?php if (get("action") == "perm-error") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("permissionError", "home", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12">
      <?php echo alert(languageVariables("alertPermissionError", "home", $languageType), "danger", "0", "/"); ?>
    </div>
  </div>
</div>
<?php } else { ?>
<?php if (AccountPermControl($readAccount["id"], "statistics") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php
  $creditHistory = $db->prepare("SELECT * FROM creditHistory WHERE type = ? ORDER BY id DESC LIMIT 6");
  $creditHistory->execute(array(0));
  $storeHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 6");
  $accountsHistory = $db->query("SELECT * FROM accounts ORDER BY id DESC LIMIT 6");

  for ($i=1, $yearEarnedMoneyData=null; $i <= 12; $i++) {
    $month = sprintf("%02d", $i);
    $earnedMoney = $db->prepare("SELECT SUM(amount) AS amount FROM creditHistory WHERE date LIKE ? AND type = ?");
    $earnedMoney->execute(array("%".$month.".".date("Y")."%", 0));
    $readEarnedMoney = fetch($earnedMoney);
    if ($readEarnedMoney["amount"] == null) {
      $readEarnedMoney["amount"] = 0;
    }
    $yearEarnedMoneyData .= $readEarnedMoney["amount"].",";
  }
  $yearEarnedMoneyData = rtrim($yearEarnedMoneyData, ",");
  $statsData = explode(",", $yearEarnedMoneyData);
  
  $earnedMoney = $db->prepare("SELECT SUM(amount) AS earnings FROM creditHistory WHERE date LIKE ? AND type = ?");
  $earnedMoney->execute(array("%".date("Y")."%", 0));
  $readEarnedMoney = fetch($earnedMoney);
  if ($readEarnedMoney["earnings"] == null) {
    $readEarnedMoney["earnings"] = 0;
  }
?>
<script type="text/javascript">
var $ChartOne = <?php echo $statsData[0]; ?>;
var $ChartTwo = <?php echo $statsData[1]; ?>;
var $ChartThree = <?php echo $statsData[2]; ?>;
var $ChartFour = <?php echo $statsData[3]; ?>;
var $ChartFive = <?php echo $statsData[4]; ?>;
var $ChartSix = <?php echo $statsData[5]; ?>;
var $ChartSeven = <?php echo $statsData[6]; ?>;
var $ChartEight = <?php echo $statsData[7]; ?>;
var $ChartNine = <?php echo $statsData[8]; ?>;
var $ChartTen = <?php echo $statsData[9]; ?>;
var $ChartEleven = <?php echo $statsData[10]; ?>;
var $ChartTwoteen = <?php echo $statsData[11]; ?>;
var $ChartMax = <?php echo $readEarnedMoney["earnings"]; ?>;
</script>
<div class="page-content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0"><?php echo languageVariables("dashboard", "words", $languageType); ?></h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
      <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
        <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
        <input type="text" class="form-control">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
      <div class="row flex-grow">
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("totalEarn", "home", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="totalEarn"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("totalSales", "home", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="totalSales"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0"><?php echo languageVariables("totalRegister", "home", $languageType); ?></h6>
              </div>
              <div class="row">
                <div class="col-6 col-md-12 col-xl-5">
                  <h3 class="mb-2" server-data="totalRegister"><div class="spinner-border" role="status"><span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span></div></h3>
                </div>
                <div class="col-6 col-md-12 col-xl-7">
                  <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <h6 class="card-title mb-0"><?php echo languageVariables("yearEarn", "home", $languageType); ?></h6>
          </div>
          <p class="text-muted mb-4"><?php echo str_replace("&year", date("Y"), languageVariables("yearEarnDescription", "home", $languageType)); ?></p>
          <div class="monthly-sales-chart-wrapper">
            <canvas id="monthly-sales-chart"></canvas>
          </div>
        </div> 
      </div>
    </div>
  </div>
  <div class="row flex-grow">
    <div class="col-md-4 grid-margin">
      <?php if (mysqlCount($storeHistory) > 0) { ?>
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <h4 class="card-header-title"><?php echo languageVariables("storeHistory", "home", $languageType); ?></h4>
            </div>
            <div class="col-auto">
              <a class="small" href="<?php echo urlConverter("admin_store_history_store", $languageType); ?>"><?php echo languageVariables("all", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive mb-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th><?php echo languageVariables("username", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("product", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($storeHistory as $readStoreHistory) { ?>
              <?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
              <?php $searchServer->execute(array($readStoreHistory["serverID"])); ?>
              <?php if (mysqlCount($searchServer) > 0) { ?>
              <?php $readServer = fetch($searchServer); ?>
                <tr>
                  <td>
                    <a class="avatar avatar-xs d-inline-block" href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>">
                      <img src="<?php echo avatarAPI($readStoreHistory["username"], 20); ?>" alt="<?php echo languageVariables("playerAvatar", "home", $languageType); ?>" class="rounded-circle">
                    </a>
                  </td>
                  <td>
                    <a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>"><?php echo $readStoreHistory["username"]; ?></a>
                  </td>
                  <td class="text-center"><?php echo $readStoreHistory["productName"]; ?></td>
                  <td class="text-center"><?php echo $readServer["name"]; ?></td>
                  <td class="text-center"><?php echo $readStoreHistory["productPrice"]; ?> <?php echo languageVariables("credit", "home", $languageType); ?></td>
                </tr>
              <?php } ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertStoreHistory", "home", $languageType), "danger", "0", "/"); } ?>
    </div>
    <div class="col-md-4 grid-margin">
      <?php if (mysqlCount($creditHistory) > 0) { ?>
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <h4 class="card-header-title"><?php echo languageVariables("creditUploadHistory", "home", $languageType); ?></h4>
            </div>
            <div class="col-auto">
              <a class="small" href="<?php echo urlConverter("admin_store_history_credit", $languageType); ?>"><?php echo languageVariables("all", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive mb-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th><?php echo languageVariables("username", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("method", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($creditHistory as $readCreditHistory) { ?>
                <tr>
                  <td>
                    <a class="avatar avatar-xs d-inline-block" href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>">
                      <img src="<?php echo avatarAPI($readCreditHistory["username"], 20); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>" class="rounded-circle">
                    </a>
                  </td>
                  <td>
                    <a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readCreditHistory["username"]; ?>"><?php echo $readCreditHistory["username"]; ?></a>
                  </td>
                  <td class="text-center"><?php echo $readCreditHistory["amount"]; ?></td>
                  <td class="text-center"><?php if ($readCreditHistory["method"] == "0") { echo languageVariables("paymentMobile", "words", $languageType); } else { echo languageVariables("paymentCredit", "words", $languageType); } ?></td>
                  <td class="text-center"><?php echo checkTime($readCreditHistory["date"]); ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertCreditUploadHistory", "home", $languageType), "danger", "0", "/"); } ?>
    </div>
    <div class="col-md-4 grid-margin">
    <?php if (mysqlCount($accountsHistory) > 0) { ?>
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <h4 class="card-header-title"><?php echo languageVariables("lastRegisterHistory", "home", $languageType); ?></h4>
            </div>
            <div class="col-auto">
              <a class="small" href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("all", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive mb-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th><?php echo languageVariables("username", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  <th class="text-center"><?php echo languageVariables("IPAdress", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($accountsHistory as $readAccountsHistory) { ?>
                <tr>
                  <td>
                    <a class="avatar avatar-xs d-inline-block" href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readAccountsHistory["username"]; ?>">
                      <img src="<?php echo avatarAPI($readAccountsHistory["username"], 20); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>" class="rounded-circle">
                    </a>
                  </td>
                  <td>
                    <a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readAccountsHistory["username"]; ?>"><?php echo $readAccountsHistory["username"]; ?></a>
                  </td>
                  <td class="text-center"><?php echo checkTime($readAccountsHistory["registerDate"]); ?></td>
                  <td class="text-center"><?php echo $readAccountsHistory["ip"]; ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertLastRegisterHistory", "home", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
<?php } ?>