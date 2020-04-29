<?php

namespace Itkee\LaravelRestful\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait Store
{
    /**
     * Store
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function store(Request $request)
    {
        //数据验证
        $this->formRequestValidation('Store');

        //保存操作前进行数据验证
        $beforeResult = $this->beforeStore($request);
        if(is_array($beforeResult) && $beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        };

        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        if($resource){
            return new $resource($model::create(request()->all())->refresh());
        }else{
            return response()->json($model::create(request()->all())->refresh(), 200);
        }
    }
}
