<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\TransactionPromise;
use App\Services\CategoriesService;
use App\Validators\BaseValidator;
use App\Validators\TransactionPromiseValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

abstract class TransactionPromisesController extends Controller
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected CategoriesService $categoriesService;
    protected string $indexRoute = '';
    protected string $componentPath;
    protected int $type;

    public function __construct
    (
        SaveModelAction             $saveModelAction,
        TransactionPromiseValidator $validator,
        CategoriesService           $categoriesService,
    )
    {
        $this->saveModelAction = $saveModelAction;
        $this->validator = $validator;
        $this->categoriesService = $categoriesService;
    }

    public function index(): Response|ResponseFactory
    {
        $promises = TransactionPromise::query()
            ->where('user_id', auth()->id())
            ->where('type', $this->type)
            ->paginate(10);

        return inertia($this->componentPath . '/Index', compact("promises"));
    }

    public function create(): Response|ResponseFactory
    {
        $categories = $this->categoriesService->getAll($this->type);

        return inertia($this->componentPath . '/Form', compact("categories"));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['category_id', 'value', 'description', 'type', 'period_type', 'period_value']);
        $data['type'] = $this->type;

        return $this->baseStore(new TransactionPromise(), $data);
    }

    public function edit(TransactionPromise $promise): Response|ResponseFactory
    {
        $categories = $this->categoriesService->getAll($this->type);

        return inertia($this->componentPath . '/Form', compact('promise', 'categories'));
    }

    public function update(Request $request, TransactionPromise $promise): RedirectResponse
    {
        $data = $request->only(['category_id', 'value', 'description', 'type', 'period_type', 'period_value']);
        $data['type'] = $this->type;
        return $this->baseUpdate($promise, $data);
    }

    public function destroy(TransactionPromise $promise): RedirectResponse
    {
        $promise->delete();

        return redirect()->route($this->indexRoute);
    }
}
