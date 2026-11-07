<h1>Add product</h1>

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <input name="name" placeholder="Name" value="{{ old('name') }}">
    @error('name') <div>{{ $message }}</div> @enderror

    <input name="price" placeholder="Price" value="{{ old('price') }}">
    @error('price') <div>{{ $message }}</div> @enderror

    <button>Save</button>
</form>