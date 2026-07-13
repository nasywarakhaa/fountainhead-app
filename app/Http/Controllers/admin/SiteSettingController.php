<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan situs.
     */
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.site-settings.index', compact('settings'));
    }
    public function create()
    {
        return view('admin.site-settings.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'key' => 'required|string|unique:site_settings,key|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,file,boolean',
            'group' => 'required|string|max:255',
        ]);
        SiteSetting::create($validated);
        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Site Settings created successfully!');
    }
    /**
     * Memperbarui pengaturan situs (semua grup).
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:1024',
            'site_favicon' => 'nullable|mimes:png,ico,svg|max:128',
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
        ]);

        // Handle file uploads
        $fileFields = ['site_logo', 'site_favicon'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $this->handleFileUpload($field, $request->file($field));
            }
        }

        // Simpan semua setting berdasarkan grup
        $this->saveSettingsByGroup($request, 'general', [
            'site_name', 'site_tagline'
        ]);

        $this->saveSettingsByGroup($request, 'contact', [
            'contact_email', 'contact_phone', 'contact_address'
        ]);

        $this->saveSettingsByGroup($request, 'social', [
            'facebook_url', 'instagram_url', 'twitter_url',
            'youtube_url', 'linkedin_url', 'tiktok_url'
        ]);
        $this->saveSettingsByGroup($request, 'stats', [
            'total_residents', 'average_rating', 'events_hosted'
        ]);
        Artisan::call('config:clear');

        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Pengaturan situs berhasil diperbarui!');
    }

    /**
     * Simpan settings berdasarkan grup tertentu.
     */
    private function saveSettingsByGroup(Request $request, $group, array $keys)
    {
        foreach ($keys as $key) {
            if ($request->has($key)) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $request->input($key, ''),
                        'type' => 'text',
                        'group' => $group
                    ]
                );
            }
        }
    }

    /**
     * Fungsi bantuan untuk menangani upload file.
     */
    private function handleFileUpload($key, $file)
    {
        // Hapus file lama jika ada
        $oldPath = SiteSetting::get($key);
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        // Simpan file baru
        $path = $file->store('settings', 'public');

        SiteSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $path,
                'type' => 'file',
                'group' => 'general'
            ]
        );
    }

    /**
     * Mengambil data statistik untuk kartu info.
     */
    public function stats()
    {
        $totalSettings = SiteSetting::count();
        $settingGroups = SiteSetting::distinct('group')->count('group');
        $lastUpdatedSetting = SiteSetting::orderBy('updated_at', 'desc')->first();

        return response()->json([
            'total_settings' => $totalSettings,
            'setting_groups' => $settingGroups,
            'last_updated' => $lastUpdatedSetting ? $lastUpdatedSetting->updated_at->diffForHumans() : 'N/A',
        ]);
    }
    public function destroy(SiteSetting $settings)
    {
        $settings->delete();
        return response()->json([
            'success' => true,
            'message' => 'Site Settings deleted successfully!'
        ]);
    }
}
