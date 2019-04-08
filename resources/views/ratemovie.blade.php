



<form action="{{ url('admin\saverating')}}" method="post">
    @csrf
    <label>Movie:</label>
    <select name="mid">
    @foreach ($movies as $movie) {
        <option value='{{ $movie->mid }}'>{{ $movie->title}}</option>"
    @endforeach
    
    </select>
    <label>Reviewer:</label>
    <select name="rid">
    @foreach ($reviewers as $reviewer) 
        <option value='{{$reviewer->rid}}'>{{$reviewer->name }}</option>
    @endforeach
    </select>
    <label>Stars:</label><input type="number" min='1' max='5' name="stars" required>
    <br>
    <button type="submit">Save</button>
</form>


