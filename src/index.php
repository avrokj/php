<?php
require_once('./connection.php');
$per_page = '';
$page = 1;
$start = 0;
$limit = 100;

$sql = $pdo->query('SELECT max(rn) rn from (SELECT *, (@rn := @rn + 1) as rn FROM books a cross join (SELECT @rn := 0) params where is_deleted <> 1 order by title) a');
$sql->execute();
$maxrn = $sql->fetch();
$total_rows = $maxrn['rn'];

// get the required number of pages
$total_pages = ceil($total_rows / $limit);

// update the active page number
if (!isset($_GET['page'])) {
    $page_number = 1;
} else {
    $page_number = $_GET['page'];
}

// get the initial page number
$initial_page = ($page_number - 1) * $limit;

// get data of selected rows per page
$stmt = $pdo->query('select * from (SELECT *, (@rn := @rn + 1) as rn FROM books a cross join (SELECT @rn := 0) params where is_deleted <> 1 order by title) a limit ' . $initial_page . ',' . $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raamatud</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-gray-300 dark:bg-slate-900 text-slate-900 dark:text-white">
    <div class="container mx-auto shadow rounded-lg m-4">

        <?php include('./header.php'); ?>

        <div class="container m-auto bg-white dark:bg-slate-700 overflow-auto p-4">
            <ul class="list-inside columns-2">

                <?php
                $num_rows = 0;
                while ($row = $stmt->fetch()) {
                ?>
                    <li class="py-1"><?= $row['rn']; ?>.&nbsp;
                        <a href="./book.php?id=<?= $row['id']; ?>">
                            <?= $row['title']; ?>
                        </a>
                        <small class="italic text-slate-500"><?= $row['id']; ?></small>
                    </li>
                <?php
                }
                ?>
            </ul>
            <div class="mt-4">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href="index.php?page=<?php if ($page_number < 2) {
                                                    echo $page_number;
                                                } else {
                                                    echo $page_number - 1;
                                                }; ?>" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" title="Eelmine">
                            <span class="sr-only">Eelmine</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    <?php
                    for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                        $page = $_GET['page'];
                        if ($page == $page_number) {
                            echo '<li>';
                            echo '<a href = "index.php?page=' . $page_number . '" aria-current="page" class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">' . $page_number . '</a>';
                            echo '</li>';
                        } else {
                            echo '<li>';
                            echo '<a href = "index.php?page=' . $page_number . '" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">' . $page_number . '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                    <li>
                        <a href="index.php?page=<?php $page_number = $_GET['page'];
                                                if ($page_number < $total_pages) {
                                                    echo $page_number + 1;
                                                } else {
                                                    echo $page_number;
                                                }; ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" title="Järgmine">
                            <span class="sr-only">Järgmine</span>
                            <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </li>
                    <li>
                </ul>
            </div>

        </div>

        <?php include('./footer.php'); ?>

    </div>
</body>

</html>