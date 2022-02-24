<div class="card">
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
                                <option value="canceled">Cancelado</option>
                              </select>
                            </fieldset>
                        </div>
                      </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
    <div class="card-header">
        <h5 class="text-bold-600">
            Extrato de Lançamentos <small class="text-muted">(Histórico dos lançamentos feitos na plataforma)</small>
        </h5>
        <div class="heading-elements">
            <ul class="list-inline">
                <li><span class="badge badge-pill badge-light-secondary">{{$allDetails->count() > 1 ? $allDetails->count()  ." registros" : $allDetails->count()  ." registro"}}</span></li>
            </ul>
        </div>
    </div>
    @if ($lancamentos->count() > 0)
        <div class="table-responsive">
            <table id="table-marketing-campaigns " class="table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center" style="width: 5%;">Data</th>
                        <th style="width: 20%;">Responsável</th>
                        <th style="width: 20%;">Armazém</th>
                        <th style="width: 20%;">Insumo</th>
                        <th class="text-center" style="width: 5%;">Status</th>
                        <th class="text-center" style="width: 10%;">Categoria</th>
                        <th class="text-center" style="width: 25%;">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lancamentos as $lancamento)
                        <tr>
                            <td class="text-center">
                                <small>{{ date("d/m/Y", strtotime($lancamento->date_report)) }}</small>
                            </td>
                            <td class="pr-75">
                                <div class="media align-items-center">
                                    <a class="media-left mr-50" href="javascript:;">
                                        <img src="{{asset('storage/avatars/'.$lancamento->user->profile->avatar)}}" alt="avatar" class="rounded-circle" height="30" width="30">
                                    </a>
                                    <div class="media-body">
                                        <h6 class="media-heading mb-0">{{$lancamento->user->first_name}} {{$lancamento->user->last_name}}</h6>
                                        <span class="font-small-2">{{$lancamento->user->profile->function}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-bold-600">
                                {{$lancamento->armazem->name}}
                            </td>
                            <td class="text-bold-600">
                                {{$lancamento->insumos->find($lancamento->insumo_id)->name}}
                            </td>
                            <td class="text-center">
                                @if ($lancamento->type === "forecast")
                                    <span class="badge badge-warning">
                                        <small>PREVISTO</small>
                                    </span>
                                @elseif($lancamento->type === "canceled")
                                    <span class="badge badge-danger">
                                        <small><s>CANCELADO</s></small>
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        <small>REALIZADO</small>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">
                                    <small>{{$lancamento->category}}</small>
                                </span>
                            </td>
                            <td class="text-bold-600 text-center">
                                @if ($lancamento->moviment_type === "entrada")
                                    <i class="bx bx-plus-circle text-success align-middle mr-50"></i>
                                    <span class="text-success">{{ number_format(abs($lancamento->qtd), 1, ",", ".") . "m³" }}</span>
                                @else
                                    <i class="bx bx-minus-circle text-danger align-middle mr-50"></i>
                                    <span class="text-danger">{{ number_format(abs($lancamento->qtd), 1, ",", ".") . "m³" }}</span>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>
        </div>
        <div class="row">
            <div class="col-12 ml-2 mt-2">
                {{$lancamentos->links()}}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger m-2">
                    🥴 NENHUMA INFORMAÇÃO ENCONTRADA COM O FILTRO SELECIONADO
                </div>
            </div>
        </div>
    @endif
</div>
