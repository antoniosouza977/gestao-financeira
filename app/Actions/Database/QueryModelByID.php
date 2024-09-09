<?php

namespace App\Actions\Database;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QueryModelByID implements Action
{

    private Model $model;
    private int $id;

    public function setModel(Model $model): QueryModelByID
    {
        $this->model = $model;

        return $this;
    }

    public function setId(int $id): QueryModelByID
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Model
     * @throws ModelNotFoundException
     */
    public function execute(): Model
    {
        $model = $this->model->query()->find($this->id);

        if (!$model) {
            throw new ModelNotFoundException();
        }

        return $model;
    }
}
