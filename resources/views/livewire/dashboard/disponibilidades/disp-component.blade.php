<div class="row">

    @if ($verifica == false)
      @livewire('cadastros.cadastro-index')
    @else
        
    <div wire:loading>
        <div style="display: flex; justify-content: center; align-items: center; background-color:#67bd52; position: fixed; top:0px; left:0px; z-index: 9999; width:100%; height:100%; opacity:.9;">
            @include('panels.loading')
        </div>
    </div>

    
    <!-- gráfico de acompanhamento diário -->
    <div class="col-12">
        <div class="card">
            <div class=" alert border-info alert-dismissible m-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle"></i>
                    <span>
                        <strong>DISPONIBILIDADE DE PRODUTOS</strong>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around align-items-center flex-wrap">

                    @foreach ($produtos as $produto)
                        <div class="table-responsive mb-2">
                            <table class="table table-borderless table-hover mb-0">

                                <thead class="thead-dark">
                                    <tr style="border-bottom: none;">
                                        <th scope="col" colspan="2"  class="text-center">
                                            <h6 class="text-bold-600 white">
                                                {{$produto->name}}
                                            </h6>
                                        </th>
                                        <th scope="col"  class="text-center">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center">
                                                    <p class="mb-0">
                                                        Acum. Anterior
                                                    </p>
                                                </div>
                                            </div>
                                        </th>
                                        @foreach ($labels as $label)
                                            <th scope="col text-center">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="text-center">
                                                        <p class="mb-0">{{$label}}</p>
                                                    </div>
                                                </div>
                                                
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($armazens as $armazem)
                                    {{-- LINHA DO PRODUTO --}}
                                    <tr data-toggle="collapse" data-target="#demo{{$armazem->id}}" class="accordion-toggle">
                                        {{-- NOME DO ARMAZÉM --}}
                                        <td class="text-center bg-secondary white" scope="col" colspan="2" style="width:100px">
                                            <button class="btn btn-default btn-xs"><span class="bx bx-plus-circle white"></span></button>
                                            {{$armazem->name}}
                                        </td>
                                        {{-- QUANTIDADE DE COMBUSTÍVEL --}}
                                        <td class="bg-rgba-secondary">
                                            <small>
                                                {{ $lancamentos->where("insumo_id", $produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->id )->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<", date("Y-m-d", strtotime($label)))->sum("qtd") > 0 ? number_format($lancamentos->where("insumo_id", $produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->id )->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<", date("Y-m-d", strtotime($label)))->sum("qtd") / ($produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->pivot->percent / 100), 1, ",", ".") . "m³" : ""  }}
                                            </small>
                                        </td>
                                        @foreach ($labels as $label)
                                        <td class="bg-rgba-secondary">
                                            <small>
                                                {{--
                                                {{ dd( $produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->pivot->percent ) }}
                                                --}}
                                                {{ $lancamentos->where("insumo_id", $produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->id )->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<=", date("Y-m-d", strtotime($label)))->sum("qtd") > 0 ? number_format($lancamentos->where("insumo_id", $produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->id )->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<=", date("Y-m-d", strtotime($label)))->sum("qtd") / ($produto->insumos->where("pivot.percent", $produto->insumos->max("pivot.percent"))->first()->pivot->percent / 100), 1, ",", ".") . "m³" : ""  }}
                                            </small>
                                        </td>
                                        @endforeach
                                    </tr>
                                    {{-- LINHA DOS INSUMOS --}}
                                    <tr>
                                        <td colspan="{{ count($labels) + 3}}" class="hiddenRow">
                                            <div class="accordian-body collapse" id="demo{{$armazem->id}}">
                                                <table>
                                                    <tbody>
                                                        @foreach ($produto->insumos as $insumo)
                                                        <tr>
                                                            <td> {{$insumo->name}}</td>
                                                            <td>
                                                                <small>
                                                                    {{ $lancamentos->where("insumo_id", $insumo->id)->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<", date("Y-m-d", strtotime($start)))->sum("qtd") != 0 ? number_format($lancamentos->where("insumo_id", $insumo->id)->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<", date("Y-m-d", strtotime($start)))->sum("qtd"), 1, ",", ".") . "m³" : "" }}
                                                                </small>
                                                            </td>
                                                            @foreach ($datas as $data)
                                                            <td >
                                                                <small>
                                                                    {{ $lancamentos->where("insumo_id", $insumo->id)->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<=", date("Y-m-d", strtotime($data)))->sum("qtd") != 0 ? number_format($lancamentos->where("insumo_id", $insumo->id)->where("armazem_id", $armazem->id)->where("type", "real")->where("date_report", "<=", date("Y-m-d", strtotime($data)))->sum("qtd"), 1, ",", ".") . "m³" : "" }}
                                                                </small>
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                               
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    @endforeach
                
                </div>
            </div>
            
        </div>
    </div>
    
    @endif
    
</div>
    