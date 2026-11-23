<?php
include '../includes/header.php';

$termo = $_GET['termo'] ?? '';
$fonte = $_GET['fonte'] ?? 'openfood';
$resultados = [];
$erroApi = '';

// Função auxiliar para fazer requisições HTTP simples (funciona no InfinityFree)
function buscarJson($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'NutriSysDW2/1.0 (Projeto Academico)');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp ? json_decode($resp, true) : null;
}

if (!empty($termo)) {
    $q = urlencode($termo);

    if ($fonte === 'openfood') {
        // API 2: Open Food Facts
        $url = "https://world.openfoodfacts.org/cgi/search.pl?search_terms={$q}&search_simple=1&action=process&json=1&page_size=8";
        $data = buscarJson($url);
        if (!empty($data['products'])) {
            foreach ($data['products'] as $prod) {
                $nutr = $prod['nutriments'] ?? [];
                $resultados[] = [
                    'nome' => $prod['product_name'] ?? 'Produto sem nome',
                    'marca' => $prod['brands'] ?? '-',
                    'cal'  => round($nutr['energy-kcal_100g'] ?? 0, 2),
                    'prot' => round($nutr['proteins_100g'] ?? 0, 2),
                    'carb' => round($nutr['carbohydrates_100g'] ?? 0, 2),
                    'gord' => round($nutr['fat_100g'] ?? 0, 2),
                ];
            }
        } else {
            $erroApi = "Nenhum produto encontrado no Open Food Facts para '{$termo}'.";
        }
    } else {
        // API 1: USDA FoodData Central (Substitua DEMO_KEY pela sua chave gratuita se desejar)
        $apiKey = "DEMO_KEY";
        $url = "https://api.nal.usda.gov/fdc/v1/foods/search?query={$q}&pageSize=8&api_key={$apiKey}";
        $data = buscarJson($url);
        if (!empty($data['foods'])) {
            foreach ($data['foods'] as $food) {
                $cal = $prot = $carb = $gord = 0;
                foreach ($food['foodNutrients'] as $n) {
                    if ($n['nutrientId'] == 1008) $cal  = $n['value']; // Energy (kcal)
                    if ($n['nutrientId'] == 1003) $prot = $n['value']; // Protein
                    if ($n['nutrientId'] == 1005) $carb = $n['value']; // Carbohydrate
                    if ($n['nutrientId'] == 1004) $gord = $n['value']; // Total lipid (fat)
                }
                $resultados[] = [
                    'nome' => $food['description'],
                    'marca' => $food['brandOwner'] ?? 'USDA Base',
                    'cal'  => round($cal, 2),
                    'prot' => round($prot, 2),
                    'carb' => round($carb, 2),
                    'gord' => round($gord, 2),
                ];
            }
        } else {
            $erroApi = "Nenhum alimento encontrado na USDA (ou limite da DEMO_KEY atingido).";
        }
    }
}
?>

<h3 class="text-success mb-3">Consulta Nutricional Externa (APIs)</h3>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="termo" class="form-control" placeholder="Ex: Banana, Aveia, Chicken breast..." value="<?= htmlspecialchars($termo) ?>" required>
            </div>
            <div class="col-md-4">
                <select name="fonte" class="form-select">
                    <option value="openfood" <?= $fonte === 'openfood' ? 'selected' : '' ?>>Open Food Facts (Produtos/Marcas)</option>
                    <option value="usda" <?= $fonte === 'usda' ? 'selected' : '' ?>>USDA FoodData Central (Base Oficial EUA)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">Pesquisar na API</button>
            </div>
        </form>
        <small class="text-muted d-block mt-2">Dica: Na base da USDA, pesquisas em inglês (ex: "Rice", "Egg", "Apple") retornam resultados mais precisos.</small>
    </div>
</div>

<?php if ($erroApi): ?>
    <div class="alert alert-warning"><?= $erroApi ?></div>
<?php endif; ?>

<?php if (!empty($resultados)): ?>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Alimento / Produto</th><th>Origem/Marca</th><th>Kcal</th><th>Prot (g)</th><th>Carb (g)</th><th>Gord (g)</th><th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $r): 
                    $linkImportar = "form.php?nome=" . urlencode($r['nome']) . "&cal={$r['cal']}&prot={$r['prot']}&carb={$r['carb']}&gord={$r['gord']}";
                ?>
                <tr>
                    <td><?= htmlspecialchars($r['nome']) ?></td>
                    <td><small class="text-muted"><?= htmlspecialchars($r['marca']) ?></small></td>
                    <td><?= $r['cal'] ?></td>
                    <td><?= $r['prot'] ?></td>
                    <td><?= $r['carb'] ?></td>
                    <td><?= $r['gord'] ?></td>
                    <td><a href="<?= $linkImportar ?>" class="btn btn-sm btn-success">+ Importar</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>