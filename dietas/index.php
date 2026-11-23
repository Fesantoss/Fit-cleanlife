<?php
require '../config/conexao.php';
include '../includes/header.php';
$sql = "SELECT d.*, p.nome AS paciente_nome 
        FROM dietas d 
        INNER JOIN pacientes p ON d.paciente_id = p.id 
        ORDER BY d.data_inicio DESC";
$lista = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-success">Planos Alimentares (Dietas)</h3>
    <a href="form.php" class="btn btn-success">+ Nova Dieta</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Paciente</th><th>Nome da Dieta</th><th>Início</th><th>Descrição</th><th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $d): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($d['paciente_nome']) ?></strong></td>
                    <td><?= htmlspecialchars($d['nome_dieta']) ?></td>
                    <td><?= date('d/m/Y', strtotime($d['data_inicio'])) ?></td>
                    <td><?= htmlspecialchars($d['descricao']) ?></td>
                    <td>
                        <a href="form.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta dieta e suas refeições?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>