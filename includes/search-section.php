<section class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl -mt-16 relative z-30">
    <div class="rounded-xl bg-white p-6 shadow-lg">
        <div class="w-full">
            <div class="grid w-full grid-cols-3 mb-6 border-b">
                <button class="py-2 border-b-2 border-rose-600 font-medium" id="tours-tab" onclick="switchTab('tours')">Treks & Tours</button>
                <button class="py-2" id="hotels-tab" onclick="switchTab('hotels')">Hotels</button>
                <button class="py-2" id="flights-tab" onclick="switchTab('flights')">Flights</button>
            </div>

            <div id="tours-content" class="mt-6">
                <form action="search.php" method="GET" class="grid gap-4 md:grid-cols-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Destination</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-map-pin mr-2 text-gray-500 mt-1"></i>
                            <select name="destination" class="w-full bg-transparent outline-none text-gray-500">
                                <option value="">Select destination</option>
                                <option value="kathmandu">Kathmandu</option>
                                <option value="pokhara">Pokhara</option>
                                <option value="chitwan">Chitwan</option>
                                <option value="everest">Everest Region</option>
                                <option value="annapurna">Annapurna</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Date</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-calendar mr-2 text-gray-500 mt-1"></i>
                            <input type="date" name="date" class="w-full bg-transparent outline-none text-gray-500">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Travelers</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-users mr-2 text-gray-500 mt-1"></i>
                            <select name="travelers" class="w-full bg-transparent outline-none text-gray-500">
                                <option value="">Select travelers</option>
                                <option value="1">1 Person</option>
                                <option value="2">2 People</option>
                                <option value="3">3 People</option>
                                <option value="4">4 People</option>
                                <option value="5+">5+ People</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="mt-auto h-10 bg-rose-600 text-white rounded-md hover:bg-rose-700">Search</button>
                </form>
            </div>

            <div id="hotels-content" class="mt-6 hidden">
                <form action="search.php" method="GET" class="grid gap-4 md:grid-cols-4">
                    <input type="hidden" name="type" value="hotels">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">City</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-map-pin mr-2 text-gray-500 mt-1"></i>
                            <select name="city" class="w-full bg-transparent outline-none text-gray-500">
                                <option value="">Select city</option>
                                <option value="kathmandu">Kathmandu</option>
                                <option value="pokhara">Pokhara</option>
                                <option value="chitwan">Chitwan</option>
                                <option value="nagarkot">Nagarkot</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Check-in/Check-out</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-calendar mr-2 text-gray-500 mt-1"></i>
                            <input type="text" name="dates" placeholder="Select dates" class="w-full bg-transparent outline-none text-gray-500">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Rooms & Guests</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-users mr-2 text-gray-500 mt-1"></i>
                            <select name="rooms" class="w-full bg-transparent outline-none text-gray-500">
                                <option value="">Select rooms</option>
                                <option value="1-1">1 Room, 1 Guest</option>
                                <option value="1-2">1 Room, 2 Guests</option>
                                <option value="2-2">2 Rooms, 2 Guests</option>
                                <option value="2-4">2 Rooms, 4 Guests</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="mt-auto h-10 bg-rose-600 text-white rounded-md hover:bg-rose-700">Search</button>
                </form>
            </div>

            <div id="flights-content" class="mt-6 hidden">
                <form action="search.php" method="GET" class="grid gap-4 md:grid-cols-4">
                    <input type="hidden" name="type" value="flights">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Departure</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-plane-departure mr-2 text-gray-500 mt-1"></i>
                            <input type="text" name="departure" placeholder="Select city" class="w-full bg-transparent outline-none text-gray-500">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Destination</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-map-pin mr-2 text-gray-500 mt-1"></i>
                            <select name="destination" class="w-full bg-transparent outline-none text-gray-500">
                                <option value="">Select city</option>
                                <option value="kathmandu">Kathmandu</option>
                                <option value="pokhara">Pokhara</option>
                                <option value="lukla">Lukla</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Date</label>
                        <div class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                            <i class="fa-solid fa-calendar mr-2 text-gray-500 mt-1"></i>
                            <input type="date" name="date" class="w-full bg-transparent outline-none text-gray-500">
                        </div>
                    </div>
                    <button type="submit" class="mt-auto h-10 bg-rose-600 text-white rounded-md hover:bg-rose-700">Search</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function switchTab(tabName) {
        // Hide all content
        document.getElementById('tours-content').classList.add('hidden');
        document.getElementById('hotels-content').classList.add('hidden');
        document.getElementById('flights-content').classList.add('hidden');

        // Remove active class from all tabs
        document.getElementById('tours-tab').classList.remove('border-b-2', 'border-rose-600');
        document.getElementById('hotels-tab').classList.remove('border-b-2', 'border-rose-600');
        document.getElementById('flights-tab').classList.remove('border-b-2', 'border-rose-600');

        // Show selected content and activate tab
        document.getElementById(tabName + '-content').classList.remove('hidden');
        document.getElementById(tabName + '-tab').classList.add('border-b-2', 'border-rose-600');
    }
</script>