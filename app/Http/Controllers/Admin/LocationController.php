<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use DB;
use App\User;
use App\Order;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Order $order)
    {
        if (empty($order->location_id)) {
            return redirect()
                ->route('admin.user.order.location.create', [$user, $order]);
        } else {
            return redirect()
                ->route('admin.user.order.location.edit', [$user, $order, $order->location_id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, Order $order)
    {   
        // return view('admin.location.form');
        return view('admin.user.location.create')
            ->with([
                'user' => $user,
                'order' => $order
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Order $order, Request $request)
    {
        // TODO: Refactor Location storing method
        DB::beginTransaction();
        try {
            $validator = $this->validator($request);

            if ($validator->fails()) {
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }

            $location = Location::create([
                'location' => $request->location,
                'address' => $request->address,
                'lat' => $request->lat ?? NULL,
                'lng' => $request->lng ?? NULL,
                'description' => $request->description ?? NULL,
            ]);

            $order->update([
                'location_id' => $location->id
            ]);

            DB::commit();

            return redirect()
                ->route('admin.user.order', [$user, $order])
                ->with('status', __('Lokasi ditambahkan'));

        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\User $user
     * @param App\Order $order
     * @param App\Location $location
     * 
     * @return \Illuminate\View\View
     */
    public function edit(User $user, Order $order, Location $location)
    {
        return view('admin.user.location.create')
            ->with([
                'user' => $user,
                'order' => $order,
                'location' => $location
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\User $user
     * @param App\Order $order
     * @param App\Location $location
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Order $order, Location $location, Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = $this->validator($request);

            if ($validator->fails()) {
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }

            $location->update([
                'location' => $request->location ?? $location->location,
                'address' => $request->address ?? $location->address,
                'lat' => $request->lat ?? $location->lat,
                'lng' => $request->lng ?? $location->lng,
                'description' => $request->description ?? $location->description
            ]);

            DB::commit();

            return redirect()
                ->route('admin.user.order', [$user, $order])
                ->with('status', __('Lokasi diedit'));

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
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $location = Location::findOrFail($id);

            if ($location->orders()->count() > 0) {
                return redirect()
                    ->route('locations.index')
                    ->with('status', 'Delete is prohibited because it will cascade other data(s)');
            } else {
                $location->delete();
                DB::commit();

                return redirect()
                ->route('locations.index')
                ->with('status', 'Location ' . $id .' deleted');
            }


        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }
    }

    /**
     * validation rule
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->only([
            'location',
            'address',
            'description',
            'latitude',
            'longitude'
        ]), [
            'location' => 'required|max:255',
            'address' => 'required',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);
    }
}
