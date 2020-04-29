<?php

namespace itkee\LaravelRestful\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait Show
{
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
        if($beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        };
        
        if($resource){
            return new $resource($model::withTrashed()->find($this->getRouteId()));
        }else{
            return response()->json($model::withTrashed()->find($this->getRouteId()), 200);
        }
    }
}