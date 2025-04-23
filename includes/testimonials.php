<?php
// Include testimonials data
include_once 'data/testimonials.php';
?>

<section id="testimonials" class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-24">
    <div class="flex flex-col items-center text-center">
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Testimonials</h2>
        <p class="mt-4 max-w-[85%] text-gray-600">
            Hear what other travelers have to say about their unforgettable experiences in Nepal
        </p>
    </div>
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($testimonialsData as $testimonial): ?>
            <div class="h-full rounded-lg border bg-white shadow">
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="relative h-10 w-10 overflow-hidden rounded-full">
                            <img
                                src="<?php echo htmlspecialchars($testimonial['avatar']); ?>"
                                alt="<?php echo htmlspecialchars($testimonial['name']); ?>"
                                class="object-cover w-full h-full">
                        </div>
                        <div>
                            <h3 class="text-base font-medium"><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($testimonial['location']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($testimonial['comment']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>