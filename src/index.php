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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="./output.css" rel="stylesheet">

</head>

<body class="bg-gray-300">
    <div class="container mx-auto shadow rounded-lg m-4 border">

        <header class="flex bg-gray-200 shadow rounded-t-lg grid grid-cols-3 p-4 sticky top-0">
            <div class="self-center">
                <h1 class="text-4xl">Raamatud</h1>
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
            <div class="text-right self-center">Meil on <strong><?= $stmt->rowCount(); ?></strong> raamatut.</div>


        </header>

        <div class="flex flex-1 bg-gray-100 overflow-auto p-4">
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