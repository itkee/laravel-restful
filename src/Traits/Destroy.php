<?php

namespace Itkee\LaravelRestful\Traits;

use Baijunyao\LaravelRestful\Exceptions\LaravelRestfulException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait Destroy
{

    /**
     * @param Request $request
     * 删除前操作
     */
    protected function beforeDestory(Request $request){}
    
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
        if(is_array($beforeResult) && $beforeResult['statusCode'] !== 200){
            return response()->json(['error' => $beforeResult['error']], $beforeResult['statusCode']);
        }

        if ($model::destroy($id) === 0) {
            return response()->json(['error' => '删除失败'], 500);
        }
        $resource = static::getResourceFQCN();

        if($resource){
            return new $resource($model::find($id));
        }else{
            return response()->json($model::withTrashed()->find($id), 200);
        }
    }
}
