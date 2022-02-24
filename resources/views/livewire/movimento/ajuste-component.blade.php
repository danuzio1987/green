<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE AJUSTE --}}
    @if ( $insumos->count() > 0 && $armazens->count() > 0)
        <div class="col-7">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                            <h4 class="text-bold-600">
                                {{$form_mode === "edit" ? "Editar Ajuste" : "Novo Ajuste"}}
                            </h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="adjust_date">Data do Ajuste</label><span class="text-danger">*</span>
                                        <input type="date" class="form-control" id="adjust_date" name="adjust_date" wire:model.defer='adjust_date'>
                                        @error('adjust_date')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="moviment_type">Tipo de Ajuste</label><span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="moviment_type">
                                            <option value="" selected hidden>Defina o ajuste</option>
                                            <option value="entrada">Entrada</option>
                                            <option value="saida">Saída</option>
                                        </select>
                                        @error('moviment_type')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="insumo_id">Insumo transferido</label><span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="insumo_id">
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
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="armazem_id">
                                            <option value="" selected hidden>Selecione um armazém</option>
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
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="qtd">Qtd (m³)</label><span class="text-danger">*</span>
                                        <input type="number" min="0" max="100" step="1" class="form-control" placeholder="0.00m³" wire:model.defer="qtd">
                                        @error('qtd')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                            </div>

                            <div class="row">
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

                        </div>
                        <div class="card-footer">
                            {{-- BOTÕES DO FORMULÁRIO --}}
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="d-flex justify-content-start">
                                        <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        @if ($form_mode === "edit")
                                            <a href="" wire:click.prevent='editAjuste' class="btn btn-warning mr-1">
                                                <i class="bx bx-save mr-1"></i>
                                                Atualizar
                                            </a>
                                        @else
                                            <a href="" wire:click.prevent='createAjuste' class="btn btn-light-success mr-1">
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
                                    Para criar um pedido é necessário <strong>USINAS</strong>, <strong>ARMAZÉNS</strong>, <strong>INSUMOS</strong> e <strong>FORNECEDORES</strong> cadastrados.
                                </div>
                                <div class="col-12">
                                    @if ($insumos->count() === 0)
                                        <a href="{{route('produtos.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAS INSUMOS</a>
                                    @endif
                                    @if ($armazens->count() === 0)
                                        <a href="{{route('clientes.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR ARMAZÉNS</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- LISTA DAS AJUSTES CADASTRADOS --}}
    <div class="col-5">
        <div class="row">
            <div class="col-12">
              <div class="users-list-filter px-1">
                  <form>
                    <div class="row border rounded py-2 mb-2">
                      <div class="col-4">
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
                      <div class="col-8">
                          <label for="search_date">Data do Ajuste</label>
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
                @if ($ajustes->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600 position-relative d-inline-block">
                      <span class="mr-50">Lista de Ajustes </span>
                      <span class="badge badge-pill badge-success badge-up badge-round badge-glow">{{$allAjustes->count()}}</span>
                    </h4>
                    
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listados todos os ajustes cadastrados na plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($ajustes as $ajuste)
                          <li class="list-group-item draggable">
                            <div class="media">
                              <div class="media-body">
                                
                                <div class="badge badge-pill badge-light-{{$ajuste->details->moviment_type === "entrada" ? "success" : "danger"}}">
                                  {{ number_format(abs($ajuste->details->qtd), 1, ",", ".") . "m³" }}
                                </div>
                                @if ($ajuste->notes !== "")
                                  <i class="bx bx-message-dots"></i>
                                @endif
                                
                                <span class="text-bold-600 mb-0 ml-75">
                                    {{ date("d/m", strtotime($ajuste->adjust_date)) }}
                                </span>
                                <div class="position-relative d-inline-block mr-2">
                                  |
                                  <small class="text-muted">{{ $armazens->find($ajuste->details->armazem_id)->name }}</small>
                                  |
                                  <small class="text-muted">{{ $insumos->find($ajuste->details->insumo_id)->name }}</small>
                                </div>
                              </div>
                              <div class="invoice-action">
                                <a href="" wire:click.prevent="showEditFormAjuste({{$ajuste->id}})" class="text-warning mr-1 cursor-pointer">
                                  <i class="bx bx-edit"></i>
                                </a>
                                <a href="" wire:click.prevent='deleteConfirmationAjuste({{$ajuste->id}})' class="text-danger cursor-pointer">
                                  <i class="bx bx-trash"></i>
                                </a>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$ajustes->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista Ajustes
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
      window.addEventListener("sucesso-salva-ajuste", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("confirma-exclusao-ajuste", function(){

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
                  Livewire.emit('deleteAjuste')
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
      window.addEventListener("sucesso-deleta-ajuste", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-ajuste", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>

</div>