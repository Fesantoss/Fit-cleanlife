<?php
require '../config/conexao.php';
if (isset($_GET['id'])) {
    try {
        $pdo->prepare("DELETE FROM alimentos WHERE id = ?")->execute([$_GET['id']]);
    } catch (PDOException $e) {
        header("Location: index.php?erro=1");
        exit;
    }
}
header("Location: index.php");