<?php

namespace App\Http\Controllers\Api;

use App\Services\OneiromancyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DreamController extends Controller
{
    protected $dream;

    public function __construct(OneiromancyService $service)
    {
        $this->dream = $service;
    }

    public function index(Request $request)
    {
      return  $this->dream->query($request->input('key'));
    }
}
