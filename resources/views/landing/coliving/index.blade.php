@extends('layouts.landing')

@section('title', 'Coliving Rooms')

@section('content')

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-orange-50 to-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Find Your Perfect Room</h1>
                <p class="text-xl text-gray-600">Comfortable, affordable, and fully equipped coliving spaces</p>
            </div>

            {{-- Search & Filter Section --}}
            <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-xl p-8" data-aos="fade-up" data-aos-delay="100">
                <form action="{{ route('coliving.index') }}" method="GET" id="filterForm">
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-orange-500 mr-1"></i>Check-in
                            </label>
                            <input type="date" name="check_in" id="check_in" value="{{ request('check_in') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-check text-orange-500 mr-1"></i>Check-out
                            </label>
                            <input type="date" name="check_out" id="check_out" value="{{ request('check_out') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-bed text-orange-500 mr-1"></i>Room Type
                            </label>
                            <select name="room_type"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                <option value="">All Types</option>
                                @foreach ($roomTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('room_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign text-orange-500 mr-1"></i>Max Price
                            </label>
                            <select name="max_price"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                <option value="">Any Price</option>
                                <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>Under 500K
                                </option>
                                <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>Under 1M
                                </option>
                                <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>Under 2M
                                </option>
                                <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>Under 3M
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-orange-500 text-white px-6 py-4 rounded-xl font-bold hover:bg-orange-600 transition-colors">
                            <i class="fas fa-search mr-2"></i>Search Rooms
                        </button>
                        <a href="{{ route('coliving.index') }}"
                            class="px-6 py-4 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Results Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">
                    Available Rooms
                    <span class="text-orange-500">({{ $rooms->total() }})</span>
                </h2>
                <div class="flex gap-2 items-center">
                    <label class="text-sm text-gray-600">Sort by:</label>
                    <select onchange="window.location.href=this.value"
                        class="px-4 py-2 rounded-lg border border-gray-300 focus:border-orange-500 outline-none">
                        <option
                            value="{{ route('coliving.index', array_merge(request()->all(), ['sort_by' => 'price_per_night', 'sort_order' => 'asc'])) }}"
                            {{ request('sort_by') == 'price_per_night' && request('sort_order') == 'asc' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option
                            value="{{ route('coliving.index', array_merge(request()->all(), ['sort_by' => 'price_per_night', 'sort_order' => 'desc'])) }}"
                            {{ request('sort_by') == 'price_per_night' && request('sort_order') == 'desc' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option
                            value="{{ route('coliving.index', array_merge(request()->all(), ['sort_by' => 'capacity', 'sort_order' => 'desc'])) }}"
                            {{ request('sort_by') == 'capacity' ? 'selected' : '' }}>
                            Capacity
                        </option>
                    </select>
                </div>
            </div>

            @if ($rooms->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($rooms as $room)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div
                                class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl h-full flex flex-col">
                                @if ($room->thumbnail)
                                    <div class="relative overflow-hidden h-64">
                                        <img src="{{ Storage::url($room->thumbnail) }}" alt="{{ $room->name }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute top-4 left-4">
                                            <span
                                                class="bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                                {{ ucfirst($room->room_type) }}
                                            </span>
                                        </div>
                                        @if ($room->is_available)
                                            <div class="absolute top-4 right-4">
                                                <span
                                                    class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Available</span>
                                            </div>
                                        @else
                                            <div class="absolute top-4 right-4">
                                                <span
                                                    class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Not
                                                    Available</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $room->name }}</h3>
                                    {{-- Short Description --}}
                                    @if (!empty($room->short_description))
                                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                            {{ $room->short_description }}
                                        </p>
                                    @endif
                                    <div class="grid grid-cols-3 gap-4 py-4 border-t border-b border-gray-100 mb-4">
                                        <div class="text-center">
                                            <i class="fas fa-bed text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->beds_count }} Bed</span>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-users text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->capacity }} Guest</span>
                                        </div>
                                        @if ($room->room_size)
                                            <div class="text-center">
                                                <i class="fas fa-ruler-combined text-orange-500 text-lg mb-1 block"></i>
                                                <span class="text-sm text-gray-600">{{ $room->room_size }}m²</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <div class="text-3xl font-extrabold text-orange-500">
                                                    Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                                                </div>
                                                <span class="text-sm text-gray-500">/ night</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('coliving.show', $room->id) }}"
                                            class="block w-full text-center bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                                            View Details & Book
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $rooms->appends(request()->all())->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <i class="fas fa-bed text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Rooms Found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your filters to find available rooms.</p>
                    <a href="{{ route('coliving.index') }}"
                        class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-600 transition-colors">
                        View All Rooms
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Set minimum dates
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');

            if (checkIn) {
                checkIn.setAttribute('min', today);
                checkIn.addEventListener('change', function() {
                    if (checkOut) {
                        checkOut.setAttribute('min', this.value);
                    }
                });
            }

            if (checkOut) {
                checkOut.setAttribute('min', today);
            }
        });
    </script>
@endsection
