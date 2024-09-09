<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

abstract class EloquentRepository extends BaseRepository
{

    public function model()
    {
        return app($this->model);
    }

    public function findByUser(User $user = null)
    {
        return $this->getModel()->where('user_id', $user->id ?? auth()->id())->get();
    }
}
