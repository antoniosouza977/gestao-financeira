<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Payment;
use App\Services\PaymentsService;
use App\Validators\BaseValidator;
use App\Validators\PaymentValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class PaymentsController extends Controller
{

    protected PaymentsService $paymentsService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'payments.index';

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

        return inertia()->render('Payments/Index', compact('incomesWithNoPayment', 'payments'));
    }

    public function create(): Response
    {
        $incomes = auth()->user()->incomes;

        return inertia()->render('Payments/Form', compact('incomes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'description', 'date']);
        return $this->baseStore(new Payment(), $data);
    }

    public function show(Payment $payment): Response
    {
        return $this->edit($payment);
    }

    public function edit(Payment $payment): Response
    {
        $incomes = auth()->user()->incomes;

        return inertia()->render('Payments/Form', compact('payment', 'incomes'));
    }

    public function update(Payment $payment, Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'description', 'date', 'income_id']);
        return $this->baseUpdate($payment, $data);
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->load('income');
        $income = $payment->income;

        $payment->delete();

        if (!$income?->active && $income?->payments->count() === 0) {
            $income->delete();
        }

        return redirect()->route($this->indexRoute);
    }


}
