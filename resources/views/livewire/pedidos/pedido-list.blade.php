<div class="row">

    @if ($verifica == false)
      @livewire('cadastros.cadastro-index')
    @else
    <div class="col-12">
        <div class="row">
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                    <i class="bx bx-edit-alt font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Total de Pedidos</p>
                  <h2 class="mb-0">48</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                    <i class="bx bx-file font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Em Aberto</p>
                  <h2 class="mb-0">17</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                    <i class="bx bx-message font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Volume Total</p>
                  <h2 class="mb-0">29</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                    <i class="bx bx-money font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Sales</p>
                  <h2 class="mb-0">72</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                    <i class="bx bx-purchase-tag font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Purchase</p>
                  <h2 class="mb-0">65</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
              <div class="card text-center">
                <div class="card-body">
                  <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                    <i class="bx bx-shopping-bag font-medium-5"></i>
                  </div>
                  <p class="text-muted mb-0 line-ellipsis">Order</p>
                  <h2 class="mb-0">40</h2>
                </div>
              </div>
            </div>
        </div>
    </div>
        
    <div class="col-lg-4 col-md-5 col-12 order-1 order-md-1">
        <div class="card" style="height: 650px;">
            
            <div class="card-header" style="display:inline;">
                <div class="row">
                    <div class="col-6 mt-1">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" id="basicInput" placeholder="Procurar cliente..." />
                        </fieldset>
                    </div>
                    <div class="col-6 mt-1">
                        <fieldset class="form-group">
                            <input type="text" class="form-control" id="basicInput" placeholder="Procurar cliente..." />
                        </fieldset>
                    </div>
                </div>
            </div>
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover table-striped">
                        <thead class="thead-dark">
                            <tr style="border-bottom: none;">
                                <th class="text-center">ENTREGA</th>
                                <th class="text-center">PEDIDO</th>
                                <th class="text-center">ENTREGA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td class="text-bold-500 text-center">
                                        @if ($pedido->order_status != "concluido")
                                        ⚠️
                                        @else
                                        ✅ 
                                        @endif
                                        @if ($pedido->tipo_entrega === "navio")
                                            <i class="bx bxs-ship mr-1"></i>
                                        @elseif ($pedido->tipo_entrega === "transferencia")
                                            <i class="bx bx-transfer-alt mr-1"></i>
                                        @else
                                            <i class="bx bxs-truck mr-1"></i>
                                        @endif
                                        <a href="" wire:click.prevent="findPedido({{$pedido->id}})">
                                            {{date("d/m/Y", strtotime($pedido->delivery_date))}}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-success">
                                            {{ number_format($pedido->insumos->sum("pivot.qtd_forecast"), 1, ",", ".") . "m³"}}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-danger">
                                            {{ number_format($pedido->insumos->sum("pivot.qtd_real"), 1, ",", ".") . "m³"}}
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{$pedidos->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7 col-12 order-2 order-md-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <div class="media mb-2">
                                    <div class="media-body pt-25">
                                        <h4 class="text-bold-600">
                                            <span class="users-view-name">
                                            {{$actual_pedido->fornecedor->name}}
                                            </span>
                                        </h4>
                                        <span><strong>PROTOCOLO: </strong></span><span class="users-view-id">{{$actual_pedido->document != "" ? $actual_pedido->document : "Não informado 🤨"}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                                <a href="{{route('pedidos.edit', $actual_pedido->id)}}" class="btn btn-sm border mt-0">
                                    <i class="bx bx-edit font-small-3 mr-1"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title mb-1">
                                    Dados do Pedido
                                    <i class="bx bx-info-circle float-right"></i>
                                </h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="bx bx-right-arrow-alt mr-50 cursor-pointer"></i>
                                        <span>
                                            <strong>Usina de Origem</strong>
                                            {{$actual_pedido->tipo_entrega === "navio" ? $actual_pedido->usina->name : "N/A"}}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="bx bx-right-arrow-alt mr-50 cursor-pointer"></i>
                                        <span><strong>Nº: </strong> S/N</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="bx bx-right-arrow-alt mr-50 cursor-pointer"></i>
                                        <span>
                                            <strong>Tipo de Entrega:</strong>
                                            @if ($actual_pedido->tipo_entrega === "navio")
                                            🚢 Entreda de Navio
                                            @elseif ($actual_pedido->tipo_entrega === "transferencia")
                                            🎁 Mudança de Propriedade
                                            @else
                                            🚛 Carreta
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="bx bx-right-arrow-alt mr-50 cursor-pointer"></i>
                                        <span>
                                            <strong>Status do Pedido:</strong>
                                            @if ($actual_pedido->order_status === "analise")
                                                <span class="badge badge-warning">EM ANÁLISE</span>
                                                <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                    data-container="body" data-original-title="O que significa?"
                                                    data-content="As quantidades estão sob análise do Fornecedor."></i>
                                            @elseif($actual_pedido->order_status === "aprovado")
                                                <span class="badge badge-primary">APROVADO</span>
                                                <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                    data-container="body" data-original-title="O que significa?"
                                                    data-content="Pedido aprovado com entrega ainda não concluída."></i>
                                            @elseif($actual_pedido->order_status === "concluido")
                                                <span class="badge badge-success">CONLUÍDO</span>
                                                <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                    data-container="body" data-original-title="O que significa?"
                                                    data-content="Pedido com quantidades entregues e finalizado."></i>
                                            @else
                                                <span class="badge badge-danger">REPROVADO</span>
                                                <i class="bx bx-help-circle" data-toggle="popover" data-trigger="hover" data-placement="right"
                                                    data-container="body" data-original-title="O que significa?"
                                                    data-content="Pedido reprovado ou cancelado"></i>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="bx bx-right-arrow-alt mr-50 cursor-pointer"></i>
                                        <span>
                                            <strong>{{$actual_pedido->tipo_entrega === "navio" ? "Janela de Entrega:" : "Data de Entrega:"}}</strong>
                                            @if ($actual_pedido->tipo_entrega === "navio")
                                            de {{date("d/m/y", strtotime($actual_pedido->window_start))}} até {{date("d/m/y", strtotime($actual_pedido->window_finish))}}
                                            @else
                                            {{date("d/m/y", strtotime($actual_pedido->delivery_date))}}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-1 mb-2">
                                <h5 class="card-title mb-1">
                                    Insumos Solicitados
                                    <i class="bx bx-droplet float-right"></i>
                                </h5>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-borderless table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center">INSUMO</th>
                                                    <th class="text-center"><small>PEDIDO</small></th>
                                                    <th class="text-center"><small>ENTREGUE</small></th>
                                                    <th class="text-center"><small>SALDO</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($actual_pedido->insumos as $insumo)
                                                <tr>
                                                    <td>
                                                       <small>
                                                           <strong>{{$insumo->name}}</strong><span class="text-muted ml-50">({{$armazens->find($insumo->pivot->armazem_id)->name}})</span>
                                                       </small>
                                                    </td>
                                                    <td><small>{{number_format($insumo->pivot->qtd_forecast, 1, ",", ".") . "m³"}}</small></td>
                                                    <td><small>{{number_format($insumo->pivot->qtd_real, 1, ",", ".") . "m³"}}</small></td>
                                                    <td><small>{{number_format($insumo->pivot->qtd_forecast - $insumo->pivot->qtd_real, 1, ",", ".") . "m³"}}</small></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($actual_pedido->tipo_entrega === "navio" && $actual_pedido->order_status != "concluido")
                                <div class="col-12 col-sm-12 d-flex justify-content-end align-items-right px-1 mt-3">
                                    <a href="#" class="btn btn-sm btn-light-success" wire:click.prevent="concluirPedido">
                                        <i class="bx bx-check-double font-small-3 mr-1"></i>
                                        Concluir Pedido
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-12 pb-1 pr-0">
                              <div class="card text-center mb-0">
                                <div class="card-body border p-1">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <p class="text-muted mb-0 line-ellipsis">Volume Solicitado</p>
                                        </div>
                                        <div class="col-12 text-right">
                                            <h3 class="mb-0 mt-1 text-bold-600">
                                                {{number_format($actual_pedido->insumos->sum("pivot.qtd_forecast"), 1, ",", ".") . "m³"}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 pb-1">
                              <div class="card text-center mb-0">
                                <div class="card-body border p-1">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <p class="text-muted mb-0 line-ellipsis">Volume Entregue</p>
                                        </div>
                                        <div class="col-12 text-right">
                                            <h3 class="mb-0 mt-1 text-bold-600 text-danger">
                                                {{number_format($actual_pedido->insumos->sum("pivot.qtd_real"), 1, ",", ".") . "m³"}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 pr-0">
                              <div class="card text-center">
                                <div class="card-body border p-1">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <p class="text-muted mb-0 line-ellipsis">Saldo do Pedido</p>
                                        </div>
                                        <div class="col-12 text-right">
                                            <h3 class="mb-0 mt-1 text-bold-600">
                                                {{number_format($actual_pedido->insumos->sum("pivot.qtd_forecast") - $actual_pedido->insumos->sum("pivot.qtd_real"), 1, ",", ".") . "m³"}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12">
                              <div class="card text-center">
                                <div class="card-body border p-1">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <p class="text-muted mb-0 line-ellipsis">% Completo</p>
                                        </div>
                                        <div class="col-12 text-right">
                                            <h3 class="mb-0 mt-1 text-bold-600">
                                                {{ $actual_pedido->insumos->sum("pivot.qtd_forecast") > 0 ? number_format( ($actual_pedido->insumos->sum("pivot.qtd_real") / $actual_pedido->insumos->sum("pivot.qtd_forecast")) * 100, 1, ",", ".") . "%" : "0,0%" }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header">
                                        <i class='bx bx-note align-middle'></i>
                                        <span class="align-middle text-bold-600">ANOTAÇÕES</span>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            <i>{{$actual_pedido->notes != "" ? $actual_pedido->notes : "Sem observações."}}</i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    @if ($actual_pedido->order_status != "concluido")
                    <div class="col-12">
                        <div class="card border p-1">
                            <div class="card-header">
                                <h6 class="text-bold-600">Entregas</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-50">
                                        <button href="" class="btn btn-success btn-block" wire:click.prevent="novaEntrega()" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}>
                                            <i class="bx bx-save mr-2"></i>
                                            REGISTRAR ENTREGA
                                        </button>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="delivery_date">Data</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" wire:model.defer='delivery_date' placeholder="{{$actual_pedido->tipo_entrega != "navio" ? "N/A" : ""}}" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}>
                                            @error('delivery_date')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="">Insumo</label><span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="insumo_id" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}>
                                            <option value="" selected hidden>Selecione um insumo</option>
                                            @foreach ($insumos as $insumo)
                                                <option value="{{$insumo->id}}">{{$insumo->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('insumo_id')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-3 form-group">
                                        <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="armazem_id" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}>
                                            <option value="" selected hidden>Selecione um armazem</option>
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
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="qtd_delivered">Qtd (m³)</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" id="qtd_delivered" name="qtd_delivered" wire:model.defer='qtd_delivered' placeholder="0,00m³" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}>
                                            @error('qtd_delivered')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="notes">Observações Importantes</label>
                                            <textarea class="form-control" name="notes" id="notes" rows="3" wire:model.defer="notes" {{$actual_pedido->tipo_entrega != "navio" ? "disabled" : ""}}></textarea>
                                            @error('notes')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                 
                    @endif
                    @if ($actual_pedido->tipo_entrega === "navio")
                        @if ($actual_pedido->entregas->count() >0)
                            <div class="col-12">
                                <div class="collapsible collapse-icon accordion-icon-rotate">
                                    <div class="card collapse-header">
                                        <div id="headingCollapse5" class="card-header" data-toggle="collapse" role="button" data-target="#paids"
                                            aria-expanded="false" aria-controls="collapse5">
                                            <span class="collapse-title">
                                                <i class='bx bx-check-double align-middle'></i>
                                                <span class="align-middle">ENTREGAS</span>
                                            </span>
                                            <span class="badge badge-secondary badge-pill badge-round float-right mr-2 ml-auto">7</span>
                                        </div>
                                        <div id="paids" role="tabpanel" aria-labelledby="headingCollapse5" class="collapse">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card-body pt-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-borderless table-hover" data-show-toggle="true">
                                                                <thead>
                                                                    <tr style="border-bottom: none;">
                                                                        <th class="text-center">DATA</th>
                                                                        <th class="text-center">INSUMO</th>
                                                                        <th class="text-center">ARMAZÉM</th>
                                                                        <th class="text-center">QTD</th>
                                                                        <th class="text-center">AÇÃO</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($entregas as $entrega)
                                                                    <tr>
                                                                        <td class="text-bold-500 text-center">
                                                                            {{date("d/m/y", strtotime($entrega->delivery_date))}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{$find_insumo->find($entrega->insumo_id)->name}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{$armazens->find($entrega->armazem_id)->name}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{number_format($entrega->qtd_delivered, 1, ",", ".") . "m³"}}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="" wire:click.prevent="deleteConfirmationEntrega({{$entrega->id}})" class="btn btn-danger">
                                                                                <i class="bx bx-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                            
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert border-warning alert-dismissible mb-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-error-circle"></i>
                                        <span>
                                            Nenhuma entrega registrada.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                {{--
                <div class="row">
                    <div class="col-12 col-sm-12 d-flex justify-content-end align-items-right mb-0 mt-1">
                        <a href="#" class="btn btn-sm border">
                            <i class="bx bx-printer font-small-3 mr-1"></i>
                            Imprimir
                        </a>
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>
    @endif
    


    <script>
        window.addEventListener("sucesso-salva-entrega", function(){
          toastr.success('Registro criado com sucesso.', 'Deu certo!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>

    <script>
        window.addEventListener("pedido-encerrado", function(){
        toastr.success('Pedido encerrado.', 'Acaboooouuu!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
        })
        })
    </script>
    <script>
        window.addEventListener("confirma-exclusao-entrega", function(){
  
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger mr-1'
              },
              buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
              title: 'Tem certeza?',
              text: "Presta atenção pra não fazer cagada!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sim, excluir!',
              cancelButtonText: 'Não, cancelar!',
              reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {
                    Livewire.emit('deleteEntrega')
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelado!',
                      'Sabia... tava fazendo cagada! :)',
                      'error'
                    )
                  }
                })
        })
      </script>
      <script>
        window.addEventListener("sucesso-deleta-entrega", function(){
          toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
      </script>

</div>
