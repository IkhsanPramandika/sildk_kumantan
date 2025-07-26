<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Guest/Contact', [
            'villageProfile' => VillageProfile::first() ?? [],
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required|accepted',
        ], [
            'privacy.accepted' => 'Anda harus menyetujui kebijakan privasi.',
        ]);
        
        try {
            // Get village profile for admin email
            $villageProfile = VillageProfile::first();
            $adminEmail = $villageProfile->email ?? config('mail.from.address');
            
            // Send email to admin
            Mail::to($adminEmail)->send(new ContactFormMail($validated));
            
            // Log the contact form submission
            Log::info('Contact form submitted', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
            ]);
            
            return back()->with('success', 'Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Error sending contact form email: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.']);
        }
    }
}
