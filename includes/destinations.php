<?php
// Include destinations data
include_once 'data/destinations.php';
?>

<section id="destinations" class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-24">
    <div class="flex flex-col items-center text-center">
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Popular Destinations</h2>
        <p class="mt-4 max-w-[85%] text-gray-600">
            Explore Nepal's most popular tourist attractions, from ancient temples to natural wonders
        </p>
    </div>
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($destinationsData as $destination): ?>
            <div class="overflow-hidden rounded-lg border bg-white shadow">
                <div class="relative h-48">
                    <img
                        src="<?php echo htmlspecialchars($destination['image']); ?>"
                        alt="<?php echo htmlspecialchars($destination['name']); ?>"
                        class="object-cover w-full h-full">
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-medium"><?php echo htmlspecialchars($destination['name']); ?></h3>
                    <p class="mt-2 text-sm text-gray-600"><?php echo htmlspecialchars($destination['description']); ?></p>
                </div>
                <div class="px-6 pb-6">
                    <a href="destination.php?id=<?php echo htmlspecialchars($destination['id']); ?>" class="w-full inline-block text-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                        View Details
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-12 flex justify-center">
        <a href="destinations.php" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
            View More Destinations
        </a>
    </div>
</section>