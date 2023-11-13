<div>
    @if (!$electionHasEnded)
        <section class="container mx-auto p-4 max-w-screen-xl" wire:poll.10s>
            <h1 class="text-center mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Partial and
                Unofficial results - {{ $election->organization->name }}</h1>
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 animate-pulse">
                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                    style="width: {{ number_format($votePercentage) }}%"> {{ number_format($votePercentage) }}%</div>
            </div>
            <p class="text-center mb-4 text-lg text-gray-600 dark:text-gray-400">{{ $total_users_voted }} out of
                {{ $total_voter_counts }} people cast their votes.</p>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-6">
                @foreach ($candidates as $position => $candidate)
                    <div
                        class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $position }}</h5>
                        </a>

                        @foreach ($candidate as $c)
                            <div class="flex items-center space-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-12 h-12 rounded-full text-gray-700 animate-pulse" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>

                                <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-4 rounded-full"
                                        style="width: {{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() / $total_voter_counts) *100) }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span
                                        class="text-sm font-medium text-black dark:text-white">{{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() / $total_voter_counts) *100) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <section class="container mx-auto p-4 max-w-screen-xl">
            <h1 class="text-center mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Official
                Results - {{ $election->organization->name }}</h1>
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                    style="width: {{ number_format($votePercentage) }}%"> {{ number_format($votePercentage) }}%</div>
            </div>
            <p class="text-center mb-4 text-lg text-gray-600 dark:text-gray-400">{{ $total_users_voted }} out of
                {{ $total_voter_counts }} people cast their votes.</p>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-6">
                @foreach ($candidates as $position => $candidate)
                    <div
                        class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $position }}</h5>
                        </a>
                        <div class="flex items-center space-x-4">
                            @if (is_null($candidate['candidate']->photo))
                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                    src="https://ui-avatars.com/api/?name={{ $candidate['candidate']->name }}"
                                    alt="name">
                            @else
                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                    src="{{ asset('storage/' . $candidate['candidate']->photo) }}" alt="name">
                            @endif
                            <div class="font-medium dark:text-white">
                                <div>{{ $candidate['candidate']->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $candidate['candidate']->partylist->name }}</div>
                                <span
                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                    <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                    {{ $candidate['count'] }} Votes
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    @endif
    </section>

</div>
