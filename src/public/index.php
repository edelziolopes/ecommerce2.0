<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/output.css" rel="stylesheet">
</head>
<body>
  <h1 class="text-3xl font-bold underline">
      <?php
        require '../Application/autoload.php';
        use Application\core\App;
        use Application\core\Controller;
        $app = new App();
      ?>
  </h1>
</body>
</html>