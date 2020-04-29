<?php

namespace Itkee\LaravelRestful\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait Index
{
    /**
     * Index
     *
     * @return AnonymousResourceCollection
     *
     * @author hanmeimei
     */
    public function index(Request $request)
    {
        //构造查询条件
        $where = static::beforeIndex($request);

        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();
        try{
            $list = $model::query()->withTrashed()->where($where)->paginate(static::PER_PAGE);

            if($resource){
                return $resource::collection($list);
            }else{
                return response()->json($list, 200);
            }
        }catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }
}
