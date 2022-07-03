<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findAll()
    {
        return response([
            'body' => Goods::all()
        ]);
    }

    public function findById(Request $request)
    {
        $goods = DB::table('goods')
            ->join('purchases', 'goods.id', '=', 'purchases.goods_id')
            ->select('*')
            ->where('goods.id', $request->input('id'))
            ->first();
        return response([
            'body' => $goods
        ]);
    }

    public function delete(Request $request)
    {
        $purchase = Goods::find($request->input('id'));
        $purchase->delete();
        return response([
            'body' => 'success'
        ]);
    }

    public function findByProductName(Request $request)
    {
        return response([
            'body' =>  Goods::where('name', $request->input('name'))
                ->orWhere('name', 'like', '%' . $request->input('name') . '%')->get()
        ]);
    }
}
