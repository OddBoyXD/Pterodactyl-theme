<?php

namespace Pterodactyl\Http\Controllers\Admin\Settings;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Pterodactyl\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;

class AnnouncementsController extends Controller
{
    /**
     * AnnouncementsController constructor.
     */
    public function __construct(
        private AlertsMessageBag $alert,
    ) {
    }

    /**
     * Render the admin management view for announcements.
     */
    public function index(): View
    {
        $announcements = Announcement::orderBy("created_at", "desc")->paginate(20);
        $totalCount = Announcement::count();
        $activeCount = Announcement::where("is_active", true)->count();

        return view("admin.settings.announcements", [
            "announcements" => $announcements,
            "totalCount" => $totalCount,
            "activeCount" => $activeCount,
        ]);
    }

    /**
     * Store a new announcement in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "title" => "required|string|max:191",
            "category" => "required|string|in:info,warning,danger,update",
            "content" => "required|string",
            "action_text" => "nullable|string|max:100",
            "action_url" => "nullable|url|max:255",
            "is_active" => "sometimes|boolean",
        ]);

        $validated["is_active"] = $request->has("is_active") && $request->input("is_active") == "1";

        Announcement::create($validated);

        $this->alert->success("Announcement has been created successfully.")->flash();

        return redirect()->route("admin.announcements");
    }

    /**
     * Update an existing announcement.
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            "title" => "required|string|max:191",
            "category" => "required|string|in:info,warning,danger,update",
            "content" => "required|string",
            "action_text" => "nullable|string|max:100",
            "action_url" => "nullable|url|max:255",
            "is_active" => "sometimes|boolean",
        ]);

        $validated["is_active"] = $request->has("is_active") && $request->input("is_active") == "1";

        $announcement->update($validated);

        $this->alert->success("Announcement has been updated successfully.")->flash();

        return redirect()->route("admin.announcements");
    }

    /**
     * Toggle active state of an announcement.
     */
    public function toggle(Announcement $announcement): RedirectResponse
    {
        $announcement->update([
            "is_active" => !$announcement->is_active,
        ]);

        $status = $announcement->is_active ? "activated" : "deactivated";
        $this->alert->success("Announcement has been {$status}.")->flash();

        return redirect()->route("admin.announcements");
    }

    /**
     * Delete an announcement.
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        $this->alert->success("Announcement has been removed successfully.")->flash();

        return redirect()->route("admin.announcements");
    }
}
