<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE USINA --}}
    <div class="col-6">
        <div class="row">
            <div class="col-12">
              <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                <div class="card-header">
                  <h4 class="text-bold-600">
                      {{$form_mode === "edit" ? "Editar Armazém" : "Cadastrar Armazém"}}
                  </h4>
                </div>
                <div class="card-body">
                  <div class="row">
                      <div class="col-12">
                          <div class="form-group">
                              <label for="name">Nome</label><span class="text-danger">*</span>
                              <input type="text" class="form-control" id="name" name="name" wire:model.defer='name' wire:keydown.enter="createArmazem" placeholder="Identifique o novo armazém" autocomplete="off">
                              @error('name')
                                  <span class="text-danger">
                                      <small>{{ $message }}</small>
                                  </span>
                              @enderror
                          </div>
                      </div>       
                      <div class="col-12 ">
                        <div class="d-flex justify-content-start">
                          <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                        </div>
                        <div class="d-flex justify-content-end">
                          @if ($form_mode === "edit")
                            <a href="" wire:click.prevent='editArmazem' class="btn btn-warning mr-1">
                              <i class="bx bx-save mr-1"></i>
                              Atualizar
                            </a>
                          @else
                            <a href="" wire:click.prevent='createArmazem' class="btn btn-light-success mr-1">
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
    {{-- LISTA DAS USINAS CADASTRADAS --}}
    <div class="col-6">
        <div class="row">
            <div class="col-12">
              <div class="card">
                @if ($armazens->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Armazéns
                    </h4>
                  </div>
                  <div class="card-body">
                      <p>
                        Abaixo estão listados todos os armazéns cadastrados na plataforma.
                      </p>
                      <ul class="list-group" id="basic-list-group">
                        @foreach ($armazens as $armazem)
                          <li class="list-group-item draggable">
                            <div class="media">
                              <div class="media-body">
                                <h5 class="text-bold-600 mb-0">
                                  {{$armazem->name}}
                                </h5>
                              </div>
                              <div class="invoice-action">
                                <a href="" wire:click.prevent='showEditFormArmazem({{$armazem->id}})' class="text-warning mr-1 cursor-pointer">
                                  <i class="bx bx-edit"></i>
                                </a>
                                <a href="" wire:click.prevent='deleteConfirmationArmazem({{$armazem->id}})' class="text-danger cursor-pointer">
                                  <i class="bx bx-trash"></i>
                                </a>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                      <div class="mt-2">
                        {{$armazens->links()}}
                      </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Lista de Armazéns 
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
      window.addEventListener("sucesso-salva-armazem", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("confirma-exclusao-armazem", function(){

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
                  Livewire.emit('deleteArmazem')
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
      window.addEventListener("sucesso-deleta-armazem", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-armazem", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>


</div>