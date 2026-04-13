<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F8FAFC;
            padding: 20px;
        }
        
        .test-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-content">
            <h1 class="text-primary">DinePay Test Page</h1>
            <p class="lead">If you can see this, the basic setup is working!</p>
            
            <div class="alert alert-success">
                <strong>Success!</strong> The page is loading correctly.
            </div>
            
            <button class="btn btn-primary">Test Button</button>
            <button class="btn btn-secondary">Test Button 2</button>
            
            <hr>
            
            <h3>Menu Items Test</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1591325418441-ff678baf78ef" class="card-img-top" alt="Food">
                        <div class="card-body">
                            <h5 class="card-title">Test Item</h5>
                            <p class="card-text">Test description</p>
                            <p class="fw-bold">Rp25.000</p>
                            <button class="btn btn-primary w-100">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        console.log('Test page loaded successfully');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
        });
    </script>
</body>
</html>
