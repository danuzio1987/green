<div class="row">

    @if ($verifica == false)
      @livewire('cadastros.cadastro-index')
    @else
        
    <div wire:loading>
        <div style="display: flex; justify-content: center; align-items: center; background-color:#67bd52; position: fixed; top:0px; left:0px; z-index: 9999; width:100%; height:100%; opacity:.9;">
            @include('panels.loading')
        </div>
    </div>

    
    <div class="col-12">
        <div class="row">
            <div class="col-9">
                <div class="row">
                    <div class="col-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-bold-600 mb-1">
                                    Volume de Transferências
                                </h4>
                                <p class="text-muted mb-0 line-ellipsis">Este Mês</p>
                                <h3 class="mb-0">
                                    <span class="text-bold-600">{{ number_format($detalhes->where("category", "Transferência")->where("moviment_type", "entrada")->whereBetween("date_report", [$start, $finish])->sum("qtd"), 1, ",", ".") }}</span>
                                    <small class="text-muted">m³</small>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card text-center">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-8">
                                    <div class="text-left p-2">
                                        <h5 class="font-medium-2 text-bold-600">Esta Semana</h5>
                                        <p class="text-muted">Volume transferido</p>
                                        <h4>
                                            <strong>{{ number_format($detalhes->where("category", "Transferência")->whereBetween("date_report", [date('Y-m-d', strtotime("next Monday") - 604800), date("Y-m-d", strtotime(now()))])->where("moviment_type", "entrada")->sum("qtd"), 1, ",", ".") }}</strong>
                                            <small class="text-muted">m³</small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-4"> 
                                    <img src="{{asset('images/emojis/emoji_gif_100px/emoji_10.gif')}}" alt="">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card text-center ">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-left p-2">
                                            <h5 class="font-medium-2 text-bold-600">Quantidade</h5>
                                            <p class="text-muted">Este Mês</p>
                                            <h4 class="">
                                                <span class="text-bold-600">{{ $detalhes->where("category", "Transferência")->where("moviment_type", "entrada")->whereBetween("date_report", [$start, $finish])->count() }}</span>
                                                <small class="text-muted">transferências</small>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <img src="{{asset('images/emojis/emoji_gif_100px/emoji_7.gif')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="col-3">
                <div class="card invoice-action-wrapper shadow-none border">
                    <div class="card-body">
                    <div class="invoice-action-btn">
                        <div class="form-group">
                            <input type="month" class="form-control" wire:model.defer="report_date">
                            @error('report_date')
                                <span class="text-danger">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div> 
                    </div>
                    <div class="invoice-action-btn">
                        <a href="" wire:click.prevent="updateDashboardTransferencia" class="btn btn-primary btn-block glow users-list-clear mb-0">
                            Atualizar
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- gráfico de acompanhamento diário -->
    <div class="col-12">
        <div class="card">
            <div class=" alert border-info alert-dismissible m-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle"></i>
                    <span>
                        <strong>ACOMPANHAMENTO DIÁRIO DAS TRANSFERÊNCIAS</strong>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around align-items-center flex-wrap">

                    @foreach ($armazens as $armazem)
                        <div class="table-responsive mb-2">
                            <table class="table table-borderless table-hover mb-0">

                                <thead class="thead-dark">
                                    <tr style="border-bottom: none;">
                                        <th scope="col" class="text-center">
                                            <h6 class="text-bold-600 white">
                                                {{$armazem->name}}
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
                                    @foreach ($insumos as $insumo)
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row">
                                            {{$insumo->name}}
                                        </th>
                               
                                        <td class="{{ $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd") > 0 ? "bg-rgba-success" : ""}} {{$insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd") != 0 && $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd") < 0 ? "bg-rgba-danger" : ""}}">
                                            <small>
                                                {{ $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd") == 0 ? "-" : number_format($insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @foreach ($datas as $data)
                                        <td class="{{ $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") > 0 ? "bg-rgba-success" : ""}} {{$insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") !== 0 && $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") < 0 ? "bg-rgba-danger" : ""}}">
                                            <small>
                                                {{ $insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") == 0 ? "-" : number_format($insumo->details->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    <tr class="bg-rgba-secondary">
                                        <th class="text-center bg-secondary white" scope="row">
                                            Transferência Diária
                                        </th>
                               
                                        <td class="{{ $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd") > 0 ? "bg-rgba-success" : ""}} {{ $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd") !== 0 && $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd") < 0 ? "bg-rgba-danger" : ""}}">
                                            <small>
                                                {{ $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd") == 0 ? "-" : number_format($detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->whereBetween("date_report", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @foreach ($datas as $data)
                                        <td class="{{ $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd")  > 0 ? "bg-rgba-success" : ""}} {{$detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd")  !== 0 && $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") < 0 ? "bg-rgba-danger" : ""}}">
                                            <small>
                                                <strong>{{ $detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd") == 0 ? "-" : number_format($detalhes->where("armazem_id", $armazem->id)->where("category", "Transferência")->where("date_report", date("Y-m-d", strtotime($data)))->sum("qtd"), 1, ",", ".") . "m³" }}</strong>
                                            </small>
                                        </td>
                                        @endforeach
                                    </tr>
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
    