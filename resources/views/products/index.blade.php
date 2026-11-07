<h1>Products</h1>
<a href="{{ route('products.create') }}">Add product</a>

<ul>
@foreach ($products as $product)
    <li>
        {{ $product->name }} - ₹{{ $product->price }}
        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button>Delete</button>
            <a href="{{ route('products.edit', $product) }}">Edit</a>
        </form>
    </li>
@endforeach
</ul>