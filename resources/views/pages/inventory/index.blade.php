@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Inventory') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/inventory/create">New Record</a>
                    <hr>
                    <div class="row">
                            <div class="col-md-12">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="productstable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Invoice No.</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $pcnt = 0; @endphp
                                            @foreach($inventories as $inventory)
                                            @php $pcnt++ @endphp
                                                <tr>
                                                    <td><a href="/inventory/{{$inventory->invoice_no}}">{{$inventory->invoice_no}}</a></td>
                                                    <td>{{$inventory->customer_name}}</td>
                                                    <td>{{$inventory->invoice_date}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{$inventories->links()}}
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection