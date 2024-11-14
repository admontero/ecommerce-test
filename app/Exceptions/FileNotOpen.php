<?php

namespace App\Exceptions;

use App\Traits\HasResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FileNotOpen extends Exception
{
    use HasResponses;

    public function render(): JsonResponse
    {
        return $this->error($this->getMessage(), Response::HTTP_CONFLICT);
    }
}
