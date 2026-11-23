<?php
require '../config/conexao.php';
$id = $_GET['id'] ?? null;
$d = ['paciente_id' => '', 'nome_dieta' => '', 'data_inicio' => date('Y-m-d'), 'descricao' => ''];

$pacientes = $pdo->query("SELECT id, nome FROM pacientes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM dietas WHERE id = ?");
    $stmt->execute([$id]);
    $d = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['paciente_id'], $_POST['nome_dieta'], $_POST['data_inicio'], $_POST['descricao']];
    if ($id) {
        $dados[] = $id;
        $pdo->prepare("UPDATE dietas SET paciente_id=?, nome_dieta=?, data_inicio=?, descricao=? WHERE id=?")->execute($dados);
    } else {
        $pdo->prepare("INSERT INTO dietas (paciente_id, nome_dieta, data_inicio, descricao) VALUES (?, ?, ?, ?)")->execute($dados);
    }
    header("Location: index.php");
    exit;
}
include '../includes/header.php';
?>
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header card-header-nutri"><?= $id ? 'Editar' : 'Novo' ?> Plano Alimentar</div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Paciente</label>
                <select name="paciente_id" class="form-select" required>
                    <option value="">Selecione um paciente...</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $d['paciente_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nome da Dieta</label>
                <input type="text" name="nome_dieta" class="form-control" placeholder="Ex: Dieta Low Carb - Fase 1" value="<?= htmlspecialchars($d['nome_dieta']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Data de Início</label>
                <input type="date" name="data_inicio" class="form-control" value="<?= $d['data_inicio'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição / Observações</label>
                <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($d['descricao']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Salvar Dieta</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>