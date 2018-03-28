@extends('templates.default')

@section('content')

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">

                <form class="form-vertical" role="form" method="post" action="{{ route('post-formation', [$name, $game_id]) }}">
                    <div class="form-group{{ $errors->has('formation') ? ' has-error' : '' }}">
                        <label for="formation" class="control-label">Set Formation</label>
                        <select class="form-control" name="formation" id="formation">
                            <option value="">--</option>
                            <option value="1">5-4-1</option>
                            <option value="2">4-4-2</option>
                            <option value="3">3-4-3</option>
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

                @foreach ($formation as $form)

                    @php $margin = ''; @endphp

                    @if ($form->no_of_players == 3)
                        @php $margin = '214px'; @endphp
                    @elseif ($form->no_of_players == 4)
                            @php $margin = '117px'; @endphp
                    @elseif ($form->no_of_players == 1)
                        @php $margin = '417px'; @endphp
                    @elseif ($form->no_of_players == 2)
                        @php $margin = '318px'; @endphp
                    @elseif ($form->no_of_players == 5)
                        @php $margin = '17px'; @endphp
                    @endif

                    <div class="col-lg-12" style="margin-left: {{ $margin }}">
                        <div class="container-steps">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                @for ($i=0; $i<$form->no_of_players; $i++)

                                    <div class="col-xs-3 bs-wizard-step" style="width:200px">
                                      <div class="text-center bs-wizard-stepnum">{{ $form->position->position_name }}</div>
                                      <div class="progress"><div class="progress-bar"></div></div>
                                      <a href="#" class="bs-wizard-dot"></a>
                                      <div class="bs-wizard-info text-center">{{ $form->players[$i]->name }}</div>
                                    </div>

                                @endfor

                            </div>
                        </div>
                    </div>

                    <br><br>

                @endforeach

            </div>
        </div>
    </div>

@stop
