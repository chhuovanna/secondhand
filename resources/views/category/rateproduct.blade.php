<form action="{{ url('admin\savecategory')}}" method="post">
    @csrf
    <label>Product:</label>
    <select name="id">
        @foreach ($products as $product) {
        <option value='{{ $product->id }}'>{{ $product->title}}</option>"
        @endforeach

    </select>
    <label>Category:</label>
    <select name="id">
        @foreach ($categorys as $category)
            <option value='{{$category->category_id}}'>{{$category->name }}</option>
        @endforeach
    </select>
    <label>Stars:</label><input type="number" min='1' max='5' name="stars" required>
    <br>
    <button type="submit">Save</button>
</form>
