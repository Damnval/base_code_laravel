<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array $with
     * @return Collection
     */
    public function getAllRecords(array $with = []): Collection;

    /**
     * @param array $attributes
     * @return Model
    */
    public function store(array $attributes): Model;

    /**
     * @param integer $id
     * @param array $with
     * @return Model|null
     */
    public function show(int $id, array $with = []): ?Model;

    /**
     * @param array $attributes
     * @param integer $id
     * @return Model|null
     */
    public function update(array $attributes, int $id): ?Model;

    /**
     * @param integer $id
     * @return boolean
     */
    public function destroy(int $id): bool;

    /**
     * @param array $attributes
     * @param array $with
     * @return Collection|null
     */
    public function where(array $attributes, array $with = []): ?Collection;
}
