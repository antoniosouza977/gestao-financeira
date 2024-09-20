<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Outgo;
use App\Validators\BaseValidator;
use App\Validators\OutgoValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfirmExpenseOutgoController extends Controller
{

    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'outgoings.index';

    public function __construct(OutgoValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->only(['expense_id', 'value', 'date']);
        return $this->baseStore(new Outgo(), $data);
    }

}
