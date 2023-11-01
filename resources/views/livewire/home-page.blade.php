<div>
    <section class="container mx-auto p-4 max-w-screen-xl">
        @if (session()->has('message'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Success!</span> {{ session('message') }}
                </div>
            </div>
        @endif

        @include('components.layouts.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl" wire:init="loadElections">
        @forelse ($present_elections as $present_election)
            <div
                class="mb-5 w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center items-center">
                    @if (is_null($present_election['organization']->photo))
                        <img src="https://ui-avatars.com/api/?size=256&background=random&name={{ $present_election['organization']->name }}"
                            class="rounded-full w-12 h-12 ring-2 ring-gray-300 dark:ring-gray-500" alt="organization logo">
                    @else
                        <img src="{{ asset('storage/' . $present_election['organization']->photo) }}"
                            class="rounded-full w-12 h-12 ring-2 ring-gray-300 dark:ring-gray-500" alt="organization logo">
                    @endif

                </div>
                <h5 class="mb-5 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $present_election['organization']->name }}</h5>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">Camarines Sur Polytechnic Colleges
                </p>

                <div class="flex mb-10 items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    
                    @foreach ($present_election['partylists'] as $key => $partylist)
                        @if (is_null($partylist[0]['partylist']['photo']))
                            <img src="https://ui-avatars.com/api/?size=256&background=random&name={{ $partylist[0]['partylist']['name'] }}"
                                class="rounded-full w-20 h-20 ring-2 ring-gray-300 dark:ring-gray-500" alt="organization logo">
                        @else
                            <img src="{{ asset('storage/' . $partylist[0]['partylist']['photo']) }}"
                                class="rounded-full w-20 h-20 ring-2 ring-gray-300 dark:ring-gray-500" alt="organization logo">
                        @endif
                        
                    @endforeach

                </div>

                <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">

                    <a href="{{ route('start.voting', $present_election['election_id']) }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Start Voting
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            No present elections
        @endforelse
        <div wire:loading>
            Loading ...
        </div>
    </section>
</div>
