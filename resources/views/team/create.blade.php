@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-body">

                    <form class="form-vertical" role="form" method="post" action="{{ route('post-team') }}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Team Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ Request::old('name') ?: '' }}">
                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        @if (count($team) == 0)
                            <div class="form-check">
                                <input type="checkbox" disabled checked class="form-check-input" name="owner" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">My Team</label>
                            </div>
                        @endif

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
