<div class="row">
    
    @if ($verifica == false)
      @livewire('cadastros.cadastro-index')
    @else

    <div wire:loading>
        <div style="display: flex; justify-content: center; align-items: center; background-color:#67bd52; position: fixed; top:0px; left:0px; z-index: 9999; width:100%; height:100%; opacity:.9;">
            @include('panels.loading')
        </div>
    </div>

    {{-- GRÁFICO DOS TANQUES --}}

    {{-- 
    <div class="col-12 p-5">
        <div class="container">
            <div class="row p-0 m-0">
                @foreach ($actual_armazem->insumos as $insumo)
                <div class="col-2 mb-3">
                    <div class="bart-section">
                        <div class="bar-chart tube-1" data-info="77%" data-insumo="{{$insumo->name}}">
                            <span></span>
                            <span style="height: {{$insumo->pivot->volume > 0 ? ($insumo->pivot->volume / ($insumo->pivot->volume + $insumo->pivot->lastro))*100 . "%" : "0%"}};" data-dan="blue"></span>
                            <span style="height: {{$insumo->pivot->volume > 0 ? ($insumo->pivot->lastro / ($insumo->pivot->volume + $insumo->pivot->lastro))*100 . "%" : "0%"}};"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    --}}

    {{--
    <div class="col-12">
        <div class="row">

            @foreach ($actual_armazem->insumos as $insumo)
            <div class="col-2 my-2">
                <div class="tube">
                    <div class="shine"></div>
                    <div class="body">
                        <div class="liquid">
                            <div class="percentage" style="height: 20%;"></div>
                        </div>
                    </div>
                    <div class="meter">
                        <div>100</div>
                        <div>80</div>
                        <div>60</div>
                        <div>40</div>
                        <div>20</div>
                    </div>
                    <div class="bubbles">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                  </div>
            </div>
            @endforeach

        </div>
    </div>
    --}}


    <div class="col-12">
        <div class="row">
            <div class="col-9">
                <div class="row">

                    <div class="col-4">
                      <div class="card text-center">
                        <div class="card-body">
                          <h2 class="text-bold-600">
                              {{$actual_armazem->name}}
                          </h2>
                          <p class="text-muted mb-0 line-ellipsis">Capacidade</p>
                          <h4 class="mb-0">
                              {{ number_format($actual_armazem->insumos->sum('pivot.volume'), 1, ",", ".") }}<small class="text-muted">m³</small>
                          </h4>
                        </div>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="card text-center">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-8">
                                    <div class="text-left p-2">
                                        <h5 class="font-medium-2 text-bold-600">Saldo</h5>
                                        <p class="text-muted">Todos os insumos até hoje</p>
                                        <h4>
                                            {{ number_format($actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime(now())))->where("type", "real")->sum("qtd"), 1, ",", ".") }}
                                            <small class="text-muted">m³ ({{$actual_armazem->insumos->sum('pivot.volume') > 0 ? number_format($actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime(now())))->where("type", "real")->sum("qtd") / $actual_armazem->insumos->sum('pivot.volume') * 100, 1, ",", ".") . "%" : "0,0%" }})</small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-4">
                                    @if ( $actual_armazem->insumos->sum('pivot.volume') > 0 && ($actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime(now())))->where("type", "real")->sum("qtd") / $actual_armazem->insumos->sum('pivot.volume')) > 0.5 )
                                        <img src="{{asset('images/emojis/emoji_gif_100px/emoji_18.gif')}}" alt="">
                                    @elseif( $actual_armazem->insumos->sum('pivot.volume') > 0 && ($actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime(now())))->where("type", "real")->sum("qtd") / $actual_armazem->insumos->sum('pivot.volume')) <= 0.5 && ($actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime(now())))->where("type", "real")->sum("qtd") / $actual_armazem->insumos->sum('pivot.volume')) > 0.2 )
                                        <img src="{{asset('images/emojis/emoji_gif_100px/emoji_5.gif')}}" alt="">
                                    @else
                                        <img src="{{asset('images/emojis/emoji_gif_100px/emoji_24.gif')}}" alt="">
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-4">
                        <div class="card text-center ">
                          <div class="card-body p-0">
                              <div class="row">
                                  <div class="col-8">
                                      <div class="text-left p-2">
                                          <h5 class="font-medium-2 text-bold-600">Lançamentos</h5>
                                          <p class="text-muted">De ontem para trás</p>
                                          <h4 class="{{ $actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->where("type", "forecast")->count() > 1 ? 'text-danger' : 'text-success'}}">
                                              <span class="text-bold-600">{{ $actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->where("type", "forecast")->where("category", "!=", "Venda")->count() }}</span>
                                              <small class="text-muted">desatualizados</small>
                                          </h4>
                                      </div>
                                  </div>
                                  <div class="col-4">
                                      @if ( $actual_armazem->details->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->where("type", "forecast")->where("category", "!=", "Venda")->count() > 1 )
                                          <img src="{{asset('images/emojis/emoji_gif_100px/emoji_27.gif')}}" alt="">
                                      @else
                                          <img src="{{asset('images/emojis/emoji_gif_100px/emoji_9.gif')}}" alt="">
                                      @endif
                                      
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>

                  </div>
            </div>
            <div class="col-3">
                <div class="card invoice-action-wrapper shadow-none border">
                  <div class="card-body p-50">
                    <div class="invoice-action-btn">
                        <div class="form-group">
                            <select class="form-control" name="armazem_id" id="armazem_id" wire:model.defer="armazem_id">
                                <option value="" selected hidden>Selecione um Armazem</option>
                                @foreach ($armazens as $armazem)
                                    <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                @endforeach
                            </select>
                            @error('armazem_id')
                                <span class="text-danger">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="invoice-action-btn">
                        <div class="form-group">
                            <input type="month" class="form-control" wire:model.defer="report_date">
                            @error('report_date')
                                <span class="text-danger">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div> 
                    </div>
                    <div class="invoice-action-btn">
                        <a href="" wire:click.prevent="updateDashboard" class="btn btn-primary btn-block glow users-list-clear mb-0">
                            Atualizar
                        </a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- gráfico de acompanhamento diário -->
    <div class="col-12">
        <div class="card">
            <div class=" alert border-info alert-dismissible m-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle"></i>
                    <span>
                        <strong>ACOMPANHAMENTO DIÁRIO DE MOVIMENTAÇÃO DE ESTOQUE</strong>
                    </span>
                    {{--
                    <div class="heading-elements">
                        <ul class="list-inline my-auto text-muted">
                            <li class="mr-50">Legenda: </li>
                            <li class="mr-50"><i class="bx bxs-circle danger font-small-1 mr-50"></i>Estoque Negativo </li>
                            <li class="mr-1"><i class="bx bxs-circle font-small-1 mr-50" style="color: black;"></i>Capac. Máx. Estoque </li>
                            <li class="mr-50"><i class="bx bxs-circle success font-small-1 mr-50"></i>Recebidos </li>
                            <li class="mr-50"><i class="bx bxs-circle warning font-small-1 mr-50"></i>Venda Real </li>
                            <li class="mr-1"><i class="bx bxs-circle font-small-1 mr-50" style="color: yellow;"></i>Ajustes </li>
                            <li class="mr-1"><i class="bx bxs-circle font-small-1 mr-50" style="color: blue;"></i>Empréstimos </li>
                        </ul>
                    </div>
                    --}}
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around align-items-center flex-wrap">

                    @foreach ($actual_armazem->insumos as $insumo)
                        <div class="table-responsive mb-2">
                            <table class="table table-borderless table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr style="border-bottom: none;">
                                        <th scope="col"  class="text-center">
                                            <h6 class="text-bold-600 white">{{$insumo->name}}</h6>
                                            <small>{{number_format($insumo->pivot->volume, 1, ",", ".") . "m³"}}</small>
                                        </th>
                                        <th scope="col"  class="text-center">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center">
                                                    <p class="mb-0">
                                                        Acum. Anterior
                                                    </p>
                                                </div>
                                            </div>
                                        </th>
                                        @foreach ($labels as $label)
                                            <th scope="col text-center">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="text-center">
                                                        <p class="mb-0">{{ date("d/M", strtotime($label)) }}</p>
                                                        <small>{{ date("D", strtotime($label)) }}</small>
                                                    </div>
                                                </div>
                                                
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- AJUSTE DE ESTOQUE --}}
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">Ajuste de Estoque</th>
                                        <td class="{{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') < 0  ? 'bg-rgba-danger' : ''}} {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0  ? 'bg-rgba-success' : ''}}" >
                                            <small>
                                                {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ",", ".") . "m³" : "" }}
                                            </small>
                                        </td>
                                        @foreach ($labels as $index => $data)
                                            <td class="{{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') < 0  ? 'bg-rgba-danger' : ''}} {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0  ? 'bg-rgba-success' : ''}}">
                                                <small class="text-bold-600">
                                                    <a href="" data-toggle="modal" data-target="#modalAjuste">
                                                        {{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Ajuste Estoque')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ',', '.') . "m³" : '' }}
                                                    </a>
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- PEDIDOS --}}
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">Entrada Navio/CTs</th>
                                        <td class="{{$detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? 'bg-rgba-success' : ''}} {{$detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') < 0 ? 'bg-rgba-danger' : ''}}">
                                            <small>
                                                {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ",", ".") . "m³" : "" }}
                                            </small>
                                        </td>
                                        @foreach ($labels as $index => $data)
                                            <td class="{{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? 'bg-rgba-success' : '' }}">
                                                <small class="text-bold-600">
                                                    <a href="" wire:click.prevent="filtraNavio({{$index}}, {{$insumo->id}}, {{$armazem_id}})">
                                                        {{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Entrada Navio')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ',', '.') . "m³" : '' }}
                                                    </a>
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- EMPRÉSTIMOS & DEVOLUÇÕES --}}
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">Empréstimos/Devoluções</th>
                                        <td style="{{array_sum($amounts_mes_anterior[$insumo->id]["Empréstimo/Devolução"]) != 0 ? 'background: blue; color: white;' : ''}}">
                                            <small>
                                                {{array_sum($amounts_mes_anterior[$insumo->id]["Empréstimo/Devolução"]) != 0 ? number_format(array_sum($amounts_mes_anterior[$insumo->id]["Empréstimo/Devolução"]), 1, ",", ".") . "m³" : "-"}}
                                            </small>
                                        </th>
                                        @foreach ($amounts[$insumo->id]["Empréstimo/Devolução"] as $emprestimo)
                                            <td style="{{ $emprestimo != 0 ? 'background: blue; color: white;' : ''}}">
                                                <small class="text-bold-600">
                                                    <a href="" data-toggle="modal" data-target="#modalEmprestimo">
                                                        {{$emprestimo != 0 ? number_format($emprestimo, 1, ",", ".") . "m³" : "-"}}
                                                    </a>
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- VENDAS --}}
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">Vendas</th>
                                        <td class="{{ date("Y-m-d", strtotime('-1 day', strtotime($start))) <= date("Y-m-d", strtotime(now())) ? "bg-warning white" : '' }}">
                                            <small>
                                                {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ",", ".") . "m³" : '' }}
                                            </small>
                                        </th>
                                        @foreach ($labels as $index => $data)
                                            <td class="{{ date("Y-m-d", strtotime($data)) <= date("Y-m-d", strtotime('-1 day', strtotime(now()))) ? "bg-warning white" : '' }}">
                                                <small class="text-bold-600">
                                                    @if ( date("Y-m-d", strtotime($data)) <= date("Y-m-d", strtotime('-1 day', strtotime(now()))))
                                                        <a href="" data-toggle="modal" data-target="#modalVenda" class="white">
                                                            {{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->where("type", "real")->sum('qtd') != 0 ? number_format($detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->where("type", "real")->sum('qtd'), 1, ',', '.') . "m³" : '' }}
                                                        </a>
                                                    @else
                                                        <a href="" data-toggle="modal" data-target="#modalVenda">
                                                            {{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') != 0 ? number_format($detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Venda')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ',', '.') . "m³" : '' }}
                                                        </a>
                                                    @endif
                                                    
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- TRANSFERÊNCIAS --}}
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">Transferências</th>
                                        <td class="">
                                            <small>
                                                {{ $detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') > 0 ? number_format($detalhes->where("date_report", "<", date("Y-m-d", strtotime($start)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ",", ".") . "m³" : "" }}
                                                {{--
                                                {{array_sum($amounts_mes_anterior[$insumo->id]["Transferência"]) != 0 ? number_format(array_sum($amounts_mes_anterior[$insumo->id]["Transferência"]), 1, ",", ".") . "m³" : "-"}}
                                                --}}
                                            </small>
                                        </th>
                                        @foreach ($labels as $index => $data)
                                            <td class="{{$detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd')>0 ? 'bg-rgba-success' : ''}} {{$detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd')<0 ? 'bg-rgba-danger' : ''}}">
                                                <small class="text-bold-600">
                                                    <a href="" data-toggle="modal" data-target="#modalTransferencia">
                                                        {{ $detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd') != 0 ? number_format($detalhes->where("date_report", date("Y-m-d", strtotime($data)))->where("category", 'Transferência')->where("insumo_id", $insumo->id)->where("armazem_id", $armazem_id)->sum('qtd'), 1, ',', '.') . "m³" : '' }}
                                                    </a>
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- LASTRO --}}
                                    <tr>
                                        <th class="text-center bg-rgba-secondary text-secondary" scope="row">
                                            Lastro
                                            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                            data-container="body" data-original-title="Como chegar neste número?"
                                            data-content="Este volume é informado durante a definição da tancagem."></i>
                                        </th>
                                        <th class="bg-rgba-secondary">-</th>
                                        @foreach ($amounts[$insumo->id]["Transferência"] as $transferencia)
                                            <td class="bg-rgba-secondary">
                                                <small>
                                                    {{number_format($insumo->pivot->lastro, 1, ",", ".") . "m³"}}
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- SALDO DO DIA --}}
                                    <tr>
                                        <th class="text-center bg-rgba-secondary text-secondary" scope="row">
                                            Saldo do Dia
                                            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                            data-container="body" data-original-title="Como chegar neste número?"
                                            data-content="Este valor representa o saldo do dio dia após a soma de todas as entradas de estoque diminuídas das respectivas saída."></i>
                                        </th>
                                        <th>-</th>
                                        @foreach ($dataDan as $dDan)
                                            <td>
                                                <small>
                                                    {{ number_format($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->where("date_report", date("Y-m-d", strtotime($dDan)))->sum("qtd"), 1, ",", ".") . "m³" }}
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- ESTOQUE FÍSICO --}}
                                    <tr>
                                        <th class="text-center bg-rgba-secondary text-secondary" scope="row">
                                            Estoque Físico
                                            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                            data-container="body" data-original-title="Como chegar neste número?"
                                            data-content="Este volume representa o saldo acumulado do respectivo armazém e deve coincidir com o estoque físico na realizade."></i>
                                        </th>
                                        <th>
                                            <small>
                                                {{ number_format($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->whereBetween("date_report", [$data_inferior, date('Y-m-d', strtotime('-1 day', strtotime($start)))])->sum('qtd'), 1, ",", ".") . "m³" }}
                                            </small>
                                        </th>
                                        @foreach ($dataDan as $dDan)
                                            <td style="{{ ($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->whereBetween("date_report", [$data_inferior, $dDan])->sum('qtd')) > ($insumo->pivot->volume) ? 'background: black; color: white;' : ''}}" class="{{ ($actual_armazem->details->where("insumo_id", $insumo->id)->whereBetween("date_report", [$data_inferior, $dDan])->sum('qtd')) < 0 ? 'bg-danger white' : ''}}">
                                                <small>
                                                   {{ number_format($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->whereBetween("date_report", [$data_inferior, $dDan])->sum('qtd'), 1, ",", ".") . "m³" }}
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                    {{-- ESTOQUE COMERCIAL --}}
                                    <tr>
                                        <th class="text-center bg-rgba-secondary text-secondary" scope="row">
                                            Estoque Comercial
                                            <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                            data-container="body" data-original-title="Como chegar neste número?"
                                            data-content="Este volume representa o estoque de produto decrescido do seu respectivo lastro, ou seja, indica a quantidade comercialmente disponível."></i>
                                        </th>
                                        <th>
                                            <small>
                                                {{ number_format($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->whereBetween("date_report", [$data_inferior, date('Y-m-d', strtotime('-1 day', strtotime($start)))])->sum('qtd'), 1, ",", ".") . "m³" }}
                                            </small>
                                        </th>
                                        @foreach ($dataDan as $dDan)
                                            <td>
                                                <small>
                                                   {{ number_format($actual_armazem->details->where("insumo_id", $insumo->id)->where("type", "!=", "canceled")->whereBetween("date_report", [$data_inferior, $dDan])->sum('qtd') - $insumo->pivot->lastro, 1, ",", ".") . "m³" }}
                                                </small>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    @endforeach
                    

                </div>
            </div>
        </div>
    </div>

    @endif



    {{-- *******************************************  --}}



    <!-- Modal de Venda -->
    <div class="modal fade" id="modalVenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy canes chocolate cake
                        marshmallow icing lollipop I love. Gummies macaroon donut caramels biscuit topping danish.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Transferência -->
    <div class="modal fade" id="modalTransferencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Transferência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy canes chocolate cake
                        marshmallow icing lollipop I love. Gummies macaroon donut caramels biscuit topping danish.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Empréstimo -->
    <div class="modal fade" id="modalEmprestimo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Empréstimos & Devoluções</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy canes chocolate cake
                        marshmallow icing lollipop I love. Gummies macaroon donut caramels biscuit topping danish.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('modalNavio', event => {
            $('#modalEntrada').modal('show');
        })
    </script>

    <!-- Modal de Entrada de Navios -->
    <div class="modal fade" id="modalEntrada" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Entrada de Navios
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Relação de lançamentos do dia <strong>{{$data_navio != null ? date("d/m/Y", strtotime($data_navio)) : ''  }}</strong>
                    </p>
                    <p>
                        <ul class="todo-task-list-wrapper list-unstyled" id="todo-task-list-drag">
                            @if ($lancamentos_navios != null)
                                @forelse ($lancamentos_navios as $pedido)
                                    <li class="todo-item" data-name="David Smith">
                                        <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                            <div class="todo-title-area d-flex">
                                                @if ($pedido_navio->find($pedido->detail_id)->tipo_entrega === "navio")
                                                    <i class='bx bxs-ship mr-75'></i>
                                                @else
                                                    <i class='bx bxs-truck mr-75'></i>
                                                @endif
                                                @if ($pedido_navio->find($pedido->detail_id)->tipo_entrega === "navio")
                                                <p class="todo-title mx-50 m-0 truncate">
                                                    [{{$pedido->document === '' ? 'SEM PROTOCOLO' : $pedido->document }}] <strong>{{number_format($pedido->qtd, 1, ',', '.') . "m³"}}</strong> de <strong>{{$insumo_navio->name}}</strong> vindo de <strong>{{$usina_navio->find($pedido_navio->find($pedido->detail_id)->usina_id)->name}}</strong> para <strong>{{$armazem_navio->name}}</strong>.
                                                </p>
                                                @else
                                                <p class="todo-title mx-50 m-0 truncate">
                                                    [{{$pedido->document === '' ? 'SEM PROTOCOLO' : $pedido->document }}] <strong>{{number_format($pedido->qtd, 1, ',', '.') . "m³"}}</strong> de <strong>{{$insumo_navio->name}}</strong> vindo de <strong>Mudança de Propriedade</strong> para <strong>{{$armazem_navio->name}}</strong>.
                                                </p>
                                                @endif
                                                
                                            </div>
                                            <div class="todo-item-action d-flex align-items-center">
                                                <div class="todo-badge-wrapper d-flex">
                                                    @if ($pedido->type === "forecast")
                                                        <span class="badge badge-warning">
                                                            <small>PREVISTO</small>
                                                        </span>
                                                    @elseif($pedido->type === "canceled")
                                                        <span class="badge badge-danger">
                                                            <small><s>CANCELADO</s></small>
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                            <small>REALIZADO</small>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="avatar ml-1">
                                                    <img src="{{asset('storage/avatars/'. $user_navio->find($pedido->user_id)->profile->avatar )}}" alt="{{$user_navio->find($pedido->user_id)->first_name}}" height="30" width="30" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="{{$user_navio->find($pedido->user_id)->first_name}}">
                                                </div>
                                                <div>
                                                    <a href="{{route('pedidos.edit', $pedido->detail_id)}}" class="btn btn-warning ml-2">
                                                        <i class="bx bx-edit mr-1"></i>
                                                        EDITAR
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <p class="text-danger">
                                        Nenhum registro encontrado neste dia.
                                    </p>
                                @endforelse
                            @endif
                        </ul>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-like d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Entendido!</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Ajuste -->
    <div class="modal fade" id="modalAjuste" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Ajustes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy canes chocolate cake
                        marshmallow icing lollipop I love. Gummies macaroon donut caramels biscuit topping danish.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>









</div>
