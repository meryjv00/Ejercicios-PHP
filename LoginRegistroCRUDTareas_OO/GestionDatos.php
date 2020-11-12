<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GestionDatos
 *
 * @author daw209
 */
require_once './Modelo/Usuario.php';
require_once './Modelo/Tarea.php';

class GestionDatos {

    static private $conexion;

    /**
     * Inicia conexión con la Base de datos
     */
    static function nuevaConexion() {
        self::$conexion = new mysqli('localhost', 'Maria', 'Chubaca2020', 'completo2');

        if (self::$conexion->connect_errno) {
            print "Fallo al conectar a MySQL: " . self::$conexion->connect_errno;
            die();
        }
    }

    /**
     * Cierra conexión con la Base de datos
     */
    static function cerrarConexion() {
        self::$conexion->close();
    }

    /**
     * Comprueba si existe un usuario con el dni y contraseña solicitados
     * En caso de que existe el usuario lo devuelve con los roles asignados,
     * en caso contrario devuelve null.
     * @param type $dni
     * @param type $contra
     * @return type 
     */
    static function getUsuario($dni, $contra) {
        self::nuevaConexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE DNI= ? AND Pass = ?");
        $stmt->bind_param("ss", $dni, $contra);
        $stmt->execute();
        $resultado = $stmt->get_result();
        var_dump($resultado);

        if ($fila = $resultado->fetch_assoc()) {
            var_dump($fila);
            $dni = $fila['DNI'];
            $correo = $fila['Correo'];
            $nombre = $fila['Nombre'];
            $tfno = $fila['Tfno'];
            $usuario = new Usuario($dni, $correo, $nombre, $tfno);
            $usuario = self::asignarRoles($usuario);
        }
        $stmt->close();
        return $usuario;
        self::cerrarConexion();
    }

    /**
     * Asigna los roles al usuario solicitado
     * @param type $usuario
     * @return type
     */
    static function asignarRoles($usuario) {
        $consulta = "SELECT * FROM roles, asignacionrol WHERE roles.IdRol = asignacionrol.IdRol and DNI='" . $usuario->getDni() . "'";
        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $usuario->asignarRol($fila['Descripcion']);
            }
        } else {
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $usuario;
    }

    static function isDni($dni) {
        self::nuevaConexion();
        $existe = false;
        $consulta = "SELECT * FROM usuarios WHERE DNI='" . $dni . "'";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $existe = true;
            }
        } else {
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $existe;
        self::cerrarConexion();
    }

    /**
     * Registro de un nuevo usuario con dni, nombre, tfno y contraseña
     * @param type $dni
     * @param type $nombre
     * @param type $tfno
     * @param type $contra
     * @return boolean
     */
    static function insertUsuario($dni, $correo, $nombre, $tfno, $contra) {
        self::nuevaConexion();
        $consulta = "INSERT INTO usuarios VALUES ('" . $dni . "','" . $correo . "','" . $nombre . "','" . $tfno . "','" . $contra . "')";
        if (self::$conexion->query($consulta)) {
            $consulta = "INSERT INTO asignacionrol VALUES ('" . $dni . "','1')";
            if (self::$conexion->query($consulta)) {
                $correcto = true;
            }
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------

    /**
     * Devuelve todos los usuarios encontrados en la Base de datos.
     * @return type
     */
    static function getUsuarios() {
        self::nuevaConexion();
        $usuarios = Array();
        $consulta = "SELECT * FROM usuarios";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $dni = $fila['DNI'];
                $correo = $fila['Correo'];
                $nombre = $fila['Nombre'];
                $tfno = $fila['Tfno'];
                $usuario = new Usuario($dni, $correo, $nombre, $tfno);
                $usuario = self::asignarRoles($usuario);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
        self::cerrarConexion();
    }

    /**
     * Actualiza el nombre y el telefono del usuario 
     * @param type $usuario
     * @return boolean
     */
    static function updateUsuario($usuario) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "UPDATE usuarios SET Nombre='" . $usuario->getNombre() . "', Tfno = '" . $usuario->getTfno() . "' WHERE DNI ='" . $usuario->getDni() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Establece a el usuario solicitado como administrador
     * @param type $usuario
     * @return boolean
     */
    static function hacerAdmin($usuario) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "INSERT INTO asignacionrol VALUES('" . $usuario->getDni() .
                "',2)";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al hacer admin: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    static function hacerAdminDNI($dni) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "INSERT INTO asignacionrol VALUES('" . $dni .
                "',2)";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al hacer admin: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * El usuario solicitado deja de ser administrador
     * @param type $usuario
     * @return boolean
     */
    static function quitarAdmin($usuario) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "DELETE FROM asignacionrol WHERE DNI ='" . $usuario->getDni() .
                "' AND IdRol = 2";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al quitar admin: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Elimina el usuario solicitado
     * @param type $usuario
     * @return booleanE
     */
    static function deleteUsuario($usuario) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "DELETE FROM asignacionrol WHERE DNI ='" . $usuario->getDni() . "'";
        if (self::$conexion->query($consulta)) {
            $consulta = "DELETE FROM usuarios WHERE DNI='" . $usuario->getDni() . "'";
            if (self::$conexion->query($consulta)) {
                $correcto = true;
            } else {
                echo "Error al borrar usuario: " . self::$conexion->error . '<br/>';
            }
        } else {
            echo "Error al borrar usuario: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Establece nueva contraseña al email solicitado
     * @param type $emailDestino
     * @param type $pass
     * @return type
     */
    static function setPassword($emailDestino, $pass) {
        $correcto = false;
        self::nuevaConexion();
        $consulta = "UPDATE usuarios SET Pass ='" . $pass . "' WHERE Correo='" . $emailDestino . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al establecer contraseña: " . self::$conexion->error . '<br/>';
        }
        return correcto;
        self::cerrarConexion();
    }

    /**
     * Crea nueva tarea
     * @param type $descripcion
     * @param type $dificultad
     * @return boolean
     */
    static function createTarea($descripcion, $dificultad) {
        $correcto = false;
        self::nuevaConexion();
        $consulta = "INSERT INTO tareas VALUES(DEFAULT,'" . $descripcion . "',0,'" . $dificultad . "')";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al hacer admin: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Obtiene todas las tareas
     * @return \Tarea
     */
    static function getTareas() {
        self::nuevaConexion();
        $tareas = Array();
        $consulta = "SELECT * FROM tareas";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['Id'];
                $descripcion = $fila['Descripcion'];
                $pdesarrollo = $fila['PorcDesarrollo'];
                $dificultad = $fila['Dificultad'];
                $tarea = new Tarea($id, $descripcion, $pdesarrollo, $dificultad);
                $tarea = self::asignarRealizadorTarea($tarea);
                $tareas[] = $tarea;
            }
        }
        return $tareas;
        self::cerrarConexion();
    }

    /**
     * Obtiene las tareas que no están completadas y aquellas en las que
     * todavía no has participado
     * @param type $dni
     * @return type
     */
    static function getTareasDispo($dni) {
        self::nuevaConexion();
        $tareas = Array();
        $consulta = "SELECT * FROM tareas WHERE PorcDesarrollo < 100 and Id not in "
                . "(select Id from asignaciontareas where DNI like '" . $dni . "')";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['Id'];
                $descripcion = $fila['Descripcion'];
                $pdesarrollo = $fila['PorcDesarrollo'];
                $dificultad = $fila['Dificultad'];
                $tarea = new Tarea($id, $descripcion, $pdesarrollo, $dificultad);
                $tarea = self::asignarRealizadorTarea($tarea);
                $tareas[] = $tarea;
            }
        }
        return $tareas;
        self::cerrarConexion();
    }

    /**
     * Asigna a la tarea los realizadores
     * @param type $tarea
     * @return type
     */
    static function asignarRealizadorTarea($tarea) {
        $consulta = "SELECT * FROM tareas, asignaciontareas WHERE tareas.Id = asignaciontareas.Id "
                . "and tareas.Id=" . $tarea->getId();
        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $tarea->asignarRealizador($fila['DNI']);
            }
        } else {
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $tarea;
    }

    /**
     * Actualiza descripcion,pdesarrollo y dificultad de una tarea
     * @param type $tarea
     * @return boolean
     */
    static function updateTarea($tarea) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "UPDATE tareas SET Descripcion='" . $tarea->getDescripcion() . "', PorcDesarrollo = " .
                $tarea->getPdesarrollo() . ", Dificultad='" . $tarea->getDificultad() .
                "' WHERE Id =" . $tarea->getId() . "";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Borra la tarea solicitada
     * @param type $tarea
     * @return boolean
     */
    static function deleteTarea($tarea) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "DELETE FROM tareas WHERE Id=" . $tarea->getId();
        if (self::$conexion->query($consulta)) {
            $consulta = "DELETE FROM asignaciontareas WHERE Id=" . $tarea->getId();
            if (self::$conexion->query($consulta)) {
                $correcto = true;
            }
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Obtiene las tareas de un usuario mediante su dni
     * @param type $dni
     * @return \Tarea
     */
    static function getMisTareas($dni) {
        self::nuevaConexion();
        $tareas = Array();
        $consulta = "SELECT * FROM tareas,asignaciontareas WHERE asignaciontareas.ID = "
                . "tareas.Id and asignaciontareas.DNI='" . $dni . "'";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila['Id'];
                $descripcion = $fila['Descripcion'];
                $pdesarrollo = $fila['PorcDesarrollo'];
                $dificultad = $fila['Dificultad'];
                $tarea = new Tarea($id, $descripcion, $pdesarrollo, $dificultad);
                $tareas[] = $tarea;
            }
        }
        return $tareas;
        self::cerrarConexion();
    }

    /**
     * Establece una tarea como terminada, es decir,
     * su porcentaje de desarrollo a 100
     * @param type $tarea
     * @return boolean
     */
    static function updateTerminada($tarea) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "UPDATE tareas SET PorcDesarrollo = 100  WHERE Id =" . $tarea->getId() . "";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Usuario decide dejar de realizar una tarea
     * @param type $tarea
     * @param type $yo
     * @return boolean
     */
    static function dejarTarea($tarea, $yo) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "DELETE FROM asignaciontareas WHERE DNI='" . $yo->getDni() . "' AND "
                . "Id=" . $tarea->getId();
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

    /**
     * Usuario elige tarea para realizar
     * @param type $tarea
     * @param type $usu
     */
    static function elegirTarea($tarea, $dni) {
        self::nuevaConexion();
        $correcto = false;
        $consulta = "INSERT INTO asignaciontareas VALUES(". $tarea->getId() . ",'" . $dni . "')";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        self::cerrarConexion();
    }

}
