<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $p_nombre = $_POST['p_nombre'];
    $p_cargo = $_POST['p_cargo'];
    $p_salario = $_POST['p_salario'];

    // Insertar en producto
    $sql = "INSERT INTO producto (nombre, precio) VALUES ('$nombre', '$precio')";
    $conn->query($sql);

    // Insertar en personal
    $sql = "INSERT INTO personal (nombre, cargo, salario) VALUES ('$p_nombre', '$p_cargo', '$p_salario')";
    $conn->query($sql);
}

// Consultar datos
$result_producto = $conn->query("SELECT * FROM producto");
$result_personal = $conn->query("SELECT * FROM personal");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tienda</title>
</head>
<body>
    <h2>Formulario de Inserción</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Producto</h3>
        Nombre: <input type="text" name="nombre"><br>
        Precio: <input type="number" step="0.01" name="precio"><br><br>

        <h3>Personal</h3>
        Nombre: <input type="text" name="p_nombre"><br>
        Cargo: <input type="text" name="p_cargo"><br>
        Salario: <input type="number" step="0.01" name="p_salario"><br><br>

        <input type="submit" value="Enviar">
    </form>

    <h2>Productos</h2>
    <?php
    if ($result_producto->num_rows > 0) {
        while($row = $result_producto->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nombre: " . $row["nombre"]. " - Precio: " . $row["precio"]. "<br>";
        }
    } else {
        echo "No hay productos.";
    }
    ?>

    <h2>Personal</h2>
    <?php
    if ($result_personal->num_rows > 0) {
        while($row = $result_personal->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nombre: " . $row["nombre"]. " - Cargo: " . $row["cargo"]. " - Salario: " . $row["salario"]. "<br>";
        }
    } else {
        echo "No hay personal.";
    }
    ?>
</body>
</html>

<?php
$conn->close();
?>