<div class="row">
    <div wire:loading>
        <div style="display: flex; justify-content: center; align-items: center; background-color:#67bd52; position: fixed; top:0px; left:0px; z-index: 9999; width:100%; height:100%; opacity:.9;">
            @include('panels.loading')
        </div>
    </div>
    <div class="col-12">
        <div class="alert border-info alert-dismissible mb-2" role="alert">
            <div class="d-flex align-items-center">
                <i class="bx bx-error-circle"></i>
                <span>
                    Será enviado um e-mail solicitando que a pessoa convidada faça seu cadastro na plataforma.
                </span>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="first_name">Primeiro Nome</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="Informe o primeiro nome" wire:model.defer="first_name">
            @error('first_name')
                <span class="text-danger">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="last_name">Último Nome</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Informe o último nome" wire:model.defer="last_name">
            @error('last_name')
                <span class="text-danger">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Informe e-mail válido" wire:model.defer="email">
            @error('email')
                <span class="text-danger">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="role_id">Permissão</label><span class="text-danger">*</span>
            <select class="form-control" wire:model.defer="role_id">
                <option value="" selected hidden>Selecione uma Perfil</option>
                @foreach ($roles as $role)
                    <option value="{{$role->id}}" {{$role->id == 1 ? "hidden" : ''}}>{{$role->name}}</option>
                @endforeach
            </select>
            @error('role_id')
                <span class="text-danger">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
        <a wire:click.preven="sendInvite" class="btn btn-primary glow mr-sm-1 mb-1">
            <i class="bx bx-mail-send mr-1"></i>
            Enviar Convite
        </a>
        <a wire:click.prevent="cancelInvite" class="btn btn-light mb-1">
            Cancelar
        </a>
    </div>
</div>