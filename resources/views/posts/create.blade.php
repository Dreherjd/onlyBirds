<x-layouts.app :title="__('Create a Post')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1 class="text-4xl">Create a post</h1>
        </div>
        <livewire:posts.createpost />
    </div>
</x-layouts.app>
