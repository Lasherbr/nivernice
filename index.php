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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="text-center">
        <img src="banner.png" class="img-fluid mb-3" alt="Banner de 60 anos" style="max-width: 320px;">
        <h1 class="text-orange">Deixe seu recado carinhoso para a Nice!</h1>

        <!-- Música -->
        <audio id="bg-music" src="musica.mp3" loop preload="auto"></audio>
        <button class="btn btn-orange my-3" onclick="toggleMusic()">Tocar música 🎵</button>
    </div>

    <!-- Carrossel responsivo -->
    <div id="recadoCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($recados as $i => $recado): ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <div class="slide-content">
                        <p class="msg">"<?php echo nl2br(htmlspecialchars($recado['mensagem'])); ?>"</p>
                        <p class="autor">– <?php echo htmlspecialchars($recado['nome']); ?> (<?php echo $recado['data_hora']; ?>)</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Formulário responsivo -->
    <form method="POST" class="bg-light p-4 rounded border border-orange">
        <div class="mb-3">
            <textarea name="mensagem" placeholder="Sua mensagem" required class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <input type="text" name="nome" placeholder="Seu nome" required class="form-control">
        </div>
        <button type="submit" class="btn btn-orange w-100">Enviar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleMusic() {
    const audio = document.getElementById('bg-music');
    if (audio.paused) {
        audio.play();
    } else {
        audio.pause();
    }
}
</script>
</body>
</html>
