<?php
require_once "../db_config.php";

$user = null;
$error = null;
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: list.php");
    exit();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Fetch data BEFORE deleting to show it
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 2. Delete
        $deleteStmt = $conn->prepare("DELETE FROM Users WHERE Id = ?");
        $deleteStmt->execute([$id]);
    } else {
        $error = "Usuario no encontrado.";
    }

} catch (PDOException $e) {
    $error = "Error al eliminar: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario Eliminado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Registro Eliminado</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php elseif ($user): ?>
                    <div class="alert alert-success">
                        El siguiente usuario ha sido eliminado correctamente:
                    </div>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>ID:</strong> <?php echo htmlspecialchars($user['Id']); ?></li>
                        <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($user['Name']); ?>
                        </li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?>
                        </li>
                    </ul>
                <?php endif; ?>

                <div class="d-grid">
                    <a href="list.php" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>