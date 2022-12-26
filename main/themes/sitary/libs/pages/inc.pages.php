<?php
$searchPages = $db->prepare("SELECT * FROM page WHERE id = ?");
$searchPages->execute(array(get("pages")));
if ($searchPages->rowCount() > 0) {
  $readPage = $searchPages->fetch();
?>
<style type="text/css">
ul li {
  color: #fff; ?>;
}
</style>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-12 mobile-prefer-content">
      <!-- PAGES -->
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo $readPage["title"]; ?></p>
          <div class="widget-box-content">
            <?php echo $readPage["description"]; ?>
          </div>
        </div>
      </div>
      <!-- /PAGES -->
    </div>
</div>
<?php } else { go(urlConverter("home", $languageType)); } ?>