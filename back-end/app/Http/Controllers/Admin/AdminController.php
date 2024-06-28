<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function getBooksWithUsers()
    {
        try {
            // Retrieve the book with the associated user
            $BooksWithUsers = Book::select('id', 'user_id', 'title', 'created_at')->with('user:id,name')->latest()->paginate(8);
            return response()->json($BooksWithUsers, 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed fetch books:', $e], 500);
        }
    }

    public function getUsers()
    {
        try {
            // Retrieve the book with the associated user
            $users = User::select('id','name','email','created_at')->latest()->paginate(8);
            return response()->json($users, 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to fetch users:', $e], 500);
        }
    }
}
