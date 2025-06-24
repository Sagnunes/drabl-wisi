<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\User;
use App\Services\DigitalCollectionService;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class DigitalCollectionController extends Controller
{
    public function __construct(
        private readonly DigitalCollectionService $digitalCollectionService,
    )
    {
    }

    public function index()
    {
        return Inertia::render('digital-collection/Index', ['fundWithDigitalObject' => $this->digitalCollectionService->getDigitalCollectionFunds()]);

    }

    public function show(Fund $fund){

        $search = Request::input('search');

        $fundResourcesPagination = $this->digitalCollectionService->getDigitalObjectsByFund($fund, $search);

        return Inertia::render('digital-collection/Show', [
            'fund' => $fund,
            'collections' => Inertia::merge($fundResourcesPagination->items()),
            'pagination' => Arr::except($fundResourcesPagination->toArray(), ['data'])
        ]);
    }

    public function csv()
    {
       $data = Request::all();

       dd($data);
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=colecao.csv",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, ['Fundo', 'Número Inventario', 'Titulo']);

            // Add rows
            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
