<?php
ob_start(); // Evita o erro de headers já enviados
require __DIR__ . '/../backend/conexao.php';

// Define ação (listar, adicionar ou editar)
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// ---------------------
// SALVAR NOVO OU EDIÇÃO
// ---------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    if (!empty($_POST['id'])) {
        // Atualiza quarto existente
        $stmt = $pdo->prepare("UPDATE rooms SET numero=?, tipo=?, price=?, status=? WHERE id=?");
        $stmt->execute([$numero, $tipo, $price, $status, $_POST['id']]);
    } else {
        // Insere novo quarto
        $stmt = $pdo->prepare("INSERT INTO rooms (numero, tipo, price, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$numero, $tipo, $price, $status]);
    }

    header("Location: rooms_crud.php");
    exit;
}

// ---------------------
// EXCLUIR QUARTO
// ---------------------
if ($action === 'delete' && $id) {
    $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: rooms_crud.php");
    exit;
}

// ---------------------
// EDITAR OU ADICIONAR FORMULÁRIO
// ---------------------
include 'layout_admin.php'; // Inclui layout só depois das ações acima

if ($action === 'add' || ($action === 'edit' && $id)) {
    $room = ['numero' => '', 'tipo' => '', 'price' => '', 'status' => 'Ativo'];
    if ($action === 'edit') {
        $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>
    <h2><?= $action === 'edit' ? 'Editar Quarto' : 'Adicionar Novo Quarto' ?></h2>

    <form method="POST" class="form-container">
        <?php if ($action === 'edit'): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($room['id']) ?>">
        <?php endif; ?>

        <label>Número:</label><br>
        <input type="text" name="numero" value="<?= htmlspecialchars($room['numero']) ?>" required><br><br>

        <label>Tipo:</label><br>
        <input type="text" name="tipo" value="<?= htmlspecialchars($room['tipo']) ?>" required><br><br>

        <label>Preço (R$):</label><br>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($room['price']) ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="Ativo" <?= $room['status'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="Inativo" <?= $room['status'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
        </select><br><br>

        <button type="submit" class="btn btn-edit">Salvar</button>
        <a href="rooms_crud.php" class="btn btn-delete">Cancelar</a>
    </form>
<?php
    ob_end_flush(); // Envia o buffer
    exit;
}

// ---------------------
// LISTAR QUARTOS
// ---------------------
$stmt = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gerenciar Quartos</h2>
<a href="rooms_crud.php?action=add" class="btn-add">+ Novo Quarto</a>

<div class="table-container">
    <h3>Lista de Quartos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Tipo</th>
                <th>Preço (R$)</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rooms) > 0): ?>
                <?php foreach ($rooms as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['id']) ?></td>
                        <td><?= htmlspecialchars($r['numero']) ?></td>
                        <td><?= htmlspecialchars($r['tipo']) ?></td>
                        <td><?= htmlspecialchars($r['price']) ?></td>
                        <td><?= htmlspecialchars($r['status']) ?></td>
                        <td>
                            <a href="rooms_crud.php?action=edit&id=<?= $r['id'] ?>" class="btn btn-edit">Editar</a>
                            <a href="rooms_crud.php?action=delete&id=<?= $r['id'] ?>" class="btn btn-delete"
                                onclick="return confirm('Tem certeza que deseja excluir este quarto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Nenhum quarto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php ob_end_flush(); // Finaliza o buffer 
?>