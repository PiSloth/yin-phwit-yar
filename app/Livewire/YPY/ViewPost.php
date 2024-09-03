<?php

namespace App\Livewire\YPY;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\ReadComment;
use App\Models\ReadPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;

class ViewPost extends Component
{
    #[Url(as: 'id')]
    public $post_id;

    #[Url(as:'noti')]
    public $comment_id;

    public $reply;

    public function mount(){
        $query = Post::find($this->post_id);
        if(Gate::allows('isHR') || $query->user_id == auth()->user()->id){
            return;
        }else{
            return back();
        }
    }

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
        $this->dispatch('close-modal');
        $this->reset('reply');
        $this->dispatch('close-modal');
    }



    public function render()
    {
        if($this->comment_id > 0){
            $commenId = ReadComment::where('comment_id' , $this->comment_id)->exists();
            // dd($commenId);

            if($commenId) {
                // dd('hello');
            }else {
                ReadComment::create([
                    'comment_id' => $this->comment_id,
                ]);
            }
        }

        return view('livewire.y-p-y.view-post', [
            'post' => Post::find($this->post_id),
        ]);
    }
}
