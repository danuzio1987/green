<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE PRODUTO --}}
    @if ($insumos->count() > 0)
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                        <h4 class="text-bold-600">
                            {{$form_mode === "edit" ? "Editar Produto" : "Cadastrar Produto"}}
                        </h4>
                        </div>
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
                            @if ($form_mode === "create")
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h4 class="card-title">Composição (Insumos)</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 mb-50">
                                                    <label class="text-nowrap">Nome do Insumo</label><span class="text-danger">*</span>
                                                </div>
                                                <div class="col-6 mb-50">
                                                    <label class="text-nowrap">% na Composição</label><span class="text-danger">*</span>
                                                </div>
                                            </div>
                                            {{-- PRIMEIRA LINHA DE INSUMO --}}
                                            <div class="row justify-content-between">
                                                <div class="col-6 form-group">
                                                    <select class="form-control" wire:model="insumo_id.0">
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
                                                    <input type="number" min="0" max="100" step="1" class="form-control" placeholder="000" wire:model="percent.0">
                                                    @error('percent.0')
                                                        <span class="text-danger">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-2 form-group text-center">
                                                    <a class="btn btn-success btn-block" wire:click.prevent="add({{$i}})">
                                                        <i class="bx bx-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            {{-- LINHAS DINÂMICAS DE INSUMO --}}
                                            @foreach ($inputs as $key => $value)
                                                <div class="row justify-content-between">
                                                    <div class="col-6 form-group">
                                                        <select class="form-control" wire:model="insumo_id.{{$value}}" required>
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
                                                        <input type="number" min="0" max="100" step="1" class="form-control" placeholder="000" wire:model="percent.{{$value}}">
                                                        @error('percent.'.$value)
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
                                            <div class="row">
                                                <div class="col-12 mt-50">
                                                    <h6 class="text-bold-500">Total da composição: <strong>{{$verifica_soma}}</strong>%</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    @if ($verifica_soma === 100)
                                                        <div class="alert border-success alert-dismissible" role="alert">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bx bx-like"></i>
                                                                <span>
                                                                    <strong>Show!!</strong>... pode salvar seu produto!
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert border-warning alert-dismissible" role="alert">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bx bx-error-circle"></i>
                                                                <span>
                                                                    Para criar o produto, a soma dos insumos na composição deve ser igual a <strong>100</strong>!
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                   
                            @endif 
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
                                    @if ($verifica_soma === 100)
                                    <a href="" wire:click.prevent='createProduto' class="btn btn-light-success mr-1">
                                        <i class="bx bx-save mr-1"></i>
                                        Criar
                                    </a>
                                    @endif
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
        <div class="col-6">
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
                                    Para criar um produto é necessário pelo menos um insumo cadastrado!
                                </div>
                                <div class="col-12">
                                    <a href="{{route('insumos.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR INSUMO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- LISTA DAS PRODUTOS CADASTRADOS --}}
    <div class="col-6">
        <div class="row">
            <div class="col-12">
              <div class="card">
                @if ($produtos->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Produtos
                    </h4>
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listadas todos os produtos cadastrados na plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($produtos as $produto)
                          <li class="list-group-item draggable">
                            <div class="media">
                              <div class="media-body">
                                <div class="list-content">
                                  <span class="list-title">
                                      <h5 class="text-bold-600">
                                          {{$produto->name}}
                                      </h5>
                                  </span>
                                  <small class="text-muted d-block">
                                      @foreach ($produto->insumos as $insumo)
                                          [<strong>{{$insumo->name}}</strong>: {{number_format($insumo->pivot->percent, 1, ",", ".") . "%"}}] 
                                      @endforeach
                                  </small>
                              </div>
                              </div>
                              <div class="invoice-action py-auto my-auto">
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="text-warning mr-1 cursor-pointer">
                                  <i class="bx bx-edit"></i>
                                </a>
                                <a href="" wire:click.prevent='deleteConfirmationProduto({{$produto->id}})' class="text-danger cursor-pointer">
                                  <i class="bx bx-trash"></i>
                                </a>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$produtos->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Produtos
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
      window.addEventListener("sucesso-salva-produto", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
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
      window.addEventListener("sucesso-deleta-produto", function(){
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

</div>