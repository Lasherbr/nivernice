<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $mysqli->real_escape_string($_POST["nome"]);
    $mensagem = $mysqli->real_escape_string($_POST["mensagem"]);
    $mysqli->query("INSERT INTO recados (nome, mensagem) VALUES ('$nome', '$mensagem')");
}

$result = $mysqli->query("SELECT nome, mensagem, data_hora FROM recados ORDER BY id DESC LIMIT 10");
$recados = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Niver Nice 60 Anos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <img src="nivernice60.png" class="top-banner" alt="Banner">
    <h1>Deixe seu recado carinhoso para a Nice!</h1>
    <form method="POST">
        <textarea name="mensagem" placeholder="Sua mensagem" required></textarea>
        <input type="text" name="nome" placeholder="Seu nome" required>
        <button type="submit">Enviar</button>
    </form>
    <div class="carrossel">
        <?php foreach ($recados as $recado): ?>
            <div class="slide">
                <p class="msg">"<?php echo htmlspecialchars($recado['mensagem']); ?>"</p>
                <p class="autor">– <?php echo htmlspecialchars($recado['nome']); ?> (<?php echo $recado['data_hora']; ?>)</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
