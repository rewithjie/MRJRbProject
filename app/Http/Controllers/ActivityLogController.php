<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // Filter by action
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        // Filter by entity type
        if ($request->filled('entity_type')) {
            $query->byEntity($request->entity_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->recent()->paginate(25);
        $statuses = ['success', 'error', 'warning'];
        $entityTypes = ActivityLog::query()->distinct('entity_type')->pluck('entity_type');

        return view('activity-logs.index', compact('logs', 'statuses', 'entityTypes'));
    }

    /**
     * Display a specific activity log.
     */
    public function show(string $id)
    {
        $log = ActivityLog::findOrFail($id);
        return view('activity-logs.show', compact('log'));
    }

    /**
     * Clear old logs (older than 30 days).
     */
    public function clearOldLogs()
    {
        $deleted = ActivityLog::where('created_at', '<', now()->subDays(30))->delete();

        return redirect()->route('logs.index')->with('success', "Cleared $deleted old activity logs.");
    }

    /**
     * Export logs as CSV.
     */
    public function export(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->filled('action')) {
            $query->byAction($request->action);
        }
        if ($request->filled('entity_type')) {
            $query->byEntity($request->entity_type);
        }
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $logs = $query->recent()->get();

        $filename = 'activity_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Action', 'Entity Type', 'Entity ID', 'User Email', 'Message', 'IP Address', 'Status', 'Created At']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->action,
                    $log->entity_type,
                    $log->entity_id,
                    $log->user_email,
                    $log->message,
                    $log->ip_address,
                    $log->status,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
