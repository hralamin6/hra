
<div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">
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
                <div class="relative" @click="theme = (theme === 'light') ? 'dark' : 'light'">
                    <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none" aria-label="Toggle theme">
                        <!-- Light mode toggle icon -->
                        <svg x-show="theme=='dark'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                        <svg x-show="theme=='light'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
</nav>
    <div x-data="{
  items: [
    { image: 'https://via.placeholder.com/600x400?text=Slide+1', caption: 'Caption 1' },
    { image: 'https://via.placeholder.com/600x400?text=Slide+2', caption: 'Caption 2' },
    { image: 'https://via.placeholder.com/600x400?text=Slide+3', caption: 'Caption 3' },
    { image: 'https://via.placeholder.com/600x400?text=Slide+4', caption: 'Caption 4' }
  ],
  activeIndex: 0,
  isPlaying: true,
  playInterval: null,
  goTo(index) {
    this.activeIndex = index;
  },
  next() {
    if (this.activeIndex === this.items.length - 1) {
      this.activeIndex = 0;
    } else {
      this.activeIndex++;
    }
  },
  prev() {
    if (this.activeIndex === 0) {
      this.activeIndex = this.items.length - 1;
    } else {
      this.activeIndex--;
    }
  },
  play() {
    this.isPlaying = true;
    this.playInterval = setInterval(() => {
      this.next();
    }, 1000);
  },
  pause() {
    this.isPlaying = false;
    clearInterval(this.playInterval);
  }
}" x-init="play()" class="relative">
        <div class="overflow-hidden rounded-lg max-w-5xl mx-auto z-10">
            <div class="relative" x-ref="slider">
                <div class="flex transition-transform duration-300 ease-in-out" :style="'transform: translateX(-' + (activeIndex * 100) + '%)'">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="w-full h-64 sm:h-96 lg:h-128 flex-shrink-0">
                            <img class="object-cover w-full h-full" :src="item.image" :alt="'Slide ' + (index + 1)">
                        </div>
                    </template>
                </div>
            </div>

            <div class="absolute inset-y-0 right-0 flex items-center">
                <button class="h-12 w-12 rounded-full bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 focus:outline-none" x-on:click="next()">
                    <svg class="h-8 w-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.707 2.293a1 1 0 010 1.414L6.414 8H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 01-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="absolute inset-y-0 left-0 flex items-center">
                <button class="h-12 w-12 rounded-full bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 focus:outline-none" x-on:click="prev()">
                    <svg class="h-8 w-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.293 17.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 111.414 1.414L4.414 10H15a1 1 0 110 2H4.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="absolute inset-x-0 bottom-0 flex justify-center mb-4">
                <template x-for="(item, index) in items" :key="index">
                    <button class="h-4 w-4 rounded-full bg-gray-400 mr-2 hover:bg-gray-500 focus:outline-none transition-colors duration-300" :class="{'bg-gray-500': activeIndex === index}" x-on:click="goTo(index)"></button>
                </template>
            </div>

            <div class="absolute inset-x-0 bottom-0 flex justify-center items-center mb-4">
                <button class="h-6 w-6 rounded-full bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 focus:outline-none" x-on:click="isPlaying ? pause() : play()">
                    <svg x-show="!isPlaying" class="h-4 w-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7M7 5l7 7m0 0l-7 7" />
                    </svg>
                    <svg x-show="isPlaying" class="h-4 w-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h4v12H4zm16 0h-4v12h4V6z" />
                    </svg>
                </button>
            </div>
        </div>

{{--        <div class="max-w-5xl mx-auto mt-4 absolute inset-0 z-20">--}}
{{--            <p class="text-center"><span class="text-3xl bg-gray-400 text-white p-4 shadow-2xl rounded-md" x-text="items[activeIndex].caption"></span></p>--}}
{{--        </div>--}}
    </div>

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
    <section class="bg-white dark:bg-gray-800">
        <div class="container px-6 py-8 mx-auto">
            <h2 class="text-2xl font-medium text-gray-800 dark:text-white mb-4">Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Square Pharmaceuticals Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Square Pharmaceuticals Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Incepta Pharmaceuticals Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Incepta Pharmaceuticals Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Opsonin Pharma Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Opsonin Pharma Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Eskayef Bangladesh Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Eskayef Bangladesh Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Beximco Pharmaceuticals Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Beximco Pharmaceuticals Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Renata Limited</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Renata Limited.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Incepta Vaccine Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Incepta Vaccine Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">General Pharmaceuticals Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from General Pharmaceuticals Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Globe Pharmaceuticals Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Globe Pharmaceuticals Ltd.</p>
                </a>
                <a href="#" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md p-4 transition-colors duration-300">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Aristopharma Ltd.</h3>
                    <p class="text-gray-600 dark:text-gray-400">Medicines from Aristopharma Ltd.</p>
                </a>
            </div>
        </div>
    </section>


    <section class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-8 md:py-12">
            <h2 class="text-2xl font-bold mb-8">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">ACI Limited</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Beximco Pharmaceuticals Ltd.</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Eskayef Bangladesh Ltd.</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Incepta Pharmaceuticals Ltd.</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Opsonin Pharma Limited</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Radiant Pharmaceuticals Limited</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Renata Limited</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Square Pharmaceuticals Ltd.</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">The ACME Laboratories Ltd.</a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-full text-sm flex items-center justify-center transition-colors duration-300 ease-in-out">Ziska Pharmaceuticals Ltd.</a>
            </div>
        </div>
    </section>
    <div class="bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-white text-2xl font-bold mb-4">Medicine group</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Advil</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Tylenol</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Aspirin</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Aleve</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Benadryl</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Claritin</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Zyrtec</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Nexium</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Pepcid</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-300 ease-in-out">Zantac</a>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Medicine Categories
            </h2>
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:gap-x-8">
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Pain Relief
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Browse our selection of pain relief medications.
                    </p>
                </a>
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Allergy & Sinus
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Find relief from allergy and sinus symptoms.
                    </p>
                </a>
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Digestive Health
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Improve your digestive health with our selection of medications.
                    </p>
                </a>
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Vitamins & Supplements
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Keep your body healthy with our selection of vitamins and supplements.
                    </p>
                </a>
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Women's Health
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Find products to support women's health needs.
                    </p>
                </a>
                <a href="#" class="group">
                    <div class="w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden bg-gray-700 group-hover:opacity-75">
                        <img src="https://dummyimage.com/500x700" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-4 text-base font-medium text-white">
                        Cold & Flu
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Find relief from cold and flu symptoms.
                    </p>
                </a>
            </div>
        </div>
    </div>
<!-- Footer section -->
<footer class="bg-white dark:bg-gray-800">
    <div class="container mx-auto px-6 py-4">
        <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Copyright &copy; 2023
            Pharmacy Website - All rights reserved.</p>
    </div>
</footer>
    @push('js')
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
    @endpush
</div>
