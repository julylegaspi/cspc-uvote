<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">
        
        @forelse ($upcoming_elections as $election)
            <p class="text-2xl text-gray-900 dark:text-white mb-5">
                {{ $loop->index + 1 }}. {{ $election->organization->name }}
                <span class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                    <svg class="w-2.5 h-2.5 mr-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($election->start)->format('F j, Y at H:i a') }}
                </span>
            </p>
        @empty
            No upcoming elections
        @endforelse

    </section>
</div>