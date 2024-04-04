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

   <div class="sm:ml-48 overflow-y-auto">
        <div class="flex flex-col items-center justify-center h-full pt-10">
            <h1 class="text-2xl font-bold text-blue-800 dark:text-blue-600 mb-3 ml-1 pt-10">
                Welcome to the PLM Library!
            </h1>
        </div>
        
       <!-- Most Popular-->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full md:w-4/5 lg:w-3/4 xl:w-2/3 mx-auto">
            <h2 class="text-lg font-semibold text-blue-900 dark:text-blue-600 mb-3 ml-1 pt-3">Most Popular</h2>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-white uppercase bg-blue-900 dark:bg-white-700 dark:text-white-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Publish Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sublocation
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booksWithHighestCount as $book)
                        <tr
                            class="bg-white border border-blue-500 dark:bg-white-800 dark:border-white-700 hover:bg-blue-50 dark:hover:bg-blue-200">
                            <td class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                <a href="{{ route('plmbook.show', ['id' => $book->id]) }}" class="text-sm text-blue-500">{{ \Str::limit($book->title, 30) }}</a>
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                {{ $book->author }}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                {{ $book->publish_date }}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                {{ $book->sublocation }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
  
</x-app-layout>