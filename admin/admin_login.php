<?php
session_start();
require __DIR__ . '/../backend/conexao.php';


// Se já estiver logado, redireciona
if (isset($_SESSION['admin'])) {
    header('Location: admin_dashboard.php');
    exit;
}

// Verifica login
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    $stmt = $pdo->prepare('SELECT * FROM admin WHERE usuario = ?');
    $stmt->execute([$usuario]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $senha === $admin['senha']) {
        $_SESSION['admin'] = $admin['usuario'];
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $erro = 'Usuário ou senha incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Hotel Sharan</title>
    <link rel="stylesheet" href="../projeto.essentia/styles.css">
    <style>
        body {
            background-color: #1a1a1a;
            font-family: 'Roboto', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #2c2c2c;
            padding: 40px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.6);
            width: 350px;
            text-align: center;
        }

        .login-box h2 {
            color: #c19b76;
            margin-bottom: 25px;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
            font-size: 14px;
        }

        .login-box input::placeholder {
            color: #bbb;
        }

        .login-box button {
            background-color: #c19b76;
            border: none;
            color: #fff;
            padding: 10px 0;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }

        .login-box button:hover {
            background-color: #b78b63;
        }

        .error {
            color: #ff4d4d;
            font-size: 13px;
            margin-top: 10px;
        }

        .voltar-site {
            display: block;
            margin-top: 15px;
            color: #bbb;
            text-decoration: none;
            font-size: 13px;
        }

        .voltar-site:hover {
            color: #c19b76;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Hotel Sharan</h2>
        <form method="post">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">ENTRAR</button>
            <?php if ($erro): ?>
                <p class="error"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>
        </form>
        <a class="voltar-site" href="../projeto.essentia/home-inicio.html">← Voltar ao site</a>
    </div>
</body>

</html>