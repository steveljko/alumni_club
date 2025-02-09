<div class="ml-[56px] flex space-x-2">
    <button
        hx-get="{{ route('post.create.form', ['type' => 'default']) }}"
        hx-target="form"
        hx-swap="outerHTML"
        hx-indicator="#defaultIndicator"
        @class([
            'flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-3 py-1 text-gray-700 hover:border-gray-300',
            '!border-navyblue-500 text-navyblue-500' => $active == 'default',
        ])
        type="button"
    >
        <div id="defaultIndicator"></div>
        <x-icons.lines class="mr-1.5" />
        <span class="text-sm font-medium tracking-[-0.02rem]">Default</span>
    </button>
    <button
        hx-get="{{ route('post.create.form', ['type' => 'event']) }}"
        hx-target="form"
        hx-swap="outerHTML"
        hx-indicator="#eventIndicator"
        @class([
            'flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-3 py-1 text-gray-700 hover:border-gray-300',
            '!border-navyblue-500 text-navyblue-500' => $active == 'event',
        ])
        type="button"
    >
        <div id="eventIndicator"></div>
        <x-icons.calendar class="mr-1.5" />
        <span class="text-sm font-medium tracking-[-0.02rem]">Event</span>
    </button>
    <button
        hx-get="{{ route('post.create.form', ['type' => 'job']) }}"
        hx-target="form"
        hx-swap="outerHTML"
        hx-indicator="#jobIndicator"
        @class([
            'flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-3 py-1 text-gray-700 hover:border-gray-300',
            '!border-navyblue-500 text-navyblue-500' => $active == 'job',
        ])
        type="button"
    >
        <div id="jobIndicator"></div>
        <x-icons.briefcase class="mr-1.5" />
        <span class="text-sm font-medium tracking-[-0.02rem]">Job</span>
    </button>
</div>
