<section class="bg-rose-600 py-24 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="flex flex-col items-center text-center">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Subscribe to Our Travel Updates</h2>
            <p class="mt-4 max-w-[85%]">Get the latest travel deals, destination guides, and travel inspiration</p>
        </div>
        <form action="process/subscribe.php" method="POST" class="mt-8 flex justify-center">
            <div class="flex w-full max-w-md flex-col sm:flex-row items-center justify-center gap-2">
                <input
                    type="email"
                    name="email"
                    placeholder="Your email address"
                    class="h-10 w-full rounded-md border border-white bg-white px-3 py-2 text-sm text-black"
                    required />
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-white text-rose-600 rounded-md hover:bg-white/90">
                    Subscribe
                </button>
            </div>
        </form>
    </div>
</section>