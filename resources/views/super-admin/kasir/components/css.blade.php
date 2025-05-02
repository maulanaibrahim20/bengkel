<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-color: #1a2639;
        --secondary-color: #3e4a61;
        --accent-color: #c9a87c;
        --light-color: #f5f5f5;
        --dark-color: #0e1420;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: var(--dark-color);
    }

    .navbar {
        background-color: var(--primary-color);
        color: white;
        padding: 15px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .product-card {
        height: 100%;
    }

    .product-image {
        height: 180px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .product-image i {
        font-size: 3rem;
        color: var(--secondary-color);
    }

    .btn-add {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 15px;
        transition: background-color 0.3s ease;
    }

    .btn-add:hover {
        background-color: var(--primary-color);
    }

    .category-btn {
        background-color: white;
        border: 1px solid #dee2e6;
        color: var(--dark-color);
        margin-right: 5px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .category-btn.active,
    .category-btn:hover {
        background-color: var(--accent-color);
        color: white;
        border-color: var(--accent-color);
    }

    .search-input {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 8px 15px;
    }

    .cart-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .cart-header {
        background-color: var(--primary-color);
        color: white;
        padding: 15px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        font-weight: 600;
    }

    .cart-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .cart-total {
        padding: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        justify-content: space-between;
    }

    .cart-notes {
        min-height: 120px;
        padding: 15px;
    }

    .btn-pay {
        background-color: var(--accent-color);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 12px;
        font-weight: 600;
        font-size: 1.2rem;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .btn-pay:hover {
        background-color: #b39265;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .product-price {
        color: var(--accent-color);
        font-weight: 600;
    }

    .dropdown-toggle {
        background-color: white;
        border: 1px solid #dee2e6;
        color: var(--dark-color);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-scroll-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* smooth scroll on iOS */
        scrollbar-width: thin;
    }

    .category-scroll-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .category-scroll-wrapper::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }

    .category-scroll-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        /* Biar tidak turun ke bawah */
        -webkit-overflow-scrolling: touch;
    }

    .category-btn-container {
        display: inline-flex;
        flex-wrap: nowrap;
        /* Penting: cegah tombol pindah ke bawah */
    }

    .category-scroll-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .category-scroll-wrapper::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }
</style>
