<div class="flex min-h-full flex-col justify-center px-8 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="dark:text-white mt-3 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Complete your profile, {{ auth()->user()->name }}</h2>
    </div>
  
    <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm">
        <form wire:submit="update">

            {{ $this->form }}
            
            <button type="submit" wire:loading.class="bg-gray" class="flex w-full mt-5 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update and continue</button>
        
            <div wire:loading class="dark:text-white">
                Please wait...
            </div>
        </form>
        
        <x-filament-actions::modals />

    </div>

    <div class="mt-3 sm:mx-auto sm:w-full sm:max-w-sm text-center">
    
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="text-base font-semibold text-indigo-600 hover:text-indigo-700">Log Out</button>
        </form>

    </div>
</div>