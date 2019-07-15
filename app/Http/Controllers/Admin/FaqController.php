<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;
use Illuminate\Support\Facades\Validator;
use DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create');
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

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('status', __('Faq ditambahkan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('admin.faq.create')
            ->with([
                'faq' => $faq
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $validator = $this->validator($request, $faq);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $faq->update([
            'question' => $request->question ?? $faq->question,
            'answer' => $request->answer ?? $faq->answer
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('status', __('Faq diedit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faq.index')
            ->with('status', __('Faq dihapus'));
    }

    /**
     * datatables of Faqs
     * 
     * @return DataTables
     */
    public function table()
    {
        return DataTables::eloquent(Faq::query()->orderBy('created_at', 'asc'))
            ->addColumn('action', function ($faq) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.faq.edit', [$faq]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="post" action="'.route('admin.faq.destroy', [$faq]).'">
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
     * @param $faq
     * 
     * @return Illuminate\Support\Facades\Validator
     */
    protected function validator(Request $request, $faq = NULL)
    {
        if (isset($faq)) {
            $requiredRule = 'nullable';
        } else {
            $requiredRule = 'required';
        }

        return Validator::make($request->only([
            'question',
            'answer'
        ]), [
            'question' => array($requiredRule, 'string'),
            'answer' => array($requiredRule, 'string')
        ]);
    }
}
