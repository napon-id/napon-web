<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderUpdate;
use App\Order;
use Validator;
use DB;

class OrderUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        return view('admin.update.index')
            ->with('order', $order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Order $order)
    {
        return view('admin.update.form')
            ->with([
                'order' => $order,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();
        try {
            $update = new OrderUpdate;
            $update->order_id = $order->id;
            $update->title = $request->title;
            $update->description = $request->description;
            $update->save();

            DB::commit();

            return redirect()
            ->route('admin.order.update.index', [$order])
            ->with('status', 'Order update created');
        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order, $id)
    {
        return view('admin.update.form')
            ->with([
                'update' => OrderUpdate::find($id),
                'order' => $order,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();
        try {
            $update = OrderUpdate::find($id);
            $update->title = $request->title;
            $update->description = $request->description;
            $update->save();

            DB::commit();

            return redirect()
            ->route('admin.order.update.index', [$order])
            ->with('status', 'Order update updated');
        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, $id)
    {
        $update = OrderUpdate::findOrFail($id);
        DB::beginTransaction();
        try {
            $update->delete();
            DB::commit();

            return redirect()
                ->route('admin.order.update.index', [$order])
                ->with('status', 'Order update deleted');
        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }

    }
}
