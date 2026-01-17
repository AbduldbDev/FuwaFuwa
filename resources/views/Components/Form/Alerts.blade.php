   {{-- Success Message --}}
   @if (session('success'))
       <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700">
           {{ session('success') }}
       </div>
   @endif

   {{-- Error Message --}}
   @if (session('error'))
       <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
           {{ session('error') }}
       </div>
   @endif

   {{-- Validation Errors --}}
   @if ($errors->any())
       <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
           <ul class="list-disc pl-5">
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif

   @if ($errors->any())
       <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
           <ul class="list-disc pl-5">
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
