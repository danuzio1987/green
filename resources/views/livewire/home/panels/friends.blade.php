<div class="tab-pane" id="friends" aria-labelledby="friends-tab" role="tabpanel">
    <!-- user profile nav tabs friends start -->
    <div class="card">
      <div class="card-body">
        <h5>Usuários da Plataforma</h5>
        <div class="row">
          <div class="col-12 mt-2">
            <ul class="list-unstyled mb-0">
              <div class="row">

              @foreach ($users as $user)
                <div class="col-4">
                  <li class="media my-50">
                    <a href="JavaScript:void(0);">
                      <div class="avatar mr-1">
                        <img src="{{asset('storage/avatars/' . $user->profile->avatar)}}" alt="{{$user->first_name}} {{$user->last_name}}" width="32" height="32">
                      </div>
                    </a>
                    <div class="media-body">
                      <h5 class="media-heading text-bold-600 mb-0">
                        <a href="javaScript:void(0);">{{$user->first_name}} {{$user->last_name}}</a>
                      </h5>
                      <small class="text-muted">{{$user->profile->function === "" ? "Função Não Informada" : $user->profile->function}}</small>
                      @if ( $user->getRoleNames()->first() === "Super Admin")
                            <span class="text-warning ml-50">
                              <small>{{ mb_strtoupper($user->getRoleNames()->first()) }}</small>
                            </span>
                        @elseif( $user->getRoleNames()->first() === "Admin")
                          <span class="text-success ml-50">
                            <small>{{ mb_strtoupper($user->getRoleNames()->first()) }}</small>
                          </span>
                        @elseif( $user->getRoleNames()->first() === "Diretoria")
                          <span class="text-primary ml-50">
                            <small>{{ mb_strtoupper($user->getRoleNames()->first()) }}</small>
                          </span>
                        @else
                          <span class="text-danger ml-50">
                            <small>{{ mb_strtoupper($user->getRoleNames()->first()) }}</small>
                          </span>
                        @endif
                    </div>
                  </li>
                </div>
              @endforeach

              </div>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- user profile nav tabs friends ends -->
  </div>