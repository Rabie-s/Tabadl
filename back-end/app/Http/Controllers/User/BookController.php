<?php

namespace App\Http\Controllers\User;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the search query, status, and book level from the request
        $status = $request->query('status');
        $book_level = $request->query('book_level');
        $search = $request->query('search');

        // Start building the query for books
        $query = Book::query();

        // Filter by status if provided
        if ($status !== null) {
            $query->where('status', $status);
        }

        // Filter by book level if provided
        if ($book_level !== null) {
            $query->where('book_level', $book_level);
        }

        // Filter by search query if provided (search by title)
        if ($search !== null) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and fetch books not marked as done
        $books = $query->where('done', 0)->latest()->paginate(10);

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        // Check if a file was uploaded
        if ($request->hasFile('image_path')) {

            try {
                $image = storeImage($request->file('image_path'));
            } catch (\Exception $e) {
                // Handle file upload exception, e.g., log the error
                // You may also throw an exception or return an error response
                return response()->json(['error' => 'Failed to upload image.'], 500);
            }
            // $mainImageName now contains the filename of the uploaded image
        } else {
            // Handle case where 'main_image' file is not uploaded
            return response()->json(['error' => 'Main image is required.'], 400);
        }

        try {
            // Create a new book record associated with the authenticated user
            $authenticatedUser = auth()->guard('user-api')->user();
            $authenticatedUser->books()->create([
                'title' => $request->title,
                'book_level' => $request->book_level,
                'image_path' => $image ?? null, // Optional image path
                'status' => $request->status,
                'description' => $request->description,
                'active' => $request->active ?? true, // Set default active status
                'done' => $request->done ?? false, // Set default done status
            ]);
            return response()->json('book successfully added', 200);
        } catch (ModelNotFoundException $e) {
            return response()->json('book not inserted', 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Find the book by ID with the associated user
            $book = Book::with('user')->where('id', $id)->get();
            return response()->json($book, 200);
        } catch (ModelNotFoundException $e) {
            // Return error response if book with the given ID is not found
            return response()->json(['error' => 'Book not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try {
            // Get the authenticated user
            $authenticatedUser = auth()->guard('user-api')->user();

            // Find the book associated with the authenticated user by ID
            $book = $authenticatedUser->books()->findOrFail($id);

            // Delete the book record
            $book->delete();

            // Delete associated image from storage
            deleteImage($book->image_path);

            // Return success message
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to delete book'], 500);
        } 
    }

    public function completed(Request $request)
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->guard('user-api')->user();

            // Find the book associated with the authenticated user by ID
            $book = $authenticatedUser->books()->where('id', $request->id)->first();

            // Update the 'done' status of the book
            $book->done = $request->done;
            $book->save();

            // Return success response
            return response()->json(['success' => 'Book marked as completed'], 200);
        } catch (ModelNotFoundException $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to complete book'], 500);
        }
    }

    public function showUserBooks()
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->guard('user-api')->user();

            // Retrieve all books associated with the authenticated user that are not marked as done
            $books = $authenticatedUser->books()->where('done', 0)->latest()->get();

            // Return the list of books
            return response()->json($books, 200);
        } catch (ModelNotFoundException $e) {
            // Return error response if user's books are not found
            return response()->json(['error' => 'Failed to fetch user books'], 500);
        }
    }
}
