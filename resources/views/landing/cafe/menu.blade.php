@extends('layouts.landing')

@section('title', 'Our Menu')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-amber-50 to-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center" data-aos="fade-up">
            {{-- Optional: Icon kecil di atas --}}
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <i class="fas fa-book-open text-amber-600 text-2xl"></i>
            </div>

            <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Browse Our Menu</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our delicious selection of handcrafted beverages and meals made with passion.
            </p>
        </div>
    </div>
</section>

<!-- Menu Sections -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <!-- BVRG - COFFEE -->
        <div class="mb-20" data-aos="fade-up">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-coffee text-amber-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">COFFEE</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Classic Coffee -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/classic-coffee.jpg') }}"
                             alt="Classic Coffee"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Classic Coffee</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp35.000 - Rp48.000</p>
                        <p class="text-sm text-gray-600 mb-4">Find your perfect coffee</p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/classic-coffee_73b520ee-e48c-48f7-b980-66bb5dc99ded"
                           target="_blank"
                           class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Espresso -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/espresso.jpg') }}"
                             alt="Espresso"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Espresso</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp30.000</p>
                        <p class="text-sm text-gray-600 mb-4">Double shots of espresso.</p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/espresso_21e96a55-73bb-4a44-be73-e6c15996375c"
                           target="_blank"
                           class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Variant Latte -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/variant-latte.jpg') }}"
                             alt="Variant Latte"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Variant Latte</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp43.000 - Rp45.000</p>
                        <p class="text-sm text-gray-600 mb-4">Pick your favorite latte flavor.</p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/variant-latte_3d9f9ac4-efb8-4b10-85c3-54ee19777669"
                           target="_blank"
                           class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- BVRG - MOCKTAILS -->
        <div class="mb-20" data-aos="fade-up">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-cocktail text-pink-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">MOCKTAILS</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Amour Blanc -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/amour-blanc.jpg') }}" alt="Amour Blanc" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Amour Blanc</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Light red fruit notes with a touch of citrus and soft fizz. Simple, calming, and effortlessly charming.
                            <br><br>
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/amour-blanc_97fbda19-9805-4e80-b7c0-2996d77d14d0"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Marina De Luxe -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/marina-de-luxe.jpg') }}" alt="Marina De Luxe" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Marina De Luxe</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A refreshing blend of tropical fruits with a crisp citrus finish. Bright, juicy, and perfect for cooling down any moment.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/marina-de-luxe_13e3ade4-c446-4205-9988-1144705bdf0e"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Ocean Bleu -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/ocean-bleu.jpg') }}" alt="Ocean Bleu" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Ocean Bleu</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Cool blue citrus flavors with a hint of sweetness and gentle bubbles. Fresh, vibrant, and as relaxing as a sea breeze.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/ocean-bleu_e614a97e-1b5a-498e-a61a-12623eb25535?tableId=0ae01522-95af-1a1b-8197-35adf5b9267c"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Sauvage -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/sauvage.jpg') }}" alt="Sauvage" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Sauvage</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp45.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Bold citrus notes mixed with light herbal tones and sparkling freshness. Wild, refreshing, and full of character.
                        </p>
                        <a href="#"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Spice Delight -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/spice-delight.jpg') }}" alt="Spice Delight" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Spice Delight</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A refreshing fruit-based drink layered with warm spices and a gentle kick. One sip, and you're wrapped in comfort with a bold twist.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/spice-delight_749d4de6-a04b-4ffc-9fbd-83d84e08f661?tableId=0ae01522-95af-1a1b-8197-35adf5b9267c"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Vive la Lutte -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/vive-la-lutte.jpg') }}" alt="Vive la Lutte" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Vive la Lutte</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A bold blend of fruit with a playful edge. Deep, slightly rebellious, and lifted by sparkling clarity. For those who toast to boldness.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/vive-la-lutte_522573e8-5652-49b3-aab5-d5a3c767de2e?tableId=0ae01522-95af-1a1b-8197-35adf5b9267c"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- BVRG - NON COFFEE -->
        <div class="mb-20" data-aos="fade-up">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-glass-whiskey text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">NON COFFEE</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Chocolate -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/chocolate.jpg') }}" alt="Chocolate" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Chocolate</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000 - Rp45.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Rich and creamy chocolate drink with a smooth texture and comforting sweetness. A timeless favorite for any mood.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/chocolate_e1b48806-a647-4d2c-af6a-e3e177f41c62"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Creamy Series -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/creamy-series.jpg') }}" alt="Creamy Series" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Creamy Series</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000 - Rp48.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A collection of smooth and creamy blended drinks with rich flavors and silky finish. Indulgent and satisfying.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/creamy-series_73790973-89ac-45ac-ab24-2743ace724d4"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Matcha Latte -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/matcha-latte.jpg') }}" alt="Matcha Latte" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Matcha Latte</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Premium matcha blended with fresh milk for a soft, earthy taste and gentle sweetness. Calm and refreshing.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/matcha-latte_707576dc-740f-486a-bed2-0823d1bb37c5"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Mineral Water -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/mineral-water.jpg') }}" alt="Mineral Water" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Mineral Water</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp20.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Pure and refreshing mineral water to keep you hydrated anytime.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/mineral-water_d418eae8-09e0-42d6-9c50-7bd6f00ab54b"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Pink Lady -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/pink-lady.jpg') }}" alt="Pink Lady" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pink Lady</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A sweet and refreshing strawberry-based drink with creamy notes and a soft fruity aroma.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/pink-lady_8d8938b6-7e49-42c4-b42c-63133c897d5b"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

                <!-- Signature Tea -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/signature-tea.jpg') }}" alt="Signature Tea" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Signature Tea</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp28.000 - Rp33.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            House-blend tea with a balanced aroma and smooth taste. Light, refreshing, and easy to enjoy.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/signature-tea_821084dd-aebe-4d72-802f-0e791b13f039"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>

            </div>
        </div>


        <!-- FOOD -->
        <div class="mb-20" data-aos="fade-up">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-utensils text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">FOOD</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Brunch -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/brunch.jpg') }}" alt="Brunch" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Brunch</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp58.000 - Rp75.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            A hearty selection of light meals perfect for late mornings and relaxed afternoons.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/brunch_57a43cbc-8f2d-4939-a5f5-cf786a1a43f8"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Dessert -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/dessert.jpg') }}" alt="Dessert" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Dessert</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp28.000 - Rp45.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Sweet treats to complete your meal, from light pastries to rich and indulgent cakes.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/dessert_95c86376-ce9e-42a8-9281-75ebfd6b4c30"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Fingers -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/fingers.jpg') }}" alt="Fingers" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Fingers</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp38.000 - Rp42.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Bite-sized snacks, crispy and flavorful. Perfect to share or enjoy on your own.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/fingers_a3a9a235-2ba6-4826-bd5d-0e8b7e174663"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Mains -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/mains.jpg') }}" alt="Mains" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Mains</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp59.000 - Rp95.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Our main course selection, crafted to be satisfying, rich in flavor, and beautifully presented.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/mains_90ca445a-c70f-41c3-bc96-00c1679b0113"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Pasta Fettuccini -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/pasta-fettuccini.jpg') }}" alt="Pasta Fettuccini" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pasta Fettuccini</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp57.000 - Rp68.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Flat ribbon pasta served with creamy and savory sauces for a smooth, comforting taste.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/pasta-fettuccini_6fd7c457-b0c4-475f-90b8-1f35c5d0d3d9"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
                <!-- Pasta Spaghetti -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">
                    <div class="relative h-64">
                        <img src="{{ asset('images/menu/items/pasta-spaghetti.jpg') }}" alt="Pasta Spaghetti" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pasta Spaghetti</h3>
                        <p class="text-amber-600 font-bold text-lg mb-2">Rp57.000 - Rp68.000</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Classic spaghetti paired with rich sauces and fresh ingredients for a timeless Italian favorite.
                        </p>
                        <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d/products/pasta-spaghetti_63f664f4-56be-4088-97a3-35e1ba0b9b26"
                        target="_blank"
                        class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition-all">
                            Buy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Call to Action -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center" data-aos="fade-up">
        <div class="max-w-3xl mx-auto">
            <i class="fas fa-shopping-cart text-5xl text-orange-500 mb-6"></i>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Ready to Order?
            </h2>
            <p class="text-gray-600 text-lg mb-8">
                Order online for pickup or delivery. Get your favorites delivered right to your door!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://fountainheadcafe.mygostore.com/outlets/0aa08506-7c0d-17b9-817c-179f84fb009d"
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2 bg-orange-500 text-white px-8 py-4 rounded-full font-semibold shadow-lg hover:bg-orange-600 transition-all hover:scale-105">
                    <i class="fas fa-shopping-bag"></i>
                    Order Online
                </a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white text-orange-500 border-2 border-orange-500 px-8 py-4 rounded-full font-semibold hover:bg-orange-50 transition-all">
                    <i class="fas fa-phone"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
