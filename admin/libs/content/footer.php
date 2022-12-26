      <?php if (get("page") !== "404") { ?>
      <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md text-center text-md-left mb-2 mb-md-0">
              <p class="text-muted text-center text-md-left"><?php echo languageVariables("copyrightReserve", "words", $languageType); ?> © <?php echo date("Y")." ".$rSettings["serverName"]; ?></p>
            </div>
            </div>
          </div>
      <?php } ?>