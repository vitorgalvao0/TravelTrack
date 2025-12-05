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
    case 'admin_place_new':
        (new AdminController())->newPlace();
        break;
    case 'admin_place_create':
        (new AdminController())->createPlace();
        break;
    case 'admin_place_edit':
        (new AdminController())->editPlace();
        break;
    case 'admin_place_update':
        (new AdminController())->updatePlace();
        break;
    case 'admin_place_delete':
        (new AdminController())->deletePlace();
        break;
    case 'admin_rewards':
        (new AdminController())->rewards();
        break;
    case 'admin_reward_new':
        (new AdminController())->newReward();
        break;
    case 'admin_reward_create':
        (new AdminController())->createReward();
        break;
    case 'admin_reward_edit':
        (new AdminController())->editReward();
        break;
    case 'admin_reward_update':
        (new AdminController())->updateReward();
        break;
    case 'admin_reward_delete':
        (new AdminController())->deleteReward();
        break;
    case 'profile':
        (new ProfileController())->show();
        break;
    case 'update_profile':
        (new ProfileController())->update();
        break;
    case 'qr':
        include VIEW_PATH . '/qr.php';
        break;
    default:
        (new PlaceController())->dashboard();
}

?>
