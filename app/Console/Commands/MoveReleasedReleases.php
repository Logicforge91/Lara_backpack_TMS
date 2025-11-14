<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CurrentRelease;
use App\Models\CompletedRelease;

class MoveReleasedReleases extends Command
{
    protected $signature = 'releases:move-released';
    protected $description = 'Move released current releases to completed releases table';

    public function handle()
    {
        // Fetch all current releases with status 'released'
        $releases = CurrentRelease::where('status', 'released')->get();

        foreach ($releases as $release) {
            // Move to completed releases
            CompletedRelease::create([
                'employee_id'      => $release->employee_id,
                'section'          => $release->section,
                'description'      => $release->description,
                'status'           => $release->status,
                'start_date'       => $release->start_date,
                'end_date'         => $release->end_date,
                'deadline_date'    => $release->deadline_date,
                'comments'         => $release->comments,
                'code_verified_by' => $release->code_verified_by,
                'story_points'     => $release->story_points,
            ]);

            // Delete from current releases
            $release->delete();
        }

        $this->info('All released current releases have been moved to completed releases.');
    }
}
