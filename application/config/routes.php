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
$route['curso/nueva'] = 'Curso/nueva';
$route['curso/mod/(:any)'] = 'Curso/mod/$1';
$route['curso/pagina/(:num)'] = 'Curso';//cuando no sea la primera página
$route['curso/pagina'] = 'Curso';//cuando sea la primera página


// Titulaciones

$route['titulacion'] = 'Titulacion';
$route['titulacion/nueva'] = 'Titulacion/nueva';
$route['titulacion/mod/(:any)'] = 'Titulacion/mod/$1';
$route['titulacion/pagina/(:num)'] = 'Titulacion';//cuando no sea la primera página
$route['titulacion/pagina'] = 'Titulacion';//cuando sea la primera página

// Asignaturas

$route['asignatura'] = 'Asignatura';
$route['asignatura/nueva'] = 'Asignatura/nueva';
$route['asignatura/mod/(:any)'] = 'Asignatura/mod/$1';
$route['asignatura/pagina/(:num)'] = 'Asignatura';//cuando no sea la primera página
$route['asignatura/pagina'] = 'Asignatura';//cuando sea la primera página


// Categorías

$route['categorias'] = 'Categorias';
$route['categorias/nueva'] = 'Categorias/nueva';
$route['categorias/mod/(:any)'] = 'Categorias/mod/$1';
$route['categorias/pagina/(:num)'] = 'Categorias';//cuando no sea la primera página
$route['categorias/pagina'] = 'Categorias';//cuando sea la primera página


// Paginación de ACCESOS.

$route['accesos/pagina/(:num)'] = 'Accesos';//cuando no sea la primera página
$route['accesos/pagina'] = 'Accesos';//cuando sea la primera página

// Alumnos

$route['alumnos/pagina/(:num)'] = 'Alumnos';//cuando no sea la primera página
$route['alumnos/pagina'] = 'Alumnos';//cuando sea la primera página

// Profesores

$route['usuarios/pagina/(:num)'] = 'Usuarios';//cuando no sea la primera página
$route['usuarios/pagina'] = 'Usuarios';//cuando sea la primera página

// Preguntas (alumno)

$route['pregunta'] = 'Pregunta';
$route['pregunta/nueva'] = 'Pregunta/nueva';
$route['pregunta/mod/(:any)'] = 'Pregunta/mod/$1';
$route['pregunta/pagina/(:num)'] = 'Pregunta';//cuando no sea la primera página
$route['pregunta/pagina'] = 'Pregunta';//cuando sea la primera página

// Preguntas (profesor)

$route['preguntas'] = 'Preguntas';
$route['preguntas/nueva'] = 'Preguntas/nueva';
$route['preguntas/mod/(:any)'] = 'Preguntas/mod/$1';
$route['preguntas/pagina/(:num)'] = 'Preguntas';//cuando no sea la primera página
$route['preguntas/pagina'] = 'Preguntas';//cuando sea la primera página

$route['datosalumno'] = 'DatosAlumno';
$route['datosprofesor'] = 'DatosProfesor';

// Paneles

$route['paneles'] = 'Paneles';
$route['paneles/mod/(:any)'] = 'Paneles/mod/$1';
$route['paneles/pagina/(:num)'] = 'Paneles';//cuando no sea la primera página
$route['paneles/pagina'] = 'Paneles';//cuando sea la primera página

// Partidas

$route['partidas'] = 'Partidas';
$route['partidas/mod/(:any)'] = 'Partidas/mod/$1';
$route['partidas/pagina/(:num)'] = 'Partidas';//cuando no sea la primera página
$route['partidas/pagina'] = 'Partidas';//cuando sea la primera página

// Jugar

$route['jugar'] = 'Jugar';
//$route['jugar/(:num)'] = 'Jugar/$1';
//$route['jugar/(:num)/(:num)'] = 'Jugar/$1/$2';
$route['jugar/(:num)/(:num)/(:num)/(:num)'] = 'Jugar/$1/$2/$3/$4';
//$route['jugar/([a-zA-Z0-9]+)'] = 'Jugar/$1/$2';
$route['jugar/([a-zA-Z0-9]+)'] = 'Jugar/$1/$2/$3/$4';
$route['jugar/(:any)'] = 'Jugar/$1/$2/$3/$4';

// Cuestión

$route['cuestion'] = 'Cuestion';
