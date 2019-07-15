<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

/**
 * General Function related to API Call
 */
trait APIHelper
{
    public function paginateResult(Request $request)
    {
        // initialize variables
        $dataPerPage = $offset = 0;
        $page = 1;

        if ($request->has('count_per_page') && $request->count_per_page != '' && is_numeric($request->count_per_page)) {
            $dataPerPage = $request->count_per_page;
        } else {
            $dataPerPage = 5;
        }

        if ($request->has('page') && $request->page != '' && is_numeric($request->page)) {
            $page = $request->page;
            $offset = ($page - 1) * $dataPerPage;
        } else {
            $offset = ($page - 1) * $dataPerPage;
        }

        return [
            'dataPerPage' => $dataPerPage,
            'page' => $page,
            'offset' => $offset
        ];
    }
}
