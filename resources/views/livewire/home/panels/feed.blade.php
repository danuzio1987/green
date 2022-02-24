<div class="tab-pane active" id="feed" aria-labelledby="feed-tab" role="tabpanel">
    <!-- user profile nav tabs feed start -->
    <div class="row">

      <div class="col-lg-4">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-1">
                  <i class="bx bxs-ship mr-50"></i>
                  Próximas Entregas
              </h5>
              <hr>            
              
              @forelse ($pedidos_pendentes as $pedido)
                <div class="user-profile-event">
                  <div class="pb-1 d-flex align-items-center">
                    <i class="bx bx-calendar-event text-primary mr-25"></i>
                    <small>
                        {{date("d/m/y", strtotime($pedido->window_start))}} - {{date("d/m/y", strtotime($pedido->window_finish))}}
                    </small>
                  </div>
                    @foreach ($pedido->insumos as $item)
                    <div class="media d-flex align-items-center mb-1">
                      <i class="bx bx-right-arrow-alt d-flex align-items-center"></i>
                      <div class="media-body ml-1">
                          <h6 class="media-heading mb-0">
                              <small><strong>{{$insumos->find($item->pivot->insumo_id)->name}}</strong></small>
                              <small>({{$armazens->find($item->pivot->armazem_id)->name}})</small>
                          </h6>
                      </div>
                      <div class="d-flex align-items-center">
                          <small class="text-center">
                            {{number_format(abs($item->pivot->qtd_forecast), 1, ",", ".") . "m³"}} / {{number_format(abs($item->pivot->qtd_real), 1, ",", ".") . "m³"}} [{{number_format($item->pivot->qtd_real/$item->pivot->qtd_forecast, 0, ",", ".") . "%"}}]
                          </small>
                      </div>
                    </div>
                    @endforeach
                </div>
                <hr>
                @empty
                  <div class="row">
                    <div class="col-12 text-center mb-2">
                      <h5 class="text-bold-600 text-success">Nenhuma entrega pendente</h5>
                      <img src="{{asset('gif/pig.gif')}}" class="img-fluid img-responsive" alt="">
                      💚💚💚💚💚💚
                    </div>
                  </div>
                @endforelse
              <a class="btn btn-block btn-secondary" href="{{route('pedidos.lista')}}">
                  Ver todos os Pedidos
              </a>
            </div>
        </div>
{{--
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-1">Info
              <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
            </h5>
            <ul class="list-unstyled mb-0">
              <li class="d-flex align-items-center mb-25">
                <i class="bx bx-briefcase mr-50 cursor-pointer"></i><span>UX
                  Designer at<a href="JavaScript:void(0);">&nbsp;google</a></span>
              </li>
              <li class="d-flex align-items-center mb-25">
                <i class="bx bx-briefcase mr-50 cursor-pointer"></i> <span>Former
                  UI Designer at<a href="JavaScript:void(0);">&nbsp;CBI</a></span>
              </li>
              <li class="d-flex align-items-center mb-25">
                <i class="bx bx-receipt mr-50 cursor-pointer"></i> <span>Studied
                  <a href="JavaScript:void(0);">&nbsp;IT science</a> at<a
                    href="JavaScript:void(0);">&nbsp;Torronto</a></span>
              </li>
              <li class="d-flex align-items-center mb-25">
                <i class="bx bx-receipt mr-50 cursor-pointer"></i><span>Studied at
                  <a href="JavaScript:void(0);">&nbsp;College of new Jersey</a></span>
              </li>
              <li class="d-flex align-items-center">
                <i class="bx bx-rss mr-50 cursor-pointer"></i> <span>Followed by<a
                    href="JavaScript:void(0);">&nbsp;338 people</a></span>
              </li>
            </ul>
          </div>
        </div>
 
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-1">What's trending<i
                class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i></h5>
            <ul class="list-unstyled mb-0">
              <li class="d-flex mb-25">
                <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i><span>
                  <a href="JavaScript:void(0);" class="mr-50">#ManJonas:</a>Frest comes with built-in
                </span>
              </li>
              <li class="d-flex mb-25">
                <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i><span>
                  <a href="JavaScript:void(0);" class="mr-50">LadyJonas:</a>dark layouts, select as</span>
              </li>
              <li class="d-flex mb-25">
                <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i><span>
                  <a href="JavaScript:void(0);" class="mr-50">#Germany:</a>Frest comes with built-in
                </span>
              </li>
              <li class="d-flex mb-25">
                <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i><span>
                  <a href="JavaScript:void(0);" class="mr-50">#SundayNoon:</a>dark layouts, select as</span>
              </li>
              <li class="d-flex">
                <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i><span>
                  <a href="JavaScript:void(0);" class="mr-50">NoWorries:</a>heme navigation with you</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h6><img src="{{asset('images/profile/pages/pixinvent.jpg')}}" class="mr-25 round"
                alt="logo" height="28">
              Pixinvent<span class="text-muted"> (Page)</span>
              <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i></h6>
            <div class="mb-1 font-small-2">
              <i class="cursor-pointer bx bxs-star text-warning"></i>
              <i class="cursor-pointer bx bxs-star text-warning"></i>
              <i class="cursor-pointer bx bxs-star text-warning"></i>
              <i class="cursor-pointer bx bxs-star text-warning"></i>
              <i class="cursor-pointer bx bx-star text-muted"></i>
              <span class="ml-50 text-muted text-bold-500">4.6 (142 reviews)</span>
            </div>
            <div class="d-flex">
              <button class="btn btn-sm btn-light-primary d-flex mr-50"><i
                  class="cursor-pointer bx bx-like font-small-3 mb-25 mr-sm-25"></i><span
                  class="d-none d-sm-block">Like</span></button>
              <button class="btn btn-sm btn-light-primary d-flex"><i
                  class="cursor-pointer bx bx-share-alt font-small-3 mb-25 mr-sm-25"></i><span
                  class="d-none d-sm-block">Share</span></button>
            </div>
          </div>
        </div>
--}}
        
      </div>

      <div class="col-lg-8">

        <div class="card">
          <div class="card-body">

                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <div class="col-sm-1 col-2">
                        <div class="avatar">
                          <img src="{{asset('storage/avatars/' . Auth::user()->profile->avatar)}}"
                            alt="user image" width="32" height="32">
                          <span class="avatar-status-online"></span>
                        </div>
                      </div>
                      <div class="col-sm-11 col-10">
                        <textarea class="form-control border shadow-none" id="user-post-textarea" rows="3" placeholder="Compartilhe o que você está pensando..."></textarea>
                      </div>
                    </div>
         
                    <div class="card-footer p-0">
                      <i class="cursor-pointer bx bx-camera font-medium-5 text-muted mr-1 pt-50"
                        data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top"
                        title="Upload a picture"></i>
                      <i class="cursor-pointer bx bx-face font-medium-5 text-muted mr-1 pt-50"
                        data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top"
                        title="Tag your friend"></i>
                      <i class="cursor-pointer bx bx-map font-medium-5 text-muted pt-50"
                        data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top"
                        title="Share your location"></i>
                      <span class=" float-sm-right d-flex flex-sm-row flex-column justify-content-end">
                        <button class="btn btn-light-primary mr-0 my-1 my-sm-0 mr-sm-1">Cancelar</button>
                        <button class="btn btn-primary">Publicar</button>
                      </span>
                    </div>
                  </div>
                </div>
 
          </div>
        </div>

        {{--
        <div class="card">
          <div class="card-header p-0">
            <div class="media m-75">
                <a class="media-left" href="JavaScript:void(0);">
                    <div class="avatar mr-75">
                        <img src="{{'storage/avatars/' . $user->profile->avatar}}" alt="avatar images" width="32" height="32">
                        <span class="avatar-status-online"></span>
                    </div>
                </a>
                <div class="media-body">
                    <h6 class="media-heading mb-0 pt-25"><a href="javaScript:void(0);">Kiara Cruiser</a></h6>
                    <span class="text-muted font-small-3">Active</span>
                </div>
            </div>
          </div>
          <div class="card-body py-0">
            <p>Unlimited color options allows you to set your application color as per your branding 🤩.</p>
            <div class="d-flex border rounded">
              <div class="user-profile-images"><img src="{{asset('images/banner/banner-29.jpg')}}"
                  alt="post" class="img-fluid user-profile-card-image">
              </div>
              <div class="p-1">
                <h5>Algolia Integration 😎</h5>
                <p class="user-profile-ellipsis">Algolia helps businesses across industries quickly create
                  relevant, scalable, and lightning fast search and discovery experiences.</p>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between pt-1">
            <div class="d-flex align-items-center">
              <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4"></i>
              <p class="mb-0 ml-25">18</p>
              <!-- user profile likes avatar start -->
              <div class="d-none d-sm-block">
                <ul class="list-unstyled users-list m-0 d-flex align-items-center ml-1">
                  <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                    title="Lilian Nenez" class="avatar pull-up">
                    <img src="{{asset('images/portrait/small/avatar-s-21.jpg')}}" alt="Avatar"
                      height="30" width="30">
                  </li>
                  <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                    title="Alberto Glotzbach" class="avatar pull-up">
                    <img src="{{asset('images/portrait/small/avatar-s-22.jpg')}}" alt="Avatar"
                      height="30" width="30">
                  </li>
                  <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                    title="Alberto Glotzbach" class="avatar pull-up">
                    <img src="{{asset('images/portrait/small/avatar-s-23.jpg')}}" alt="Avatar"
                      height="30" width="30">
                  </li>
                  <li class="d-inline-block pl-50">
                    <p class="text-muted mb-0 font-small-3">+10 more</p>
                  </li>
                </ul>
              </div>
              <!-- user profile likes avatar ends -->
            </div>
            <div class="d-flex align-items-center">
              <i class="cursor-pointer bx bx-comment-dots font-medium-4"></i>
              <span class="ml-25">52</span>
              <i class="cursor-pointer bx bx-share-alt font-medium-4 ml-1"></i>
              <span class="ml-25">22</span>
            </div>
          </div>
        </div>
        --}}
      </div>

    </div>

  </div>