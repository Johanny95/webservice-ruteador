<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller']         = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override']               = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes']       = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['session']                     		  = 'c_login/session';
$route['check']                               = 'c_session/checkSession';

if(!in_array($_SERVER['REMOTE_ADDR'], $this->config->item('maintenance_ips')) && $this->config->item('maintenance_mode')) {
	$route['default_controller'] = "c_login/maintenance";
	$route['(:any)']             = "c_login/maintenance";
} else{
	$route['default_controller'] = 'c_login/cerrar_sesion';
}

////////////////////
// Meta reponedor //
////////////////////

$route['cerrar_sesion']                       = 'c_login/cerrar_sesion';
$route['log']                                 = 'c_login/log';
$route['inicio']                              = 'c_home/inicio';
$route['usuario/denegado']                    = 'c_denegado/denegado';
$route['404_override']                        = '';
$route['translate_uri_dashes']                = FALSE;

$route['add_camiones']						  = 'Controller_integracion/C_camion_integracion/add_camiones';
$route['upd_camiones']						  = 'Controller_integracion/C_camion_integracion/upd_camiones';
$route['del_camiones']						  = 'Controller_integracion/C_camion_integracion/del_camiones';


/*integracion rutas*/
$route['get_rutas_by_day']					  = 'Controller_integracion/C_rutas_integracion/get_rutas_by_day';
$route['get_visit_by_day']					  = 'Controller_integracion/C_rutas_integracion/get_visit_by_day';
$route['integrar_rutas_det']				  = 'Controller_integracion/C_rutas_integracion/integrar_rutas_det';

/*integracion visitas*/
// $route['crear_visitas']						  = 'Controller_integracion/C_visitas_integracion/crear_visitas';
$route['actualizar_visitas']				  = 'Controller_integracion/C_visitas_integracion/upd_visitas_ruteador';
$route['eliminar_visitas']					  = 'Controller_integracion/C_visitas_integracion/del_visitas_ruteador';


$route['del_visitas_prueba']				  = 'Controller_integracion/C_visitas_integracion/visitas_by_day';


/*ADD ID DE CAMIONES Y CHOFERES YA CREADOS EN SIMPLIROUTE*/
$route['get_id_chofer']						  = 'Controller_integracion/C_chofer_integracion/cargar_code_chofer';
$route['get_id_camion']						  = 'Controller_integracion/C_camion_integracion/add_id_camiones_ruteador';


$route['add_chofer']						  = 'Controller_integracion/C_chofer_integracion/add_chofer_ruteador';
$route['upd_chofer']						  = 'Controller_integracion/C_chofer_integracion/upd_chofer_ruteador';
$route['del_chofer']						  = 'Controller_integracion/C_chofer_integracion/del_chofer_ruteador';


$route['delete_camiones_prueba']			  = 'Controller_integracion/C_visitas_integracion/delete_camiones';


/*06-04-2020*/
$route['rutas_oracle']		  				  = 'Controller_integracion/C_rutas_integracion/oracle_rutas_visitas';




/*prueba*/
$route['get_visitas_creadas']				  = 'Controller_integracion/C_creacion_visitas/get_visitas_creadas';
$route['crear_visitas']						  = 'Controller_integracion/C_creacion_visitas/crear_visitas';	