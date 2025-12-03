<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AntiGravity XAMPP Test</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            line-height: 1.6;
        }

        h1 {
            color: #2c3e50;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .info {
            background: #f0f0f0;
            padding: 1rem;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1>¡Hola! Tu entorno XAMPP está funcionando.</h1>

    <div class="info">
        <p><strong>Directorio del proyecto:</strong> <?php echo __DIR__; ?></p>
        <p><strong>Versión de PHP:</strong> <?php echo phpversion(); ?></p>
        <p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>

        <p>Si ves esta página en <a href="http://antigravity.local">http://antigravity.local</a>,
            el Virtual Host está correctamente configurado.</p>

        <h2>Siguientes pasos:</h2>
        <ul>
            <li><a href="db_test.php">Probar conexión a Base de Datos</a></li>
            <li><a href="users/list.php">Listar Usuarios</a></li>
        </ul>
</body>

</html>