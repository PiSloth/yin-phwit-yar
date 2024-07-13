<?php

namespace App\Livewire\YPY;

use App\Models\Content;
use App\Models\Department;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Publish extends Component
{

    use WireUiActions;
    public $department_id = '';
    public $type_id = '';
    public $content;

    public function createHRPost()
    {
        $this->validate([
            'department_id' => 'required',
            'type_id' => 'required',
            'content' => 'required'
        ]);
        DB::transaction(function () {

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'department_id' => $this->department_id,
                'type_id' => $this->type_id,
                'audience_level_id' => 1, // this audience level is HR
                'status_id' => 1, //request post to HR to before well note
            ]);

            $content = Content::create([
                'post_id' => $post->id,
                'content' => $this->content,
            ]);



            // Notification::create([
            //     'notifaciton_type_id' => 1, //Create Post
            //     'post_id' => $post->id,
            // ]);

        });

        $this->notification()->send([
            'title'       => 'Profile saved!',
            'description' => 'Your profile was successfully saved',
            'icon'        => 'success'
        ]);
    }

    public function createPublicPost()
    {
        $this->validate([
            'content' => 'required',
        ]);
    }


    public function render()
    {
        return view('livewire.y-p-y.publish', [
            'departments' => Department::all(),
            'types' => Type::all(),
            // dd(Type::all()),
        ]);
    }
}
