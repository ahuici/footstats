<?php
require_once __DIR__ . '/../modelos/modelo_users.php';

?>

<h2>Lista de Usuarios</h2>

<?php
if (mysqli_num_rows($allUsers) <= 0) {
    echo "No hay usuarios, añade alguno.";
} else {
    while ($fila = mysqli_fetch_array($allUsers)) {
echo '
<div class="col-md-4 mb-3">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">'.$fila['name'].' '.$fila['surname'].'</h5>
      <p class="card-text mb-1">
        Edad: '.$fila['age'].' | Género: '.$fila['gender'].'
      </p>
      <span class="badge bg-'.($fila['privilege'] == 0 ? 'danger' : 'secondary').'">
        Privilegio: '.$fila['privilege'].'
      </span>
    </div>
  </div>
</div>';

    }
}
?>

