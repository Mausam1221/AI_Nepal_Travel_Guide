<?php
// Include configuration file
include_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepal Travel Guide</title>
    <meta name="description" content="Explore Nepal's magnificent landscapes and cultural experiences">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rose: {
                            100: '#ffe4e6',
                            600: '#e11d48',
                            700: '#be123c',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="flex min-h-screen flex-col">
    <header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl flex h-16 items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-globe text-rose-600"></i>
                <span class="text-xl font-bold">Nepal Travel Guide</span>
            </div>
            <nav class="hidden md:flex gap-6">
                <a href="#destinations" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Destinations
                </a>
                <a href="#tips" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Travel Tips
                </a>
                <a href="#testimonials" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Testimonials
                </a>
                <a href="#contact" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Contact Us
                </a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="login.php" class="hidden md:flex px-4 py-2 text-sm border rounded-md hover:bg-gray-100">
                    Login
                </a>
                <a href="booking.php" class="px-4 py-2 text-sm text-white bg-rose-600 rounded-md hover:bg-rose-700">
                    Book Now
                </a>
            </div>
        </div>
    </header>