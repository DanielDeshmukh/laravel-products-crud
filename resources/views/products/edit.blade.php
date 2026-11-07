<h1>Edit product</h1>

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <input name="name" value="{{ old('name', $product->name) }}">
    @error('name') <div>{{ $message }}</div> @enderror

    <input name="price" value="{{ old('price', $product->price) }}">
    @error('price') <div>{{ $message }}</div> @enderror

    <button>Update</button>
</form>