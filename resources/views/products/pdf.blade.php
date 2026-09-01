<!DOCTYPE html>
<html>
<head>
    <title>Products PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Products List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Detail</th>
                <th>Category</th>
                <th>Status</th>
                <th>Brand</th>
                <th>Expiry Date</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->detail }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->expiry_date }}</td>
                    <td>{{ $product->tags ? implode(', ', json_decode($product->tags, true)) : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
