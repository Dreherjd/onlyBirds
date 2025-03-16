<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;

    public function mount(Post $post){
        $this->authorize('update', $post);
        $this->fill($post);
    }
}; ?>

<div>
    {{ $post->entry_title }}
</div>
