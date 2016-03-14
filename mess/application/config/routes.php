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
|	http://codeigniter.com/user_guide/general/routing.html
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

//Account Route Start
$route['default_controller'] = 'Account';
$route['create']['get'] = 'Account/getCreate';
$route['create']['post'] = 'Account/postCreate';
$route['login']['post'] = 'Account/getLogin';
$route['logout']['get'] = 'Account/getLogout';
$route['dashboard']['get'] = 'Account/getDashboard';

//Dashboard Manager Route Start

$route['dashboard/test']['get'] = 'Dashboard';
$route['dashboard/member']['get'] = 'Member/getMember';
$route['dashboard/member/new']['get'] = 'Member/getNewMember';
$route['dashboard/member/new']['post'] = 'Member/postNewMember';
$route['dashboard/accounts']['get'] = 'MessAccounts/getMessAccounts';
$route['dashboard/accounts/new']['get'] = 'MessAccounts/getNewMessAccounts';
$route['dashboard/accounts/new']['post'] = 'MessAccounts/postNewMessAccounts';
$route['dashboard/expenditure']['get'] = 'Expenditure/getExpenditure';
$route['dashboard/expenditure/new']['get'] = 'Expenditure/getNewExpenditure';
$route['dashboard/expenditure/new']['post'] = 'Expenditure/postNewExpenditure';
$route['dashboard/meal']['get'] = 'Meal/getMeal';
$route['dashboard/archive/meal']['get'] = 'Archive/getMealArchive';
$route['dashboard/archive/meal/month/(:any)']['get'] = 'Archive/getMealMonth/$1';
$route['dashboard/archive/report']['get'] = 'Archive/getReportArchive';
$route['dashboard/archive/report/month/(:any)']['get'] = 'Archive/getArchiveMonth/$1';
$route['dashboard/userpanel']['get'] = 'UserPanel/getUserPanel';
$route['dashboard/userpanel/new']['post'] = 'UserPanel/postNewUserPanel';
$route['dashboard/report']['get'] = 'Report/getReport';

//Dashboard User Route Start

$route['dashboard/panel']['get'] = 'Panel/getPanel';
$route['dashboard/panel']['post'] = 'Panel/postPanel';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;