<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de tareas</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header><h1> Administrador de tareas </h1></header>
    <div class="log">
        <h1>Entrar</h1><br>
        
            <div class="input_log">
            <form action="procesar.php" method="post">
            <label>Nombre:</label>
            <input type="text" name="nombre"><br>
            <label>Contraseña:</label>
            <input type="text" name="contraseña"><br>
            </div>
            <button type="submit" name="submit_login" class="btn btn-primary">Entrar</button>

        </form>
        <br><br>
        <a href="crear.php" class="btn btn-primary">Crear Cuenta</a>
    </div>
    <footer>
        <div class="footer-content">
            <ul class="socials">
                <li>Numero: 449 546 8686</li>
                <li>Corre: a.e.breceda@gmail.com</li>
                <li>Aguascalientes, Ags</li>
            </ul>
        </div>
        <div class="footer-bottom">
        <p> &copy; Diseñado por Andres</p>
        </div>
    </footer>
</body>
</html>