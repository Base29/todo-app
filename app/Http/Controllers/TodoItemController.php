<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Carbon\Carbon;
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
        $items = TodoItem::latest()->where('user_id', $user->id)->paginate(10);

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
            ->create($request->all());

        return response([
            'success' => true,
            'item' => $item,
        ]);
    }

    // Update Todo Item
    public function update(Request $request, $id)
    {

        // Authenticated user
        $user = auth()->user();

        // Check if item exists
        $item = TodoItem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'message' => 'Item not found',
            ]);
        }

        if (!$item->ownedBy($user)) {
            return response([
                'success' => false,
                'message' => 'You are not allowed to update or edit this item',
            ]);
        }

        // Updating item
        $item->update($request->only('title', 'description'));

        return response([
            'success' => true,
            'item' => $item,
        ]);
    }

    // Delete Todo Item
    public function delete($id)
    {
        // Authenticated user
        $user = auth()->user();

        // Check if item exists
        $item = TodoItem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'message' => 'Item not found',
            ]);
        }

        if (!$item->ownedBy($user)) {
            return response([
                'success' => false,
                'message' => 'You are not allowed to delete this item',
            ]);
        }

        // Deleting item
        $item->delete();

        return response([
            'success' => true,
            'message' => 'Item deleted successfully',
        ]);
    }

    public function singleItem($id)
    {
        // Authenticated user
        $user = auth()->user();

        // Check if item exists
        $item = TodoItem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'message' => 'Item not found',
            ]);
        }

        if (!$item->ownedBy($user)) {
            return response([
                'success' => false,
                'message' => 'You are not allowed to delete this item',
            ]);
        }

        return response([
            'success' => true,
            'item' => $item,
        ]);
    }

    public function done(Request $request, $id)
    {

        // Authenticated user
        $user = auth()->user();

        // Check if item exists
        $item = TodoItem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'message' => 'Item not found',
            ]);
        }

        if (!$item->ownedBy($user)) {
            return response([
                'success' => false,
                'message' => 'You are not allowed to delete this item',
            ]);
        }

        // Updating completed and completed_at fields
        $item->update(['completed' => $request->done, 'completed_at' => Carbon::now()]);

        return response([
            'success' => true,
            'item' => $item,
        ]);
    }
}