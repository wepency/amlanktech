<?php

namespace App\Services;

use App\Traits\DataTableHelperTrait;

class PostService
{
    use DataTableHelperTrait;

    public const RAW_COLUMNS = [
        'image',
        'actions',
        'likes',
        'dislikes',
        'comments',
        'dislikes'
    ];

    private const SINGLE_MODEL_TITLE = 'post';
    private const PLURAL_MODEL_TITLE = 'posts';

    public function editCreatedAtColumn()
    {
        return $this->editColumn('created_at', function ($row) {
            return $row->created_at->format('Y-m-d H:i:s');
        });
    }

    public function editColumnImage()
    {
        return $this->editColumn('image', function ($row) {
            return '<img src="'.get_image_path('uploads',$row->image).'" alt="image" style="width: 100px; height: 100px;" />';
        });
    }

    public function editColumnContent()
    {
        return $this->editColumn('content', function ($row) {
            return substr($row->content, 0, 150);
        });
    }

    public function addColumnLikes()
    {
        return $this->editColumn('likes', function ($row) {
            return '<a class="open-likes" href="#" data-bs-target="#likes" data-bs-toggle="modal">عرض الاعجابات ('.$row->likes_count.')</a>';
        });
    }

    public function addColumnDislikes()
    {
        return $this->editColumn('dislikes', function ($row) {
            return '<a href="#" class="open-dislikes" data-bs-target="#likes" data-bs-toggle="modal">عرض الاعتراضات ('.$row->dislikes_count.')</a>';
        });
    }

    public function addColumnComments()
    {
        return $this->addColumn('comments', function ($row) {
            return '<a href="#" class="open-comments" data-bs-target="#comments" data-bs-toggle="modal">عرض التعليقات ('.$row->comments_count.')</a>';
        });
    }

    public function addColumnActions()
    {
        return $this->addColumn('actions', function ($row) {
            // Edit Button
            $out = static::editButton(self::SINGLE_MODEL_TITLE, self::PLURAL_MODEL_TITLE);

            $deleteRoute = dashboard_route('companies.destroy', $row->id);
            $out .= static::deleteButton($deleteRoute);

            return $out;
        });
    }

    public function rawTableColumns()
    {
        return $this->rawColumns(self::RAW_COLUMNS);
    }
}
