<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

// MODELS
use App\Models\DrugCategory;

class DrugCategoryController extends Controller
{
  private $views = 'pages.drug-category';
  private $url = '/drug-category';
  private $title = 'Drug Category';
  private $page = 'Drug Category';

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
    if (request()->ajax()) {
      $datas = DrugCategory::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_drug_category']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('drug-category');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('drug-category.show', $data->id_drug_category) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('drug-category.edit', $data->id_drug_category) . '"> Edit</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_drug_category . '" data-name="' . $data->name_drug_category . '"> Hapus</a>';
          }

          return '
              <div class="dropleft text-center">
                <button class="btn btn-sm btn-icon" category="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                </button>

                <div class="dropdown-menu m-0">
                  ' . $btn_detail . '
                  ' . $btn_edit . '
                  ' . $btn_delete . '
                </div>
              </div>
          ';
        })
        ->addColumn('set_admin', function ($data) {
          $set_admin = '<div class="text-pink text-center">' . $data->user->username . '</div>';
          return $set_admin;
        })
        ->rawColumns(['action', 'set_admin'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('drug-category'),
    ];

    return view($this->views . '.index', $data);
  }

  /**
   * Rules to store a newly created or to update specified resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function rules($request)
  {
    $rule = [
      'name_drug_category' => 'required|string|max:100',
    ];
    $message = [
      'name_drug_category.required' => 'Kategori Obat wajib diisi!',
      'name_drug_category.max' => 'Kategori Obat max 100 karakter!',
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $data = [
      'url' => $this->url,
      'title' => 'New ' . $this->title,
      'page' => $this->page,
    ];

    return view($this->views . '.create', $data);
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    $validator = $this->rules($request->all());
    $check_name_drug_category = DrugCategory::where('name_drug_category', $request->name_drug_category)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_name_drug_category != null) {
      return response()->json(['status' => false, 'message' => $request->name_drug_category . " telah digunakan!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new DrugCategory();

        $post->user_id = Auth::user()->id;

        $post->name_drug_category = $request->name_drug_category;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data Kategori Obat berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data Kategori Obat gagal disimpan!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    $get_data = DrugCategory::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => $this->title . ' Detail',
      'page' => $this->page,
      'get_data' => $get_data,
    ];

    return view($this->views . '.show', $data);
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $get_data = DrugCategory::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => 'Edit Data ' . $this->title,
      'page' => $this->page,
      'get_data' => $get_data,
    ];

    return view($this->views . '.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    $validator = $this->rules($request->all());
    $check_name_drug_category = DrugCategory::where('name_drug_category', $request->name_drug_category)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = DrugCategory::findOrFail($id);

        if ($request->name_drug_category != $post->name_drug_category) {
          if ($check_name_drug_category == null) {
            $post->name_drug_category = $request->name_drug_category;
          } else {
            return response()->json(['status' => false, 'message' => $request->name_drug_category . " telah digunakan!"], 200);
          }
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data Kategori Obat berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data Kategori Obat gagal diperbarui!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $hapus = DrugCategory::destroy($id);

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  public function getDrugCategoryBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = DrugCategory::orderby('name_drug_category', 'ASC')
        ->limit(10)
        ->get();
    } else {
      $data = DrugCategory::orderby('name_drug_category', 'ASC')
        ->where('name_drug_category', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_drug_category,
        "text" => $item->name_drug_category
      );
    }

    return response()->json($response);
  }
}
