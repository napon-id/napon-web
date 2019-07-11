<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Description;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.description.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.description.create');
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
            $path = $request->file('img')->store('public/description');
            $image = basename($path);
        }

        Description::create([
            'img' => config('app.url') . '/description/' . $image,
            'title' => $request->title,
            'text' => $request->text
        ]);

        return redirect()
            ->route('admin.description.index')
                ->with('status', __('Deskripsi ditambahkan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Description $description)
    {
        return view('admin.description.create')
            ->with([
                'description' => $description
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Description $description)
    {
        $validator = $this->validator($request, $description);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('img')) {
            $this->deleteFile($description->img);
            $path = $request->file('img')->store('public/description');
            $image = basename($path);
        }

        $description->update([
            'img' => $request->has('img') ? (config('app.url') . '/description/' . $image) : $description->img,
            'text' => $request->has('text') ? $request->text : $description->text,
            'title' => $request->has('title') ? $request->title : $description->title
        ]);

        return redirect()
            ->route('admin.description.index')
            ->with('status', __('Deskripsi diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Description $description)
    {
        $this->deleteFile($description->img);

        $description->delete();

        return redirect()
            ->route('admin.description.index')
            ->with('status', __('Deskripsi dihapus'));
    }

    /**
     * description datatable
     * 
     * @return DataTables
     */
    public function table()
    {
        return DataTables::eloquent(Description::query()->orderBy('created_at', 'asc'))
            ->editColumn('img', function ($description) {
                return '
                    <img src="'.$description->img.'" class="img-fluid img-thumbnail">
                ';
            })
            ->addColumn('action', function ($description) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.description.edit', [$description]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.route('admin.description.destroy', [$description]).'" method="post">
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
                'action'
            ])
            ->make(true);
    }

    /**
     * validation rules
     * 
     * @param Illuminate\Http\Request
     * @param description
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $description = NULL)
    {
        if (isset($description)) {
            $requiredRule = 'nullable';
        } else {
            $requiredRule = 'required';
        }

        return Validator::make($request->only([
            'img',
            'text',
            'title'
        ]), [
            'img' => array($requiredRule, 'file', 'mimetypes:image/jpeg,image/jpg,image/png'),
            'text' => 'required',
            'title' => 'required|max:191'
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
        $oldFile = trim($file, config('app.url'));
        Storage::delete('public/' . $oldFile);
    }
}
