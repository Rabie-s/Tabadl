<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
{
    /**
     * Get the total count of books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalBooks(): JsonResponse
    {
        return response()->json(Book::count(), 201);
    }

    /**
     * Get the total count of users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalUsers(): JsonResponse
    {
        return response()->json(User::count(), 201);
    }
}
