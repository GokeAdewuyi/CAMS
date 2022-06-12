<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('students') }}" class="float-right flex text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 text-indigo-700" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Students - ').$course['code'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @include('alert-messages')

                <div x-data="{ open: false, working: false }" x-cloak>
                    <div class="p-3 sm:px-5 bg-white border-b border-gray-200">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <x-jet-section-title>
                                <x-slot name="title">{{ __('Upload Students` Data') }}</x-slot>
                                <x-slot name="description">
                                    {{ __('Ensure the file to be uploaded correlates with the template.') }}
                                    You can download the template <a href="{{ route('students.template') }}" target="_blank" class="underline text-purple-700">Here</a>
                                </x-slot>
                            </x-jet-section-title>

                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form method="POST" enctype="multipart/form-data" wire:submit.prevent="{{ route('students.process') }}">
                                    @csrf
                                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="course">{{ __('Course') }}</label>
                                                @php $c = \App\Models\Course::find(session('current_course')) @endphp
                                                <x-jet-input type="text" readonly value="{{ $c['code'].' ('.$c->curriculum->name.')' }}" class="mt-1 block w-full" />
                                                <input type="hidden" value="{{ $c['id'] }}" name="course">
                                                @error('course') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="file">{{ __('File') }}</label>
                                                <input id="file" type="file" name="file" class="mt-1 block w-full">
                                                @error('file') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                                        <x-jet-button id="preview" type="button" class="mr-3" @click="preview(); open = true">
                                            {{ __('Preview') }}
                                        </x-jet-button>
                                        <input type="hidden" id="json_data">
                                        <x-jet-button type="submit">
                                            {{ __('Upload') }}
                                        </x-jet-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-1 justify-around">
                        <div x-show="open"
                             class="w-full fixed z-50 bottom-0 inset-x-0 px-4 pb-4 mt-5 sm:inset-0 sm:flex sm:items-start sm:justify-center">
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <div x-show="open" x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-auto shadow-xl transform transition-all">
                                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                    <button @click="open = false" type="button"
                                            class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="w-full">
                                    <div class="mt-3">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            {{ __('Students Preview') }}
                                        </h3>
                                        <div class="mt-2" id="preview-table-container">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    @endsection
    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
        <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(() => {
                const previewBtn = $('#preview')
                const excelFile = $('#file')
                previewBtn.hide()
                excelFile.on('change', (e) => {
                    const file = e.target.files[0];
                    if (file && file.type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                        const xl2json = new ExcelToJSON();
                        xl2json.parseExcel(file);
                        previewBtn.show(200);
                    } else previewBtn.hide(200)
                })
            })

            function preview() {
                initializeTable();
                let html = ''
                const data = JSON.parse($('#json_data').val())
                let i = 1
                data.forEach(cur => {
                    html += `<tr>
                                <td>${i}</td>
                                <td>${cur["firstname"] ?? ''}</td>
                                <td>${cur["lastname"] ?? ''}</td>
                                <td>${cur["othername"] ?? ''}</td>
                                <td>${cur["email"] ?? ''}</td>
                                <td>${cur["matric number"] ?? ''}</td>
                                <td>${cur["level"] ?? ''}</td>
                            </tr>`
                    i++;
                })
                $('#preview-table').html(html)
                $('#datatable').DataTable({
                    "lengthMenu": [ 5 ],
                    "pageLength": 5
                })
            }

            const ExcelToJSON = function() {
                this.parseExcel = function(file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const data = e.target.result;
                        const workbook = XLSX.read(data, {
                            type: 'binary'
                        });

                        let i = 0;
                        workbook.SheetNames.forEach(function(sheetName) {
                            // Here is your object
                            const XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                            const json_object = JSON.stringify(XL_row_object);
                            if (i === 0)
                                $( '#json_data' ).val( json_object );
                            i++
                        })
                    };

                    reader.onerror = function(ex) {
                        console.log(ex);
                    };

                    reader.readAsBinaryString(file);
                };
            };

            function initializeTable() {
                $('#preview-table-container').html(`
                    <table class="table table-bordered table-striped table-actions" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Othername</th>
                            <th>Email</th>
                            <th>Matric Number</th>
                            <th>Level</th>
                        </tr>
                        </thead>
                        <tbody id="preview-table"></tbody>
                    </table>
                `)
            }
        </script>
    @endsection
</x-app-layout>
