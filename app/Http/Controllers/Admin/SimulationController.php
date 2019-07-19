<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tree;
use App\Product;
use App\Simulation;
use Illuminate\Support\Facades\Validator;
use DataTables;

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param App\Tree $tree
     * @param App\Product $product
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Tree $tree, Product $product)
    {
        return view('admin.product.simulation.index')
            ->with([
                'tree' => $tree,
                'product' => $product
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param App\Tree $tree
     * @param App\Product $product
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Tree $tree, Product $product)
    {
        return view('admin.product.simulation.create')
            ->with([
                'tree' => $tree,
                'product' => $product
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Tree $tree
     * @param App\Product $product
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Tree $tree, Product $product, Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Simulation::create([
            'product_id' => $product->id,
            'year' => $request->year,
            'min' => $request->min,
            'max' => $request->max
        ]);

        if ($product->simulations()->count() < 6) {
            return redirect()
                ->route('admin.tree.product.simulation.create', ['tree' => $tree, 'product' => $product])
                ->with('status', __('Tambahkan data simulasi hingga terdiri dari minimal 6 data. Saat ini terdapat ' . $product->simulations()->count() . ' data'));
        } else {
            return redirect()
                ->route('admin.tree.product.simulation.index', ['tree' => $tree, 'product' => $product])
                ->with('status', __('Simulasi ditambahkan'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tree $tree, Product $product, Simulation $simulation)
    {
        return view('admin.product.simulation.create')
            ->with([
                'tree' => $tree,
                'product' => $product,
                'simulation' => $simulation
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Tree $tree
     * @param App\Product $product
     * @param App\Simulation $simulation
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Tree $tree, Product $product, Simulation $simulation, Request $request)
    {
        $validator = $this->validator($request, $simulation);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $simulation->update([
            'year' => $request->year ?? $simulation->year,
            'min' => $request->min ?? $simulation->min,
            'max' => $request->max ?? $simulation->max
        ]);

        return redirect()
            ->route('admin.tree.product.simulation.index', ['tree' => $tree, 'product' => $product])
            ->with('status', __('Simulasi diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Tree
     * @param App\Product
     * @param App\Simulation
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tree $tree, Product $product, Simulation $simulation)
    {
        if ($product->simulations()->get()->count() <= 6) {
            return redirect()
                ->route('admin.tree.product.simulation.index', ['tree' => $tree, 'product' => $product])
                ->with('status', __('Jumlah simulasi tidak boleh kosong'));
        } else {
            $simulation->delete();

            return redirect()
                ->route('admin.tree.product.simulation.index', [$tree, $product])
                ->with('status', __('Simulasi dihapus'));
        }
    }

    /**
     * simulation datatable
     * 
     * @return DataTables
     */
    public function table(Tree $tree, Product $product)
    {
        return DataTables::eloquent(Simulation::query()->where('product_id', $product->id)->orderBy('year', 'asc'))
            ->addColumn('action', function ($simulation) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.tree.product.simulation.edit', ['tree' => $simulation->product->tree, 'product' => $simulation->product, 'simulation' => $simulation]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="post" action="'.route('admin.tree.product.simulation.destroy', ['tree' => $simulation->product->tree, 'product' => $simulation->product, 'simulation' => $simulation]).'">
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
     * @param Illuminate\Http\Request $request
     * @param App\Simulation $simulation
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $simulation = NULL)
    {
        if (isset($simulation)) {
            $requiredRule = 'nullable';
            $maxVal = $simulation->max;
            $minVal = $simulation->min;
            $max = $maxVal;
        } else {
            $requiredRule = 'required';
            $maxVal = $request->max;
            $minVal = $request->min;
            $max = isset($maxVal) ? $maxVal : 100;
        }

        return Validator::make($request->only([
            'year',
            'min',
            'max'
        ]), [
            'year' => array($requiredRule, 'numeric', 'min:0'),
            'min' => array($requiredRule, 'numeric', 'min:0', 'max:' . $max),
            'max' => array($requiredRule, 'numeric', 'min:' . $minVal, 'max:100')
        ]);
    }
}
