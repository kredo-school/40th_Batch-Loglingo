<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bookmarkable_id' => 'required|integer',
            'bookmarkable_type' => 'required|string', // this will accept Models ex.) "App\Models\Post"
        ]);

        // avoid duplicating bookmarks
        $exists = Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $validated['bookmarkable_id'])
            ->where('bookmarkable_type', $validated['bookmarkable_type'])
            ->first();

        if ($exists) {
            $exists->delete();
            $status = 'removed';
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'bookmarkable_id' => $validated['bookmarkable_id'],
                'bookmarkable_type' => $validated['bookmarkable_type'],
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status, // 'added' or 'removed'
            'isBookmarked' => ($status === 'added')
        ]);
    }
}
