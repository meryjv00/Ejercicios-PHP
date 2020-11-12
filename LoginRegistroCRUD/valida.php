<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './GestionDatos.php';
require_once './Usuario.php';
session_start();

//--INICIAR SESIÓN
if (isset($_REQUEST['Entrar'])) {
    $dni = $_REQUEST['usuario'];
    $contra = $_REQUEST['contra'];

    GestionDatos::nuevaConexion();
    $usuario = GestionDatos::getUsuario($dni, $contra);
    if (isset($usuario)) {
        $_SESSION['usuario'] = $usuario;
        //Admin
        if ($usuario->sizeRol() == 2) {
            //Obtenemos todos los usuarios
            $usuarios = GestionDatos::getUsuarios();
            $_SESSION['usuarios'] = $usuarios;
            header('Location: Vistas/ElegirAdmin.php');
            //Usuario estándar
        } else {
            header('Location: Vistas/Bienvenido.php');
        }
    } else {
        $_SESSION['mensaje'] = 'Usuario o contraseña incorrectos';
        header('Location: index.php');
    }
    GestionDatos::cerrarConexion();
}
//--REGISTRAR
if (isset($_REQUEST['Registrar'])) {
    GestionDatos::nuevaConexion();
    $dni = $_REQUEST['dni'];
    $nombre = $_REQUEST['nombre'];
    $tfno = $_REQUEST['tfno'];
    $contra = $_REQUEST['contra'];
    if (GestionDatos::insertUsuario($dni, $nombre, $tfno, $contra)) {
        header('Location: index.php');
    }
    GestionDatos::cerrarConexion();
}

//--CERRAR SESIÓN
if (isset($_REQUEST['CerrarSesion'])) {
    unset($SESSION['usuario']);
    header('Location: index.php');
}
//------------------------------------------------------------------------------
//----------------------------ADMINISTRADOR-------------------------------------
//------------------------------------------------------------------------------
//--ELEGIR ADMIN
//ENTRAR COMO ADMIN
if (isset($_REQUEST['EntrarAdmin'])) {
    header('Location: Vistas/CRUD.php');
}
//ENTRAR COMO USUARIO
if (isset($_REQUEST['EntrarUsu'])) {
    header('Location: Vistas/Bienvenido.php');
}

//--VOLVER ADMIN
if (isset($_REQUEST['VolverAdmin'])) {
    header('Location: Vistas/ElegirAdmin.php');
}

//--ADMINISTRADOR CRUD
//REDIRIGIR CREAR
if (isset($_REQUEST['CrearUsuario'])) {
    header('Location: Vistas/registroAdmin.php');
}
//CREAR USUARIO
if (isset($_REQUEST['RegistrarUsuario'])) {
    GestionDatos::nuevaConexion();
    $dni = $_REQUEST['dni'];
    $nombre = $_REQUEST['nombre'];
    $tfno = $_REQUEST['tfno'];
    $contra = $_REQUEST['contra'];
    $admin = $_REQUEST['admin'];
    if (GestionDatos::insertUsuario($dni, $nombre, $tfno, $contra)) {
        if (isset($admin)) {
            GestionDatos::hacerAdminDNI($dni);
        }
    }
    //Obtiene los usuarios para que al volver a la 
    //página los contenidos estén actualizados
    $usuarios = GestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
    GestionDatos::cerrarConexion();
    header('Location: Vistas/CRUD.php');
}
//EDITAR-ELIMINAR USUARIOS
if (isset($_SESSION['usuarios'])) {
    $usuarios = $_SESSION['usuarios'];
    $accion = "";
    $posElegida;
    for ($i = 0; $i < count($usuarios); $i++) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $posElegida = $i;
        }
    }
    //EDITAR USUARIO
    if ($accion == 'Editar') {
        $usuario = $usuarios[$posElegida];
        $nombres = $_REQUEST['nombre'];
        $tfnos = $_REQUEST['tfno'];

        $usuario->setNombre($nombres[$posElegida]);
        $usuario->setTfno($tfnos[$posElegida]);
        GestionDatos::nuevaConexion();
        if (GestionDatos::updateUsuario($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        GestionDatos::cerrarConexion();
    }
    //HACER ADMIN
    if ($accion == 'Hacer admin') {
        $usuario = $usuarios[$posElegida];
        GestionDatos::nuevaConexion();
        if (GestionDatos::hacerAdmin($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        GestionDatos::cerrarConexion();
    }
    //QUITAR ADMIN
    if ($accion == 'Quitar admin') {
        $usuario = $usuarios[$posElegida];
        GestionDatos::nuevaConexion();
        if (GestionDatos::quitarAdmin($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        GestionDatos::cerrarConexion();
    }
    //ELIMINAR USUARIO
    if ($accion == 'Eliminar') {
        $usuario = $usuarios[$posElegida];
        GestionDatos::nuevaConexion();
        if (GestionDatos::deleteUsuario($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        GestionDatos::cerrarConexion();
    }
}
