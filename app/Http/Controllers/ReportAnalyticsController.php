<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportAnalyticsController extends Controller
{

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Maintenance', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('Maintenance', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $reports = Report::latest()->get();
        $this->authorizeRead();

        return view('Pages/reports', compact('reports'));
    }

    public function download($id)
    {
        $report = Report::findOrFail($id);

        if (!$report->file_path || !Storage::exists($report->file_path)) {
            return abort(404, "Report file not found.");
        }

        return Storage::download($report->file_path);
    }
}
