<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Province;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.province.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.province.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Province::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('admin.province.index')
            ->with('status', __('Provinsi ditambahkan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Province $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        return view('admin.province.create')
            ->with([
                'province' => $province
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Province $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        $validator = $this->validator($request, $province);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $province->update([
            'name' => $request->name ?? $province->name
        ]);

        return redirect()
            ->route('admin.province.index')
            ->with('status', __('Provinsi diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Province $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()
            ->route('admin.province.index')
            ->with('status', __('Provinsi dihapus'));
    }

    /**
     * datatables of provinces
     * 
     * @return DataTables
     */
    public function table()
    {
        return DataTables::eloquent(Province::query()->orderBy('id', 'asc'))
            ->addColumn('action', function ($province) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.province.city.index', [$province]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Kota').'">
                            <i class="fas fa-list"></i>
                        </a>
                        <a class="btn" href="'.route('admin.province.edit', [$province]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="post" action="'.route('admin.province.destroy', [$province]).'">
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
     * @param $province
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $province = NULL)
    {
        if (isset($province)) {
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
