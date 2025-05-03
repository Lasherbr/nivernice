<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $mensagem = mysqli_real_escape_string($conn, $_POST["mensagem"]);
    $sql = "INSERT INTO recados (nome, mensagem) VALUES ('$nome', '$mensagem')";
    mysqli_query($conn, $sql);
}

$sql = "SELECT nome, mensagem, data_hora FROM recados ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
$recados = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recados[] = $row;
    }
}
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
    <img src="banner.png" class="top-banner" alt="Banner de 60 anos">
    <h1>Deixe seu recado carinhoso para a Nice!</h1>
    <form method="POST">
        <textarea name="mensagem" placeholder="Sua mensagem" required></textarea>
        <input type="text" name="nome" placeholder="Seu nome" required>
        <button type="submit">Enviar</button>
    </form>
    <div class="carrossel">
        <?php foreach ($recados as $i => $recado): ?>
            <div class="slide<?php echo $i === 0 ? ' active' : ''; ?>">
                <p class="msg">"<?php echo htmlspecialchars($recado['mensagem']); ?>"</p>
                <p class="autor">– <?php echo htmlspecialchars($recado['nome']); ?> (<?php echo $recado['data_hora']; ?>)</p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
