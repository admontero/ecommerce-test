<?php

namespace App\Exceptions;

use App\Traits\HasResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions as BaseExceptions;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler
{
    use HasResponses;

    public function __invoke(BaseExceptions $exceptions): BaseExceptions
    {
        $this->renderUnauthenticated($exceptions);
        $this->renderUnauthorized($exceptions);
        $this->renderNotFound($exceptions);
        $this->renderValidation($exceptions);
        $this->renderGeneric($exceptions);

        return $exceptions;
    }

    protected function renderUnauthenticated(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (AuthenticationException $e) => $this->error(
                message: 'Unauthenticated',
                code: Response::HTTP_UNAUTHORIZED,
                errors: []
            )
        );
    }

    protected function renderUnauthorized(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (AuthorizationException $e) => $this->error(
                message: 'Unauthorized',
                code: Response::HTTP_FORBIDDEN,
                errors: []
            )
        );
    }

    protected function renderNotFound(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (NotFoundHttpException|ModelNotFoundException $e) => $this->error(
                message: 'The resource cannot be found',
                code: Response::HTTP_NOT_FOUND,
                errors: []
            )
        );
    }

    protected function renderValidation(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(function (ValidationException $e) {
            foreach ($e->errors() as $key => $value) {
                foreach ($value as $message) {
                    $errors[] = [
                        'status' => 422,
                        'message' => $message,
                        'source' => $key
                    ];
                }
            }

            return $this->error(
                code: Response::HTTP_UNPROCESSABLE_ENTITY,
                errors: $errors,
            );
        });
    }

    protected function renderGeneric(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (\Throwable $e) => $this->error(
                message: 'Server error',
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                errors: []
            )
        );
    }
}

