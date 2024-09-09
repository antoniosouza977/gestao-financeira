<?php

namespace App\Services;

use App\Repositories\IncomeCategoryRepositoryEloquent;
use Illuminate\Support\Collection;

class IncomeCategoryService
{

    private IncomeCategoryRepositoryEloquent $incomeCategoryRepository;

    public function __construct(IncomeCategoryRepositoryEloquent $incomeCategoryRepositoryEloquent)
    {
        $this->incomeCategoryRepository = $incomeCategoryRepositoryEloquent;
    }

    public function listUserCategories() : Collection
    {
        $defaultCategories = $this->incomeCategoryRepository->findWhere(['user_id' => null]);
        $userCategories = $this->incomeCategoryRepository->findByField('user_id', auth()->id());

        return $defaultCategories->merge($userCategories);
    }

}
