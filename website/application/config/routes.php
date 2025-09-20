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
|	https://codeigniter.com/userguide3/general/routing.html
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

//user login

$route['login'] = 'Home/login_data';

$route['logout'] = 'Home/logout_data';

$route['register'] = 'Home/register';

$route['set_language'] = 'Home/set_language';


// search

$route['search'] = 'Home/search_data/$1';


// cart

$route['cart'] = 'Home/cart_details';

$route['cart_count'] = 'Home/cart_count';

$route['wishlist_count'] = 'Home/wishlist_count';


// pages

$route['privacy'] = 'Home/privacy';

$route['refund'] = 'Home/refund';

$route['about'] = 'Home/about';

$route['about_us'] = 'Home/about_us';

$route['faq'] = 'Home/faq';

$route['contact'] = 'Home/contact';

$route['tearm'] = 'Home/tearm';

$route['404'] = 'Home/error';



$route['get_home_products'] = 'Home/get_home_products';

$route['get_home_cat_products'] = 'Home/get_home_cat_products';

$route['get_home_bottom_banner'] = 'Home/get_home_bottom_banner';


$route['default_controller'] = 'Home';

$route['404_override'] = 'Home/error';

$route['translate_uri_dashes'] = FALSE;
