<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            NEW POST
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mb-6 mt-5 bg-white rounded-sm shadow-sm p-10">
        <form action="{{ route("post.store") }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
            </div>
        </form>
    </div>
</x-app-layout>