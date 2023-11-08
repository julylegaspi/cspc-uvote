<footer
    class="p-4 my-6 mx-4 bg-white rounded-lg shadow md:flex md:items-center md:justify-between md:p-6 xl:p-8 dark:bg-gray-800">
    <ul class="flex flex-wrap items-center mb-6 space-y-1 md:mb-0">
        <li><a href="{{ route('terms.and.conditions.index') }}" target="_blank"
                class="mr-4 text-sm font-normal text-gray-500 hover:underline md:mr-6 dark:text-gray-400">Terms
                and conditions</a></li>
        
    </ul>
</footer>
<p class="my-10 text-sm text-center text-gray-500">
    &copy; {{ now()->format('Y') }} All rights reserved.
</p>