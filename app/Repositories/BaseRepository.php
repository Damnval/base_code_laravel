<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    protected $model;

    /**
     * Constructor to bind model to repo
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records of a Model
     * can get the model relationships by passing it in $with array
     *
     * @param array $with
     * @return Collection
     */
    public function getAllRecords(array $with = []): Collection
    {
        if ($with) {
            return $this->model->with($with)->get();
        }

        return $this->model->all();
    }

    /**
    * Saving Attributes of a Model to resource
    *
    * @param array $attributes
    * @return Model Newly saved Model resource
    */
    public function store(array $attributes): Model
    {
        $this->model->fill($attributes);
        $this->model->save();
        return $this->model;
    }

    /**
     * Get properties and fields of a model
     * Can get the relationship by passing in $with
     *
     * @param integer $id
     * @param array $with
     * @return Model|null
     */
    public function show(int $id, array $with = []): ?Model
    {
        if ($with) {
            return $this->model->with($with)->findOrFail($id);
        }

        return $this->model->findOrFail($id);
    }

    /**
     * Update Model's properties and fields
     *
     * @param array $attributes
     * @param int $id
     * @return Model
     */
    public function update(array $attributes, int $id): ?Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($attributes);

        return $model;
    }

    /**
     * Delete a model in Resourckke
     *
     * @param integer $id
     * @return boolean
     */
    public function destroy(int $id): bool
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    /**
     * Get collection Model based on query
     *
     * @param array $attributes
     * @param array $with
     * @return Collection|null
     */
    public function where(array $attributes, array $with = []): ?Collection
    {
        $model = $this->model->where($where);

        if ($with) {
            return $model->with($with);
        }

        return $model;
    }
}
