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
        self::$conexion = mysqli_connect('localhost', 'Maria', 'Chubaca2020', 'completo1');
        print "Conexión realizada de forma procedimental: " . mysqli_get_server_info($conexion) . "<br/>";

        if (mysqli_connect_errno($conexion)) {
            print "Fallo al conectar a MySQL: " . mysqli_connect_error();
            die();
        }
    }

    /**
     * Cierra conexión con la Base de datos
     */
    static function cerrarConexion() {
        mysqli_close(self::$conexion);
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
        $consulta = "SELECT * FROM usuarios WHERE DNI='" . $dni . "' AND "
                . "Pass = '" . $contra . "'";
        if ($resultado = mysqli_query(self::$conexion, $consulta)) {

            if ($fila = mysqli_fetch_array($resultado)) {
                $dni = $fila[0];
                $nombre = $fila[1];
                $tfno = $fila[2];
                $usuario = new Usuario($dni, $nombre, $tfno);
                $usuario = self::asignarRoles($usuario);
            }
        }
        return $usuario;
    }

    /**
     * Asigna los roles al usuario solicitado
     * @param type $usuario
     * @return type
     */
    static function asignarRoles($usuario) {
        $consulta = "SELECT * FROM roles, asignacionrol WHERE roles.IdRol = asignacionrol.IdRol and DNI='" . $usuario->getDni() . "'";
        if ($resultado = mysqli_query(self::$conexion, $consulta)) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $usuario->asignarRol($fila[1]);
            }
        }
        return $usuario;
    }

    /**
     * Registro de un nuevo usuario con dni, nombre, tfno y contraseña
     * @param type $dni
     * @param type $nombre
     * @param type $tfno
     * @param type $contra
     * @return boolean
     */
    static function insertUsuario($dni, $nombre, $tfno, $contra) {
        $consulta = "INSERT INTO usuarios VALUES ('" . $dni . "','" . $nombre . "','" . $tfno . "','" . $contra . "')";
        if (mysqli_query(self::$conexion, $consulta)) {
            $consulta = "INSERT INTO asignacionrol VALUES ('" . $dni . "','1')";
            if (mysqli_query(self::$conexion, $consulta)) {
                $correcto = true;
            }
        } else {
            $correcto = false;
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }

    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------

    /**
     * Devuelve todos los usuarios encontrados en la Base de datos.
     * @return type
     */
    static function getUsuarios() {
        $usuarios = Array();
        $consulta = "SELECT * FROM usuarios";

        if ($resultado = mysqli_query(self::$conexion, $consulta)) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $dni = $fila[0];
                $nombre = $fila[1];
                $tfno = $fila[2];
                $usuario = new Usuario($dni, $nombre, $tfno);
                $usuario = self::asignarRoles($usuario);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }

    /**
     * Actualiza el nombre y el telefono del usuario 
     * @param type $usuario
     * @return boolean
     */
    static function updateUsuario($usuario) {
        $correcto = false;
        $consulta = "UPDATE usuarios SET Nombre='" . $usuario->getNombre() . "', Tfno = '" . $usuario->getTfno() . "' WHERE DNI ='" . $usuario->getDni() . "'";
        if (mysqli_query(self::$conexion, $consulta)) {
            $correcto = true;
        } else {
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }

    /**
     * Establece a el usuario solicitado como administrador
     * @param type $usuario
     * @return boolean
     */
    static function hacerAdmin($usuario) {
        $correcto = false;
        $consulta = "INSERT INTO asignacionrol VALUES('" . $usuario->getDni() .
                "',2)";
        if (mysqli_query(self::$conexion, $consulta)) {
            $correcto = true;
        } else {
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }
    static function hacerAdminDNI($dni) {
        $correcto = false;
        $consulta = "INSERT INTO asignacionrol VALUES('" . $dni .
                "',2)";
        if (mysqli_query(self::$conexion, $consulta)) {
            $correcto = true;
        } else {
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }
    /**
     * El usuario solicitado deja de ser administrador
     * @param type $usuario
     * @return boolean
     */
    static function quitarAdmin($usuario) {
        $correcto = false;
        $consulta = "DELETE FROM asignacionrol WHERE DNI ='" . $usuario->getDni() .
                "' AND IdRol = 2";
        if (mysqli_query(self::$conexion, $consulta)) {
            $correcto = true;
        } else {
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }
    /**
     * Elimina el usuario solicitado
     * @param type $usuario
     * @return booleanE
     */
    static function deleteUsuario($usuario) {
        $correcto = false;
        $consulta = "DELETE FROM asignacionrol WHERE DNI ='" . $usuario->getDni() . "'";
        if (mysqli_query(self::$conexion, $consulta)) {
            $consulta = "DELETE FROM usuarios WHERE DNI='" . $usuario->getDni() . "'";
            if (mysqli_query(self::$conexion, $consulta)) {
                $correcto = true;
            }else{
                echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
            }
        } else {
            echo "Error al insertar: " . mysqli_error(self::$conexion) . '<br/>';
        }
        return $correcto;
    }

}
