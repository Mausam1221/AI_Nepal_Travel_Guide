<section id="contact" class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-24">
    <div class="grid gap-12 md:grid-cols-2">
        <div>
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Contact Us</h2>
            <p class="mt-4 text-gray-600">
                If you have any questions or need a customized travel plan, please feel free to contact us
            </p>
            <div class="mt-8 space-y-4">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-map-pin h-5 w-5 text-rose-600"></i>
                    <p>Thamel, Kathmandu, Nepal</p>
                </div>
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-phone h-5 w-5 text-rose-600"></i>
                    <p>+977 1 4123456</p>
                </div>
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-envelope h-5 w-5 text-rose-600"></i>
                    <p>info@nepaltravel.com</p>
                </div>
            </div>
        </div>
        <form action="process/contact.php" method="POST" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-sm font-medium">Name</label>
                    <input
                        type="text"
                        name="name"
                        class="h-10 w-full rounded-md border px-3 py-2 text-sm"
                        required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="h-10 w-full rounded-md border px-3 py-2 text-sm"
                        required />
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium">Subject</label>
                <input
                    type="text"
                    name="subject"
                    class="h-10 w-full rounded-md border px-3 py-2 text-sm"
                    required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium">Message</label>
                <textarea
                    name="message"
                    class="min-h-[120px] w-full rounded-md border px-3 py-2 text-sm"
                    required></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">
                Send Message
            </button>
        </form>
    </div>
</section>