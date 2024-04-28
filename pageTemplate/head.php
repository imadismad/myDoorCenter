<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyDoorCenter</title>
  <?php
  echo '<link rel="icon" type="image/png" href="'.BASE_DIR_STATIC.'images/favicon.ico">';
  ?>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Mail -->
  <script type="text/javascript" src="https://cdn.emailjs.com/sdk/2.3.2/email.min.js"></script>
  <!-- Main css -->
  <?php
  echo '<link href="'.BASE_DIR_STATIC.'css/main.css" rel="stylesheet">';
  ?>
  
  <!-- Specific css -->
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
    $cssFilePath = BASE_DIR_STATIC . "css/" . $directoryPath;
    $cssFilePathCheck = BASE_DIR . "css/" . $directoryPath;

    if (file_exists($cssFilePathCheck)) {
        $styles = scandir($cssFilePathCheck);
        foreach ($styles as $style) {
            if (pathinfo($style, PATHINFO_EXTENSION) === 'css') {
                echo '<link href="' . $cssFilePath . '/' . $style . '" rel="stylesheet">' . PHP_EOL;
            }
        }
    }

    if (defined("CSS_CUSTOM_IMPORT")) echo CSS_CUSTOM_IMPORT;
?>





    
</head>