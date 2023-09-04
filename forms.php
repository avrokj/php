<?php
var_dump($_POST);

$userName = $_GET['user_name'];
$pass = $_GET['password'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./forms.php" method="get">
    <input type="text" name="user_name" placeholder="sisesta nimi">
    <input type="password" name="password" placeholder="sisesta parool">
    <button type="submit">Submit</button>
</form>
<h1>Hello, <?= $userName; ?> !</h1>
</body>
</html>