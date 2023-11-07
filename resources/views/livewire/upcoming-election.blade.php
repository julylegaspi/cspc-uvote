<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.guest.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">

        @forelse ($upcoming_elections as $election)
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
                        <h2 class="text-4xl font-semibold text-gray-900 dark:text-white">
                            {{ $election->organization->name }}</h2>
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                            <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($election->start)->format('F j, Y @ H:i A') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <section class="container mx-auto bg-white dark:bg-gray-900">
                <div class="flex justify-center mx-auto max-w-screen-md">
                    <img src="{{ asset('logo/empty.svg') }}" class="w-64 h-64" alt="Empty">
                </div>
                <div class="text-center mt-4">No upcoming elections</div>
            </section>
        @endforelse

    </section>
</div>
