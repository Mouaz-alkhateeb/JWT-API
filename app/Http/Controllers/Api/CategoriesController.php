<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $categories = Categories::select('id', 'name_' . app()->getLocale())->get();
        return $this->SuccesResponse('1111', 'Success...!', 'categories', $categories);
    }
    public function get_category(Request $request)
    {
        $category = Categories::find($request->id);
        if (!$category)
            return $this->ErrorResponse('0000', 'Error...!');
        return $this->SuccesResponse('1111', 'Success...!', 'categroy', $category);
    }


    public function change_status(Request $request)
    {
        $category = Categories::where('id', $request->id)->update(['active' => $request->active]);
        return $this->changeStatus('2000', 'status change successfully...!');
    }
}
