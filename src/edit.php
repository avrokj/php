<?php

require_once('./connection.php');

$id = $_GET['id'];

if (isset($_POST['edit_book'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $language = $_POST['language'];
  $price = $_POST['price'];
  $pages = $_POST['pages'];
  $summary = $_POST['summary'];
  $stock_saldo = $_POST['stock_saldo'];
  $type = $_POST['type'];

  $stmt = $pdo->prepare('UPDATE books SET title = :title, language = :language, price = :price, pages = :pages, summary = :summary, stock_saldo = :stock_saldo, type = :type WHERE id = :id');
  $stmt->execute([$title, $language, $price, $pages, $summary, $stock_saldo, $type, $id]);

  echo "<script>
          /* alert('Uuendatud!'); */ 
          window.location.href = './book.php?id=$id';
          </script>";
  exit();
} else if (isset($_POST['add_author'])) {
  $id = $_GET['id'];
  $book_id = $_POST['book_id'];
  $author_id = $_POST['author_id'];
  //var_dump($author_id);

  $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
  $stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);


  echo "<script>
          /* alert('Lisatud!'); */ 
          window.location.href = './edit.php?id=$id';
          </script>";
  exit();
} else if (isset($_POST['remove_author'])) {
  $book_id = $_POST['book_id'];
  $author_id = $_POST['author_id'];

  $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id= :book_id AND author_id= :author_id');
  $stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);

  echo "<script>
          /* alert('Eemaldatud!'); */ 
          window.location.href = './edit.php?id=$id';
          </script>";
  exit();
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id'); // statement objekti
$stmt->execute(['id' => $id]); // tagastab statementi
$book = $stmt->fetch(); // tagastab array

$stmt = $pdo->prepare('SELECT * FROM book_authors ba left join authors a on a.id = ba.author_id WHERE ba.book_id = :book_id');
$stmt->execute(['book_id' => $id]);

$authorsStmt = $pdo->query('SELECT * FROM authors order by first_name');

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
  <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./output.css" rel="stylesheet">
  <script src="./assets/app.js" type="javascript"></script>

</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
  <div class="container mx-auto shadow rounded-lg m-4">

    <?php include('./header.php'); ?>

    <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
      <form method="post" id="edit_book">
        <div class="grid grid-cols-4 gap-4">
          <div class=""><img src=" <?= $book['cover_path']; ?>" class="object-contain w-full"></div>
          <div class="col-span-3">
            <h1 class="text-2xl">Pealkiri: <input type='text' name='title' value='<?= $book['title']; ?>' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'></h1>
            <label class="block font-bold mt-2">Autor:</label>
            <ul>
              <?php
              $author = [];
              while ($authors = $stmt->fetch()) {
              ?>
                <li class="flex gap-2 pb-2">
                  <input type='text' name='first_name' value='<?= $authors['first_name']; ?>' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
                  <input type='text' name='last_name' value='<?= $authors['last_name']; ?>' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
                  <!-- <small><?= $authors['author_id']; ?></small> -->
                  <input type="hidden" name="book_id" value="<?= $id; ?>">
                  <input type="hidden" name="author_id" value="<?= $authors['author_id']; ?>">
                  <button type="submit" name="remove_author" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded" title="Eemalda autor"><i class="fa fa-user-times"></i></button>
                </li>
              <?php
              } ?>
            </ul>

            <span>Lisa autor: </span></br>
            <input type="hidden" name="book_id" value="<?= $id; ?>">
            <select name="author_id" class="w-half dark:bg-slate-500 border dark:border-cyan-600 shadow border px-4 py-2 pr-8 rounded focus:shadow-outline">
              <option selected="true" disabled="disabled">- vali autor -</option>
              <?php
              while ($author = $authorsStmt->fetch()) {
                echo '<option value="' . $author["id"] . '">' . $author["first_name"] . ' ' . $author["last_name"] . '</option>';
              }
              ?>
            </select>
            <button type="submit" name="add_author" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"><i class="fa fa-user-plus"></i> Lisa autor</button>
            <label class="block font-bold mt-2">Keel</label>
            <input type='text' name='language' value='<?= $book['language']; ?>' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
            <label class="block font-bold mt-2">Hind</label>
            <input type='number' name='price' step='any' value='<?= number_format($book['price'], 2); ?>' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'> €

            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block font-bold mt-2">Lehti</label>
                <input type='number' name='pages' value='<?= $book['pages']; ?>' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0"><label class="block font-bold mt-2">Laoseis</label>
                <input type='number' min="0" name='stock_saldo' value='<?= $book['stock_saldo']; ?>' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0"><label class="block font-bold mt-2">Raamatu tüüp:</label>
                <select name="type" class="w-full dark:bg-slate-500 border dark:border-cyan-600 shadow block border px-4 py-2 pr-8 rounded focus:shadow-outline">
                  <option value="<?= $book['type']; ?>" selected="<?= $book['type']; ?>">
                    <?= $book['type']; ?>
                  </option>
                  <option value="new">new</option>
                  <option value="used">used</option>
                  <option value="ebook">ebook</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="py-4">
          <label class="block font-bold mt-2">Kokkuvõte:</label>
          <textarea name='summary' rows="10" cols="50" class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded shadow p-4 focus:shadow-outline'><?= $book['summary']; ?></textarea>
        </div>

        <div class="inline-flex pt-10 gap-4">
          <a href="./book.php?id=<?= $id; ?>" name="back" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-arrow-left"></i> Tagasi</a>
          <input type="hidden" name="id" value="<?= $book['id']; ?>">
          <button type="submit" name="edit_book" onclick="return confirm('Oled kindel, et soovid muutused salvestada?')" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"><i class="fa fa-floppy-o"></i> Salvesta</button>
        </div>
      </form>

    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>