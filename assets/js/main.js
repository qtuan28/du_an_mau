document.addEventListener('DOMContentLoaded', () => {
  // Cart State
  let cartItems = [
    {
      id: 'p1',
      title: 'Vợt Volt phiên bản Player màu sáng đậm',
      price: 3590000,
      image: 'assets/images/paddle_volt.png',
      qty: 1
    }
  ];

  // DOM Elements
  const cartToggleBtn = document.getElementById('cartToggleBtn');
  const cartDrawer = document.getElementById('cartDrawer');
  const drawerOverlay = document.getElementById('drawerOverlay');
  const closeCartBtn = document.getElementById('closeCartBtn');
  const cartBadge = document.getElementById('cartBadge');
  const drawerCartItems = document.getElementById('drawerCartItems');
  const drawerCartTotal = document.getElementById('drawerCartTotal');

  const quickViewModal = document.getElementById('quickViewModal');
  const closeQuickViewBtn = document.getElementById('closeQuickViewBtn');

  // Toggle Cart Drawer
  function openCart() {
    cartDrawer.classList.add('active');
    drawerOverlay.classList.add('active');
  }

  function closeCart() {
    cartDrawer.classList.remove('active');
    drawerOverlay.classList.remove('active');
  }

  if (cartToggleBtn) cartToggleBtn.addEventListener('click', openCart);
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
  if (drawerOverlay) drawerOverlay.addEventListener('click', () => {
    closeCart();
    closeQuickView();
  });

  // Render Cart Items
  function renderCart() {
    let totalCount = 0;
    let totalPrice = 0;

    drawerCartItems.innerHTML = '';

    if (cartItems.length === 0) {
      drawerCartItems.innerHTML = `
        <div style="text-align: center; padding: 40px 0; color: #64748b;">
          <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          <p>Giỏ hàng của bạn đang trống</p>
        </div>
      `;
    } else {
      cartItems.forEach(item => {
        totalCount += item.qty;
        totalPrice += item.price * item.qty;

        const itemEl = document.createElement('div');
        itemEl.className = 'cart-item';
        itemEl.innerHTML = `
          <img src="${item.image}" class="cart-item-img" alt="${item.title}">
          <div class="cart-item-info">
            <div class="cart-item-title">${item.title}</div>
            <div class="cart-item-price">${formatCurrency(item.price)}</div>
            <div class="cart-item-qty">
              <button class="qty-btn dec-btn" data-id="${item.id}">-</button>
              <span>${item.qty}</span>
              <button class="qty-btn inc-btn" data-id="${item.id}">+</button>
              <button class="qty-btn remove-btn" data-id="${item.id}" style="margin-left: auto; border: none; color: #ef4444; font-size: 14px;">✕</button>
            </div>
          </div>
        `;
        drawerCartItems.appendChild(itemEl);
      });
    }

    if (cartBadge) cartBadge.textContent = totalCount;
    if (drawerCartTotal) drawerCartTotal.textContent = formatCurrency(totalPrice);

    // Attach Event Listeners to Cart Item Buttons
    document.querySelectorAll('.inc-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.target.getAttribute('data-id');
        const item = cartItems.find(i => i.id === id);
        if (item) item.qty++;
        renderCart();
      });
    });

    document.querySelectorAll('.dec-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.target.getAttribute('data-id');
        const item = cartItems.find(i => i.id === id);
        if (item && item.qty > 1) {
          item.qty--;
        } else if (item) {
          cartItems = cartItems.filter(i => i.id !== id);
        }
        renderCart();
      });
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.target.getAttribute('data-id');
        cartItems = cartItems.filter(i => i.id !== id);
        renderCart();
      });
    });
  }

  // Format Price in VNĐ
  function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount).replace('₫', 'đ');
  }

  // Quick View Modal
  function openQuickView(productData) {
    document.getElementById('modalImage').src = productData.image;
    document.getElementById('modalTitle').textContent = productData.title;
    document.getElementById('modalPrice').textContent = formatCurrency(productData.price);
    
    quickViewModal.classList.add('active');
    drawerOverlay.classList.add('active');

    const addToCartBtn = document.getElementById('modalAddToCartBtn');
    addToCartBtn.onclick = () => {
      addToCart(productData);
      closeQuickView();
      openCart();
    };
  }

  function closeQuickView() {
    quickViewModal.classList.remove('active');
    if (!cartDrawer.classList.contains('active')) {
      drawerOverlay.classList.remove('active');
    }
  }

  if (closeQuickViewBtn) closeQuickViewBtn.addEventListener('click', closeQuickView);

  // Add Product to Cart
  function addToCart(product) {
    const existing = cartItems.find(i => i.title === product.title);
    if (existing) {
      existing.qty++;
    } else {
      cartItems.push({
        id: 'p_' + Date.now(),
        title: product.title,
        price: product.price,
        image: product.image,
        qty: 1
      });
    }
    renderCart();
    showToast(`Đã thêm "${product.title}" vào giỏ hàng!`);
  }

  // Attach Quick View & Direct Add Events
  document.querySelectorAll('.product-quick-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const card = btn.closest('.product-card');
      const title = card.querySelector('.product-title').textContent.trim();
      const priceText = card.querySelector('.product-price').textContent.replace(/[^\d]/g, '');
      const price = parseInt(priceText, 10);
      const image = card.querySelector('.product-image-box img').src;

      openQuickView({ title, price, image });
    });
  });

  // Newsletter Submit Toast
  const newsletterBtn = document.querySelector('.btn-newsletter');
  if (newsletterBtn) {
    newsletterBtn.addEventListener('click', () => {
      const email = prompt('Nhập địa chỉ email của bạn để đăng ký nhận ưu đãi 30%:');
      if (email && email.trim() !== '') {
        showToast('Chúc mừng! Bạn đã đăng ký nhận mã ưu đãi 30% thành công.');
      }
    });
  }

  // Toast System
  function showToast(message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #0f1115;
      color: #ffffff;
      padding: 12px 24px;
      border-radius: 4px;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      z-index: 999;
      animation: fadeIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }

  // Initial Render
  renderCart();
});
