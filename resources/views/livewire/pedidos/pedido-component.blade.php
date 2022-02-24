<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE PRODUTO --}}
    @if ( $usinas->count() > 0 && $armazens->count() > 0 && $insumos->count() > 0 && $fornecedores->count() > 0)
        <div class="col-7">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                            <h4 class="text-bold-600">
                                {{$form_mode === "edit" ? "Editar Pedido" : "Novo Pedido"}}
                            </h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="solicitation_date">Data Solicitação</label><span class="text-danger">*</span>
                                        <input type="date" class="form-control" id="solicitation_date" name="solicitation_date" wire:model.defer='solicitation_date'>
                                        @error('solicitation_date')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="fornecedor_id">Fornecedor</label><span class="text-danger">*</span>
                                        <select class="form-control" name="fornecedor_id" id="fornecedor_id" wire:model.defer="fornecedor_id">
                                            <option value="" selected hidden>Selecione um Fornecedor</option>
                                            @foreach ($fornecedores as $fornecedor)
                                                <option value="{{$fornecedor->id}}">{{$fornecedor->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('fornecedor_id')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="tipo_entrega">Entrega</label><span class="text-danger">*</span>
                                        <select class="form-control" name="tipo_entrega" id="tipo_entrega" wire:model="tipo_entrega">
                                            <option value="" selected hidden>Como?</option>
                                            <option value="navio">Navio</option>
                                            <option value="transferencia">Mud. Propriedade</option>
                                            <option value="outro">Caminhão</option>
                                        </select>
                                        @error('tipo_entrega')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{--
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="tipo_entrega">Faixa</label><span class="text-danger">*</span>
                                        <select class="form-control" name="tipo_entrega" id="tipo_entrega" wire:model="tipo_entrega" {{$tipo_entrega != "navio" ? "disabled" : ""}}>
                                            <option value="" selected hidden>Qual faixa?</option>
                                            <option value="">1 (05 - 10)</option>
                                            <option value="">2 (10 - 15)</option>
                                            <option value="">3 (15 - 20)</option>
                                        </select>
                                        @error('tipo_entrega')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                --}}
                                
                            </div>

                            <div class="row">
                                <div class="col-{{$tipo_entrega === "navio" ? "3" : "4"}}">
                                    <div class="form-group">
                                        <label for="document">Protocolo</label>
                                        <input type="text" class="form-control" id="document" name="document" wire:model.defer='document' placeholder="Nº Protocolo" autocomplete="off">
                                        @error('document')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-{{$tipo_entrega === "navio" ? "3" : "4"}}">
                                    <div class="form-group">
                                        <label for="usina_id">Usina de Origem</label><span class="text-danger">*</span>
                                        <select class="form-control" name="usina_id" id="usina_id" wire:model.defer="usina_id" {{$tipo_entrega != "navio" ? "disabled" : ""}}>
                                            <option value="" selected hidden>Qual Usina?</option>
                                            @foreach ($usinas as $usina)
                                                <option value="{{$usina->id}}">{{$usina->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('usina_id')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{--
                                <div class="col-{{$tipo_entrega === "navio" ? "3" : "4"}}">
                                    <div class="form-group">
                                        <label for="armazem_id">Armazém de Destino</label><span class="text-danger">*</span>
                                        <select class="form-control" name="armazem_id" id="armazem_id" wire:model="armazem_id">
                                            <option value="" selected hidden>Qual Armazém?</option>
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
                                --}}

                                @if ($tipo_entrega === "navio")
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="window_start">Início Janela</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control" id="window_start" name="window_start" wire:model.defer='window_start' placeholder="dd/mm/aaaa">
                                            @error('window_start')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="window_finish">Final Janela</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control"  id="window_finish" name="window_finish" wire:model.defer='window_finish' placeholder="dd/mm/aaaa">
                                            @error('window_finish')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="delivery_date">Data de Entrega</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control"  id="delivery_date" name="delivery_date" wire:model.defer='delivery_date' placeholder="dd/mm/aaaa">
                                            @error('delivery_date')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                            </div>

                            @if ($form_mode === "create")
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card border">
                                            <div class="card-header">
                                                <h4 class="card-title">Itens do Pedido (Insumos)</h4>
                                            </div>
                                            <div class="card-body">
                                                
                                                {{-- PRIMEIRA LINHA DE INSUMO --}}
                                                <div class="row justify-content-between">
                                                    <div class="col-4 form-group">
                                                        <label class="text-nowrap">Nome do Insumo</label><span class="text-danger">*</span>
                                                        <select class="form-control" wire:model.defer="insumo_id.0">
                                                            <option value="" selected hidden>Selecione um insumo</option>
                                                            @foreach ($insumos as $insumo)
                                                                <option value="{{$insumo->id}}">{{$insumo->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('insumo_id.0')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4 form-group">
                                                        <label for="armazem_id">Armazém de Destino</label><span class="text-danger">*</span>
                                                        <select class="form-control" name="armazem_id.0" id="armazem_id.0" wire:model.defer="armazem_id.0">
                                                            <option value="" selected hidden>Qual Armazém?</option>
                                                            @foreach ($armazens as $armazem)
                                                                <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('armazem_id.0')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2 form-group">
                                                        <label class="text-nowrap">Qtd (m³)</label><span class="text-danger">*</span>
                                                        <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd.0" >
                                                        @error('qtd.0')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2 form-group text-center">
                                                        <label class="text-nowrap">Ação</label>
                                                        <button class="btn btn-success btn-block" wire:click.prevent="add({{$i}})">
                                                            <i class="bx bx-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- LINHAS DINÂMICAS DE INSUMO --}}
                                                @foreach ($inputs as $key => $value)
                                                    <div class="row justify-content-between">
                                                        <div class="col-4 form-group">
                                                            <select class="form-control" wire:model.defer="insumo_id.{{$value}}">
                                                                <option value="" selected hidden>Selecione um insumo</option>
                                                                @foreach ($insumos as $insumo)
                                                                    <option value="{{$insumo->id}}">{{$insumo->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('insumo_id.'.$value)
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-4 form-group">
                                                            <select class="form-control" wire:model.defer="armazem_id.{{$value}}">
                                                                <option value="" selected hidden>Qual Armazém?</option>
                                                                @foreach ($armazens as $armazem)
                                                                    <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('armazem_id.{{$value}}')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-2 form-group">
                                                            <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd.{{$value}}" >
                                                            @error('qtd.'.$value)
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-2 form-group text-center">
                                                            <a class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">
                                                            <i class="bx bx-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>                                                   
                            @endif

                            {{-- BOTÕES DO FORMULÁRIO --}}
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex justify-content-start">
                                        <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        @if ($form_mode === "edit")
                                            <a href="" wire:click.prevent='editProduto' class="btn btn-warning mr-1">
                                                <i class="bx bx-save mr-1"></i>
                                                Atualizar
                                            </a>
                                        @else
                                            <a href="" wire:click.prevent='createPedido' class="btn btn-light-success mr-1">
                                                <i class="bx bx-save mr-1"></i>
                                                Criar
                                            </a>
                                        @endif
                                        <a href="" wire:click.prevent='cancel' class="btn btn-light-danger">
                                            <i class="bx bx-block mr-1"></i>
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-7">
            <div class="row">
                <div class="col-12">
                    <div class="card alert alert-danger py-5">
                        <div class="card-header">
                            <h4 class="text-bold-600">
                                INFORMAÇÕES INSUFICIENTES!
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    Para criar um pedido é necessário ter <strong>USINAS</strong>, <strong>ARMAZÉNS</strong>, <strong>INSUMOS</strong> e <strong>FORNECEDORES</strong> cadastrados.
                                </div>
                                <div class="col-12">
                                    @if ($usinas->count() === 0)
                                        <a href="{{route('usinas.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR USINA</a>
                                    @endif
                                    @if ($armazens->count() === 0)
                                        <a href="{{route('armazens.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR ARMAZÉM</a>
                                    @endif
                                    @if ($insumos->count() === 0)
                                        <a href="{{route('insumos.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR INSUMO</a>
                                    @endif
                                    @if ($fornecedores->count() === 0)
                                        <a href="{{route('fornecedores.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR FORNECEDOR</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- LISTA DAS PEDIDOS CADASTRADOS --}}
    <div class="col-5">
        <div class="row">
            <div class="col-12">
                <div class="users-list-filter px-1">
                    <form>
                      <div class="row border rounded py-2 mb-2">
                        <div class="col-2">
                            <label for="paginate">Paginação</label>
                            <fieldset class="form-group">
                              <select class="form-control" id="paginate" wire:model="paginate">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                              </select>
                            </fieldset>
                        </div>
                        <div class="col-5">
                          <label for="search_status">Status</label>
                          <fieldset class="form-group">
                            <select class="form-control" name="search_status" id="search_status" wire:model="search_status" >
                                <option value="">Todos</option>
                                <option value="analise">Em Análise</option>
                                <option value="aprovado">Aprovado</option>
                                <option value="reprovado">Reprovado</option>
                            </select>
                          </fieldset>
                        </div>
                        <div class="col-5">
                            <label for="search_date">Chegada</label>
                            <fieldset class="form-group">
                              <input type="date" class="form-control" wire:model="search_date">
                            </fieldset>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
              <div class="card">
                @if ($pedidos->count() > 0)

                  <div class="card-header">
                    <h4 class="text-bold-600 position-relative d-inline-block">
                      <span class="mr-50">
                          <a href="{{route('pedidos.lista')}}">Lista de Pedidos</a>
                        </span>
                      <span class="badge badge-pill badge-success badge-up badge-round badge-glow">{{$allPedidos->count()}}</span>
                    </h4>
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listadas todos os pedidos cadastrados nesta plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($pedidos as $pedido)
                          <li class="list-group-item draggable">
                            <div class="media">
                                <div class="media-body">
                                    @if ($pedido->tipo_entrega === "navio")
                                    <i class="bx bxs-ship"></i>
                                    @elseif ($pedido->tipo_entrega === "transferencia")
                                    <i class="bx bx-transfer-alt"></i>
                                    @else
                                    <i class="bx bxs-truck"></i>
                                    @endif
                                    @if ($pedido->order_status === "analise")
                                        <div class="badge badge-pill badge-light-warning">ANÁLISE</div>
                                    @elseif($pedido->order_status === "aprovado")
                                        <div class="badge badge-pill badge-light-primary">APROVADO</div>
                                    @elseif($pedido->order_status === "concluido")
                                        <div class="badge badge-pill badge-light-success">CONCLUÍDO</div>
                                    @else
                                        <div class="badge badge-pill badge-light-danger">REPROVADO</div>
                                    @endif
                                    @if ($pedido->order_status === "reprovado")
                                        <span class="text-muted mb-0 ml-75">
                                            <s>{{ date("d/m", strtotime($pedido->delivery_date)) }}</s>
                                        </span>
                                    @else
                                        <span class="text-bold-600 mb-0 ml-75">
                                            {{ $pedido->tipo_entrega === "transferencia" ?  date("d/m", strtotime($pedido->delivery_date)) : date("d/m", strtotime($pedido->window_finish)) }}
                                        </span>
                                    @endif
                                    <div class="position-relative d-inline-block mr-2">
                                        <small class="text-muted ml-50">{{ number_format($pedido->insumos->sum("pivot.qtd_forecast"), 1, ",", ",") . "m³" }}</small>
                                        <span class="badge badge-pill badge-secondary badge-round ml-50">{{$pedido->insumos->count() > 1 ? $pedido->insumos->count() . " insumos" : $pedido->insumos->count() . " insumo"}}</span>
                                    </div>
                                </div>
                                <div class="invoice-action">
                                    <a href="{{route('pedidos.edit', $pedido->id)}}" class="text-warning mr-1 cursor-pointer">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="" wire:click.prevent='deleteConfirmationPedido({{$pedido->id}})' class="text-danger cursor-pointer">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$pedidos->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Pedidos
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="alert alert-warning alert-dismissible mb-2" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-error-circle"></i>
                                <span>
                                    Não encontramos nenhum registro, utilize o formulário ao lado para cadastro.
                                </span>
                            </div>
                        </div>
                      </div>
                      <div class="col-12 text-center">
                        <img src="{{asset("gif/travolta.gif")}}" class="img-responsive" alt="">
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>
        </div>
    </div>


    <script>
      window.addEventListener("sucesso-salva-pedido", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("confirma-exclusao-pedido", function(){

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
                  Livewire.emit('deletePedido')
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
      window.addEventListener("sucesso-deleta-pedido", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-pedido", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>

</div>