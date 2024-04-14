
    <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Main js -->
  <script src="js/sidebar.js"></script>
  <script src="js/reduce-header.js"></script>

  <!-- Get the specific js path and add it to the page -->
  <?php
    $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

    $jsFilePath = "js/$currentPage";

    $scripts = scandir($jsFilePath);

    foreach ($scripts as $script) {
        if (pathinfo($script, PATHINFO_EXTENSION) === 'js') {
            echo '<script src="' . $jsFilePath . '/' . $script . '"></script>' . PHP_EOL;
        }
    }
    ?>
