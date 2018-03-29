<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Game;
use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Show Game
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getPlayTeam()
    {
        $games = Game::all();

        if (count($games) == 0) {
            return redirect()->route('get-team');
        }

        return view('game.show')->with('games', $games);
    }

    /**
     * Show Formation
     * @param string $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getFormation(string $name)
    {
        $team = Team::where('name', $name)->get()->first();

        if ( ! $team) {
            abort(404);
        }

        if (count($team->player) < 22) {
            return redirect()->route('get-team');
        }

        $position_array = [];

        foreach ($team->activePlayers as $player) {
            $position_array[$player->position_id][] = $player;
        }

        krsort($position_array);

        $formations = Formation::all();

        return view('game.formations')
            ->with('position_array', $position_array)
            ->with('formations', $formations)
            ->with('name', $name);
    }

    /**
     * Save Formation
     * @param Request $request
     * @param string $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFormation(Request $request, string $name)
    {
        $this->validate($request, [
            'formation' => 'required',
        ]);

        $team = Team::where('name', $name)->get()->first();

        $formation_check = $request->input('formation');

        Player::where('team_id', $team->id)->update(['active' => 0]);

        Player::where('team_id', $team->id)->where('position_id', 1)
            ->orderBy('quality', 'desc')->take(1)->update(['active' => 1]);

        if ($formation_check == 1) {

            Player::where('team_id', $team->id)->where('position_id', 2)->where('injured', 0)
                ->orderBy('quality', 'desc')->take(5)->update(['active' => 1]);

            Player::where('team_id', $team->id)->where('position_id', 4)->where('injured', 0)
                ->orderBy('speed', 'desc')->take(1)->update(['active' => 1]);

        } elseif ($formation_check == 2) {

            Player::where('team_id', $team->id)->where('position_id', 2)->where('injured', 0)
                ->orderBy('quality', 'desc')->take(4)->update(['active' => 1]);

            Player::where('team_id', $team->id)->where('position_id', 4)->where('injured', 0)
                ->orderBy('quality', 'desc')->take(2)->update(['active' => 1]);

        } elseif ($formation_check == 3) {

            Player::where('team_id', $team->id)->where('position_id', 2)->where('injured', 0)
                ->orderBy('quality', 'desc')->take(3)->update(['active' => 1]);

            Player::where('team_id', $team->id)->where('position_id', 4)->where('injured', 0)
                ->orderBy('quality', 'desc')->take(3)->update(['active' => 1]);
        }

        Player::where('team_id', $team->id)->where('position_id', 3)->where('injured', 0)
            ->orderBy('quality', 'desc')->take(4)->update(['active' => 1]);

        $position_array = [];

        foreach ($team->activePlayers as $player) {
            $position_array[$player->position_id][] = $player;
        }

        krsort($position_array);

        $formations = Formation::all();

        return redirect()
            ->route('get-formation', [$name])
            ->with('position_array', $position_array)
            ->with('formations', $formations)
            ->with('info', 'The formation was successfully set up');
    }

    /**
     * Game simulation
     * @param string $game_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play(string $game_id)
    {
       $game = Game::find($game_id);

        if ( ! $game) {
            abort(404);
        }

       $players1 = Player::where('team_id', $game->team_one_id)->where('active', 1)->get();

       $attack_quality1 = [];
       $attack_speed1   = [];

       $defense_quality1 = [];
       $defense_speed1   = [];

       $i = 1;

       foreach ($players1 as $player) {

           if ($player->position_id == 1 || $player->position_id == 2) {

               $defense_quality1[] = $player->quality;
               $defense_speed1[]   = $player->speed;
           }

           if ($player->position_id == 3) {

               if ($i < 3) {
                   $defense_quality1[] = $player->quality;
                   $defense_speed1[]   = $player->speed;
               } else {
                   $attack_quality1[] = $player->quality;
                   $attack_speed1[]   = $player->speed;
               }
               $i++;
           }

           if ($player->position_id == 4) {
               $attack_quality1[] = $player->quality;
               $attack_speed1[]   = $player->speed;
           }
       }

       $average_attack_quality1  = array_sum($attack_quality1) / count($attack_quality1);
       $average_attack_speed1    = array_sum($attack_speed1) / count($attack_speed1);
       $average_defense_quality1 = array_sum($defense_quality1) / count($defense_quality1);
       $average_defense_speed1   = array_sum($defense_speed1) / count($defense_speed1);

       $players2 = Player::where('team_id', $game->team_two_id)->where('active', 1)->get();

       $attack_quality2 = [];
       $attack_speed2   = [];

       $defense_quality2 = [];
       $defense_speed2   = [];

       $j = 1;

       foreach ($players2 as $player) {

           if ($player->position_id == 1 || $player->position_id == 2) {
               $defense_quality2[] = $player->quality;
               $defense_speed2[]   = $player->speed;
           }

           if ($player->position_id == 3) {

               if ($j < 3) {
                   $defense_quality2[] = $player->quality;
                   $defense_speed2[]   = $player->speed;
               } else {
                   $attack_quality2[] = $player->quality;
                   $attack_speed2[]   = $player->speed;
               }
               $j++;
           }

           if ($player->position_id == 4) {
               $attack_quality2[] = $player->quality;
               $attack_speed2[]   = $player->speed;
           }
       }

       $average_attack_quality2  = array_sum($attack_quality2) / count($attack_quality2);
       $average_attack_speed2    = array_sum($attack_speed2) / count($attack_speed2);
       $average_defense_quality2 = array_sum($defense_quality2) / count($defense_quality2);
       $average_defense_speed2   = array_sum($defense_speed2) / count($defense_speed2);

       $added_defense_quality2 = $this->addValue(count($defense_quality2), count($attack_quality1)) + $average_defense_quality2;
       $added_defense_speed2   = $this->addValue(count($defense_speed2), count($attack_speed1)) + $average_defense_speed2;

       $attack_quality_final1 = $average_attack_quality1 - $added_defense_quality2;
       $attack_speed_final1   = $average_attack_speed1 - $added_defense_speed2;

       $added_defense_quality1 = $this->addValue(count($defense_quality1), count($attack_quality2)) + $average_defense_quality1;
       $added_defense_speed1   = $this->addValue(count($defense_speed1), count($attack_speed2)) + $average_defense_speed1;

       $attack_quality_final2 = $average_attack_quality2 - $added_defense_quality1;
       $attack_speed_final2   = $average_attack_speed2 - $added_defense_speed1;

       $give    = $this->addHit($attack_quality_final1, $attack_speed_final1);
       $receive = $this->addHit($attack_quality_final2, $attack_speed_final2);

       $score = $give . " -- " . $receive;

       $game->score = $score;

       $game->save();

       $player1 = Player::where('team_id', $game->team_one_id)
           ->where('position_id', '!=', 1)->where('active', 1)
           ->inRandomOrder()->get()->first();

       $player1->injured = 1;

       $player1->save();

       $player2 = Player::where('team_id', $game->team_two_id)
           ->where('position_id', '!=', 1)->where('active', 1)
           ->inRandomOrder()->get()->first();

       $player2->injured = 1;

       $player2->save();

       Player::where('team_id', $game->team_one_id)->update(['active' => 0]);
       Player::where('team_id', $game->team_two_id)->update(['active' => 0]);

       DB::table('games')->update(['ready_to_play' => 0]);

       $game_update = Game::where('id', '>', $game_id)->first();

       if ($game_update) {

           $game_update->ready_to_play = 1;

           $game_update->save();
       }

        $games = Game::all();

        return redirect()
            ->route('get-play-game')
            ->with('games', $games)
            ->with('info', 'The match is over');
    }

    /**
     * Adding value to quantity
     * @param string $defense
     * @param string $attack
     * @return float|int
     */
    private function addValue(string $defense, string $attack)
    {
        if ($defense - $attack == 1) {
            return 1;
        }

        if ($defense - $attack == 2) {
            return 1.5;
        }

        if ($defense - $attack == 3) {
            return 2;
        }

        return 0;
    }

    /**
     * Adding Hit
     * @param string $quality
     * @param string $speed
     * @return int
     */
    private function addHit(string $quality, string $speed)
    {
        $sum = $quality + $speed;

        if ($sum > 0 && $sum < 0.5) {
            return 1;
        } elseif ($sum > 0.5 && $sum < 1) {
            return 2;
        } elseif ($sum > 1) {
            return 3;
        }

        return 0;
    }
}
