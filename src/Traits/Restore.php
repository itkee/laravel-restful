<?php

namespace Itkee\LaravelRestful\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait Restore
{
    /**
     * Restore
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    public function restore()
    {
        $model = static::getModelFQCN();
        $resource = static::getResourceFQCN();

        $currentModel = $model::find($this->getRouteId());
        $currentModel->restore();

        return new $resource($currentModel);
    }
}
