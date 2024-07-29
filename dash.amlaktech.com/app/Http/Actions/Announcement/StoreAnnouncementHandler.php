<?php

namespace App\Http\Actions\Announcement;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class StoreAnnouncementHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Announcement
    {
        $announcement = new Announcement;

        $announcement->title= $this->request->get('title');
        $announcement->body = Purifier::clean($this->request->get('body'));

        $announcement->association_id = $this->request->get('association_id');
        $announcement->status = $this->request->get('status') == 'on';

        $announcement->save();

        return $announcement;
    }
}
