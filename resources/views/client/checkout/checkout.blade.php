<x-client-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">Checkout</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Service Information -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Service Information</h3>
                <p><strong>Service:</strong> {{ $booking->service->name }}</p>
                <p><strong>Price:</strong> €{{ number_format($booking->service->price, 2) }}</p>
            </div>

            <!-- Discount Code Input -->
            <form id="discountForm" method="POST" action="{{ route('client.applyDiscount', $booking) }}">
                @csrf
                <div class="mb-4">
                    <label for="discount_code" class="block text-sm font-medium text-gray-700">Discount Code</label>
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            id="discount_code"
                            name="discount_code"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                            placeholder="Enter discount code"
                        />
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Apply
                        </button>
                    </div>
                </div>
            </form>

            <!-- Discount Details -->
            @if(session('discount'))
                <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
                    <p><strong>Discount Applied:</strong> {{ session('discount')['code'] }}</p>
                    <p><strong>Discount Value:</strong> €{{ number_format(session('discount')['value'], 2) }}</p>
                </div>
            @endif

            <!-- Total Amount -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Total Amount</h3>
                <p>
                    <strong>Total:</strong> €
                    {{ number_format($booking->service->price - (session('discount')['value'] ?? 0), 2) }}
                </p>
            </div>

            <!-- Proceed to Payment -->
            <form method="POST" action="{{ route('client.pay', $booking) }}">
                @csrf
                <input type="hidden" name="discount_code" value="{{ session('discount')['code'] ?? '' }}">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</x-client-layout>
