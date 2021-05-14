<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Fetch items from database
    public function index()
    {
        // Authenticated user
        $user = auth()->user();

        // Get Todo items of the user
        $items = TodoItem::latest()->where('user_id', $user->id)->get();

        return response([
            'success' => true,
            'items' => $items,
        ]);

    }

    // Add items to database
    public function create(Request $request)
    {
        // Validating request
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        // Create item in the database
        $item = $request->user()
            ->items()
            ->create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

        return response([
            'success' => true,
            'item' => $item,
        ]);
    }
}