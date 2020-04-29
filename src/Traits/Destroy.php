<?php

namespace itkee\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait Destroy
{
    /**
     * Destroy
     *
     * @return ResponseFactory|Response
     * @throws LaravelRestfulException
     *
     * @author hanmeimei
     */
    public function destroy(Request $request)
    {
        $id = $this->getRouteId();
        $model = static::getModelFQCN();

        //保存操作前进行数据验证
        $beforeResult = $this->beforeDestory($request);
        if($beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        };

        if ($model::destroy($id) === 0) {
            return response()->json(['error' => '删除失败'], 500);
        }
        $resource = static::getResourceFQCN();

        if($resource){
            return new $resource($model::withTrashed()->find($id));
        }else{
            return response()->json($model::withTrashed()->find($id), 200);
        }
    }
}
