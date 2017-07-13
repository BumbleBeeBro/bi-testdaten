<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button aria-expanded="false" class="navbar-toggle collapsed" data-target="#navbar-1" data-toggle="collapse" type="button">
                <span class="sr-only">
                    Toggle navigation
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
            </button>
            <a class="navbar-brand" href="#">
                BI-Testdaten
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-1">
            <ul class="nav navbar-nav">
                <!-- Startseite -->
                @if(Request::url() === Request::root())
                <li class="active">
                @else
                <li>
                @endif
                    <a href="/">
                        Simulation
                        <span class="sr-only">
                            (current)
                        </span>
                    </a>
                </li>
                <!-- Clipboard -->
                @if(Request::url() === Request::root() . '/picks')
                <li class="active">
                @else
                <li>
                @endif
                    <a href="/picks">
                        Ergebnisse
                        <span class="sr-only">
                            (current)
                        </span>
                    </a>
                </li>
{{--                 <!-- Kontakt -->
                @if(Request::url() === Request::root() . '/contact')
                <li class="active">
                @else
                <li>
                @endif
                    <a href="/contact">
                        Contact
                        <span class="sr-only">
                            (current)
                        </span>
                    </a>
                </li> --}}
                <!-- Impressum -->
                @if(Request::url() === Request::root() . '/inmprint')
                <li class="active">
                @else
                <li>
                @endif
                    <a href="/imprint">
                        Impressum
                        <span class="sr-only">
                            (current)
                        </span>
                    </a>
                </li>
                <!-- Datenschutz -->
                @if(Request::url() === Request::root() . '/privacy')
                <li class="active">
                @else
                <li>
                @endif
                    <a href="/privacy">
                        Datenschutz
                        <span class="sr-only">
                            (current)
                        </span>
                    </a>
                </li>
                {{-- <li>
                    <form class="navbar-form">
                        <div class="form-group">
                            <input class="form-control" placeholder="Search" type="text">
                            </input>
                        </div>
                        <button class="btn btn-default" type="submit">
                            Submit
                        </button>
                    </form>
                </li> --}}
            </ul>
            <!-- Dropdown für login -->
{{--             <ul class="nav navbar-nav navbar-right">
            @if (!auth()->check())
                <li class="dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                        Login
                        <span class="caret">
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <form action="/login" class="navbar-form" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" name="usernameLogin" placeholder="Username" type="text">
                                </input>
                            </div>
                            <!-- Input group -->
                            <div class="input-group">
                                <input class="form-control" name="passwordLogin" placeholder="Passwort" type="password">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
                                            Login
                                        </button>
                                    </span>
                                </input>
                            </div>
                            <!-- /input-group -->
                        </form>
                    </ul>
                </li>
                @else
                <li>
                    <h5 class="navbar-text">
                        {{ auth()->user()->username}}
                    </h5>
                </li>
                <li>
                    <form action="/logout" class="navbar-form" method="post">
                        {{ csrf_field() }}
                        <button class="btn btn-default" type="submit">
                            Logout
                        </button>
                    </form>
                </li>
                @endif
            </ul> --}}
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<!-- navbar ende -->
