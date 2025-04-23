<?php
// Include tips data
include_once 'data/tips.php';
?>

<section id="tips" class="bg-slate-50 py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="flex flex-col items-center text-center">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Travel Tips</h2>
            <p class="mt-4 max-w-[85%] text-gray-600">
                Practical advice to make your trip to Nepal smoother and more enjoyable
            </p>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($tipsData as $tip): ?>
                <div class="flex flex-col items-center text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                        <i class="<?php echo $tip['icon']; ?>"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium"><?php echo htmlspecialchars($tip['title']); ?></h3>
                    <p class="mt-2 text-sm text-gray-600"><?php echo htmlspecialchars($tip['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>