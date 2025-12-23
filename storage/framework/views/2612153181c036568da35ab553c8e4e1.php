
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'BlissBox - Online Gifting Store'); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --pink: #ec4899;        /* Vibrant pink */
            --purple: #8b5cf6;      /* Soft purple */
            --yellow: #fbbf24;      /* Warm yellow */
            --light-pink: #fdf2f8;  /* Light pink background */
            --dark: #1f2937;        /* Dark slate */
            --muted: #6b7280;       /* Muted text */
            --gradient: linear-gradient(135deg, #ec4899, #8b5cf6, #fbbf24);
            --gradient-pink-purple: linear-gradient(135deg, #ec4899, #8b5cf6);
            --gradient-purple-yellow: linear-gradient(135deg, #8b5cf6, #fbbf24);
            --gradient-pink-yellow: linear-gradient(135deg, #ec4899, #fbbf24);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-pink);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 76px;
        }
        
        main { flex: 1; }
        
        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.1);
            border-bottom: 3px solid transparent;
            border-image: var(--gradient);
            border-image-slice: 1;
            padding: 12px 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.9rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            margin: 0 6px;
            padding: 8px 16px !important;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            background: var(--gradient-pink-purple);
            color: white !important;
            transform: translateY(-2px);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--gradient-pink-purple);
            border: none;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(236, 72, 153, 0.3);
        }
        
        .btn-secondary {
            background: var(--gradient-purple-yellow);
            border: none;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        
        .btn-accent {
            background: var(--gradient-pink-yellow);
            border: none;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 12px;
            transition: all 0.3s;
            color: var(--dark);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.08);
            transition: all 0.3s;
            overflow: hidden;
            background: white;
            border-top: 4px solid var(--pink);
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(236, 72, 153, 0.15);
            border-top-color: var(--purple);
        }
        
        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, 
                rgba(236, 72, 153, 0.05), 
                rgba(139, 92, 246, 0.05),
                rgba(251, 191, 36, 0.05));
            border-radius: 24px;
            padding: 5rem 0;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, 
                rgba(236, 72, 153, 0.15) 0%, 
                rgba(236, 72, 153, 0) 70%);
            border-radius: 50%;
        }
        
        /* Category Cards */
        .category-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(236, 72, 153, 0.15);
        }
        
        .category-card:hover::before {
            opacity: 1;
        }
        
        .category-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.3s;
        }
        
        .category-card:hover i {
            transform: scale(1.2) rotate(10deg);
        }
        
        /* Product Cards */
        .product-card {
            border: 2px solid rgba(236, 72, 153, 0.1);
            border-radius: 16px;
            overflow: hidden;
            background: white;
            transition: all 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            border-color: var(--pink);
            box-shadow: 0 15px 30px rgba(236, 72, 153, 0.15);
        }
        
        .featured-badge {
            background: var(--gradient-pink-yellow);
            color: var(--dark);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            position: absolute;
            top: 15px;
            right: 15px;
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            margin-top: auto;
            border-top: 5px solid transparent;
            border-image: var(--gradient);
            border-image-slice: 1;
            padding: 3rem 0 1.5rem;
        }
        
        /* Forms */
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 12px 18px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }
        
        /* Search */
        .search-box {
            border-radius: 25px;
            border: 2px solid var(--purple);
            padding: 12px 24px;
            width: 300px;
            transition: all 0.3s;
        }
        
        .search-box:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }
        
        /* Cart Count */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--gradient-pink-purple);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        /* Badges */
        .badge-primary {
            background: var(--gradient-pink-purple);
            border: none;
            border-radius: 20px;
            padding: 6px 14px;
            font-weight: 700;
        }
        
        /* Feature Icons */
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.8rem;
            transition: all 0.3s;
        }
        
        .feature-icon:hover {
            transform: rotate(20deg) scale(1.1);
        }
        
        /* Price */
        .price {
            color: var(--pink);
            font-weight: 800;
            font-size: 1.4rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body { padding-top: 72px; }
            .hero-section { padding: 3rem 0; }
            .search-box { width: 100%; margin-bottom: 1rem; }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #fdf2f8; }
        ::-webkit-scrollbar-thumb { background: var(--gradient); border-radius: 5px; }
    </style>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Show toast
                    const toast = document.createElement('div');
                    toast.style.cssText = `
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        background: white;
                        padding: 15px 25px;
                        border-radius: 12px;
                        box-shadow: 0 10px 25px rgba(236, 72, 153, 0.2);
                        z-index: 9999;
                        border-left: 5px solid var(--pink);
                        animation: slideIn 0.3s ease;
                    `;
                    toast.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2" style="color: var(--pink);"></i>
                            <span>Added to cart! 🎉</span>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.style.animation = 'slideOut 0.3s ease';
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                    
                    // Update cart count
                    updateCartCount();
                });
            });
            
            // Search
            const searchInput = document.querySelector('.search-box');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            window.location.href = `/products?search=${encodeURIComponent(searchTerm)}`;
                        }
                    }
                });
            }
            
            // Scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.category-card, .product-card, .feature-icon').forEach(el => {
                observer.observe(el);
            });
            
            // Add animation keyframes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
            
            function updateCartCount() {
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    let count = parseInt(cartCount.textContent) || 0;
                    cartCount.textContent = count + 1;
                }
            }
        });
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/layouts/app.blade.php ENDPATH**/ ?>