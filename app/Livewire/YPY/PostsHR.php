<?php

namespace App\Livewire\YPY;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;

class PostsHR extends Component
{
    public $reply;
    public $post_id;

    public function postId($id)
    {
        $this->post_id = $id;
    }

    public function createComment()
    {
        $this->validate([
            'reply' => 'required'
        ]);

        DB::transaction(function () {
            $comment = Comment::create([
                'post_id' => $this->post_id,
                'comment' => $this->reply,
                'commentor_id' => auth()->user()->id,
            ]);

            Notification::create([
                'post_id' => $this->post_id,
                'notification_type_id' => 6,
                'created_by_id' => auth()->user()->id,
                'comment_id' => $comment->id,
            ]);
        });
        $this->dispatch('close-maodal');
        $this->reset('reply');
        $this->dispatch('close-modal');
    }

    #[Title('To HR')]
    public function render()
    {
        if(Gate::allows('isHR')){
               $posts = Post::where('audience_level_id', 1)
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select('posts.*', DB::raw('COUNT(comments.id) as comments_count'))
            ->groupBy('posts.id')
            ->orderByRaw('comments_count = 0 DESC')
            ->orderBy('posts.id', 'desc')
            ->get();
        }else{
            $posts = Post::where('user_id', auth()->user()->id)
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select('posts.*', DB::raw('COUNT(comments.id) as comments_count'))
            ->groupBy('posts.id')
            ->orderByRaw('comments_count = 0 DESC')
            ->orderBy('posts.id', 'desc')
            ->get();

        }


        // $postCount = Post::where('audience_level_id', 1)
        //     ->whereDoesntHave('comments')
        //     ->count();
        // dd($postCount);

        return view('livewire.y-p-y.posts-h-r', [
            'posts' => $posts,
        ]);
    }
}
