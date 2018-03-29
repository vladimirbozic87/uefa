@extends('templates.default')

@section('content')

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">

                <div class="col-lg-12" style="padding-left: 44%">
                    <h3 style="margin-top: 0px"><a href="{{ route('get-create-players', [$name]) }}">{{ $name }}</a></h3>
                </div>

                <form class="form-vertical" role="form" method="post" action="{{ route('post-formation', [$name]) }}">
                    <div class="form-group{{ $errors->has('formation') ? ' has-error' : '' }}">
                        <label for="formation" class="control-label">Set Formation</label>
                        <select class="form-control" name="formation" id="formation">
                            <option value="">--</option>
                            @foreach($formations as $formation)

                                @if(Request::old('formation') == $formation->id)
                                    @php $selected = "selected" @endphp
                                @else
                                    @php $selected = "" @endphp
                                @endif

                                <option value="{{ $formation->id }}" {{ $selected }}>{{ $formation->type }}</option>
                            @endforeach

                        </select>
                        @if ($errors->has('formation'))
                            <span class="help-block">{{ $errors->first('formation') }}</span>
                        @endif
                    </div>

                    <div class="form-gorup">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>

                <br>

                @foreach ($position_array as $position)

                    @php $margin = ''; @endphp

                    @if (count($position) == 3)
                        @php $margin = '214px'; @endphp
                    @elseif (count($position) == 4)
                        @php $margin = '117px'; @endphp
                    @elseif (count($position) == 1)
                        @php $margin = '417px'; @endphp
                    @elseif (count($position) == 2)
                        @php $margin = '318px'; @endphp
                    @elseif (count($position) == 5)
                        @php $margin = '17px'; @endphp
                    @endif

                    <div class="col-lg-12" style="margin-left: {{ $margin }}">
                        <div class="container-steps">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                @foreach ($position as $player)

                                    <div class="col-xs-3 bs-wizard-step" style="width:200px">
                                        <div class="text-center bs-wizard-stepnum">{{ $player->position->position_name }}</div>
                                        <div class="progress"><div class="progress-bar"></div></div>
                                        <a href="#" class="bs-wizard-dot"></a>
                                        <div class="bs-wizard-info text-center">{{ $player->name }}</div>
                                        <div class="bs-wizard-info text-center">
                                            (<b style="color:green">quality:{{ $player->quality }}</b>,
                                            <b style="color:#117a8b">speed:{{ $player->speed }}</b>)
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </div>

@stop
