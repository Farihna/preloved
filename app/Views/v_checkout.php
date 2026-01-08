<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 32px;
    }
    
    .checkout-section {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title i {
        color: #667eea;
        font-size: 24px;
    }
    
    .product-checkout-info {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
    }
    
    .product-thumb-checkout {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }
    
    .product-detail-checkout h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .product-price-checkout {
        font-size: 20px;
        font-weight: 700;
        color: #667eea;
    }
    
    .nego-info-badge {
        display: inline-block;
        padding: 6px 12px;
        background: #d1fae5;
        color: #065f46;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 8px;
    }
    
    .address-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .address-card {
        padding: 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .address-card:hover {
        border-color: #667eea;
        background: #f8fafc;
    }
    
    .address-card.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }
    
    .address-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .address-label {
        font-weight: 700;
        color: #1e293b;
    }
    
    .address-default-badge {
        padding: 4px 10px;
        background: #667eea;
        color: white;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .address-detail {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }
    
    .courier-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .courier-option {
        padding: 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .courier-option:hover {
        border-color: #667eea;
    }
    
    .courier-option.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }
    
    .courier-info h6 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    
    .courier-info p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    
    .courier-price {
        text-align: right;
    }
    
    .courier-cost {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .courier-etd {
        font-size: 12px;
        color: #64748b;
    }
    
    .order-summary {
        position: sticky;
        top: 100px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .summary-row.total {
        border-bottom: none;
        border-top: 2px solid #e2e8f0;
        padding-top: 16px;
        margin-top: 8px;
    }
    
    .summary-label {
        color: #64748b;
        font-size: 14px;
    }
    
    .summary-value {
        font-weight: 600;
        color: #1e293b;
    }
    
    .summary-row.total .summary-label {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .summary-row.total .summary-value {
        font-size: 24px;
        font-weight: 800;
        color: #667eea;
    }
    
    .btn-checkout {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s ease;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    }
    
    .btn-checkout:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-add-address {
        width: 100%;
        padding: 14px;
        background: white;
        color: #667eea;
        border: 2px dashed #667eea;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-add-address:hover {
        background: #f8fafc;
    }
    
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    
    .loading-spinner {
        background: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
    }
    
    @media (max-width: 968px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        
        .order-summary {
            position: static;
        }
    }
</style>

<div class="checkout-container">
    <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 32px;">Checkout</h1>
    
    <div class="checkout-grid">
        <!-- Left Column -->
        <div>
            <!-- Product Info -->
            <div class="checkout-section">
                <div class="section-title">
                    <i class="bi bi-box-seam"></i>
                    <span>Product Details</span>
                </div>
                
                <div class="product-checkout-info">
                    <img src="<?= base_url('img/' . $product['foto']) ?>" class="product-thumb-checkout" alt="Product">
                    <div class="product-detail-checkout">
                        <h5><?= esc($product['nama']) ?></h5>
                        <div class="product-price-checkout">
                            Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                        </div>
                        <?php if ($negotiation): ?>
                        <span class="nego-info-badge">
                            💰 Harga Nego (Hemat Rp <?= number_format($product['harga'] - $finalPrice, 0, ',', '.') ?>)
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="checkout-section">
                <div class="section-title">
                    <i class="bi bi-geo-alt"></i>
                    <span>Shipping Address</span>
                </div>
                
                <div class="address-list" id="addressList">
                    <?php if (empty($addresses)): ?>
                        <p style="text-align: center; color: #64748b; padding: 20px;">
                            Belum ada alamat tersimpan
                        </p>
                    <?php else: ?>
                        <?php foreach ($addresses as $addr): ?>
                        <div class="address-card <?= $addr['is_default'] ? 'selected' : '' ?>" 
                             data-address-id="<?= $addr['id'] ?>"
                             data-city-id="<?= $addr['city_id'] ?>"
                             onclick="selectAddress(this)">
                            <div class="address-card-header">
                                <span class="address-label"><?= esc($addr['label']) ?></span>
                                <?php if ($addr['is_default']): ?>
                                <span class="address-default-badge">Default</span>
                                <?php endif; ?>
                            </div>
                            <div class="address-detail">
                                <strong><?= esc($addr['recipient_name']) ?></strong> | <?= esc($addr['phone']) ?><br>
                                <?= esc($addr['address']) ?><br>
                                <?= esc($addr['city_name']) ?>, <?= esc($addr['province']) ?> <?= esc($addr['postal_code']) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <button type="button" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Alamat Baru</span>
                </button>
            </div>
            
            <!-- Shipping Method -->
            <div class="checkout-section">
                <div class="section-title">
                    <i class="bi bi-truck"></i>
                    <span>Shipping Method</span>
                </div>
                
                <div id="courierSection" style="display: none;">
                    <div class="courier-list" id="courierList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
                
                <div id="courierPlaceholder" style="text-align: center; padding: 40px; color: #94a3b8;">
                    <i class="bi bi-geo-alt" style="font-size: 48px; margin-bottom: 16px;"></i>
                    <p>Pilih alamat pengiriman terlebih dahulu</p>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Order Summary -->
        <div>
            <div class="checkout-section order-summary">
                <div class="section-title">
                    <i class="bi bi-receipt"></i>
                    <span>Order Summary</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Harga Produk</span>
                    <span class="summary-value" id="productPriceDisplay">
                        Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                    </span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Ongkos Kirim</span>
                    <span class="summary-value" id="shippingCostDisplay">-</span>
                </div>
                
                <div class="summary-row total">
                    <span class="summary-label">Total</span>
                    <span class="summary-value" id="totalAmountDisplay">
                        Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                    </span>
                </div>
                
                <button type="button" class="btn-checkout" id="btnCheckout" onclick="processCheckout()" disabled>
                    Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p style="margin-top: 16px; color: #64748b;">Sedang memproses...</p>
    </div>
</div>

<script>
// Global variables
let selectedAddress = null;
let selectedCourier = null;
const productPrice = <?= $finalPrice ?>;
const productWeight = <?= $product['weight'] ?? 500 ?>;
const originCityId = <?= $product['city_id'] ?? 152 ?>;

// Select address
function selectAddress(element) {
    // Remove previous selection
    document.querySelectorAll('.address-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection
    element.classList.add('selected');
    
    // Save selected address
    selectedAddress = {
        id: element.dataset.addressId,
        cityId: element.dataset.cityId
    };
    
    // Reset courier selection
    selectedCourier = null;
    document.getElementById('shippingCostDisplay').textContent = '-';
    updateTotal();
    
    // Load couriers
    loadCouriers(selectedAddress.cityId);
}

// Load couriers via RajaOngkir
function loadCouriers(destinationCityId) {
    document.getElementById('loadingOverlay').style.display = 'flex';
    document.getElementById('courierPlaceholder').style.display = 'none';
    document.getElementById('courierSection').style.display = 'block';
    
    // Courier codes
    const couriers = ['jne', 'pos', 'tiki'];
    
    // Fetch costs for all couriers
    Promise.all(couriers.map(courier => 
        fetch('<?= base_url("rajaongkir/cost") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                origin: originCityId,
                destination: destinationCityId,
                weight: productWeight,
                courier: courier
            })
        }).then(res => res.json())
    ))
    .then(results => {
        document.getElementById('loadingOverlay').style.display = 'none';
        
        // Compile all courier options
        let courierHTML = '';
        
        results.forEach(result => {
            if (result.success && result.data && result.data.length > 0) {
                result.data.forEach(courier => {
                    if (courier.costs && courier.costs.length > 0) {
                        courier.costs.forEach(service => {
                            const cost = service.cost[0].value;
                            const etd = service.cost[0].etd;
                            
                            courierHTML += `
                                <div class="courier-option" 
                                     data-courier-code="${courier.code}"
                                     data-courier-name="${courier.name}"
                                     data-service="${service.service}"
                                     data-cost="${cost}"
                                     data-etd="${etd}"
                                     onclick="selectCourier(this)">
                                    <div class="courier-info">
                                        <h6>${courier.name} - ${service.service}</h6>
                                        <p>${service.description}</p>
                                    </div>
                                    <div class="courier-price">
                                        <div class="courier-cost">Rp ${cost.toLocaleString('id-ID')}</div>
                                        <div class="courier-etd">${etd} hari</div>
                                    </div>
                                </div>
                            `;
                        });
                    }
                });
            }
        });
        
        if (courierHTML === '') {
            courierHTML = '<p style="text-align: center; padding: 20px; color: #94a3b8;">Tidak ada layanan kurir tersedia</p>';
        }
        
        document.getElementById('courierList').innerHTML = courierHTML;
    })
    .catch(error => {
        document.getElementById('loadingOverlay').style.display = 'none';
        console.error('Error:', error);
        alert('Gagal memuat data kurir. Silakan coba lagi.');
    });
}

// Select courier
function selectCourier(element) {
    // Remove previous selection
    document.querySelectorAll('.courier-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // Add selection
    element.classList.add('selected');
    
    // Save selected courier
    selectedCourier = {
        code: element.dataset.courierCode,
        name: element.dataset.courierName,
        service: element.dataset.service,
        cost: parseInt(element.dataset.cost),
        etd: element.dataset.etd
    };
    
    // Update summary
    document.getElementById('shippingCostDisplay').textContent = 
        'Rp ' + selectedCourier.cost.toLocaleString('id-ID');
    
    updateTotal();
    
    // Enable checkout button
    document.getElementById('btnCheckout').disabled = false;
}

// Update total
function updateTotal() {
    const shippingCost = selectedCourier ? selectedCourier.cost : 0;
    const total = productPrice + shippingCost;
    
    document.getElementById('totalAmountDisplay').textContent = 
        'Rp ' + total.toLocaleString('id-ID');
}

// Process checkout
function processCheckout() {
    if (!selectedAddress || !selectedCourier) {
        alert('Silakan pilih alamat dan metode pengiriman');
        return;
    }
    
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    const formData = new URLSearchParams({
        product_id: <?= $product['id'] ?>,
        negotiation_id: <?= $negotiation['id'] ?? 'null' ?>,
        address_id: selectedAddress.id,
        courier_code: selectedCourier.code,
        courier_service: selectedCourier.service,
        courier_name: selectedCourier.name,
        shipping_cost: selectedCourier.cost,
        estimated_delivery: selectedCourier.etd + ' hari',
        product_price: productPrice,
        total_amount: productPrice + selectedCourier.cost
    });
    
    fetch('<?= base_url("transaction/process") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingOverlay').style.display = 'none';
        
        if (data.success) {
            alert(data.message);
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        document.getElementById('loadingOverlay').style.display = 'none';
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// Auto-select default address on load
window.addEventListener('DOMContentLoaded', () => {
    const defaultAddress = document.querySelector('.address-card.selected');
    if (defaultAddress) {
        selectAddress(defaultAddress);
    }
});
</script>

<?= $this->endSection() ?>