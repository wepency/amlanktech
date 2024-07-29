<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Announcement\StoreAnnouncementHandler;
use App\Http\Actions\Announcement\UpdateAnnouncementHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function index()
    {
        $announcements = Announcement::with('association');

        if (!is_admin()) {
            $announcements = $announcements->whereAssociationId(getAssociationId());
        }

        $announcements = $announcements->orderBy('id', 'desc')->paginate();

        return view('Admin.Announcements.Index', [
            'page_title' => 'الاعلانات ',
            'announcements' => $announcements,
        ]);
    }


    public function create(Request $request, Announcement $announcement): JsonResponse
    {

        return response()->json([
            'data' => view('Admin.Announcements.create', [
                'page_title' => 'إضافة اعلان جديد',
                'url' => dashboard_route('announcements.store'),
                'announcement' => $announcement,
            ])->render()
        ]);
    }


    public function edit(Announcement $announcement): JsonResponse
    {

        return response()->json([
            'data' => view('Admin.Announcements.create', [
                'page_title' => 'تعديل اعلان ',
                'url' => dashboard_route('announcements.update', $announcement->id),
                'announcement' => $announcement,
            ])->render()
        ]);
    }


    public function store(StoreAnnouncementRequest $request)
    {
        (new StoreAnnouncementHandler($request))->handle();
        return redirect()->back()->with('success', 'Announcement created successfully');
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        (new UpdateAnnouncementHandler($request, $announcement))->handle();
        return redirect()->back()->with('success', 'Announcement updated successfully');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        return $this->redirectBack($announcement->delete());
    }

}
