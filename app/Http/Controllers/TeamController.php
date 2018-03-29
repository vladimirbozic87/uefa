<?php

namespace App\Http\Controllers;

use App\Game;
use App\Player;
use App\Position;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Show form for create Team
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getCreate()
    {
        $team = Team::all();

        if (count($team) == 4) {

            $my_team = Team::where('owner', 1)->get()->first();

            return redirect()->route('get-create-players', $my_team->name);
        }

        return view('team.create')->with('team', $team);
    }

    /**
     * Create Team
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:teams|regex:/^[A-Za-z0-9\-\+\s]+$/',
        ]);

        $team_check = Team::all();

        $owner = 0;

        if (count($team_check) == 0) {
            $owner = 1;
        }

        DB::table('teams')->update(['active' => 0]);

        $team = new Team();

        $team->name   = $request->input('name');
        $team->owner  = $owner;
        $team->active = 1;

        $team->save();

        $team_check2 = Team::all();

        if (count($team_check2) == 4) {

            $owner = Team::where('owner', 1)->get()->first();

            foreach ($team_check2 as $t) {

                if ($t->id === $owner->id) {
                    continue;
                }

                $game = new Game();

                $game->team_one_id = $owner->id;
                $game->team_two_id = $t->id;
                $game->score       = "";

                $game->save();
            }

            Game::where('team_one_id', $owner->id)->first()->update(['ready_to_play' => 1]);
        }

        return redirect()->route('get-create-players', [$team->name]);
    }

    /**
     * Show all Players and show form for Player creation
     * @param string $name
     * @return mixed
     */
    public function getCreatePlayers(string $name)
    {
        $team = Team::where('name', $name)->get()->first();

        if ( ! $team) {
            abort(404);
        }

        $players = Player::where('team_id', $team->id)->get();

        $player_positions = Position::all();

        return view('player.create')
            ->with('name', $name)
            ->with('player_positions', $player_positions)
            ->with('players', $players);
    }

    /**
     * Create Players
     * @param Request $request
     * @param string $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreatePlayers(Request $request, string $name)
    {
        $this->validate($request, [
            'player_name'     => 'required|unique:players,name',
            'player_position' => 'required',
            'player_quality'  => 'required|integer|between:1,10',
            'player_speed'    => 'required|integer|between:1,10',
        ]);

        $team = Team::where('name', $name)->get()->first();

        $players_check_1 = Player::where('team_id', $team->id)->where('position_id', '1')->get();

        if (count($players_check_1) == 2 && $request->input('player_position') == 1) {
            return redirect()->back()->withInput($request->all())->with('danger', 'There can be only two goalies');
        }

        $players_check_2 = Player::where('team_id', $team->id)->where('position_id', '2')->get();

        if (count($players_check_2) == 6 && $request->input('player_position') == 2) {
            return redirect()->back()->withInput($request->all())->with('danger', 'There can be only six defenders');
        }

        $players_check_3 = Player::where('team_id', $team->id)->where('position_id', '3')->get();

        if (count($players_check_3) == 10 && $request->input('player_position') == 3) {
            return redirect()->back()->withInput($request->all())->with('danger', 'There can be only ten midfielders');
        }

        $players_check_4 = Player::where('team_id', $team->id)->where('position_id', '4')->get();

        if (count($players_check_4) == 4 && $request->input('player_position') == 4) {
            return redirect()->back()->withInput($request->all())->with('danger', 'There can be only ten strikers');
        }

        $player_positions = Position::all();

        $player = new Player();

        $player->team_id     = $team->id;
        $player->name        = $request->input('player_name');
        $player->position_id = $request->input('player_position');
        $player->quality     = $request->input('player_quality');
        $player->speed       = $request->input('player_speed');

        $player->save();

        $players = Player::where('team_id', $team->id)->get();

        if (count($players) == 22) {
            return redirect()
                ->route('get-create-players', [$name])
                ->with('player_positions', $player_positions)
                ->with('players', $players)
                ->with('info', 'Team is completed');

        }

        return view('player.create')
            ->with('name', $name)
            ->with('player_positions', $player_positions)
            ->with('players', $players);
    }

    /**
     * Set Team to manipulated
     * @return $this
     */
    public function getSetTeam()
    {
        $teams = Team::all();

        return view('team.active')->with('teams', $teams);
    }

    /**
     * Set Team to manipulated
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetTeam(Request $request)
    {
        $this->validate($request, [
            'active' => 'required',
        ]);

        $team = Team::find($request->input('active'));

        DB::table('teams')->update(['active' => 0]);

        $team->active = 1;

        $team->save();

        return redirect()->route('get-create-players', [$team->name]);
    }
}
