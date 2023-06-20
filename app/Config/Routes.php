<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('seznam-svazu', 'Association::index');
$routes->get('svaz/pridat', 'Association::new');
$routes->post('svaz/create', 'Association::create');
$routes->get('svaz/editovat/(:num)', 'Association::edit/$1');
$routes->put('svaz/update', 'Association::update');
$routes->delete('svaz/smazat/(:num)', 'Association::delete/$1');
$routes->get('svaz/zobrazit/(:num)', 'Association::show/$1');

$routes->get('seznam-sezon', 'Season::index');
$routes->get('sezona/pridat', 'Season::new');
$routes->post('sezona/create', 'Season::create');
$routes->get('sezona/editovat/(:num)', 'Season::edit/$1');
$routes->put('sezona/update', 'Season::update');
$routes->delete('sezona/smazat/(:num)', 'Season::delete/$1');
$routes->get('sezona/zobrazit/(:any)/(:num)', 'Season::show/$2');

$routes->get('seznam-lig', 'League::index');
$routes->get('liga/pridat', 'League::new');
$routes->post('liga/create', 'League::create');
$routes->get('liga/editovat/(:num)', 'League::edit/$1');
$routes->put('liga/update', 'League::update');
$routes->delete('liga/smazat/(:num)', 'League::delete/$1');
$routes->get('liga/zobrazit/(:num)', 'League::show/$1');

$routes->get('sezona/svaz/(:num)/pridat', 'AssociationSeason::new/$1');
$routes->post('sezona/svaz/create', 'AssociationSeason::create');
$routes->get('sezona/svaz/editovat/(:num)', 'AssociationSeason::edit/$1');
$routes->put('sezona/svaz/update', 'AssociationSeason::update');
$routes->delete('sezona/svaz/smazat/(:num)', 'AssociationSeason::delete/$1');

$routes->get('sezona/liga/(:num)/pridat', 'LeagueSeason::new/$1');
$routes->post('sezona/liga/create', 'LeagueSeason::create');
$routes->get('soutez/(:any)/sezona/(:any)/editovat/soutez/(:num)', 'LeagueSeason::edit/$3');
$routes->get('soutez/(:any)/sezona/(:any)/sprava/skupin/(:num)', 'LeagueSeason::listGroup/$3');
$routes->get('soutez/(:any)/sezona/(:any)/smazat/skupina/(:num)','LeagueSeason::deleteGroup/$3');
$routes->get('soutez/(:any)/sezona/(:any)/pridat/skupina/(:num)','LeagueSeason::addGroup/$3');
$routes->post('soutez/sezona/skupina/create', 'LeagueSeason::createGroup');
$routes->get('soutez/(:any)/sezona/(:any)/editovat/skupina/(:num)','LeagueSeason::editGroup/$3');
$routes->put('soutez/sezona/update', 'LeagueSeason::update');
$routes->delete('soutez/(:any)/sezona/(:any)/smazat/soutez/(:num)','LeagueSeason::delete/$3');
$routes->get('soutez/(:any)/sezona(:any)/(:num)', 'LeagueSeason::show/$3');


$routes->get('seznam-tymu', 'Team::index');
$routes->get('tym/pridat', 'Team::new');
$routes->get('tym/importovat', 'Team::import');
$routes->post('tym/create', 'Team::create');
$routes->post('tym/createImport', 'Team::createImport');
$routes->get('tym/editovat/(:num)', 'Team::edit/$1');

$routes->get('soutez/(:any)/sezona/(:any)/(:num)', 'TeamLeagueSeason::index/$3');
$routes->get('soutez/(:any)/sezona/(:any)/(:num)/pridat','TeamLeagueSeason::add/$3');
$routes->post('soutez/sezona','TeamLeagueSeason::add2');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
