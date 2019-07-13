<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tree;
use Validator;
use DB;

class TreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tree.index')
            ->with([
                'trees' => Tree::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tree.form');
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
                'name' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $tree = Tree::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            DB::commit();
            return redirect()
                ->route('trees.index')
                ->with('status', __('Pohon ditambahkan'));

        } catch (\Exception $e) {
            abort(402, $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.tree.form')
            ->with('tree', Tree::findOrFail($id));
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
                'name' => 'required',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $tree = Tree::find($id);
            $tree->name = $request->name;
            $tree->description = $request->description;
            $tree->update();

            DB::commit();
            return redirect()
                ->route('trees.index')
                ->with('status', __('Pohon diedit'));

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
            $tree = Tree::findOrFail($id);
            $tree->delete();
            DB::commit();

            return redirect()
                ->route('trees.index')
                ->with('status', __('Pohon dihapus'));

        } catch (\Exception $e) {
            DB::rollback();
            abort(402, $e);
        }

    }
}
