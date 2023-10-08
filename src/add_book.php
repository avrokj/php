<?php

require_once('./connection.php');

$sql = $pdo->query('SELECT max(id) maxid FROM books');
$sql->execute();
$maxid = $sql->fetch();
$max_id = $maxid['maxid'] + 1;

if (isset($_POST['add_book'])) {

  if ($_POST['price'] == '') {
    $price_value = 1;
  } else {
    $price_value = $_POST['price'];
  }

  $id = $_POST['id'];
  $title = $_POST['title'];
  $language = $_POST['language'];
  $price = $price_value;
  $pages = $_POST['pages'];
  $summary = $_POST['summary'];
  $stock_saldo = $_POST['stock_saldo'];
  $type = $_POST['type'];

  $stmt = $pdo->prepare('INSERT INTO books (title, language, price, pages, summary, stock_saldo, type) VALUES (:title, :language, :price, :pages, :summary, :stock_saldo, :type)');
  $stmt->execute(['title' => $title, 'language' => $language, 'price' => $price, 'pages' => $pages, 'summary' => $summary, 'stock_saldo' => $stock_saldo, 'type' => $type]);

  // $stmt = $pdo->prepare('UPDATE authors SET first_name = :first_name, last_name = :last_name WHERE id = :id');
  // $stmt->execute([$first_name, $last_name, $id]);

  echo "<script>
          /* alert('Uuendatud!'); */ 
          window.location.href = './edit.php?id=$max_id';
          </script>";
  exit();
}
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
  <script src="./app.js" type="javascript"></script>

</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
  <div class="container mx-auto shadow rounded-lg m-4">

    <?php include('./header.php'); ?>

    <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
      <form action="./add_book.php" method="post" id="add_book">
        <div class="grid grid-cols-4 gap-4">
          <div class=""><img src="" class="object-contain w-full">Pildi lisamine on arendamisel :)</div>
          <div class="col-span-3">
            <h1 class="text-2xl">Pealkiri: <input type='text' name='title' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'></h1>
            <label class="block font-bold mt-2">Author:</label>
            <ul>
              <li>Autori saab lisada raamatule peale esmast salvestamist.</li>
            </ul>
            </p>
            <label class="block font-bold mt-2">Keel</label>
            <input type='text' name='language' value='<?= $book['language']; ?>' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
            <label class="block font-bold mt-2">Hind</label>
            <input type='number' name='price' step='any' class='dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'> €


            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block font-bold mt-2">Lehti</label>
                <input type='number' name='pages' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0"><label class="block font-bold mt-2">Laoseis</label>
                <input type='number' min="0" name='stock_saldo' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0"><label class="block font-bold mt-2">Raamatu tüüp:</label>
                <select name="type" class="w-full dark:bg-slate-500 border dark:border-cyan-600 shadow block border px-4 py-2 pr-8 rounded focus:shadow-outline">
                  <option selected="true" disabled="disabled">- vali tüüp -</option>
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
          <textarea name='summary' rows="10" cols="50" class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded shadow p-4 focus:shadow-outline'></textarea>
        </div>


        <div class="inline-flex pt-10 gap-4">
          <a href="./index.php" name="back" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-home"></i> Avalehele</a>
          <input type="hidden" name="id">
          <button type="submit" name="add_book" onclick="return confirm('Oled kindel, et soovid uue raamatu lisada?')" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"><i class="fa fa-floppy-o"></i> Salvesta</button>
        </div>
      </form>

    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>