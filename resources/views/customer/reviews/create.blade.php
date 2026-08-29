<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Write a Review — {{ $booking->hotel->name }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></li>
            <li class="breadcrumb-item active">Review</li>
        </ol>
    </nav>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Your Review</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.reviews.store', $booking) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="d-flex gap-2" id="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="rating" class="btn-check" value="{{ $i }}" id="star{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="star{{ $i }}">{{ $i }} ★</label>
                                    </div>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title <small class="text-muted">(optional)</small></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Summary of your experience">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="5" placeholder="Tell us about your stay...">{{ old('body') }}</textarea>
                            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Booking Summary</div>
                <div class="card-body small">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Hotel</dt><dd class="col-sm-7">{{ $booking->hotel->name }}</dd>
                        <dt class="col-sm-5">Booking #</dt><dd class="col-sm-7">{{ $booking->booking_number }}</dd>
                        <dt class="col-sm-5">Stay</dt><dd class="col-sm-7">{{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
