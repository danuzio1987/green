<div class="row">
    {{-- FORMULÁRIO DE CRIAÇÃO DE PRODUTO --}}
    @if ($insumos->count() > 0 && $armazens->count() > 0)
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="card {{$form_mode === "edit" ? "bg-rgba-warning" : ""}}">
                        <div class="card-header">
                        <h4 class="text-bold-600">
                            {{$form_mode === "edit" ? "Editar Tancagem" : "Cadastrar Tancagem"}}
                        </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 form-group">
                                            <label for="armazem_id">Armazém</label><span class="text-danger">*</span>
                                            <select class="form-control" wire:model="armazem_id">
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
                                        <div class="col-4 form-group">
                                            <label for="insumo_id">Insumo</label><span class="text-danger">*</span>
                                            <select class="form-control" wire:model="insumo_id" {{$armazem_id === '' ? 'disabled' : ''}}>
                                                <option value="" selected>Selecione um insumo</option>
                                                @foreach ($insumos as $insumo)
                                                    <option value="{{$insumo->id}}" {{$insumo->armazens->find($armazem_id) ? "hidden" : ""}} >{{$insumo->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('insumo_id')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-2 form-group">
                                            <label for="volume">Vol. (m³)</label><span class="text-danger">*</span>
                                            <input type="number" min="0" max="100" step="1" class="form-control" name="volume" id="volume" placeholder="0,0m³" wire:model="volume" wire:keydown.enter="{{ $form_mode === "create" ? 'createTancagem' : 'editTancagem'}}" {{$armazem_id === '' ? 'disabled' : ''}}>
                                            @error('volume')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-2 form-group">
                                            <label for="lastro">Lastro (m³)</label><span class="text-danger">*</span>
                                            <input type="number" min="0" max="100" step="1" class="form-control" name="lastro" id="lastro" placeholder="0,0m³" wire:model="lastro" wire:keydown.enter="{{ $form_mode === "create" ? 'createTancagem' : 'editTancagem'}}" {{$armazem_id === '' ? 'disabled' : ''}}>
                                            @error('lastro')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 ">
                                    <div class="d-flex justify-content-start">
                                        <span class="text-muted">⚠️<small>(<span class="text-danger">*</span>) Campo de preenchimento obrigatório</small></span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                    @if ($form_mode === "edit")
                                        <a href="" wire:click.prevent='editTancagem' class="btn btn-warning mr-1">
                                            <i class="bx bx-save mr-1"></i>
                                            Atualizar
                                        </a>
                                    @else
                                        <a href="" wire:click.prevent='createTancagem' class="btn btn-light-success mr-1">
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
                                    Para cadastro de tancagem, são necessáras as criações de <strong>armazéns</strong> e <strong>insumos</strong>.
                                </div>
                                @if ($armazens->count() === 0)
                                    <div class="col-12">
                                        <a href="{{route('armazens.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR ARMAZÉM</a>
                                    </div>
                                @endif
                                @if ($insumos->count() === 0)
                                    <div class="col-12">
                                        <a href="{{route('insumos.index')}}" class="btn btn-warning btn-block mt-3">CADASTRAR INSUMO</a>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- LISTA DAS PRODUTOS CADASTRADOS --}}
    <div class="col-6">
        <div class="row">
            <div class="col-12">
              <div class="card">

                @if ($armazens->count() > 0)
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Tabela de Tancagem <small class="text-muted">{{$view_mode === false ? "(por armazém)" : "(por insumo)"}}</small>
                    </h4>
                    <div class="custom-control custom-switch custom-control-inline mb-1">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:model="view_mode">
                        <label class="custom-control-label mr-1" for="customSwitch1">
                        </label>
                        <span><small>Agrupar por Insumo</small></span>
                    </div>
                  </div>
                  <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card collapse-icon accordion-icon-rotate">
                                    

                                    <div class="card-body">
                                        <table class="table mb-0 table-borderless">
                                            @if ($view_mode === true)
                                                <tbody>
                                                    @foreach ($insumos as $index => $insumo)
                                                        <tr class="bg-rgba-secondary">
                                                            <td class="p-2">
                                                                <h4 class="text-bold-600 mb-0">
                                                                    {{$insumo->name}}
                                                                </h4>
                                                            </td>
                                                            <td class="text-right p-2">
                                                                <h4 class="text-bold-600 mb-0">
                                                                    {{number_format($insumo->armazens->sum("pivot.volume"), 2, ",", ".") . "m³"}}
                                                                </h4>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        @foreach ($insumo->armazens as $armazem)
                                                            <tr>
                                                                <td>{{$armazem->name}}</td>
                                                                <td class="text-right">
                                                                    {{ number_format($armazem->pivot->volume, 2, ",", ".") . "m³" }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="invoice-action">
                                                                        <a href="" wire:click.prevent='showEditFormTancagem({{$armazem->id}}, {{$insumo->id}})' class="text-warning mr-1 cursor-pointer">
                                                                            <i class="bx bx-edit"></i>
                                                                        </a>
                                                                        <a href="" wire:click.prevent='deleteConfirmationTancagem({{$armazem->id}}, {{$insumo->id}})' class="text-danger cursor-pointer">
                                                                            <i class="bx bx-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody> 
                                            @else
                                                <tbody>
                                                    @foreach ($armazens as $index => $armazem)
                                                        <tr class="bg-rgba-secondary">
                                                            <td class="p-2">
                                                                <h4 class="text-bold-600 mb-0">
                                                                    {{$armazem->name}}
                                                                </h4>
                                                            </td>
                                                            <td class="text-right p-2">
                                                                <h4 class="text-bold-600 mb-0">
                                                                    {{number_format($armazem->insumos->sum("pivot.volume"), 2, ",", ".") . "m³"}}
                                                                    <small class="text-muted ml-75">({{number_format($armazem->insumos->sum("pivot.lastro"), 2, ",", ".") . "m³"}})</small>
                                                                </h4>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        @foreach ($armazem->insumos as $insumo)
                                                            <tr>
                                                                <td>{{$insumo->name}}</td>
                                                                <td class="text-right">
                                                                    {{ number_format($insumo->pivot->volume, 2, ",", ".") . "m³" }}
                                                                    <small class="text-muted ml-75">({{ number_format($insumo->pivot->lastro,1, ",", ".") . "m³" }})</small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="invoice-action">
                                                                        <a href="" wire:click.prevent='showEditFormTancagem({{$armazem->id}}, {{$insumo->id}})' class="text-warning mr-1 cursor-pointer">
                                                                            <i class="bx bx-edit"></i>
                                                                        </a>
                                                                        <a href="" wire:click.prevent='deleteConfirmationTancagem({{$armazem->id}}, {{$insumo->id}})' class="text-danger cursor-pointer">
                                                                            <i class="bx bx-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            @endif
                                            
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                  </div>
                @else
                  <div class="card-header">
                    <h4 class="text-bold-600">
                      Tabela de Tancagem
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
      window.addEventListener("sucesso-salva-tancagem", function(){
        toastr.success('Registro criado com sucesso.', 'Deu certo!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("confirma-exclusao-tancagem", function(){

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
                  Livewire.emit('deleteTancagem')
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
      window.addEventListener("sucesso-deleta-tancagem", function(){
        toastr.success('Registro excluído com sucesso.', 'Agora já era!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>
    <script>
      window.addEventListener("sucesso-edita-tancagem", function(){
        toastr.success('Registro atualizado com sucesso.', 'Show de bola!', {
          closeButton: true,
          tapToDismiss: false,
          timeOut: 3000
        })
      })
    </script>

</div>