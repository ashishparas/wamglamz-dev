<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\User;
use \App\Role;
use Illuminate\Support\Facades\Mail;
use Hash;
use App;
use App\Message as MyModel;

class MessageController extends ApiController {

//    private static $__selectedAttributes = ['id','name','date','from_time','to_time','description','image'];

    public function getItems(Request $request) {
        $rules = ['search' => '', 'limit' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {
            $model = new MyModel();
            $perPage = isset($request->limit) ? $request->limit : 20;
            if (isset($request->search))
                $model = $model->Where('name', 'LIKE', "%$request->search%");
//                        ->orWhere('short_description', 'LIKE', "%$request->search%");
//            $model = $model->orderBy($request->order_by, $request->sort_by);
            $model = $model->orderBy('id','desc');
//            $model = $model->where('state', '1');
            return parent::success($model->paginate($perPage));
        } catch (\Exception $ex) {

            return parent::error($ex->getMessage());
        }
    }

    public function getItem(Request $request) {
        $rules = ['id' => 'required|exists:messages'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {
            $model = new MyModel();
            $model = $model->whereId($request->id);
            return parent::success($model->first());
        } catch (\Exception $ex) {

            return parent::error($ex->getMessage());
        }
    }


}
