@extends('layouts.app')

@section('title', 'Contact Us - BlissBox')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="fw-bold mb-3" style="color: #1e293b;">Contact Us</h1>
                <p class="lead text-muted">We'd love to hear from you. Send us a message!</p>
            </div>

            <div class="card border-light shadow-sm mb-5">
                <div class="card-body p-4 p-md-5">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Your Name *</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="row mt-4">
                <div class="col-md-4 text-center mb-4">
                    <div class="p-3">
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                        </div>
                        <h5 class="mb-2">Our Location</h5>
                        <p class="text-muted mb-0">123 Gift Street<br>Happy City, HC 12345</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="p-3">
                        <div class="mb-3">
                            <i class="fas fa-phone fa-2x text-primary"></i>
                        </div>
                        <h5 class="mb-2">Phone Number</h5>
                        <p class="text-muted mb-0">(123) 456-7890</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="p-3">
                        <div class="mb-3">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <h5 class="mb-2">Email Address</h5>
                        <p class="text-muted mb-0">hello@blissbox.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control {
    border: 1px solid #dee2e6;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.card {
    border-radius: 8px;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}
</style>
@endsection