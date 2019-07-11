<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
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

        if ($request->has('img')) {
            $path = $request->file('img')->store('public/banner');
            $image = basename($path);
        }

        Banner::create([
            'img' => config('app.url') . '/banner/' . $image,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.banner.index')
            ->with('status', __('Banner ditambahkan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.create')
            ->with([
                'banner' => $banner
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = $this->validator($request, $banner);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('img')) {
            $this->deleteFile($banner->img);
            $path = $request->file('img')->store('public/banner');
            $image = basename($path);
        }

        $banner->update([
            'img' => $request->has('img') ? (config('app.url') . '/banner/' . $image) : $banner->img,
            'description' => $request->description ?? $banner->description
        ]);

        return redirect()
            ->route('admin.banner.index')
            ->with('status', __('Banner diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()
            ->route('admin.banner.index')
            ->with('status', __('Banner dihapus'));
    }

    /**
     * validation rule
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $banner = NULL)
    {
        if (isset($banner)) {
            $rule = 'nullable';
        } else {
            $rule = 'required';
        }

        return Validator::make($request->only([
            'img',
            'description'
        ]), [
            'img' => array($rule, 'file', 'mimetypes:image/jpeg,image/jpg,image/png'),
            'description' => 'required'
        ]);
    }

    /**
     * banner datatable
     * 
     * @return DataTables
     */
    public function table()
    {
        return DataTables::eloquent(Banner::query()->orderBy('created_at', 'desc'))
            ->editColumn('img', function ($banner) {
                return '<img src="'.$banner->img.'" class="img-fluid img-thumbnail">';
            })
            ->editColumn('created_at', function ($banner) {
                return $banner->created_at->format('d-m-Y');
            })
            ->addColumn('action', function ($banner) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.banner.edit', [$banner]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.route('admin.banner.destroy', [$banner]).'" method="post">
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
                'img',
                'description',
                'action'
            ])
            ->make(true);
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
        $oldFile = trim($file, config('app.url'));
        Storage::delete('public/' . $oldFile);
    }
}
