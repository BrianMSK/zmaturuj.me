<?php
require_once '../../config/config.php'; // INCLUDE CONFIG
require_once '../../classes/is_admin.php'; // CHECK IF USER IS ADMIN

if (is_admin($_SESSION['id'])) {
  die();
} else {
  header("Location: /zmaturuj.me/error");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zmaturuj.me Account Generator</title>
</head>

<body>
  <form action="../zmaturuj.me/views/backend/generate-account.php" method="post">
    <input type="email" name="email" placeholder="Write e-mail">
    <input type="submit" name="submit" value="Generate"></input>
  </form>
</body>

</html>