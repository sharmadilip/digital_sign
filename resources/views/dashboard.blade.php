@extends('layouts.app', ['activePage'=>'homepage','pageSlug' => 'dashboard'])
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Total Contracts</h5>
                            <h2 class="card-title">This year</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Approved</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Send TO Client</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Draft</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card card-tasks">
                <div class="card-header ">
                    <h6 class="title d-inline">Approved</h6>
                    <p class="card-category d-inline">Last 30 days</p>
                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Client
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Sent Date
                                    </th>
                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aproved_contract as $ap_contract)
                                <tr>
                                    <td>
                                      {{$ap_contract->client_name}}
                                    </td>
                                    <td>
                                        @if($ap_contract->contract_type==1)Contract @else Quatation @endif
                                        
                                    </td>
                                    <td>
                                        {{$ap_contract->send_to_client}}
                                    </td>
                                    <td class="text-center">
                                      <a href="{{ route('pages.viewinvoice') }}?invoice_id={{$ap_contract->id}}" >View</a>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title d-inline">Sent to Client</h4>
                    <p class="card-category d-inline">Last 30 days</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Client
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Sent Date
                                    </th>
                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($send_contract as $sent_contract)
                                <tr>
                                    <td>
                                      {{$sent_contract->client_name}}
                                    </td>
                                    <td>
                                        @if($sent_contract->contract_type==1)Contract @else Quatation @endif
                                    </td>
                                    <td>
                                        {{$sent_contract->send_to_client}}
                                    </td>
                                    <td class="text-center">
                                      <a href="#" data-id="{{$sent_contract->id}}" id="send_to_client_contract">Re-send</a>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
         // demo.initDashboardPageCharts();
        });
    </script>
@endpush
