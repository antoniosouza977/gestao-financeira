<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Models\Payment;
use App\Validators\ConfirmPaymentValidator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ConfirmIncomePaymentController extends Controller
{

    private ConfirmPaymentValidator $validator;
    private SaveModelAction $saveModelAction;

    public function __construct(ConfirmPaymentValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        try {
            $data = $request->only(['income_id', 'value', 'date']);
            $data['user_id'] = auth()->id();
            $data['month'] = Carbon::make($data['date'])?->month;

            $this->saveModelAction
                ->setModel(new Payment())
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::CREATE)
                ->execute();

            return Redirect::back();
        } catch (ValidationException $exception) {
            return Redirect::back()->withErrors($exception->errors())->withInput();
        }
    }

}
