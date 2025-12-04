<?php
require_once __DIR__ . '/config/autoload.php';

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

switch ($page) {
    case 'login':
        (new AuthController())->showLogin();
        break;
    case 'register':
        (new AuthController())->showRegister();
        break;
    case 'auth':
        (new AuthController())->handle($action);
        break;
    case 'home':
    case 'dashboard':
        (new PlaceController())->dashboard();
        break;
    case 'places':
        (new PlaceController())->index();
        break;
    case 'place':
        (new PlaceController())->show();
        break;
    case 'checkin':
        (new CheckinController())->handle($action);
        break;
    case 'rewards':
        (new RewardController())->index();
        break;
    case 'reward':
        (new RewardController())->handle($action);
        break;
    case 'review':
        (new ReviewController())->handle($action);
        break;
    case 'history':
        (new CheckinController())->history();
        break;
    case 'admin':
        (new AdminController())->panel();
        break;
    case 'admin_places':
        (new AdminController())->places();
        break;
    case 'admin_rewards':
        (new AdminController())->rewards();
        break;
    case 'admin_reviews':
        (new AdminController())->reviews();
        break;
    case 'qr':
        include VIEW_PATH . '/qr.php';
        break;
    default:
        (new PlaceController())->dashboard();
}

?>
