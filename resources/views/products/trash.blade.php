<!DOCTYPE html>
<html>
<head>
    <title>Product Trash</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>🗑️ Product Trash</h2>
            <p class="text-muted mb-0">
                Deleted products
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-primary">
            ← Back to Products
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count())

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($products as $product)

                        <tr>

                            <td>
                                {{ $loop->iteration + (($products->currentPage() - 1) * $products->perPage()) }}
                            </td>

                            <td>
                                {{ $product->id }}
                            </td>

                            <td>
                                {{ $product->name }}
                            </td>

                            <td>
                                {{ $product->category }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    Deleted
                                </span>
                            </td>

                            <td>
                                {{ $product->deleted_at }}
                            </td>

                            <td>

                                {{-- Restore --}}
                                <form
                                    action="{{ route('products.restore', $product->id) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-success btn-sm"
                                    >
                                        Restore
                                    </button>
                                </form>

                                {{-- Permanent Delete --}}
                                <form
                                    action="{{ route('products.forceDelete', $product->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Permanently delete this product? This cannot be undone.')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete Permanently
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>

    @else

        <div class="alert alert-info text-center">
            🗑️ Trash is empty.
        </div>

    @endif

</div>

</body>
</html>