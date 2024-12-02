<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    // Create Book
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Create Book
        $book = Buku::create([
            'title' => $request->title,
            'author' => $request->author,
            'published_at' => $request->published_at
        ]);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    // Read All Books
    public function index()
    {
        $books = Buku::all();

        return response()->json([
            'data' => $books
        ]);
    }

    // Read Single Book
    public function show($id)
    {
        $book = Buku::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'data' => $book
        ]);
    }

    // Update Book
    public function update(Request $request, $id)
    {
        $book = Buku::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        // Validation (optional fields)
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'published_at' => 'sometimes|required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Update Book
        if ($request->has('title')) {
            $book->title = $request->title;
        }
        if ($request->has('author')) {
            $book->author = $request->author;
        }
        if ($request->has('published_at')) {
            $book->published_at = $request->published_at;
        }

        $book->save();

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    // Delete Book
    public function destroy($id)
    {
        $book = Buku::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}