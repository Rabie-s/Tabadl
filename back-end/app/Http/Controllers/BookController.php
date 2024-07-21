<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{

    /**
     * Display a paginated list of books based on filters.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
     * Store a newly created book resource in storage.
     *
     * @param  StoreBookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        try {
            // Store the uploaded image, if provided
            if ($request->file('image_path')) {
                $image = storeImage($request->file('image_path'));
            }

            // Create a new book record associated with the authenticated user
            $authenticatedUser = auth()->user();
            $authenticatedUser->books()->create([
                'title' => $request->title,
                'book_level' => $request->book_level,
                'image_path' => $image ?? null, // Optional image path
                'status' => $request->status,
                'description' => $request->description,
                'active' => $request->active ?? true, // Set default active status
                'done' => $request->done ?? false, // Set default done status
            ]);

            // Return success response
            return response()->json(['success' => 'Book created successfully'], 201);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to create book'], 409);
        }
    }

    /**
     * Display the specified book resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            // Find the book by ID with the associated user
            $book = Book::with('user')->where('id', $id)->get();
            return response()->json($book, 201);
        } catch (ModelNotFoundException $e) {
            // Return error response if book with the given ID is not found
            return response()->json(['error' => 'Book not found'], 500);
        }
    }

    /**
     * Update the specified book resource in storage.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->user();

            // Find the book associated with the authenticated user by ID
            $book = $authenticatedUser->books()->findOrFail($id);

            // Update the book attributes with the provided data
            $book->update($request->only([
                'title',
                'image_path',
                'status',
                'description',
                'active',
                'done',
            ]));

            // Return success response
            return response()->json(['success' => 'Book updated successfully'], 201);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to update book'], 500);
        }
    }

    /**
     * Remove the specified book resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->user();

            // Find the book associated with the authenticated user by ID
            $book = $authenticatedUser->books()->findOrFail($id);

            // Delete the book record
            $book->delete();

            // Delete associated image from storage
            deleteImage($book->image_path);

            // Return success message
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to delete book'], 500);
        }
    }

    /**
     * Mark the specified book as completed.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function completed(Request $request)
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->user();

            // Find the book associated with the authenticated user by ID
            $book = $authenticatedUser->books()->where('id', $request->id)->first();

            // Update the 'done' status of the book
            $book->done = $request->done;
            $book->save();

            // Return success response
            return response()->json(['success' => 'Book marked as completed'], 200);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Failed to complete book'], 500);
        }
    }

    /**
     * Display all books of the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserBooks()
    {
        try {
            // Get the authenticated user
            $authenticatedUser = auth()->user();

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
