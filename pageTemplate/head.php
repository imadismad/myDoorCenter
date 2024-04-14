<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyDoorCenter</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Main css -->
  <link href="css/main.css" rel="stylesheet">

  <!-- Get the specific css path -->
  <?php
      $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

      $cssFilePath = "css/$currentPage/style.css";
    ?>
  <!-- Specific css -->
  <link href="<?php echo $cssFilePath; ?>" rel="stylesheet">

</head>