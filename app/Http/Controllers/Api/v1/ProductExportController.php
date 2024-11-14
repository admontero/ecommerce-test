<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\ExportProductAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ExportProductAction $exportProductAction): BinaryFileResponse|JsonResponse
    {
        $path = $exportProductAction->handle();

        if (! $path) {
            return $this->error('The export was not generated correctly');
        }

        return response()->download($path, 'products.csv');
    }
}
