<div>
    <div class="alert bg-rgba-primary">
      <i class="bx bx-info-circle mr-1 align-middle"></i>
      <span class="align-middle">
        Abaixo estão todos os cadastros básicos que devem ser feitos na plataforma para utilizá-la da melhor forma possível. <strong>O sistema só poderá ser utilizado após a realização de todos os cadastros básicos!</strong>
      </span>
    </div>
    
    <section id="card-caps">
    
      <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-12">
          <div class="card">
            <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
            <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
              <div class="overlay-content">
                <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                  Usinas
                </h4>
                @if ($usinas->count() > 0)
                  <span class="badge badge-pill badge-success badge-up badge-round">
                    <i class="bx bx-check"></i>
                  </span>
                @else
                  <span class="badge badge-pill badge-danger badge-up badge-round">
                    <i class="bx bx-x"></i>
                  </span>
                @endif
                <p class="card-text text-ellipsis">
                  Usinas irão determinar as origens dos pedidos de insumos feitos na plataforma.
                </p>
              </div>
              <div class="overlay-status">
                <p class="mb-25 text-warning"><small>{{$usinas->count() === 0 ? "Nenhuma usina cadastrada." : $usinas->count() . " usina(s) cadastrada(s)"}}</small></p>
                <a href="{{route('usinas.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
              </div>
            </div>
          </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Armazéns
                    </h4>
                    @if ($armazens->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Armazéns são os locais de estocagens de insumos.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$armazens->count() === 0 ? "Nenhum armazém cadastrado." : $armazens->count() . " armazém(ns) cadastro(s)"}}</small></p>
                    <a href="{{route('armazens.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Fornecedores
                    </h4>
                    @if ($fornecedores->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Aqui é controlado o cadastro dos responsáveis pelo fornecimento de insumos.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$fornecedores->count() === 0 ? "Nenhum fornecedor cadastrado." : $fornecedores->count() . " fornecedor(s) cadastro(s)."}}</small></p>
                    <a href="{{route('fornecedores.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Clientes
                    </h4>
                    @if ($clientes->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Faça o cadastro dos seus clientes para gestão das vendas no sistema.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$clientes->count() === 0 ? "Nenhum cliente cadastrado." : $clientes->count() . " cliente(s) cadastro(s)."}}</small></p>
                    <a href="{{route('clientes.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    
      <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-12">
          <div class="card">
            <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
            <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
              <div class="overlay-content">
                <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                  Insumos
                </h4>
                @if ($insumos->count() > 0)
                  <span class="badge badge-pill badge-success badge-up badge-round">
                    <i class="bx bx-check"></i>
                  </span>
                @else
                  <span class="badge badge-pill badge-danger badge-up badge-round">
                    <i class="bx bx-x"></i>
                  </span>
                @endif
                <p class="card-text text-ellipsis">
                  Insumos são os produtos objeto de controle desta plataforma.
                </p>
              </div>
              <div class="overlay-status">
                <p class="mb-25 text-warning"><small>{{$insumos->count() === 0 ? "Nenhum insumo cadastrado." : $insumos->count() . " insumo(s) cadastro(s)."}}</small></p>
                <a href="{{route('insumos.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
              </div>
            </div>
          </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Produtos
                    </h4>
                    @if ($produtos->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Produtos são os objetos das vendas. Um produto é formado por um ou mais insumos.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$produtos->count() === 0 ? "Nenhum insumo cadastrado." : $produtos->count() . " insumo(s) cadastro(s)."}}</small></p>
                    <a href="{{route('produtos.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Tancagem
                    </h4>
                    @if ($tancagens->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Tancagem é a capacidade (limites) de estocagem de cada armazém.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$tancagens->count() === 0 ? "Nenhum tancagem cadastrada." : $tancagens->count() . " tancagens cadastradas."}}</small></p>
                    <a href="{{route('tancagem.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card">
                <img class="card-img img-fluid" src="{{asset('images/slider/08.jpg')}}" alt="Card image">
                <div class="card-img-overlay overlay-dark d-flex justify-content-between flex-column">
                <div class="overlay-content">
                    <h4 class="text-bold-600 white mb-50 position-relative d-inline-block mr-2">
                      Pedidos
                    </h4>
                    @if ($pedidos->count() > 0)
                      <span class="badge badge-pill badge-success badge-up badge-round">
                        <i class="bx bx-check"></i>
                      </span>
                    @else
                      <span class="badge badge-pill badge-danger badge-up badge-round">
                        <i class="bx bx-x"></i>
                      </span>
                    @endif
                    <p class="card-text text-ellipsis">
                    Pedidos são solicitações de insumos para recomposição de saldo dos armazéns.
                    </p>
                </div>
                <div class="overlay-status">
                    <p class="mb-25 text-warning"><small>{{$pedidos->count() === 0 ? "Nenhum pedido realizado." : $pedidos->count() . " pedido(s) realizado(s)."}}</small></p>
                    <a href="{{route('pedidos.index')}}" class="btn btn-outline-info">Ver Cadastro</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>