@if(session()->has('message'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
         x-data="{ shown: true, timeout: null }"
         x-show.transition.out.opacity.duration.100ms="shown"
         x-transition:leave.opacity.duration.100ms
    >
        <div class="flex justify-between">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
            <div>
                <button @click="shown = false" type="button"
                        class="text-teal-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@elseif(session()->has('error'))
    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3"
         x-data="{ shown: true, timeout: null }"
         x-show.transition.out.opacity.duration.100ms="shown"
         x-transition:leave.opacity.duration.100ms
    >
        <div class="flex justify-between">
            <div>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
            <div>
                <button @click="shown = false" type="button"
                        class="text-red-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
