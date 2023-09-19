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
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $book['title']; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./output.css" rel="stylesheet">
  <script src="./app.js" type="javascript"></script>

</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
  <div class="container mx-auto shadow rounded-lg m-4">

    <?php include('./header.php'); ?>

    <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
      <div class="grid grid-cols-4 gap-4">
        <div class=""><img src=" <?= $book['cover_path']; ?>" class="object-contain w-full"></div>
        <div class="col-span-3">
          <h1 class="text-2xl"><?= $book['title']; ?></h1>
          <p class="py-2"><strong>Author:</strong>
            <?php
            $author = [];
            while ($authors = $stmt->fetch()) {
              $author[] = $authors['first_name'] . ' ' . $authors['last_name'];
            } ?>
            <span><?= implode(', ', $author); ?></span>
          </p>
          <p class="py-2"><strong>Keel:</strong> <?= $book['language']; ?></p>
          <p class="py-2"><strong>Hind:</strong> <?= number_format($book['price'], 2); ?> € <small><em>(keskmine lehe hind: <?= round($book['price'] / $book['pages'], 2); ?> €)</em></small></p>
          <p class="py-2"><strong>Lehti:</strong> <?= $book['pages']; ?></p>
          <p class="py-2"><strong>Laoseis:</strong> <?= $book['stock_saldo']; ?></p>
          <p class="py-2"><strong>Raamatu tüüp:</strong> <?= $book['type']; ?></p>
        </div>
      </div>

      <div class="py-4"><strong>Kokkuvõte:</strong> <?= $book['summary']; ?></div>

      <div class="inline-flex pt-10">
        <form action="edit.php?id=<?= $id; ?>" method="post" id="edit" class="pr-4">
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <button onclick="return confirm('Oled kindel, et soovid muuta?')" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-pencil" aria-hidden="true"></i> Muuda</button>
        </form>
        <form action="delete.php" method="post" id="delete" class="pr-4">
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <button onclick="return confirm('Oled kindel, et soovid kustutada?')" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded"><i class="fa fa-trash" aria-hidden="true"></i> Kustuta</button>
        </form>
      </div>

    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>