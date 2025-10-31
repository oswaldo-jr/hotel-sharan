<?php
require __DIR__ . '/../backend/conexao.php';
include 'layout_admin.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h1>Editar Reserva</h1>

<form method="POST" action="reservations_update.php">
    <input type="hidden" name="id" value="<?= $res['id'] ?? '' ?>">

    <label>Nome:</label><br>
    <input type="text" name="name" value="<?= $res['name'] ?? '' ?>" required><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" value="<?= $res['email'] ?? '' ?>" required><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="phone" value="<?= $res['phone'] ?? '' ?>"><br><br>

    <label>Entrada:</label><br>
    <input type="date" name="check_in" value="<?= $res['check_in'] ?? '' ?>" required><br><br>

    <label>Saída:</label><br>
    <input type="date" name="check_out" value="<?= $res['check_out'] ?? '' ?>" required><br><br>

    <label>Adultos:</label><br>
    <input type="number" name="adults" value="<?= $res['adults'] ?? 1 ?>"><br><br>

    <label>Crianças:</label><br>
    <input type="number" name="children" value="<?= $res['children'] ?? 0 ?>"><br><br>

    <button type="submit" class="btn btn-edit">Salvar Alterações</button>
    <a href="reservations_crud.php" class="btn btn-delete">Cancelar</a>
</form>

<?php include 'layout_admin.php'; ?>