<?php
class AdminController extends BaseController
{
    private function ensureAdmin()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $user = (new UserModel())->findById($_SESSION['user_id']);
        if (!$user || !$user['is_admin']) {
            echo 'Access denied';
            exit;
        }
    }

    public function panel()
    {
        $this->ensureAdmin();
        $this->view('admin/panel.php');
    }

    public function places()
    {
        $this->ensureAdmin();
        $places = (new PlaceModel())->all();
        $this->view('admin/places.php', ['places' => $places]);
    }

    public function rewards()
    {
        $this->ensureAdmin();
        $rewards = (new RewardModel())->all();
        $this->view('admin/rewards.php', ['rewards' => $rewards]);
    }

    public function reviews()
    {
        $this->ensureAdmin();
        $this->view('admin/reviews.php');
    }
}
