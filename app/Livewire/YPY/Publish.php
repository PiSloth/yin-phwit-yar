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
        });

        $this->reset('content', 'department_id', 'type_id');
        $this->notification()->send([
            'title'       => 'Profile saved!',
            'description' => 'Your profile was successfully saved',
            'icon'        => 'success'
        ]);

        $this->dialog()->success(
            $title = 'Thanks',
            $description = 'Your post successfully send to HR'
        );
    }

    public function createPublicPost()
    {
        // use a simple syntax
        $this->dialog()->success(
            $title = 'Hi Buddy',
            $description = 'We will be very soon for Public post'
        );

        $this->validate([
            'content' => 'required',
        ]);
    }


    public function render()
    {
        $results = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.commentor_id')
            ->select('comments.post_id', 'users.name', 'comments.comment')
            ->get();
        // dd($results);

        return view('livewire.y-p-y.publish', [
            'departments' => Department::all(),
            'types' => Type::all(),
            // dd(Type::all()),
        ]);
    }
}
