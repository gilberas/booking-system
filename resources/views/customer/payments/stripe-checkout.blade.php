<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Pay with Card — {{ $booking->booking_number }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.payments.index', $booking) }}">Payment</a></li>
            <li class="breadcrumb-item active">Stripe</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Card Details</div>
                <div class="card-body">
                    <form id="payment-form">
                        @csrf
                        <div id="payment-element" class="mb-3"></div>
                        <div id="error-message" class="alert alert-danger d-none"></div>
                        <button id="submit-btn" class="btn btn-primary w-100">
                            <span id="btn-text">Pay ${{ number_format($due, 2) }}</span>
                            <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Payment Summary</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-6">Booking</dt><dd class="col-sm-6">{{ $booking->booking_number }}</dd>
                        <dt class="col-sm-6">Total</dt><dd class="col-sm-6">${{ number_format($booking->total_amount, 2) }}</dd>
                        <dt class="col-sm-6">Paid</dt><dd class="col-sm-6 text-success">${{ number_format($booking->paid_amount, 2) }}</dd>
                        <hr>
                        <dt class="col-sm-6 fw-bold">Due Now</dt><dd class="col-sm-6 fw-bold text-primary">${{ number_format($due, 2) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements({
            clientSecret: '{{ $intent->client_secret }}',
            appearance: { theme: 'stripe' },
        });

        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const errorMsg = document.getElementById('error-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            btnText.textContent = 'Processing...';
            btnSpinner.classList.remove('d-none');
            errorMsg.classList.add('d-none');

            const { error, paymentIntent } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('customer.payments.confirm', ['booking' => $booking, 'payment_intent' => $intent->id, 'redirect_status' => 'succeeded']) }}',
                },
                redirect: 'if_required',
            });

            if (error) {
                errorMsg.textContent = error.message;
                errorMsg.classList.remove('d-none');
                submitBtn.disabled = false;
                btnText.textContent = 'Pay ${{ number_format($due, 2) }}';
                btnSpinner.classList.add('d-none');
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                window.location.href = '{{ route('customer.payments.confirm', ['booking' => $booking, 'redirect_status' => 'succeeded']) }}&payment_intent=' + paymentIntent.id;
            }
        });
    </script>
    @endpush
</x-app-layout>
