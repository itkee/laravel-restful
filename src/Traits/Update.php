<?php

namespace Itkee\LaravelRestful\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait Update
{

    /**
     * 更新前操作
     * @param Request $request
     */
    protected function beforeUpdate(Request $request){}

    /**
     * Update
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function update(Request $request)
    {
        $this->formRequestValidation('Update');

        //更新前逻辑操作 如果不是200状态码，则进行错误返回
        $beforeResult = $this->beforeUpdate($request);

        if(is_array($beforeResult) && $beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        }


        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        $currentModel = $model::find($this->getRouteId());
        $currentModel->update(request()->all());

        return new $resource($currentModel);
    }
}
