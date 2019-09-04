<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="ti-menu"></i>
        </a>
        <div class="top-left-part">
            <a class="logo" href="{{ Auth::user()->grupo->home_page }}">
                <b id="logoSmall" style="display:none"><img src="{{ asset('img/logo_alt.png') }}" alt="logo" style="width:70px"/></b>
                <b id="logoNormal" style="display:none"><img src="{{ asset('img/logo.png') }}" alt="logo" style="width:170px"/></b>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li>
                <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light">
                    <i class="icon-arrow-left-circle ti-menu"></i>
                </a>
            </li>
        </ul>

        <ul class="nav navbar-top-links navbar-right pull-right">
            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <b class="hidden-xs">{{ Auth::user()->nombre }}</b>
                </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li><a href="/mi_perfil"><i class="ti-user"></i>  Mi Perfil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i>  Cerrar Sesión</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>



<!-- MENU -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            @if(Auth::check())
                @if (Auth::user()->grupo_id == 5 && Auth::user()->cliente->registro_completo)
                    <li>
                        <a href="/solicitudes" class="waves-effect">
                            <i class="fa fa-file-text-o" data-icon="v"></i>
                            <span class="hide-menu">Mis solicitudes </span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/mis_documentos" class="waves-effect">
                            <i class="fa fa-files-o" data-icon="v"></i>
                            <span class="hide-menu">Mis documentos </span>
                        </a>
                    </li>
                @elseif( Auth::user()->grupo_id == 6 )
                    <li>
                        <a href="/integrador/mis_datos" class="waves-effect">
                            <i class="ti-user" data-icon="v"></i>
                            <span class="hide-menu">Mis Datos</span>
                        </a>
                    </li>
                    <li>
                        <a href="/integrador/cotizaciones" class="waves-effect">
                            <i class="fa fa-files-o" data-icon="v"></i>
                            <span class="hide-menu">Mis Cotizaciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="/integrador/cotizaciones_preautorizadas" class="waves-effect">
                            <i class="fa fa-files-o" data-icon="v"></i>
                            <span class="hide-menu">Cotizaciones Preautorizadas</span>
                        </a>
                    </li>
                    <li>
                        <a href="/integrador/solicitudes" class="waves-effect">
                            <i class="fa fa-file-text-o" data-icon="v"></i>
                            <span class="hide-menu">Solicitudes</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="/admin/solicitudes" class="waves-effect">
                            <i class="fa fa-file-text-o" data-icon="v"></i>
                            <span class="hide-menu">Solicitudes</span>
                        </a>
                    </li>
                    @if(in_array(Auth::user()->grupo_id,[1,2]))
                        <li>
                            <a href="/admin/cotizaciones_preautorizadas" class="waves-effect">
                                <i class="fa fa-files-o" data-icon="v"></i>
                                <span class="hide-menu">Cotizaciones por preautorizar</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/preautorizadas" class="waves-effect">
                                <i class="fa fa-files-o" data-icon="v"></i>
                                <span class="hide-menu">Cotizaciones preautorizadas</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/productos" class="waves-effect">
                                <i class="fa fa-credit-card" data-icon="v"></i>
                                <span class="hide-menu">Productos</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/planes" class="waves-effect">
                                <i class="fa fa-credit-card" data-icon="v"></i>
                                <span class="hide-menu">Planes</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/razones_sociales" class="waves-effect">
                                <i class="fa fa-building-o" data-icon="v"></i>
                                <span class="hide-menu">Razones sociales</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/integradores" class="waves-effect">
                                <i class="ti-user" data-icon="v"></i>
                                <span class="hide-menu">Integradores</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/usuarios" class="waves-effect">
                                <i class="ti-user" data-icon="v"></i>
                                <span class="hide-menu">Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/configuraciones" class="waves-effect">
                                <i class="fa fa-cog" data-icon="v"></i>
                                <span class="hide-menu">Configuraciones</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endif
        </ul>
    </div>
</div>
