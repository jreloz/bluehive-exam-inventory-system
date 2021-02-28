@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Record') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/inventory/">Back</a>
                    <hr>

                    <form action="" name="inventory" id="inventory" method="post">
                       
                        @foreach($inventories as $inventory)
                        <div class="row">
                            <div class="col-md-4">
                                <span>Invoice No.</span>
                                <input readonly type="text" class="form-control" value="{{$inventory->invoice_no}}" name="invoiceno" required>
                            </div>
                            <div class="col-md-4">
                                <span>Invoice Date</span>
                                <input type="date" class="form-control" value="{{$inventory->invoice_date}}" name="invoicedate" required>
                            </div>
                            <div class="col-md-4">
                                <span>Customer Name</span>
                                <input type="text" class="form-control" value="{{$inventory->customer_name}}" name="customername" required>
                            </div>
                        </div>
                        @endforeach
                        

                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_products">Add</button>
                            </div>
                        </div>


                    
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="productstable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $pcnt = 0; @endphp
                                            @foreach($products as $product)
                                            @php $pcnt++ @endphp
                                            <tr id='prow@php echo $pcnt @endphp'>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->quantity}}</td>
                                                <td>{{$product->price}}</td>
                                                <td>{{$product->subtotal}}
                                                    <button type='button' data-id='row@php echo $pcnt @endphp' class='btn-danger float-right remrow'>
                                                        <span class='fas fa-trash'></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="3">Total</td>
                                                <td scope="col" id="total">0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info float-right">Save Changes</button>
                            </div>
                        </div>
                        </form>


                        <div class="modal fade" id="modal_products" tabindex="-1" role="dialog" aria-labelledby="Products" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Product Information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" required id="productname">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Quantity</label>
                                    <input type="number" onkeyup="calsubtotal()" value="0" class="form-control" id="quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Price</label>
                                    <input type="number" onkeyup="calsubtotal()" value="0.00" class="form-control" id="price" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Subtotal</label>
                                    <input type="number" readonly class="form-control" id="subtotal" required>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="additem" class="btn btn-primary">Continue</button>
                                </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>



    $(document).ready(function(){
        sumprice();
    });

    $('#inventory').on('submit',function(e){
        
        e.preventDefault();
        var itemsarray = [];
        $("#productstable > tbody > tr").each(function () {
            itemsarray.push({
                "name": $(this).find('td').eq(0).text(),
                "quantity": $(this).find('td').eq(1).text(),
                "price": $(this).find('td').eq(2).text(), 
                "subtotal": $(this).find('td').eq(3).text(),
            });
        });

        $.ajax({
            type: 'POST',
            url: '/inventory/update/{{$inventory->invoice_no}}',
            data: $('#inventory').serialize() + '&itemsarray=' +
                encodeURIComponent(JSON.stringify(itemsarray)),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        .done(function (data) {
            statuscode = data.statuscode
            remarks = data.remarks
            if (statuscode == "201") {
                alert(remarks);
                window.history.back();
            } else {
                e.preventDefault();
                alert(remarks);
            }
        });
    });

    var tid;
    var pcnt = @php echo $pcnt @endphp;
    $('#additem').on('click',function(){
        var name = $('#productname').val();
        var quantity = $('#quantity').val();
        var price = $('#price').val();
        var subtotal = $('#subtotal').val();

        $("#productstable > tbody").
        prepend("<tr id='prow" + pcnt + "'>" +
            "<td>" + name + "</td>" +
            "<td>" + quantity + "</td>" +
            "<td>" + price + "</td>" +
            "<td>" + "<div id='stotal'>" + subtotal + "</div>" +
            "<button type='button' data-id='row" + pcnt + "' class='btn-danger float-right remrow'>" +
                "<span class='fas fa-trash'></span>" +
            "</button>" +
            
            "</td>" +
            
            "</tr>"
            )
        $('#modal_products').modal('hide'); 
        sumprice();
    })


    $("#productstable").on('click', '.remrow', function () {
        tid = $(this).data('id');
        $(this).parent().parent().remove();
        sumprice();
    });


    function sumprice(){
        var total = 0.00;
        $("#productstable > tbody > tr").each(function () {
            total = parseFloat(total) + parseFloat($(this).find('td').eq(3).text());
        });
        $('#total').html(total);
    }

    function calsubtotal(){
        var qty = $('#quantity').val();
        var price = parseFloat($('#price').val());
        var subtotal = price * qty;

        $('#subtotal').val(subtotal);
    }
</script>
                   
@endsection