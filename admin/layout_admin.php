<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Protege o painel (exceto login)
$paginaAtual = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['admin']) && $paginaAtual !== 'admin_login.php') {
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel Administrativo - Hotel Sharan</title>

    <!-- CSS do site principal -->
    <link rel="stylesheet" href="../front-end/front/styles.css">


    <!-- Fontes e Ícones -->
    <link href=" https://fonts.googleapis.com/css2?family=DM+Serif+Text&family=Roboto:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Ajustes extras apenas para o painel */
        body {
            background: #fdfdfd;
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
        }

        main {
            padding: 150px 40px 60px;
            min-height: 70vh;
        }

        /* Header fixo */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 85%;
            margin: 0 auto;
            padding: 18px 0;
        }

        .header .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
            color: #fff;
            margin: 0;
        }

        .header .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .header .nav-links a:hover {
            color: #c19b76;
        }

        .img-logo img {
            height: 46px;
        }

        /* Conteúdo principal */
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Tabelas */
        .table-container {
            margin: 20px 0;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        tr:hover {
            background: #f1f1f1;
        }

        /* Botões */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            color: #1a1a1a;
            text-decoration: none;
            cursor: pointer;
            font-size: 20px;
        }

        .btn-edit {
            background: #007bff;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-add {
            background: #28a745;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Rodapé igual ao front */
        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 60px 0 40px 0;
        }

        .icons a {
            color: #c19b76;
            font-size: 20px;
            text-decoration: none;
            margin-right: 10px;
            transition: transform 0.2s;
        }

        .icons a:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <header class="header">
        <div class="container">
            <div class="img-logo">
                <img src="../front-end/img/img.logo.png" alt="Logo Hotel Sharan">
            </div>
            <ul class="nav-links">
                <li><a href="/projeto.essentia/admin/admin_dashboard.php">Início</a></li>
                <li><a href="/projeto.essentia/admin/rooms_crud.php">Quartos</a></li>
                <li><a href="/projeto.essentia/admin/reservations_crud.php">Reservas</a></li>
                <li><a href="/projeto.essentia/admin/admin_logout.php" style="color:#c19b76;">Sair</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="admin-container">