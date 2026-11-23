<?php
require 'config/conexao.php';
include 'includes/header.php';

$totPacientes = $pdo->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
$totAlimentos = $pdo->query("SELECT COUNT(*) FROM alimentos")->fetchColumn();
$totDietas    = $pdo->query("SELECT COUNT(*) FROM dietas")->fetchColumn();
$totRefeicoes = $pdo->query("SELECT COUNT(*) FROM refeicoes")->fetchColumn();
?>

<div class="p-4 mb-4 bg-white rounded-3 shadow-sm border-start border-success border-5">
    <h2 class="text-success">Painel de Controle Nutricional</h2>
    <p class="text-muted mb-0">Bem-vindo ao sistema de gerenciamento de pacientes, alimentos, planos alimentares e refeições.</p>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Pacientes</h5>
                <h2 class="text-success fw-bold"><?= $totPacientes ?></h2>
                <a href="pacientes/index.php" class="btn btn-outline-success btn-sm mt-2">Gerenciar</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Alimentos</h5>
                <h2 class="text-success fw-bold"><?= $totAlimentos ?></h2>
                <a href="alimentos/index.php" class="btn btn-outline-success btn-sm mt-2">Catálogo & APIs</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Dietas Ativas</h5>
                <h2 class="text-success fw-bold"><?= $totDietas ?></h2>
                <a href="dietas/index.php" class="btn btn-outline-success btn-sm mt-2">Planos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="text-muted">Refeições</h5>
                <h2 class="text-success fw-bold"><?= $totRefeicoes ?></h2>
                <a href="refeicoes/index.php" class="btn btn-outline-success btn-sm mt-2">Organizar</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>