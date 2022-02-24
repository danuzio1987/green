
<div class="row match-height">

    <div class="col-9">
        <div class="card">
            <div class="card-body pb-0 mx-25">
                <div class="row">
                    <div class="card-body">

                        <div class="row">
                            {{-- status da venda --}}
                            {{--
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="type">Status</label><span class="text-danger">*</span>
                                    <select class="form-control" name="armazem_id" id="type" wire:model.defer="type">
                                        <option value="" selected hidden>Qual status</option>
                                        <option value="forecast">Previsto</option>
                                        <option value="real">Real</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            --}}
                            {{-- modo da venda da venda --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="mode">Modo da Venda</label>
                                    <select class="form-control" name="mode" id="mode" wire:model.defer="mode" disabled>
                                        <option value="" selected hidden>Qual status</option>
                                        <option value="normal">Normal</option>
                                        <option value="antecipacao">Antecipação</option>
                                        <option value="propriedade">Mud. Propriedade</option>
                                        <option value="planejamento">Planejamento</option>
                                    </select>
                                    @error('mode')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- datas --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="sale_date">Data da Venda</label><span class="text-danger">*</span>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" wire:model.defer='sale_date'>
                                    @error('sale_date')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- 
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="date_report">Data Retirada</label><span class="text-danger">*</span>
                                    <input type="date" class="form-control" id="date_report" name="date_report" wire:model.defer='date_report' placeholder="dd/mm/aaaa">
                                    @error('date_report')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            --}}
                            {{-- documento --}}
                            {{-- cliente --}}
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="cliente_id">Cliente</label><span class="text-danger">*</span>
                                    <select class="form-control" name="cliente_id" id="cliente_id" wire:model.defer="cliente_id">
                                        <option value="" selected hidden>Selecione um Cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="document">Documento</label>
                                    <input type="text" class="form-control" id="document" name="document" wire:model.defer='document' placeholder="Nº NF" autocomplete="off">
                                    @error('document')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- observações --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notes">OBSERVAÇÕES</label>
                                    <textarea name="notes" id="notes" wire:model.defer="notes"  rows="3" class="form-control" placeholder="Observações importantes"></textarea>
                                    @error('notes')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- lista de produtos --}}
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card border {{$form_mode === "edit" ? 'bg-rgba-warning' : ''}}">
                                    <div class="card-header">
                                        <h4 class="text-bold-600">
                                            📦 {{$form_mode === "create" ? "Inserir Produto" : "Editar Produto"}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 form-group">
                                                <label for="">Produto</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="produto_id">
                                                    <option value="" selected hidden>Selecione um produto</option>
                                                    @foreach ($produtos as $produto)
                                                    
                                                        <option value="{{$produto->id}}" {{$this->venda->produtos()->find($produto->id) ? "hidden" : ""}} >{{$produto->name}}</option>
                                                        {{-- 
                                                        <option value="{{$produto->id}}" >{{$produto->name}}</option>
                                                        --}}
                                                    @endforeach
                                                </select>
                                                @error('produto_id')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                                {{-- armazém --}}
                                            <div class="col-3 form-group">
                                                <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
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
                                            <div class="col-3 form-group">
                                                <label for="date_report">Retirada</label><span class="text-danger">*</span>
                                                <input type="date" class="form-control" wire:model.defer="date_report">
                                                @error('date_report')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-3 form-group">
                                                <label for="qtd_sale">Qtd Vendida</label><span class="text-danger">*</span>
                                                <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd_sale">
                                                @error('qtd_sale')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-75">
                                                <div class="row">
                                                    @if ($form_mode === "create")
                                                    <div class="col-12">
                                                        <a href="#" wire:click.prevent="inserirProduto" class="btn btn-light-success btn-block">
                                                            <i class="bx bx-save mr-2"></i>
                                                            + INCLUIR PRODUTO
                                                        </a>
                                                    </div>
                                                    @else
                                                    <div class="col-6">
                                                        <a href="#" wire:click.prevent="updateProduto" class="btn btn-warning btn-block">
                                                            <i class="bx bx-edit mr-2"></i>
                                                            EDITAR PRODUTO
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="#" wire:click.prevent="clearForm" class="btn btn-secondary btn-block">
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
                                        <h4 class="card-title">Produtos Vendidos</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive table-hover">
                                                <table class="table mb-0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th style="width: {{$mode === "antecipacao" ? '30%' : '35%'}};" >Produto</th>
                                                            <th style="width: {{$mode === "antecipacao" ? '15%' : '20%'}};" >Armazém</th>
                                                            <th style="width: {{$mode === "antecipacao" ? '15%' : '20%'}};" class="text-center">
                                                                Qtd <br>
                                                                (vendida)
                                                            </th>
                                                            <th style="width: 10%;" >Entrega</th>
                                                            @if ($mode === "antecipacao")
                                                            <th style="width: 15%;" class="text-center">
                                                                Qtd <br>
                                                                (entregue)
                                                            </th>
                                                            @endif
                                                            <th style="width: 15%;" class="text-center">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @foreach ($venda->produtos as $produto)
                                                        <tr>
                                                            <td>
                                                                <div class="list-content">
                                                                    <span class="list-title">
                                                                        <h6 class="text-bold-600">
                                                                            {{$produto->name}}
                                                                        </h6>
                                                                    </span>
                                                                    <small class="text-muted d-block">
                                                                        @foreach ($produto->insumos as $insumo)
                                                                            [<strong>{{$insumo->name}}</strong>: {{number_format($insumo->pivot->percent, 1, ",", ".") . "%"}}] 
                                                                        @endforeach
                                                                    </small>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$armazens->find($produto->pivot->armazem_id)->name}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($produto->pivot->qtd_sale, 1, ",", ".") . "m³"}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ date("d/m/y", strtotime($produto->pivot->date_retirada)) }}
                                                            </td>
                                                            @if ($mode === "antecipacao")
                                                            <td class="text-center">
                                                                {{ number_format($produto->pivot->qtd_delivered, 1, ",", ".") . "m³"}}
                                                            </td>
                                                            @endif

                                                            <td class="text-center">
                                                                <div class="invoice-action">
                                                                    <a href="" wire:click.prevent="showEditForm({{$produto->id}}, {{$produto->pivot->armazem_id}})" class="text-warning mr-1 cursor-pointer">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                    @if ($venda->produtos->count() > 1)
                                                                    <a href="" wire:click.prevent='deleteConfirmationProduto({{$produto->id}}, {{$produto->pivot->armazem_id}})' class="text-danger cursor-pointer">
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
                            {{-- ENTREGAS --}}
                            @if ($mode === "antecipacao")
                            <div class="col-12">
                                <div class="card border {{$form_delivery === "edit" ? 'bg-rgba-warning' : ''}}">
                                    <div class="card-header">
                                        <h4 class="text-bold-600">
                                            🚚 {{$form_delivery === "create" ? "Nova Entrega" : "Editar Entrega"}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 form-group">
                                                <label for="entrega_produto_id">Produto</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="entrega_produto_id">
                                                    <option value="" selected hidden>Selecione um produto</option>
                                                    @foreach ($venda->produtos as $produto)
                                                    
                                                        <option value="{{$produto->id}}" >{{$produto->name}}</option>
                                                        {{-- 
                                                        <option value="{{$produto->id}}" >{{$produto->name}}</option>
                                                        --}}
                                                    @endforeach
                                                </select>
                                                @error('entrega_produto_id')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                                {{-- armazém --}}
                                            <div class="col-3 form-group">
                                                <label for="entrega_armazem_id">Armazém</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="entrega_armazem_id">
                                                    <option value="" selected hidden>Selecione um Armazem</option>
                                                    @foreach ($armazens as $armazem)
                                                        <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('entrega_armazem_id')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-3 form-group">
                                                <label for="entrega_delivery_date">Retirada</label><span class="text-danger">*</span>
                                                <input type="date" class="form-control" wire:model.defer="entrega_delivery_date">
                                                @error('entrega_delivery_date')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-3 form-group">
                                                <label for="entrega_qtd_delivered">Qtd Entregue</label><span class="text-danger">*</span>
                                                <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="entrega_qtd_delivered">
                                                @error('entrega_qtd_delivered')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-75">
                                                <div class="row">
                                                    @if ($form_delivery === "create")
                                                    <div class="col-12">
                                                        <a href="#" wire:click.prevent="novaEntrega" class="btn btn-light-success btn-block">
                                                            <i class="bx bx-save mr-2"></i>
                                                            + INCLUIR ENTREGA
                                                        </a>
                                                    </div>
                                                    @else
                                                    <div class="col-6">
                                                        <a href="#" wire:click.prevent="updateEntrega" class="btn btn-warning btn-block">
                                                            <i class="bx bx-edit mr-2"></i>
                                                            EDITAR ENTREGA
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="#" wire:click.prevent="cancel" class="btn btn-secondary btn-block">
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
                                        <h4 class="card-title">Produtos Entregues</h4>
                                    </div>
                                    <div class="card-body">
                                        @if ($venda->entregas->count() > 0)
                                            <div class="row">
                                                <div class="col-12 table-responsive table-hover">
                                                    <table class="table mb-0">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th style="width: 35%;" >Produto</th>
                                                                <th style="width: 25%;" >Armazém</th>
                                                                <th style="width: 15%;" class="text-center">
                                                                    Qtd <br>
                                                                    (entregue)
                                                                </th>
                                                                <th style="width: 10%;" >Entrega</th>
                                                                <th style="width: 15%;" class="text-center">Ações</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                            @foreach ($venda->entregas as $entrega)
                                                            <tr>
                                                                <td>
                                                                    <div class="list-content">
                                                                        <span class="list-title">
                                                                            <h6 class="text-bold-600">
                                                                                {{$produtos->find($entrega->entrega_produto_id)->name}}
                                                                            </h6>
                                                                        </span>
                                                                        <small class="text-muted d-block">
                                                                            @foreach ($produtos->find($entrega->entrega_produto_id)->insumos as $insumo)
                                                                                [<strong>{{$insumo->name}}</strong>: {{number_format($insumo->pivot->percent, 1, ",", ".") . "%"}}] 
                                                                            @endforeach
                                                                        </small>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{$armazens->find($entrega->entrega_armazem_id)->name}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ number_format($entrega->entrega_qtd_delivered, 1, ",", ".") . "m³"}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ date("d/m/y", strtotime($entrega->entrega_delivery_date)) }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="invoice-action">
                                                                        <a href="" wire:click.prevent="showEditFormDelivery({{$entrega->id}})" class="text-warning mr-1 cursor-pointer">
                                                                            <i class="bx bx-edit"></i>
                                                                        </a>
                                                                        @if ($venda->produtos->count() > 1)
                                                                        <a href="" wire:click.prevent='confirmDeleteEntrega({{$entrega->id}})' class="text-danger cursor-pointer">
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
                                        @else
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="alert alert-warning outline" role="alert">
                                                        <p class="mb-0">Nenhuma entrega registrada para esta venda.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>                        
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12 mb-2">
                                <button class="btn btn-danger btn-block" wire:click.prevent="pergunta">
                                    <i class="bx bx-block mr-2"></i>
                                    ENCERRAR VENDA
                                </button>
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
                    <a  wire:click.prevent="updateVenda" class="btn btn-success btn-block">
                        <i class="bx bx-save mr-1"></i>
                        ATUALIZAR VENDA
                    </a>
                </div>

                <div class="invoice-action-btn mb-1">
                    <a href="" wire:click.prevent='deleteConfirmationVenda' class="btn btn-light-danger btn-block">
                        <i class="bx bx-block mr-1"></i>
                        EXCLUIR VENDA
                    </a>
                </div>

                <div class="invoice-action-btn mb-1">
                    <a href="{{route('vendas.index')}}" class="btn btn-light-secondary btn-block">
                        <i class="bx bx-x mr-1"></i>
                        SAIR
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener("venda-atualizada", function(){
            toastr.success('Dados da venda atualizados.', 'Fala comigo!', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("confirma-exclusao-produto", function(){

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
                    Livewire.emit('deleteProduto')
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
        window.addEventListener("confirma-exclusao-venda", function(){
  
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
                    Livewire.emit('deleteVenda')
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
        window.addEventListener("confirma-encerra-venda", function(){
  
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger mr-1'
              },
              buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
              title: 'Encerrar Venda',
              text: "Realmente quer encerrar?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sim, encerrar!',
              cancelButtonText: 'Não, cancelar!',
              reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {
                    Livewire.emit('encerraVenda')
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
        window.addEventListener("sucesso-deleta-venda", function(){
        toastr.success('Venda excluída com sucesso.', 'Agora já era!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
        })
        })
    </script>
    <script>
        window.addEventListener("produto-inserido", function(){
            toastr.success('Produto inserido com sucesso.', 'Showww 🤟', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("nova-entrega", function(){
            toastr.success('Entrega registrada com sucesso.', 'Boooaaaa 🤟', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("entrega-editada", function(){
            toastr.success('Entrega atualizada com sucesso.', 'Mandou bem! 🤟', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("sucesso-deleta-entrega", function(){
            toastr.success('Entrega excluída com sucesso.', 'Agora já era!! 🤟', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("venda-encerrada", function(){
            toastr.success('Venda encerrada com sucesso!.', 'Agora já era!! 🤟', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>

</div>
