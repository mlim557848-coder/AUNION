@extends('admin.layout')
@section('page-title', 'Create Event')
@section('page-subtitle', 'Add a new alumni event')
@section('title', 'Create Event')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.events.index') }}"
           class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-500 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Event</h1>
            <p class="text-sm text-gray-500 mt-0.5">Fill in the details for the new alumni event</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            @include('admin.events._form')

            <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                <a href="{{ route('admin.events.index') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-plus mr-1.5"></i> Create Event
                </button>
            </div>
        </form>
    </div>

</div>
@endsection