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
require_once './Usuario.php';

class GestionDatos {

    static private $conexion;

    /**
     * Inicia conexión con la Base de datos
     */
    static function nuevaConexion() {
        self::$conexion = new mysqli('localhost', 'Maria', 'Chubaca2020', 'completo1');

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

}
