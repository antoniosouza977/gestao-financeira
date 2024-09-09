<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IncomeRepository;
use App\Entities\Income;
use App\Validators\IncomeValidator;

/**
 * Class IncomeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IncomeRepositoryEloquent extends EloquentRepository implements IncomeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Income::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return IncomeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function filterRequest(Request $request): array
    {
        $data = $request->only([
            'amount',
            'amount',
            'category_id',
            'date',
            'description',
            'monthly_income'
        ]);
        $data['date'] = isset($data['date']) ? Carbon::make($data['date'])->format('Y-m-d') : null;
        $data['user_id'] = auth()->id();
        return array_filter($data);
    }

}
