<?php
class ReviewController extends BaseController
{
    public function handle($action)
    {
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? null;
            $place_id = $_POST['place_id'] ?? null;
            $rating = (int)($_POST['rating'] ?? 0);
            $comment = $_POST['comment'] ?? '';
            if (!$user_id || !$place_id || $rating < 1 || $rating > 5) {
                $_SESSION['flash'] = 'Dados inválidos para avaliação';
                header('Location: index.php?page=place&id=' . $place_id);
                exit;
            }
            (new ReviewModel())->create(['user_id'=>$user_id,'place_id'=>$place_id,'rating'=>$rating,'comment'=>$comment]);
            $_SESSION['flash'] = 'Avaliação enviada';
            header('Location: index.php?page=place&id=' . $place_id);
            exit;
        }
    }
}
