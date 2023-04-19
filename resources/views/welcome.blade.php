<!DOCTYPE html>
<html lang="en" x-data="{dark: $persist(true)}" :class="{'dark': dark}" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pharmacy Website</title>
    <!-- Load Tailwind CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.4/dist/tailwind.min.css" />
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">
<!-- Navigation -->
<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="hidden md:flex">
                <a href="/" class="text-xl font-bold text-gray-800 dark:text-white hover:text-gray-700 dark:hover:text-gray-300">Pharmacy Website</a>
            </div>
            <div class="flex items-center justify-end md:flex-1">
                <a href="#" class="text-gray-600 dark:text-gray-400 mx-4 hover:text-gray-800 dark:hover:text-white">Home</a>
                <a href="#" class="text-gray-600 dark:text-gray-400 mx-4 hover:text-gray-800 dark:hover:text-white">Shop</a>
                <a href="#" class="text-gray-600 dark:text-gray-400 mx-4 hover:text-gray-800 dark:hover:text-white">About</a>
                <a href="#" class="text-gray-600 dark:text-gray-400 mx-4 hover:text-gray-800 dark:hover:text-white">Contact</a>
                <a href="#" class="text-gray-600 dark:text-gray-400 mx-4 hover:text-gray-800 dark:hover:text-white">Login</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero section -->
<section class="bg-blue-500 dark:bg-blue-900 py-20">
    <div class="container mx-auto px-6 md:flex md:justify-between items-center">
        <div class="md:w-1/2">
            <h1 class="text-4xl font-bold text-white leading-tight mb-6">Buy Your Medicines Online From Our Pharmacy</h1>
            <p class="text-gray-200 text-xl mb-8">We provide high quality medicines at affordable prices. Get your prescription filled today!</p>
            <button class="bg-white text-blue-500 py-2 px-10 rounded-full shadow-lg uppercase tracking-wider font-semibold text-sm hover:bg-gray-100 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Shop Now</button>
        </div>
        <div class="md:w-1/2">
            <img src="https://images.unsplash.com/photo-1601752224087-e2fd0d0f164e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Pharmacy" class="w-full rounded-lg shadow-md" />
        </div>
    </div>
</section>

<!-- Services section -->
<section class="bg-white dark:bg-gray-800 py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Our Services</h2>
        <div class="flex flex-wrap justify-center">
            <div class="max-w-xs w-full lg:max-w-sm bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-6 m-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Free Shipping</h3>
                <p class="text-gray-600 dark:text-gray-400">We ship your orders for free, so you can save money on shipping and get your medicines delivered to your doorsteps.</p>
            </div>
            <div class="max-w-xs w-full lg:max-w-sm bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md p-6 m-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">24/7 Customer Service</h3>
                <p class="text-gray-600 dark:text-gray-400">Our customer service team is available 24/7 to assist you with any questions or concerns you may have</p>
            </div>
        </div>
    </div>
</section>
        <!-- Contact section -->
        <section class="bg-gray-100 dark:bg-gray-800 py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Contact Us</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col justify-center">
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Send us a message</h3>
                            <form action="#" method="POST">
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Name</label>
                                    <input type="text" id="name" name="name" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent dark:bg-gray-900 dark:text-white" required />
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                                    <input type="email" id="email" name="email" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent dark:bg-gray-900 dark:text-white" required />
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Message</label>
                                    <textarea id="message" name="message" class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent dark:bg-gray-900 dark:text-white" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Send Message</button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Visit us</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">123 Main St<br />New York, NY 12345</p>
                            <a href="#" class="text-blue-500 hover:text-blue-600 underline">Get directions</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer section -->
        <footer class="bg-white dark:bg-gray-800">
            <div class="container mx-auto px-6 py-4">
                <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Copyright &copy; 2023
                    Pharmacy Website - All rights reserved.</p>
            </div>
        </footer>

        <!-- Dark Mode Toggle using Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.7.3/dist/alpine.js"></script>
        <script>
            function setTheme(theme) {
                document.documentElement.className = theme;
                localStorage.setItem("theme", theme);
            }

            let savedTheme = localStorage.getItem("theme");
            if (savedTheme === "dark") {
                setTheme("dark");
            }

            window.toggleTheme = function() {
                if (document.documentElement.classList.contains("dark")) {
                    setTheme("light");
                } else {
                    setTheme("dark");
                }
            };
        </script>
<button @click="theme = (theme === 'light') ? 'dark' : 'light'" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
    Toggle Dark Mode
</button>
</body>
</html>
