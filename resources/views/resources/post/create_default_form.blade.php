<form class="w-full"
    hx-indicator="#defaultFormSpinner"
    hx-post="{{ route('post.create.execute', ['type' => 'default']) }}">
    @csrf
    <div class="flex w-full items-start">
        <img class="mr-4 h-10 w-10 rounded-full"
            src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
            alt="User avatar">
        <div class="flex w-full flex-col">
            <textarea name="body"
                id="postboxTextarea"
                class="leading-1.5 mt-2.5 w-full resize-none text-base font-medium text-gray-700 outline-none"
                placeholder="What is happending?"
                hx-on:keydown="document.querySelector('#body-validation-message').classList.add('hidden')"
                autocomplete="off"></textarea>
            <span class="my-2 hidden text-sm font-medium text-red-400"
                id="body-validation-message"></span>
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between">
        <div class="ml-[56px] flex space-x-2">
            <button hx-get="{{ route('post.create.form', ['type' => 'default']) }}"
                hx-target="form"
                hx-swap="outerHTML"
                hx-indicator="#defaultIndicator"
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-blue-400 bg-blue-50 px-2 py-1"
                type="button">
                <div id="defaultIndicator"></div>
                <x-icon-lines class="mr-1.5 text-blue-600" />
                <span class="text-sm font-medium text-blue-600">Default</span>
            </button>
            <button hx-get="{{ route('post.create.form', ['type' => 'event']) }}"
                hx-target="form"
                hx-swap="outerHTML"
                hx-indicator="#eventIndicator"
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-2 py-1 hover:border-gray-300"
                type="button">
                <div id="eventIndicator"></div>
                <x-icon-calendar class="mr-1.5" />
                <span class="text-sm font-medium text-gray-700">Event</span>
            </button>
            <button hx-get="{{ route('post.create.form', ['type' => 'job']) }}"
                hx-target="form"
                hx-swap="outerHTML"
                hx-indicator="#jobIndicator"
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-2 py-1 hover:border-gray-300"
                type="button">
                <div id="jobIndicator"></div>
                <x-icon-briefcase class="mr-1.5" />
                <span class="text-sm font-medium text-gray-700">Job</span>
            </button>
        </div>
        <x-button type="submit"
            id="defaultForm"
            spinner="true"
            size="sm">Post</x-button>
    </div>
</form>
