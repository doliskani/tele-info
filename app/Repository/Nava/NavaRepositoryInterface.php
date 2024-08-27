<?php

namespace App\Repository\Persone;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface NavaRepositoryInterface
{
   /**
    * @return Collection
    */
    public function all(): Collection;

   /**
    * @param array $attributes
    * @return Model
    */
    public function create(array $attributes): Model;

    /**
    * @param int $id
    * @return Model
    */
    public function find($id): ?Model;

   /**
    * @param Model $model 
    * @param array $attributes
    * @return int
    */
    public function update(Model $model , array $attributes): int;



}