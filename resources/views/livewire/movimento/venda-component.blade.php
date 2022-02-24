<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE VENDA --}}
    @if ( $clientes->count() > 0 && $produtos->count() > 0)
        <div class="col-7">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                            <h4 class="text-bold-600">
                                {{$form_mode === "edit" ? "Editar Venda" : "Nova Venda"}}{{$sale_mode === "recorrente" ? " - PLANEJAMENTO" : ""}}
                            </h4>
                            @if ($sale_mode === "unica" && $form_mode === "create")
                                <a href="" wire:click.prevent="saleMode" class="btn btn-icon btn-warning mb-1" >
                                    <i class="bx bx-rotate-left"></i>
                                </a>
                            @endif
                        </div>
                        <div class="card-body">

                            <div class="row">
                                {{-- status da venda --}}
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="type">Status</label>
                                        <select class="form-control" name="type" id="type" wire:model.defer="type" disabled>
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
                                {{-- datas --}}
                                @if ($sale_mode === "recorrente")
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="inicio_recorrencia">Início</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control" id="inicio_recorrencia" name="inicio_recorrencia" wire:model.defer='inicio_recorrencia'>
                                            @error('inicio_recorrencia')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="termino_recorrencia">Final</label><span class="text-danger">*</span>
                                            <input type="date" class="form-control" id="termino_recorrencia" name="termino_recorrencia" wire:model.defer='termino_recorrencia' placeholder="dd/mm/aaaa">
                                            @error('termino_recorrencia')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
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
                                @endif
                                {{-- tipo de venda --}}
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="mode">Modo de Venda</label><span class="text-danger">*</span>
                                        <select class="form-control" name="mode" id="mode" wire:model.defer="mode">
                                            <option value="" selected hidden>Modo de venda</option>
                                            <option value="normal">Venda Normal</option>
                                            <option value="antecipacao">Antecipação</option>
                                            <option value="propriedade">Mud. de Propriedade</option>
                                        </select>
                                        @error('mode')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- cliente --}}
                                <div class="col-8">
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
                                {{-- documento --}}
                                <div class="col-4">
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
                                {{-- PRODUTOS --}}
                                <div class="col-12">
                                    {{-- primeira linha de produto --}}
                                    <div class="row justify-content-between">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="produto_id">Produto</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="produto_id.0">
                                                    <option value="" selected hidden>Selecione um produto</option>
                                                    @foreach ($produtos as $produto)
                                                        <option value="{{$produto->id}}">{{$produto->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('produto_id.0')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
                                                <select class="form-control" name="armazem_id" id="armazem_id" wire:model.defer="armazem_id.0">
                                                    <option value="" selected hidden>Selecione um Armazem</option>
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
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="qtd">Qtd (m³)</label><span class="text-danger">*</span>
                                                <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd.0">
                                                @error('qtd.0')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-2 form-group text-center">
                                            <label class="text-nowrap">Ação</label>
                                            <button class="btn btn-success btn-block" wire:click.prevent="add({{$i}})">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- demais linhas de produto [dinâmicas] --}}
                                    @foreach ($inputs as $key => $value)
                                    <div class="row justify-content-between">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control" wire:model.defer="produto_id.{{$value}}">
                                                    <option value="" selected hidden>Selecione um produto</option>
                                                    @foreach ($produtos as $produto)
                                                        <option value="{{$produto->id}}">{{$produto->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('produto_id'.$value)
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control"  wire:model.defer="armazem_id.{{$value}}">
                                                    <option value="" selected hidden>Selecione um Armazem</option>
                                                    @foreach ($armazens as $armazem)
                                                        <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('armazem_id'.$value)
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="number" min="0" class="form-control" placeholder="0.00m³" wire:model.defer="qtd.{{$value}}">
                                                @error('qtd'.$value)
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
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

                            {{-- BOTÕES DO FORMULÁRIO --}}
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex justify-content-start">
                                        <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        
                                        @if ($form_mode === "edit")
                                            <a href="" wire:click.prevent='editVenda' class="btn btn-warning mr-1">
                                                <i class="bx bx-save mr-1"></i>
                                                Atualizar
                                            </a>
                                        @else
                                            @if ($sale_mode === "recorrente")
                                            <a href="" wire:click.prevent='createVendaRecorrente' class="btn btn-light-success mr-1">
                                                <i class="bx bx-rotate-left mr-1"></i>
                                                Criar Recorrência
                                            </a>
                                            @else
                                            <a href="" wire:click.prevent='createVenda' class="btn btn-light-success mr-1">
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
                                    Para criar um pedido é necessário <strong>USINAS</strong>, <strong>ARMAZÉNS</strong>, <strong>INSUMOS</strong> e <strong>FORNECEDORES</strong> cadastrados.
                                </div>
                                <div class="col-12">
                                    @if ($produtos->count() === 0)
                                        <a href="{{route('produtos.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAS PRODUTOS</a>
                                    @endif
                                    @if ($clientes->count() === 0)
                                        <a href="{{route('clientes.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR CLIENTE</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- LISTA DAS VENDAS CADASTRADAS --}}
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
                          <label for="search_produtos">Produtos</label>
                          <fieldset class="form-group">
                            <select class="form-control" name="search_produtos" id="search_produtos" wire:model="search_produtos" >
                                <option value="">Todos</option>
                                @foreach ($produtos as $produto)
                                <option value="{{$produto->id}}">{{$produto->name}}</option>
                                @endforeach
                            </select>
                          </fieldset>
                        </div>
                        <div class="col-5">
                            <label for="search_delivery">Data da Venda</label>
                            <fieldset class="form-group">
                              <input type="date" class="form-control" wire:model="search_delivery">
                            </fieldset>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
              <div class="card">
                @if ($vendas->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600 position-relative d-inline-block">
                      <span class="mr-50">Lista de Vendas </span>
                      <span class="badge badge-pill badge-success badge-up badge-round badge-glow">{{$allVendas->count()}}</span>
                    </h4>
                    
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listadas todas as vendas cadastradas na plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($vendas as $venda)
                          <li class="list-group-item draggable">
                            <div class="media">
                              <div class="media-body">
                                <span class="bullet bullet-{{$venda->details->count() > 0 && $venda->details()->first()->type === "forecast" ? "warning" : "success"}} bullet-sm"></span>
                                <div class="badge badge-pill badge-light-secondary">{{ number_format(abs($venda->produtos->sum("pivot.qtd_sale")) , 1, ",", ".") . "m³"}}</div>
                                @if ($venda->notes !== "")
                                <i class="bx bx-comment-dots"></i>
                                @endif
                                <span class="text-bold-600 mb-0 ml-50">
                                    {{ date('d/m', strtotime($venda->sale_date)) }}
                                </span>
                                <div class="position-relative d-inline-block mr-2">
                                    <small class="text-muted ml-50">{{mb_strtoupper($venda->cliente->name)}}</small>
                                    <span class="badge badge-pill badge-secondary badge-round ml-50">
                                        {{$venda->details->count()}}
                                    </span>
                                   
                                </div>
                              </div>
                              <div class="invoice-action">
                                <a href="{{route('vendas.edit', $venda->id)}}" class="text-warning mr-1 cursor-pointer">
                                  <i class="bx bx-edit"></i>
                                </a>
                                <a href="" wire:click.prevent='deleteConfirmationVenda({{$venda->id}})' class="text-danger cursor-pointer">
                                  <i class="bx bx-trash"></i>
                                </a>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$vendas->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Vendas
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
      window.addEventListener("sucesso-salva-venda", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
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
      window.addEventListener("sucesso-deleta-venda", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-venda", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>

</div>