<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">

            @php $show_team = \App\Team::where('active', 1)->get()->first(); @endphp

            @if (count($show_team))

                @php $owner = "" @endphp

                @if ($show_team->owner == 1)

                    @php $owner = "My Team" @endphp

                @endif

                <a href="{{ route('get-create-players', [$show_team->name]) }}" class="navbar-brand"><b style="color:firebrick">{{ $owner }}</b> {{ $show_team->name }}</a>
            @endif
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

                @if (count(\App\Team::all()) == 4)
                    <li><a href="{{ route('get-play-game') }}">Play Game</a></li>
                @endif
                @if (count(\App\Team::all()) < 4)
                    <li><a href="{{ route('get-team') }}">Create Team</a></li>
                @endif
                @if (count(\App\Team::all()) > 1)
                    <li><a href="{{ route('get-set-team') }}">Set Active Team</a></li>
                @endif

            </ul>
        </div>
    </div>
</nav>