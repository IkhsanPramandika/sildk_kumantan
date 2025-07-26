<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Jobs\ImportExcelJob;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Resident::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('rt')) {
            $query->where('rt', $request->input('rt'));
        }

        if ($request->has('rw')) {
            $query->where('rw', $request->input('rw'));
        }

        if ($request->has('life_status')) {
            $query->where('life_status', $request->input('life_status'));
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->input('gender'));
        }
        //Sort logic
        if ($request->has('sort_name')) {
            $direction = $request->input('sort_name') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('full_name', $direction);
        }

        if ($request->filled('occupation')) {
    $query->whereRaw('LOWER(occupation) = ?', [strtolower($request->input('occupation'))]);
}


        $residents = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Residents/Index', [
            'residents' => $residents,
            'filters' => $request->only(['search', 'rt', 'rw', 'life_status', 'gender', 'sort_name']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Residents/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:residents',
            'family_card_number' => 'required|string|size:16',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|size:3',
            'rw' => 'required|string|size:3',
            'hamlet' => 'nullable|string|max:50',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|in:islam,christian,catholic,hindu,buddhist,confucian,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'occupation' => 'nullable|string|max:100',
            'last_education' => 'required|in:none,elementary,junior_high,senior_high,d1,d2,d3,s1,s2,s3',
            'blood_type' => 'required|in:A,B,AB,O,Unknown',
            'citizenship' => 'required|in:wni,wna',
            'life_status' => 'required|in:alive,deceased',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'family_relationship_status' => 'nullable|string|max:50',
            'disability_type' => 'nullable|string|max:50',
        ]);

        Resident::create($validated);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        return Inertia::render('Admin/Residents/Show', [
            'resident' => $resident
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        return Inertia::render('Admin/Residents/Edit', [
            'resident' => $resident
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:residents,nik,' . $resident->id,
            'family_card_number' => 'required|string|size:16',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|size:3',
            'rw' => 'required|string|size:3',
            'hamlet' => 'nullable|string|max:50',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|in:islam,christian,catholic,hindu,buddhist,confucian,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'occupation' => 'nullable|string|max:100',
            'last_education' => 'required|in:none,elementary,junior_high,senior_high,d1,d2,d3,s1,s2,s3',
            'blood_type' => 'required|in:A,B,AB,O,Unknown',
            'citizenship' => 'required|in:wni,wna',
            'life_status' => 'required|in:alive,deceased',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'family_relationship_status' => 'nullable|string|max:50',
            'disability_type' => 'nullable|string|max:50',
        ]);

        $resident->update($validated);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('admin.residents.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Import residents from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ]);

        $file = $request->file('file');
        $path = $file->store('imports');

        ImportExcelJob::dispatch($path);

        return back()->with('success', 'File has been uploaded and is being processed. You will be notified once the import is complete.');
    }
}
