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

        @include('components.layouts.guest.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl mb-10" wire:init="loadElections">
        @forelse ($present_elections as $present_election)
            <div
                class="mb-5 w-full p-4 text-center bg-blue-900 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center items-center mb-3">
                    @if (is_null($present_election->organization->photo))
                        <img src="https://ui-avatars.com/api/?size=256&background=random&name={{ $present_election->organization->name }}"
                            class="rounded-full w-20 h-20 ring-2 ring-gray-300 dark:ring-gray-500"
                            alt="organization logo">
                    @else
                        <img src="{{ asset('storage/' . $present_election->organization->photo) }}"
                            class="rounded-full w-20 h-20 ring-2 ring-gray-300 dark:ring-gray-500"
                            alt="organization logo">
                    @endif

                </div>
                <h5 class="mb-5 text-3xl font-bold text-white dark:text-white">
                    {{ $present_election->organization->name }}</h5>
                <p class="mb-5 text-base text-white sm:text-lg dark:text-gray-400">Camarines Sur Polytechnic Colleges
                </p>


                <div class="flex mb-10 items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 gap-4">

                    @foreach ($present_election->partylists as $partylist)
                        @if (is_null($partylist->photo))
                            <div class="content-center">
                                <img src="https://ui-avatars.com/api/?size=256&background=random&name={{ $partylist->name }}"
                                    class="rounded-full w-32 h-32 ring-2 ring-gray-300 dark:ring-gray-500"
                                    alt="organization logo">
                                <p class="text-white mt-2">{{ $partylist->code }}</p>
                            </div>
                        @else
                            <div>
                                <img src="{{ asset('storage/' . $partylist->photo) }}"
                                    class="rounded-full w-32 h-32 ring-2 ring-gray-300 dark:ring-gray-500"
                                    alt="organization logo">
                                <p class="text-white mt-2">{{ $partylist->code }}</p>
                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    @guest

                        <a href="{{ route('google.login') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Sign In to vote
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>

                    @endguest

                    @auth

                        @if ($present_election->votes()->where('user_id', auth()->user()->id)->where('election_id', $present_election->id)->first())
                            <a href="{{ route('election.result', $present_election->id) }}"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                View results
                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('start.voting', $present_election->id) }}"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Start Voting
                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <section class="container mx-auto bg-white dark:bg-gray-900">
                <div class="flex justify-center mx-auto max-w-screen-md">
                    <img src="{{ asset('logo/empty.svg') }}" class="w-64 h-64" alt="Empty">
                </div>
                <div class="text-center mt-4">No present elections</div>
                <div wire:loading class="text-center">
                    Loading ...
                </div>
            </section>
        @endforelse

    </section>
</div>
