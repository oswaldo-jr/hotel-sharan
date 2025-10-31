<?php
session_start();
session_unset();
session_destroy();

include 'layout.php'; // inclui cabeçalho e menu
?>

<h2>Sessão Encerrada</h2>
<p style="margin-top: 10px;">Você saiu com sucesso do painel administrativo do <strong>Hotel Sharan</strong>.</p>

<div style="margin-top: 30px;">
    <a href="admin_login.php" class="btn btn-blue">Fazer Login Novamente</a>
    <a href="../projeto.essentia/home-inicio.html" class="btn btn-green">Voltar ao Site</a>
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