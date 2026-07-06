<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(Request $request): View
    {
        $log = AuditLog::with('pengguna')
            ->when($request->modul, fn ($q, $m) => $q->where('modul', $m))
            ->when($request->tanggal, fn ($q, $t) => $q->whereDate('created_at', $t))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        $modulList = AuditLog::select('modul')->distinct()->pluck('modul');

        return view('admin.audit.index', compact('log', 'modulList'));
    }
}
