<?php

namespace App\Controller;

use App\Models\GamesList;
use App\Models\UsersList;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GamesController extends AbstractController
{
    private GamesList $gamesList;

    public function __construct(protected Request $request, protected Response $response)
    {
        parent::__construct($request, $response);
        $this->gamesList = new GamesList();
    }

    public function index(): Response
    {
        return $this->render('Games/index', [
          'games' => implode(", ", array_map(function ($game) { return $game->getVars(); }, $this->gamesList->all()))
        ]);
    }

    public function show(?string $game_id): Response
    {
        [$game, $achievements, $tags] = $this->gamesList->find($game_id);
        
        return $this->render('Games/show', [
            'game' => $game,
            'achievements' => json_encode(array_map(function ($achievement) { return $achievement->getVars(); }, $achievements)),
            'tags' => $tags,
            'json_tags' => json_encode($tags)
        ]);
    }

    public function update(): void
    {
        $achievement_id = @$_POST['achievement_id'];
        $description = @$_POST['description'];

        $achievement = $this->gamesList->updateAchievement($achievement_id, $description);

        echo json_encode($achievement->getVars());
    }

    public function user(): void
    {
        $game_id = @$_GET['gameid'];
        $user_id = @$_GET['userid'];

        if(!empty($game_id) && !empty($user_id)) {
            $usersList = new UsersList();
            [$game, $achievements, $tags] = $this->gamesList->findForUser($game_id, $user_id);
            [$user, $_trash1, $_trash2, $games] = $usersList->find($user_id);

            $this->render('Games/user', [
              'game' => $game,
              'user' => $user,
              'achievements' => json_encode(array_map(function ($achievement) { return $achievement->getVars(); }, $achievements)),
              'tags' => $tags
            ]);
        } else {
            $this->render('Games/404');
        }
    }
}
