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
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
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

//$route['default_controller'] = 'welcome';
$route['default_controller'] = 'Login';
$route['404_override'] = 'Error404';
$route['translate_uri_dashes'] = FALSE;

// Curso

$route['curso'] = 'Curso';


// Titulaciones

$route['titulacion'] = 'Titulacion';

// Asignaturas

$route['asignatura'] = 'Asignatura';

// Categorías

$route['categorias'] = 'Categorias';

// Preguntas (alumno)

$route['pregunta'] = 'Pregunta';

// Preguntas (profesor)

$route['preguntas'] = 'Preguntas';

$route['datosalumno'] = 'DatosAlumno';
$route['datosprofesor'] = 'DatosProfesor';

// Paneles

$route['paneles'] = 'Paneles';
$route['paneles/mod/(:any)'] = 'Paneles/mod/$1';
$route['paneles/nueva/(:any)'] = 'Paneles/nueva/$1';
$route['paneles/pagina/(:num)'] = 'Paneles';//cuando no sea la primera página
$route['paneles/pagina'] = 'Paneles';//cuando sea la primera página

// Partidas

$route['partidas'] = 'Partidas';
$route['partidas/mod/(:any)'] = 'Partidas/mod/$1';
$route['partidas/pagina/(:num)'] = 'Partidas';//cuando no sea la primera página
$route['partidas/pagina'] = 'Partidas';//cuando sea la primera página

// Jugar

$route['jugar'] = 'Jugar';
$route['jugar/finalizar'] = 'Jugar/finalizar/$1';

//$route['jugar/(:num)'] = 'Jugar/$1';
//$route['jugar/(:num)/(:num)'] = 'Jugar/$1/$2';
$route['jugar/(:num)/(:num)/(:num)/(:num)'] = 'Jugar/$1/$2/$3/$4';
//$route['jugar/([a-zA-Z0-9]+)'] = 'Jugar/$1/$2';
$route['jugar/([a-zA-Z0-9]+)'] = 'Jugar/$1/$2/$3/$4';
$route['jugar/(:any)'] = 'Jugar/$1/$2/$3/$4';

// Cuestión

$route['cuestion'] = 'Cuestion';

// Visualizar partida

$route['visualizar'] = 'Visualizar';

$route['universidad'] = 'Universidad';
