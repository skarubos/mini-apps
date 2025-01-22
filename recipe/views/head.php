<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Pacifico|Lato' rel='stylesheet' type='text/css'>

  <?php
    forEach ($cssLinks as $cssLink) echo '<link rel="stylesheet" type="text/css" href="css/' . $cssLink . '.css">';
    $editable = in_array("home", $cssLinks);

  ?>

</head>
