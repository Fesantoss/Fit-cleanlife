<?php
require '../config/conexao.php';
$id = $_GET['id'] ?? null;

// Se vier da consulta de API via GET, já preenche os campos automaticamente
$a = [
    'nome'         => $_GET['nome'] ?? '',
    'calorias'     => $_GET['cal'] ?? '',
    'proteinas'    => $_GET['prot'] ?? '',
    'carboidratos' => $_GET['carb'] ?? '',
    'gorduras'     => $_GET['gord'] ?? ''
];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM alimentos WHERE id = ?");
    $stmt->execute([$id]);
    $a = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['nome'], $_POST['calorias'], $_POST['proteinas'], $_POST['carboidratos'], $_POST['gorduras']];
    if ($id) {
        $dados[] = $id;
        $pdo->prepare("UPDATE alimentos SET nome=?, calorias=?, proteinas=?, carboidratos=?, gorduras=? WHERE id=?")->execute($dados);
    } else {
        $pdo->prepare("INSERT INTO alimentos (nome, calorias, proteinas, carboidratos, gorduras) VALUES (?, ?, ?, ?, ?)")->execute($dados);
    }
    header("Location: index.php");
    exit;
}
include '../includes/header.php';
?>
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header card-header-nutri"><?= $id ? 'Editar' : 'Cadastrar' ?> Alimento (Porção 100g)</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome do Alimento</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($a['nome']) ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Calorias (kcal)</label>
                    <input type="number" step="0.01" name="calorias" class="form-control" value="<?= $a['calorias'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Proteínas (g)</label>
                    <input type="number" step="0.01" name="proteinas" class="form-control" value="<?= $a['proteinas'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Carboidratos (g)</label>
                    <input type="number" step="0.01" name="carboidratos" class="form-control" value="<?= $a['carboidratos'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gorduras (g)</label>
                    <input type="number" step="0.01" name="gorduras" class="form-control" value="<?= $a['gorduras'] ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar no Catálogo</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>