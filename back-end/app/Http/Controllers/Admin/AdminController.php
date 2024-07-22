<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Retrieve books with associated users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooksWithUsers(): JsonResponse
    {
        try {
            // Retrieve the books with the associated user
            $BooksWithUsers = Book::select('id', 'user_id', 'title', 'created_at')->with('user:id,name')->latest()->paginate(8);
            return response()->json($BooksWithUsers, 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed fetch books:', $e], 500);
        }
    }

    /**
     * Retrieve users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        try {
            // Retrieve the users
            $users = User::select('id', 'name', 'email', 'phone_number', 'created_at')->latest()->paginate(8);
            return response()->json($users, 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to fetch users:', $e], 500);
        }
    }

    /**
     * Delete a book by ID.
     *
     * @param string $id The ID of the book to delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBook(string $id): JsonResponse
    {
        try {
            // Get book data
            $book = Book::findOrFail($id);
            // Delete book from database
            $book->delete();
            // Delete image from public path
            if (File::exists(public_path('images/' . $book->image_path))) {
                File::delete(public_path('images/' . $book->image_path));
            }
            // Return success message
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to delete book:', $e], 500);
        }
    }
}
