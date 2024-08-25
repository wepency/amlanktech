<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;
use App\Services\UploadService;
use App\Traits\generateAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    use generateAPI;

    public function index(Request $request)
    {
        $posts = Post::withCount('comments', 'likes', 'dislikes');

        if (!is_admin()) {
            $posts->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {

            $data = (new PostService($posts))
                ->editColumnImage()
                ->editColumnContent()
                ->addColumnLikes()
                ->addColumnDislikes()
                ->addColumnComments()
                ->addColumnActions()
                ->rawTableColumns()
                ->getAssociationDetails()
                ->setRowId();

            if ($request->start >= $request->length) {
                $total = $data->totalCount();
                $query = $data->getQuery();
            } else {
                $total = $data->getFilteredQuery()->count();
                $query = $data->getFilteredQuery();
            }

            // Eager load the related admin agreements
            $queryWithReacts = $query->with('comments', 'reactions');

            // Get the count of comments for each row
            $totalComments = $queryWithReacts->get()->map(function ($item) {
                return $item->comments->count();
            })->sum();

            // Get the count of reactions for each row
            $totalReactions = $queryWithReacts->get()->map(function ($item) {
                return $item->reactions->count();
            })->sum();

            $data->with([
                'total' => $total,
                'totalComments' => $totalComments,
                'totalReactions' => $totalReactions
            ]);

            return $data->toJson();

        }

        return view('Admin.Posts.index', [
            'page_title' => 'المنشورات',
            'singleModel' => 'post',
            'pluralModel' => 'posts'
        ]);
    }

    public function likes(Post $post)
    {
        $reactions = $post->reactions()->where('type', 1)->get();

        return response()->json([
            'data' => view('Admin.Posts._likes', [
                'page_title' => 'الإعجابات 👍',
                'reactions' => $reactions
            ])->render()
        ]);
    }

    public function dislikes(Post $post)
    {
        $reactions = $post->reactions()->where('type', 0)->get();

        return response()->json([
            'data' => view('Admin.Posts._likes', [
                'page_title' => 'الإعتراضات 👍',
                'reactions' => $reactions
            ])->render()
        ]);
    }

    public function comments(Post $post)
    {
        return response()->json([
            'data' => view('Admin.Posts._comments', [
                'page_title' => 'التعليقات',
                'comments' => $post->comments
            ])->render()
        ]);
    }

    public function create(Request $request, Post $post)
    {
        return response()->json([
            'data' => view('Admin.Posts.create', [
                'page_title' => 'اضافة منشور',
                'post' => $post,
                'url' => dashboard_route('posts.store'),
            ])->render()
        ]);
    }

    public function store(Request $request, Post $post)
    {
        try {
            return $this->redirectBack($this->updateOrCreate($request, $post));
        }catch (\Exception $exception) {
            report($exception);
        }

        return $this->redirectBack(false);
    }

    public function edit(Request $request, Post $post)
    {
        return response()->json([
            'data' => view('Admin.Posts.create', [
                'page_title' => 'تعديل المنشور',
                'post' => $post,
                'url' => dashboard_route('posts.update', $post->id),
            ])->render()
        ]);
    }

    public function update(Request $request, Post $post)
    {
        try {
            return $this->redirectBack($this->updateOrCreate($request, $post));
        }catch (\Exception $exception) {
            report($exception);
        }

        return $this->redirectBack(false);
    }

    public function updateOrCreate(Request $request, Post $post)
    {

        DB::beginTransaction();

        $data = [
//            'name' => 'required|string|max:100',
//            'association_id' => 'nullable|exists:associations,id|numeric',
//            'amount' => 'required|numeric',
//            'file_path' => 'nullable|mimes:pdf,docx,doc,xslx,xls',
//            'added_to_budget' => 'nullable'
        ];

        $validatedData = $request->validate($data);

        if ($request->hasFile('image')) {
            $validatedData['image'] = UploadService::upload($request->file('image'))['filename'];
        }

        if ($post->exists && !$request->hasFile('image')) {
            unset($validatedData['image']);
        }

        $validatedData['is_active'] = $request->is_active == 'on';

        $post = $post->updateOrCreate([
            'id' => $post->id
        ], $validatedData);

        DB::commit();

        return true;
    }

    public function destroy(Post $post)
    {
        return $this->redirectBack($post->delete());
    }
}
