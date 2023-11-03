<div>
    <section class="container mx-auto p-4 max-w-screen-xl">
        <h2
            class="mb-4 text-2xl font-bold text-gray-900 lg:font-extrabold lg:text-4xl lg:leading-snug dark:text-white lg:text-center 2xl:px-48">
            Frequently asked questions</h2>
        <p class="mb-1 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl xl:px-64 lg:mb-12">
            Search for the questions that are frequently asked about Election</p>

        <div id="accordion-flush" data-accordion="collapse"
            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
            data-inactive-classes="text-gray-500 dark:text-gray-400">
            @forelse ($faqs as $key => $faq)
                <h2 id="accordion-flush-heading-{{ $key }}">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-{{ $key }}" aria-expanded="true"
                        aria-controls="accordion-flush-body-{{ $key }}">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg> {{ $faq->question }}</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-{{ $key }}" class="hidden"
                    aria-labelledby="accordion-flush-heading-{{ $key }}">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{!! $faq->answer !!}
                        </p>
                    </div>
                </div>

            @empty
            <p class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl xl:px-64 lg:mb-16">
                No FAQs...</p>
            @endforelse

        </div>



    </section>
</div>
