<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User\Story;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('delete:expired-stories', function () {
    // Find stories older than 24 hours
    $expiredStories = Story::where('created_at', '<', now()->subDay())->get();

    foreach ($expiredStories as $story) {
        // Delete media file if it exists in storage/app/public/stories
        if ($story->media && Storage::disk('public')->exists($story->media)) {
            Storage::disk('public')->delete($story->media);
        }

        // Delete the story record
        $story->delete();
    }

    $this->info("Expired stories and files deleted successfully.");
})->purpose('Delete expired stories older than 24 hours')->daily();
