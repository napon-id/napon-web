<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tree;
use App\Product;
use Validator;
use DB;

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
    public function create()
    {
        if (!request()->has('tree')) {
            return redirect()->back();
        }

        $tree = Tree::find(request()->get('tree'));

        return view('admin.product.form')
            ->with('tree', $tree);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!request()->has('tree')) {
            return redirect()->back();
        }

        $tree = Tree::find(request()->get('tree'));

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'tree_quantity' => 'required|numeric|integer|min:0',
                'img' => 'required',
                'percentage' => 'required|numeric|integer|min:0|max:100',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $product = Product::create([
                'tree_id' => $tree->id,
                'name' => $request->name,
                'description' => $request->description,
                'tree_quantity' => $request->tree_quantity,
                'img' => $request->img,
                'percentage' => $request->percentage,
                'time' => $request->time,
                'available' => $request->available ? 'yes' : 'no',
                'has_certificate' => $request->has_certificate ? 1 : 0,
            ]);

            DB::commit();

            return redirect()
                ->route('products.index', [$tree])
                ->with('status', 'Product created => ' . $product);
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
        if (!request()->has('tree')) {
            return redirect()->back();
        }

        return view('admin.product.form')
            ->with([
                'tree' => Tree::find(request()->get('tree')),
                'product' => Product::findOrFail($id),
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
        if (!request()->has('tree')) {
            return redirect()->back();
        }

        $tree = Tree::find(request()->get('tree'));

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'tree_quantity' => 'required|numeric|integer|min:0',
                'img' => 'required',
                'percentage' => 'required|numeric|integer|min:0|max:100',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $product = Product::find($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->tree_quantity = $request->tree_quantity;
            $product->img = $request->img;
            $product->percentage = $request->percentage;
            $product->time = $request->time;
            $product->available = $request->available ? 'yes' : 'no';
            $product->has_certificate = $request->has_certificate ? 1 : 0;
            $product->update();

            DB::commit();

            return redirect()
                ->route('products.index', [$tree])
                ->with('status', 'Product updated => ' . $product);
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
            $product = Product::findOrFail($id);
            if ($product->orders()->count() == 0) {
                $product->delete();
                DB::commit();

                return redirect()
                    ->back()
                    ->with('status', 'Product ' .$id. ' deleted');
            } else {
                return redirect()
                    ->back()
                    ->with('status', 'Delete is prohibited because it will cascade other data(s)');
            }
        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }

    }
}
