<?php
$searchPages = $db->prepare("SELECT * FROM page WHERE id = ?");
$searchPages->execute(array(get("pages")));
if ($searchPages->rowCount() > 0) {
  $readPage = $searchPages->fetch();
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-12 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <strong><?php echo $readPage["title"]; ?></strong>
              </h3>
              <?php echo $readPage["description"]; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go("/"); } ?>