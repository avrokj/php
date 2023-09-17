<?php

require_once('./connection.php');

$id = $_POST['id'];
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM book_authors ba left join authors a on a.id = ba.author_id WHERE ba.book_id = :book_id');
$stmt->execute(['book_id' => $id]);

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
  <form action="edit_db.php" method="post" id="edit">
    <h1>Pealkiri: <input type='text' name='title' value='<?= $book['title']; ?>'></h1>
    <img src="<?= $book['cover_path']; ?>">
    <p><strong>Author:</strong>
    <ul>
      <?php
      $author = [];
      while ($authors = $stmt->fetch()) {
      ?>
        <li><input type='text' name='first_name' value='<?= $authors['first_name']; ?>'> <input type='text' name='last_name' value='<?= $authors['last_name']; ?>'> <small><?= $authors['author_id']; ?></small></li>
      <?php
      } ?>

    </ul>
    </p>
    <p><strong>Keel:</strong> <input type='text' name='language' value='<?= $book['language']; ?>'></p>
    <p><strong>Hind:</strong> <input type='number' name='price' step='any' value='<?= number_format($book['price'], 2); ?>'> € <small><em>(keskmine lehe hind: <?= round($book['price'] / $book['pages'], 2); ?> €)</em></small></p>
    <p><strong>Lehti:</strong> <input type='number' name='pages' value='<?= $book['pages']; ?>'></p>
    <p><strong>Kokkuvõte:</strong> <textarea name='summary' rows="10" cols="50"><?= $book['summary']; ?></textarea></p>
    <p><strong>Laoseis:</strong> <input type='number' min="0" name='stock_saldo' value='<?= $book['stock_saldo']; ?>'></p>
    <p><strong>Raamatu tüüp:</strong>
      <select name="type">
        <option value="<?= $book['type']; ?>" selected="<?= $book['type']; ?>">
          <?= $book['type']; ?>
        </option>
        <option value="new">new</option>
        <option value="used">used</option>
        <option value="ebook">ebook</option>
      </select>
    </p>

    <input type="hidden" name="id" value="<?= $book['id']; ?>">
    <button onclick="return confirm('Oled kindel, et soovid muuta?')">Muuda</button>
  </form>
</body>

</html>