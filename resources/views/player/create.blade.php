@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-body">


                    <table class="table table-striped">
                        <thead>
                        @if (count($players) > 0)
                            <tr>
                                <th style="color: white; background-color: #005cbf" align="center">Player Name</th>
                                <th style="color: white; background-color: #005cbf" align="center">Player Position</th>
                                <th style="color: white; background-color: #005cbf" align="center">Player Quality</th>
                                <th style="color: white; background-color: #005cbf" align="center">Player Speed</th>
                            </tr>
                        @endif
                        </thead>
                        <tbody>
                        @foreach ($players as $player)

                            @if ($player->injured == 1)
                                @php
                                    $color   = 'red';
                                    $injured = '(injured)';
                                @endphp
                            @else
                                @php
                                    $color = 'black';
                                    $injured = '';
                                @endphp
                            @endif

                            <tr>
                                <td style="color: {{ $color }};">
                                  {{ $player->name }} {{ $injured }}
                                </td>
                                <td>
                                  {{ $player->position->position_name }}
                                </td>
                                <td>
                                    <div class="progress" style="margin-bottom: 0px;">
                                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ $player->quality * 10 }}%">
                                            {{ $player->quality }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress" style="margin-bottom: 0px;">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ $player->speed * 10 }}%">
                                            {{ $player->speed }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <br>

                    @if (count($players) < 22)

                    <form class="form-vertical" role="form" method="post" action="{{ route("post-create-players", [$name]) }}">

                        <div class="col-lg-3">

                            <div class="form-group{{ $errors->has('player_name') ? ' has-error' : '' }}">
                                <label for="player_name" class="control-label">Player Name</label>
                                <input type="text" name="player_name" class="form-control" id="player_name" value="{{ Request::old('player_name') ?: '' }}">
                                @if ($errors->has('player_name'))
                                    <span class="help-block">{{ $errors->first('player_name') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-lg-2">

                            <div class="form-group{{ $errors->has('player_position') ? ' has-error' : '' }}">
                                <label for="player_position" class="control-label">Player Position</label>
                                <select class="form-control" name="player_position" id="player_position">
                                    <option value="">--</option>
                                    @foreach($player_positions as $player_position)

                                        @if(Request::old('player_position') == $player_position->id)
                                            @php $selected = "selected" @endphp
                                        @else
                                            @php $selected = "" @endphp
                                        @endif

                                        <option value="{{ $player_position->id }}" {{ $selected }}>{{ $player_position->position_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('player_position'))
                                    <span class="help-block">{{ $errors->first('player_position') }}</span>
                                @endif

                            </div>

                        </div>
                        <div class="col-lg-2">

                            <div class="form-group{{ $errors->has('player_quality') ? ' has-error' : '' }}">
                                <label for="player_quality" class="control-label">Player Quality</label>
                                <input type="text" name="player_quality" class="form-control" placeholder="from 1 to 10" id="player_quality" value="{{ Request::old('player_quality') ?: '' }}">
                                @if ($errors->has('player_quality'))
                                    <span class="help-block">{{ $errors->first('player_quality') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-lg-2">

                            <div class="form-group{{ $errors->has('player_speed') ? ' has-error' : '' }}">
                                <label for="player_speed" class="control-label">Player Speed</label>
                                <input type="text" name="player_speed" class="form-control" placeholder="from 1 to 10" id="player_speed" value="{{ Request::old('player_speed') ?: '' }}">
                                @if ($errors->has('player_speed'))
                                    <span class="help-block">{{ $errors->first('player_speed') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-lg-3" style="padding-top: 24px">
                            <div class="form-gorup">
                                <button type="submit" class="btn btn-primary" id="add">Add Player</button>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>

                   @endif

                </div>

            </div>

        </div>
    </div>

@stop
