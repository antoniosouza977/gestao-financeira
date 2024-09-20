<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Payment;
use App\Validators\BaseValidator;
use App\Validators\PaymentValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfirmIncomePaymentController extends Controller
{

    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'payments.index';

    public function __construct(PaymentValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->only(['income_id', 'value', 'date']);
        return $this->baseStore(new Payment(), $data);
    }

}
