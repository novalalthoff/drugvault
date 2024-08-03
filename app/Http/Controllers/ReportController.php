<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use stdClass;

// MODELS
use App\Models\Drug;
use App\Models\StorageLog;

class ReportController extends Controller
{
  private $views = 'pages.report';
  private $url = '/report';
  private $title = 'Report';
  private $page = 'Report';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the form for creating a new resource.
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
   //
  }

  public function monthlyReport(Request $request)
  {
    $start = "2023-06-01";
    $start_str = strtotime($start);
    $week_1 = strtotime("+7 day", $start_str);
    $week_2 = strtotime("+8 day", $week_1);
    $week_3 = strtotime("+7 day", $week_2);
    $week_1 = date("Y-m-d", $week_1);
    $week_2 = date("Y-m-d", $week_2);
    $week_3 = date("Y-m-d", $week_3);
    $week_4 = strtotime("+1 month", $start_str);
    $week_4 = date("Y-m-d", $week_4);

    $last_start = strtotime("-1 month", $start_str);
    $last_start = date("Y-m-d", $last_start);
    $last_start_str = strtotime($last_start);
    $last_week_1 = strtotime("+7 day", $last_start_str);
    $last_week_2 = strtotime("+8 day", $last_week_1);
    $last_week_3 = strtotime("+7 day", $last_week_2);
    $last_week_1 = date("Y-m-d", $last_week_1);
    $last_week_2 = date("Y-m-d", $last_week_2);
    $last_week_3 = date("Y-m-d", $last_week_3);
    $last_week_4 = $start;

    $storage_in = new stdClass();
    $storage_out = new stdClass();

    $storage_in->week_1 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $start)->where('created_at', '<', $week_1)->sum('qty_storage');
    $storage_in->week_2 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_1)->where('created_at', '<', $week_2)->sum('qty_storage');
    $storage_in->week_3 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_2)->where('created_at', '<', $week_3)->sum('qty_storage');
    $storage_in->week_4 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_3)->where('created_at', '<', $week_4)->sum('qty_storage');
    $storage_in->last_week_1 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_start)->where('created_at', '<', $last_week_1)->sum('qty_storage');
    $storage_in->last_week_2 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_1)->where('created_at', '<', $last_week_2)->sum('qty_storage');
    $storage_in->last_week_3 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_2)->where('created_at', '<', $last_week_3)->sum('qty_storage');
    $storage_in->last_week_4 = (int) StorageLog::where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_3)->where('created_at', '<', $last_week_4)->sum('qty_storage');

    $storage_out->week_1 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $start)->where('created_at', '<', $week_1)->sum('qty_storage');
    $storage_out->week_2 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_1)->where('created_at', '<', $week_2)->sum('qty_storage');
    $storage_out->week_3 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_2)->where('created_at', '<', $week_3)->sum('qty_storage');
    $storage_out->week_4 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $week_3)->where('created_at', '<', $week_4)->sum('qty_storage');
    $storage_out->last_week_1 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_start)->where('created_at', '<', $last_week_1)->sum('qty_storage');
    $storage_out->last_week_2 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_1)->where('created_at', '<', $last_week_2)->sum('qty_storage');
    $storage_out->last_week_3 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_2)->where('created_at', '<', $last_week_3)->sum('qty_storage');
    $storage_out->last_week_4 = (int) StorageLog::where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $last_week_3)->where('created_at', '<', $last_week_4)->sum('qty_storage');

    $s_in = StorageLog::select('drug_id', DB::raw('SUM(qty_storage) AS qty'))->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $start)->where('created_at', '<', $week_4)->groupBy('drug_id')->get();
    $s_out = StorageLog::select('drug_id', DB::raw('SUM(qty_storage) AS qty'))->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->where('created_at', '>=', $start)->where('created_at', '<', $week_4)->groupBy('drug_id')->get();

    // $storage_in->drug_dist = new stdClass();
    // for ($i = 0; $i < count($s_in); $i++) { 
    //   $storage_in->drug_dist[$i]->drug = Drug::where('id_drug', $s_in[$i]->drug_id)->first()->name_drug;
    //   $storage_in->drug_dist[$i]->qty = $s_in[$i]->qty;
    // }

    // dd("week 1 : " . $week_1 . ", week 2 : " . $week_2 . ", week 3 : " . $week_3 . ", week 4 : " . $week_4);
    // dd($storage_out->week_4);

    $data = [
      'url' => $this->url,
      'title' => 'Monthly ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('monthly-report'),
      'get_menu_yearly' => get_menu_id('yearly-report'),
      'storage_in' => $storage_in,
      'storage_out' => $storage_out,
    ];

    return view($this->views . '.monthly-report', $data);
  }

  public function yearlyReport(Request $request)
  {
    $data = [
      'url' => $this->url,
      'title' => 'Yearly ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('yearly-report'),
      'get_menu_monthly' => get_menu_id('monthly-report'),
    ];

    return view($this->views . '.yearly-report', $data);
  }

  /**
   * Rules to store a newly created or to update specified resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function rules($request)
  {
    $rule = [
      //
    ];
    $message = [
      //
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    //
  }
}
