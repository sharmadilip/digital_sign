@extends('layouts.app', ['activePage'=>'homepage','pageSlug' => 'dashboard'])
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                
                <div class="card-body">
                    <div class="chart-area" style="height: auto;">
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
                    <p class="card-category d-inline">Last 60 days</p>
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
                    <p class="card-category d-inline">Last 60 days</p>
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
            const ctx = document.getElementById('chartBig1');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug","Sep","Oct","Nov","Dec" ],
    datasets: [{
        label: "Approved",
        backgroundColor: "rgba(2, 82, 6, 0.31)",
        borderColor: "rgba(2, 82, 6, 0.7)",
        pointBorderColor: "rgba(2, 82, 6, 0.7)",
        pointBackgroundColor: "rgba(2, 82, 6, 0.7)",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointBorderWidth: 1,
        data: [{{$chart_data_approve}}],
        borderWidth: 1
    },{
        label: "Sent",
        backgroundColor: "rgba(38, 185, 154, 0.31)",
        borderColor: "rgba(38, 185, 154, 0.7)",
        pointBorderColor: "rgba(38, 185, 154, 0.7)",
        pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointBorderWidth: 1,
        data: [{{$chart_data_sent}}],
        borderWidth: 1
    }],
   
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
        });
    </script>
@endpush
