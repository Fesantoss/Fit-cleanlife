<?php
require '../config/conexao.php';
include '../includes/header.php';
$sql = "SELECT r.*, d.nome_dieta, p.nome AS paciente_nome, a.nome AS alimento_nome, a.calorias 
        FROM refeicoes r
        INNER JOIN dietas d ON r.dieta_id = d.id
        INNER JOIN pacientes p ON d.paciente_id = p.id
        INNER JOIN alimentos a ON r.alimento_id = a.id
        ORDER BY p.nome, r.horario";
$lista = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-success">Refeições Programadas</h3>
    <a href="form.php" class="btn btn-success">+ Nova Refeição</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Horário</th><th>Paciente / Dieta</th><th>Alimento</th><th>Quantidade</th><th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $r): ?>
                <tr>
                    <td><span class="badge bg-success"><?= substr($r['horario'], 0, 5) ?></span></td>
                    <td><?= htmlspecialchars($r['paciente_nome']) ?> <small class="text-muted">(<?= htmlspecialchars($r['nome_dieta']) ?>)</small></td>
                    <td><?= htmlspecialchars($r['alimento_nome']) ?></td>
                    <td><?= htmlspecialchars($r['quantidade']) ?></td>
                    <td>
                        <a href="form.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover esta refeição?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>