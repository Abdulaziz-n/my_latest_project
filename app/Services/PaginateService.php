<?php

namespace App\Services;

use App\Http\Requests\Paginate\PaginationRequest;

class PaginateService
{
    public function perPage()
    {
        if (request()->get('perPage') > 100) {
            return 20;
        }
        return request()->get('perPage') ?? 20;
    }
}
