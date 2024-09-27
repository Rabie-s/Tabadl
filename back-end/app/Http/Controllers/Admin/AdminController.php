<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Book;
use App\Models\User;
use App\Models\Admin;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function fetchBooksWithUsers()
    {
        try {
            // Retrieve the book with the associated user
            $BooksWithUsers = Book::select('id', 'user_id', 'title', 'created_at')->with('user:id,name')->latest()->paginate(8);
            return response()->json($BooksWithUsers, 200);
        } catch (ModelNotFoundException $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed fetch books:', $e], 500);
        }
    }

    public function fetchUsers()
    {
        try {
            // Retrieve the book with the associated user
            $users = User::select('id', 'name', 'email', 'phone_number', 'created_at')->latest()->paginate(8);
            return response()->json($users, 200);
        } catch (ModelNotFoundException $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to fetch users:', $e], 500);
        }
    }

    public function deleteBook(string $id)
    {
        try {
            //get book data
            $book = Book::findOrFail($id);
            //delete book from database
            $book->delete();
            //delete image from public path
            if (File::exists(public_path('images/' . $book->image_path))) {
                File::delete(public_path('images/' . $book->image_path));
            }
            //return response
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed delete book'], 404);
        }
    }

    public function fetchAdmins(){
        try {
            // Retrieve all admins
            $admins = Admin::latest()->paginate(8);
            return response()->json($admins, 200);
        } catch (ModelNotFoundException $e) {
            // Handle any exceptions and return an error response
            return response()->json(['error' => 'Failed to fetch admins.'], 500);
        }
    }

    public function deleteAdmin(string $id){
        try {
            // Find admin by ID and delete
            $admin = Admin::findOrFail($id);
            $admin->delete();
            
            // Return success message upon successful deletion
            return response()->json(['message' => 'Admin deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // response if admin is not found or deletion fails
            return response()->json(['error' => 'Admin not found or could not be deleted.'], 404);
        }
    }
}
