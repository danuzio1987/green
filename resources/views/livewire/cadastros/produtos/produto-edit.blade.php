<div class="row match-height">

    <div class="col-9">
        <div class="card">
            <div class="card-body pb-0 mx-25">
                <div class="row">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nome</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="name" name="name" wire:model.defer='name' placeholder="Identifique o novo produto" autocomplete="off">
                                    @error('name')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-8">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">Composição do Produto (Insumos)</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive table-hover">
                                                <table class="table mb-0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th style="width: 50%;" >Insumo</th>
                                                            <th style="width: 30%;" class="text-center">%</th>
                                                            <th style="width: 20%;">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @foreach ($produto->insumos as $insumo)
                                                        <tr>
                                                            <td>
                                                                <h6 class="text-bold-600">
                                                                    {{$insumo->name}}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ number_format($insumo->pivot->percent, 1, ",", ".") . "%"}}
                                                            </td>
                                                            <td>
                                                                <div class="invoice-action">
                                                                    <a href="" wire:click.prevent="showEditFormInsumo({{$insumo->id}})" class="text-warning mr-1 cursor-pointer">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                    <a href="" wire:click.prevent='deleteConfirmationInsumo({{$insumo->id}})' class="text-danger cursor-pointer">
                                                                        <i class="bx bx-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="bg-rgba-secondary">
                                                            <th>TOTAL</th>
                                                            <th class="text-center">{{ number_format($verifica_soma, 1, ",", ".") . "%" }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="card border {{$form_mode === "edit" ? 'bg-rgba-warning' : ''}}">
                                        <div class="card-header">
                                            <h4 class="text-bold-600">
                                                {{$form_mode === "create" ? "Inserir Insumo" : "Editar Insumo"}}
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="">Insumo</label><span class="text-danger">*</span>
                                                    <select class="form-control" wire:model.defer="insumo_id">
                                                        <option value="" selected hidden>Selecione um insumo</option>
                                                        @foreach ($insumos as $insumo)
                                                            <option value="{{$insumo->id}}" {{ $produto->insumos()->find($insumo->id) ? "hidden" : '' }} >{{$insumo->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('insumo_id')
                                                        <span class="text-danger">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label for="percent">%</label><span class="text-danger">*</span>
                                                    <input type="number" min="0" max="100" step="1" class="form-control" placeholder="0,0%" wire:model.defer="percent">
                                                    @error('percent')
                                                        <span class="text-danger">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mt-75">
                                                    @if ($form_mode === "create")
                                                    <a href="#" wire:click.prevent="inserirInsumo" class="btn btn-light-success btn-block">+ INCLUIR INSUMO</a>
                                                    @else
                                                    <a href="#" wire:click.prevent="editInsumo" class="btn btn-warning btn-block">+ EDITAR INSUMO</a>
                                                    <a href="#" wire:click.prevent="start" class="btn btn-secondary btn-block">CANCELAR</a>
                                                    @endif
                                                </div>
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

                @if ($verifica_soma == 100)
                <div class="invoice-action-btn mb-1">
                    <a  wire:click.prevent="updateProduto" class="btn btn-success btn-block">
                        <i class="bx bx-save mr-1"></i>
                        ATUALIZAR PRODUTO
                    </a>
                </div>
                @endif

                <div class="invoice-action-btn mb-1">
                    <a href="" wire:click.prevent='deleteConfirmationProduto' class="btn btn-light-danger btn-block">
                        <i class="bx bx-block mr-1"></i>
                        CANCELAR PRODUTO
                    </a>
                </div>

                <div class="invoice-action-btn mb-1">
                    <a href="{{route('produtos.index')}}" class="btn btn-light-secondary btn-block">
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
        window.addEventListener("confirma-exclusao-produto", function(){
  
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
        window.addEventListener("sucesso-deleta-insumo", function(){
          toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>
    <script>
        window.addEventListener("sucesso-edita-produto", function(){
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

