{{-- navabar  --}}
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu
@if(isset($configData['navbarType'])){{$configData['navbarClass']}} @endif"
data-bgcolor="@if(isset($configData['navbarBgColor'])){{$configData['navbarBgColor']}}@endif">
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="navbar-collapse" id="navbar-mobile">

          <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav">
              <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
              <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route("pedidos.lista")}}" data-toggle="tooltip" data-placement="top" title="Pedidos"><i class="bx bxs-ship"></i></a></li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route('vendas.index')}}" data-toggle="tooltip" data-placement="top" title="Vendas"><i class="bx bx-money"></i></a></li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route('transferencias.index')}}" data-toggle="tooltip" data-placement="top" title="Transferências"><i class="bx bx-transfer"></i></a></li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{route('ajustes.index')}}" data-toggle="tooltip" data-placement="top" title="Ajustes"><i class="bx bxs-droplet-half"></i></a></li>
            </ul>
          </div>

          <ul class="nav navbar-nav float-right">
            
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
            
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
               
                <i class="ficon bx bx-bell {{Auth::user()->unreadNotifications->count() > 0 ? 'bx-tada bx-flip-horizontal' : '' }}"></i>
                @if (Auth::user()->unreadNotifications->count() > 0)
                <span class="badge badge-pill badge-danger badge-up">{{Auth::user()->unreadNotifications->count()}}</span>
                @endif
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                <li class="dropdown-menu-header">
                  <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
                    <span class="notification-title">
                      @if (Auth::user()->unreadNotifications->count() == 1)
                        {{Auth::user()->unreadNotifications->count() . " nova notificação"}}
                      @elseif(Auth::user()->unreadNotifications->count() > 1)
                        {{Auth::user()->unreadNotifications->count() . " novas notificações"}}
                      @else
                          Sem novas notificações.
                      @endif
                    </span>
                    <span class="text-bold-400 cursor-pointer">Marcar todas como lidas</span></div>
                </li>

                <li class="scrollable-container media-list">

                  @if (isset(Auth::user()->unreadNotifications))
                    @foreach (Auth::user()->unreadNotifications as $notification)
                    <a class="d-flex justify-content-between" href="javascript:void(0)">
                      <div class="media d-flex align-items-center">
                        <div class="media-left pr-0">
                          <div class="avatar mr-1 m-0"><img src="{{asset('storage/avatars/' . $notification->data[0]['avatar'])}}" alt="avatar" height="39" width="39"></div>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">
                            <span class="text-bold-500">{{ $notification->data['usuario'] }}</span> {{$notification->data['mensagem']}}
                          </h6>
                          <small class="notification-text">{{ date("d/m/y H:i", strtotime($notification->created_at)) }}</small>
                        </div>
                      </div>
                    </a>
                    @endforeach
                  @endif

                </li>

                <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Ver todas as notificações</a></li>

              </ul>
            </li>

            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <div class="user-nav d-sm-flex d-none">
                  <span class="user-name">
                    {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                  </span>
                  @if ( auth()->user()->getRoleNames()->first() === "Super Admin")
                    <span class="badge badge-warning">
                      {{--
                      {{ App\Models\User::findOrFail(Auth::user()->id)->getRoleNames()->first()}}
                      --}}
                      {{auth()->user()->getRoleNames()->first()}}
                    </span>
                  @elseif( auth()->user()->getRoleNames()->first() === "Admin")
                    <span class="badge badge-success">
                      {{auth()->user()->getRoleNames()->first()}}
                    </span>
                  @elseif( auth()->user()->getRoleNames()->first() === "Diretoria")
                    <span class="badge badge-primary">
                      {{auth()->user()->getRoleNames()->first()}}
                    </span>
                  @else
                    <span class="badge badge-danger">
                      {{auth()->user()->getRoleNames()->first()}}
                    </span>
                  @endif
                  
                </div>
                <span><img class="round" src="{{asset('storage/avatars/'.Auth::user()->profile->avatar)}}" alt="avatar" height="40" width="40"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right pb-0">
                <a class="dropdown-item" href="{{route('perfil.index')}}">
                  <i class="bx bx-user mr-50"></i>
                  Meu Perfil
                </a>
                <div class="dropdown-divider mb-0"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bx bx-power-off mr-50"></i> Sair
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </div>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
</nav>
