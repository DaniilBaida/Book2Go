
<form action="{{ route('client.reviews.store', $service) }}" method="POST">
    @csrf
    <label for="rating">Rating:</label>
    <select name="rating" id="rating" required>
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>

    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment"></textarea>

    <button type="submit">Submit Review</button>
</form>
