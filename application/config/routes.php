<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['search'] = 'search/term';

$route['article/tag/(:any)']  = 'articles/list_articles/$1'; //articles with selected tag
$route['article/page/(:num)']  = "articles/list_articles/$1"; //article pagination
$route['article/(:any)']  = 'articles/page/$1'; //to full article
$route['article']  = 'articles'; //all articles

$route['author/(:num)/articles']  = 'authors/author_articles/$1'; //get a authhor
$route['author/(:num)']  = 'authors/author/$1'; //get a authhor

$route['default_controller'] = "welcome";
$route['404_override'] = 'PageNotFound';



/* End of file routes.php */
/* Location: ./application/config/routes.php */