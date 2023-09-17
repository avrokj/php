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
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./output.css" rel="stylesheet">

</head>

<body class="bg-gray-300">
  <div class="container mx-auto shadow rounded-lg m-4 border">

    <header class="flex bg-gray-200 shadow rounded-t-lg grid grid-cols-3 p-4 sticky top-0">
      <div class="self-center">
        <a href="./">
          <h1 class="text-4xl">Raamatud</h1>
        </a>
      </div>
      <div class="flex justify-center items-center">
        <form action="./search.php" method="post" class="max-w-[480px] w-full px-4">
          <div class="relative">
            <input type="text" name="SearchValue" id="" placeholder="Sisesta raamatu nimi..." class="w-full border h-12 shadow p-4 rounded-full">
            <button name="search" title="Otsi"><svg class="text-teal-400 h-5 w-5 absolute top-3.5 right-3 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z">
                </path>
              </svg></button>
          </div>
        </form>
      </div>
      <div class="text-right self-center">Raamatu ID: <strong><?= $id; ?></strong>.</div>


    </header>

    <div class="container m-auto bg-gray-100 overflow-auto p-4">
      <div class="grid grid-cols-4 gap-4">
        <div class=""><img src=" <?= $book['cover_path']; ?>" class="object-contain w-full"></div>
        <div class="col-span-3">
          <h1 class="text-2xl"><?= $book['title']; ?></h1>
          <p><strong>Author:</strong>
            <?php
            $author = [];
            while ($authors = $stmt->fetch()) {
              $author[] = $authors['first_name'] . ' ' . $authors['last_name'];
            } ?>
            <span><?= implode(', ', $author); ?></span>
          </p>
          <p><strong>Keel:</strong> <?= $book['language']; ?></p>
          <p><strong>Hind:</strong> <?= number_format($book['price'], 2); ?> € <small><em>(keskmine lehe hind: <?= round($book['price'] / $book['pages'], 2); ?> €)</em></small></p>
          <p><strong>Lehti:</strong> <?= $book['pages']; ?></p>
          <p><strong>Laoseis:</strong> <?= $book['stock_saldo']; ?></p>
          <p><strong>Raamatu tüüp:</strong> <?= $book['type']; ?></p>
        </div>
      </div>



      <div class="py-4"><strong>Kokkuvõte:</strong> <?= $book['summary']; ?></div>
      <div class="inline-flex pt-10">
        <form action="edit.php" method="post" id="edit" class="pr-4">
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <button onclick="return confirm('Oled kindel, et soovid muuta?')" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-pencil" aria-hidden="true"></i> Muuda</button>
        </form>
        <form action="delete.php" method="post" id="delete" class="pr-4">
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <button onclick="return confirm('Oled kindel, et soovid kustutada?')" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded"><i class="fa fa-trash" aria-hidden="true"></i> Kustuta</button>
        </form>
      </div>



    </div>
    <footer class="flex bg-gray-200 shadow rounded-b-lg grid grid-cols-2 p-4">
      <div>&copy; Raamatud <?= date("Y"); ?></div>
      <div class="text-right">
        <a href="./" class="px-4">> Lisa raamat </a>
        <a href="./" class="px-4">> Lisa autor </a>
      </div>
    </footer>
  </div>
</body>

</html>