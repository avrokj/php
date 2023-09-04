<?php

require_once('./connection.php');

$id = $_POST['id'];

$stmt = $pdo->prepare('UPDATE books SET is_deleted=1 WHERE id = :id'); // statement objekti
$stmt->execute(['id' => $id]); // tagastab statementi

header('Location: index.php');