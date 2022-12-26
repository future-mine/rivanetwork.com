<section class="px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8 lg:py-40">
  <div class="container mx-auto sm:flex justify-center">
    <p class="text-5xl font-extrabold text-indigo-600"><?php echo languageVariables("sectionTitle", "404", $languageType); ?></p>
    <div class="sm:ml-6">
      <div class="sm:border-l sm:border-gray-200 sm:pl-6">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl"><?php echo languageVariables("sectionInfo", "404", $languageType); ?></h1>
        <p class="mt-1 text-base text-gray-500"><?php echo languageVariables("sectionText", "404", $languageType); ?></p>
      </div>
      <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
        <a href="<?php echo urlConverter("home", $languageType); ?>" class="btn btn-primary">
          <?php echo languageVariables("back", "words", $languageType); ?>
        </a>
      </div>
    </div>
  </div>
</section>