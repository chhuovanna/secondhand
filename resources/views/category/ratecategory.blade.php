



<form action="{{ url('admin\saveseller')}}" method="post">
    @csrf
    <label>Category:</label>
    <select name="id">
        @foreach ($categorys as $category) {
        <option value='{{ $category->id }}'>{{ $category->title}}</option>"
        @endforeach

    </select>
    <label>Seller:</label>
    <select name="id">
        @foreach ($sellers as $seller)
            <option value='{{$seller->rid}}'>{{$seller->name }}</option>
        @endforeach
    </select>
    <label>Stars:</label><input type="number" min='1' max='5' name="stars" required>
    <br>
    <button type="submit">Save</button>
</form>


