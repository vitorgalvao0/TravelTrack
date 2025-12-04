<?php
class PlaceController extends BaseController
{
    public function dashboard()
    {
        $user = null;
        if (!empty($_SESSION['user_id'])) {
            $user = (new UserModel())->findById($_SESSION['user_id']);
        }
        $places = (new PlaceModel())->all();
        $ranking = (new CheckinModel())->weeklyRanking();
        $this->view('user/dashboard.php', ['user' => $user, 'places' => $places, 'ranking' => $ranking]);
    }

    public function index()
    {
        $places = (new PlaceModel())->all();
        $this->view('user/places.php', ['places' => $places]);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=places');
            exit;
        }
        $place = (new PlaceModel())->find($id);
        $reviews = (new ReviewModel())->forPlace($id);
        $user = null;
        if (!empty($_SESSION['user_id'])) {
            $user = (new UserModel())->findById($_SESSION['user_id']);
        }
        $this->view('user/place.php', ['place' => $place, 'reviews' => $reviews, 'user' => $user]);
    }
}
