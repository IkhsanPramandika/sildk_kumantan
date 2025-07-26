<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Complaint::with('resident')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('complaint_number', 'like', "%{$search}%")
                        ->orWhereHas('resident', function ($q) use ($search) {
                            $q->where('full_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->latest();

        $complaints = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Complaints/Index', [
            'complaints' => $complaints,
            'filters' => $request->only(['search', 'status', 'category'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load('resident');
        return Inertia::render('Admin/Complaints/Show', [
            'complaint' => $complaint
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function respond(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,received,in_progress,completed,rejected',
            'response' => 'required|string',
        ]);

        $validated['response_date'] = now();

        $complaint->update($validated);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Respon pengaduan berhasil diperbarui.');
    }
}
