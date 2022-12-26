<div class="content-grid full">
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
<style type="text/css">
.news-tag-category {
  height: 50px;
  padding: 0 8px;
  border-radius: 200px;
  font-size: 1.1rem;
  font-weight: 700;
  line-height: 50px;
  text-transform: uppercase;
  position: relative;
  background-color: #615dfa;
  color: #fff;
  top: -.6rem;
  right: .5rem;
}
</style>
    <article class="post-open">
      <figure class="post-open-cover liquid">
        <img src="<?php echo $readNews["image"]; ?>" alt="<?php echo languageVariables("blog", "words", $languageType); ?> - <?php echo $readNews["title"]; ?>">
      </figure>
      <div class="post-open-body">
        <div class="post-open-heading">
          <p class="post-open-timestamp"><span class="highlighted"><?php echo checkTime($readNews["date"]); ?></span></p>
          <h2 class="post-open-title"><a href="<?php echo urlConverter("news_category", $languageType); ?>/<?php echo $readNews["categoryName"]; ?>" class="news-tag-category"><?php echo $readNews["categoryName"]; ?></a><?php echo $readNews["title"]; ?></h2>
        </div>
        <div class="post-open-content">
          <div class="post-open-content-sidebar">
            <div class="user-avatar small no-outline">
              <img src="https://minotar.net/bust/<?php echo $readNews["newsAuthor"]; ?>/100.png" width="60" height="60">
            </div>
          </div>
          <div class="post-open-content-body">
            <p class="post-open-paragraph"><?php echo $readNews["text"]; ?></p>
            <div class="tag-list">
              <?php $searchNewsTags = $db->prepare("SELECT * FROM newsTags WHERE newsID = ?"); ?>
              <?php $searchNewsTags->execute(array($readNews["id"])); ?>
              <?php if ($searchNewsTags->rowCount() > 0) { ?>
              <?php foreach ($searchNewsTags as $readNewsTags) { ?>
              <a class="tag-item secondary" href="#"><?php echo $readNewsTags["name"]; ?></a>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php
      if (isset($_POST["newsLike"])) {
        if ($safeCsrfToken->validate('newsLikeToken')) {
          if (isset($_SESSION["incAccountLogin"])) {
            $insertNewsLike = $db->prepare("INSERT INTO newsLike SET userID = ?, newsID = ?, date = ?");
            $insertNewsLike->execute(array($readAccount["id"], $readNews["id"], date("d.m.Y H:i:s")));
            $newNewsLike = $readNews["newsHearts"]+1;
            $updateNewsLike = $db->prepare("UPDATE newsList SET newsHearts = ? WHERE id = ?");
            $updateNewsLike->execute(array($newNewsLike, $readNews["id"]));
            echo '<div class="p-5">'.alert(languageVariables("alertLikeSuccess", "blog", $languageType), "success", "3", "").'</div>';
          } else {
            go(urlConverter("login", $languageType));
          }
        } else {
          echo '<div class="p-5">'.alert(languageVariables("alertSystem", "blog", $languageType), "danger", "0", "/").'</div>';
        }
      } else if (isset($_POST["removeNewsLike"])) {
        if ($safeCsrfToken->validate('removeNewsLikeToken')) {
          if (isset($_SESSION["incAccountLogin"])) {
            $removeNewsLike = $db->prepare("DELETE FROM newsLike WHERE userID = ? AND newsID = ?");
            $removeNewsLike->execute(array($readAccount["id"], $readNews["id"]));
            $newNewsLike = $readNews["newsHearts"]-1;
            $updateNewsLike = $db->prepare("UPDATE newsList SET newsHearts = ? WHERE id = ?");
            $updateNewsLike->execute(array($newNewsLike, $readNews["id"]));
            echo '<div class="p-5">'.alert(languageVariables("alertLikeRemove", "blog", $languageType), "success", "3", "").'</div>';
          } else {
            go(urlConverter("login", $languageType));
          }
        } else {
          echo '<div class="p-5">'.alert(languageVariables("alertSystem", "blog", $languageType), "danger", "0", "/").'</div>';
        }
      }
      ?>
        <div class="content-actions">
          <div class="content-action">
          </div>
          <div class="content-action">
            <div class="meta-line">
              <p class="meta-line-link"><?php echo $readNews["newsHearts"]; ?> <?php echo languageVariables("like", "words", $languageType); ?></p>
            </div>
            <?php $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?"); ?>
            <?php $searchNewsComments->execute(array($readNews["id"], 1)); ?>
            <?php $newsCommentsRow = $searchNewsComments->rowCount(); ?>
            <div class="meta-line">
              <p class="meta-line-text"><?php echo $newsCommentsRow; ?> <?php echo languageVariables("comment", "words", $languageType); ?></p>
            </div>
            <div class="meta-line">
              <p class="meta-line-text"><?php echo $readNews["newsDisplay"]; ?> <?php echo languageVariables("views", "words", $languageType); ?></p>
            </div>
          </div>
        </div>
        <div class="post-options">
          <div class="post-option-wrap">
            <?php
            $searchNewsLike = $db->prepare("SELECT * FROM newsLike WHERE userID = ? AND newsID = ?");
            $searchNewsLike->execute(array($readAccount["id"], $readNews["id"]));
            ?>
            <form action="" method="POST">
              <button type="submit" <?php if ($searchNewsLike->rowCount() > 0) { ?>name="removeNewsLike"<?php } else { ?>name="newsLike"<?php } ?> class="post-option reaction-options-dropdown-trigger <?php if ($searchNewsLike->rowCount() > 0) { echo "active"; } ?>" style="background: none; border: none; padding: 0;">
                <svg class="post-option-icon icon-thumbs-up">
                  <use xlink:href="#svg-thumbs-up"></use>
                </svg>
                <p class="post-option-text"><?php echo languageVariables("like", "words", $languageType); ?></p>
              </button>
              <?php if ($searchNewsLike->rowCount() > 0) { ?>
                <?php echo $safeCsrfToken->input("removeNewsLikeToken"); ?>
              <?php } else { ?>
                <?php echo $safeCsrfToken->input("newsLikeToken"); ?>
              <?php } ?>
            </form>
          </div>
          <?php
          $searchPlayerComments = $db->prepare("SELECT * FROM comments WHERE username = ? AND newsID = ? AND status = ?");
          $searchPlayerComments->execute(array($readAccount["username"], $readNews["id"], 1));
          ?>
          <button type="button" class="post-option <?php if ($searchPlayerComments->rowCount() > 0) { echo "active"; } ?>" style="background: none; border: none; padding: 0;">
            <svg class="post-option-icon icon-comment">
              <use xlink:href="#svg-comment"></use>
            </svg>
            <p class="post-option-text"><?php echo languageVariables("comment", "words", $languageType); ?></p>
          </button>
        </div>
        <div id="comments" class="post-comment-list">
        <?php if ($rSettings["commentsStatus"] == "1" && $readNews["commentStatus"] == "1") { ?>
        <?php
        $searchNewsComment = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?");
        $searchNewsComment->execute(array($readNews["id"], 1));
        if ($searchNewsComment->rowCount() > 0) {
          foreach ($searchNewsComment as $readNewsComment) {
        ?>
          <div class="post-comment">
            <a class="user-avatar small no-outline" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readNewsComment["username"]; ?>">
              <img src="https://minotar.net/bust/<?php echo $readNewsComment["username"]; ?>/100.png" width="40" height="40">
            </a>
            <p class="post-comment-text"><a class="post-comment-text-author" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readNewsComment["username"]; ?>"><?php echo $readNewsComment["username"]; ?></a><?php echo $readNewsComment["message"]; ?></p>
            <div class="content-actions">
              <div class="content-action">
                <div class="meta-line">
                  <p class="meta-line-timestamp"><?php echo checkTime($readNewsComment["date"]); ?></p>
                </div>
              </div>
            </div>
          </div>
          <?php } } else { echo '<div class="p-3">'.alert(languageVariables("alertComment", "blog", $languageType), "warning", "0", "/").'</div>'; } ?>
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
                  echo '<div class="p-3">'.alert(languageVariables("alertSuccess", "blog", $languageType), "success", "3", "").'</div>';
                } else {
                  $readBanned = $bannedQuery->fetch();
                  if ($readBanned["bannedDate"] == "1000-01-01 00:00:00") { 
                    $userBannedBackDate = languageVariables("indefinite", "words", $languageType);
                  } else {
                    $userBannedBackDate = max(round((strtotime($readBanned["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType);
                  }
                  echo '<div class="p-3">'.alert(str_replace(["&reason","&date"], [$readBanned["reason"],$userBannedBackDate], languageVariables("alertBan", "blog", $languageType)), "danger", "0", "/").'</div>';
                }
              } else {
                echo '<div class="p-3">'.alert(languageVariables("alertNone", "blog", $languageType), "warning", "0", "/").'</div>';
              }
            } else {
              echo '<div class="p-3">'.alert(languageVariables("alertSystem", "blog", $languageType), "danger", "0", "/").'</div>';
            }
          }
          ?>
          <div class="post-comment-form">
            <div class="user-avatar small no-outline">
          	<img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="40" height="40">
            </div>
            <form action="" method="POST">
              <div class="form-row">
                <div class="form-item">
                  <div class="form-input small">
                    <label for="post-reply"><?php echo languageVariables("comment", "blog", $languageType); ?></label>
                    <input type="text" id="post-reply" name="commentMessage">
                    <?php echo $safeCsrfToken->input("commentsToken"); ?>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php } else { echo '<div class="p-3">'.alert(languageVariables("alertLogin", "blog", $languageType), "warning", "0", "/").'</div>'; } ?>
          <?php } ?>
        </div>
      </div>
    </article>
<?php } else { echo '<div class="p-5">'.alert(languageVariables("alertNotBlog", "blog", $languageType), "warning", "0", "/").'</div>'; } ?>
</div>
  <div class="content-grid medium">
    <div class="section-header medium">
      <div class="section-header-info">
        <p class="section-pretitle"><?php echo languageVariables("news", "words", $languageType); ?></p>
        <h2 class="section-title"><?php echo languageVariables("other", "words", $languageType); ?></h2>
      </div>
    </div>
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
    <div class="grid grid-4-4 centered">
      <?php foreach ($searchOtherNews as $readOtherNews) { ?>
      <div class="post-preview">
        <figure class="post-preview-image liquid">
          <img src="<?php echo $readOtherNews["image"]; ?>" alt="<?php echo languageVariables("blog", "words", $languageType); ?> - <?php echo $readOtherNews["title"]; ?>">
        </figure>
        <div class="post-preview-info fixed-height">
          <div class="post-preview-info-top">
            <p class="post-preview-timestamp"><?php echo checkTime($readOtherNews["date"]); ?></p>
            <p class="post-preview-title"><?php echo $readOtherNews["title"]; ?></p>
          </div>
          <div class="post-preview-info-bottom">
            <p class="post-preview-text"><?php echo contentShort(strip_tags($readOtherNews["text"]), 150); ?></p>
            <a class="post-preview-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readOtherNews["title"]); ?>/<?php echo $readOtherNews["id"]; ?>"><?php echo languageVariables("moreRead", "words", $languageType); ?></a>
          </div>
        </div>
        <div class="content-actions">
          <div class="content-action">
          </div>
          <div class="content-action">
            <div class="meta-line">
              <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readOtherNews["title"]); ?>/<?php echo $readOtherNews["id"]; ?>"><?php echo $readOtherNews["newsHearts"]; ?> <?php echo languageVariables("like", "words", $languageType); ?></a>
            </div>
            <?php $searchOtherNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ? AND status = ?"); ?>
            <?php $searchOtherNewsComments->execute(array($readNews["id"], 1)); ?>
            <?php $otherNewsCommentsRow = $searchOtherNewsComments->rowCount(); ?>
            <div class="meta-line">
              <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readOtherNews["title"]); ?>/<?php echo $readOtherNews["id"]; ?>"><?php echo $otherNewsCommentsRow; ?> <?php echo languageVariables("comment", "words", $languageType); ?></a>
            </div>
            <div class="meta-line">
              <a class="meta-line-link" href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readOtherNews["title"]); ?>/<?php echo $readOtherNews["id"]; ?>"><?php echo $readOtherNews["newsDisplay"]; ?> <?php echo languageVariables("views", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } else { alert(languageVariables("alertNotOtherBlog", "blog", $languageType), "danger", "0", "/"); } ?>
  </div>