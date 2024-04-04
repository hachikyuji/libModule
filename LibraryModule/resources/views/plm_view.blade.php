<x-app-layout>
      <x-slot name="header">
         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
               {{ __('Dashboard') }}
         </h2>
      </x-slot> 

   <aside id="default-sidebar" class="fixed top-20 left-0 z-40 w-64 h-screen overflow-y-auto bg-white dark:bg-blue-900">
      <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-blue-900">
         <ul class="space-y-2 font-medium">
            <li>
               <a href="{{ route('plm_library') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512" fill="white">
                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Home</span>
               </a>
            </li>
            <li>
               <a href="{{ route('plm_search') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                  <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Search</span>
               </a>
            </li>
            <li>
               <form method="GET" action="{{ route('welcome') }}">
               @csrf
               <button type="submit" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
                  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                     <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Log In</span>
               </button>
               </form>
            </li>
         </ul>
      </div>
   </aside>

   <div class="sm:ml-64 flex items-center justify-center">
      
      <div class="flex flex-col items-center justify-center h-full pt-10">
         <form action="{{ route('plm_search') }}" method="GET">
               <button type="submit" class="flex items-center justify-center mt-4 px-4 py-2 bg-blue-800 hover:bg-blue-500 text-white rounded-md shadow-md">
                     <svg class="w-6 h-6 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path fill-rule="evenodd" d="M13.729 5.575c1.304-1.074 3.27-.146 3.27 1.544v9.762c0 1.69-1.966 2.618-3.27 1.544l-5.927-4.881a2 2 0 0 1 0-3.088l5.927-4.88Z" clip-rule="evenodd"/>
                     </svg>
                     <span class="font-semibold font-bold">PLM Library</span>
               </button>
            </form>
            <h1 class="text-3xl font-bold text-blue-800 dark:text-blue-600 mb-3 ml-1">
                 PLM Library
             </h1>

             <div class="max-w-3xl w-full p-6 bg-blue-900 dark:bg-blue-900 rounded-md shadow-md text-white">
               <h2 class="text-2xl font-bold text-white-700">{{ $books->title }}</h2>
               <p class="text-lg text-white">By: {{ $books->author }}</p>

               
               <div class="mt-4">
                  <p class="text-lg font-bold text-white-700">Description:</p>
                  <p>{{ $books->edition }}</p>
                  <p>{{$books->extent}}</p>
               </div>

               <div class="mt-4">
                  <p class="text-lg text-white">
                     <span class="font-bold">Call Number:</span> {{ $books->call_number }}
                  </p>
                  <p class="text-lg text-white">
                     <span class="font-bold">Available Copies:</span> {{ $books->available_copies }} out of {{ $books->total_copies }}
                  </p>
                  <p class="text-lg text-white">
                     <span class="font-bold">Sublocation:</span> {{ $books->sublocation }}
                  </p>
               </div>
               <div class="mt-4">
                  <p class="text-lg font-bold text-white-700">Publication Info:</p>
                  <p>{{ $books->publish_date }} </p>
                  <p>{{ $books->publisher}}</p>
                  <p>ISBN: {{ $books->isbn}}</p>
               </div>

               <div class="flex flex-col items-center">
                    <div class = "flex">
                     <form method="get" action="{{ route('login')}}">
                        @csrf
                           <button type="submit" class="mt-4 p-2 bg-blue-500 hover:bg-blue-100 dark:hover:bg-blue-700 text-white rounded-md flex items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                                 <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                              </svg>
                              &nbsp;
                                 <span class="whitespace-nowrap text-white">Log In to PLM Library</span>
                           </button>
                     </form>

                  </div>

                  @if(session('success'))
                     <div class="alert alert-success">
                           {{ session('success') }}
                     </div>
                  @endif

                  @if(session('error'))
                     <div class="alert alert-danger">
                           {{ session('error') }}
                     </div>
                  @endif
               </div>
        </div>
      </div>
   </div>

   <div class="flex items-center justify-center sm:ml-64">
    <div class="max-w-3xl w-full p-6 bg-blue-900 dark:bg-blue-900 rounded-md shadow-md text-white mt-8">
        <h2 class="text-2xl font-bold text-white-700">Recommended Books</h2>

        <h3 class="text-lg text-center font-bold text-white-700 mt-4">Books by Similar Authors</h3>
        @if(count($similarAuthorsBooks) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($similarAuthorsBooks as $recommendation)
                    <div class="bg-gray-800 p-4 rounded-md">
                    <a href="{{ route('book.show', ['id' => $recommendation->id]) }}" class="text-lg font-bold text-white">{{ \Str::limit($recommendation->title, 50) }}</a>
                        <p class="text-sm text-gray-300">{{ $recommendation->author }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-300 mt-4">No books by similar authors found.</p>
        @endif

        <h3 class="text-lg text-center font-bold text-white-700 mt-4">Related Books</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($similarSublocationBooks as $recommendation)
                <div class="bg-gray-800 p-4 rounded-md">
                <a href="{{ route('book.show', ['id' => $recommendation->id]) }}" class="text-lg font-bold text-white">{{ \Str::limit($recommendation->title, 50) }}</a>
                    <p class="text-sm text-gray-300">{{ $recommendation->author }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>


    

</x-app-layout>