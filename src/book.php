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

    <header class="flex bg-gray-200 dark:bg-slate-800 shadow rounded-t-lg grid grid-cols-3 p-4 sticky top-0">

      <div class="self-center">
        <a href="./">
          <h1 class="text-4xl">Raamatud</h1>
        </a>
      </div>

      <div class="flex justify-center items-center">
        <form action="./search.php" method="post" class="max-w-[480px] w-full px-4">
          <div class="relative">
            <input type="text" name="SearchValue" id="" placeholder="Sisesta raamatu nimi..." class="w-full dark:bg-slate-500 border dark:border-cyan-600 h-12 shadow p-4 rounded-full">
            <button name="search" title="Otsi"><svg class="text-teal-400 h-5 w-5 absolute top-3.5 right-3 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z">
                </path>
              </svg></button>
          </div>
        </form>
      </div>

      <div class="text-right self-center">Raamatu ID: <strong><?= $id; ?></strong>.
        <a class="hs-dark-mode-active:hidden block hs-dark-mode group flex items-center text-gray-600 hover:text-blue-600 font-medium dark:text-gray-400 dark:hover:text-gray-500" href="#!" data-hs-theme-click-value="dark">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
          </svg>
        </a>
        <a class="hs-dark-mode-active:block hidden hs-dark-mode group flex items-center text-gray-600 hover:text-blue-600 font-medium dark:text-gray-400 dark:hover:text-gray-500" href="#!" data-hs-theme-click-value="light">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
          </svg>
        </a>
      </div>

    </header>

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
    <footer class="flex bg-gray-200 dark:bg-slate-800 shadow rounded-b-lg grid grid-cols-2 p-4">
      <div>&copy; Raamatud <?= date("Y"); ?></div>
      <div class="text-right">
        <a href="./" class="px-4">> Lisa raamat </a>
        <a href="./" class="px-4">> Lisa autor </a>
      </div>
    </footer>
  </div>
</body>

</html>