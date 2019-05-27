<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Article;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
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
            $path = $request->file('img')->store('public/blog');
            $fileName = basename($path);
        }

        $blog = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'img' => $request->has('img') ? (config('app.url') . '/images/blog/' . $fileName) : '',
            'author' => auth()->user()->name
        ]);

        if ($blog) {
            $blog->update([
                'slug' => $blog->makeSlug($blog->title)
            ]);
        }

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog added');
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
        $blog = Article::findOrFail($id);

        return view('admin.blog.create')
            ->with('blog', $blog);
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
        $blog = Article::findOrFail($id);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $blog->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        $blog->update([
            'slug' => $blog->makeSlug($blog->title)
        ]);

        if ($request->has('img')) {
            $path = $request->file('img')->store('public/blog');
            $fileName = basename($path);
            
            $blog->update([
                'img' => $request->has('img') ? (config('app.url') . '/images/blog/' . $fileName) : ''
            ]);
        }

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Article::findOrFail($id);
        $blog->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog deleted : ' . $blog->title);
    }

    /**
     * Datatable for blog
     * 
     * @return DataTable
     */
    public function table()
    {
        return DataTables::of(Article::query())
            ->editColumn('img', function ($blog) {
                return '<img style="max-height: 5em;" src="'.$blog->img.'">';
            })
            ->addColumn('action', function ($blog) {
                return '
                    <a class="btn" href="'.route('admin.blog.show', [$blog]).'"><i class="fas fa-eye"></i></a>
                    <a class="btn" href="'.route('admin.blog.edit', [$blog]).'"><i class="fas fa-pencil-alt"></i></a>
                    
                    <form action="'.route('admin.blog.destroy', [$blog]).'" method="POST">
                        '.csrf_field().'
                        '.method_field('DELETE'). '
                        <button class="btn">
                            <i class="fas fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns([
                'img',
                'action'
            ])
            ->make(true);
    }

    /**
     * Validator
     */
    protected function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'description' => 'required',
            'img' => 'nullable|file'
        ]);

        return $validator;
    }
}
