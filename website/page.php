<?php
include("puente.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de <?php echo $_SESSION["nombre"] ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function () {
        loadTasks();

        // Crear o actualizar tareas con AJAX
        $('#createTaskForm').on('submit', function (e) {
            e.preventDefault();

            var action = $(this).attr('data-action') === 'update' ? 'update' : 'create';
            var id = $(this).attr('data-id') || '';

            $.ajax({
                type: 'POST',
                url: 'puente.php',
                data: $(this).serialize() + '&action=' + action + (id ? '&id=' + id : ''),
                success: function (response) {
                    alert('Tarea ' + (action === 'update' ? 'actualizada' : 'agregada') + ' correctamente');
                    loadTasks();
                    $('#createTaskForm')[0].reset();
                    $('#createTaskForm').removeAttr('data-action data-id'); // Restablecer formulario
                },
                error: function () {
                    alert('Error al ' + (action === 'update' ? 'actualizar' : 'agregar') + ' la tarea.');
                }
            });
        });

        // Editar tarea 
        $('body').on('click', '.editTask', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'GET',
                url: 'puente.php',
                data: { id: id, action: 'get' },
                success: function (response) {
                    var task = JSON.parse(response);
                    $('#createTaskForm [name="actividad"]').val(task.actividad);
                    $('#createTaskForm [name="inicio"]').val(task.inicio);
                    $('#createTaskForm [name="final"]').val(task.final);
                    $('#createTaskForm [name="importancia"][value="' + task.importancia + '"]').prop('checked', true);
                    $('#createTaskForm').attr('data-id', task.id_tarea).attr('data-action', 'update');
                },
                error: function () {
                    alert('Error al cargar la tarea para editar.');
                }
            });
        });

        // Eliminar tarea
        $('body').on('click', '.deleteTask', function () {
            var id = $(this).data('id');
            if (confirm("¿Estás seguro de que deseas eliminar esta tarea?")) {
                $.ajax({
                    type: 'POST',
                    url: 'puente.php',
                    data: { id: id, action: 'delete' }, // Agregamos 'action': 'delete' aquí
                    success: function (response) {
                        alert('Tarea eliminada correctamente');
                        loadTasks();
                    },
                    error: function () {
                        alert('Error al eliminar la tarea.');
                    }
                });
            }
        });

        function loadTasks() {
            $.ajax({
                url: 'puente.php',
                type: 'GET',
                data: { action: 'list' },
                success: function (response) {
                    $('#taskTable tbody').html(response);
                },
                error: function () {
                    alert('Error al cargar las tareas.');
                }
            });
        }
    });

    </script>
</head>
<body>

    <header>
        <h1>Administrador de tareas</h1>
    </header>

    <div class="border border-5 border-primary ">
        <div class="tarea">
            <h2>Crear Actividad</h2><br>
            <form id="createTaskForm">
                <label for="respuesta">Nombre de la actividad:</label>
                <input id="respuesta" type="text" name="actividad"><br><br>
                <label>Fecha de inicio:</label>
                <input type="date" name="inicio"><br>
                <label>Fecha de fin:</label>
                <input type="date" name="final"><br><br>
                <label>Nivel de importancia</label>
                <h5>Baja</h5>
                <input type="radio" name="importancia" value="Baja" checked>
                <h5>Media</h5>
                <input type="radio" name="importancia" value="Media">
                <h5>Alta</h5>
                <input type="radio" name="importancia" value="Alta">
                <br><br>
                <button type="submit" class="btn btn-outline-success">Agregar Actividad</button>
            </form>
            <br>
            <a class="btn btn-outline-info" href="index.php">volver</a>
        </div>
    </div>

    <div class="border border-5 border-success">
        <div class="tabla">
            <h2>Tareas Registradas</h2>
            <table border="1" class="tabla2" id="taskTable">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Importancia</th>
                        <th>Eliminar</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las tareas se cargarán aquí mediante AJAX -->
                </tbody>
            </table>
        </div>
    </div>


    <footer>
        <div class="footer-content">
            <h3>Administrador</h3>
            <ul class="socials">
                <li>Numero: 449 546 8686</li>
                <li>Correo: a.e.breceda@gmail.com</li>
                <li>Aguascalientes, Ags</li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p> &copy; Diseñado por Andres</p>
        </div>
    </footer>

</body>
</html>
