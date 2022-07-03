<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseController extends Controller
{
    public function create(Request $request)
    {
        if ($request->input('goods_id') != null) {
            $getQty = DB::table('goods')->where('id', $request->input('goods_id'))->first();
            $goods = DB::table('goods')
                ->where('id', $request->input('goods_id'))
                ->update(['qty' => $getQty->qty + $request->input('qty')]);

            $purchase = Purchase::create([
                'goods_id' => $request->input('goods_id'),
                'category' => $request->input('category'),
                'goods_name' => $request->input('goods_name'),
                'company' => $request->input('company'),
                'qty' => $request->input('qty'),
                'pay_total' => $request->input('pay_total')
            ]);

            return response([
                'body' => [
                    'goods' => $goods,
                    'purchase' => $purchase
                ]
            ], Response::HTTP_OK);
        }
        $goods = Goods::create([
            'name' => $request->input('goods_name'),
            'qty' => $request->input('qty'),
            'category' => $request->input('category')
        ]);
        $lastId = DB::table('goods')->orderBy('id', 'desc')->first();
        $purchase = Purchase::create([
            'goods_name' => $request->input('goods_name'),
            'goods_id' => $lastId->id,
            'category' => $request->input('category'),
            'company' => $request->input('company'),
            'qty' => $request->input('qty'),
            'pay_total' => $request->input('pay_total')
        ]);

        return response([
            'body' => [
                'goods' => $goods,
                'purchase' => $purchase
            ]
        ], Response::HTTP_OK);
    }

    public function findAll()
    {
        return response([
            'body' => Purchase::all()
        ]);
    }

    public function findById(Request $request)
    {
        return response([
            'body' =>  Purchase::find($request->input('id'))
        ]);
    }

    public function findByProductName(Request $request)
    {
        return response([
            'body' =>  Purchase::where('goods_name', $request->input('name'))
                ->orWhere('goods_name', 'like', '%' . $request->input('name') . '%')->get()
        ]);
    }

    public function update(Request $request)
    {
        DB::table('purchases')
            ->where('id', $request->input('id'))
            ->update([
                'qty' => $request->input('qty'),
                'goods_name' => $request->input('goods_name'),
                'category' => $request->input('category'),
                'company' => $request->input('company'),
                'pay_total' => $request->input('pay_total')
            ]);

        return response([
            'body' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $purchase = Purchase::find($request->input('id'));
        $purchase->delete();
        return response([
            'body' => 'success'
        ]);
    }
}
