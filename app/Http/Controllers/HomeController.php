<?php

namespace App\Http\Controllers;

use App\Models\HomepageSection;
use App\Models\ColivingRoom;
use App\Models\HeroSlider;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Galleries;
use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get all CMS content from admin panel
        $heroSliders = HeroSlider::active()->orderBy('sort_order')->get();
        $sections = HomepageSection::all();
        $features = Feature::active()->orderBy('sort_order')->get();
        $featuredRooms = ColivingRoom::where('is_featured', true)
            ->where('is_available', true)
            ->take(6)
            ->get();
        $testimonials = Testimonial::featured()->orderBy('sort_order')->take(6)->get();
        $galleries = Galleries::featured()->orderBy('sort_order')->take(8)->get();
        $availableRooms = ColivingRoom::where('is_available', true)
            ->orderBy('price_per_night')
            ->take(6)
            ->get();
        // Stats
        $stats = [
            'available_rooms' => ColivingRoom::where('is_available', true)->count(),
            'total_residents' => SiteSetting::get('total_residents', '500+'),
            'rating' => SiteSetting::get('average_rating', '4.9'),
            'events_hosted' => SiteSetting::get('events_hosted', '200+'),
        ];
        return view('landing.home', compact(
            'heroSliders',
            'sections',
            'features',
            'featuredRooms',
            'testimonials',
            'galleries',
            'availableRooms',
            'stats'
        ));
    }

    public function about()
    {
        $galleries = Galleries::orderBy('sort_order')->get();
        $features = Feature::active()->orderBy('sort_order')->get();

        return view('landing.about', compact('galleries', 'features'));
    }

    public function contact()
    {
        $faqs = Faq::active()->orderBy('sort_order')->get();

        return view('landing.contact', compact('faqs'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);
        $validated['name'] = trim(strip_tags((string) $validated['name']));
        $validated['subject'] = trim(strip_tags((string) $validated['subject']));
        $validated['message'] = trim(strip_tags((string) $validated['message']));
        // phone normalize (optional)
        if (!empty($validated['phone'])) {
            $validated['phone'] = preg_replace('/[^0-9+\-\s()]/', '', (string) $validated['phone']);
            $validated['phone'] = mb_substr($validated['phone'], 0, 20);
        }
        // email udah tervalidasi, cukup trim+lower
        $validated['email'] = strtolower(trim((string) $validated['email']));
        ContactMessage::create($validated);
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
