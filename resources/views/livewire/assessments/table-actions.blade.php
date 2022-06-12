@php
    $assessment = \App\Models\Assessment::find($id);
@endphp
<div class="flex space-x-1 justify-around">
    <a href="{{ route('assessments').'?a='.$assessment['id'] }}" title="Upload Result">
        <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
        </button>
    </a>
    @include('datatables::delete', ['value' => $assessment['title'], 'id' => $assessment['id']])
</div>
