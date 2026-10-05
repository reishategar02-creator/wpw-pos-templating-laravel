(function () {
    const searchInput       = document.getElementById('searchProduct');
    const resultBox         = document.getElementById('productResults');
    const cartBody           = document.getElementById('cartBody');
    const itemCountEl        = document.getElementById('itemCount');
    const totalQtyEl         = document.getElementById('totalQty');
    const subtotalEl         = document.getElementById('subtotal');
    const grandTotalEl       = document.getElementById('grandTotal');
    const paymentInput       = document.getElementById('payment');
    const changeBox          = document.getElementById('changeBox');
    const changeEl           = document.getElementById('change');
    const changeLabelEl      = document.getElementById('changeLabel');
    const discountPercent    = document.getElementById('discountPercent');
    const discountAmount     = document.getElementById('discountAmount');
    const taxInput           = document.getElementById('tax');
    const otherFeeInput      = document.getElementById('otherFee');
    const paymentMethodBox   = document.getElementById('paymentMethod');
    const customerNameInput  = document.getElementById('customerName');
    const btnPay              = document.getElementById('btnPay');

    let cart = [];
    let selectedMethod = 'tunai';
    let searchTimer = null;

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', maximumFractionDigits: 0
        }).format(value || 0);
    }

    /* ===== SEARCH ===== */
    searchInput.addEventListener('input', function () {
        const keyword = searchInput.value.trim();
        clearTimeout(searchTimer);
        if (!keyword) { resultBox.style.display = 'none'; return; }

        searchTimer = setTimeout(() => {
            fetch(window.KASIR_SEARCH_URL + '?q=' + encodeURIComponent(keyword))
                .then(res => res.json())
                .then(renderResults)
                .catch(() => {
                    resultBox.innerHTML = '<div class="product-item">Gagal memuat data</div>';
                    resultBox.style.display = 'block';
                });
        }, 300);
    });

    function renderResults(products) {
        resultBox.innerHTML = products.length
            ? products.map(p => `
                <div class="product-item" data-id="${p.id}" data-name="${p.name}" data-price="${p.price}" data-stock="${p.stock}">
                    <div>
                        <div class="product-name">${p.name}</div>
                        <div class="product-stock">Stok: ${p.stock}</div>
                    </div>
                    <div class="product-price">${formatRupiah(p.price)}</div>
                </div>`).join('')
            : '<div class="product-item">Barang tidak ditemukan</div>';
        resultBox.style.display = 'block';
    }

    resultBox.addEventListener('click', function (e) {
        const item = e.target.closest('.product-item[data-id]');
        if (!item) return;
        addToCart({
            id: parseInt(item.dataset.id),
            name: item.dataset.name,
            price: parseFloat(item.dataset.price),
            stock: parseInt(item.dataset.stock),
        });
        searchInput.value = '';
        resultBox.style.display = 'none';
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.search-area')) resultBox.style.display = 'none';
    });

    /* ===== CART ===== */
    function addToCart(product) {
        const existing = cart.find(i => i.id === product.id);
        if (existing) {
            if (existing.qty + 1 > product.stock) { alert('Stok tidak mencukupi.'); return; }
            existing.qty++;
        } else {
            if (product.stock < 1) { alert('Stok habis.'); return; }
            cart.push({ ...product, qty: 1 });
        }
        renderCart();
    }

    function renderCart() {
        if (cart.length === 0) {
            cartBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">Keranjang masih kosong.<br>Silakan cari barang di atas.</td></tr>`;
            calculateTotal();
            return;
        }
        cartBody.innerHTML = cart.map((item, idx) => `
            <tr>
                <td>${idx + 1}</td>
                <td><strong>${item.name}</strong></td>
                <td>${formatRupiah(item.price)}</td>
                <td>
                    <div class="qty-control">
                        <button type="button" data-action="dec" data-id="${item.id}">-</button>
                        <input type="number" value="${item.qty}" min="1" data-id="${item.id}" class="qty-input">
                        <button type="button" data-action="inc" data-id="${item.id}">+</button>
                    </div>
                </td>
                <td class="text-end"><strong>${formatRupiah(item.price * item.qty)}</strong></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="remove" data-id="${item.id}">&times;</button>
                </td>
            </tr>`).join('');
        calculateTotal();
    }

    cartBody.addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = parseInt(btn.dataset.id);
        const item = cart.find(i => i.id === id);
        if (!item) return;

        if (btn.dataset.action === 'inc') {
            if (item.qty + 1 > item.stock) { alert('Stok tidak mencukupi.'); return; }
            item.qty++;
        }
        if (btn.dataset.action === 'dec') {
            item.qty--;
            if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
        }
        if (btn.dataset.action === 'remove') {
            cart = cart.filter(i => i.id !== id);
        }
        renderCart();
    });

    cartBody.addEventListener('change', function (e) {
        if (!e.target.classList.contains('qty-input')) return;
        const id = parseInt(e.target.dataset.id);
        const item = cart.find(i => i.id === id);
        if (!item) return;
        let qty = parseInt(e.target.value) || 1;
        if (qty > item.stock) { alert('Stok tidak mencukupi.'); qty = item.stock; }
        item.qty = Math.max(1, qty);
        renderCart();
    });

    /* ===== TOTALS ===== */
    function getSummary() {
        let totalQty = 0, subtotal = 0;
        cart.forEach(i => { totalQty += i.qty; subtotal += i.price * i.qty; });

        const dPercent = parseFloat(discountPercent.value) || 0;
        const dAmount  = parseFloat(discountAmount.value) || 0;
        const tax      = parseFloat(taxInput.value) || 0;
        const otherFee = parseFloat(otherFeeInput.value) || 0;

        const discount   = subtotal * (dPercent / 100) + dAmount;
        const grandTotal = Math.max(0, subtotal - discount + tax + otherFee);

        return { totalQty, subtotal, grandTotal };
    }

    function calculateTotal() {
        const s = getSummary();
        totalQtyEl.innerText   = s.totalQty;
        itemCountEl.innerText  = s.totalQty + ' Item';
        subtotalEl.innerText   = formatRupiah(s.subtotal);
        grandTotalEl.innerText = formatRupiah(s.grandTotal);
        calculateChange();
    }

    function calculateChange() {
        const s = getSummary();
        const payment = parseFloat(paymentInput.value) || 0;
        const change = payment - s.grandTotal;

        if (change >= 0) {
            changeBox.classList.remove('short-payment');
            changeLabelEl.innerText = 'KEMBALIAN';
            changeEl.innerText = formatRupiah(change);
        } else {
            changeBox.classList.add('short-payment');
            changeLabelEl.innerText = 'UANG KURANG';
            changeEl.innerText = formatRupiah(Math.abs(change));
        }
    }

    [discountPercent, discountAmount, taxInput, otherFeeInput].forEach(el => el.addEventListener('input', calculateTotal));
    paymentInput.addEventListener('input', calculateChange);

    /* ===== PAYMENT METHOD ===== */
    paymentMethodBox.addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-method]');
        if (!btn) return;
        paymentMethodBox.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        selectedMethod = btn.dataset.method;
    });

    /* ===== CANCEL ===== */
    document.getElementById('btnCancel').addEventListener('click', function () {
        if (cart.length === 0) return;
        if (!confirm('Batalkan transaksi ini?')) return;
        cart = [];
        paymentInput.value = '';
        discountPercent.value = 0;
        discountAmount.value = 0;
        taxInput.value = 0;
        otherFeeInput.value = 0;
        renderCart();
    });

    /* ===== PAY ===== */
    btnPay.addEventListener('click', function () {
        if (cart.length === 0) { alert('Keranjang masih kosong.'); return; }
        const s = getSummary();
        const payment = parseFloat(paymentInput.value) || 0;
        if (payment < s.grandTotal) { alert('Uang pembayaran masih kurang.'); return; }

        const payload = {
            customer_name: customerNameInput.value || null,
            payment_method: selectedMethod,
            discount_percent: parseFloat(discountPercent.value) || 0,
            discount_amount: parseFloat(discountAmount.value) || 0,
            tax: parseFloat(taxInput.value) || 0,
            other_fee: parseFloat(otherFeeInput.value) || 0,
            paid_amount: payment,
            items: cart.map(i => ({ product_id: i.id, qty: i.qty })),
        };

        btnPay.disabled = true;
        fetch(window.KASIR_STORE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            if (status !== 200 || !data.success) {
                alert(data.message || 'Transaksi gagal diproses.');
                btnPay.disabled = false;
                return;
            }
            window.location.href = data.redirect;
        })
        .catch(() => { alert('Terjadi kesalahan jaringan.'); btnPay.disabled = false; });
    });

    /* ===== DATE & SHORTCUT ===== */
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.innerText = new Date().toLocaleString('id-ID');

    document.addEventListener('keydown', function (e) {
        if (e.key === 'F2') { e.preventDefault(); searchInput.focus(); }
        if (e.key === 'F4') { e.preventDefault(); paymentInput.focus(); }
    });

    renderCart();
})();