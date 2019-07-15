<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Province;
use App\Cities;
use DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param App\Province $province
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Province $province)
    {
        return view('admin.province.city.index')
            ->with([
                'province' => $province
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param App\Province $province
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Province $province)
    {
        return view('admin.province.city.create')
            ->with([
                'province' => $province
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param App\Province $province
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Province $province)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Cities::create([
            'province_id' => $province->id,
            'name' => $request->name
        ]);

        return redirect()
            ->route('admin.province.city.index', [$province])
            ->with('status', __('Kota ditambahkan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Province
     * @param App\Cities $city
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province, Cities $city)
    {
        return view('admin.province.city.create')
            ->with([
                'province' => $province,
                'city' => $city
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Province $province
     * @param  App\Cities $city
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province, Cities $city)
    {
        $validator = $this->validator($request, $city);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $city->update([
            'name' => $request->name ?? $city->name
        ]);

        return redirect()
            ->route('admin.province.city.index', [$province])
            ->with('status', __('Kota diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Province $province
     * @param  App\Cities $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province, Cities $city)
    {
        $city->delete();

        return redirect()
            ->route('admin.province.city.index', [$province, $city])
            ->with('status', __('Kota dihapus'));
    }

    /**
     * datatables of cities
     */
    public function table(Province $province)
    {
        return DataTables::eloquent(Cities::query()->where('province_id', $province->id)->orderBy('id', 'asc'))
            ->addColumn('action', function ($city) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.province.city.edit', ['province' => $city->province, 'city' => $city]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.route('admin.province.city.destroy', ['province' => $city->province, 'city' => $city]).'" method="post">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button class="btn" data-toggle="tooltip" data-placement="bottom" title="'.__('Hapus').'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * validation rules
     * 
     * @param Illuminate\Http\Request
     * @param $city
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $city = NULL)
    {
        if (isset($city)) {
            $requiredRule = 'nullable';
        } else {
            $requiredRule = 'required';
        }

        return Validator::make($request->only([
            'name'
        ]), [
            'name' => array($requiredRule, 'max:191')
        ]);
    }
}
