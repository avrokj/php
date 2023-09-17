<?php

include_once 'connection.php';

$stmt = $pdo->query('SELECT * FROM books');

echo "<ul>";

while ($row = $stmt->fetch())
{
    ?> 
        <li>
            <a href="./book.php?id=<?= $row['id']; ?>">
                <?= $row['title'];?>
            </a>
        </li>
<?php
}?>
echo "</ul>";