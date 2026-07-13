<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\ColivingRoom;
use App\Models\ColivingBooking;
use App\Models\CafeEventBooking;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Galleries;
use App\Models\HeroSlider;
use App\Models\HomepageSection;
use App\Models\SiteSetting;
use App\Models\Testimonial;

class AllContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        ColivingRoom::truncate();
        ColivingBooking::truncate();
        CafeEventBooking::truncate();
        SiteSetting::truncate();
        HeroSlider::truncate();
        Feature::truncate();
        Galleries::truncate();
        Testimonial::truncate();
        Faq::truncate();
        ContactMessage::truncate();
        HomepageSection::truncate();

        // Site Settings
        SiteSetting::set('total_residents', '500+', 'general', 'general');
        SiteSetting::set('average_rating', '4.9', 'general', 'general');
        SiteSetting::set('events_hosted', '200+', 'general', 'general');
        SiteSetting::set('site_name', 'FountainHead Cafe & Co-living', 'general', 'general');
        SiteSetting::set('site_tagline', 'Where Coffee Meets Community', 'general', 'general');
        SiteSetting::set('site_logo', 'settings/JrCQs7AjGmruvQWwZFvorCxzTQyaRt32U7stBe8h.png', 'general', 'general');
        SiteSetting::set('site_favicon', 'settings/JFBc2tGxo3AerQ9W3hTfKwaSFdHYB5bTvYI8ibca.ico', 'general', 'general');
        SiteSetting::set('working_hours', 'Monday - Sunday: 9am - 9pm', 'general', 'general');
        SiteSetting::set('contact_email', 'hello@fountainhead.id', 'contact', 'contact');
        SiteSetting::set('contact_phone', '+6281511730175', 'contact', 'contact');
        SiteSetting::set('address', "RT.2/RW.10, North Meruya, Kembangan,\nWest Jakarta City, Jakarta 11620", 'contact', 'contact');
        SiteSetting::set('facebook_url', '', 'social', 'social');
        SiteSetting::set('instagram_url', 'https://www.instagram.com/fountainhead.co', 'social', 'social');
        SiteSetting::set('twitter_url', '', 'social', 'social');
        SiteSetting::set('tiktok_cafe', 'https://www.tiktok.com/@fountainheadcafe', 'social', 'social');
        SiteSetting::set('tiktok_coliving', 'https://www.tiktok.com/@fountainhead.coliving', 'social', 'social');
        // Hero Sliders
        HeroSlider::create([
            'title' => 'Your Perfect Space for Living & Creating',
            'subtitle' => 'Experience modern coliving and vibrant cafe culture in the heart of Jakarta. Work, live, and connect.',
            'image' => 'hero-sliders/p9snOonQCc9nHaC8dyd5w3ZrK1Nv4WDJxN0UoAMX.jpg',
            'cta_text' => 'Explore Rooms',
            'cta_link' => 'https://fountainhead-app.test/coliving',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HeroSlider::create([
            'title' => 'Host Your Next Event With Us',
            'subtitle' => 'Our versatile cafe space is perfect for workshops, meetings, and private celebrations.',
            'image' => 'hero-sliders/YcQsDnf5aDvPHxWQBuGySBSegNSrcXP0JrOTLOSp.jpg',
            'cta_text' => 'Book Event Space',
            'cta_link' => 'https://fountainhead-app.test/cafe',
            'sort_order' => 2,
            'is_active' => true,
        ]);


        // Features
        Feature::create(['title' => 'High-Speed WiFi', 'description' => 'Stay connected with our blazing fast internet, perfect for work and play.', 'icon' => 'fas fa-wifi', 'sort_order' => 1, 'is_active' => true]);
        Feature::create(['title' => 'Vibrant Community', 'description' => 'Connect with like-minded individuals through our curated events and communal spaces.', 'icon' => 'fas fa-users', 'sort_order' => 2, 'is_active' => true]);
        Feature::create(['title' => '24/7 Security', 'description' => 'Your safety is our priority. We provide round-the-clock security for your peace of mind.', 'icon' => 'fas fa-shield-alt', 'sort_order' => 3, 'is_active' => true]);
        Feature::create(['title' => 'Prime Location', 'description' => 'Located in the heart of the city, with easy access to public transport and lifestyle hubs.', 'icon' => 'fas fa-map-marker-alt', 'sort_order' => 4, 'is_active' => true]);

        // Coliving Room: Fountain Deluxe Rooms
        $deluxeRoom = ColivingRoom::create([
            'name' => 'Fountain Deluxe Rooms',
            'slug' => 'fountain-deluxe-rooms',
            'room_type' => 'single',
            'description' => "✨ Fountain Deluxe Rooms: Functional Minimalist Comfort\nEnjoy a serene and peaceful stay in our Fountain Deluxe Rooms. Designed with a modern minimalist style, this room prioritizes tranquility, cleanliness, and function for both rest and work.\n\nKey Room Features:\n- Comfortable Queen Bed: Indulge in crisp white linens and a high-quality Queen mattress, ensuring you get the best night's sleep.\n- Functional Work/Study Area: Equipped with a stylish glass desk and an ergonomic chair, complemented by warm task lighting—perfect for remote work or studying.\n- Maximized Natural Light: The large window, fitted with blinds, provides abundant natural light during the day, creating an energetic and refreshing atmosphere.\n- Warm Ambiance: The all-white decor combined with the wooden floor gives a sense of spaciousness, cleanliness, and inviting warmth.",
            'short_description' => 'A bright, comfortable single room featuring a plush Queen bed, a functional desk/work area, and excellent natural light. Ideal for rest and focus.',
            'price_per_night' => 250000,
            'weekly_price' => 1500000,
            'monthly_price' => 5000000,
            'capacity' => 1,
            'room_size' => 20,
            'beds_count' => 1,
            'bed_type' => 'queen',
            'bathroom_type' => 'private',
            'facilities' => ["AC", "WiFi"],
            'amenities' => ["Wardrobe", "Work Desk", "Chair", "Mirror"],
            'thumbnail' => 'coliving-rooms/05skbq56f4exovd1njt1eJL5yzPZvMvVKW1e5wk7.jpg',
            'images' => [
                "coliving-rooms/f79gnBaEB5zjHwsHUTkOxbCB9LFumNjpP6UAmCIB.jpg",
                "coliving-rooms/6QoHKvO310tWsqel07ceWNx9mKaObYj3ZZwsr1Yy.jpg",
                "coliving-rooms/NVIB6HhDbeEi4FlBGB04zX4qEBoB1liP3JkKAY3r.jpg",
                "coliving-rooms/ZYFO74SjWRc8uxoJGAlsleKVjrdXJfJioMx9hGVw.jpg",
                "coliving-rooms/8Ok3hp9A0eDMynpvhNWujVKXHVcDTspoTpsI0cNO.jpg",
                "coliving-rooms/TlMHvDztHLodrVOMJUv2caDMQwfyjXTTmg4H3NS4.jpg",
            ],
            'is_available' => true,
            'is_featured' => true,
            'cancellation_policy' => "Our policy is designed for fairness. Please note that all cancellations and refunds are subject to a small administrative processing fee.\n\nA. Short-Term Stays (Daily & Weekly)\n- More than 7 days prior to check-in: 100% refund.\n- Between 3 and 7 days prior: 50% refund.\n- Less than 48 hours prior: No refund.\n- Early departure: No refund for unused nights.\n\nB. Long-Term Stays (Monthly)\n- 14+ days before check-in: Full refund.\n- Less than 14 days: First month's rent forfeited, deposit refunded.\n- Early termination: Monthly prepaid stays are non-refundable.",
            'house_rules' => "1. Quiet hours: 10 PM – 8 AM\n2. Smoking prohibited inside rooms & indoor areas.\n3. Visitors welcome until 10 PM; no overnight guests without approval.\n4. Tenants must keep their room clean.\n5. Damages will be charged.\n6. Pets not allowed.\n7. No illegal/dangerous items.\n8. No subletting.",
        ]);
        // Testimonials
        Testimonial::create([
            'customer_name' => 'Sarah Johnson',
            'customer_role' => 'Digital Nomad',
            'testimonial_text' => 'Fountainhead has been a game-changer! The community is amazing, the internet is fast, and the location is unbeatable.',
            'rating' => 5,
            'is_featured' => true,
        ]);
        Testimonial::create([
            'customer_name' => 'Budi Santoso',
            'customer_role' => 'Startup Founder',
            'testimonial_text' => 'We hosted our company workshop here and the experience was seamless. Great coffee too!',
            'rating' => 5,
            'is_featured' => true,
        ]);

        // Galleries
        // 1. Entrance / Balloons
Galleries::create([
            'title'       => 'Grand Opening Entrance',
            'description' => 'A stunning entrance setup featuring festive pink decorations to warmly welcome guests to our special grand opening event.',
            'image'       => 'galleries/9DLKSkTe5sKQHLqzilwmvKyzPTq3udA13uSvFH0q.jpg',
            'category'    => 'Event',
            'is_featured' => true
        ]);

        // 2. Laptop & Coffee (Work Spot)
        Galleries::create([
            'title'       => 'Remote Work Haven',
            'description' => 'An ideal spot for digital nomads and freelancers, featuring a comfortable atmosphere perfect for staying productive with a cup of coffee.',
            'image'       => 'galleries/dp2ZZEiTgCNf5JxMYA7NlWpafx0GjtHeRAgoNg0N.jpg',
            'category'    => 'Cafe',
            'is_featured' => true
        ]);

        // 3. Sofa Area
        Galleries::create([
            'title'       => 'Resident Lounge',
            'description' => 'Relax and unwind in our cozy communal lounge, designed with plush seating for residents to socialize or enjoy some quiet time.',
            'image'       => 'galleries/fcDZmAt34sdu1XwlQcBbVJZ87jJwpU1TjhiddmMm.jpg',
            'category'    => 'Coliving',
            'is_featured' => true
        ]);

        // 4. People Gathering (Wide)
        Galleries::create([
            'title'       => 'Community Meetup',
            'description' => 'Our vibrant community enjoys regular gatherings, fostering meaningful connections and friendships among all members in a relaxed setting.',
            'image'       => 'galleries/hoCOUoegc4bTM2aZFCfRh7Nm75xtG1xMHWDekEIZ.jpg',
            'category'    => 'Community',
            'is_featured' => true
        ]);

        // 5. Hallway
        Galleries::create([
            'title'       => 'Modern Corridors',
            'description' => 'Sleek and well-lit corridors leading to private suites, designed with a modern aesthetic, clean lines, and warm lighting.',
            'image'       => 'galleries/iPsWhorL5orudrvDE0HUQHQEJWNzmAuZAyWonvaj.jpg',
            'category'    => 'Facility',
            'is_featured' => true
        ]);

        // 6. Building Front (PNG)
        Galleries::create([
            'title'       => 'The Building Facade',
            'description' => 'The magnificent exterior of our building, showcasing classic architecture blended seamlessly with modern coliving facilities.',
            'image'       => 'galleries/IUaoy4lPnNT7cBjT7ZSHaOm7WEVsRVDMkMsTghaJ.png',
            'category'    => 'Coliving',
            'is_featured' => true
        ]);

        // SKIP: jtd0TV... (Duplicate of Laptop image)

        // 7. Group Photo
        Galleries::create([
            'title'       => 'Members Celebration',
            'description' => 'Capturing the smiles and joy of our amazing community members coming together to celebrate a milestone at our event space.',
            'image'       => 'galleries/LbUajpd6jF86ShhH4Lz7c8LwNqrLOVB5EIltoawN.jpg',
            'category'    => 'Event',
            'is_featured' => true
        ]);

        // 8. People Talking (Side view)
        Galleries::create([
            'title'       => 'Social & Networking',
            'description' => 'A casual setting perfect for networking, sharing ideas, and collaborating with fellow creatives and professionals in the living room.',
            'image'       => 'galleries/O3pI2aTbYmpEzvdpWK7QjAoBhg64lCwWZrVtH0n2.jpg',
            'category'    => 'Community',
            'is_featured' => true
        ]);

        // 9. Shelves
        Galleries::create([
            'title'       => 'Curated Merchandise',
            'description' => 'Explore our curated selection of merchandise and decorative items, adding a unique touch of style to the communal environment.',
            'image'       => 'galleries/QwaR2yROJDB1zvSEe464bW6kxvOct3s3bFDYNzGP.jpg',
            'category'    => 'Facility',
            'is_featured' => true
        ]);

        // 10. Long Table
        Galleries::create([
            'title'       => 'Collaboration Table',
            'description' => 'A spacious wooden communal table perfect for team meetings, group projects, or simply working alongside others in a creative environment.',
            'image'       => 'galleries/UNqufIFfj6BfFAkrfy57ztWjHxyUsr6ROyh1uv3j.jpg',
            'category'    => 'Cafe',
            'is_featured' => true
        ]);

        // 11. Wide Room (Coworking)
        Galleries::create([
            'title'       => 'Open Workspace',
            'description' => 'Our expansive open-plan workspace provides plenty of room and natural light to keep you inspired and focused throughout the day.',
            'image'       => 'galleries/vso9Mew4xMqwf3GTg8AsGpK96K8872PzjG8ShkjG.jpg',
            'category'    => 'Cafe',
            'is_featured' => true
        ]);

        // 12. Stairs
        Galleries::create([
            'title'       => 'Architectural Staircase',
            'description' => 'Beautifully designed staircases that connect our various levels, merging high functionality with artistic interior design elements.',
            'image'       => 'galleries/WMxDQep9jX8JOd9LsKTEPP4J4t7zknElCVQ9rNjb.jpg',
            'category'    => 'Facility',
            'is_featured' => true
        ]);

        // 13. Coffee Bar
        Galleries::create([
            'title'       => 'Barista Station',
            'description' => 'Our dedicated coffee station ensures you have access to fresh artisan brews to kickstart your morning or power through the afternoon slump.',
            'image'       => 'galleries/zkKjuGsK6wdz1leKOsM9lAR2oV0n0uuW1FkCCNMO.jpg',
            'category'    => 'Cafe',
            'is_featured' => true
        ]);

        // FAQ
        Faq::create([
            'question' => 'What is the minimum stay duration?',
            'answer' => 'For our coliving spaces, the minimum stay is 1 month. However, we also offer nightly rates for shorter stays depending on availability.',
            'category' => 'coliving',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Can I book the cafe for a private party?',
            'answer' => 'Absolutely! Our cafe is available for private bookings for birthdays, workshops, and other events. Please contact us for a custom quotation.',
            'category' => 'cafe',
            'is_active' => true
        ]);

        // Contact message dummy
        ContactMessage::create([
            'name' => 'Test Message',
            'email' => 'test@example.com',
            'subject' => 'Question about Monthly Stay',
            'message' => 'Hello, I am interested in the monthly price for the Deluxe Room. Can you provide more details? Thanks!',
            'status' => 'new'
        ]);

        // Homepage section
        HomepageSection::updateOrCreate(
            ['key' => 'welcome'],
            [
                'title' => 'Welcome To FountainHead',
                'description' => 'Discover a unique blend of vibrant cafe culture and modern coliving spaces designed for comfort, productivity, and community. Whether you\'re looking for a cozy spot to work or a dynamic living environment, FountainHead has it all.',
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
