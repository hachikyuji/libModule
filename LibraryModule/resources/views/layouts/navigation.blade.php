<nav x-data="{ open: false }" class="bg-white dark:bg-white-800 border-b border-white-100 dark:border-white-700 fixed w-full z-50">
    <div class="max-w-7xl flex justify-between items-center h-20">
        <div class="flex-shrink-0 flex items-center logo-container ml--3">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/plmLogo.png') }}" alt="PLM Logo" class="block h-20 w-auto">
            </a>
        </div>

        <div class="flex items-center ml-auto">
            
        </div>

        @auth
        <div class="flex items-center ml-auto"> 
            <div class="flex flex-col items-end"> 
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ Auth::user()->name }}</span>
                <span class="mr-4 text-gray-600 dark:text-gray-500 text-sm">Account Type: {{ Auth::user()->account_type }}</span>
            </div>
        </div>
        @endauth
    </div>
</nav>

<div class="pt-10">

</div>

@push('scripts')
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
@endpush
