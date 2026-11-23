<?php
require '../config/conexao.php';
include '../includes/header.php';
$lista = $pdo->query("SELECT * FROM alimentos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-success">Catálogo de Alimentos</h3>
    <div>
        <a href="consultar_apis.php" class="btn btn-outline-success me-2">🔍 Consultar APIs (USDA / OpenFood)</a>
        <a href="form.php" class="btn btn-success">+ Novo Alimento</a>
    </div>
</div>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger">Não é possível excluir este alimento pois ele está vinculado a uma refeição!</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Alimento</th><th>Calorias (kcal)</th><th>Proteínas (g)</th><th>Carboidratos (g)</th><th>Gorduras (g)</th><th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['nome']) ?></td>
                    <td><?= $a['calorias'] ?></td>
                    <td><?= $a['proteinas'] ?></td>
                    <td><?= $a['carboidratos'] ?></td>
                    <td><?= $a['gorduras'] ?></td>
                    <td>
                        <a href="form.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir alimento?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>