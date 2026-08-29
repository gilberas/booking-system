<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center p-4">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Welcome') }}</h5>
                    <p class="card-text text-muted">{{ __('You are logged in!') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
