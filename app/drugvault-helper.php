<?php

// LIBRARIES
use Illuminate\Support\Facades\Request;

// MODELS
use App\Models\Menu;
use App\Models\MenuAuth;

if (!function_exists('split_name')) {
  function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );

    if ($last_name == '') {
      return $first_name[0];

    } else {
      return $first_name[0] . $last_name[0];
    }
  }
}

if (!function_exists('check')) {
  function check($model)
  {
    return $model . " activated";
  }
}

// * Reference Function, function that use for reference
if (!function_exists('reference')) {
  function reference($code, $value = null)
  {
    switch ($code) {
      case 'gender':
        (object) $data = [
          'L' => 'Laki-laki',
          'P' => 'Perempuan',
        ];
        return ($value == null) ? $data : $data[$value];
        break;
      case 'status':
        (object) $data = [
          '0' => 'Tidak Aktif',
          '1' => 'Aktif',
        ];
        return ($value == null) ? $data : $data[$value];
        break;
      default:
        return "not found";
        break;
    }
  }
}

if (!function_exists('show_image')) {
  function show_image($src = null)
  {
    if (!empty($src)) {
      if (file_exists(public_path($src))) {
        return asset($src);
      } else {
        return asset('static/not_found.png');
      }
    } else {
      return asset('static/not_found.png');
    }
  }
}

if (!function_exists('show_image')) {
  function show_image($source)
  {
    if ($source == NULL) {
      $source = asset('storage/nofound.png');
    }
    return $source;
  }
}

if (!function_exists('get_menu_id')) {
  function get_menu_id($menu)
  {
    $menuData = Menu::where('link_menu', $menu)->first();

    if ($menuData) {
      return $menuData->id_menu;
    } else {
      return abort(419, 'Maaf Anda tidak dapat mengakses menu ini!');
    }
  }
}

if (!function_exists('isAccess')) {
  function isAccess($act, $menu, $role)
  {
    $action = MenuAuth::where('role_id', $role)->where('menu_id', $menu)->where('is_active', '1')->first();

    //tidak memiliki akses
    if ($action == NULL) {
      return FALSE;
    }

    if (strpos($action->action_menu_auth, $act) !== false) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}

if (!function_exists('activeMenu')) {
  function activeMenu($uri = '')
  {
    $active = '';

    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri . '*')) {
      $active = 'active';
    }

    return $active;
  }
}

if (!function_exists('isSelected')) {
  function IsSelected($param_one, $param_two)
  {
    return ($param_one == $param_two) ? "selected" : null;
  }
}

if (!function_exists('rupiah_format')) {
  function rupiah_format($nominal)
  {
    return number_format($nominal, 0, 0, ".");
  }
}

if (!function_exists('hp')) {
  function hp($nohp)
  {
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")", "", $nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".", "", $nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if (!preg_match('/[^+0-9]/', trim($nohp))) {
      // cek apakah no hp karakter 1-3 adalah +62
      if (substr(trim($nohp), 0, 3) == '+62') {
        $hp = trim($nohp);
      }
      // cek apakah no hp karakter 1 adalah 0
      elseif (substr(trim($nohp), 0, 1) == '0') {
        $hp = '62' . substr(trim($nohp), 1);
      }
    }
    return $hp;
  }
}

if (!function_exists('number_wa')) {
  function number_wa($number)
  {
    if ($number == "") {
      return "";
    }
    $code = substr($number, 0, 1);
    if ($code == "0") {
      // echo $code;
      $phone = "62" . substr($number, 1);
    } elseif ($code == "62") {
      // echo $code;
      $phone = $number;
    } elseif ($code == "+62") {
      // echo $code;
      $phone = substr($number, 1);
    } else {
      $phone = $number;
    }
    return $phone;
  }
}

function xprint_r($print)
{
  echo "<pre>";
  print_r($print);
  echo "</pre>";
}

if (!function_exists('whatNumber')) {
  function whatNumber($number)
  {
    $number = strtolower($number);
    $words = array(
      'a' => "1",
      'b' => "2",
      'c' => "3",
      'd' => "4",
      'e' => "5",
      'f' => "6",
      'g' => "7",
      'h' => "8",
      'i' => "9",
      'j' => "10",
      'k' => "11",
      'l' => "12",
      'm' => "13",
      'n' => "14",
      'o' => "15",
      'p' => "16",
      'r' => "17",
      's' => "18",
      't' => "19",
      'u' => "20",
      'v' => "21",
      'w' => "22",
      'x' => "23",
      'y' => "24",
      'z' => "25",
    );
    return $words[$number];
  }
}

if (!function_exists('fnBulan')) {
  function fnBulan($bulan)
  {
    $bulan = (int) $bulan;
    if ($bulan == "7") {
      $bln = "Juli";
    } else if ($bulan == "8") {
      $bln = "Agustus";
    } else if ($bulan == "9") {
      $bln = "September";
    } else if ($bulan == "10") {
      $bln = "Oktober";
    } else if ($bulan == "11") {
      $bln = "November";
    } else if ($bulan == "12") {
      $bln = "Desember";
    } else if ($bulan == "1") {
      $bln = "Januari";
    } else if ($bulan == "2") {
      $bln = "Februari";
    } else if ($bulan == "3") {
      $bln = "Maret";
    } else if ($bulan == "4") {
      $bln = "April";
    } else if ($bulan == "5") {
      $bln = "Mei";
    } else if ($bulan == "6") {
      $bln = "Juni";
    } else {
      $bln = "";
    }
    return $bln;
  }
}

if (!function_exists('fnDate')) {
  function fnDate($value, $format)
  {
    $date = explode("-", $value);

    $tgl = $date[2];
    $bln = $date[1];
    $thn = $date[0];

    $return = "";
    switch ($format) {
      case "DDMMYYYY":
        $return = $tgl . " " . fnBulan($bln) . " " . $thn;
        break;
      case "DD":
        $return = $tgl;
        break;
      case "MM":
        $return = $bln;
        break;
      case "YYYYY":
        $return = $thn;
        break;
      case "MMYYYY":
        $return = fnBulan($bln) . " " . $thn;
        break;
      case "mm":
        $return = fnBulan($bln);
        break;
      case "HHDDMMYYYY":
        $eks = explode(" ", $tgl);
        $tgl = $eks[0];
        $jam = $eks[1];
        list($H, $M, $S) = explode(":", $jam);
        $return = $tgl . " " . fnBulan($bln) . " " . $thn . " | " . $H . ":" . $M . ":" . $S;
        break;
    }
    return $return;
  }
}

if (!function_exists('create_link')) {
  function create_link($string, $separator = '-')
  {
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array('&' => 'and', "'" => '');
    $string = mb_strtolower(trim($string), 'UTF-8');
    $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
    $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
    $string = preg_replace("/[$separator]+/u", "$separator", $string);
    return $string;
  }
}