<form action="{{ route('admin.supplier.purchase') }}" method="POST">
    @csrf
    <label>Supplier:</label>
    <select name="supplier_id">
        @foreach($suppliers as $s)
            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
        @endforeach
    </select>

    <label>Products:</label>
    @foreach($products as $p)
        <div>
            <input type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $p->id }}">
            {{ $p->name }} (₹{{ $p->price }})
            <input type="number" name="products[{{ $loop->index }}][quantity]" min="1" value="1">
        </div>
    @endforeach

    <button type="submit">Purchase</button>
</form>
