<?php

namespace App\Http\Actions\Announcement;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class UpdateAnnouncementHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Announcement $announcement,
    )
    {
    }

    public function handle(): self
    {

        $this->announcement->title= $this->request->get('title');
        $this->announcement->body = Purifier::clean($this->request->get('body'));

        $this->announcement->association_id = $this->request->get('association_id');
        $this->announcement->status = $this->request->get('status') == 'on';

        $this->announcement->save();

        $this->message = 'The Announcement Has Been Updated Successfully';

        return $this;
    }

}
