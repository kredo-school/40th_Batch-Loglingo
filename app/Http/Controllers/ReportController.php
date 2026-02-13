<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
     /**
     * 通報する
     */
    public function store(Request $request)
    {
        $request->validate([
            'reportable_id'   => 'required|integer',
            'reportable_type' => 'required|string',
        ]);

        Report::firstOrCreate([
        'user_id'         => auth()->id(),
        'reportable_id'   => $request->reportable_id,
        'reportable_type' => $request->reportable_type,
    ]);

    return back();

        // すでに通報済みかチェック
        $alreadyReported = Report::where('user_id', auth()->id())
            ->where('reportable_id', $request->reportable_id)
            ->where('reportable_type', $request->reportable_type)
            ->exists();

        if ($alreadyReported) {
            return back()->with('error', 'You have already reported');
        }

        Report::create([
            'user_id'         => auth()->id(),
            'reportable_id'   => $request->reportable_id,
            'reportable_type' => $request->reportable_type,
        ]);

        return back()->with('success', 'reported');
    }


}
