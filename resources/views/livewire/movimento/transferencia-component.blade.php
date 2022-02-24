<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE TRANSFERÊNCIA --}}
    @if ( $insumos->count() > 0 && $armazens->count() > 0)
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                            <h4 class="text-bold-600">
                                {{$form_mode === "edit" ? "Editar Transferência" : "Nova Transferência"}}
                            </h4>
                        </div>
                        <div class="card-body">

                          <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="origem_id">SAINDO DE (ORIGEM)</label><span class="text-danger">*</span>
                                    <select class="form-control" wire:model="origem_id">
                                        <option value="" selected>Selecione um armazém</option>
                                        @foreach ($armazens as $armazem)
                                            <option value="{{$armazem->id}}" {{$destino_id == $armazem->id ? "hidden" : ""}}>{{$armazem->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('origem_id')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                  <label for="destino_id">INDO PARA (DESTINO)</label><span class="text-danger">*</span>
                                  <select class="form-control" wire:model="destino_id">
                                      <option value="" selected>Selecione um armazém</option>
                                      @foreach ($armazens as $armazem)
                                          <option value="{{$armazem->id}}" {{$origem_id == $armazem->id ? "hidden" : ""}} >{{$armazem->name}}</option>
                                      @endforeach
                                  </select>
                                  @error('destino_id')
                                      <span class="text-danger">
                                          <small>{{ $message }}</small>
                                      </span>
                                  @enderror
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-4">
                              <div class="form-group">
                                  <label for="transfer_date">Data da Carga</label><span class="text-danger">*</span>
                                  <input type="date" class="form-control" id="transfer_date" name="transfer_date" wire:model.defer='transfer_date'>
                                  @error('transfer_date')
                                      <span class="text-danger">
                                          <small>{{ $message }}</small>
                                      </span>
                                  @enderror
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="form-group">
                                  <label for="descarga_date">Data da Descarga</label><span class="text-danger">*</span>
                                  <input type="date" class="form-control" id="descarga_date" name="descarga_date" wire:model.defer='descarga_date'>
                                  @error('descarga_date')
                                      <span class="text-danger">
                                          <small>{{ $message }}</small>
                                      </span>
                                  @enderror
                              </div>
                            </div> 
                            <div class="col-4">
                                <label for="delivery_status">Status Descarga</label><span class="text-danger">*</span>
                                <select class="form-control" wire:model.defer="delivery_status">
                                    <option value="" selected>Informe Status</option>
                                    <option value="andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                                @error('delivery_status')
                                    <span class="text-danger">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                          </div>

                          <div class="row">
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
                              <div class="col-3">
                                <div class="form-group">
                                    <label for="qtd_origem">Qtd Saída</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" placeholder="0.00m³" wire:model.defer="qtd_origem">
                                    @error('qtd_origem')
                                        <span class="text-danger">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                              </div>
                              <div class="col-3">
                                <div class="form-group">
                                    <label for="qtd_destino">Qtd Chegada</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" placeholder="0.00m³" wire:model.defer="qtd_destino">
                                    @error('qtd_destino')
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
                                      <textarea name="notes" id="notes" wire:model.defer="notes"  rows="3" class="form-control" placeholder="Registre aqui as informações as informações mais relevantes desta transferência."></textarea>
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
                                            <a href="" wire:click.prevent='editTransferencia' class="btn btn-warning mr-1">
                                                <i class="bx bx-save mr-1"></i>
                                                Atualizar
                                            </a>
                                        @else
                                            <a href="" wire:click.prevent='createTransferencia' class="btn btn-light-success mr-1">
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
    {{-- LISTA DAS TRANSFERÊNCIAS CADASTRADAS --}}
    <div class="col-6">
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
                      <div class="col-3">
                        <label for="search_origem">Armazém Origem</label>
                        <fieldset class="form-group">
                          <select class="form-control" name="search_origem" id="search_origem" wire:model="search_origem" >
                              <option value="">Todos</option>
                              @foreach ($armazens as $armazem)
                              <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                              @endforeach
                          </select>
                        </fieldset>
                      </div>
                      <div class="col-3">
                        <label for="search_destino">Armazém Destino</label>
                        <fieldset class="form-group">
                          <select class="form-control" name="search_destino" id="search_destino" wire:model="search_destino" >
                              <option value="">Todos</option>
                              @foreach ($armazens as $armazem)
                              <option value="{{$armazem->id}}">{{$armazem->name}}</option>
                              @endforeach
                          </select>
                        </fieldset>
                      </div>
                      <div class="col-4">
                          <label for="search_date">Data</label>
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
                @if ($transferencias->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600 position-relative d-inline-block">
                      <span class="mr-50">Lista de Transferências</span>
                      <span class="badge badge-pill badge-success badge-up badge-round badge-glow">{{$allTransfer->count()}}</span>
                    </h4>
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listadas todas as transferências cadastradas na plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($transferencias as $transferencia)
                          <li class="list-group-item draggable">
                            <div class="media">
                                <div class="media-body">
                                    @if ($transferencia->delivery_status === "andamento")
                                      <i class="bx bxs-truck mr-50 text-warning"></i>
                                    @endif
                                    @if ($transferencia->delivery_status === "concluida")
                                      <i class="bx bx-check-double mr-50 text-success"></i>
                                    @endif
                                    <div class="badge badge-pill badge-light-secondary">
                                      {{ number_format(abs($transferencia->details()->where("detail_id", $transferencia->id)->first()->qtd), 1, ",", ".") . "m³" }}
                                    </div>
                                    @if ($transferencia->notes !== "")
                                        <i class="bx bx-message-dots"></i>
                                      @endif
                                    
                                    <div class="position-relative d-inline-block mr-2">
                                        <div class="d-inline-flex align-items-center mr-1">
                                          <i class="bx bx-down-arrow-alt font-size-base text-danger"></i>
                                          <span>{{$armazens->find($transferencia->origem_id)->name}}</span>
                                          <small class="ml-50 text-muted">
                                            ({{ date("d/m", strtotime($transferencia->transfer_date)) }})
                                          </small>
                                        </div>
                                        <div class="d-inline-flex align-items-center mr-1">
                                          <i class="bx bx-up-arrow-alt font-size-base text-success"></i>
                                          <span>{{$armazens->find($transferencia->destino_id)->name}}</span>
                                          <small class="ml-50 text-muted">
                                            ({{ date("d/m", strtotime($transferencia->descarga_date)) }})
                                          </small>
                                      </div>
                                    </div>
                                </div>
                                <div class="invoice-action">
                                    <a href="" wire:click.prevent='showFormEditTransferencia({{$transferencia->id}})' class="text-warning mr-1 cursor-pointer">
                                      <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="" wire:click.prevent='deleteConfirmationTransferencia({{$transferencia->id}})' class="text-danger cursor-pointer">
                                      <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$transferencias->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Transferências
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
      window.addEventListener("sucesso-salva-transferencia", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("confirma-exclusao-transferencia", function(){

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
                  Livewire.emit('deleteTransferencia')
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
      window.addEventListener("sucesso-deleta-transferencia", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-transferencia", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("nova-transferencia", function(e){

        Swal.fire({
              title: 'Transferência cadastrada!',
              html: 
                "<h3 class='text-bold-600'>" + e.detail.volume + 'm³ - ' + e.detail.insumo +'</h3>' + 
                "<h4><span class='text-danger'><i class='bx bx-down-arrow-alt'></i> <strong>" + e.detail.armazem_origem + '</strong></span></h4>' + 
                "<h4><span class='text-success'><i class='bx bx-up-arrow-alt'></i> <strong>" + e.detail.armazem_destino + '</strong></span></h4>',
              width: 600,
              padding: '5em',
              color: '#716add',
              background: '#fff',
              confirmButtonText:
              '<i class="bx bx-like mr-75"></i> Aí sim!',
              backdrop: `
                rgba(103,189,82,0.4)
                url("/gif/happy.gif")
                left top
                no-repeat
              `
            })
          
      })
    </script>

</div>