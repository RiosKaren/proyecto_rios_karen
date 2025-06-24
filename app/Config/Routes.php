<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/inicio', 'Home::index');

$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('terminos', 'Home::terminos');
$routes->get('contacto', 'Home::contacto');
$routes->get('comercializacion', 'Home::comercializacion');

$routes->post('suscribir', 'Home::suscribir');

$routes->get('/admin', 'UsuarioController::admin');


//UsuarioController.php
$routes->get('/login', 'UsuarioController::login');
$routes->post('/login', 'UsuarioController::loginPost');

$routes->get('/registro', 'UsuarioController::registro');
$routes->post('/registro', 'UsuarioController::registroPost');

$routes->get('/recuperar', 'UsuarioController::recuperar');
$routes->post('/recuperar', 'UsuarioController::recuperarPost');


$routes->get('/logout', 'UsuarioController::logout');

$routes->get('/usuarios', 'UsuarioController::index');
$routes->get('/usuarios/nuevo', 'UsuarioController::nuevo');
$routes->post('/usuarios/guardar', 'UsuarioController::guardar');


//RUTAS PERFIL DE USUARIO
$routes->get('/perfil', 'PerfilController::index');
$routes->get('/back/perfil', 'PerfilController::index');

$routes->post('/perfil/actualizar-datos', 'PerfilController::actualizarDatos');
$routes->post('/perfil/cambiar-password', 'PerfilController::cambiarPassword');

$routes->get('/perfil/orden/(:num)', 'PerfilController::verOrden/$1');


//admin productos
$routes->get('admin/productos', 'ProductosController::index');
$routes->get('admin/productos/crear', 'ProductosController::crear');       // muestra el formulario
$routes->post('admin/productos/guardar', 'ProductosController::guardar'); // guarda el producto
$routes->get('admin/productos/editar/(:num)', 'ProductosController::editar/$1');
$routes->post('admin/productos/actualizar/(:num)', 'ProductosController::actualizar/$1');
$routes->get('admin/productos/deshabilitar/(:num)', 'ProductosController::deshabilitar/$1');
$routes->get('admin/productos/habilitar/(:num)', 'ProductosController::habilitar/$1');


$routes->get('producto/(:num)', 'ProductosController::ver/$1');


//lista de usuarios

$routes->get('admin/usuarios', 'UsuarioController::usuarios');

$routes->get('admin/usuarios/desactivar/(:num)', 'UsuarioController::desactivar/$1');
$routes->get('admin/usuarios/activar/(:num)', 'UsuarioController::activar/$1');

//RUTAS ADMIN SOLICITUDES
$routes->post('consultas/enviar', 'ConsultasClientesController::enviar');
$routes->get('admin/consultas', 'ConsultasClientesController::verSolicitudes');
$routes->get('admin/solicitudes', 'ConsultasClientesController::verSolicitudes');

$routes->post('admin/solicitudes/responder/(:num)', 'ConsultasClientesController::responder/$1');
$routes->post('admin/solicitudes/cambiar-estado/(:num)', 'ConsultasClientesController::cambiarEstado/$1');

//compras
$routes->get('admin/compras', 'ComprasAdminController::index');

$routes->get('admin/compras/detalle/(:num)', 'ComprasAdminController::detalle/$1');

//carrito
$routes->get('/carrito', 'CarritoController::index');
$routes->post('/carrito/agregar', 'CarritoController::agregar');
$routes->get('/carrito/eliminar/(:segment)', 'CarritoController::eliminar/$1');
$routes->get('/carrito/vaciar', 'CarritoController::vaciar'); // Vaciar carrito completo
$routes->post('/carrito/actualizar', 'CarritoController::actualizarCantidad');


//checkout
$routes->get('/checkout', 'CheckoutController::index');               // Mostrar formulario de compra
$routes->post('/checkout/procesar', 'CheckoutController::procesar'); // Procesar datos y confirmar compra

// Rutas para búsqueda de productos
$routes->get('productos/buscar', 'ProductosController::buscar');
$routes->get('productos', 'ProductosController::catalogo'); // Catálogo completo
$routes->get('catalogo', 'ProductosController::catalogo'); // Alias para catálogo
