<?php

namespace Itkee\LaravelRestful\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait Show
{

    /**
     * @param Request $request
     * 查询前操作
     */
    protected function beforeShow(Request $request){}

    /**
     * Show
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function show(Request $request)
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();
        //保存操作前进行数据验证
        $beforeResult = $this->beforeShow($request);
        if(is_array($beforeResult) && $beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        };
        
        if($resource){
            return new $resource($model::withTrashed()->find($this->getRouteId()));
        }else{
            return response()->json($model::withTrashed()->find($this->getRouteId()), 200);
        }
    }
}
