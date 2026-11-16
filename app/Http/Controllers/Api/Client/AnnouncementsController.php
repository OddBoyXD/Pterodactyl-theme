<?php

namespace Pterodactyl\Http\Controllers\Api\Client;

use Pterodactyl\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Pterodactyl\Http\Requests\Api\Client\ClientApiRequest;

class AnnouncementsController extends ClientApiController
{
    /**
     * Get all active announcements for client dashboard.
     */
    public function index(ClientApiRequest $request): JsonResponse
    {
        $announcements = Announcement::where("is_active", true)
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json($announcements);
    }
}
