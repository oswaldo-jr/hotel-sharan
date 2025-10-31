<?php
require __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método não permitido';
    exit;
}

// Recebendo os campos vindos do formulário (reserva.html)
$room        = trim($_POST['room'] ?? '');
$check_in    = $_POST['check_in'] ?? '';
$check_out   = $_POST['check_out'] ?? '';
$adults      = (int)($_POST['adults'] ?? 1);
$children    = (int)($_POST['children'] ?? 0);
$name        = trim($_POST['nome'] ?? ''); // corrigido para "nome"
$email       = trim($_POST['email'] ?? '');
$cpf         = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
$phone       = trim($_POST['telefone'] ?? ''); // corrigido para "telefone"

// ---------------------------
// Validações simples
// ---------------------------
$erros = [];
if (!$room) $erros[] = 'O campo quarto é obrigatório.';
if (!$check_in || !$check_out) $erros[] = 'As datas são obrigatórias.';
if (strtotime($check_in) >= strtotime($check_out)) $erros[] = 'A data de saída deve ser posterior à de entrada.';
if (!$name) $erros[] = 'O nome é obrigatório.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'E-mail inválido.';
if (!preg_match('/^[0-9]{11}$/', $cpf)) $erros[] = 'CPF deve ter 11 dígitos.';
// Validação de telefone mais flexível
if (!preg_match('/^[0-9\(\)\-\s]+$/', $phone)) $erros[] = 'Telefone inválido.';

if ($erros) {
    echo implode("<br>", $erros);
    exit;
}

// ---------------------------
// Inserção no banco
// ---------------------------
$sql = "INSERT INTO reservations 
        (name, email, room, check_in, check_out, phone, adults, children, cpf, created_at)
        VALUES (:name, :email, :room, :check_in, :check_out, :phone, :adults, :children, :cpf, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':room' => $room,
    ':check_in' => $check_in,
    ':check_out' => $check_out,
    ':phone' => $phone,
    ':adults' => $adults,
    ':children' => $children,
    ':cpf' => $cpf
]);

echo "✅ Reserva feita com sucesso!";