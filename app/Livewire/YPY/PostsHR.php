<?php

namespace App\Livewire\YPY;

use App\Models\Post;
use Livewire\Component;

class PostsHR extends Component
{
    public function createComment()
    {
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $posts = Post::where('audience_level_id', 1)->get();

        return view('livewire.y-p-y.posts-h-r', [
            'posts' => $posts,
        ]);
    }
}
