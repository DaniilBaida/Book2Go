<div class="mb-3">
    <label for="name" class="form-label">Business Name</label>
    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $business->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $business->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="location" class="form-label">Location</label>
    <input type="text" name="location" class="form-control" id="location" value="{{ old('location', $business->location ?? '') }}">
</div>

<div class="mb-3">
    <label for="operating_hours" class="form-label">Operating Hours</label>
    <input type="text" name="operating_hours" class="form-control" id="operating_hours" value="{{ old('operating_hours', $business->operating_hours ?? '') }}">
</div>

<div class="mb-3">
    <label for="service_category" class="form-label">Service Category</label>
    <input type="text" name="service_category" class="form-control" id="service_category" value="{{ old('service_category', $business->service_category ?? '') }}">
</div>