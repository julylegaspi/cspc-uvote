<div>
    <section class="container mx-auto p-4 max-w-screen-xl" wire:poll.10s>
        @if (!$electionHasEnded)
            <h1 class="text-center mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Partial and
                Unofficial results - {{ $election->organization->name }}</h1>
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 animate-pulse">
                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                    style="width: {{ number_format($votePercentage) }}%"> {{ number_format($votePercentage) }}%</div>
            </div>
            <p class="text-center mb-4 text-lg text-gray-600 dark:text-gray-400">{{ $total_users_voted }} out of {{ $total_voter_counts }} people cast their votes.</p>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-6">
                @foreach ($candidates as $position => $candidate)
                    <div
                        class="p-6 bg-blue-900 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-white dark:text-white">
                                {{ $position }}</h5>
                        </a>

                        @foreach ($candidate as $c)
                            
                            <div class="flex items-center space-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 rounded-full text-white animate-pulse"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>

                                <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                    <div class="bg-yellow-300 h-4 rounded-full" style="width: {{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() / $total_voter_counts) * 100) }}%"></div>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-white dark:text-white">{{ number_format(($election->votes()->where('candidate_id', $c->user_id)->count() / $total_voter_counts) * 100) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <h1 class="text-center mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Official
                Results - {{ $election->organization->name }}</h1>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-6">
                    @foreach ($candidates as $position => $candidate)
                        <div
                            class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $position }}</h5>
                            </a>
                            {{ $candidate }}
                            @foreach ($candidate as $c)

                            
                                {{-- <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 rounded-full animate-pulse"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                    </svg>
    
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 animate-pulse">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ number_format(($election->votes->where('candidate_id', $c->user_id)->count() / $total_voter_counts) * 100) }}%"></div>
                                    </div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-blue-700 dark:text-white">{{ number_format(($election->votes->where('candidate_id', $c->user_id)->count() / $total_voter_counts) * 100) }}%</span>
                                    </div>
                                </div> --}}
                            @endforeach
                        </div>
                    @endforeach
                </div>
        @endif

        {{-- <p class="mb-4 text-lg text-gray-600 dark:text-gray-400 text-center">{{ number_format($votePercentage) }}% of
            100%</p> --}}
        {{-- <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-6">
            <div>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolor quas commodi itaque ut illum saepe
                quibusdam odio quod quae ipsam! Reprehenderit deleniti officia id iure soluta dignissimos voluptas
                cupiditate? Quas?
            </div>
            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur rerum dignissimos molestias
                reiciendis iste, qui tenetur quo quae commodi blanditiis a dolorem animi earum tempore quos laborum sunt
                voluptatum enim?</div>
            <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam illum delectus possimus, illo in
                voluptatum consequuntur dolorum inventore modi ad, eveniet tempora, ab sed ipsum iure impedit dicta
                corporis consectetur?</div>
        </div> --}}
    </section>

</div>
