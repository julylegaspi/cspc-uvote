<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.guest.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">
        @include('components.layouts.flash')
        <form>
            @csrf

            <div class="grid grid-cols-5 gap-4">
                <div class="col-span-2">
                    <div
                        class="w-full p-2 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">

                        <div class="mb-4 border-gray-200 dark:border-gray-700">
                            <ul class=" text-center" id="myTab" data-tabs-toggle="#electionTabContent" role="tablist">
                                @foreach ($candidates as $key => $position)
                                    <li role="presentation">
                                        <button
                                            class="@if ($loop->first) inline-block p-4 border-b-2 rounded-t-lg @else inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 @endif"
                                            id="position{{ $loop->index }}-tab"
                                            data-tabs-target="#position{{ $loop->index }}" type="button"
                                            role="tab" aria-controls="position{{ $loop->index }}"
                                            aria-selected="false">{{ $key }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-span-3">
                    <div id="electionTabContent">
                        @foreach ($candidates as $key => $candidate)
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" wire:ignore
                                id="position{{ $loop->index }}" role="tabpanel"
                                aria-labelledby="{{ $loop->index }}-tab">
                                <h5 class="mb-5 text-3xl font-bold text-gray-900 dark:text-white"
                                    id="{{ $key }}">
                                    {{ $key }}</h5>
                                <ul class="mb-10 grid w-full gap-6 md:grid-cols-4 sm:grid-cols-2">
                                    @foreach ($candidate as $cKey => $cValue)
                                        <li class="text-center">
                                            <input type="radio" id="{{ $cValue->user->id }}"
                                                wire:model="votes.{{ $cValue['position']->id }}"
                                                value="{{ $cValue->user->id }}" class="hidden peer">
                                            <label for="{{ $cValue->user->id }}"
                                                class="border-2 p-1 flex items-center justify-between w-full text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                @if (is_null($cValue->user->photo))
                                                    <img src="https://ui-avatars.com/api/?size=100&name={{ $cValue->user->name }}"
                                                        class="w-full rounded-lg w-32 h-32" alt="">
                                                @else
                                                    <img src="{{ asset('storage/' . $cValue->user->photo) }}"
                                                        class="w-full rounded-lg w-32 h-min" alt="">
                                                @endif
                                            </label>
                                            <button type="button" title="View candidate profile"
                                                class="inline-flex items-center ml-2 text-sm font-medium text-gray-600 md:ml-2 dark:gray-blue-500 hover:underline"
                                                data-drawer-target="drawer-right-example"
                                                data-drawer-show="drawer-right-example" data-drawer-placement="right"
                                                aria-controls="drawer-right-example"
                                                wire:click.prefetch="getProfileInfo({{ $cValue->user->id }})">
                                                <svg class="w-3 h-3 mr-1" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                                </svg>
                                                {{ $cValue->user->name }}

                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <button wire:click="showReview" type="button" data-modal-target="review-modal" data-modal-toggle="review-modal"
                        class="mt-3 px-6 py-3.5 text-base font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Review and Submit
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>

                    {{-- <button onclick="return confirm('You are about to submit your vote. Continue?')" type="submit"
                        class="mt-3 px-6 py-3.5 text-base font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit vote
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button> --}}

                </div>
            </div>

        </form>

    </section>

    <section>

        <!-- drawer component -->
        <div id="drawer-right-example" wire:ignore.self
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <h3 id="drawer-right-label"
                class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg
                    class="w-4 h-4 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>Candidate Profile</h3>
            <button wire:click="cancel" type="button" data-drawer-hide="drawer-right-example"
                aria-controls="drawer-right-example"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 right-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <div wire:loading>Fetching information ...</div>
            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Partylist:</p>
            <p class="mb-3">{{ $partylist }}</p>

            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Name:</p>
            <p class="mb-3">{{ $name }}</p>

            {{-- <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Address:</p>
            <p class="mb-3">{{ $address }}</p> --}}

            {{-- <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Birthday:</p>
            <p class="mb-3">{{ \Carbon\Carbon::parse($birthday)->format('F j, Y') }}</p> --}}

            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Course & Section:</p>
            <p class="mb-3">{{ $course }} - {{ $section }}</p>

            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Organizational
                Affiliation:
            </p>
            <p class="mb-3">{{ $organizational_affiliation }}</p>

            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Notable Achievements:</p>
            <p class="mb-3">{{ $notable_achievements }}</p>

            <p class="font-bold underline text-lg font-medium text-gray-900 dark:text-white">Platform:</p>
            <p class="mb-3">{{ $platform }}</p>



        </div>

    </section>


    <!-- Review modal -->
    <div id="review-modal" data-modal-backdrop="review" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Review and Submit Vote
                    </h3>
                    <button type="button" wire:loading.attr='disabled'
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="review-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    @if($review == 'yes')
                    @forelse ($votes as $positionKey => $candidate_id)
                        
                        <h2 class="text-lg leading-5 font-semibold text-gray-900 dark:text-white">{{ $loop->index + 1}}. {{ \App\Models\Position::find($positionKey)->name }}</h2>
                        <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                            <li class="flex items-center ml-4">
                                <svg class="w-3.5 h-3.5 me-2 mr-1 text-green-500 dark:text-green-400 flex-shrink-0"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                {{ \App\Models\User::find($candidate_id)->name }} - {{ \App\Models\User::find($candidate_id)->partylist->name }}
                            </li>
                        </ul>
                    @empty
                        <p class="text-red-600 dark:text-red-500">Noting to see here...you may want to select at least one candidate.</p>
                    @endforelse

                    @endif

                    <div wire:loading wire:target="showReview">Loading...</div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button wire:loading.attr='disabled' data-modal-hide="review-modal" type="button"
                        class="mr-2 ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Back
                        to voting</button>
                    <button wire:loading.attr='disabled' wire:click.prevent="submit" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit
                        vote</button>

                    <div wire:loading wire:target="submit">Submitting vote...please wait</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // set the drawer menu element
            const $targetEl = document.getElementById('drawer-right-example');

            // options with default values
            const options = {
                placement: 'right',
                backdrop: true,
            };
        </script>
    @endpush

</div>
