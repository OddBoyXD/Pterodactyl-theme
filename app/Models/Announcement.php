<?php

namespace Pterodactyl\Models;

class Announcement extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "announcements";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "title",
        "content",
        "category",
        "action_text",
        "action_url",
        "is_active",
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        "is_active" => "boolean",
    ];

    /**
     * Default validation rules.
     */
    public static array $validationRules = [
        "title" => "required|string|max:191",
        "content" => "required|string",
        "category" => "required|string|in:info,warning,danger,update",
        "action_text" => "nullable|string|max:100",
        "action_url" => "nullable|url|max:255",
        "is_active" => "sometimes|boolean",
    ];

    /**
     * Override route binding key to be "id".
     */
    public function getRouteKeyName(): string
    {
        return "id";
    }
}
