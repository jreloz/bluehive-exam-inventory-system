<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class InventoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //$this->middleware('auth');
        if(auth('api')->check()){
            return 'With API Login';
        }else{
            return 'Unauthorized!';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $inventories = DB::table('inventories')
        // ->select('invoice_no','customer_name','invoice_date')
        // ->get();
        
        // return response()->json([
        //     'statuscode' => 201,
        //     'inventories' => $inventories,

        //     'remarks' => 'Transaction completed successfully!'
        // ]);

        return auth()->user();

        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products  = json_decode(json_encode($request->itemsarray));

        try {
            DB::beginTransaction();

            DB::table('inventories')->insert(
                [
                    'invoice_no' => $request->invoiceno,
                    'invoice_date' => $request->invoicedate,
                    'customer_name' => $request->customername
                ]
            );

            foreach ($products as $pkey) {
                DB::table('products')->insert(
                    [ 
                        'invoice_no' => $request->invoiceno,
                        'name' => $pkey->name,
                        'quantity' => $pkey->quantity,
                        'price' => $pkey->price,
                        'subtotal' => $pkey->subtotal,  
                    ]
                );
            }
           
            DB::commit();
            return response()->json([
                'statuscode' => 201,
                'remarks' => 'Transaction completed successfully!'
            ]);
        }  catch (QueryException $qe) {
            DB::rollBack();
            return response()->json([
                'statuscode' => $qe->errorInfo[1],
                'remarks' => $qe->errorInfo[2]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();
            $inventories = DB::table('inventories')
            ->select('invoice_no','customer_name','invoice_date')
            ->where('invoice_no',$id)
            ->get();
    
            $products = DB::table('products')
            ->select('name','quantity','price','subtotal')
            ->where('invoice_no',$id)
            ->get();


            DB::commit();
            return response()->json([
                'statuscode' => 201,
                'inventories' => $inventories,
                'products' => $products,
                'remarks' => 'Transaction completed successfully!'
            ]);
        }  catch (QueryException $qe) {
            DB::rollBack();
            return response()->json([
                'statuscode' => $qe->errorInfo[1],
                'remarks' => $qe->errorInfo[2]
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $products  = json_decode(json_encode($request->itemsarray));

        try {
            DB::beginTransaction();

            DB::table('inventories')
            ->where('invoice_no', '=', $request->invoiceno)
            ->update([
                'invoice_date' => $request->invoicedate,
                'customer_name' => $request->customername
            ]);

            DB::table('products')
            ->where('invoice_no', '=', $request->invoiceno)
            ->delete();

            foreach ($products as $pkey) {
                DB::table('products')->insert(
                    [ 
                        'invoice_no' => $request->invoiceno,
                        'name' => $pkey->name,
                        'quantity' => $pkey->quantity,
                        'price' => $pkey->price,
                        'subtotal' => $pkey->subtotal,  
                    ]
                );
            }
           
            DB::commit();
            return response()->json([
                'statuscode' => 201,
                'remarks' => 'Transaction completed successfully!'
            ]);
        }  catch (QueryException $qe) {
            DB::rollBack();
            return response()->json([
                'statuscode' => $qe->errorInfo[1],
                'remarks' => $qe->errorInfo[2]
            ]);
        }
    }

}
