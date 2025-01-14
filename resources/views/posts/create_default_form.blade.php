<form hx-post="{{ route('post.create.execute', ['type' => 'default']) }}">
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
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-blue-400 bg-blue-50 px-2 py-1"
                type="button">
                <svg width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    class="mr-1.5 text-blue-600"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.125 5.625H16.875M3.125 10H16.875M3.125 14.375H10"
                        class="stroke-current"
                        stroke-width="1.25"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="text-sm font-medium text-blue-600">Default</span>
            </button>
            <button hx-get="{{ route('post.create.form', ['type' => 'event']) }}"
                hx-target="form"
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-2 py-1 hover:border-gray-300"
                type="button">
                <svg width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    class="mr-1.5"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.625 2.5V4.375M14.375 2.5V4.375M2.5 15.625V6.25C2.5 5.75272 2.69754 5.27581 3.04917 4.92417C3.40081 4.57254 3.87772 4.375 4.375 4.375H15.625C16.1223 4.375 16.5992 4.57254 16.9508 4.92417C17.3025 5.27581 17.5 5.75272 17.5 6.25V15.625M2.5 15.625C2.5 16.1223 2.69754 16.5992 3.04917 16.9508C3.40081 17.3025 3.87772 17.5 4.375 17.5H15.625C16.1223 17.5 16.5992 17.3025 16.9508 16.9508C17.3025 16.5992 17.5 16.1223 17.5 15.625M2.5 15.625V9.375C2.5 8.87772 2.69754 8.40081 3.04917 8.04917C3.40081 7.69754 3.87772 7.5 4.375 7.5H15.625C16.1223 7.5 16.5992 7.69754 16.9508 8.04917C17.3025 8.40081 17.5 8.87772 17.5 9.375V15.625M10 10.625H10.0067V10.6317H10V10.625ZM10 12.5H10.0067V12.5067H10V12.5ZM10 14.375H10.0067V14.3817H10V14.375ZM8.125 12.5H8.13167V12.5067H8.125V12.5ZM8.125 14.375H8.13167V14.3817H8.125V14.375ZM6.25 12.5H6.25667V12.5067H6.25V12.5ZM6.25 14.375H6.25667V14.3817H6.25V14.375ZM11.875 10.625H11.8817V10.6317H11.875V10.625ZM11.875 12.5H11.8817V12.5067H11.875V12.5ZM11.875 14.375H11.8817V14.3817H11.875V14.375ZM13.75 10.625H13.7567V10.6317H13.75V10.625ZM13.75 12.5H13.7567V12.5067H13.75V12.5Z"
                        stroke="#374151"
                        stroke-width="1.25"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="text-sm font-medium text-gray-700">Event</span>
            </button>
            <button hx-get="{{ route('post.create.form', ['type' => 'job']) }}"
                hx-target="form"
                class="flex cursor-pointer select-none items-center justify-center rounded-full border border-transparent px-2 py-1 hover:border-gray-300"
                type="button">
                <svg width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    class="mr-1.5"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.875 11.7917V15.3333C16.875 16.245 16.2192 17.03 15.315 17.15C13.5759 17.3808 11.8017 17.5 10 17.5C8.19838 17.5 6.42421 17.3808 4.68505 17.15C3.78088 17.03 3.12505 16.245 3.12505 15.3333V11.7917M16.875 11.7917C17.0729 11.6197 17.2312 11.407 17.3391 11.168C17.447 10.9291 17.5019 10.6697 17.5 10.4075V7.255C17.5 6.35417 16.86 5.57583 15.9692 5.4425C15.0253 5.30118 14.0766 5.19361 13.125 5.12M16.875 11.7917C16.7134 11.9292 16.525 12.0375 16.3142 12.1083C14.2777 12.784 12.1457 13.1273 10 13.125C7.79338 13.125 5.67088 12.7675 3.68588 12.1083C3.48026 12.0399 3.28982 11.9324 3.12505 11.7917M3.12505 11.7917C2.92717 11.6197 2.76885 11.407 2.66096 11.168C2.55308 10.9291 2.49818 10.6697 2.50005 10.4075V7.255C2.50005 6.35417 3.14005 5.57583 4.03088 5.4425C4.97479 5.30118 5.92345 5.19361 6.87505 5.12M13.125 5.12V4.375C13.125 3.87772 12.9275 3.40081 12.5759 3.04917C12.2242 2.69754 11.7473 2.5 11.25 2.5H8.75005C8.25277 2.5 7.77585 2.69754 7.42422 3.04917C7.07259 3.40081 6.87505 3.87772 6.87505 4.375V5.12M13.125 5.12C11.0448 4.95923 8.95528 4.95923 6.87505 5.12M10 10.625H10.0067V10.6317H10V10.625Z"
                        stroke="#374151"
                        stroke-width="1.25"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="text-sm font-medium text-gray-700">Job</span>
            </button>
        </div>
        <button class="rounded-md bg-[#DCEBFF] px-3 py-2 text-sm font-medium text-[#2F80ED]"
            type="submit">Post</button>
    </div>
</form>
