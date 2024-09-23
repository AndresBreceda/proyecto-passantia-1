<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db   = 'administrador';
    public $conn = "";

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function close() {
        mysqli_close($this->conn);
    }
}

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($nombre, $contraseña) {
        $sql = "SELECT nombre, contraseña FROM usuarios WHERE nombre = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $nombre);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $db_nombre, $db_contraseña);
                mysqli_stmt_fetch($stmt);
                if ($contraseña === $db_contraseña) {
                    $_SESSION['nombre'] = $nombre;
                    header("Location: page.php");
                    exit();
                } else {
                    return "Contraseña incorrecta.";
                }
            } else {
                return "Usuario no encontrado.";
            }
            mysqli_stmt_close($stmt);
        } else {
            return "Error en la consulta.";
        }
    }

    public function crearUsuario($nombre, $contraseña) {
        $sql = "INSERT INTO usuarios (nombre, contraseña) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ss', $nombre, $contraseña);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return "Usuario creado exitosamente.";
        } else {
            return "Error al crear el usuario.";
        }
    }
}

class Tarea {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function crearTarea($actividad, $inicio, $final, $importancia) {
        $sql = "INSERT INTO tareas (actividad, inicio, final, importancia) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssss', $actividad, $inicio, $final, $importancia);
            if (mysqli_stmt_execute($stmt)) {
                return "Tarea creada exitosamente.";
            } else {
                return "Error al crear la tarea.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    public function eliminarTarea($id) {
        $sql = "DELETE FROM tareas WHERE id_tarea = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                return "Tarea eliminada.";
            } else {
                return "Error al eliminar la tarea.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    public function actualizarTarea($id, $actividad, $inicio, $final, $importancia) {
        $sql = "UPDATE tareas SET actividad = ?, inicio = ?, final = ?, importancia = ? WHERE id_tarea = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssi', $actividad, $inicio, $final, $importancia, $id);
            if (mysqli_stmt_execute($stmt)) {
                return "Tarea actualizada.";
            } else {
                return "Error al actualizar la tarea.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    public function obtenerTarea($id) {
        $sql = "SELECT * FROM tareas WHERE id_tarea = ?";
        if ($stmt = mysqli_prepare($this->conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $tarea = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $tarea;
        }
    }

    public function listarTareas() {
        $sql = "SELECT * FROM tareas ORDER BY inicio ASC LIMIT 100";
        $result = mysqli_query($this->conn, $sql);
        $tareas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tareas[] = $row;
        }
        return $tareas;
    }
}

?>
