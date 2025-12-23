{{-- resources/views/partials/footer.blade.php --}}
{{-- ONLY the footer, nothing else! --}}

<footer class="bg-dark text-white mt-5">
    <div class="container py-5">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 mb-4">
                <h3 class="mb-3">
                    <i class="fas fa-gift text-primary"></i> Bliss<span class="text-warning">Box</span>
                </h3>
                <p class="text-light">
                    Your perfect online gifting destination. We help you find the ideal gift for every occasion with love and care.
                </p>
                <div class="social-icons mt-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-pinterest fa-lg"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Shop</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/products" class="text-light text-decoration-none">All Products</a></li>
                    <li class="mb-2"><a href="/products?category=For+Her" class="text-light text-decoration-none">For Her</a></li>
                    <li class="mb-2"><a href="/products?category=For+Him" class="text-light text-decoration-none">For Him</a></li>
                    <li class="mb-2"><a href="/products?category=Birthday" class="text-light text-decoration-none">Birthday</a></li>
                    <li><a href="/products?category=Anniversary" class="text-light text-decoration-none">Anniversary</a></li>
                </ul>
            </div>
            
            <!-- Help -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Help</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/contact" class="text-light text-decoration-none">Contact Us</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">FAQs</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Shipping Info</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Returns</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4">
                <h5 class="mb-3">Contact Info</h5>
                <ul class="list-unstyled text-light">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        123 Gift Street, Joy City
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        (123) 456-7890
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        support@blissbox.com
                    </li>
                    <li>
                        <i class="fas fa-clock me-2 text-primary"></i>
                        Mon-Fri: 9AM-6PM EST
                    </li>
                </ul>
                
                <!-- Newsletter -->
                <div class="mt-4">
                    <h6 class="text-warning">Join Our Newsletter</h6>
                    <form class="d-flex mt-2">
                        <input type="email" class="form-control me-2" placeholder="Your email" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <hr class="bg-light my-4">
        
        <!-- Copyright -->
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">
                    &copy; {{ date('Y') }} BlissBox. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">
                    Made with <i class="fas fa-heart text-danger"></i> for gift lovers
                </p>
            </div>
        </div>
    </div>
</footer>