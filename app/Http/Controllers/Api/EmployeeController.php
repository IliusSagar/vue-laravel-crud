<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::get());
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        Employee::create($validated);

        return response()->json('success');

    }
}
