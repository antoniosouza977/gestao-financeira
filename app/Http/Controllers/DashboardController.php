<?php

namespace App\Http\Controllers;

use App\Services\BudgetsService;
use App\Services\IncomesService;
use App\Services\OutgoingsService;
use App\Services\PaymentsService;
use Carbon\Carbon;
use Inertia\Response;

class DashboardController extends Controller
{
    private PaymentsService $paymentsService;
    private OutgoingsService $outgoingsService;
    private IncomesService $incomesService;
    private BudgetsService  $budgetsService;

    public function __construct
    (
        PaymentsService  $paymentsService,
        OutgoingsService $outgoingsService,
        IncomesService   $incomesService,
        BudgetsService   $budgetsService
    )
    {
        $this->paymentsService = $paymentsService;
        $this->outgoingsService = $outgoingsService;
        $this->incomesService = $incomesService;
        $this->budgetsService = $budgetsService;
    }

    public function index(): Response
    {
        $startPeriod = Carbon::now()->startOfMonth()->format('d/m');
        $endPeriod = Carbon::now()->endOfMonth()->format('d/m');

        $paymentsTotal = $this->paymentsService->monthlyPaymentsTotal();
        $outgoingsTotal = $this->outgoingsService->monthlyOutgoingsTotal();
        $incomesTotal = $this->incomesService->monthlyIncomesTotal();
        $budgetsTotal = $this->budgetsService->monthlyBudgetsTotal();
        $latestsOutgoings = $this->outgoingsService->latestsOutgoings();


        return inertia()->render('Dashboard',
            compact('startPeriod', 'endPeriod', 'paymentsTotal',
                'outgoingsTotal', 'incomesTotal', 'budgetsTotal', 'latestsOutgoings'));
    }
}
