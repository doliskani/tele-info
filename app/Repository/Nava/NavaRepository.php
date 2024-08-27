<?php

namespace App\Repository\Persone;

use App\Helpers\Constant;
use App\Models\Nava;
use App\Models\Row;
use App\Models\User;
use App\Repository\BaseRepository;
use App\Repository\Persone\PersoneRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NavaRepository extends BaseRepository implements PersoneRepositoryInterface
{

   /**
    * VipRepository constructor.
    *
    * @param User $model
    */
   public function __construct(Nava $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();    
   }

   /**
    * @param array $attributes
    * @return Collection
    */
   public function create(array $attributes): Model
   {
       return $this->model->create($attributes);    
   }

  
    /**
    * @param int $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);  
    }

    /**
    * @param Model $model 
    * @param array $attributes
    * @return int
    */
    public function update(Model $model , array $attributes): int
    {
        return $this->model->update($attributes);
    }


}