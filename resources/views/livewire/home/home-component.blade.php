<div>
  @if ($verifica == false)
      @livewire('cadastros.cadastro-index')
  @else

    <div class="row">
      
      <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
        <div class="card">
          <div class="card-header">
            <h3 class="greeting-text">
                {{Auth::user()->profile->gender === "female" ? "Seja bem vinda " . Auth::user()->first_name : "Seja bem vindo " . Auth::user()->first_name}}
            </h3>
            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="top"
                                            data-container="body" data-original-title="Para que serve isso?"
                                            data-content="Os lançamentos das vendas precisam ser atualizados diariamente, para o correto controle dos saldos de estoque!!"></i>
            <p class="mb-0">Foque em manter os lançamentos atualizados!</p>
          </div>
          <div class="card-body pt-0">
            <div class="d-flex justify-content-between align-items-end">
              <div class="dashboard-content-left">
                <h1 class="text-danger font-large-2 text-bold-500 mb-1">
                  <span class="alert alert-{{$detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->count() > 0 ? 'danger' : 'success'}}">
                    {{ $detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->count() }}
                  </span>
                </h1>
                @if ($detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->count() > 0)
                <p class="text-danger">Lançamentos desatualizados.</p>
                @else
                <p class="text-success">Tudo atualizado ;)</p>
                @endif
                
                <a href="{{route('extrato.index')}}" class="btn btn-outline-primary">
                  <i class="bx bx-pencil mr-1"></i>
                  Ver Lançamentos
                </a>
              </div>
              <div class="dashboard-content-right">
                @if ( $detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->count() > 0)
                  <img src="{{asset('images/emojis/emoji_gif_100px/emoji_27.gif')}}" height="155" width="155" class="img-fluid" alt="emoji" />
                @else
                  <img src="{{asset('images/emojis/emoji_gif_100px/emoji_18.gif')}}" height="155" width="155" class="img-fluid" alt="emoji" />
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="text-bold-600">Confirmações de Pedidos</h4>
            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="top"
                                            data-container="body" data-original-title="Para que serve isso?"
                                            data-content="Este indicador demonstra quantos pedidos precisam ter suas quantidades confirmadas pelo Fornecedor."></i>
            <p>Abaixo estão os pedidos que estão aguardando confirmação</p>
          </div>
          <div class="card-body pt-0">
            <div class="d-flex justify-content-between align-items-end">
              <div class="dashboard-content-left">
                <h1 class="text-danger font-large-2 text-bold-500 mb-1">
                  <span class="alert alert-{{$detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Entrada Navio")->count() > 0 ? 'danger' : 'success'}}">
                    {{ $detalhes->where("type", "forecast")->where("category", "Entrada Navio")->where("date_report","<=",date("Y-m-d", strtotime('now')))->count() }}
                  </span>
                </h1>
                @if ($detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Entrada Navio")->count() > 0)
                <p class="text-danger">Atualização(ões) pendente(s)</p>
                @else
                <p class="text-success">Nenhuma atualização pendente.</p> 
                @endif
                
                <a href="{{route('pedidos.index')}}" class="btn btn-outline-primary">
                  <i class="bx bx-pencil mr-1"></i>
                  Ver Pedidos
                </a>
              </div>
              <div class="dashboard-content-right">
                @if ($detalhes->where("type", "forecast")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Entrada Navio")->count() > 0)
                <img src="{{asset('images/emojis/emoji_gif_100px/emoji_27.gif')}}" class="img-fluid" alt="emoji" />
                @else
                <img src="{{asset('images/emojis/emoji_gif_100px/emoji_18.gif')}}" class="img-fluid" alt="emoji" />
                @endif
                
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="text-bold-600">Saldo de Empréstimos/Devoluções</h4>
            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="left"
                                            data-container="body" data-original-title="Para que serve isso?"
                                            data-content="Este indicador demonstra o saldo entre empréstimos e devoluções, em outras palavras, se a GREEN está deficitária ou não em relação aos seus parceiros."></i>
            <p>Abaixo o saldo entre o volume emprestado e devolvido.</p>
          </div>
          <div class="card-body pt-0">
            <div class="d-flex justify-content-between align-items-end">
              <div class="dashboard-content-left">
                <h1 class="text-danger font-large-2 text-bold-500 mb-1">
                  <span class="alert alert-{{ $detalhes->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Empréstimo/Devolução")->sum("qtd") > 0 ? 'danger' : 'success'}}">
                    {{ number_format($detalhes->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Empréstimo/Devolução")->sum("qtd"), 1, ",", ".") . "m³" }}
                  </span>
                </h1>
                @if ($detalhes->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Empréstimo/Devolução")->sum("qtd") > 0)
                  <p class="text-danger"><strong>A GREEN mais recebeu.</strong></p>
                @else
                  <p class="text-success"><strong>A GREEN mais emprestou.</strong></p>
                @endif
                <a href="{{route('emprestimos.index')}}" class="btn btn-outline-primary">
                  <i class="bx bx-pencil mr-1"></i>
                  Ver Empréstimos & Devoluções
                </a>
              </div>
              <div class="dashboard-content-right">
                @if ($detalhes->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime(now())))])->where("category", "Empréstimo/Devolução")->sum("qtd") > 0)
                  <img src="{{asset('images/emojis/emoji_gif_100px/emoji_27.gif')}}" class="img-fluid" alt="emoji" />
                @else
                  <img src="{{asset('images/emojis/emoji_gif_100px/emoji_18.gif')}}" class="img-fluid" alt="emoji" />
                @endif
                
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row">

      <div class="col-xl-4 col-md-6 col-12 dashboard-earning-swiper" id="widget-earnings">
        <div class="card">
          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                <i class="bx bx-store-alt font-medium-5 align-middle"></i>
                <span class="align-middle"><strong>Armazéns</strong></span>
            </h5>
            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="top"
                                            data-container="body" data-original-title="Para que serve isso?"
                                            data-content="Este quadro mostra um resumo gerencial das informações mais importantes sobre os armazéns."></i>
          </div>
          <div class="card-body py-1 px-0">
            <div class="widget-earnings-swiper swiper-container p-1">
              <div class="swiper-wrapper">
                @foreach ($armazens as $armazem)
                  <div class="swiper-slide rounded swiper-shadow py-50 px-2 d-flex align-items-center" id="store{{$armazem->id}}">
                      <i class="bx bx-pyramid mr-1 font-weight-normal font-medium-4"></i>
                      <div class="swiper-text">
                        <div class="swiper-heading">{{$armazem->name}}</div>
                        <small class="d-block">
                            {{number_format($armazem->insumos->sum("pivot.volume"), 1, ",", ".") . "m³"}}
                          </small>
                      </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="main-wrapper-content">
            @foreach ($armazens as $armazem)
            <div class="wrapper-content" data-earnings="store{{$armazem->id}}">
                <div class="widget-earnings-scroll table-responsive">
                  <table class="table table-borderless widget-earnings-width mb-0">
                    <tbody>
                        @foreach ($armazem->insumos as $insumo)
                        <tr>
                            <td class="mr-50">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <h6 class="media-heading mb-0">{{$insumo->name}}</h6>
                                  <span class="font-small-2">{{number_format($insumo->pivot->volume, 1, ",", ".") . "m³"}}</span>
                                </div>
                              </div>
                            </td>
                            <td class="px-0" style="width: 40%;">
                              <div class="activity-progress flex-grow-1">
                                <small class="text-muted d-inline-block mb-50"></small>
                                <small class="float-right">
                                  {{ $insumo->pivot->volume > 0 ?  number_format((1-($detalhes->where("armazem_id", $armazem->id)->where("insumo_id", $insumo->id)->where("date_report", "<=", date("Y-m-d", strtotime(now())))->sum("qtd")/$insumo->pivot->volume)) * 100, 1, ",", ".") . "%" : "-" }}
                                </small>
                                <div class="progress progress-bar-primary progress-sm">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" style="width:{{ $insumo->pivot->volume > 0 ?  number_format((1-($detalhes->where("armazem_id", $armazem->id)->where("insumo_id", $insumo->id)->where("date_report", "<=", date("Y-m-d", strtotime(now())))->sum("qtd")/$insumo->pivot->volume)) * 100, 0, ",", ".") . "%" : "-" }}"></div>
                                </div>
                            </div>
                              
                            </td>
                            <td class="text-right"><span class="badge badge-light-warning">
                                {{ number_format($detalhes->where("armazem_id", $armazem->id)->where("insumo_id", $insumo->id)->where("date_report", "<=", date("Y-m-d", strtotime(now())))->sum("qtd"), 1, ",", ".") . "m³" }}
                            </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-xl-8 col-12 dashboard-marketing-campaign">
        <div class="card marketing-campaigns">
          <div class="card-body pb-0">
            <div class="row">
                <div class="col-12">
                    <div class="users-list-filter px-1">
                        <form>
                          <div class="row border rounded py-2 mb-2">
                            <div class="col-1">
                                <label for="paginate">Paginação</label>
                                <fieldset class="form-group">
                                    <select class="form-control" name="paginate" id="paginate" wire:model="paginate">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <label for="search_category">Categoria</label>
                                <fieldset class="form-group">
                                    <select class="form-control" name="search_category" id="search_category" wire:model="search_category">
                                        <option value="">Todos</option>
                                        <option value="Entrada Navio">Pedidos</option>
                                        <option value="Venda">Vendas</option>
                                        <option value="Transferência">Transferências</option>
                                        <option value="Ajuste Estoque">Ajustes</option>
                                        <option value="Empréstimo/Devolução">Emprést./Devol.</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <label for="search_armazem">Armazém</label>
                                <fieldset class="form-group">
                                    <select class="form-control" name="search_armazem" id="search_armazem" wire:model="search_armazem">
                                        <option value="">Todos</option>
                                        @foreach ($armazens as $armazem)
                                        <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <label for="search_insumo">Insumo</label>
                                <fieldset class="form-group">
                                  <select class="form-control" name="search_insumo" id="search_insumo" wire:model="search_insumo">
                                    <option value="">Todos</option>
                                    @foreach ($insumos as $insumo)
                                        <option value="{{$insumo->id}}">{{$insumo->name}}</option>
                                    @endforeach
                                  </select>
                                </fieldset>
                            </div>
                            <div class="col-2">
                                <label for="search_status">Status</label>
                                <fieldset class="form-group">
                                  <select class="form-control" name="search_status" id="search_status" wire:model="search_status">
                                    <option value="">Todos</option>
                                    <option value="forecast">Previsto</option>
                                    <option value="real">Realizado</option>
                                  </select>
                                </fieldset>
                            </div>
                          </div>
                        </form>
                      </div>
                </div>
            </div>
          </div>
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="text-bold-600">Lançamentos</h4>
            <span class="badge badge-light-secondary">
              {{$allLancamentos->count()}} lançamentos
            </span>
          </div>
          <div class="table-responsive">
            <!-- table start -->
            <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
              <thead class="thead-dark">
                <tr>
                  <th>Data</th>
                  <th>Categoria</th>
                  <th>Qtde</th>
                  <th>Armazém</th>
                  <th>Insumo</th>
                  <th class="text-center">Status</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($lancamentos as $lancamento)
                <tr>
                  <td class="py-1">
                    <span>{{date("d/m/y", strtotime($lancamento->date_report))}}</span>
                  </td>
                  <td class="py-1">
                    <strong>{{$lancamento->category}}</strong>
                  </td>
                  <td class="text-{{$lancamento->qtd > 0 ? 'success' : 'danger'}}">
                    {{ number_format($lancamento->qtd, 1, ",", ".") . "m³" }}
                  </td>
                  <td class="py-1">
                    {{ $armazens->find($lancamento->armazem_id)->name }}
                  </td>
                  <td class="py-1">
                    {{ $insumos->find($lancamento->insumo_id)->name}}
                  </td>
                  <td class="text-center py-1">
                    @if ($lancamento->type === "forecast")
                      <span class="badge badge-warning">PREVISTO</span>
                    @else
                      <span class="badge badge-success">REALIZADO</span>
                    @endif
                  </td>
                </tr>
                @endforeach
 
              </tbody>
            </table>
            <div class="mt-1 px-1">
              {{$lancamentos->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
    
  @endif
</div>