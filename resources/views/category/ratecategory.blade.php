



<form action="{{ url('admin\saveseller')}}" method="post">
    @csrf
    <label>Category:</label>
    <select name="id">
        @foreach ($categorys as $category) {
        <option value='{{ $category->id }}'>{{ $category->title}}</option>"
        @endforeach

    </select>
    <label>Product:</label>
    <select name="id">
        @foreach ($products as $product)
            <option value='{{$product->rid}}'>{{$product->name }}</option>
        @endforeach
    </select>
    <label>Stars:</label><input type="number" min='1' max='5' name="stars" required>
    <br>
    <button type="submit">Save</button>
</form>


