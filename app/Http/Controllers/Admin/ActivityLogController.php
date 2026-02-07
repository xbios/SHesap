<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityLogRepository;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected $repository;

    public function __construct(ActivityLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'action', 'model_type']);
        $logs = $this->repository->getFiltered($filters);

        return view('admin.logs.index', compact('logs', 'filters'));
    }
}
