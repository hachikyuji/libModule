<x-app-layout>
      <x-slot name="header">
         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
               {{ __('Dashboard') }}
         </h2>
      </x-slot> 

   <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
      <span class="sr-only">Open sidebar</span>
      <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
      </svg>
   </button>

   <aside id="default-sidebar" class="fixed top-20 left-0 z-40 w-64 h-screen overflow-y-auto bg-white dark:bg-blue-900">
      <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-blue-900">
         <ul class="space-y-2 font-medium">
            <li>
               <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512" fill="white">
                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Home</span>
               </a>
            </li>
            <li>
               <a href="{{ route('search') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                  <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Search</span>
               </a>
            </li>
            <li>
               <a href="{{ route('queue') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="white">
                  <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Queue</span>
                  <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-red-600 dark:text-white-300">!</span>
               </a>
            </li>
            <li>
               <a href="{{ route('history') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                  <path d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65V152c0-13.3-10.7-24-24-24z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">History</span>
               </a>
            </li>
            <li>
               <a href="{{ route('admin_requests') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="white">
                  <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Requests Approval</span>
                  <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-red-600 dark:text-white-300">!</span>
               </a>
            </li>
            <li>
            @if (Route::has('register'))
               <a href="{{ route('register') }}" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" fill="white">
                  <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Create Account</span>
               </a>
               @endif
            </li>
            <li>
               <a href="{{ route('book_management') }}"  class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="white">
                  <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Book Management</span>
               </a>
            </li>
            <li>
               <form method="POST" action="{{ route('logout') }}">
               @csrf
               <button type="submit" class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-blue-700 group">
                  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white">
                     <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                  </svg>
                  <span class="flex-1 ms-3 whitespace-nowrap text-white">Log Out</span>
               </button>
               </form>
            </li>
            
         </ul>
      </div>
   </aside>


   <div class="sm:ml-64 flex items-center justify-center">
      <div class="flex flex-col items-center justify-center h-full pt-10">
               <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-600 mb-3 ml-1 pt-10">
                  Current Requests
               </h1>

         <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full md:w-full lg:w-full xl:w-full">
               <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-white uppercase bg-blue-900 dark:bg-white-700 dark:text-white-400">
                     <tr>
                           <th scope="col" class="px-6 py-3">
                              Email
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Book
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Book Status
                           </th>
                           <th scope="col" class="px-6 py-3">
                              User Fine
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Request Type
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Request Status
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Expiration Status
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Link
                           </th>
                     </tr>
                  </thead>
                     <tbody>
                        @foreach($queueRequest as $queue)
                           <tr class="bg-white border border-blue-500 dark:bg-white-800 dark:border-white-700 hover:bg-blue-50 dark:hover:bg-blue-200">
                              <td class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                    {{ $queue->email }}
                              </td>
                              <td class="px-4 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                    {{ $queue->book_request }}
                              </td>
                              <td class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                    @php
                                       $book = \App\Models\Books::where('title', $queue->book_request)->first();
                                       $status = $book ? ($book->available_copies > 0 ? 'Available' : 'Unavailable') : 'Not Found';
                                    @endphp
                                    {{ $status }}
                              </td>
                              <td class="px-12 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                              @php
                                 $finesDisplayed = false;
                              @endphp
                              @foreach($accountHistory->where('books_borrowed', $queue->book_request) as $history)
                                 @if(!$finesDisplayed && $history->email == $queue->email)
                                    {{ $history->fines }}
                                    @php
                                          $finesDisplayed = true;
                                    @endphp
                                 @endif
                              @endforeach
                              </td>
                              <td class="px-10 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue">
                                    {{ $queue->request_type }}
                              </td>
                              <td class="px-10 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue ">
                                    {{ $queue->request_status }}
                              </td>
                              <td class="px-10 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue ">
                              @php
                                 $expirationTime = Carbon\Carbon::parse($queue->expiration_time);
                                 $currentTime = now();

                                 // Check if the request is expired
                                 $isExpired = $expirationTime->isPast();
                              @endphp

                              @if($isExpired)
                                 <span class="text-red-500">Expired</span>
                              @else
                                 <span class="text-green-500">Not Expired</span>
                              @endif
                              </td>
                              <td class="px-6 py-4 font-medium text-blue-500 whitespace-nowrap dark:text-blue">
                              @if($book)
                                 <a href="{{ route('book.show', ['id' => $book->id]) }}">View</a>
                              @endif
                              </td>
                           </tr>
                     @endforeach
                     </tbody>
               </table>
         </div>
      </div>
   </div>
</x-app-layout>