<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

include 'layout_admin.php'; // inclui o cabeçalho e menu
?>

<h2>Bem-vindo ao Painel Administrativo do Hotel Sharan</h2>
<p>Gerencie facilmente seus quartos, reservas e assinantes da newsletter.</p>

<div style="margin-top: 40px;">
    <a href="rooms_crud.php" class="btn btn-green">Gerenciar Quartos</a>
    <a href="reservations_crud.php" class="btn btn-blue">Gerenciar Reservas</a>
</div>

<!-- Rodapé -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <div class="newsletter">
                <h3>NEWSLETTER</h3>
                <p>Assine para receber novidades do Hotel Sharan.</p>
                <form class="email" action="../backend/newsletter_submit.php" method="POST">
                    <input type="email" name="email" placeholder="Digite seu e-mail" required>
                    <button type="submit">ENVIAR</button>
                </form>
            </div>
            <div class="social-icons">
                <img src="../img/img.logo.png" alt="Logo" class="footer-logo" />
                <p>Obrigado por confiar no Hotel Sharan. Seu conforto é nossa prioridade.</p>
            </div>
        </div>
    </div>
</footer>

</main>
</body>

</html>