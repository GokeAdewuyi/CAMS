<div class="flex justify-end mt-4">
    <div class="mr-2">
        <a href="{{ route('assessments.upload') }}">
            <x-jet-button class="show-loader">
                {{ __('Upload Result') }}
            </x-jet-button>
        </a>
    </div>
    <div class="ml-2 mr-2">
        <x-jet-button wire:click="createResult()">
            {{ __('Add Result') }}
        </x-jet-button>
    </div>
</div>

@if($openResultModal)
    @include('livewire.assessments.result', ['openModal' => $openResultModal, 'assessment' => $assessment])
@endif
<div class="p-3 sm:px-5 bg-white border-b border-gray-200">
    <div class="">
        <livewire:student-assessment-table />
    </div>
</div>
