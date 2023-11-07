<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.guest.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">

        @forelse ($past_elections as $election)
            <div class="p-6 bg-white border  border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    @if (is_null($election->organization->photo))
                        <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                            src="https://ui-avatars.com/api/?name={{ $election->organization->name }}" alt="">
                    @else
                        <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                            src="{{ asset('storage/' . $election->organization->photo) }}" alt="">
                    @endif
                    <div class="font-medium dark:text-white">
                        <a href="{{ route('election.result', $election) }}"
                            class="inline-flex text-blue-600 dark:text-blue-500 hover:underline">
                            <h2 class="text-3xl font-semibold text-blue dark:text-white">
                                {{ $election->organization->name }}</h2>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <section class="container mx-auto bg-white dark:bg-gray-900">
                <div class="flex justify-center mx-auto max-w-screen-md">
                    <img src="{{ asset('logo/empty.svg') }}" class="w-64 h-64" alt="Empty">
                </div>
                <div class="text-center mt-4">No past elections</div>
            </section>
        @endforelse

    </section>
</div>
