<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="Core/utilities/css/styles.css">

  
</head>

<body>
  <?php
  //use web\Core\Http\Request;
  use web\App\ParcelUrl\ParcelUrl;
  chdir(dirname(__DIR__));
  require_once "vendor/autoload.php";
  $parser = new ParcelUrl('https://www.php.net/manual/ru/');
  $response = $parser->fetch();
  if ($parser->isError()) {
      echo 'An error occurred while fetching data';
  } else {
      echo $response;
  }

  ?>
</body>
</html>