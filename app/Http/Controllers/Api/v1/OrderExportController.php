<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\ExportOrderAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ExportOrderAction $exportOrderAction): BinaryFileResponse|JsonResponse
    {
        $path = $exportOrderAction->handle();

        if (! $path) {
            return $this->error('The export was not generated correctly');
        }

        return response()->download($path, 'orders.csv');
    }
}
