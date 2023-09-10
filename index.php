<?php

require_once('./connection.php');

$stmt = $pdo->query('SELECT * FROM books where is_deleted <> 1');

?>

<h1>Raamatud</h1>

<?php
$count = $stmt->rowCount();
echo "<p>Meil on <strong>$count</strong> raamatut.</p>";
?>

<form action="./search.php" method="post">
    <input type="text" name="SearchValue" id="" placeholder="Sisesta raamatu nimi...">
    <button name="search" title="Otsi">Otsi</button>
</form>
<ul>

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