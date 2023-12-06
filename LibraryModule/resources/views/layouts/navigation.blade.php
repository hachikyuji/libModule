<nav x-data="{ open: false }" class="bg-white dark:bg-white-800 border-b border-white-100 dark:border-white-700 fixed w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl  flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center logo-container ml--3">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/plmLogo.png') }}" alt="PLM Logo" class="block h-20 w-auto">
            </a>
        </div>
    </div>
</nav>

<!-- Add padding to the content to avoid it being hidden behind the fixed navbar -->
<div class="pt-10">
    <!-- Your content goes here -->
</div>

<script>
    // Get the navigation bar element
    var navBar = document.querySelector('nav');

    // Set up a scroll event listener
    window.addEventListener('scroll', function () {
        // Check if the user has scrolled down, add a class to fix the navigation bar
        if (window.scrollY > 0) {
            navBar.classList.add('bg-white', 'dark:bg-white-800', 'border-b', 'border-white-100', 'dark:border-white-700', 'fixed', 'w-full', 'z-50', 'shadow-md');
        } else {
            // Remove the fixed navigation bar class
            navBar.classList.remove('bg-white', 'dark:bg-white-800', 'border-b', 'border-white-100', 'dark:border-white-700', 'fixed', 'w-full', 'z-50', 'shadow-md');
        }
    });
</script>
