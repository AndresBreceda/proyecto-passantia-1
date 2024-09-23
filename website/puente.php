<?php
session_start();
include('procesar.php');

$db = new Database();
$conn = $db->conn;


$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'listar');

switch ($action) {
    case 'create':  // Crear nueva tarea
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $actividad = htmlspecialchars(trim($_POST['actividad']));
            $inicio = htmlspecialchars(trim($_POST['inicio']));
            $final = htmlspecialchars(trim($_POST['final']));
            $importancia = htmlspecialchars(trim($_POST['importancia']));

            $tarea = new Tarea($conn);
            $resultado = $tarea->crearTarea($actividad, $inicio, $final, $importancia);
            echo $resultado ? "Tarea creada correctamente." : "Error al crear la tarea.";
        }
        break;

    case 'delete':  // Eliminar tarea
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $tarea = new Tarea($conn);
            echo $tarea->eliminarTarea($id);
        }
        break;

    case 'update':  // Actualizar tarea
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $actividad = htmlspecialchars(trim($_POST['actividad']));
            $inicio = htmlspecialchars(trim($_POST['inicio']));
            $final = htmlspecialchars(trim($_POST['final']));
            $importancia = htmlspecialchars(trim($_POST['importancia']));

            $tarea = new Tarea($conn);
            echo $tarea->actualizarTarea($id, $actividad, $inicio, $final, $importancia);
        }
        break;

    case 'get':  // Obtener datos de una tarea para editar
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $tarea = new Tarea($conn);
            echo json_encode($tarea->obtenerTarea($id));
        }
        break;

    case 'list':  // Listar todas las tareas
        $tarea = new Tarea($conn);
        $tareas = $tarea->listarTareas();
        $output = '';
        if (!empty($tareas)) {
            foreach ($tareas as $tarea) {
                $output .= '
                    <tr>
                        <td>' . htmlspecialchars($tarea['actividad']) . '</td>
                        <td>' . htmlspecialchars($tarea['inicio']) . '</td>
                        <td>' . htmlspecialchars($tarea['final']) . '</td>
                        <td>' . htmlspecialchars($tarea['importancia']) . '</td>
                        <td><button class="deleteTask btn btn-outline-danger" data-id="' . $tarea['id_tarea'] . '">Eliminar</button></td>
                        <td><button class="editTask btn btn-outline-primary" data-id="' . $tarea['id_tarea'] . '">Editar</button></td>
                    </tr>';
            }
        } else {
            $output = '<tr><td colspan="6">No hay tareas registradas.</td></tr>';
        }
        echo $output;
        exit();
        break;

    default:
        break;
}

$db->close();
?>
