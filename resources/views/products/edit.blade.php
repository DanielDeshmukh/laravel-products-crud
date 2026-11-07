<h1>Edit product</h1>

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <input name="name" value="{{ old('name', $product->name) }}">
    @error('name')
    <div>{{ $message }}</div> @enderror

    <input name="price" value="{{ old('price', $product->price) }}">
    @error('price')
    <div>{{ $message }}</div> @enderror

    <select name="category_id">
        <option value="">No category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button>Update</button>
</form>