<nav class="navbar navbar-default navbar-static-top">
    <div class="navbar-header">
        @include('layouts._logo_block')
        @include('layouts._phone_block')
        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        @include('layouts._phone_block')
        <ul class="nav navbar-nav">
            @foreach($data as $k => $item)
                @if($item->on_menu)
                    <li class="main-menu">
                        <a {{ !$k ? 'class=active' : '' }} href="#{{ str_slug($item->name) }}" data-scroll="{{ str_slug($item->name) }}">{{ $item->name }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
        @include('layouts._logo_block')
    </div>
</nav>