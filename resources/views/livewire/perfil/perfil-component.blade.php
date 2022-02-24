<div class="row">
    <div class="col-12">
      <div class="row">
        <!-- left menu section -->
        <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill"
                    href="#account-vertical-general" aria-expanded="true">
                    <i class="bx bx-cog"></i>
                    <span>Geral</span>
                </a>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill"
                    href="#account-vertical-info" aria-expanded="false">
                    <i class="bx bx-info-circle"></i>
                    <span>Informações</span>
                </a>
            </li>
            --}}
            @hasanyrole('Super Admin|Admin')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" id="account-pill-social" data-toggle="pill"
                    href="#account-vertical-social" aria-expanded="false">
                    <i class="bx bx-user-plus"></i>
                    <span>Convidar Usuário</span>
                </a>
            </li>
            @endhasanyrole
          </ul>
        </div>
        <!-- right content section -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-body">
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                        <div class="media">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="rounded mr-75" alt="profile image" height="64" width="64">
                            @else
                                <img src="{{asset('storage/avatars/' . $avatar )}}" class="rounded mr-75" alt="profile image" height="64" width="64">
                            @endif
                            
                            <div class="media-body mt-25">
                                <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                    <label for="select-files" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                      <span>ATUALIZAR AVATAR</span>
                                      <input id="select-files" type="file" hidden wire:model.defer="photo">
                                    </label>
                                </div>
                                <p class="text-muted ml-1 mt-50">
                                    <small>
                                        Tamaho máximo 1MB
                                    </small>
                                    
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div wire:loading class="alert alert-info col-12">
                                Carregando... calma aí!
                            </div>
                        </div>
                        <hr>
                        <form class="validate-form">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="first_name">Nome</label>
                                            <input type="text" class="form-control" placeholder="Primeiro nome" name="first_name" id="first_name" wire:model.defer="first_name">
                                            @error('first_name')
                                            <span class="text-danger">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="last_name">Sobrenome</label>
                                            <input type="text" class="form-control" placeholder="Último nome"  name="last_name" id="last_name" wire:model.defer="last_name">
                                            @error('last_name')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="email">E-mail</label>
                                            <input type="email" wire:model.defer="email" class="form-control" placeholder="E-mail cadastrado" name="email" disabled>
                                            @error('email')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="function">Função</label>
                                            <input type="text" class="form-control" placeholder="Sua função"  name="function" id="function" wire:model.defer="function">
                                            @error('function')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    @if ($email_verified_at)
                                    <div class="alert bg-rgba-success alert-dismissible mb-2" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <p class="mb-0">
                                            E-mail confirmado em <strong>{{date("d/m/Y H:i", strtotime($email_verified_at))}}</strong>
                                        </p>
                                    </div>
                                    @else
                                    <div class="alert bg-rgba-warning alert-dismissible mb-2" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <p class="mb-0">
                                            Você precisa confirmar seu e-mail
                                        </p>
                                        <a href="javascript: void(0);">Resend confirmation</a>
                                    </div>
                                    @endif
                                    
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                    <a wire:click.prevent="updateProfile" class="btn btn-primary glow mr-sm-1 mb-1">Atualizar</a>
                                    <button type="reset" class="btn btn-light mb-1">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{--
                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                        <form class="validate-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea class="form-control" id="accountTextarea" rows="3" placeholder="Fale um pouco sobre você..."></textarea>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Aniversário</label>
                                            <input type="date" class="form-control birthdate-picker" placeholder="dd/mm/aaaa" name="dob">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control" id="accountSelect">
                                            <option>USA</option>
                                            <option>India</option>
                                            <option>Canada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Languages</label>
                                        <select class="form-control" id="languageselect2">
                                            <option value="English" selected>English</option>
                                            <option value="Spanish">Spanish</option>
                                            <option value="French">French</option>
                                            <option value="Russian">Russian</option>
                                            <option value="German">German</option>
                                            <option value="Arabic" selected>Arabic</option>
                                            <option value="Sanskrit">Sanskrit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Contato</label>
                                            <input type="text" class="form-control"
                                                placeholder="Phone number" value="(000) 0000 0000"
                                                name="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Site</label>
                                        <input type="text" class="form-control" placeholder="http://www.seusite.com.br">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" class="form-control" placeholder="Endereço">
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                        changes</button>
                                    <button type="reset" class="btn btn-light mb-1">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                     --}}

                    @hasanyrole('Super Admin|Admin')
                    <div class="tab-pane fade " id="account-vertical-social" role="tabpanel" aria-labelledby="account-pill-social" aria-expanded="false">
                        @livewire('perfil.invite-user')
                    </div>
                    @endhasanyrole
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
        window.addEventListener("sucesso-econvite", function(){
          toastr.success('Dentro de instantes o convidado será notificado.', 'Convite enviado!', {
            closeButton: true,
            tapToDismiss: false,
            timeOut: 3000
          })
        })
    </script>

    <script>
        window.addEventListener("sucesso-edita-usuario", function(){
            toastr.success('Perfil atualizado com sucesso.', 'Show de bola!', {
                closeButton: true,
                tapToDismiss: false,
                timeOut: 3000
            })
        })
    </script>



  </div>