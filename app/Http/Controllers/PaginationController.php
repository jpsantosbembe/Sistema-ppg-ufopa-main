<?php

namespace App\Http\Controllers;

use App\Service\PaginationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PaginationController extends Controller
{
    public function __construct(
        private PaginationService $paginationService
    ){}

    public function people(Request $request): Response
    {
        return response($this->paginationService->people($request));
    }

    public function upload():Response
    {
        return response($this->paginationService->upload());
    }

    public function program(Request $request):Response
    {
        return response($this->paginationService->program($request));
    }

    public function project(Request $request):Response
    {
        return response($this->paginationService->project($request));
    }

    public function discipline(Request $request):Response
    {
        return response($this->paginationService->discipline($request));
    }

    public function production(Request $request):Response
    {
        return response($this->paginationService->production($request));
    }

    public function user(Request $request):Response
    {
        return response($this->paginationService->user($request));
    }

    public function oriented(Request $request):Response
    {
        return response($this->paginationService->oriented($request));
    }
}
