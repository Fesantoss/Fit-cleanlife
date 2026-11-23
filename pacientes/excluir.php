<?php
require '../config/conexao.php';
if (isset($_GET['id'])) {
    $pdo->prepare("DELETE FROM pacientes WHERE id = ?")->execute([$_GET['id']]);
}
header("Location: index.php");