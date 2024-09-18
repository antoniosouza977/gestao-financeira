<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Models\Payment;
use App\Services\PaymentsService;
use App\Validators\PaymentValidator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PaymentsController
{

    private PaymentsService $paymentsService;
    private PaymentValidator $validator;
    private SaveModelAction $saveModelAction;

    public function __construct(PaymentsService $paymentsService, PaymentValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->paymentsService = $paymentsService;
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function index(): Response
    {
        $incomesWithNoPayment = $this->paymentsService->missingIncomePayments();
        $payments = $this->paymentsService->userPayments();

        return Inertia::render('Payments/Index', compact('incomesWithNoPayment', 'payments'));
    }

    public function create(): Response
    {
        $incomes = Auth::user()->incomes;

        return Inertia::render('Payments/Form', compact('incomes'));
    }

    public function store(Request $request): RedirectResponse
    {
        {
            try {
                $data = $request->only(['value', 'description', 'date']);
                $data['user_id'] = auth()->id();
                $data['month'] = Carbon::make($data['date'])?->month;

                $this->saveModelAction
                    ->setModel(new Payment())
                    ->setData($data)
                    ->setValidator($this->validator)
                    ->validateData(ValidationType::CREATE)
                    ->execute();

                return Redirect::route('payments.index');
            } catch (ValidationException $exception) {
                return Redirect::back()->withErrors($exception->errors())->withInput();
            }
        }
    }

    public function edit(Payment $payment): Response
    {
        $incomes = Auth::user()->incomes;

        return Inertia::render('Payments/Form', compact('payment', 'incomes'));
    }

    public function update(Payment $payment, Request $request): RedirectResponse
    {
        if ($payment->user_id !== auth()->id()) {
            return Redirect::route('payments.index');
        }

        try {
            $data = $request->only(['value', 'description', 'date', 'income_id']);
            $data['month'] = Carbon::make($data['date'])?->month;

            $this->saveModelAction
                ->setModel($payment)
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::UPDATE)
                ->execute();

            return Redirect::route('payments.index');
        } catch (ValidationException $exception) {
            return Redirect::back()->withErrors($exception->errors())->withInput();
        }
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        if ($payment->user_id !== auth()->id()) {
            return Redirect::route('payments.index');
        }

        $payment->load('income');
        $income = $payment->income;

        $payment->delete();

        if (!$income?->active && $income?->payments->count() === 0) {
            $income->delete();
        }

        return Redirect::route('payments.index');
    }


}
