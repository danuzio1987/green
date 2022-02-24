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
                                <h2 class="text-bold-600">
                                    Volume de Vendas
                                </h2>
                                <p class="text-muted mb-0 line-ellipsis">Este Mês</p>
                                <h4 class="mb-0">
                                    <span class="text-bold-600">{{ number_format($detalhes->whereBetween("date_report", [$start, $finish])->sum("qtd"), 1, ",", ".") }}</span>
                                    <small class="text-muted">m³</small>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card text-center">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-8">
                                    <div class="text-left p-2">
                                        <h5 class="font-medium-2 text-bold-600">Vendas da Semana</h5>
                                        <p class="text-muted">Vendas reais atualizadas</p>
                                        <h4>
                                            <span class="text-bold-600">{{ $detalhes->whereBetween("date_report", [date('Y-m-d', strtotime("next Monday") - 604800), date("Y-m-d", strtotime(now()))])->count()}}</span>
                                            <small class="text-muted">venda(s)</small>
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
                                            <h5 class="font-medium-2 text-bold-600">Atualização</h5>
                                            <p class="text-muted">Lançamentos pendentes</p>
                                            <h4 class="">
                                               <span class="text-bold-600 {{ $detalhes->where("type", "forecast")->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->count() > 0 ? 'text-danger' : 'text-success'}}">{{ $detalhes->where("type", "forecast")->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->count()}}</span>
                                                <small class="text-muted">desatualizados</small>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        @if ($detalhes->where("type", "forecast")->where("date_report", "<=", date("Y-m-d", strtotime('-1 day', strtotime(now()))))->count() > 0)
                                            <img src="{{asset('images/emojis/emoji_gif_100px/emoji_27.gif')}}" alt="">
                                        @else
                                            <img src="{{asset('images/emojis/emoji_gif_100px/emoji_9.gif')}}" alt="">
                                        @endif
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
                        <a href="" wire:click.prevent="updateDashboardVendas" class="btn btn-primary btn-block glow users-list-clear mb-0">
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
                        <strong>ACOMPANHAMENTO DIÁRIO DAS VENDAS</strong><small><i> (por armazém)</i></small>
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
                                        <th scope="col" colspan="2"  class="text-center">
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

                                    @foreach ($produtos as $produto)
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row" colspan="2">
                                            {{$produto->name}} <small>(VENDA)</small>
                                        </th>
                                        <td class="{{ $produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum('qtd_sale') > 0 ? 'bg-rgba-success' : '' }}">
                                            <small>
                                                {{ $produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum("qtd_sale") == 0 ? "-" : number_format($produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @foreach ($datas as $data)
                                        <td class="{{ $produto->vendas->where("armazem_sale", $armazem->id)->where("sale_date", date("Y-m-d", strtotime($data)))->sum("qtd_sale") > 0 ? "bg-rgba-success" : "" }} {{ $produto->vendas->where("armazem_sale", $armazem->id)->where("sale_date", date("Y-m-d", strtotime($data)))->sum("qtd_sale") != 0 && $produto->vendas->where("armazem_sale", $armazem->id)->where("sale_date", date("Y-m-d", strtotime($data)))->sum("qtd_sale") < 0 ? "bg-rgba-danger" : ""}}">
                                            <small>
                                                {{$produto->vendas->where("armazem_sale", $armazem->id)->where("sale_date", date("Y-m-d", strtotime($data)))->sum("qtd_sale") == 0 ? "-" : number_format($produto->vendas->where("armazem_sale", $armazem->id)->where("sale_date", date("Y-m-d", strtotime($data)))->sum("qtd_sale"), 1, ",", ".") . "m³"}}
                                            </small>
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center bg-rgba-secondary text-secondary" scope="row" colspan="2">
                                            {{$produto->name}} <small>(RETIRADA)</small>
                                        </th>
                                        <td class="{{$produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("retirada", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum("qtd_sale") > 0 ? "bg-rgba-success" : ""}}">
                                            <small>
                                                {{ $produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("retirada", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum("qtd_sale") == 0 ? "-" : number_format($produto->vendas->where("armazem_sale", $armazem->id)->whereBetween("retirada", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))] )->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @foreach ($datas as $data)
                                        <td class="{{$produto->vendas->where("armazem_sale", $armazem->id)->where("retirada", date("Y-m-d", strtotime($data)))->sum("qtd_sale") > 0 ? "bg-rgba-success" : ""}}">
                                            <small>
                                                {{$produto->vendas->where("armazem_sale", $armazem->id)->where("retirada", date("Y-m-d", strtotime($data)))->sum("qtd_sale") == 0 ? "-" : number_format($produto->vendas->where("armazem_sale", $armazem->id)->where("retirada", date("Y-m-d", strtotime($data)))->sum("qtd_sale"), 1, ",", ".") . "m³"}}
                                            </small>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th class="text-center bg-secondary white" scope="row" colspan="2">
                                            Venda Total (Dia/Acum) 
                                        </th>
                                        <td class="bg-rgba-secondary">
                                            <small>
                                                {{$vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd_sale") == 0 ? "-" : number_format($vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [$data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start)))])->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                            </small>
                                        </td>
                                        @foreach ($datas as $data)
                                        <td class="bg-rgba-secondary">
                                            <small>
                                               <strong> {{ $vendas->where("armazem_sale", $armazem->id)->where("sale_date", $data)->sum("qtd_sale") == 0 ? "-" : number_format($vendas->where("armazem_sale", $armazem->id)->where("sale_date", $data)->sum("qtd_sale"), 1, ",", ".") . "m³" }}</strong>
                                            </small>
                                            <br>
                                            <small>
                                                {{ $vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [$data_inferior, date("Y-m-d", strtotime($data))])->sum("qtd_sale") == 0 ? "-" : number_format($vendas->where("armazem_sale", $armazem->id)->whereBetween("sale_date", [$data_inferior, date("Y-m-d", strtotime($data))])->sum("qtd_sale"), 1, ",", ".") . "m³" }}
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
            <div class=" alert border-info alert-dismissible m-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle"></i>
                    <span>
                        <strong>ACOMPANHAMENTO DIÁRIO DAS VENDAS</strong><small><i> (por produto)</i></small>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around align-items-center flex-wrap">

                    <div class="table-responsive mb-2">
                        <table class="table table-borderless table-hover mb-0">

                            <thead class="thead-dark">
                                <tr style="border-bottom: none;">
                                    <th scope="col" colspan="2"  class="text-center">
                                        <h6 class="text-bold-600 white">
                                            Produtos
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
                                @foreach ($produtos as $produto)
                                <tr>
                                    <th class="text-center bg-secondary white" scope="row" colspan="2">
                                        {{$produto->name}}
                                    </th>
                                    <td class="{{ $vendas->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->where("produto_id", $produto->id)->sum("qtd_sale") > 0 ? "bg-rgba-success" : "" }}">
                                        <small>
                                            {{ $vendas->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->where("produto_id", $produto->id)->sum("qtd_sale") == 0 ? "-" : number_format($vendas->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->where("produto_id", $produto->id)->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                        </small>
                                    </td>
                                    @foreach ($datas as $data)
                                    <td class="{{ $vendas->where("sale_date", $data)->where("produto_id", $produto->id)->sum("qtd_sale") > 0 ? "bg-rgba-success" : ""}}">
                                        <small>
                                            {{ $vendas->where("sale_date", $data)->where("produto_id", $produto->id)->sum("qtd_sale") == 0 ? "-" : number_format($vendas->where("sale_date", $data)->where("produto_id", $produto->id)->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                        </small>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="bg-rgba-secondary">
                                    <th class="text-center bg-secondary white" scope="row" colspan="2">
                                        TOTAL
                                    </th>
                                    <td class="">
                                        <small>
                                            {{ $vendas->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd_sale") == 0 ? "-" : number_format($vendas->whereBetween("sale_date", [ $data_inferior, date("Y-m-d", strtotime('-1 day', strtotime($start))) ])->sum("qtd_sale"), 1, ",", ".") . "m³" }}
                                        </small>
                                    </td>
                                    @foreach ($datas as $data)
                                    <td class="">
                                        <small>
                                            <strong>{{ $vendas->where("sale_date", $data)->sum("qtd_sale") == 0 ? "-" : number_format($vendas->where("sale_date", $data)->sum("qtd_sale"), 1, ",", ".") . "m³" }}</strong>
                                        </small>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    
    @endif
    
</div>
    