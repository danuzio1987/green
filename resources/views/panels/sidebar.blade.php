<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">

  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
            <div class="brand-logo">
              <img src="{{asset('images/logo/icone_green.png')}}" class="logo" alt="" width="30" height="30">
            </div>
            <h2 class="brand-text mb-0 text-secondary">
              GREEN
            </h2>
          </a>
        </li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="bx bx-x d-block d-xl-none font-medium-4 secondary"></i>
            <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block secondary" data-ticon="bx-disc"></i>
          </a>
        </li>
    </ul>
  </div>

  <div class="shadow-bottom"></div>
  
  <div class="main-menu-content">

    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines"> 
      
        <li class="nav-item {{request()->route()->getPrefix() == '/dashboards' ? 'active' : '' }}">
          <a href="#">
              <i class="menu-livicon" data-icon="dashboard"></i>
              <span class="menu-title text-truncate">Dashboard</span>
          </a>
          {{-- vertical-menu-submenu --}}
          <ul class="menu-content">
            {{-- 
              <li {{ Route::currentRouteName() === "geral" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/geral')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Geral</span>
                </a>
              </li>
              --}}
              <li {{ Route::currentRouteName() === "vilarinho" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/armazens')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Controle de Estoque</span>
                </a>
              </li>
              <li {{ Route::currentRouteName() === "sales" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/sales')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Controle de Vendas</span>
                </a>
              </li>
              <li {{ Route::currentRouteName() === "disponibilidades" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/disponibilidades')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Disponibilidades</span>
                </a>
              </li>
              <li {{ Route::currentRouteName() === "transfers" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/transfers')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Transferências</span>
                </a>
              </li>
              <li {{ Route::currentRouteName() === "extrato.index" ? 'class=active' : '' }}>
                <a href="{{url('/dashboards/extrato')}}"  class="d-flex align-items-center">
                  <i class="bx bx-right-arrow-alt"></i>
                  <span class="menu-item text-truncate">Lançamentos</span>
                </a>
              </li>
          </ul>
        </li>

        @hasanyrole('Super Admin|Admin|Operação')

        <li class="navigation-header text-truncate"><span>Cadastros</span></li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/usinas')}}">
              <i class="menu-livicon" data-icon="building"></i>
              <span class="menu-title text-truncate">Usinas</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/armazens')}}">
              <i class="menu-livicon" data-icon="morph-glass"></i>
              <span class="menu-title text-truncate">Armazéns</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/fornecedores')}}">
              <i class="menu-livicon" data-icon="truck"></i>
              <span class="menu-title text-truncate">Fornecedores</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/clientes')}}">
              <i class="menu-livicon" data-icon="piggybank"></i>
              <span class="menu-title text-truncate">Clientes</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/insumos')}}">
              <i class="menu-livicon" data-icon="lab"></i>
              <span class="menu-title text-truncate">Insumos</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/produtos')}}">
              <i class="menu-livicon" data-icon="drop"></i>
              <span class="menu-title text-truncate">Produtos</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "geral" ? 'active' : '' }}">
          <a href="{{url('/cadastros/tancagem')}}">
              <i class="menu-livicon" data-icon="battery-full"></i>
              <span class="menu-title text-truncate">Tancagem</span>
          </a>
        </li>

        <li class="navigation-header text-truncate"><span>MOVIMENTOS</span></li>

        <li class="nav-item {{ Route::currentRouteName() === "pedidos.index" ? 'active' : '' }}">
          <a href="{{url('/pedidos/pedidos')}}">
              <i class="menu-livicon" data-icon="notebook"></i>
              <span class="menu-title text-truncate">Meus Pedidos</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "vendas.index" ? 'active' : '' }}">
          <a href="{{url('/movimentos/vendas')}}">
              <i class="menu-livicon" data-icon="coins"></i>
              <span class="menu-title text-truncate">Vendas</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "transferencias.index" ? 'active' : '' }}">
          <a href="{{url('/movimentos/transferencias')}}">
              <i class="menu-livicon" data-icon="magic"></i>
              <span class="menu-title text-truncate">Transferências</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "ajustes.index" ? 'active' : '' }}">
          <a href="{{url('/movimentos/ajustes')}}">
              <i class="menu-livicon" data-icon="retweet"></i>
              <span class="menu-title text-truncate">Ajustes</span>
          </a>
        </li>

        <li class="nav-item {{ Route::currentRouteName() === "emprestimos.index" ? 'active' : '' }}">
          <a href="{{url('/movimentos/emprestimos')}}">
              <i class="menu-livicon" data-icon="swap-horizontal"></i>
              <span class="menu-title text-truncate">Empr./Dev.</span>
          </a>
        </li>

        @endhasanyrole

        <li class="navigation-header text-truncate"><span>Configurações</span></li>

        <li class="nav-item {{ Route::currentRouteName() === "perfil.index" ? 'active' : '' }}">
          <a href="{{url('/configuracoes/perfil')}}">
              <i class="menu-livicon" data-icon="user"></i>
              <span class="menu-title text-truncate">Meu Perfil</span>
          </a>
        </li>

        @role('Super Admin')
        <li class="nav-item {{ Route::currentRouteName() === "acesso.index" ? 'active' : '' }}">
          <a href="{{url('/configuracoes/acesso')}}">
              <i class="menu-livicon" data-icon="wrench"></i>
              <span class="menu-title text-truncate">Níveis de Acesso</span>
          </a>
        </li>
        @endrole

    </ul>

    {{-- 
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
        <li class="navigation-header text-truncate"><span>Resumo</span></li>
      
        <li class="nav-item {{ Route::currentRouteName() === "home" ? 'active' : '' }}">
          <a href="">
                  <i class="bx bx-save"></i>
                  <span class="menu-title text-truncate">Nome do menu</span>
          </a>
        </li>
    </ul>
    --}}




  </div>
</div>
