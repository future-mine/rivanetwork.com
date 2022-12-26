<?php
$searchPages = $db->prepare("SELECT * FROM page WHERE id = ?");
$searchPages->execute(array(get("pages")));
if ($searchPages->rowCount() > 0) {
  $readPage = $searchPages->fetch();
?>
<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
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
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readPage["title"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-12 gap-10 mt-10 px-4 md:px-0">
    <div class="card lg:col-span-12 h-fit">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo $readPage["title"]; ?></h3>
        <div class="text-gray-400 mt-4">
        <?php echo $readPage["description"]; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } else { go("/"); } ?>