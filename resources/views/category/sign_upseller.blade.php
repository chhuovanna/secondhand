



<form action="{{ url('admin\savesign_up')}}" method="post">
    @csrf
    <label>Seller:</label>
    <select name="seller_id">
        @foreach ($sellers as $seller) {
        <option value='{{ $seller->$seller_id }}'>{{ $seller->title}}</option>"
        @endforeach

    </select>
    <label>View:</label>
    <select name="sign_up_id">
        @foreach ($views as $view)
            <option value='{{$view->sign_up_id}}'>{{$view->name }}</option>
        @endforeach
    </select>
    <label>Stars:</label><input type="number" min='1' max='5' name="stars" required>
    <br>
    <button type="submit">Save</button>
</form>


