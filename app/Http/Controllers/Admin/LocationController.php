<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Validator;
use DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.location.index')
            ->with([
                'locations' => Location::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.location.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'location' => 'required|max:255',
                'address' => 'required',
                'lat' => 'nullable|numeric',
                'lng' => 'nullable|numeric',
            ]);

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

            DB::commit();

            return redirect()
                ->route('locations.index')
                ->with('status', 'Location added : ' . $location);

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
    public function edit($id)
    {
        return view('admin.location.form')
            ->with([
                'location' => Location::find($id),
            ]);
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
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'location' => 'required|max:255',
                'address' => 'required',
                'lat' => 'nullable|numeric|between:-9999999999.99,9999999999.99',
                'lng' => 'nullable|numeric|between:-9999999999.99,9999999999.99',
            ]);

            if ($validator->fails()) {
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }
            $location = Location::find($id)->update([
                'location' => $request->location,
                'address' => $request->address,
                'lat' => $request->lat ?? NULL,
                'lng' => $request->lng ?? NULL,
                'description' => $request->description ?? NULL,
            ]);

            DB::commit();

            return redirect()
                ->route('locations.index')
                ->with('status', 'Location edited : ' . $location);

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
}
