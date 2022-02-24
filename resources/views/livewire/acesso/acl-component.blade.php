<div class="row">

    <div class="col-12">
      <div class="row">
        
        {{-- ROLES --}}
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card border {{$role_form != "create" ? "bg-rgba-warning" : ""}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control  @error('role_name') is-invalid @enderror" wire:keydown.enter="{{$role_form === "create" ? "createRole" : "updateRole" }}" placeholder="Informe o nome do Perfil" name="role_name" id="role_name" wire:model.defer="role_name">
                                                @error('role_name')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            @if ($role_form === "create")
                                            <a wire:click.prevent="createRole" class="btn btn-success btn-block glow mr-sm-1 mb-1">Criar</a>
                                            @else
                                            <a wire:click.prevent="updateRole" class="btn btn-warning btn-block glow mr-sm-1 mb-1">Atualizar</a>
                                            @endif
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            <button type="reset" wire:click.prevent="cancel" class="btn btn-danger btn-block mb-1">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            
                                <div class="card-header">
                                    <h4 class="text-bold-600">
                                        Níveis de Acesso
                                        <span class="badge badge-secondary py-auto my-auto ml-1">{{$role_count->count()}}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                    Abaixo estão listados todos os níveis de permissão da plataforma.
                                    </p>
                                    <ul class="list-group" id="basic-list-group">
                                    @foreach ($roles as $role)
                                        <li class="list-group-item draggable">
                                            <div class="media">
                                            <div class="media-body">
                                                <h5 class="text-bold-600 mb-0">
                                                {{$role->name}}
                                                </h5>
                                            </div>
                                            <div class="invoice-action">
                                                <a href="" wire:click.prevent='showEditFormRole({{$role->id}})' class="text-warning mr-1 cursor-pointer">
                                                <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="" wire:click.prevent='confirmationDeleteRole({{$role->id}})' class="text-danger cursor-pointer">
                                                <i class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                    <div class="mt-2">
                                    {{$roles->links()}}
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- PERMISSIONS--}}
        <div class="col-4">
            <div class="card">
                <div class="card-body">                  
                    <div class="row">
                        <div class="col-12">
                            <div class="card border {{$permission_form != "create" ? "bg-rgba-warning" : ""}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control  @error('permission_name') is-invalid @enderror" wire:keydown.enter="{{$permission_form === "create" ? "createPermission" : "updatePermission" }}" placeholder="Informe o nome da permissão" name="permission_name" id="permission_name" wire:model.defer="permission_name">
                                                @error('permission_name')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            @if ($permission_form === "create")
                                            <a wire:click.prevent="createPermission" class="btn btn-success btn-block glow mr-sm-1 mb-1">Criar</a>
                                            @else
                                            <a wire:click.prevent="updatePermission" class="btn btn-warning btn-block glow mr-sm-1 mb-1">Atualizar</a>
                                            @endif
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            <button type="reset" wire:click.prevent="cancel" class="btn btn-danger btn-block mb-1">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            
                                <div class="card-header">
                                    <h4 class="text-bold-600">
                                        Permissões de Acesso
                                        <span class="badge badge-secondary py-auto my-auto ml-1">{{$permission_count->count()}}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                    Abaixo estão istadas todas as permissões da plataforma.
                                    </p>
                                    <ul class="list-group" id="basic-list-group">
                                    @foreach ($permissions as $permission)
                                        <li class="list-group-item draggable">
                                            <div class="media">
                                            <div class="media-body">
                                                <h5 class="text-bold-600 mb-0">
                                                {{$permission->name}}
                                                </h5>
                                            </div>
                                            <div class="invoice-action">
                                                <a href="" wire:click.prevent='showEditFormPermission({{$permission->id}})' class="text-warning mr-1 cursor-pointer">
                                                <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="" wire:click.prevent='confirmationDeletePermission({{$permission->id}})' class="text-danger cursor-pointer">
                                                <i class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                    <div class="mt-2">
                                    {{$permissions->links()}}
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- VÍNCULOS --}}
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="role_id">Perfil</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="role_id">
                                                    <option value="" selected hidden>Selecione um perfil</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_Id')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="permission_id">Permissão</label><span class="text-danger">*</span>
                                                <select class="form-control" wire:model.defer="permission_id">
                                                    <option value="" selected hidden>Selecione uma permissão</option>
                                                    @foreach ($permissions as $permission)
                                                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('permission_id')
                                                    <span class="text-danger">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            <a wire:click.prevent="relacionar" class="btn btn-success btn-block glow mr-sm-1 mb-1">Vincular</a>
                                        </div>
                                        <div class="col-6 py-auto my-auto">
                                            <button type="reset" wire:click.prevent="cancel" class="btn btn-danger btn-block mb-1">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            
                                <div class="card-header">
                                    <h4 class="text-bold-600">
                                        Perfis de Acesso
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                    Abaixo todos os níveis de acesso e suas respectivas permissões.
                                    </p>
                                    <div class="accordion collapse-icon accordion-icon-rotate" id="accordionWrapa2">
                                        @foreach ($roles as $role)
                                        <div class="card collapse-header">
                                            <div id="heading5" class="card-header" data-toggle="collapse" data-target="#accordion{{$role->id}}" aria-expanded="false" aria-controls="accordion5" role="tablist">
                                                <span class="collapse-title">
                                                    <i class="bx bx-lock-alt align-middle"></i>
                                                    <span class="align-middle">{{$role->name}}</span>
                                                    <span class="badge badge-secondary py-auto my-auto ml-1">{{$role->permissions->count()}}</span>
                                                </span>
                                            </div>
                                            <div id="accordion{{$role->id}}" role="tabpanel" data-parent="#accordionWrapa2" aria-labelledby="heading5" class="collapse">
                                                <div class="card-body">
                                                    <ul class="list-group" id="basic-list-group">
                                                        @foreach ($role->permissions as $permission)
                                                            <li class="list-group-item draggable">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <h6 class="mb-0">
                                                                        {{$permission->name}}
                                                                        </h6>
                                                                    </div>
                                                                    <div class="invoice-action">
                                                                        <a href="" wire:click.prevent='removePermission({{$role->id}}, {{$permission->id}})' class="text-danger cursor-pointer">
                                                                        <i class="bx bx-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>



                                    {{------}}
                                    
                                    
                                    <div class="mt-2">
                                    
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

      </div>
    </div>

    {{-- roles --}}
    <script>
        window.addEventListener("role-created", function(){
          toastr.success('Perfil criado com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>
    <script>
        window.addEventListener("role-updated", function(){
          toastr.success('Perfil atualizado com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>
    <script>
        window.addEventListener("role-delete-confirmation", function(){
  
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
                    Livewire.emit('deleteRole')
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
        window.addEventListener("role-deleted", function(){
          toastr.danger('Perfil excluído com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>
    {{-- permissions --}}
    <script>
        window.addEventListener("permission-created", function(){
        toastr.success('Permissão criada com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
        })
        })
    </script>
    <script>
        window.addEventListener("permission-updated", function(){
        toastr.success('Permissão atualizada com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
        })
        })
    </script>
    <script>
        window.addEventListener("permission-delete-confirmation", function(){

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
                    Livewire.emit('deletePermission')
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
        window.addEventListener("permission-deleted", function(){
        toastr.success('Permissão excluída com sucesso', 'Show de bola!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
        })
        })
    </script>

    {{-- VÍNCULOS --}}
    <script>
        window.addEventListener("vinculo-created", function(){
            toastr.success('Vínculo criado com sucesso', 'Show de bola!', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>
    <script>
        window.addEventListener("vinculo-deleted", function(){
            toastr.success('Vínculo excluído com sucesso', 'Show de bola!', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>


  </div>