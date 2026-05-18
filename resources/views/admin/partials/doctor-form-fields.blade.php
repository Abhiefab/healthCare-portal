@php
    $profile = $doctor;
@endphp

<div class="form-grid">
    <label>
        <span>Name</span>
        <input name="name" value="{{ old('name', $profile?->user?->name) }}" required>
    </label>
    <label>
        <span>Email</span>
        <input type="email" name="email" value="{{ old('email', $profile?->user?->email) }}" required>
    </label>
    <label>
        <span>Title</span>
        <input name="title" value="{{ old('title', $profile?->title) }}" placeholder="Cardiologist" required>
    </label>
    <label>
        <span>Specialization</span>
        <input name="specialization" value="{{ old('specialization', $profile?->specialization) }}" required>
    </label>
    <label>
        <span>Experience Years</span>
        <input type="number" min="0" max="70" name="experience_years" value="{{ old('experience_years', $profile?->experience_years ?? 0) }}" required>
    </label>
    <label>
        <span>Rating</span>
        <input type="number" min="0" max="5" step="0.1" name="rating" value="{{ old('rating', $profile?->rating ?? 0) }}" required>
    </label>
    <label>
        <span>Reviews</span>
        <input type="number" min="0" name="review_count" value="{{ old('review_count', $profile?->review_count ?? 0) }}" required>
    </label>
    <label>
        <span>Status</span>
        <select name="status" required>
            @foreach (['Available', 'Busy', 'Offline'] as $status)
                <option value="{{ $status }}" @selected(old('status', $profile?->status ?? 'Available') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </label>
    <label>
        <span>Location</span>
        <input name="location" value="{{ old('location', $profile?->location) }}" required>
    </label>
    <label>
        <span>Image Path</span>
        <input name="image_path" value="{{ old('image_path', $profile?->image_path) }}" placeholder="images/doctors/doctor5.png">
    </label>
</div>
