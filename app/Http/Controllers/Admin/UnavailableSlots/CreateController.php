<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Admin/UnavailableSlots/Create');
    }
}
