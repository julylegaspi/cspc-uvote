<div>
    @if (!$electionHasEnded)
        <section class="container mx-auto p-4 max-w-screen-xl" wire:poll.10s>
            <h1 class="text-center mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Partial and
                Unofficial results - {{ $election->organization->name }} ({{ $election->created_at->format('F d, Y') }})
            </h1>
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 animate-pulse">
                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                    style="width: {{ number_format($votePercentage) }}%"> {{ number_format($votePercentage) }}%</div>
            </div>
            <p class="text-center mb-4 text-lg text-gray-600 dark:text-gray-400">{{ $total_users_voted }} out of
                {{ $total_voter_counts }} people cast their votes.</p>

            <form action="{{ route('download.results', $election) }}" method="post" target="_blank">
                @csrf
                <button type="submit"
                    class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                    <svg class="w-4 h-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                            clip-rule="evenodd" />
                    </svg>

                    Download and print unofficial results
                </button>
            </form>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
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
                                        style="width: {{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() /$total_voter_counts) *100) }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span
                                        class="text-sm font-medium text-black dark:text-white">{{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() /$total_voter_counts) *100) }}%</span>
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
                Results - {{ $election->organization->name }} ({{ $election->created_at->format('F d, Y') }})</h1>
            <p class="text-center mb-4 text-lg text-gray-600 dark:text-gray-400">{{ $total_users_voted }} out of
                {{ $total_voter_counts }} people cast their votes.</p>

            <form action="{{ route('download.results', $election) }}" method="post" target="_blank">
                @csrf
                <button type="submit"
                    class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                    <svg class="w-4 h-4 text-white mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                            clip-rule="evenodd" />
                    </svg>

                    Download and print official results
                </button>
            </form>
        </section>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="summary-tab"
                        data-tabs-target="#summary" type="button" role="tab" aria-controls="summary"
                        aria-selected="false">Summary</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#winners" type="button" role="tab"
                        aria-controls="winners" aria-selected="false">Winners</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="summary" role="tabpanel"
                aria-labelledby="summary-tab">
                <section class="container mx-auto p-4 max-w-screen-xl">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                        @foreach ($candidates as $position => $candidate)
                            <div
                                class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="#">
                                    <h5 class="mb-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $position }}</h5>
                                </a>
                                @foreach ($candidate as $c)
                                    @if ($loop->first)
                                        <div class="flex items-center space-x-4 mt-4">
                                            @if (is_null($c['candidate']->photo))
                                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                                    src="https://ui-avatars.com/api/?name={{ $c['candidate']->name }}"
                                                    alt="name">
                                            @else
                                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                                    src="{{ asset('storage/' . $c['candidate']->photo) }}"
                                                    alt="name">
                                            @endif
                                            <div class="font-medium dark:text-white">
                                                <div class="text-xl">{{ $c['candidate']->name }}
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $c['candidate']->partylist->name }}</div>
                                                    <p class="text-base font-bold text-gray-900 dark:text-white">
                                                        {{ $c['count'] }} {{ Str::plural('vote', $c['count']) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center space-x-4 mt-4 pl-5">
                                            @if (is_null($c['candidate']->photo))
                                                <img class="w-10 h-10 rounded-full ring-2 ring-gray-300"
                                                    src="https://ui-avatars.com/api/?name={{ $c['candidate']->name }}"
                                                    alt="name">
                                            @else
                                                <img class="w-10 h-10 rounded-full ring-2 ring-gray-300"
                                                    src="{{ asset('storage/' . $c['candidate']->photo) }}"
                                                    alt="name">
                                            @endif
                                            <div class="font-medium dark:text-white">
                                                <div class="text-lg">{{ $c['candidate']->name }}
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $c['candidate']->partylist->name }}</div>
                                                    <p class="text-base font-bold text-gray-900 dark:text-white">
                                                        {{ $c['count'] }} {{ Str::plural('vote', $c['count']) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="winners" role="tabpanel"
                aria-labelledby="winners-tab">
                <section class="container mx-auto p-4 max-w-screen-xl">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-6">
                        @foreach ($candidates as $position => $candidate)
                            <div
                                class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="#">
                                    <h5 class="mb-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $position }}</h5>
                                </a>
                                @foreach ($candidate as $c)
                                    @if ($loop->first)
                                        <div class="flex items-center space-x-4 mt-4">
                                            @if (is_null($c['candidate']->photo))
                                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                                    src="https://ui-avatars.com/api/?name={{ $c['candidate']->name }}"
                                                    alt="name">
                                            @else
                                                <img class="w-20 h-20 rounded-full ring-2 ring-gray-300"
                                                    src="{{ asset('storage/' . $c['candidate']->photo) }}"
                                                    alt="name">
                                            @endif
                                            <div class="font-medium dark:text-white">
                                                <div class="text-xl">{{ $c['candidate']->name }}
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $c['candidate']->partylist->name }}</div>
                                                    <p class="text-base font-bold text-gray-900 dark:text-white">
                                                        {{ $c['count'] }} {{ Str::plural('vote', $c['count']) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    @endif
</div>
