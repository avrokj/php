<?php
require_once('./connection.php');
$stmt = $pdo->query('SELECT * FROM books where is_deleted <> 1 order by title');
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
            <ol class="list-inside list-decimal">

                <?php
                while ($row = $stmt->fetch()) {
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
        </div>

        <?php include('./footer.php'); ?>

    </div>
</body>

</html>