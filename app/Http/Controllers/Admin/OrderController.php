<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\OrderUpdate;
use DataTables;
use App\Report;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * display report table
     * 
     * @param App\User
     * 
     * @return Illuminate\Http\Response
     */
    public function report(User $user, Order $order)
    {
        return view('admin.user.order.report')
            ->with([
                'user' => $user,
                'order' => $order
            ]);
    }

    public function reportTable(User $User, Order $order)
    {
        return DataTables::eloquent(Report::query()->where('order_id', '=', $order->id)->orderBy('created_at', 'desc'))
            ->editColumn('start_date', function ($report) {
                return Carbon::createFromFormat('Y-m-d', $report->start_date)->format('d-m-Y');
            })
            ->editColumn('end_date', function ($report) {
                return Carbon::createFromFormat('Y-m-d', $report->end_date)->format('d-m-Y');
            })
            ->editColumn('report_image', function ($report) {
                return '
                    <img src="'.$report->report_image.'" class="img-fluid img-thumbnail">
                ';
            })
            ->editColumn('report_video', function ($report) {
                return '
                    <video width="320" height="240" controls class="ml-3 mr-3 mb-3 mt-3">
                        <source src="'.$report->report_video.'" type="video/mp4">
                    </video>
                ';
            })
            ->addColumn('action', function ($report) {
                return '
                    <div class="btn-group">
                        <a class="btn" href="'.route('admin.user.order.report.edit', [$report->order->user, $report->order, $report]).'" data-toggle="tooltip" data-placement="bottom" title="'.__('Edit').'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.route('admin.user.order.report.destroy', [$report->order->user, $report->order, $report]).'" method="post">
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
                'report_image',
                'report_video',
                'action'
            ])
            ->make(true);
    }

    /**
     * add order report
     * 
     * @param App\User
     * @param App\Order
     * @param App\Report
     * 
     * @return Illuminate\View\View
     */
    public function reportCreate(User $user, Order $order)
    {
        return view('admin.user.order.create')
            ->with([
                'user' => $user,
                'order' => $order
            ]);
    }

    /**
     * store order report
     * 
     * @param App\User
     * @param App\Order
     * @param App\Report
     * 
     * @return Illuminate\Http\Response
     */
    public function reportStore(User $user, Order $order, Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('report_image')) {
            $path = $request->file('report_image')->store('public/report');
            $image = basename($path);
        }

        if ($request->has('report_video')) {
            $path = $request->file('report_video')->store('public/report');
            $video = basename($path);
        }

        $report = Report::create([
            'order_id' => $order->id,
            'report_key' => md5('Report-' . $user->email . '-' . now()),
            'period' => $request->period,
            'start_date' => Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'),
            'tree_height' => $request->tree_height,
            'tree_diameter' => $request->tree_diameter,
            'tree_state' => $request->tree_state,
            'weather' => $request->weather,
            'report_image' => $request->has('report_image') ? (config('app.url') . '/report/' . $image) : '',
            'report_video' => $request->has('report_video') ? (config('app.url') . '/report/' . $video) : ''
        ]);

        if ($report) {
            return redirect()
                ->route('admin.user.order.report', [$user, $order])
                ->with('status', __('Laporan ditambahkan'));
        }
    }

    /**
     * edit order report
     * 
     * @param App\User
     * @param App\Order
     * @param App\Report
     * 
     * @return Illuminate\View\View
     */
    public function reportEdit(User $user, Order $order, Report $report)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $report->start_date)->format('d-m-Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $report->end_date)->format('d-m-Y');

        return view('admin.user.order.create')
            ->with([
                'user' => $user,
                'order' => $order,
                'report' => $report,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
    }

    /**
     * update order report
     * 
     * @param App\User
     * @param App\Order
     * @param App\Report
     * 
     * @return Illuminate\View\View
     */
    public function reportUpdate(User $user, Order $order, Report $report, Request $request)
    {
        $validator = $this->validator($request, $report);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('report_image')) {
            $this->deleteFile($report->report_image);

            $imagePath = $request->file('report_image')->store('public/report');
            $image = basename($imagePath);
        }

        if ($request->has('report_video')) {
            $this->deleteFile($report->report_video);

            $videoPath = $request->file('report_video')->store('public/report');
            $video = basename($videoPath);
        }

        $report->update([
            'period' => $request->has('period') ? $request->period : $report->period,
            'start_date' => $request->has('start_date') ? Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d') : $report->start_date,
            'end_date' => $request->has('end_date') ? Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d') : $report->end_date,
            'tree_height' => $request->has('tree_height') ? $request->tree_height : $report->tree_height,
            'tree_diameter' => $request->has('tree_diameter') ? $request->tree_diameter : $report->tree_diameter,
            'tree_state' => $request->has('tree_state') ? $request->tree_state : $report->tree_state,
            'weather' => $request->has('weather') ? $request->weather : $report->weather,
            'report_image' => $request->has('report_image') ? (config('app.url') . '/report/' . $image) : $report->report_image,
            'report_video' => $request->has('report_video') ? (config('app.url') . '/report/' . $video) : $report->report_video
        ]);

        return redirect()
            ->route('admin.user.order.report', [$user, $order])
            ->with('status', __('Laporan diedit'));
    }

    /**
     * delete order report
     * 
     * @param App\User
     * @param App\Order
     * @param App\Report
     * 
     * @return Illuminate\View\View
     */
    public function reportDestroy(User $user, Order $order, Report $report)
    {
        if (isset($report->report_video)) {
            $this->deleteFile($report->report_video);
        }

        if (isset($report->report_image)) {
            $this->deleteFile($report->report_image);
        }
        
        $report->delete();
        
        return redirect()
            ->route('admin.user.order.report', [$user, $order])
            ->with('status', __('Laporan dihapus'));
    }

    /**
     * order index
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('admin.order.index');
    }

    public function table()
    {
        return DataTables::eloquent(Order::query()->orderBy('created_at', 'desc'))
            ->addColumn('date', function ($order) {
                return $order->created_at;
            })
            ->addColumn('product', function ($order) {
                return $order->product()->first()->name;
            })
            ->addColumn('email', function ($order) {
                return $order->user()->first()->email;
            })
            ->addColumn('status', function ($order) {
                switch ($order->status) {
                    case 'waiting':
                        return '<span class="badge badge-warning">Waiting</span>';
                        break;
                    case 'paid':
                        return '<span class="badge badge-info">Paid</span>';
                        break;
                    case 'investing':
                        return '<span class="badge badge-primary">Investing</span>';
                        break;
                    case 'done':
                        return '<span class="badge badge-success">Done</span>';
                        break;
                    default:
                        return $order->status;
                        break;
                }
            })
            ->addColumn('action', function ($order) {
                return '
                    <div class="btn-group">
                        <button class="btn order-update-modal" data-toggle="modal" data-target="#orderUpdateModal" data-url="'.route('admin.order.edit', [$order->id]).'" data-post="'.route('admin.order.update', [$order->id]).'">
                        <i class="fas fa-pencil-alt"></i>
                        </button>
                        <a href="'.route('admin.order.update.index', [$order]).'" class="btn" data-toggle="tooltip" data-placement="bottom" title="order updates" target="_blank">
                            <i class="fas fa-list-ol"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function edit($id)
    {
        return response()->json(Order::find($id));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        // if ($request->selling_price) {
        //     $order->selling_price = $request->selling_price;
        // }
        if ($request->status) {
            $order->status = $request->status;
        }
        $order->save();

        return response()->json([
            'order' => $order,
        ]);
    }

    /**
     * validation rule
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Suport\Facades\Validator
     */
    protected function validator(Request $request, $report = NULL)
    {
        if (isset($report)) {
            $fileRule = 'nullable';
        } else {
            $fileRule = 'required';
        }

        return Validator::make($request->only([
            'period',
            'start_date',
            'end_date',
            'tree_height',
            'tree_diameter',
            'tree_state',
            'weather',
            'report_image',
            'report_video'
        ]), [
            'period' => 'required|max:191',
            'start_date' => 'required|date|date_format:d-m-Y',
            'end_date' => 'required|date|date_format:d-m-Y',
            'tree_height' => 'required|numeric',
            'tree_diameter' => 'required|numeric',
            'tree_state' => 'required|string|max:191',
            'weather' => 'required|string|max:191',
            'report_image' => array($fileRule, 'file', 'mimetypes:image/jpeg,image/png', 'max:2048'),
            'report_video' => array($fileRule, 'file', 'mimetypes:video/mp4')
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
