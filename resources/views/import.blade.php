<form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
    @csrf
    <p>Staff</p>
    <input type="file" name="file">
    <button type="submit">Export to Database</button>
</form>

<form method="POST" action="{{ route('importDealer') }}" enctype="multipart/form-data">
    @csrf
    <p>Dealer</p>
    <input type="file" name="file">
    <button type="submit">Export to Database</button>
</form>

<form method="POST" action="{{ route('importSpec') }}" enctype="multipart/form-data">
    @csrf
    <p>Spec</p>
    <input type="file" name="file">
    <button type="submit">Export to Database</button>
</form>