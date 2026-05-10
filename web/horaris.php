<?php
$filtreJoc = '';
if (isset($_GET['joc'])) {
    $filtreJoc = $_GET['joc'];
}

$conexio = mysqli_connect("localhost", "gamingzone", "@Gamingz0ne", "gamingzone");
if (!$conexio) {
    die("Error de conexion: " . mysqli_connect_error());
}

include 'includes/header.html';
?>

<div class="page-hero">
  <div class="eyebrow">Programa oficial</div>
  <h1>Horaris</h1>
  <p>Consulta tots els partits programats, les fases i els enfrontaments del torneig.</p>
</div>

<div class="filter-bar">
  <?php
  $classeTots = '';
  if ($filtreJoc == '') {
      $classeTots = 'active';
  }
  echo '<a href="horaris.php" class="filter-btn ' . $classeTots . '">Tots</a>';

  $sql = "SELECT DISTINCT joc FROM partits ORDER BY joc";
  $resultat = mysqli_query($conexio, $sql);
  while ($fila = mysqli_fetch_row($resultat)) {
      $joc = $fila[0];
      $classe = '';
      if ($filtreJoc == $joc) {
          $classe = 'active';
      }
      echo '<a href="horaris.php?joc=' . $joc . '" class="filter-btn ' . $classe . '">' . $joc . '</a>';
  }
  ?>
</div>

<?php
$sql = "SELECT data, hora, joc, jugador1, jugador2, fase FROM partits WHERE estat = 'en_curs'";
if ($filtreJoc != '') {
    $sql = $sql . " AND joc = '" . $filtreJoc . "'";
}
$sql = $sql . " ORDER BY data ASC, hora ASC";
$resultat = mysqli_query($conexio, $sql);
$totalEnCurs = mysqli_num_rows($resultat);

if ($totalEnCurs > 0) {
    echo '<div class="card">';
    echo '<div class="section-title">En curs ara</div>';
    while ($p = mysqli_fetch_row($resultat)) {
        echo '<div class="partit-item">';
        echo '<p><strong>' . $p[1] . '</strong> - ' . $p[2] . '</p>';
        echo '<p>' . $p[3] . ' vs ' . $p[4] . '</p>';
        echo '<p>Fase: ' . $p[5] . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

$sql = "SELECT data, hora, joc, jugador1, jugador2, fase FROM partits WHERE estat = 'pendent'";
if ($filtreJoc != '') {
    $sql = $sql . " AND joc = '" . $filtreJoc . "'";
}
$sql = $sql . " ORDER BY data ASC, hora ASC";
$resultat = mysqli_query($conexio, $sql);
$totalPendents = mysqli_num_rows($resultat);

if ($totalPendents > 0) {
    $dataActual = '';
    while ($p = mysqli_fetch_row($resultat)) {
        if ($p[0] != $dataActual) {
            if ($dataActual != '') {
                echo '</div>';
            }
            echo '<div class="card">';
            echo '<div class="section-title">' . $p[0] . '</div>';
            $dataActual = $p[0];
        }
        echo '<div class="partit-item">';
        echo '<p><strong>' . $p[1] . '</strong> - ' . $p[2] . '</p>';
        echo '<p>' . $p[3] . ' vs ' . $p[4] . '</p>';
        echo '<p>Fase: ' . $p[5] . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

if ($totalEnCurs == 0 && $totalPendents == 0) {
    echo '<div class="card"><p>No hi ha partits programats per als filtres seleccionats.</p></div>';
}

mysqli_close($conexio);
include 'includes/footer.html';
?>
