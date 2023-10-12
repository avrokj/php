<?php

require_once('./connection.php');

$keyword = $_POST['keyword'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE is_deleted <> 1 and lower(title) LIKE lower(:keyword) order by title');
$stmt->execute(['keyword' => '%' . $keyword . '%']);
$book = $stmt->fetchAll();
$count = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otsi raamatut</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
  <div class="container mx-auto shadow rounded-lg m-4">

    <?php include('./header.php'); ?>

    <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
      <h1 class="text-2xl">Otsingu tulemused:</h1>

      <?php if (count($book) > 0) {
        echo "<p class='py-2'>Tulemusi otsingule <strong>$keyword</strong> leiti <strong>$count</strong> tulemust.</p>";
      ?>

        <ol class="list-inside list-decimal">

          <?php
          foreach ($book as $row) {
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
        echo "<p>Tulemusi otsingule <strong>$keyword</strong> ei leitud.</p>";
      }
        ?>

        <div class="inline-flex pt-10 gap-4">
          <a href="./index.php" name="back" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"><i class="fa fa-arrow-left"></i> Avalehele</a>
        </div>

    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>