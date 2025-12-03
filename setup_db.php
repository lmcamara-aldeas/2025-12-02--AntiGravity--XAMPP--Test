<?php
require_once "db_config.php";

try {
    // 1. Connect as root to create Database and User
    // We assume root has no password in default XAMPP
    $conn = new PDO("mysql:host=$servername", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create Database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    $conn->exec($sql);
    echo "<p style='color: green'>Base de datos <strong>$dbname</strong> verificada.</p>";

    // 3. Create User and Grant Permissions
    // We use the variables from db_config.php for the new user
    $sqlUser = "CREATE USER IF NOT EXISTS '$username'@'localhost' IDENTIFIED BY '$password'";
    $conn->exec($sqlUser);

    // Ensure password is correct if user already existed
    $sqlAlter = "ALTER USER '$username'@'localhost' IDENTIFIED BY '$password'";
    $conn->exec($sqlAlter);
    echo "<p style='color: green'>Usuario <strong>$username</strong> verificado.</p>";

    $sqlGrant = "GRANT ALL PRIVILEGES ON $dbname.* TO '$username'@'localhost'";
    $conn->exec($sqlGrant);
    $conn->exec("FLUSH PRIVILEGES");
    echo "<p style='color: green'>Permisos asignados correctamente.</p>";

    // 4. Create Table Users
    // Switch to the created database
    $conn->exec("USE $dbname");

    $sqlTable = "CREATE TABLE IF NOT EXISTS Users (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(255) NOT NULL,
        Email VARCHAR(255) NOT NULL
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

    $conn->exec($sqlTable);
    echo "<p style='color: green'>Tabla <strong>Users</strong> verificada.</p>";

    // 5. Import Data from CSV
    $csvFile = __DIR__ . '/datos/Users.csv';
    if (file_exists($csvFile)) {
        // Truncate table to avoid duplicates on re-run
        $conn->exec("TRUNCATE TABLE Users");

        $stmt = $conn->prepare("INSERT INTO Users (Name, Email) VALUES (?, ?)");
        $handle = fopen($csvFile, "r");
        $count = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip empty lines or invalid rows
            if (count($data) >= 2) {
                $stmt->execute([$data[0], $data[1]]);
                $count++;
            }
        }
        fclose($handle);
        echo "<p style='color: green'>Se han importado <strong>$count</strong> usuarios desde <code>datos/Users.csv</code>.</p>";
    } else {
        echo "<p style='color: orange'>Aviso: No se encontró el archivo <code>datos/Users.csv</code> para importar.</p>";
    }

    echo "<h1>Configuración Completa</h1>";
    echo "<p>Todo listo. <a href='db_test.php'>Probar conexión</a></p>";

} catch (PDOException $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color: red'>" . $e->getMessage() . "</p>";
}

$conn = null;
?>