<?php 
if ($readModule["broadcastStatus"] == "1") {
  $searchBroadcastOne = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT 4");
  if ($searchBroadcastOne->rowCount() > 0) {
?>
<section>
  <div class="owl-carousel owl-theme owl-loaded">
    <div class="owl-stage-outer h-80 bg-gray-100/75 overflow-hidden sliders">
      <div class="owl-stage">
        <?php foreach ($searchBroadcastOne as $readBroadcastOne) { ?>
        <a href="<?php echo $readBroadcastOne["url"]; ?>" class="owl-item" style="background-image: url('<?php echo $readBroadcastOne["image"]; ?>')">
          <div class="relative z-20 sliders-content">
            <div class="h1 text-white slider-mob-h1 my-auto mx-auto"><?php echo $readBroadcastOne["title"]; ?></div>
            <p class="mt-2 text-white text-center slider-mob-h2 my-auto mx-auto" style="font-size: 1.4rem;"><?php echo $readBroadcastOne["text"]; ?></p>
          </div>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php } } ?>
<?php
if (isset($_GET["news"])) {
  if (!is_numeric(get("news"))) {
    $_GET["news"] = 1;
  }
  $newsPage = intval(get("news"));
} else {
  $newsPage = 1;
}

$newsCount = $db->prepare("SELECT * FROM newsList ORDER BY id");
$newsCount->execute();
$newsItemsCount = $newsCount->rowCount();
$sectionPageItemCount = ceil($newsItemsCount/6);

if ($newsPage > $sectionPageItemCount) {
  $newsPage = 1;
}

$newsPageSubCount = 6;
$newsPageItemCount = $newsPage * $newsPageSubCount - $newsPageSubCount;
// PC
if ($newsPage == $sectionPageItemCount || $newsPage == 1) {
  $sectionMaxPageItemCount = 5;
} else {
  $sectionMaxPageItemCount = 4;
}

// MOBILE
if ($newsPage == $sectionPageItemCount || $newsPage == 1) {
  $sectionMaxPageItemCountMobile = 2;
} else {
  $sectionMaxPageItemCountMobile = 1;
}
?>
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto lg:grid lg:grid-cols-10 gap-16 px-4 md:px-0">
    <div class="lg:col-span-7 flex flex-col gap-16">
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
              <a href="<?php echo urlConverter("news", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("news", "words", $languageType); ?></a>
            </div>
          </li>
        </ol>
      </nav>

      <div>
      <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT $newsPageItemCount, $newsPageSubCount"); ?>
        <div class="grid gap-12 <?php echo (($searchNews->rowCount() > 0) ? "lg:grid-cols-2" : "lg:grid-cols-1"); ?>">
          <?php if ($searchNews->rowCount() > 0) { ?>
          <?php foreach($searchNews as $readNews) { ?>
          <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>" class="rounded-2xl relative h-[18rem] overflow-hidden group bg-cover bg-center" style="background-image: url('<?php echo $readNews["image"]; ?>')">
            <div class="absolute top-0 -left-full w-full group-hover:left-0 transition-all h-full">
              <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-indigo-700/25 to-black/25"></div>
              <div class="relative z-10 p-10 flex flex-col h-full">
                <dt class="fw-bold text-white fs-3 max-w-lg leading-7"><span class="text-emerald-400"><?php echo $readNews["categoryName"]; ?></span> - <?php echo $readNews["title"]; ?></dt>
                <dd class="mt-5 text-indigo-100 max-w-lg"><?php echo contentShort(strip_tags($readNews["text"]), 60); ?></dd>
                <div class="flex justify-between items-center mt-auto">
                  <div class="btn btn-primary"><?php echo languageVariables("moreRead", "words", $languageType); ?></div>
                  <div class="flex gap-3 text-xs font-medium">
                    <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                      <i class="fas fa-eye"></i> <?php echo $readNews["newsDisplay"]; ?>
                    </div>
                    <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                      <i class="fas fa-heart"></i> <?php echo $readNews["newsHearts"]; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <span class="absolute top-8 right-12 rounded-xl bg-emerald-500 text-white py-2 px-4 fs-8 uppercase fw-medium group-hover:-right-full transition-all"><?php echo $readNews["categoryName"]; ?></span>
            <div class="absolute bottom-0 left-0 w-full py-5 px-10 overflow-hidden transform group-hover:translate-y-full transition-all">
              <div class="absolute top-0 left-0 w-full h-full bg-black/50 blur-sm"></div>
              <div class="relative z-10">
                <dt class="fw-bold text-white fs-4"><?php echo $readNews["title"]; ?></dt>
                <dd class="mt-1 text-white/75"><?php echo contentShort(strip_tags($readNews["text"]), 60); ?></dd>
              </div>
            </div>
          </a>
          <?php } } else { echo alert(languageVariables("alertNotNews", "home", $languageType), "danger", "0", "/"); } ?>
          <?php if ($searchNews->rowCount() > 0) { ?>
          <div class="lg:col-span-2 mb-3">
            <div class="mt-12 pagination">
              <a <?php if ($newsPage !== 1) { ?>href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage-1; ?>"<?php } ?> class="item <?php echo (($newsPage == 1) ? "disable" : ""); ?>"><i class="fas fa-angle-left"></i></a>
              <?php
              for ($i = $newsPage - $sectionMaxPageItemCountMobile; $i < $newsPage + $sectionMaxPageItemCountMobile + $newsPage; $i++) {
                if ($i > 0 and $sectionPageItemCount >= $i) {
              ?>
              <a href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $i; ?>" class="item <?php echo (($newsPage == $i) ? "active" : ""); ?>"><?php echo $i; ?></a>
              <?php } } ?>
              <a <?php if ($newsPage != $sectionPageItemCount) { ?>href="<?php echo urlConverter("news", $languageType); ?>/<?php echo $newsPage+1; ?>"<?php } ?> class="item <?php echo (($newsPage == $sectionPageItemCount) ? "disable" : ""); ?>"><i class="fas fa-angle-right"></i></a>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="lg:col-span-3 flex flex-col gap-12">
      <?php 
      $secondsPassed = time()-date('d')*86400;
      $topTotalCredit = $db->prepare("SELECT SUM(amount) as amount, username FROM creditHistory WHERE timeStamp > ? AND type = ? GROUP BY username ORDER BY amount DESC LIMIT 1");
      $topTotalCredit->execute(array($secondsPassed, 0));
      if ($topTotalCredit->rowCount() > 0) {
        $readTopTotalCredit = $topTotalCredit->fetch();
        $topDonatorCreditAmount = $db->prepare("SELECT * FROM creditHistory WHERE timeStamp > ? AND username = ? AND type = ?");
        $topDonatorCreditAmount->execute(array($secondsPassed, $readTopTotalCredit["username"], 0));
        $topDonatorAmount = $topDonatorCreditAmount->rowCount();
      }
      ?>
      <div>
        <?php if ($topTotalCredit->rowCount() > 0) { ?>
        <h4 class="h4"><?php echo languageVariables("topDonatorTitle", "words", $languageType); ?></h4>
        <div class="mt-4 rounded-2xl bg-primary p-6 flex justify-between">
          <div class="rounded-xl py-3 px-6 bg-indigo-400/25 text-indigo-100 flex flex-col justify-center items-center">
            <p class="fw-extrabold fs-4"><?php echo $readTopTotalCredit["amount"]; ?></p>
            <span><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span>
          </div>
          <div class="flex gap-2 items-center">
            <div class="text-right">
              <p class="text-indigo-50 h4"><?php echo $readTopTotalCredit["username"]; ?></p>
              <span class="text-indigo-200 fs-10"><?php echo str_replace("&count", $topDonatorAmount, languageVariables("creditUploadCount", "words", $languageType)); ?></span>
            </div>
            <div class="bg-cover bg-top w-24 h-36 transform -scale-x-100 rounded-bl-2xl -mt-14" style="background-image: url('https://mc-heads.net/body/<?php echo $readTopTotalCredit["username"]; ?>')"></div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div>
        <h4 class="h4"><?php echo languageVariables("storeHistoryTitle", "home", $languageType); ?></h4>
        <?php $searchStoreHistoryOne = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 1"); ?>
        <?php if ($searchStoreHistoryOne->rowCount() > 0) { ?>
        <?php $readStoreHistoryOne = $searchStoreHistoryOne->fetch(); ?>
        <?php $searchServerListOne = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
        <?php $searchServerListOne->execute(array($readStoreHistoryOne["serverID"])); ?>
        <?php $readServerListOne = $searchServerListOne->fetch(); ?>
        <?php $searchStoreHistory = $db->prepare("SELECT * FROM storeHistory WHERE id != ? ORDER BY id DESC LIMIT 5"); ?>
        <?php $searchStoreHistory->execute(array($readStoreHistoryOne["1"])); ?>
        <?php if ($searchStoreHistory->rowCount() > 0) { ?>
        <div class="mt-4 card">
          <div class="rounded-2xl flex items-center justify-center bg-indigo-500/25 w-14 h-14 absolute -top-5 -right-5">
            <i class="fas fa-basket-shopping text-indigo-500 fs-5"></i>
          </div>
          <div class="relative overflow-hidden border-b-2 border-gray-200/25">
            <div class="absolute bottom-0 left-1/2 shadow-3xl shadow-emerald-400/10"></div>
            <div class="p-6 flex gap-3 items-center relative z-10">
              <img class="h-14 w-14 rounded-xl" src="https://minotar.net/avatar/<?php echo $readStoreHistoryOne["username"]; ?>/100" alt="">
              <div>
                <span class="text-gray-400 fs-7"><?php echo languageVariables("lastStoreHistory", "words", $languageType); ?> </span>
                <p class="text-gray-700 fs-5 fw-bold"><?php echo $readStoreHistoryOne["username"]; ?></p>
              </div>
              <div class="ml-auto text-gray-200 fs-5">
              <?php echo $readStoreHistoryOne["productName"]; ?>
              </div>
            </div>
          </div>
          <div class="overflow-hdn relative rounded-b-2xl">
            <table class="table table-hover">
              <thead>
                <tr class="bg-indigo-400/25">
                  <th class="text-center !text-indigo-700">#</th>
                  <th class="!text-indigo-700"><?php echo languageVariables("username", "words", $languageType); ?></th>
                  <th class="text-center !text-indigo-700"><?php echo languageVariables("server", "words", $languageType); ?></th>
                  <th class="text-center !text-indigo-700"><?php echo languageVariables("product", "words", $languageType); ?></th>
                  <th class="text-center !text-indigo-700"><?php echo languageVariables("date", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
              <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
              <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
              <?php $readServerList = $searchServerList->fetch(); ?>
                <tr>
                  <td class="text-center"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readStoreHistory["username"]; ?>/28" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readStoreHistory["username"]; ?>"></td>
                  <td><?php echo $readStoreHistory["username"]; ?></td>
                  <td class="text-center"><?php echo $readServerList["name"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo $readStoreHistory["productName"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo checkTime($readStoreHistory["date"]); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("storeHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
        <?php } else { echo alert(languageVariables("storeHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
      </div>

      <div>
        <h4 class="h4"><?php echo languageVariables("creditHistoryTitle", "home", $languageType); ?></h4>
        <?php $searchCreditHistoryOne = $db->query("SELECT * FROM creditHistory WHERE type = 0 ORDER BY id DESC LIMIT 1"); ?>
        <?php if ($searchCreditHistoryOne->rowCount() > 0) { ?>
        <?php $readCreditHistoryOne = $searchCreditHistoryOne->fetch(); ?>
        <?php $searchCreditHistory = $db->prepare("SELECT * FROM creditHistory WHERE type = ? AND id != ? ORDER BY id DESC LIMIT 5"); ?>
        <?php $searchCreditHistory->execute(array(0, $readCreditHistoryOne["id"])); ?>
        <?php if ($searchCreditHistory->rowCount() > 0) { ?>
        <div class="mt-4 card">
          <div class="p-6 flex justify-between">
            <div class="rounded-xl py-3 px-6 bg-indigo-400/25 text-indigo-600 flex flex-col justify-center items-center">
              <p class="fw-extrabold fs-4"><?php echo $readCreditHistoryOne["amount"]; ?></p>
              <span><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span>
            </div>
            <div class="flex gap-5 items-center">
              <div class="text-right">
                <p class="text-gray-600 fs-5 fw-bold"><?php echo $readCreditHistoryOne["username"]; ?></p>
                <span class="text-secondary fs-7 fw-medium"><?php echo languageVariables("lastDonator", "words", $languageType); ?></span>
              </div>
              <div class="bg-cover bg-top w-24 h-36 transform -scale-x-100 rounded-bl-2xl -mt-14" style="background-image: url('https://mc-heads.net/body/<?php echo $readCreditHistoryOne["username"]; ?>')"></div>
            </div>
          </div>
          <div class="overflow-hdn relative rounded-b-2xl">
            <table class="table table-hover">
              <thead>
                <tr class="bg-indigo-400/25">
                  <th class="text-center !text-indigo-700">#</th>
                  <th class="!text-indigo-700"><?php echo languageVariables("username", "words", $languageType); ?></th>
                  <th class="text-center !text-indigo-700"><?php echo languageVariables("amount", "words", $languageType); ?></th>
                  <th class="text-center !text-indigo-700"><?php echo languageVariables("paymentType", "words", $languageType); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($searchCreditHistory as $readCreditHistory) { ?>
                <tr>
                  <td class="text-center"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCreditHistory["username"]; ?>/28" alt="<?php echo languageVariables("server", "words", $languageType); ?> - <?php echo $readCreditHistory["username"]; ?>"></td>
                  <td><?php echo $readCreditHistory["username"]; ?></td>
                  <td class="text-center"><?php echo $readCreditHistory["amount"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo (($readCreditHistory["method"] == 0) ? "<i class=\"fas fa-mobile\"></i>" : "<i class=\"fas fa-credit-card\"></i>"); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("creditHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
        <?php } else { echo alert(languageVariables("creditHistoryAlert", "home", $languageType), "danger", "0", "/"); } ?>
      </div>
      <div>
        <div class="">
          <?php
            $searchErrorStatus = "FALSE";
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["searchPlayer"])) {
              if ($safeCsrfToken->validate('searchPlayerToken')) {
                if (post("searchUsername") !== "") {
                  $searchUsername = $db->prepare("SELECT * FROM accounts WHERE username = ?");
                  $searchUsername->execute(array(post("searchUsername")));
                  if ($searchUsername->rowCount() > 0) {
                    go(urlConverter("player", $languageType)."/".post("searchUsername"));
                  } else {
                    $searchErrorStatus = "TRUE";
                    echo alert(languageVariables("alertNotUser", "credit", $languageType), "danger", "0", "/");
                  }
                } else {
                  $searchErrorStatus = "TRUE";
                  echo alert(languageVariables("alertNone", "player", $languageType), "warning", "0", "/");
                }
              } else {
                $searchErrorStatus = "TRUE";
                echo alert(languageVariables("alertSystem", "player", $languageType), "danger", "0", "/");
              }
            }
          ?>
          <div class="card mt-4 p-6">
            <form action="" method="POST" class="flex gap-3">
              <input type="text" class="grow form-control !py-2" name="searchUsername" placeholder="<?php echo languageVariables("searchPlayer", "words", $languageType); ?>">
              <?php echo $safeCsrfToken->input("searchPlayerToken"); ?>
              <button type="submit" name="searchPlayer" class="rounded-2xl flex items-center justify-center bg-indigo-500/25 w-14 h-14">
                <i class="fas fa-search text-primary fs-5"></i>
              </button>
            </form>
            <?php if ($searchErrorStatus == "TRUE") { ?>
            <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
              <div class="h-4 w-6 rounded-sm bg-white border-gray-200/50 rotate-45 transform origin-bottom-left"></div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div>
        <h4 class="h4" server-command="discordServerName">Discord</h4>
        <div class="relative rounded-2xl mt-5" style="background-color: #7289da">
          <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block">
            <div class="h-4 w-6 rounded-sm shadow-sm rotate-45 transform origin-bottom-left">
              <div class="w-full h-full" style="background-color: #7289da"><span class="absolute top-0 left-0 w-full h-full bg-indigo-600/50"></span></div>
            </div>
          </div>
          <div class="relative overflow-hidden rounded-2xl flex items-center justify-between px-6 py-5">
            <div class="absolute w-1/3 scale-150 bg-indigo-600/50 transform rotate-3 h-full"></div>
            <div class="relative z-10 text-white">
              <svg class="h-10" xmlns="http://www.w3.org/2000/svg" viewBox="34 0 94 34">
                <path class="fill-current" d="M45.6,7.3h-5.7v6.4l3.8,3.4v-6.2h2c1.3,0,1.9,0.6,1.9,1.6v4.8c0,1-0.6,1.7-1.9,1.7h-5.8v3.6h5.7   c3,0,5.9-1.5,5.9-5v-5.1C51.4,8.9,48.6,7.3,45.6,7.3z M75.3,17.6v-5.3c0-1.9,3.4-2.3,4.4-0.4l3.1-1.3c-1.2-2.7-3.5-3.5-5.3-3.5   c-3,0-6,1.8-6,5.2v5.3c0,3.5,3,5.2,6,5.2c1.9,0,4.2-0.9,5.5-3.4l-3.3-1.6C78.7,19.9,75.3,19.4,75.3,17.6z M65,13   c-1.2-0.3-2-0.7-2-1.4c0.1-1.8,2.8-1.8,4.4-0.1l2.5-1.9c-1.6-1.9-3.3-2.4-5.2-2.4c-2.8,0-5.5,1.6-5.5,4.6c0,2.9,2.2,4.5,4.7,4.8   c1.2,0.2,2.6,0.7,2.6,1.5c-0.1,1.6-3.5,1.6-5-0.3L59,20c1.4,1.8,3.3,2.8,5.2,2.8c2.8,0,5.9-1.6,6-4.6C70.4,14.5,67.7,13.5,65,13z    M53.5,22.6h3.8V7.3h-3.8V22.6z M118.1,7.3h-5.7v6.4l3.8,3.4v-6.2h2c1.3,0,1.9,0.6,1.9,1.6v4.8c0,1-0.6,1.7-1.9,1.7h-5.8v3.6h5.7   c3,0,5.9-1.5,5.9-5v-5.1C124,8.9,121.1,7.3,118.1,7.3z M90.2,7.1c-3.2,0-6.3,1.7-6.3,5.2v5.2c0,3.5,3.2,5.2,6.3,5.2   c3.2,0,6.3-1.7,6.3-5.2v-5.2C96.5,8.9,93.4,7.1,90.2,7.1z M92.7,17.6c0,1.1-1.2,1.7-2.4,1.7c-1.2,0-2.5-0.5-2.5-1.7v-5.2   c0-1.1,1.2-1.7,2.4-1.7c1.2,0,2.5,0.5,2.5,1.7V17.6z M110.3,12.4c-0.1-3.6-2.5-5-5.6-5h-6.1v15.2h3.9v-4.8h0.7l3.5,4.8h4.8   l-4.1-5.2C109.2,16.8,110.3,15.2,110.3,12.4z M104.7,14.4h-2.3v-3.5h2.3C107.1,10.9,107.1,14.4,104.7,14.4z"></path>
              </svg>
              <a href="<?php echo $rMedia["discord"]; ?>" class="btn btn-white">
                <?php echo languageVariables("nowJoin", "words", $languageType); ?>
                <i class="fas fa-angle-right ml-3"></i>
              </a>
            </div>
            <div class="relative z-10 text-right text-white">
              <span class="fw-bolder" server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</span>
              <p class="fw-extrabold mt-2"><?php echo languageVariables("onlineUser", "words", $languageType); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>