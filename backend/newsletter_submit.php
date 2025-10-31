<?php
require __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método não permitido';
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo 'E-mail inválido!';
    exit;
}

// Evita e-mails duplicados simples 
$pdo->prepare('INSERT INTO newsletter (email) VALUES (?)')->execute([$email]);
echo 'Inscrição realizada com sucesso!';
