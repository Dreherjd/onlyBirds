<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {

    public function delete($post_id){
        $post = Post::where('id', $post_id)->first();
        $this->authorize('delete', $post);
        $post->delete();
    }

    public function with(): array
    {
        return [
            'posts' => Post::orderBy('created_at', 'desc')->get(),
        ];
    }
}; ?>

<div class="space-y-2">
    <div class="grid grid-cols-1 gap-8 mx-60 mt-6">
        @foreach ($posts as $post)
            <x-card wire:key='{{ $post->id }}' title="{{ $post->entry_title }}" rounded="3xl" shadow="2xl">
                <x-slot name="slot">
                    <p>{{ Str::limit($post->entry_content, 400) }}</p>
                </x-slot>
                <x-slot name="footer" class="flex items-center justify-between">
                    <div>
                        <x-button wire:click="delete('{{ $post->id }}')" label="Delete" outline negative />
                        <x-button href="{{ route('post.edit', $post) }}" label="Edit" outline warning />
                        <x-button label="View" outline primary />
                    </div>
                </x-slot>
            </x-card>
        @endforeach
    </div>
</div>
