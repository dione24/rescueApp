<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use App\Mail\AnnouncementAccepted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAcceptanceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function handle()
    {
        $user = $this->announcement->user;
        $admin = User::where('role', 'admin')->first();

        Mail::to($user)->send(new AnnouncementAccepted($this->announcement));
        Mail::to($admin)->send(new AnnouncementAccepted($this->announcement));
    }
}
