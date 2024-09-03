<?php

namespace App\Livewire\YPY;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ViewPost extends Component
{
    #[Url(as: 'id')]
    public $post_id;
    public $reply;

    public function createComment()
    {
        $this->validate([
            'reply' => 'required'
        ]);

        DB::transaction(function () {
            $comment =  Comment::create([
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

        $this->reset('reply');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.y-p-y.view-post', [
            'post' => Post::find($this->post_id),
        ]);
    }
}
