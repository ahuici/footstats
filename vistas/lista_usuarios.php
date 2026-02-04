<?php
require_once __DIR__ . '/../modelos/modelo_users.php';

?>

<h2>Lista de Usuarios</h2>

<?php
if (mysqli_num_rows($allUsers) <= 0) {
    echo "No hay usuarios, añade alguno.";
} else {
    while ($fila = mysqli_fetch_array($allUsers)) {
        echo "<ul>
                <li><h2>".$fila['name']." ".$fila['surname']."</h2>
                <p>Edad: ".$fila['age']." | Género: ".$fila['gender']."</p>
                <p>Privilegio: ".$fila['privilege']."</p>
                </li>
              </ul>";
    }
}
?>

