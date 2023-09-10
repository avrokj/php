<?php

require_once('./connection.php');

$SearchValue = $_POST['SearchValue'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE lower(title) LIKE :SearchValue');
$stmt->bindValue(':SearchValue', '%' . strtolower($SearchValue) . '%');
$stmt->execute();
$book = $stmt->fetch();
$count = $stmt->rowCount() - 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
</head>

<body>
  <h1>Otsingu tulemused:</h1>

  <?php if (count($book) > 0) {
    echo "<p>Tulemusi otsingule <strong>$SearchValue</strong> leiti <strong>$count</strong> tulemust.</p>";
  ?>

    <ul>

      <?php
      while ($row = $stmt->fetch()) {
      ?>
        <li>
          <a href="./book.php?id=<?= $row['id']; ?>">
            <?= $row['title']; ?>
          </a>
          <small><?= $row['id']; ?></small>
        </li>
      <?php
      }
      ?>
    </ul>
  <?php
  } else {
    echo "<p>Tulemusi otsingule <strong>$SearchValue</strong> ei leitud.</p>";
  }
  ?>

  <a href="./"><strong><- Kõik raamatud</strong></a>

</body>

</html>