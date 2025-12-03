<?php
require_once "../db_config.php";

$users = [];
$error = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM Users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .table-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 30px;
            color: #343a40;
        }

        .filter-row input,
        .filter-row select {
            font-size: 0.875rem;
        }

        /* Ensure dropdowns are visible */
        .table-responsive {
            overflow: visible;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Usuarios Registrados</h1>
                <div>
                    <a href="create.php" class="btn btn-success me-2">Crear Nuevo</a>
                    <a href="../index.php" class="btn btn-outline-secondary">Volver al Inicio</a>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php else: ?>

                <!-- Filters Section -->
                <div class="card mb-3">
                    <div class="card-header">Filtros Avanzados</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- ID Filter -->
                            <div class="col-md-4">
                                <label class="form-label">ID</label>
                                <div class="input-group">
                                    <select class="form-select filter-operator" data-col="0">
                                        <option value="contains">Contiene</option>
                                        <option value="exact">Igual a</option>
                                        <option value="starts">Empieza por</option>
                                    </select>
                                    <input type="text" class="form-control filter-input" data-col="0"
                                        placeholder="Buscar ID...">
                                </div>
                            </div>
                            <!-- Name Filter -->
                            <div class="col-md-4">
                                <label class="form-label">Nombre</label>
                                <div class="input-group">
                                    <select class="form-select filter-operator" data-col="1">
                                        <option value="contains">Contiene</option>
                                        <option value="exact">Igual a</option>
                                        <option value="starts">Empieza por</option>
                                    </select>
                                    <input type="text" class="form-control filter-input" data-col="1"
                                        placeholder="Buscar Nombre...">
                                </div>
                            </div>
                            <!-- Email Filter -->
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <select class="form-select filter-operator" data-col="2">
                                        <option value="contains">Contiene</option>
                                        <option value="exact">Igual a</option>
                                        <option value="starts">Empieza por</option>
                                    </select>
                                    <input type="text" class="form-control filter-input" data-col="2"
                                        placeholder="Buscar Email...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover table-striped align-middle" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['Id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opciones
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="update.php?id=<?php echo $user['Id']; ?>">Modificar</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item text-danger"
                                                            href="delete.php?id=<?php echo $user['Id']; ?>"
                                                            onclick="return confirm('¿Quieres realmente eliminar el dato seleccionado?');">Eliminar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#usersTable').DataTable({
                dom: 'Blfrtip', // B=Buttons, l=Length, f=Filter, r=Processing, t=Table, i=Info, p=Pagination
                lengthMenu: [10, 20, 50, 100],
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'Ocultar/Mostrar Columnas',
                        className: 'btn btn-outline-primary mb-3'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                columnDefs: [
                    { orderable: false, targets: 3 } // Disable sorting on Actions column
                ]
            });

            // Custom Filtering Logic
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var isValid = true;

                    // Loop through each filter input
                    $('.filter-input').each(function () {
                        var colIdx = $(this).data('col');
                        var searchTerm = $(this).val().toLowerCase();
                        var operator = $('.filter-operator[data-col="' + colIdx + '"]').val();
                        var cellValue = data[colIdx].toLowerCase();

                        if (searchTerm) {
                            if (operator === 'exact') {
                                if (cellValue !== searchTerm) isValid = false;
                            } else if (operator === 'starts') {
                                if (!cellValue.startsWith(searchTerm)) isValid = false;
                            } else { // contains
                                if (!cellValue.includes(searchTerm)) isValid = false;
                            }
                        }
                    });

                    return isValid;
                }
            );

            // Event listener for inputs and selects to redraw table
            $('.filter-input, .filter-operator').on('keyup change', function () {
                table.draw();
            });
        });
    </script>
</body>

</html>