<?php
$filtreFase = '';
if (isset($_GET['fase'])) {
    $filtreFase = $_GET['fase'];
}

$conexio = mysqli_connect("localhost", "gamingzone", "@Gamingz0ne", "gamingzone");
if (!$conexio) {
    die("Error de conexion: " . mysqli_connect_error());
}

include 'includes/header.html';
?>

<div class="page-hero">
  <div class="eyebrow">Classificacio final</div>
  <h1>Resultats</h1>
  <p>Tots els resultats dels partits ja disputats, amb guanyador i marcador.</p>
</div>

<div class="filter-bar">
  <?php
  $classeTots = '';
  if ($filtreFase == '') {
      $classeTots = 'active';
  }
  echo '<a href="resultats.php" class="filter-btn ' . $classeTots . '">Totes les fases</a>';

  $sql = "SELECT DISTINCT fase FROM partits WHERE estat = 'finalitzat' ORDER BY fase";
  $resultat = mysqli_query($conexio, $sql);
  while ($fila = mysqli_fetch_row($resultat)) {
      $fase = $fila[0];
      $classe = '';
      if ($filtreFase == $fase) {
          $classe = 'active';
      }
      echo '<a href="resultats.php?fase=' . $fase . '" class="filter-btn ' . $classe . '">' . $fase . '</a>';
  }
  ?>
</div>

<?php
$sql = "SELECT data, hora, joc, jugador1, jugador2, fase, guanyador, marcador FROM partits WHERE estat = 'finalitzat' AND resultat IS NOT NULL";
if ($filtreFase != '') {
    $sql = $sql . " AND fase = '" . $filtreFase . "'";
}
$sql = $sql . " ORDER BY data DESC, hora DESC";
$resultat = mysqli_query($conexio, $sql);
$totalRes = mysqli_num_rows($resultat);

if ($totalRes == 0) {
    echo '<div class="card"><p>Encara no hi ha resultats registrats.</p></div>';
} else {
    echo '<div class="card">';
    echo '<div class="section-title">Partits Finalitzats</div>';
    while ($r = mysqli_fetch_row($resultat)) {
        echo '<div class="resultat-item">';
        echo '<p><strong>' . $r[0] . '</strong> - ' . $r[2] . ' - Fase: ' . $r[5] . '</p>';
        echo '<p>' . $r[3] . ' vs ' . $r[4] . '</p>';
        echo '<p>Guanyador: ' . $r[6] . ' | Marcador: ' . $r[7] . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

$sql = "SELECT guanyador, COUNT(*) FROM partits WHERE estat = 'finalitzat' AND guanyador IS NOT NULL GROUP BY guanyador ORDER BY COUNT(*) DESC LIMIT 10";
$resultat = mysqli_query($conexio, $sql);
$totalRank = mysqli_num_rows($resultat);

if ($totalRank > 0) {
    echo '<div class="card">';
    echo '<div class="section-title">Ranquing</div>';
    $posicio = 1;
    while ($jug = mysqli_fetch_row($resultat)) {
        $medalla = $posicio . '.';
        echo '<div class="ranking-item"><p>' . $medalla . ' ' . $jug[0] . ' - ' . $jug[1] . ' victories</p></div>';
        $posicio++;
    }
    echo '</div>';
}

mysqli_close($conexio);
include 'includes/footer.html';
?>
