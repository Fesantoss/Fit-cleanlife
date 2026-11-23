<?php
// Define a raiz do projeto automaticamente (funciona tanto no XAMPP quanto no InfinityFree)
$base_url = '/nutricao_dw2'; // Na hospedagem, mude para '' (vazio) se subir direto na htdocs
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Nutrição e Dietas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f8f5; }
        .navbar-nutri { background-color: #198754; }
        .card-header-nutri { background-color: #e9f5ee; color: #146c43; font-weight: bold; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-nutri mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= $base_url ?>/index.php">🥗 NutriSys DW2</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>/index.php">Painel</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>/pacientes/index.php">Pacientes</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>/alimentos/index.php">Alimentos</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>/dietas/index.php">Dietas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>/refeicoes/index.php">Refeições</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mb-5">