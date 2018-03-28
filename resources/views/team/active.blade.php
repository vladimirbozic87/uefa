@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-body">

                    <form class="form-vertical" role="form" method="post" action="{{ route('post-set-team') }}">

                        <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                            <label for="active" class="control-label">Set Team Active</label>
                            <select class="form-control" name="active" id="active">
                                <option value="">--</option>
                                @foreach($teams as $team)

                                    @if(Request::old('active') == $team->id)
                                        @php $selected = "selected" @endphp
                                    @elseif($team->active == 1)
                                        @php $selected = "selected" @endphp
                                    @else
                                        @php $selected = "" @endphp
                                    @endif

                                    <option value="{{ $team->id }}" {{ $selected }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('active'))
                                <span class="help-block">{{ $errors->first('active') }}</span>
                            @endif

                        </div>

                        <br>

                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>

                </div>

            </div>

        </div>
    </div>

@stop
