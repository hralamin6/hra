<?php

namespace App\Http\Livewire\Newsfeed;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $post_body;
    public $singlePost;
    public $title;
    public $post_image;
    public $post_image_link;
    public $body;
    public $post;
    public $image;
    public $image_link;
    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'desc';
    public $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = ['deleteMultiple', 'deleteSingle'];

    public function getDataProperty()
    {
        return Post::with('comments', 'user')->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'title','body','view','user_id', 'status', 'created_at'])->withQueryString();
    }

    public function addComment(Post $post)
    {
        $this->validate([
            'image'=>'nullable|image',
            'image_link'=>'nullable|image',
        ]);
        $data = $this->validate([
            'body' => ['required', 'max:3313'],
        ]);
        $data['user_id'] = auth()->id();
        $data = $post->comments()->create($data);
        if ($this->image){
            $a = $data->addMedia($this->image->getRealPath())->toMediaCollection();
            unlink("media/".$a->id.'/'. $a->file_name);
        }elseif ($this->image_link){
            $data->addMediaFromUrl($this->image_link)->toMediaCollection();
            unlink("media/".$data->getFirstMedia()->id.'/'. $data->getFirstMedia()->file_name);
        }

        $this->reset('body', 'image', 'image_link');
        $this->render();
        $this->emit('dataAdded', ['dataId' => $data->id]);

    }
    public function loadData(Post $post)
    {
        $this->reset('post_body', 'post_image', 'post_image_link', 'title');
        $this->emit('openEditModal');
        $this->title = $post->title;
        $this->post_body = $post->body;
        $this->post = $post;
    }
    public function editData()
    {
        $this->validate([
            'post_image'=>'nullable|image',
            'post_image_link'=>'nullable|url',
            'post_body' => ['required', 'max:3313'],
            'title' => ['required', 'max:3313'],

        ]);

        $this->post->update(['body' => $this->post_body,'title' => $this->title]);
        if ($this->post_image){
                        $this->post->clearMediaCollection();
            $a = $this->post->addMedia($this->post_image->getRealPath())->toMediaCollection();
            unlink("media/".$a->id.'/'. $a->file_name);
        }elseif ($this->post_image_link){
                        $this->post->clearMediaCollection();
            $this->post->addMediaFromUrl($this->post_image_link)->toMediaCollection();
            unlink("media/".$this->post->getFirstMedia()->id.'/'. $this->post->getFirstMedia()->file_name);
        }

        $this->reset('post_body', 'post_image', 'post_image_link', 'title');
        $this->render();
        $this->emit('dataAdded', ['dataId' => 'post-'.$this->post->id]);
    }
    public function addPost()
    {
        $this->validate([
            'post_image'=>'nullable|image',
            'post_image_link'=>'nullable|url',
            'post_body' => ['required', 'max:3313'],
            'title' => ['required', 'max:3313'],

        ]);
        $data = new Post();
        $data['title'] = $this->title;
        $data['body'] = $this->post_body;
        $data['user_id'] = auth()->id();
        $data->save();
        if ($this->post_image){
            $a = $data->addMedia($this->post_image->getRealPath())->toMediaCollection();
            unlink("media/".$a->id.'/'. $a->file_name);
        }elseif ($this->post_image_link){
            $data->addMediaFromUrl($this->post_image_link)->toMediaCollection();
            unlink("media/".$data->getFirstMedia()->id.'/'. $data->getFirstMedia()->file_name);
        }

        $this->reset('post_body', 'post_image', 'post_image_link', 'title');
        $this->render();
        $this->emit('dataAdded', ['dataId' => 'post-'.$data->id]);

    }

    public function resetData()
    {
        $this->reset('body', 'image', 'image_link');
    }

    public function loadMoreComment(Post $post)
    {
        dd($post);
    }
    public function deletePost(Post $post)
    {
        $post->delete();
        if ($post->getFirstMedia()){
            unlink("media/".$post->getFirstMedia()->id.'/'. $post->getFirstMedia()->file_name);
        }

        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        if ($comment->getFirstMedia()){
            unlink("media/".$comment->getFirstMedia()->id.'/'. $comment->getFirstMedia()->file_name);
        }
    }
    public function render()
    {
//        $this->singlePost = Post::where('id', $this->search)->first();
        $posts = $this->data;
        return view('livewire.newsfeed.home-component', compact('posts'));
    }
}
