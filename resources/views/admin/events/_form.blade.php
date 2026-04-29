<div class="space-y-5">

    {{-- Title --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">
            Event Title <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
               placeholder="e.g. Batch 2015 Alumni Homecoming"
               class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-400 @enderror">
        @error('title')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
        <textarea name="description" rows="4"
                  placeholder="Provide details about the event..."
                  class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('description') border-red-400 @enderror">{{ old('description', $event->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- Date & Time Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Event Date <span class="text-red-500">*</span>
            </label>
            <input type="date" name="event_date"
                   value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('event_date') border-red-400 @enderror">
            @error('event_date')
                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Time</label>
            <input type="time" name="event_time"
                   value="{{ old('event_time', $event->event_time ?? '') }}"
                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    {{-- Location --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Location</label>
        <div class="relative">
            <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}"
                   placeholder="e.g. University Gymnasium, Davao City"
                   class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-400 @enderror">
        </div>
        @error('location')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">
            Status <span class="text-red-500">*</span>
        </label>
        <select name="status"
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white @error('status') border-red-400 @enderror">
            @foreach(['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" {{ old('status', $event->status ?? 'upcoming') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
        @enderror
    </div>

</div>