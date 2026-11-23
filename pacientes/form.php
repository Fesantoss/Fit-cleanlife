<?php
require '../config/conexao.php';
$id = $_GET['id'] ?? null;
$p = ['nome' => '', 'idade' => '', 'peso' => '', 'altura' => '', 'objetivo' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['nome'], $_POST['idade'], $_POST['peso'], $_POST['altura'], $_POST['objetivo']];
    if ($id) {
        $dados[] = $id;
        $pdo->prepare("UPDATE pacientes SET nome=?, idade=?, peso=?, altura=?, objetivo=? WHERE id=?")->execute($dados);
    } else {
        $pdo->prepare("INSERT INTO pacientes (nome, idade, peso, altura, objetivo) VALUES (?, ?, ?, ?, ?)")->execute($dados);
    }
    header("Location: index.php");
    exit;
}
include '../includes/header.php';
?>
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header card-header-nutri"><?= $id ? 'Editar' : 'Novo' ?> Paciente</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($p['nome']) ?>" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Idade</label>
                    <input type="number" name="idade" class="form-control" value="<?= $p['idade'] ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="<?= $p['peso'] ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Altura (m)</label>
                    <input type="number" step="0.01" name="altura" class="form-control" value="<?= $p['altura'] ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Objetivo</label>
                <input type="text" name="objetivo" class="form-control" placeholder="Ex: Emagrecimento, Hipertrofia..." value="<?= htmlspecialchars($p['objetivo']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>