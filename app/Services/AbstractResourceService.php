<?php

namespace App\Services;

use App\Http\Requests\AbstractUpdateOrCreateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;
use voku\helper\ASCII;

class AbstractResourceService
{
    protected int $itemsPerPage = 20;

    protected Model $mainModel;

    public function __construct(Model $mainModel)
    {
        $this->mainModel = $mainModel;
    }

    /**
     * @param Request|null $request
     * @return LengthAwarePaginator|ResourceCollection
     */
    public function list(Request $request = null)
    {
        return $this->mainModel::query()->paginate($this->itemsPerPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AbstractUpdateOrCreateRequest $request
     * @return Model
     */
    public function store(array $requestData)
    {
        $object = new $this->mainModel;
        $object->fill($requestData);
        $object->save();
        return $object;
    }

    /**
     * Display the specified resource.
     *
     * @param Model $object
     * @return Model
     */
    public function show(Model $object): Model
    {
        return $object;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $request
     * @param Model $object
     * @return Model
     */
    public function update($request, Model $object): Model
    {
        $object->fill($request->all());
        $object->save();
        return $object;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $object
     * @return bool
     */

    public function destroy(Model $object): bool
    {
        return $object->delete();
    }
}
