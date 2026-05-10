<?php
$conexio = mysqli_connect("localhost", "gamingzone", "@Gamingz0ne", "gamingzone");
if (!$conexio) {
    die("Error de conexion: " . mysqli_connect_error());
}

$sql = "SELECT COUNT(*) FROM partits";
$resultat = mysqli_query($conexio, $sql);
$fila = mysqli_fetch_row($resultat);
$totalPartits = $fila[0];

$sql = "SELECT COUNT(*) FROM partits WHERE estat = 'finalitzat'";
$resultat = mysqli_query($conexio, $sql);
$fila = mysqli_fetch_row($resultat);
$finalitzats = $fila[0];

$sql = "SELECT COUNT(*) FROM partits WHERE estat = 'pendent'";
$resultat = mysqli_query($conexio, $sql);
$fila = mysqli_fetch_row($resultat);
$pendents = $fila[0];

$sql = "SELECT COUNT(DISTINCT nick) FROM jugadors";
$resultat = mysqli_query($conexio, $sql);
$fila = mysqli_fetch_row($resultat);
$totalJugadors = $fila[0];

$sql = "SELECT data, hora, joc, jugador1, jugador2, fase FROM partits WHERE estat = 'pendent' ORDER BY data ASC, hora ASC LIMIT 1";
$resultat = mysqli_query($conexio, $sql);
$proper = mysqli_fetch_row($resultat);

include 'includes/header.html';
?>

<div class="hero-banner">
  <div class="date-badge">🎮 27 – 28 de Maig 2026 🎮</div>
  <h1>GAMING <span class="accent">ZONE</span><br>TOURNAMENT</h1>
  <p class="subtitle">El torneig de videojocs de la nostra xarxa local. Competeix, guanya i porta el teu equip a la glòria.</p>
  <a href="horaris.php" class="btn btn-primary">Veure Horaris</a>
  <a href="resultats.php" class="btn btn-outline">Resultats</a>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-value"><?php echo $totalPartits; ?></div>
    <div class="stat-label">Total Partits</div>
  </div>
  <div class="stat-card">
    <div class="stat-value"><?php echo $finalitzats; ?></div>
    <div class="stat-label">Finalitzats</div>
  </div>
  <div class="stat-card">
    <div class="stat-value"><?php echo $pendents; ?></div>
    <div class="stat-label">Pendents</div>
  </div>
  <div class="stat-card">
    <div class="stat-value"><?php echo $totalJugadors; ?></div>
    <div class="stat-label">Jugadors</div>
  </div>
</div>

<?php if ($proper) { ?>
<div class="card">
  <div class="section-title">Proper Partit</div>
  <div class="proper-partit-info">
    <p><strong><?php echo $proper[3]; ?></strong> vs <strong><?php echo $proper[4]; ?></strong></p>
    <p>Joc: <?php echo $proper[2]; ?> | Fase: <?php echo $proper[5]; ?></p>
    <p>Data: <?php echo $proper[0]; ?> | Hora: <?php echo $proper[1]; ?></p>
  </div>
</div>
<?php } ?>

<div class="card">
  <div class="section-title">Jocs del Torneig</div>
  <div class="games-grid">
    <div class="game-chip">Valorant</div>
    <div class="game-chip">Counter-Strike 2</div>
    <div class="game-chip">FIFA 25</div>
    <div class="game-chip">Rocket League</div>
    <div class="game-chip">Tekken 8</div>
  </div>
</div>

<?php
mysqli_close($conexio);
include 'includes/footer.html';
?>
