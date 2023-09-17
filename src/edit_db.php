<?php

require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $language = $_POST['language'];
  $price = $_POST['price'];
  $pages = $_POST['pages'];
  $summary = $_POST['summary'];
  $stock_saldo = $_POST['stock_saldo'];
  $type = $_POST['type'];

  $stmt = $pdo->prepare('UPDATE books SET title = :title, language = :language, price = :price, pages = :pages, summary = :summary, stock_saldo = :stock_saldo, type = :type WHERE id = :id');
  $stmt->execute([$title, $language, $price, $pages, $summary, $stock_saldo, $type, $id]);

  $stmt = $pdo->prepare('UPDATE books SET title = :title, language = :language, price = :price, pages = :pages, summary = :summary, stock_saldo = :stock_saldo, type = :type WHERE id = :id');
  $stmt->execute([$title, $language, $price, $pages, $summary, $stock_saldo, $type, $id]);

  // $stmt = $pdo->prepare('UPDATE authors SET first_name = :first_name, last_name = :last_name WHERE id = :id');
  // $stmt->execute([$first_name, $last_name, $id]);

  echo "<script>
          alert('Uuendatud!'); 
          window.location.href = './book.php?id=$id';
          </script>";
  exit();
}
