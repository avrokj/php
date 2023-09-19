<?php

require_once('./connection.php');

if (isset($_POST['add-author'])) {

  $firstName = $_POST['first-name'];
  $lastName = $_POST['last-name'];

  $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first_name, :last_name)');
  $stmt->execute(['first_name' => $firstName, 'last_name' => $lastName]);
}

?>


<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autori lisamine</title>
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

      <h1 class="text-2xl">Lisa autor</h1>

      <form action="./add_author.php" method="post">
        <div class="flex flex-wrap -mx-3 mb-2">
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label class="block font-bold mt-2">Eesnimi</label>
            <input type='text' name='first-name' value='' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
          </div>
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"><label class="block font-bold mt-2">Perekonnanimi</label>
            <input type='text' min="0" name='last-name-name' value='' class='w-full dark:bg-slate-500 border dark:border-cyan-600 shadow rounded h-10 shadow p-4 focus:shadow-outline'>
          </div>
        </div>

        <div class="inline-flex pt-10 gap-4">
          <a href="./index.php" name="back" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-arrow-left"></i> Avalehele</a>
          <button type="submit" name="add-author" onclick="return confirm('Oled kindel, et soovid muuta?')" class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded"><i class="fa fa-floppy-o"></i> Lisa</button>
        </div>
    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>