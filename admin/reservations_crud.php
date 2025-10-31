<?php
require __DIR__ . '/../backend/conexao.php';
include 'layout_admin.php';

// Define ação (listar, adicionar ou editar)
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;


// SALVAR NOVO OU EDIÇÃO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name      = $_POST['name'];
  $email     = $_POST['email'];
  $room      = $_POST['room'];
  $check_in  = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $phone     = $_POST['phone'];
  $adults    = $_POST['adults'];
  $children  = $_POST['children'];

  if (!empty($_POST['id'])) {
    // Atualiza reserva existente
    $stmt = $pdo->prepare("UPDATE reservations 
                               SET name=?, email=?, room=?, check_in=?, check_out=?, phone=?, adults=?, children=? 
                               WHERE id=?");
    $stmt->execute([$name, $email, $room, $check_in, $check_out, $phone, $adults, $children, $_POST['id']]);
  } else {
    // Insere nova reserva
    $stmt = $pdo->prepare("INSERT INTO reservations 
                               (name, email, room, check_in, check_out, phone, adults, children, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $room, $check_in, $check_out, $phone, $adults, $children]);
  }

  echo "<script>alert('Reserva salva com sucesso!'); window.location='reservations_crud.php';</script>";
  exit;
}

// ---------------------
// EXCLUIR RESERVA
// ---------------------
if ($action === 'delete' && $id) {
  $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
  $stmt->execute([$id]);
  echo "<script>alert('Reserva excluída com sucesso!'); window.location='reservations_crud.php';</script>";
  exit;
}

// ---------------------
// EDITAR OU ADICIONAR FORMULÁRIO
// ---------------------
if ($action === 'add' || ($action === 'edit' && $id)) {
  $reserva = [
    'name' => '',
    'email' => '',
    'room' => '',
    'check_in' => '',
    'check_out' => '',
    'phone' => '',
    'adults' => 1,
    'children' => 0
  ];

  if ($action === 'edit') {
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
  }
?>
<h2><?= $action === 'edit' ? 'Editar Reserva' : 'Adicionar Nova Reserva' ?></h2>

<form method="POST" class="form-container">
    <?php if ($action === 'edit'): ?>
    <input type="hidden" name="id" value="<?= htmlspecialchars($reserva['id']) ?>">
    <?php endif; ?>

    <label>Nome:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($reserva['name']) ?>" required><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($reserva['email']) ?>" required><br><br>

    <label>Quarto:</label><br>
    <input type="text" name="room" value="<?= htmlspecialchars($reserva['room']) ?>" required><br><br>

    <label>Data de Entrada:</label><br>
    <input type="date" name="check_in" value="<?= htmlspecialchars($reserva['check_in']) ?>" required><br><br>

    <label>Data de Saída:</label><br>
    <input type="date" name="check_out" value="<?= htmlspecialchars($reserva['check_out']) ?>" required><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($reserva['phone']) ?>"><br><br>

    <label>Adultos:</label><br>
    <input type="number" name="adults" value="<?= htmlspecialchars($reserva['adults']) ?>" min="1" required><br><br>

    <label>Crianças:</label><br>
    <input type="number" name="children" value="<?= htmlspecialchars($reserva['children']) ?>" min="0"><br><br>

    <button type="submit" class="btn btn-edit">Salvar</button>
    <a href="reservations_crud.php" class="btn btn-delete">Cancelar</a>
</form>
<?php
  include 'layout_admin.php';
  exit;
}

// ---------------------
// LISTAR RESERVAS
// ---------------------
$stmt = $pdo->query("SELECT * FROM reservations ORDER BY id DESC");
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gerenciar Reservas</h2>
<a href="reservations_crud.php?action=add" class="btn-add">+ Nova Reserva</a>

<div class="table-container">
    <h3>Lista de Reservas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Quarto</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Telefone</th>
                <th>Data de Cadastro</th>
                <th>Adultos</th>
                <th>Crianças</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reservas) > 0): ?>
            <?php foreach ($reservas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['id']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['room']) ?></td>
                <td><?= htmlspecialchars($r['check_in']) ?></td>
                <td><?= htmlspecialchars($r['check_out']) ?></td>
                <td><?= htmlspecialchars($r['phone']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                <td><?= htmlspecialchars($r['adults']) ?></td>
                <td><?= htmlspecialchars($r['children']) ?></td>
                <td>
                    <a href="reservations_crud.php?action=edit&id=<?= $r['id'] ?>" class="btn btn-edit">Editar</a>
                    <a href="reservations_crud.php?action=delete&id=<?= $r['id'] ?>" class="btn btn-delete"
                        onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="11" style="text-align:center;">Nenhuma reserva cadastrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'layout_admin.php'; ?>