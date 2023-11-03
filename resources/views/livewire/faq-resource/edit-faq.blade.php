<div>
    <div class="grid grid-cols-1 gap-4 w-full 2xl:grid-cols-3">
        <div class="col-span-2">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <p class="mb-4 text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">Edit
                    FAQ</p>

                <div class="mb-6">
                    <label for="question"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Question</label>
                    <input type="text" id="question" wire:model="question"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('question')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">

                    <label for="answer"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Answer</label>
                    <textarea id="answer" rows="4" wire:model="answer"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

                    @error('answer')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="button" wire:click="update"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update
                </button>
            </div>

        </div>

    </div>
</div>