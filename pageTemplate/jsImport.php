
    <!-- JQuery -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
  <script src="<?php echo BASE_DIR_STATIC.'js/jquery-3.5.1.slim.min.js'?>"></script>
 
  <!-- Bootstrap -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="<?php echo BASE_DIR_STATIC.'js/bootstrap.bundle.min.js'?>"></script>
  
  <!-- Main js -->
  <?php
  echo '<script src="'.BASE_DIR_STATIC.'js/sidebar.js"></script>';
  echo '<script src="'.BASE_DIR_STATIC.'js/reduce-header.js"></script>';
  ?>

  <!-- Get the specific js path and add it to the page -->
  <?php
    $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

    $fullPath = $_SERVER['PHP_SELF'];

    $projectFolder = 'mydoorcenter';

    $position = strpos(strtolower($fullPath), strtolower($projectFolder));

    if ($position !== false) {
        $pathBeforeFile = substr($fullPath, $position + strlen($projectFolder));
        $directoryPath = dirname($pathBeforeFile);
    } else {
        $directoryPath = dirname($fullPath);
    }

    $directoryPath = trim($directoryPath, '/') . '/' . $currentPage;

    $jsFilePath = BASE_DIR_STATIC . "js/" . $directoryPath;
    $jsFilePathCheck = BASE_DIR . "js/" . $directoryPath;

    if (file_exists($jsFilePathCheck)) {
        $scripts = scandir($jsFilePathCheck);
        foreach ($scripts as $script) {
            if (pathinfo($script, PATHINFO_EXTENSION) === 'js') {
                if (str_starts_with($script, "module."))
                echo '<script type="module" src="' . $jsFilePath . '/' . $script . '"></script>' . PHP_EOL;
                else
                    echo '<script src="' . $jsFilePath . '/' . $script . '"></script>' . PHP_EOL;
            }
        }
    }

    if (defined("JS_CUSTOM_IMPORT")) echo JS_CUSTOM_IMPORT;
?>