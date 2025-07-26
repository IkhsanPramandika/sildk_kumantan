<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ComplaintController extends Controller
{
    public function create()
    {
        return Inertia::render('Guest/Complaints/Create');
    }

    public function check()
    {
        return Inertia::render('Guest/Complaints/Check');
    }

    public function checkStatus(Request $request)
    {
        $validated = $request->validate([
            'complaint_number' => 'required|string|exists:complaints,complaint_number'
        ]);

        $complaint = Complaint::with('resident')
            ->where('complaint_number', $validated['complaint_number'])
            ->first();

        return Inertia::render('Guest/Complaints/Show', [
            'complaint' => $complaint
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|exists:residents,nik',
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:infrastructure,service,social,economy,other',
            'description' => 'required|string',
        ]);

        // Get resident by NIK
        $resident = Resident::where('nik', $validated['nik'])->first();

        if (!$resident) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar dalam database penduduk.'
            ]);
        }

        $complaint = Complaint::create([
            'complaint_number' => 'COMP-' . date('Ymd') . '-' . Str::random(4),
            'resident_id' => $resident->id,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'status' => 'received',
        ]);

        return redirect()->route('complaints.success', [
            'complaint_number' => $complaint->complaint_number
        ]);
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('resident');
        return Inertia::render('Guest/Complaints/Show', [
            'complaint' => $complaint
        ]);
    }

    public function success(Request $request)
    {
        $complaint = Complaint::where('complaint_number', $request->complaint_number)->firstOrFail();
        return Inertia::render('Guest/Complaints/Success', [
            'complaintNumber' => $complaint->complaint_number
        ]);
    }
}
