<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the search query and status from the request
        $status = $request->query('status');
        $search = $request->query('search');

        // Start building the query with pagination
        $query = Book::query();

        // If status is provided, filter by status
        if ($status !== null) {
            $query->where('status', $status);
        }

        // If search query is provided, filter by title or other relevant fields
        if ($search !== null) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $books = $query->where('done', 0)->latest()->paginate(10);

        // Return the paginated list of books as a collection of BookResource
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        // Generate a random filename and move the uploaded image to the desired location
        $getFileExtension = $request->file('image_path')->getClientOriginalExtension(); //get extension of file
        $newFileName = (string)rand() . '.' . $getFileExtension; //merge random string and file extension
        $request->file('image_path')->move('images', $newFileName);

        // Create a new book instance and save it
        $book = new Book();
        $book->title = $request->title;
        $book->image_path = $newFileName;
        $book->status = $request->status;
        $book->description = $request->description;
        $book->user_id = $request->user_id;
        $book->save();

        // Return a success response with status code 201
        return response()->json(['success' => 'Created successful'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            // Retrieve the book with the associated user
            $book = Book::with('user')->where('id', $id)->get();
            return response()->json($book, 201);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to show book'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // Find the book belonging to the authenticated user by ID
            $book = $user->books()->findOrFail($id);

            // Update the book with the provided data
            $book->update($request->only([
                'title',
                'image_path',
                'status',
                'description',
                'active',
                'done',
            ]));

            // Return a success response with status code 201
            return response()->json(['success' => 'Updated successful'], 201);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to update book'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // Find the book belonging to the authenticated user by ID
            $book = $user->books()->findOrFail($id);

            // Delete the found book
            $book->delete();

            // Return a success message if the book is deleted successfully
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to delete book'], 500);
        }
    }

    /**
     * Mark the specified resource as completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completed(Request $request)
    {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // Find the book belonging to the authenticated user by ID and update its completion status
            $book = $user->books()->where('id', $request->id)->first(); // Use first() instead of get()
            $book->done = $request->done;
            $book->save();

            // Return a success response with status code 200
            return response()->json(['success' => 'Book marked as completed'], 200);
        } catch (\Exception $e) {
            // Return an error response with status code 500 if an exception occurs
            return response()->json(['error' => 'Failed to complete book'], 500);
        }
    }

    /**
     * Display a listing of the authenticated user's books.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserBooks()
    {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // Retrieve and return the books belonging to the authenticated user that are not yet completed
            $books = $user->books()->where('done', 0)->latest()->get();
            return response()->json($books,200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user book'], 500);
        }
    }
}
