<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
{
    public function getTotalBooks()
    {
        return response()->json(Book::count(), 201);
    }

    public function getTotalUsers()
    {
        return response()->json(User::count(), 201);
    }
}
