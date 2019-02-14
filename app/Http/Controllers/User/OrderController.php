<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\OrderDataTable;
use DataTables;
use App\Order;
use App\User;
use App\Product;
use Validator;
use DB;

class OrderController extends Controller
{
    use OrderDataTable;

    public function productApi()
    {
        $user_id = auth()->user()->id;

        $orders = DB::table('orders')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->join('trees', 'products.tree_id', '=', 'trees.id')
          ->select('orders.*', 'products.name as product_name', 'tree_quantity as product_tree_quantity', 'products.percentage as product_percentage', 'trees.price as tree_price')
          ->where('orders.user_id', '=', $user_id)
          ->get();

          return $this->generateOrderDatatable($orders, 'all');
    }

    public function productApiStatus($status)
    {
        $user_id = auth()->user()->id;

        $orders = DB::table('orders')
          ->join('products', 'orders.product_id', '=', 'products.id')
          ->join('trees', 'products.tree_id', '=', 'trees.id')
          ->select('orders.*', 'products.name as product_name', 'tree_quantity as product_tree_quantity', 'products.percentage as product_percentage', 'trees.price as tree_price')
          ->where('orders.user_id', '=', $user_id)
          ->where('status', $status)
          ->orderBy('orders.created_at', 'ASC')
          ->get();

        return $this->generateOrderDatatable($orders, $status);

    }

    public function productApiOrder()
    {
        if (request()->query('id')) {
          $product = DB::table('products')
            ->join('trees', 'products.tree_id', '=', 'trees.id')
            ->select('products.*', 'trees.name as tree_name', 'trees.price as tree_price')
            ->where('products.id', request()->query('id'))
            ->first();
          // $product = Product::find(request()->query('id'));
        } else {
          $product = Product::get();
        }

        return response()->json([
          'data' => $product,
        ]);
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'product' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
          return redirect()->route('user.product.order')
            ->withErrors($validator)
            ->withInput();
        }

        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->token = base64_encode(now());
        $order->product_id = $request->product;
        $order->save();

        return redirect()
            ->route('user.product.checkout', ['token' => $order->token]);
    }

    public function checkout($token)
    {
        $order = Order::where('token', $token)
            ->first();

        $transaction = $order->transaction()->first();

        if ($order == null || $order->status != 'waiting' || $order->user_id != auth()->user()->id) {
            return redirect()
                ->route('user.product');
        }

        return view('user.checkout')
            ->with([
                'order' => $order,
                'transaction' => $transaction,
                'status' => 'Proses checkout berhasil',
            ]);
    }
}
