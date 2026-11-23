<?php
require '../config/conexao.php';
include '../includes/header.php';
$lista = $pdo->query("SELECT * FROM pacientes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-success">Pacientes</h3>
    <a href="form.php" class="btn btn-success">+ Novo Paciente</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Nome</th><th>Idade</th><th>Peso (kg)</th><th>Altura (m)</th><th>Objetivo</th><th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= $p['idade'] ?> anos</td>
                    <td><?= $p['peso'] ?> kg</td>
                    <td><?= $p['altura'] ?> m</td>
                    <td><?= htmlspecialchars($p['objetivo']) ?></td>
                    <td>
                        <a href="form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir paciente e suas dietas?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>