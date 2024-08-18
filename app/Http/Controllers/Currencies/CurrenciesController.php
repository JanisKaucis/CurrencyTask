<?php
namespace App\Http\Controllers\Currencies;

use Inertia\Inertia;

class CurrenciesController
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $title = 'currency';
        return Inertia::render('Currencies/CurrenciesIndex', [
            'title' => $title
        ]);
    }
}
