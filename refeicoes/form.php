<?php
require '../config/conexao.php';
$id = $_GET['id'] ?? null;
$r = ['dieta_id' => '', 'alimento_id' => '', 'quantidade' => '', 'horario' => '08:00'];

$dietas = $pdo->query("SELECT d.id, d.nome_dieta, p.nome AS paciente FROM dietas d INNER JOIN pacientes p ON d.paciente_id = p.id ORDER BY p.nome")->fetchAll(PDO::FETCH_ASSOC);
$alimentos = $pdo->query("SELECT id, nome FROM alimentos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM refeicoes WHERE id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['dieta_id'], $_POST['alimento_id'], $_POST['quantidade'], $_POST['horario']];
    if ($id) {
        $dados[] = $id;
        $pdo->prepare("UPDATE refeicoes SET dieta_id=?, alimento_id=?, quantidade=?, horario=? WHERE id=?")->execute($dados);
    } else {
        $pdo->prepare("INSERT INTO refeicoes (dieta_id, alimento_id, quantidade, horario) VALUES (?, ?, ?, ?)")->execute($dados);
    }
    header("Location: index.php");
    exit;
}
include '../includes/header.php';
?>
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header card-header-nutri"><?= $id ? 'Editar' : 'Adicionar' ?> Refeição na Dieta</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Dieta / Paciente</label>
                <select name="dieta_id" class="form-select" required>
                    <option value="">Selecione a dieta...</option>
                    <?php foreach ($dietas as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= $d['id'] == $r['dieta_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['paciente']) ?> — <?= htmlspecialchars($d['nome_dieta']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Alimento</label>
                <select name="alimento_id" class="form-select" required>
                    <option value="">Selecione o alimento...</option>
                    <?php foreach ($alimentos as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= $a['id'] == $r['alimento_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantidade</label>
                    <input type="text" name="quantidade" class="form-control" placeholder="Ex: 150g ou 2 unidades" value="<?= htmlspecialchars($r['quantidade']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Horário</label>
                    <input type="time" name="horario" class="form-control" value="<?= substr($r['horario'], 0, 5) ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar Refeição</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>