<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlissBox - Gift Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">BlissBox</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/shop">Shop</a>
                <a class="nav-link" href="/categories">Categories</a>
                <a class="nav-link" href="/contact">Contact</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to BlissBox Gift Store</h1>
        <p class="lead">Find the perfect gift for every occasion</p>
        
        @if(isset($products) && count($products) > 0)
            <div class="row mt-4">
                @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            @if($product->image)
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">${{ $product->price }}</p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mt-4">
                No products found. Please check back later.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>