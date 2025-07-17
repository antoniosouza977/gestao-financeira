<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Validators\BaseValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    protected SaveModelAction $saveModelAction;

    protected BaseValidator $validator;

    protected ?string $indexRoute = null;

    public function baseStore(Model $model, array $data): RedirectResponse
    {
        return $this->save($model, $data, ValidationType::CREATE);
    }

    public function baseUpdate(Model $model, array $data): RedirectResponse
    {
        if ($model->user_id !== auth()->id()) {
            abort(403);
        }

        return $this->save($model, $data, ValidationType::UPDATE);
    }

    public function save(Model $model, array $data, ValidationType $validationType): RedirectResponse
    {
        try {
            $this->saveModelAction
                ->setModel($model)
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData($validationType)
                ->execute();

            if (is_null($this->indexRoute)) {
                return redirect()->back();
            }

            return redirect()->route($this->indexRoute);
        } catch (ValidationException $validationException) {
            return redirect()->back()
                ->withErrors($validationException->errors())
                ->withInput();
        }
    }
}
