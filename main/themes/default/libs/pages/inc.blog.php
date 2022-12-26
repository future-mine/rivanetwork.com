<section class="pt-20 container mx-auto px-4 md:px-0">
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
      <li class="flex">
        <div class="flex items-center py-1">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
          </svg>
          <a href="<?php echo urlConverter("news_category", $languageType); ?>/<?php echo $readNews["categoryName"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readNews["title"]; ?></a>
        </div>
      </li>
    </ol>
  </nav>
</section>
<?php
$searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?");
$searchNews->execute(array(get("news")));
if ($searchNews->rowCount() > 0) {
  require_once(__DR__."/main/includes/packages/class/csrf/class.php");
  $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
  $readNews = $searchNews->fetch();
  if (!isset($_COOKIE["news-".$readNews["id"]])) {
    $newNewsDisplay = $readNews["newsDisplay"]+1;
    $updateNewsDisplay = $db->prepare("UPDATE newsList SET newsDisplay = ? WHERE id = ?");
    $updateNewsDisplay->execute(array($newNewsDisplay, $readNews["id"]));
    setcookie("news-".$readNews["id"], "view");
  }
?>
<section class="pb-32 pt-20 relative">
  <div class="relative container mx-auto grid lg:grid-cols-5 gap-12 px-4 md:px-0">
    <div class="absolute -top-20 left-4 h1 text-gray-200/50 select-none hidden lg:block"><?php echo $readNews["title"]; ?></div>
    <div class="lg:col-span-3 grid gap-8 h-fit">
      <div class="lg:hidden rounded-3xl w-full h-56 bg-cover bg-center min-h-[20rem]" style="background-image: url('<?php echo $readNews["image"]; ?>')"></div>
      <div class="card overflow-hidden shadow-sm flex flex-col">
        <div class="py-8 px-10">
          <div class="flex justify-between items-center border-b-2 border-gray-200/50 pb-3">
            <div class="flex gap-3 items-center">
              <img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readNews["newsAuthor"]; ?>/40.png" alt="" width="40" height="40">
              <div class="flex flex-col justify-center">
                <p class="text-gray-700 fw-bolder"><?php echo $readNews["newsAuthor"]; ?></p>
                <span class="fs-7 text-gray-400"><?php echo languageVariables("author", "words", $languageType); ?></span>
              </div>
            </div>
            <div>
              <spanm class="rounded-xl py-2 px-4 fs-8 uppercase bg-success text-white"><?php echo $readNews["categoryName"]; ?></spanm>
            </div>
          </div>
          <h1 class="h2 text-dark mt-3"><?php echo $readNews["title"]; ?></h1>
          <p class="text-gray-400 mt-3 mb-12">
            <?php echo $readNews["text"]; ?>
          </p>
        </div>

        <div class="mt-auto py-3 px-4 bg-gray-100/50 flex justify-between items-center fs-7">
          <span class="text-gray-400 fw-medium"><?php echo checkTime($readNews["date"]); ?></span>
          <div class="flex gap-4 relative">
            <div class="relative flex gap-2 items-center text-primary bg-indigo-100 rounded-lg py-1 px-2">
              <div class="absolute -top-3 left-2 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
                <div class="h-4 w-6 rounded-sm bg-indigo-100 rotate-45 transform origin-bottom-left"></div>
              </div>
              <i class="fas fa-eye"></i>
              <?php echo $readNews["newsDisplay"]; ?>
            </div>
            <div class="relative flex gap-2 items-center text-primary bg-indigo-100 rounded-lg py-1 px-2">
              <div class="absolute -top-3 left-2 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
                <div class="h-4 w-6 rounded-sm bg-indigo-100 rotate-45 transform origin-bottom-left"></div>
              </div>
              <i class="fas fa-heart"></i>
              <?php echo $readNews["newsHearts"]; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="">
        <h3 class="h4"><?php echo languageVariables("comments", "words", $languageType); ?></h3>
        <div class="mt-6 grid gap-8">
          <?php
          if ($rSettings["commentsStatus"] == "1" && $readNews["commentStatus"] == "1") {
          $searchNewsComment = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?");
          $searchNewsComment->execute(array($readNews["id"], 1));
          if ($searchNewsComment->rowCount() > 0) {
            foreach ($searchNewsComment as $readNewsComment) {
          ?>
          <div class="flex gap-6">
            <div>
              <img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readNewsComment["username"]; ?>/40.png" alt="" width="40" height="40">
            </div>
            <div class="card p-2 grow">
              <div class="absolute -left-4 top-2 w-4 overflow-hidden">
                <div class="h-6 w-4 rounded-sm bg-white border border-gray-200/50 -rotate-45 transform origin-top-right"></div>
              </div>
              <div class="flex justify-between items-center">
                <p class="font-medium text-gray-700"><?php echo $readNewsComment["username"]; ?></p>
                <span class="uppercase text-xs pr-4 text-gray-400"><?php echo checkTime($readNewsComment["date"]); ?></span>
              </div>
              <p class="text-gray-400 mt-1">
                <?php echo $readNewsComment["message"]; ?>
              </p>
            </div>
          </div>
          <?php } } else { echo alert(languageVariables("alertComment", "blog", $languageType), "warning", "0", "/"); } ?>
          <?php if (isset($_SESSION["incAccountLogin"])) { ?>
          <?php
          if (isset($_POST["commentMessage"])) {
            if ($safeCsrfToken->validate('commentsToken')) {
              if (post("commentMessage") !== "") {
                $bannedQuery = $db->prepare("SELECT * FROM banned WHERE username = ? AND type = ? AND (bannedDate > ? OR bannedDate = ?)");
                $bannedQuery->execute(array($readAccount["username"], "comment", date("Y-m-d H:i:s"), "1000-01-01 00:00:00"));
                if ($bannedQuery->rowCount() == 0) {
                  $insertComment = $db->prepare("INSERT INTO comments SET username = ?, message = ?, date = ?, newsID = ?, status = ?");
                  $insertComment->execute(array($readAccount["username"], post("commentMessage"), date("d.m.Y H:i:s"), $readNews["id"], 0));
                  $webhookDescription = str_replace(array("[username]", "[url]"), array($readAccount["username"], $siteURL."haber/".createSlug($readNews["title"])."/".$readNews["id"]), $readWebhooks["webhookCommentDescription"]);
                  $hookObject = json_encode([
                    "username" => str_replace("[username]", $readAccount["username"], $readWebhooks["webhookCommentName"]),
                    "avatar_url" => avatarAPI($readAccount["username"], 100),
                    "tts" => false,
                    "embeds" => [
                       [
                            "title" => $readWebhooks["webhookCommentTitle"],
                            "type" => "rich",
                            "image" => ($readWebhooks["webhookCommentImage"] !== "0") ? [
                              "url" => $readWebhooks["webhookCommentImage"]
                            ] : [],
                            "description" => $webhookDescription,
                            "color" => hexdec(rand_color()),
                            "footer" => ($readWebhooks["webhookCommentSignature"] == "1") ? [
                                "text" => "Powered by MineXON",
                                "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                            ] : []
                        ]
                    ]
                  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                  $sendWebhook = (($readWebhooks["webhookCommentStatus"] == "1") ? webhooks($readWebhooks["webhookCommentAPI"], $hookObject) : "OK");
                  echo alert(languageVariables("alertSuccess", "blog", $languageType), "success", "3", "");
                } else {
                  $readBanned = $bannedQuery->fetch();
                  if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") { 
                    $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                  } else {
                    $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType);
                  }
                  echo alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBan", "blog", $languageType)), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "blog", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "blog", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <div class="card mt-10 p-4 fs-7">
            <form action="" method="POST">
              <label for="reply" class="text-gray-500 fw-bolder"><?php echo languageVariables("comment", "blog", $languageType); ?></label>
              <textarea id="reply" class="form-control w-full min-w-[6rem] mt-2" name="commentMessage"></textarea>
              <div class="flex justify-end mt-4">
                <button type="submit" class="btn btn-success btn-sm"><?php echo languageVariables("send", "words", $languageType); ?></button>
              </div>
              <?php echo $safeCsrfToken->input("commentsToken"); ?>
            </form>
            <div class="absolute -top-4 left-4 w-6 overflow-hidden inline-block md:hidden lg:inline-block">
              <div class="h-4 w-6 rounded-sm bg-white border-gray-200/50 rotate-45 transform origin-bottom-left"></div>
            </div>
          </div>
          <?php } else { echo alert(languageVariables("alertLogin", "blog", $languageType), "warning", "0", "/"); } ?>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="lg:col-span-2 gap-8 h-fit">
      <div class="hidden lg:block rounded-3xl w-full h-56 bg-cover bg-center min-h-[20rem]" style="background-image: url('<?php echo $readNews["image"]; ?>')"></div>
      <?php
      if ($searchNews->rowCount() > 0) {
        if ($readNews["id"] == "1" || $readNews["id"] == "2" || $readNews["id"] == "3") {
          $searchOtherNews = $db->prepare("SELECT * FROM newsList WHERE id = ? OR id = ? OR id = ? ORDER BY id DESC");
        } else {
          $searchOtherNews = $db->prepare("SELECT * FROM newsList WHERE id < ? ORDER BY id DESC LIMIT 3");
        }
        
        if ($readNews["id"] == "1") {
          $searchOtherNews->execute(array(4, 3, 2));
        } else if ($readNews["id"] == "2") {
          $searchOtherNews->execute(array(4, 3, 1));
        } else if ($readNews["id"] == "3") {
          $searchOtherNews->execute(array(4, 2, 1));
        } else {
          $searchOtherNews->execute(array($readNews["id"]));
        }
      } else {
        $searchOtherNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT 3");
      }
      if ($searchOtherNews->rowCount() > 0) {
      ?>
      <div class="lg:pl-20 mt-12">
        <h4 class="h4 text-dark"><?php echo languageVariables("other", "words", $languageType); ?></h4>
        <div class="grid gap-4 mt-4 lg:mt-0">
          <?php foreach ($searchOtherNews as $readOtherNews) { ?>
          <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readOtherNews["title"]); ?>/<?php echo $readOtherNews["id"]; ?>" class="rounded-2xl relative h-[18rem] overflow-hidden group bg-cover bg-center" style="background-image: url('<?php echo $readOtherNews["image"]; ?>')">
            <div class="absolute top-0 -left-full w-full group-hover:left-0 transition-all h-full">
              <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-indigo-700/25 to-black/25"></div>
              <div class="relative z-10 p-10 flex flex-col h-full">
                <dt class="fw-bold text-white fs-3 max-w-lg leading-7"><span class="text-emerald-400"><?php echo $readOtherNews["categoryName"]; ?></span> - <?php echo $readOtherNews["title"]; ?></dt>
                <dd class="mt-5 text-indigo-100 max-w-lg"><?php echo contentShort(strip_tags($readOtherNews["text"]), 60); ?></dd>
                <div class="flex justify-between items-center mt-auto">
                  <div class="btn btn-primary"><?php echo languageVariables("moreRead", "words", $languageType); ?></div>
                  <div class="flex gap-3 text-xs font-medium">
                    <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                      <i class="fas fa-eye"></i> <?php echo $readNews["newsDisplay"]; ?>
                    </div>
                    <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                      <i class="fas fa-comment"></i> <?php echo $readNews["newsHearts"]; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <span class="absolute top-8 right-12 rounded-xl bg-emerald-500 text-white py-2 px-4 fs-8 uppercase fw-medium group-hover:-right-full transition-all"><?php echo $readOtherNews["categoryName"]; ?></span>
            <div class="absolute bottom-0 left-0 w-full py-5 px-10 overflow-hidden transform group-hover:translate-y-full transition-all">
              <div class="absolute top-0 left-0 w-full h-full bg-black/50 blur-sm"></div>
              <div class="relative z-10">
                <dt class="fw-bold text-white fs-4"><?php echo $readOtherNews["title"]; ?></dt>
                <dd class="mt-1 text-white/75"><?php echo contentShort(strip_tags($readOtherNews["text"]), 60); ?></dd>
              </div>
            </div>
          </a>
          <?php } ?>
        </div>
      </div>
      <?php } else { alert(languageVariables("alertNotOtherBlog", "blog", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</section>
<?php } else { echo alert(languageVariables("alertNotBlog", "blog", $languageType), "warning", "0", "/"); } ?>