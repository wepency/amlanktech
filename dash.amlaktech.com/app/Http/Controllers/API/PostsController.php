<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\PostsResource;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReaction;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use generateAPI;

    public function index(Request $request)
    {
        $associations = getAllMemberAssociations();

        if ($request->association_id) {
            $associations = [$request->association_id];
        }

        $reactions = get_auth()->user()->reactions()->pluck('type', 'post_id')->toArray();

        $posts = Post::with('comments', 'comments.user')->belongsToAssociations($associations)->active()->orderBy('id', 'DESC')->paginate();
        return $this->success(['posts' => PostsResource::makeCollection($posts, $reactions)] + $this->pagination_links($posts));
    }

    public function show(Post $post)
    {
        return $this->success(['post' => PostsResource::make($post)]);
    }

    public function storeComment(Request $request, Post $post)
    {
        try {

            if (!checkIfUserInAssociation($post->association_id)) {
                throw new \Exception('ليس لديك الصلاحيات لانشاء تعليق على هذا المنشور.', 401);
            }

            $request->validate([
                'comment' => 'required|max:191'
            ]);

            PostComment::create([
                'content' => $request->comment,
                'user_id' => get_auth()->id(),
                'post_id' => $post->id
            ]);

            return $this->success(['تم اضافة التعليق بنجاح.']);

        } catch (\Exception $exception) {
            report($exception);
            return $this->error([$exception->getMessage()]);
        }
    }

    public function deleteComment(Request $request, Post $post)
    {
        try {

            if ($post->delete())
                return $this->success(['تم خذف التعليق بنجاح.']);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error(['هناك مشكلة ما في حذف التعليق، برجاء المحاولة لاحقا.']);
    }

    public function updateReactions(Request $request, Post $post)
    {
        try {

            $oldReacts = get_auth()->user()->reactions()->where('post_id', $post->id)->first();

            if ($request->type == '') {

                PostReaction::where('post_id', $post->id)->where('user_id', get_auth()->id())->delete();

                if ($oldReacts->type == 1) {
                    $post->update([
                        'likes' => $post->likes - 1
                    ]);
                } else {
                    $post->update([
                        'dislikes' => $post->dislikes - 1
                    ]);
                }

            } else {
                PostReaction::updateOrCreate([
                    'post_id' => $post->id,
                    'user_id' => get_auth()->id()
                ], [
                    'post_id' => $post->id,
                    'user_id' => get_auth()->id(),
                    'type' => $request->type == 'like' ? 1 : 0
                ]);

                $post->update([
                    'likes' => $request->type == 'like' ? $post->likes + 1 : $post->likes,
                    'dislikes' => $request->type == 'dislike' ? $post->dislikes + 1 : $post->dislikes
                ]);

            }

            return $this->success(['تم تعديل التفاعل بنجاح.']);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error(['هناك مشكلة ما في اضافة التفاعل، برجاء المحاولة لاحقا.']);
    }
}
