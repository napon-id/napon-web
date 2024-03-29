<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tree;
use App\Product;
use DB;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tree $tree)
    {
        return view('admin.product.index')
            ->with('tree', $tree);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tree $tree)
    {
        return view('admin.product.form')
            ->with('tree', $tree);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Tree $tree, Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('img_black')) {
            $imgBlackPath = $request->file('img_black')->store('public/product');
            $img_black = basename($imgBlackPath);
        }

        if ($request->has('img_white')) {
            $imgWhitePath = $request->file('img_white')->store('public/product');
            $img_white = basename($imgWhitePath);
        }

        if ($request->has('img_background')) {
            $imgBackgroundPath = $request->file('img_background')->store('public/product');
            $img_background = basename($imgBackgroundPath);
        }

        $product = Product::create([
            'tree_id' => $tree->id,
            'name' => $request->name,
            'tree_quantity' => $request->tree_quantity,
            'description' => $request->description,
            'available' => 'yes',
            'price' => $request->price,
            'img_black' => config('app.url') . '/product/' . $img_black,
            'img_white' => config('app.url') . '/product/' . $img_white,
            'img_background' => config('app.url') . '/product/' . $img_background
        ]);

        return redirect()
            ->route('admin.tree.product.simulation.create', [$tree, $product])
            ->with('status', __('Produk ditambahkan. Silakan tambahkan simulasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tree $tree, Product $product)
    {
        return view('admin.product.form')
            ->with([
                'tree' => $tree,
                'product' => $product
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tree $tree, Product $product, Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = $this->validator($request, $product);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->has('img_black')) {
                // $this->deleteFile($product->img_black);
                $imgBlackPath = $request->file('img_black')->store('public/product');
                $img_black = basename($imgBlackPath);
            }

            if ($request->has('img_white')) {
                // $this->deleteFile($product->img_white);
                $imgWhitePath = $request->file('img_white')->store('public/product');
                $img_white = basename($imgWhitePath);
            }

            if ($request->has('img_background')) {
                // $this->deleteFile($product->img_background);
                $imgBackgroundPath = $request->file('img_background')->store('public/product');
                $img_background = basename($imgBackgroundPath);
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'tree_quantity' => $request->tree_quantity,
                'price' => $request->price,
                'img_black' => $request->has('img_black') ? (config('app.url') . '/product/' . $img_black) : $product->img_black,
                'img_white' => $request->has('img_white') ? (config('app.url') . '/product/' . $img_white) : $product->img_white,
                'img_background' => $request->has('img_background') ? (config('app.url') . '/product/' . $img_background) : $product->img_background
            ]);

            DB::commit();

            return redirect()
                ->route('admin.tree.product.index', [$tree])
                ->with('status', __('Tabungan diedit'));

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
    public function destroy(Tree $tree, Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            
            DB::commit();

            return redirect()
                ->route('admin.tree.product.index', [$tree])
                ->with('status', __('Tabungan dihapus'));

        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }

    }

    /**
     * product datatable
     * 
     * @return DataTables
     */
    public function table(Tree $tree)
    {
        return DataTables::eloquent(Product::query()->where('tree_id', $tree->id)->orderBy('created_at', 'asc'))
            ->editColumn('img_black', function ($product) {
                return '
                    <img src="'.$product->img_black.'" class="img-fluid img-thumbnail">
                ';
            }) 
            ->editColumn('img_white', function ($product) {
                return '
                    <img src="'.$product->img_white.'" class="img-fluid img-thumbnail">
                ';
            }) 
            ->editColumn('img_background', function ($product) {
                return '
                    <img src="'.$product->img_background.'" class="img-fluid img-thumbnail">
                ';
            })
            ->addColumn('action', function ($product) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.tree.product.simulation.index', ['tree' => $product->tree, 'product' => $product]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Simulasi').'">
                            <i class="fas fa-list"></i>
                        </a>
                        <a class="btn" href="'.route('admin.tree.product.edit', ['tree' => $product->tree, 'product' => $product]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.route('admin.tree.product.destroy', ['tree' => $product->tree, 'product' => $product]).'" method="post">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button class="btn" data-toggle="tooltip" data-placement="bottom" title="'.__('Hapus').'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            }) 
            ->rawColumns([
                'img_black',
                'img_white',
                'img_background',
                'action'
            ])
            ->make(true);
    }

    /**
     * validation rules
     * 
     * @param Illuminate\Http\Request
     * @param product
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $product = NULL)
    {
        if (isset($product)) {
            $requiredRule = 'nullable';
            $nameValidation = 'required|max:191|alpha_dash|unique:products,name,' . $product->id;
        } else {
            $requiredRule = 'required';
            $nameValidation = 'required|max:191|alpha_dash|unique:products';
        }

        return Validator::make($request->only([
            'name',
            'tree_quantity',
            'description',
            'price',
            'img_black',
            'img_white',
            'img_background'
        ]), [
            'name' => $nameValidation,
            'tree_quantity' => 'required|numeric|min:0',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'img_black' => array($requiredRule, 'file', 'max:2048', 'mimetypes:image/jpeg,image/jpg,image/png'),
            'img_white' => array($requiredRule, 'file', 'max:2048', 'mimetypes:image/jpeg,image/jpg,image/png'),
            'img_background' => array($requiredRule, 'file', 'max:2048', 'mimetypes:image/jpeg,image/jpg,image/png')
        ]);
    }

    /**
     * delete file based on dir
     * 
     * @param string file
     * 
     * @return void
     */
    protected function deleteFile($file)
    {
        // $oldFile = trim($file, config('app.url'));
        // Storage::delete('public/' . $oldFile);
    }
}
