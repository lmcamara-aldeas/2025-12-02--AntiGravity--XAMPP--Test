<?php
require_once "db_config.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $status = "Conexión Segura Exitosa";
    $message = "Usuario <strong>$username</strong> conectado a base de datos <strong>$dbname</strong><br>";
    $message .= "PHP " . phpversion() . " | MariaDB " . $conn->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";

    // Check for Users table
    $stmt = $conn->query("SHOW TABLES LIKE 'Users'");
    $tableExists = $stmt->rowCount() > 0 ? "Sí" : "No";
    $message .= "Tabla 'Users' existe: <strong>$tableExists</strong>";

    $color = "green";
} catch (PDOException $e) {
    $status = "Error de conexión";
    $message = $e->getMessage();
    $color = "red";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Prueba de Base de Datos Segura</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            border: 1px solid #ddd;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color:
                <?php echo $color; ?>
            ;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1><?php echo $status; ?></h1>
        <p><?php echo $message; ?></p>
        <p><a href="index.php">Volver al inicio</a></p>
    </div>
</body>

</html>