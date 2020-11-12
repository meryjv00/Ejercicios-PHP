<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './GestionDatos.php';
require_once './Modelo/Usuario.php';
session_start();

//--INICIAR SESIÓN
if (isset($_REQUEST['Entrar'])) {
    $dni = $_REQUEST['usuario'];
    $contra = $_REQUEST['contra'];

    $usuario = GestionDatos::getUsuario($dni, $contra);
    if (isset($usuario)) {
        $_SESSION['usuario'] = $usuario;
        //Admin
        if ($usuario->sizeRol() == 2) {
            header('Location: Vistas/ElegirAdmin.php');
            //Usuario estándar
        } else {
            header('Location: Vistas/Bienvenido.php');
        }
    } else {
        $_SESSION['mensaje'] = 'Usuario o contraseña incorrectos';
        header('Location: index.php');
    }
}
//--REGISTRAR
if (isset($_REQUEST['Registrar'])) {
    $dni = $_REQUEST['dni'];
    $correo = $_REQUEST['correo'];
    $nombre = $_REQUEST['nombre'];
    $tfno = $_REQUEST['tfno'];
    $contra = $_REQUEST['contra'];
    if (!GestionDatos::isDni($dni)) {
        if (GestionDatos::insertUsuario($dni, $correo, $nombre, $tfno, $contra)) {
            header('Location: index.php');
        } else {
            $_SESSION['mensaje2'] = 'No se ha podido llevar a cabo el registro';
            header('Location: Vistas/registro.php');
        }
    } else {
        $_SESSION['mensaje2'] = 'El dni introducido ya está registrado';
        header('Location: Vistas/registro.php');
    }
}

//--CERRAR SESIÓN
if (isset($_REQUEST['CerrarSesion'])) {
    unset($SESSION['usuario']);
    header('Location: index.php');
}
//--IR PÁGINA BIENVENIDA USUARIO
if (isset($_REQUEST['Bienvenido'])) {
    header('Location: Vistas/Bienvenido.php');
}
//------------------------------------------------------------------------------
//----------------------------ADMINISTRADOR-------------------------------------
//------------------------------------------------------------------------------
//--ELEGIR ADMIN
//ENTRAR COMO ADMIN
if (isset($_REQUEST['EntrarAdmin'])) {
    header('Location: Vistas/elegirOpcion.php');
}

if (isset($_REQUEST['EntrarCRUD'])) {
    //Obtenemos todos los usuarios
    $usuarios = GestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
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
    $dni = $_REQUEST['dni'];
    $correo = $_REQUEST['correo'];
    $nombre = $_REQUEST['nombre'];
    $tfno = $_REQUEST['tfno'];
    $contra = $_REQUEST['contra'];
    $admin = $_REQUEST['admin'];

    if (!GestionDatos::isDni($dni)) {
        if (GestionDatos::insertUsuario($dni, $correo, $nombre, $tfno, $contra)) {
            if (isset($admin)) {
                GestionDatos::hacerAdminDNI($dni);
            }
        }
    } else {
        $_SESSION['mensaje2'] = 'El dni introducido ya está registrado';
        header('Location: Vistas/registroAdmin.php');
        die();
    }

    //Obtiene los usuarios para que al volver a la 
    //página los contenidos estén actualizados
    $usuarios = GestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
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
        if (GestionDatos::updateUsuario($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
    }
    //HACER ADMIN
    if ($accion == 'Hacer admin') {
        $usuario = $usuarios[$posElegida];
        if (GestionDatos::hacerAdmin($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
    }
    //QUITAR ADMIN
    if ($accion == 'Quitar admin') {
        $usuario = $usuarios[$posElegida];
        if (GestionDatos::quitarAdmin($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
    }
    //ELIMINAR USUARIO
    if ($accion == 'Eliminar') {
        $usuario = $usuarios[$posElegida];
        if (GestionDatos::deleteUsuario($usuario)) {
            header('Location: Vistas/CRUD.php');
        }
        //Obtiene los usuarios para que al volver a la 
        //página los contenidos estén actualizados
        $usuarios = GestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
    }
}
//-----------------------------------------------------------------------------
//-----------------------GESTIÓN DE TAREAS ADMINISTRADOR-----------------------
//-----------------------------------------------------------------------------
//--------TAREAS
if (isset($_REQUEST['EntrarTareas'])) {
    //Obtenemos todas las tareas
    $tareas = GestionDatos::getTareas();
    $_SESSION['tareas'] = $tareas;
    header('Location: Vistas/tareas.php');
}

if (isset($_REQUEST['CrearTarea'])) {
    header('Location: Vistas/crearTarea.php');
}
//AÑADIR TAREA
if (isset($_REQUEST['RegistrarTarea'])) {
    $descripcion = $_REQUEST['descripcion'];
    $dificultad = $_REQUEST['dificultad'];
    if (!GestionDatos::createTarea($descripcion, $dificultad)) {
        $_SESSION['mensaje2'] = 'No se ha podido insertar la tarea';
        header('Location: Vistas/crearTarea.php');
    } else {
        header('Location: Vistas/tareas.php');
    }
    $tareas = GestionDatos::getTareas();
    $_SESSION['tareas'] = $tareas;
}

//EDITAR-ELIMINAR TAREAS
if (isset($_SESSION['tareas'])) {
    $tareas = $_SESSION['tareas'];
    $accion = "";
    $posElegida;
    for ($i = 0; $i < count($tareas); $i++) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $posElegida = $i;
        }
    }
    if ($accion == 'Editar tarea') {
        $descripciones = $_REQUEST['descripcion'];
        $pdesarrollos = $_REQUEST['pdesarrollo'];
        $dificultades = $_REQUEST['dificultad'];

        $tarea = $tareas[$posElegida];
        $tarea->setDescripcion($descripciones[$posElegida]);
        $tarea->setPdesarrollo($pdesarrollos[$posElegida]);
        $tarea->setDificultad($dificultades[$posElegida]);

        if (GestionDatos::updateTarea($tarea)) {
            header('Location: Vistas/tareas.php');
        }
    }

    if ($accion == 'Eliminar tarea') {
        $tarea = $tareas[$posElegida];
        if (GestionDatos::deleteTarea($tarea)) {
            header('Location: Vistas/tareas.php');
        }
        //Obtiene las tareas para que al volver a la página los contenidos estén actualizados
        $tareas = GestionDatos::getTareas();
        $_SESSION['tareas'] = $tareas;
    }
}

//-----------------------------------------------------------------------------
//-----------------------------------USARIO------------------------------------
//-----------------------------------------------------------------------------
//VER MIS TAREAS
if (isset($_REQUEST['VerMisTareass'])) {
    $usu = $_SESSION['usuario'];
    $misTareas = GestionDatos::getMisTareas($usu->getDni());
    $_SESSION['misTareas'] = $misTareas;
    header('Location: Vistas/verMisTareas.php');
}
//VER TAREAS DISPONIBLES
if (isset($_REQUEST['VerTareasDisp'])) {
    $usu = $_SESSION['usuario'];
    $tareasDispo = GestionDatos::getTareasDispo($usu->getDni());
    $_SESSION['tareasDispo'] = $tareasDispo;
    header('Location: Vistas/verTareas.php');
}
//EDITAR MIS TAREAS
if (isset($_SESSION['misTareas'])) {
    $misTareas = $_SESSION['misTareas'];
    $accion = "";
    $posElegida;
    for ($i = 0; $i < count($misTareas); $i++) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $posElegida = $i;
        }
    }
    if ($accion == 'Editar') {
        $descripciones = $_REQUEST['descripcion'];
        $pdesarrollos = $_REQUEST['pdesarrollo'];
        $dificultades = $_REQUEST['dificultad'];

        $tarea = $misTareas[$posElegida];
        $tarea->setDescripcion($descripciones[$posElegida]);
        $tarea->setPdesarrollo($pdesarrollos[$posElegida]);
        $tarea->setDificultad($dificultades[$posElegida]);

        if (GestionDatos::updateTarea($tarea)) {
            header('Location: Vistas/verMisTareas.php');
        }
    }
    if ($accion == 'Terminada') {
        $tarea = $misTareas[$posElegida];
        $tarea->setPdesarrollo(100);
        if (GestionDatos::updateTerminada($tarea)) {
            header('Location: Vistas/verMisTareas.php');
        }
    }

    if ($accion == 'Dejar tarea') {
        $yo = $_SESSION['usuario'];
        $tarea = $misTareas[$posElegida];
        if (GestionDatos::dejarTarea($tarea, $yo)) {
            header('Location: Vistas/verMisTareas.php');
        }
        $misTareas = GestionDatos::getMisTareas($yo->getDni());
        $_SESSION['misTareas'] = $misTareas;
    }
}
//ELEGIR NUEVA TAREA
if (isset($_SESSION['tareasDispo'])) {
    $tareasDispo = $_SESSION['tareasDispo'];
    $accion = "";
    $posElegida;
    for ($i = 0; $i < count($tareasDispo); $i++) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $posElegida = $i;
        }
    }
    if ($accion == 'Elegir tarea') {
        $yo = $_SESSION['usuario'];
        $tarea = $tareasDispo[$posElegida];
        if (GestionDatos::elegirTarea($tarea, $yo->getDni())) {
            header('Location: Vistas/verTareas.php');
        }
        $tareasDispo = GestionDatos::getTareasDispo($yo->getDni());
        $_SESSION['tareasDispo'] = $tareasDispo;
    }
}
