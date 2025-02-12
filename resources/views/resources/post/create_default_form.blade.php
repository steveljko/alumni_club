<form
    class="w-full"
    hx-post="{{ route('posts.store', ['type' => 'default']) }}"
    hx-indicator="#defaultFormSpinner"
    id="postbox_form"
>
    @csrf
    <div class="flex w-full items-start">
        <img
            class="mr-4 h-10 w-10 rounded-full"
            src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
            alt="User avatar"
        >
        <div class="flex w-full flex-col">
            <textarea
                name="body"
                id="postboxTextarea"
                class="leading-1.5 mt-2.5 w-full resize-none text-base font-medium text-gray-700 outline-none"
                placeholder="What is happending?"
                hx-on:keydown="document.querySelector('#body-validation-message').classList.add('hidden')"
                autocomplete="off"
            ></textarea>
            <span class="my-2 hidden text-sm font-medium text-red-400" id="body-validation-message"></span>
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between">
        <x-postbox-type active="default" />
        <x-button
            type="submit"
            id="defaultForm"
            spinner="true"
            size="sm"
        >Post</x-button>
    </div>
</form>
