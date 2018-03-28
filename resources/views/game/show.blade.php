@extends('templates.default')

@section('content')

    <div class="row">


            <div class="panel panel-primary">
                <div class="panel-body">

                    <div class="alert alert-warning" role="alert">
                        <strong>You need to complete teams and set up formations</strong>
                    </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="color: white; background-color: #005cbf" align="center">My Team</th>
                        <th style="color: white; background-color: #005cbf" align="center">Other Team</th>
                        <th style="color: white; background-color: #005cbf" align="center">Play Game</th>
                        <th style="color: white; background-color: #005cbf" align="center">Winner</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)

                        @if ($game->ready_to_play == 1)
                            @php
                                $color = 'black';
                                $color1 = 'black';
                                $color2 = 'black';
                                $play = true;
                            @endphp
                        @else
                            @php
                                $color = 'darkgray';
                                $color1 = 'darkgray';
                                $color2 = 'darkgray';
                                $play = false;
                            @endphp
                        @endif

                        @php $play2 = ''; @endphp

                        @if (count($game->teamOne->player) != 22 && $play === true)
                            @php
                                $color1 = 'red';
                                $play2 = 'disabled';
                            @endphp
                        @endif

                        @if (count($game->teamTwo->player) != 22 && $play === true)
                            @php
                                $color2 = 'red';
                                $play2 = 'disabled';
                            @endphp
                        @endif

                        @if (count($game->formation) != 8)
                            @php $play2 = 'disabled'; @endphp
                        @endif

                        <tr>
                            <td>
                                @if ($play)
                                    @if ($color1 == 'red')
                                        <p style="color: red">Formation</p>
                                    @else
                                        <a readonly href="{{ route('get-formation', [$game->teamOne->name, $game->id]) }}">Formation</a>
                                    @endif
                                @endif
                                <a href="{{ route('get-create-players', [$game->teamOne->name]) }}"><h4 style="color: {{ $color1 }}">{{ $game->teamOne->name }}</h4></a>
                            </td>
                            <td>
                                @if ($play)
                                    @if ($color2 == 'red')
                                        <p style="color: red">Formation</p>
                                    @else
                                        <a href="{{ route('get-formation', [$game->teamTwo->name, $game->id]) }}">Formation</a>
                                    @endif
                                @endif
                                <a href="{{ route('get-create-players', [$game->teamTwo->name]) }}"><h4 style="color: {{ $color2 }}">{{ $game->teamTwo->name }}</h4></a>
                            </td>
                            <td>
                                @if ($play)
                                    <form class="form-vertical" role="form" method="post" action="{{ route('play', [$game->id]) }}">
                                       <button type="submit" {{ $play2 }} class="btn btn-primary">Play</button>
                                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                                    </form>
                                @else
                                    <h4 style="color: {{ $color }}">Play</h4>
                                @endif
                            </td>
                            <td>
                                @if ($game->team_winner_id == 0)
                                    <h4 style="color:darkgray">--</h4>
                                @else
                                    @if ($game->score == '0 -- 0' ||
                                         $game->score == '1 -- 1' ||
                                         $game->score == '2 -- 2' ||
                                         $game->score == '3 -- 3')
                                        @php $winner = ''; @endphp
                                    @else
                                        @php $winner = $game->teamWinner->name; @endphp
                                    @endif

                                    <h4 style="color: firebrick">{{ $winner }} ({{ $game->score }})</h4>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

        </div>
    </div>

  </div>
@stop
