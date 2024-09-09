<?php

namespace App\Repositories;

use App\Entities\IncomeCategory;
use App\Models\User;
use App\Validators\IncomeCategoryValidator;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class IncomeCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IncomeCategoryRepositoryEloquent extends EloquentRepository implements IncomeCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return IncomeCategory::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return IncomeCategoryValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findByUser(User $user = null)
    {
        $user = $user ?? auth()->user();
        return $this->getModel()
            ->where('user_id', $user->id)
            ->orWhere('user_id', null)
            ->get();
    }

}
