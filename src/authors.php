<?php
require_once('./connection.php');
$stmt = $pdo->query('SELECT a.id author_id, a.first_name, a.last_name, b.id bookid, b.title FROM book_authors ba left join authors a on a.id = ba.author_id left join books b on ba.book_id = b.id order by first_name');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Raamatud</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
  <div class="container mx-auto shadow rounded-lg m-4">

    <?php include('./header.php'); ?>

    <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
      <div class="table-wrp block">
        <table class="min-w-full text-left">
          <thead class="border-b font-medium dark:border-neutral-500 sticky top-100">
            <tr>
              <th scope="col" class="px-4 py-2">Jrk.</th>
              <th scope="col" class="px-4 py-2">Autori nimi</th>
              <th scope="col" class="px-4 py-2">Raamatu pealkiri</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            while ($row = $stmt->fetch()) {
            ?><tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-4 py-2">
                  <?php
                  echo $i;
                  $i++;
                  ?>.
                </td>
                <td class="whitespace-nowrap px-4 py-2">
                  <a href="./author.php?id=<?= $row['author_id']; ?>">
                    <?= $row['first_name']; ?> <?= $row['last_name']; ?>
                  </a>
                </td>
                <td class="whitespace-nowrap px-4 py-2"><?= $row['title']; ?></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php include('./footer.php'); ?>

  </div>
</body>

</html>