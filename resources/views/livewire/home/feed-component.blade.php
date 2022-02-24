<div class="row">
    <div class="col-12">
      <!-- user profile heading section start -->
      <div class="card">
        <div class="user-profile-images">
          <!-- user timeline image -->
          <img src="{{asset('images/profile/post-media/green.png')}}" class="img-fluid rounded-top user-timeline-image" alt="user timeline image">
          <!-- user profile image -->
          <img src="{{asset('storage/avatars/' . $user->profile->avatar)}}" class="user-profile-image rounded"
            alt="user profile image" height="140" width="140">
        </div>
        <div class="user-profile-text">
          <h4 class="mb-0 text-bold-500 profile-text-color">{{$user->first_name}} {{$user->last_name}}</h4>
          <small>{{$user->profile->function}}</small>
        </div>
        <!-- user profile nav tabs start -->
        <div class="card-body px-0">
          <ul
            class="nav user-profile-nav justify-content-center justify-content-md-start nav-pills border-bottom-0 mb-0"
            role="tablist">
            <li class="nav-item mb-0">
              <a class=" nav-link d-flex px-1 active" id="feed-tab" data-toggle="tab" href="#feed" aria-controls="feed" role="tab" aria-selected="true">
                <i class="bx bx-home"></i>
                <span class="d-none d-md-block">Feed</span>
              </a>
            </li>
            <li class="nav-item mb-0">
              <a class="nav-link d-flex px-1" id="activity-tab" data-toggle="tab" href="#activity"
                aria-controls="activity" role="tab" aria-selected="false"><i class="bx bx-user"></i><span
                  class="d-none d-md-block">Atividades</span></a>
            </li>
            <li class="nav-item mb-0">
              <a class="nav-link d-flex px-1" id="friends-tab" data-toggle="tab" href="#friends"
                aria-controls="friends" role="tab" aria-selected="false"><i class="bx bx-message-alt"></i><span
                  class="d-none d-md-block">Usuários</span></a>
            </li>
            <li class="nav-item mb-0 mr-0">
              <a class="nav-link d-flex px-1" id="profile-tab" data-toggle="tab" href="#profile"
                aria-controls="profile" role="tab" aria-selected="false"><i class="bx bx-copy-alt"></i><span
                  class="d-none d-md-block">Perfil</span></a>
            </li>
          </ul>
        </div>
        <!-- user profile nav tabs ends -->
      </div>
      <!-- user profile heading section ends -->

      <!-- user profile content section start -->
      <div class="row">
        <!-- user profile nav tabs content start -->
        <div class="col-lg-9">
          <div class="tab-content">
            @include('livewire.home.panels.feed')
            @include('livewire.home.panels.activity')
            @include('livewire.home.panels.friends')
            @include('livewire.home.panels.profile')
          </div>
        </div>

        <div class="col-lg-3">

          {{--
          <div class="card">
            <div class="card-body">
              <div class="d-inline-flex">
                <h5 class="media-heading mb-0">
                    <i class="bx bx-money mr-50"></i>
                    Vendas
                </h5>
              </div>
              <div class="user-profile-birthday-image text-center p-2">
                <img class="img-fluid" src="{{asset('images/profile/pages/birthday.png')}}" alt="image">
              </div>
              <div class="user-profile-birthday-footer text-center text-lg-left">
                <p class="mb-0"><small>Leave her a message with your best wishes on her profile page!</small></p>
                <a class="btn btn-sm btn-light-primary mt-50" href="JavaScript:void(0);">Send Wish</a>
              </div>
            </div>
          </div>
          --}}

          <div class="card">
            <div class="card-body">

                <h5 class="card-title mb-1">
                    <i class="bx bxs-truck mr-50"></i>
                    Transferências Pendentes
                    @if ($transferencias_pendentes->count() > 0)
                    <span class="badge badge-danger">{{$transferencias_pendentes->count()}}</span>
                    @endif
                    
                </h5>

                @forelse ($transferencias_pendentes as $transferencia)
                <div class="media d-flex align-items-center mb-1">
                    <i class="bx bxs-checkbox d-flex align-items-center text-danger"></i>
                    <div class="media-body ml-1">
                        <h6 class="media-heading mb-0">
                            <small> De <strong>{{$armazens->find($transferencia->origem_id)->name}}</strong> para <strong>{{$armazens->find($transferencia->destino_id)->name}}</strong></small>
                        </h6>
                        <small class="text-muted">Descarga prevista para: {{date("d/m/y", strtotime($transferencia->descarga_date))}}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-center">
                            {{number_format(abs($transferencia->details()->first()->qtd), 1, ",", ".") . "m³"}}
                            <br>
                            {{$insumos->find($transferencia->details()->first()->insumo_id)->name}}
                        </small>
                    </div>
                </div>
                @empty
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="{{asset("/gif/megafone.gif")}}" class="img-fluid img-responsive" alt="" width="70%;" height="70%;">
                    </div>
                    <div class="col-12 alert alert-info">
                      Nenhuma transferência pendente!
                    </div>
                </div>
                    
                @endforelse

            </div>
          </div>
          
        </div>
        <!-- user profile right side content ends -->
      </div>
      <!-- user profile content section start -->
    </div>
  </div>