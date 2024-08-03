<?php

namespace App\Http\Controllers;

// Libraries
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use stdClass;

// Models
use App\Models\StorageLog;
use App\Models\Drug;

class HomeController extends Controller
{
  private $url = '/';
  private $title = 'Home Page';

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
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $date = date('Y-m-d', time());
    $date = strtotime($date);
    $date = strtotime("+30 day", $date);
    $date = date("Y-m-d", $date);

    $response = array();
    $storage_in = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')->where('expired_storage', '<=', $date)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->get();
    $storage_out = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')->where('expired_storage', '<=', $date)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->get();

    // QTY NOT OUT
    for ($i = 0; $i < count($storage_in); $i++) { 
      $slog_out = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')->where('drug_id', $storage_in[$i]->drug_id)->where('expired_storage', $storage_in[$i]->expired_storage)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->first();
      $slog_in = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')->where('drug_id', $storage_in[$i]->drug_id)->where('expired_storage', $storage_in[$i]->expired_storage)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->get();
      if ($slog_out == null) {
        $drug_name = Drug::where('id_drug', $storage_in[$i]->drug_id)->first()->name_drug;
        $qty = 0;
        for ($i = 0; $i < count($slog_in); $i++) {
          $qty += $storage_in[$i]->qty_storage;
        }
        $response[] = array(
          "drug_id" => $drug_name,
          "expired_storage" => $storage_in[$i]->expired_storage,
          "qty_storage" => rupiah_format($qty)
        );
      }
    }

    // QTY SUM
    for ($i = 0; $i < count($storage_out); $i++) { 
      $slog_in = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')->where('drug_id', $storage_out[$i]->drug_id)->where('expired_storage', $storage_out[$i]->expired_storage)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->first();
      if ($slog_in != null) {
        $drug_name = Drug::where('id_drug', $storage_out[$i]->drug_id)->first()->name_drug;
        $in = StorageLog::where('drug_id', $storage_out[$i]->drug_id)->where('expired_storage', '<=', $date)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->sum('qty_storage');
        $out = StorageLog::where('drug_id', $storage_out[$i]->drug_id)->where('expired_storage', '<=', $date)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->sum('qty_storage');
        $response[] = array(
          "drug_id" => $drug_name,
          "expired_storage" => $slog_in->expired_storage,
          "qty_storage" => rupiah_format($in - $out)
        );
      }
    }

    // $storage_not_out = StorageLog::select('drug_id', 'expired_storage', 'qty_storage')
    //                     ->where('expired_storage', '<=', $date)
    //                     ->where('type_storage', 'IN')
    //                     ->where('is_cancelled', '!=', '1')
    //                     ->whereNotIn('expired_storage', DB::table('tb_storage')->where('expired_storage', '<=', $date)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->get()->pluck('drug_id', 'expired_storage'))
    //                     ->get();

    // $storage = StorageLog::where('expired_storage', '<=', $date)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->get()->pluck('expired_storage');
    // dd($response);

    $response = array();

    foreach ($storage_in as $in) {
      foreach ($storage_out as $out) {
        if ($in->expired_storage == $out->expired_storage) {
          $stock = $in->qty_storage - $out->qty_storage;
          if ($stock != 0) {
            $response[] = array(
              "expired_storage" => $in->expired_storage,
              "qty_storage" => rupiah_format($stock)
            );
          }
        }
      }
    }

    // if (count($storage_not_out) > 0) {
    //   foreach ($storage_not_out as $str) {
    //     $response[] = array(
    //       "expired_storage" => $str->expired_storage,
    //       "qty_storage" => rupiah_format((int)$str->qty_storage)
    //     );
    //   }
    // }

    usort($response, function ($a, $b) {
      return $a['expired_storage'] > $b['expired_storage'];
    });

    for ($i = 0; $i < count($response); $i++) { 
      $response[$i]['expired_storage'] = Carbon::createFromFormat("Y-m-d", $response[$i]['expired_storage'])->format("d-m-Y");
    }


    $data = [
      'url' => $this->url,
      'title' => $this->title,
      'get_menu' => get_menu_id('home'),
    ];

    return view('pages.home.index', $data);
  }
}
