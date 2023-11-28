<div>
    <div class="grid grid-cols-3 gap-4 w-full 2xl:grid-cols-3">
        <div class="col-span-2">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <p class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">Create Election</p>

                <section class="mt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 mb-4">
                            <label for="organization"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Organization</label>
                            <select id="organization" wire:model="organization"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                            @error('organization')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>

                            <label for="start_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start date</label>
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>

                                <input type="datetime-local" id="start_date" wire:model="start_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Start date">
                            </div>
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label for="end_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End date</label>
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>

                                <input type="datetime-local" id="end_date" wire:model="end_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="End date">
                            </div>
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="col-span-2">

                            {{-- <label for="partylists"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partylist</label>
                            <select id="partylist" wire:model="partylist" multiple autocomplete="off"
                                wire:change="getPartylist"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Select option</option>
                                @foreach ($partylists as $partylist)
                                    <option value="{{ $partylist->id }}">{{ $partylist->name }}</option>
                                @endforeach
                            </select> --}}
                            <h3 class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partylists</h3>
                            <ul
                                class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach ($partylists as $key => $partylist)
                                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="partylist{{ $key }}" type="checkbox"
                                                value="{{ $partylist->id }}" wire:model="partylist"
                                                wire:change="getPartylist"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="partylist{{ $key }}"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $partylist->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @error('partylist')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror


                        </div>
                    </div>
                </section>
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">


                <section class="mt-4">
                    @foreach ($candidates as $key => $candidate)
                        <div class="mb-4">
                            <div
                                class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    {{ $candidate['partylist_name'] }}</h5>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    @foreach ($candidate['candidates'] as $cKey => $cValue)
                                        <div>
                                            <label for="position"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                                            <select id="position"
                                                wire:model="candidates.{{ $key }}.candidates.{{ $cKey }}.position"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="">Select option</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('candidates.' . $key . '.candidates.' . $cKey . '.position')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="candidate"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Candidate</label>
                                            <div class="flex items-center">
                                                <select
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    wire:model="candidates.{{ $key }}.candidates.{{ $cKey }}.user"
                                                    id="candidate">
                                                    <option value="">Select option</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($cKey > 0)
                                                    <button title="remove"
                                                        wire:click="removeCandidate({{ $key }}, {{ $cKey }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                            @error('candidates.' . $key . '.candidates.' . $cKey . '.user')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <button wire:click="addCandidate({{ $key }})" type="button"
                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">add
                                    candidate</button>
                            </div>
                        </div>
                    @endforeach
                </section>

                <button type="button" wire:click="save"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Save
                </button>
            </div>

        </div>
        <div class="col-span-1">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <p class="mb-4 text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">Voters</p>

                @foreach ($departments as $departmentKey => $departmentValue)
                    <p>
                        <input id="department-{{ $departmentKey }}" wire:model="department" type="checkbox"
                            value="{{ $departmentValue->id }}" wire:click="getCourses"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="department-{{ $departmentKey }}"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $departmentValue->name }}</label>
                    </p>
                    
                    @foreach ($departmentValue->courses as $courseKey => $course)
                        <p class="ml-6">
                            <input id="course-{{ $courseKey }}" wire:model="course" type="checkbox"
                                value="{{ $course->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="course-{{ $courseKey }}"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $course->name }}</label>
                        </p>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>

    {{-- @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
        <script>
            new TomSelect('#partylist');
        </script>
    @endpush --}}
</div>
