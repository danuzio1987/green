<div class="card bg-transparent shadow-none border">
    <div class="card-body">
        <h4 class="mb-2 text-bold-600">
            FORMULÁRIO DE EDIÇÃO DE PEDIDO
            @if ($pedido->order_status === "analise")
            <span class="badge badge-warning ml-75">EM ANÁLISE</span>
            @elseif ($pedido->order_status === "aprovado")
            <span class="badge badge-primary ml-75">APROVADO</span>
            @elseif ($pedido->order_status === "concluido")
            <span class="badge badge-success ml-75">CONCLUÍDO</span>
            @else
            <span class="badge badge-danger ml-75">REPROVADO</span>
            @endif
        </h4>

        <div class="row match-height">

            <div class="col-9">
                <div class="card">
                    <div class="card-body pb-0 mx-25">
                        <div class="row">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="solicitation_date">Data Solicitação</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control" id="solicitation_date" name="solicitation_date" readonly="readonly" wire:model.defer='solicitation_date' />
                                            @error('solicitation_date')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="fornecedor_id">Fornecedor</label><span class="text-danger">*</span>
                                            <select class="form-control" name="fornecedor_id" id="fornecedor_id" wire:model.defer="fornecedor_id" disabled>
                                                <option value="" selected hidden>Selecione um Fornecedor</option>
                                                @foreach ($fornecedores as $fornecedor)
                                                    <option value="{{$fornecedor->id}}" {{$fornecedor_id === $fornecedor->id ? "selected" : ""}}>{{$fornecedor->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('fornecedor_id')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="document">Protocolo</label>
                                            <input type="text" class="form-control" id="document" name="document" wire:model.defer='document' placeholder="Nº Protocolo">
                                            @error('document')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="order_status">Status do Pedido</label><span class="text-danger">*</span>
                                            <select class="form-control" name="order_status" id="order_status" wire:model.defer="order_status" {{$tipo_entrega === "transferencia" ? 'disabled' : ''}}>
                                                <option value="" selected hidden>Selecione um Status</option>
                                                <option value="analise" {{$order_status === "analise" ? "selected" : ""}}>Em Análise</option>
                                                <option value="aprovado" {{$order_status === "aprovado" ? "selected" : ""}}>Aprovado</option>
                                                <option value="reprovado" {{$order_status === "reprovado" ? "selected" : ""}}>Reprovado</option>
                                            </select>
                                            @error('order_status')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="tipo_entrega">Entrega</label>
                                            <select class="form-control" name="tipo_entrega" id="tipo_entrega" wire:model="tipo_entrega" disabled>
                                                <option value="" selected hidden>Como?</option>
                                                <option value="navio">Navio</option>
                                                <option value="transferencia">Transferência</option>
                                                <option value="outro">Outro</option>
                                            </select>
                                            @error('tipo_entrega')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-{{$tipo_entrega === "navio" ? "3" : "4"}}">
                                        <div class="form-group">
                                            <label for="usina_id">Usina de Origem</label><span class="text-danger">*</span>
                                            <select class="form-control" name="usina_id" id="usina_id" wire:model.defer="usina_id" {{$tipo_entrega === "transferencia" ? 'disabled' : ''}} disabled>
                                                <option value="" selected hidden>Selecione uma Usina</option>
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

                                    <div class="col-{{$tipo_entrega === "navio" ? "3" : "4"}}">
                                        <div class="form-group">
                                            <label for="armazem_id">Faixa de Entrega</label><span class="text-danger">*</span>
                                            <select class="form-control" name="armazem_id" id="armazem_id" wire:model.defer="armazem_id">
                                                <option value="" selected hidden>Selecione uma Faixa</option>
                                                @foreach ($armazens as $armazem)
                                                    <option value="{{$armazem->id}}" {{$armazem_id === $armazem->id ? "selected" : ""}} >{{$armazem->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('armazem_id')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

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
                                                <label for="window_finish">Término Janela</label><span class="text-danger">*</span>
                                                <input type="date" class="form-control" id="window_finish" name="window_finish" wire:model.defer='window_finish' placeholder="dd/mm/aaaa">
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
                                                <input type="date" class="form-control" id="delivery_date" name="delivery_date" wire:model.defer='delivery_date' placeholder="dd/mm/aaaa">
                                                @error('delivery_date')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="notes">Observações Importantes</label>
                                            <textarea name="notes" id="notes" class="form-control" wire:model.defer="notes" rows="3"></textarea>
                                            @error('notes')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="card border {{$form_mode === "edit" ? 'bg-rgba-warning' : ''}}">
                                            <div class="card-header">
                                                <h4 class="text-bold-600">
                                                    {{$form_mode === "create" ? "Inserir Insumo" : "Editar Insumo"}}
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3 form-group">
                                                        <label for="">Insumo</label><span class="text-danger">*</span>
                                                        <select class="form-control" wire:model.defer="insumo_id">
                                                            <option value="" selected hidden>Selecione um insumo</option>
                                                            @foreach ($insumos as $insumo)
                                                                <option value="{{$insumo->id}}" {{$this->pedido->insumos()->find($insumo->id) ? "hidden" : ""}} >{{$insumo->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('insumo_id')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-3 form-group">
                                                        <div class="form-group">
                                                            <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
                                                            <select class="form-control" name="armazem_id" id="armazem_id" wire:model.defer="armazem_id">
                                                                <option value="" selected hidden>Selecione um Armazém</option>
                                                                @foreach ($armazens as $armazem)
                                                                    <option value="{{$armazem->id}}" {{$armazem_id === $armazem->id ? "selected" : ""}} >{{$armazem->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('armazem_id')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-3 form-group">
                                                        <label for="qtd_forecast">Qtd {{$order_status === "aprovado" ? "Aprovada" : "Solicitada"}}</label><span class="text-danger">*</span>
                                                        <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd_forecast">
                                                        @error('qtd_forecast')
                                                            <span class="text-danger">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="data_descarga_item_pedido">Entrega</label><span class="text-danger">*</span>
                                                            <input type="date" class="form-control" wire:model.defer="data_descarga_item_pedido">
                                                            @error('data_descarga_item_pedido')
                                                                <span class="text-danger">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            @if ($form_mode === "create")
                                                            <div class="col-12">
                                                                <a href="#" wire:click.prevent="inserirInsumo" class="btn btn-light-success btn-block">
                                                                    <i class="bx bx-save mr-2"></i>
                                                                    INSERIR NOVO ISUMO
                                                                </a>
                                                            </div>
                                                            @else
                                                            <div class="col-6">
                                                                <a href="#" wire:click.prevent="editItem" class="btn btn-warning btn-block ">
                                                                    <i class="bx bx-edit mr-2"></i>
                                                                    ATUALIZAR INSUMO
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="#" wire:click.prevent="start" class="btn btn-secondary btn-block">
                                                                    <i class="bx bx-block mr-2"></i>
                                                                    CANCELAR
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card border">
                                            <div class="card-header">
                                                <h4 class="card-title">Itens do Pedido (Insumos)</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 table-responsive table-hover">
                                                        <table class="table mb-0">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th style="width: 20%;" >Insumo</th>
                                                                    <th style="width: 20%;" >Armazém</th>
                                                                    <th style="width: 20%;" class="text-center">
                                                                        Entrega <br>
                                                                        (Prevista)
                                                                    </th>
                                                                    <th style="width: 25%;" class="text-center">
                                                                        Qtd <br>
                                                                        ({{$order_status === "aprovado" ? "Aprovada" : "Solicitada"}})
                                                                    </th>
                                                                    <th style="width: 15%;" class="text-center">Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                                @foreach ($pedido->insumos as $insumo)
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="text-bold-600">
                                                                            {{$insumo->name}}
                                                                        </h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="text-bold-600">
                                                                            {{$armazens->find($insumo->pivot->armazem_id)->name}}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-bold-600">
                                                                            {{ $insumo->pivot->data_descarga_item_pedido === null ? "" : date("d/m/Y", strtotime($insumo->pivot->data_descarga_item_pedido)) }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ number_format($insumo->pivot->qtd_forecast, 1, ",", ".") . "m³"}}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="invoice-action">
                                                                            <a href="" wire:click.prevent="showEditForm({{$insumo->id}}, {{$armazens->find($insumo->pivot->armazem_id)->id}})" class="text-warning mr-1 cursor-pointer">
                                                                                <i class="bx bx-edit"></i>
                                                                            </a>
                                                                            @if ($pedido->insumos->count() > 1)
                                                                            <a href="" wire:click.prevent='deleteConfirmationInsumo({{$insumo->id}})' class="text-danger cursor-pointer">
                                                                                <i class="bx bx-trash"></i>
                                                                            </a>
                                                                            @endif
                                                                        </div>
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

                                <div class="row">
                                    <div class="col-12 ">
                                        <div class="d-flex justify-content-start">
                                            <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                                        </div>
                                    </div>
                                </div>
                                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">

                <div class="card invoice-action-wrapper shadow-none border">
                    <div class="card-body">

                        <div class="invoice-action-btn mb-1">
                            <a  wire:click.prevent="updatePedido" class="btn btn-success btn-block">
                                <i class="bx bx-save mr-1"></i>
                                ATUALIZAR PEDIDO
                            </a>
                        </div>

                        <div class="invoice-action-btn mb-1">
                            <a href="" wire:click.prevent='deleteConfirmationPedido({{$pedido->id}})' class="btn btn-light-danger btn-block">
                                <i class="bx bx-block mr-1"></i>
                                EXCLUIR PEDIDO
                            </a>
                        </div>

                        <div class="invoice-action-btn mb-1">
                            <a href="{{route('pedidos.index')}}" class="btn btn-light-secondary btn-block">
                                <i class="bx bx-x mr-1"></i>
                                SAIR
                            </a>
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
                window.addEventListener("confirma-exclusao-insumo", function(){
        
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-1'
                    },
                    buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                    title: 'Confirma a exclusão do insumo?',
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
                            Livewire.emit('deleteInsumo')
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
                window.addEventListener("confirma-exclusao-pedido", function(){
        
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-1'
                    },
                    buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                    title: 'Confirma a exclusão deste pedido?',
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
                window.addEventListener("sucesso-deleta-insumo", function(){
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
            <script>
                window.addEventListener("sucesso-deleta-pedido", function(){
                toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
                    closeButton: true,
                    tapToDismiss: false,
                    timeOut: 3000
                })
                })
            </script>

        </div>

    </div>
</div>

