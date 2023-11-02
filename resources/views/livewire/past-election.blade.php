<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.guest.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">
        
        @forelse ($past_elections as $election)
            <p class="text-2xl text-gray-900 dark:text-white mb-4">
                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('election.result', $election) }}">{{ $loop->index + 1 }}. {{ $election->organization->name }}</a>
            </p>
        @empty
            No past elections
        @endforelse

    </section>
</div>
