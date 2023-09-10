<?php

require_once('./connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id'); // statement objekti
$stmt->execute(['id' => $id]); // tagastab statementi
$book = $stmt->fetch(); // tagastab array

$stmt = $pdo->prepare('SELECT * FROM book_authors ba left join authors a on a.id = ba.author_id WHERE ba.book_id = :book_id');
$stmt->execute(['book_id' => $id]);

// var_dump($book);
// die();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $book['title']; ?></title>
</head>

<body>
  <h1><?= $book['title']; ?></h1>
  <img src="<?= $book['cover_path']; ?>">
  <p><strong>Author:</strong>
    <?php
    $author = [];
    while ($authors = $stmt->fetch()) {
      $author[] = $authors['first_name'] . ' ' . $authors['last_name'];
    } ?>
    <span><?= implode(', ', $author); ?></span>
  </p>
  <p><strong>Keel:</strong> <?= $book['language']; ?></p>
  <p><strong>Hind:</strong> <?= round($book['price'], 2); ?> € <small><em>(keskmine lehe hind: <?= round($book['price'] / $book['pages'], 2); ?> €)</em></small></p>
  <p><strong>Lehti:</strong> <?= $book['pages']; ?></p>
  <p><strong>Kokkuvõte:</strong> <?= $book['summary']; ?></p>
  <p><strong>Laoseis:</strong> <?= $book['stock_saldo']; ?></p>
  <p><strong>Raamatu tüüp:</strong> <?= $book['type']; ?></p>

  <form action="delete.php" method="post" id="delete">
    <input type="hidden" name="id" value="<?= $book['id']; ?>">
    <button>Kustuta</button>
  </form>
</body>

</html>