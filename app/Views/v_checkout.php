<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

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
                                data-province-id="<?= $addr['province_id'] ?>"
                                data-district-id="<?= $addr['district_id'] ?>"
                                onclick="selectAddress(this)">
                                <div class="address-card-header">
                                    <span class="address-label"><?= esc($addr['label']) ?></span>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <?php if ($addr['is_default']): ?>
                                            <span class="address-default-badge">Default</span>
                                        <?php endif; ?>
                                        <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); openEditModalCheckout(<?= $addr['id'] ?>);" style="padding: 2px 8px; font-size: 12px;">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </div>
                                </div>
                                <div class="address-detail">
                                    <strong><?= esc($addr['recipient_name']) ?></strong> | <?= esc($addr['phone_number']) ?><br>
                                    <?= esc($addr['address_line']) ?><br>
                                    <?= esc($addr['village_name'] ?? $addr['village']) ?>, 
                                    <?= esc($addr['district_name'] ?? $addr['district']) ?>, 
                                    <?php 
                                        $cityType = $addr['city_type'] ?? '';
                                        $cityName = $addr['city_name'] ?? $addr['city'];
                                        $formattedCity = $cityType ? (strtolower($cityType) === 'kabupaten' ? 'KAB' : 'KOTA') . ' ' . $cityName : $cityName;
                                        echo esc($formattedCity); 
                                    ?>, 
                                    <?= esc($addr['province_name'] ?? $addr['province']) ?> 
                                    <?= esc($addr['zip_code']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary w-100 mb-3">
                        <i class="fas fa-plus me-2"></i>Tambah Alamat Baru
                    </a>
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
    </div>
    <!-- Right Column - Order Summary -->
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
    
    <!-- Modal Tambah Alamat -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alamat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddAddress">
                        <div class="mb-3">
                            <label class="form-label">Label Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="label" placeholder="Rumah, Kantor, dll" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="recipient_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone_number" placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select class="form-select" id="province" name="province_id" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select" id="city" name="city_id" required disabled>
                                <option value="">Pilih provinsi dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select class="form-select" id="district" name="district_id" required disabled>
                                <option value="">Pilih kota dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                            <select class="form-select" id="village" name="village_id" required disabled>
                                <option value="">Pilih kecamatan dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address_line" rows="3" placeholder="Jalan, RT/RW, detail alamat" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zip_code" maxlength="5" pattern="[0-9]{5}" placeholder="12345" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="setDefault">
                            <label class="form-check-label" for="setDefault">
                                Jadikan alamat utama
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitAddress()">Simpan Alamat</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Alamat -->
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Alamat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditAddress">
                        <input type="hidden" name="address_id" id="editAddressId">
                        
                        <div class="mb-3">
                            <label class="form-label">Label Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="label" id="editLabel" placeholder="Rumah, Kantor, dll" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="recipient_name" id="editRecipientName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone_number" id="editPhoneNumber" placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select class="form-select" id="editProvince" name="province_id" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select" id="editCity" name="city_id" required disabled>
                                <option value="">Pilih provinsi dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDistrict" name="district_id" required disabled>
                                <option value="">Pilih kota dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                            <select class="form-select" id="editVillage" name="village_id" required disabled>
                                <option value="">Pilih kecamatan dahulu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address_line" id="editAddressLine" rows="3" placeholder="Jalan, RT/RW, detail alamat" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zip_code" id="editZipCode" maxlength="5" pattern="[0-9]{5}" placeholder="12345" required readonly style="background-color: #f8f9fa;">
                            <small class="text-muted">Kode pos akan terisi otomatis setelah memilih kelurahan/desa</small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="editSetDefault">
                            <label class="form-check-label" for="editSetDefault">
                                Jadikan alamat utama
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitEditAddress()">Update Alamat</button>
                </div>
            </div>
        </div>
    </div>
    <div class="loading-overlay" id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="margin-top: 16px; color: #fff;">Sedang memproses...</p>
        </div>
    </div>
</div>
<script>
    let selectedAddress = null;
    let selectedCourier = null;
    let shippingOptions = [];
    const productPrice = <?= $finalPrice ?>;
    const productWeight = <?= $product['weight'] ?? 1000 ?>;

    // Fungsi Pembantu: Format nama Kota (KAB/KOTA)
    function formatCityName(city) {
        const type = (city.type || '').toLowerCase();
        const name = city.name || '';
        const formattedType = type === 'kabupaten' ? 'KAB' : (type === 'kota' ? 'KOTA' : type.toUpperCase());
        return `${formattedType} ${name}`;
    }

    // Fungsi Universal untuk mengisi dropdown
    async function updateRegionSelect(targetId, url, placeholder) {
        const select = document.getElementById(targetId);
        if (!select) return;

        select.innerHTML = '<option value="">Memuat...</option>';
        select.disabled = true;

        try {
            const res = await fetch(url);
            const data = await res.json();
            
            select.innerHTML = `<option value="">${placeholder}</option>`;
            if (data.success && data.data) {
                data.data.forEach(item => {
                    const name = item.type ? formatCityName(item) : item.name;
                    select.innerHTML += `<option value="${item.id}">${name}</option>`;
                });
                select.disabled = false;
            }
        } catch (err) {
            console.error(`Error loading ${targetId}:`, err);
            select.innerHTML = `<option value="">Gagal memuat</option>`;
        }
    }

    // Fungsi untuk memasang Event Listener pada dropdown wilayah
    function setupRegionHandlers(prefix) {
        const p = prefix ? (prefix.charAt(0).toUpperCase() + prefix.slice(1)) : ''; // capitalize for CamelCase ID
        const pf = prefix ? prefix : ''; // for lowerCase prefix

        // ID Elemen (Contoh: editProvince atau province)
        const elProv = document.getElementById(pf + (p ? 'Province' : 'province'));
        const elCity = document.getElementById(pf + (p ? 'City' : 'city'));
        const elDist = document.getElementById(pf + (p ? 'District' : 'district'));
        const elVill = document.getElementById(pf + (p ? 'Village' : 'village'));
        const elZip  = document.getElementById(pf + (p ? 'ZipCode' : 'zip_code'));

        elProv?.addEventListener('change', function() {
            updateRegionSelect(elCity.id, `<?= base_url("address/cities") ?>/${this.value}`, 'Pilih Kota/Kabupaten');
            elDist.innerHTML = '<option value="">Pilih kota dahulu</option>';
            elVill.innerHTML = '<option value="">Pilih kecamatan dahulu</option>';
            if(elZip) elZip.value = '';
        });

        elCity?.addEventListener('change', function() {
            updateRegionSelect(elDist.id, `<?= base_url("address/districts") ?>/${this.value}`, 'Pilih Kecamatan');
            elVill.innerHTML = '<option value="">Pilih kecamatan dahulu</option>';
        });

        elDist?.addEventListener('change', function() {
            updateRegionSelect(elVill.id, `<?= base_url("address/villages") ?>/${this.value}`, 'Pilih Desa');
        });

        elVill?.addEventListener('change', function() {
            if (this.value && elZip) {
                elZip.value = 'Memuat...';
                fetch(`<?= base_url("address/postal-code") ?>/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        elZip.value = (data.success && data.postal_code) ? data.postal_code : '';
                    });
            }
        });
    }

    /**
     * ==========================================
     * LOGIKA PEMILIHAN ALAMAT & KURIR (CHECKOUT)
     * ==========================================
     */

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
            cityId: element.dataset.cityId,
            provinceId: element.dataset.provinceId,
            districtId: element.dataset.districtId
        };

        // Reset courier selection
        selectedCourier = null;
        shippingOptions = [];
        document.getElementById('shippingCostDisplay').textContent = '-';
        document.getElementById('btnCheckout').disabled = true;
        updateTotal();

        // Load couriers
        loadCouriers();
    }

    // Load couriers via RajaOngkir Komerce API
    function loadCouriers() {
        if (!selectedAddress || !selectedAddress.districtId) {
            alert('Data alamat tidak lengkap. Pilih alamat lain atau edit alamat ini.');
            return;
        }
            
        document.getElementById('loadingOverlay').style.display = 'flex';
        document.getElementById('courierPlaceholder').style.display = 'none';
        document.getElementById('courierSection').style.display = 'block';
        document.getElementById('courierList').innerHTML = '<p style="text-align: center; padding: 20px;">Mencari layanan pengiriman terbaik...</p>';

        // Calculate shipping cost
        fetch('<?= base_url("rajaongkir/calculate-shipping") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                district_id: selectedAddress.districtId,
                weight: productWeight
            })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';


            if (!data.success) {
                document.getElementById('courierList').innerHTML = 
                    `<div style="text-align: center; padding: 40px;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 48px; color: #ef4444; margin-bottom: 16px;"></i>
                        <p style="color: #ef4444; font-weight: 500;">${data.message}</p>
                        <p style="color: #64748b; font-size: 14px; margin-top: 8px;">Pastikan alamat sudah lengkap dan benar</p>
                    </div>`;
                return;
            }

            shippingOptions = data.data || [];

            if (shippingOptions.length === 0) {
                document.getElementById('courierList').innerHTML = 
                    '<p style="text-align: center; padding: 20px; color: #94a3b8;">Tidak ada layanan pengiriman tersedia untuk alamat ini</p>';
                return;
            }

            // Display courier options - ONLY SHOW CHEAPEST FIRST
            renderCourierOptions(false); // false = collapsed (show only cheapest)

            // Auto-select cheapest option
            if (data.cheapest) {
                selectedCourier = {
                    code: data.cheapest.courier_code,
                    name: data.cheapest.courier_name,
                    service: data.cheapest.service,
                    cost: data.cheapest.cost,
                    etd: data.cheapest.etd
                };

                // Update summary
                document.getElementById('shippingCostDisplay').textContent =
                    'Rp ' + selectedCourier.cost.toLocaleString('id-ID');
                
                updateTotal();

                // Enable checkout button
                document.getElementById('btnCheckout').disabled = false;

            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            console.error('Error:', error);
            document.getElementById('courierList').innerHTML = 
                `<div style="text-align: center; padding: 40px;">
                    <i class="bi bi-x-circle" style="font-size: 48px; color: #ef4444; margin-bottom: 16px;"></i>
                    <p style="color: #ef4444; font-weight: 500;">Gagal memuat data kurir</p>
                    <button class="btn btn-sm btn-primary mt-3" onclick="loadCouriers()">
                        <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                    </button>
                </div>`;
        });
    }

    // Function to render courier options (collapsed or expanded)
    function renderCourierOptions(showAll = false) {
        let courierHTML = '';
        
        // Always show the cheapest (first item)
        const cheapest = shippingOptions[0];
        courierHTML += `
            <div class="courier-option selected" 
                data-index="0"
                data-courier-code="${cheapest.courier_code}"
                data-courier-name="${cheapest.courier_name}"
                data-service="${cheapest.service}"
                data-cost="${cheapest.cost}"
                data-etd="${cheapest.etd}"
                onclick="selectCourier(this, 0)">
                <div class="courier-info">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <h6 style="margin: 0;">${cheapest.courier_name} - ${cheapest.service}</h6>
                        <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px;">TERMURAH</span>
                    </div>
                    <p>${cheapest.description || 'Layanan pengiriman standar'}</p>
                </div>
                <div class="courier-price">
                    <div class="courier-cost">Rp ${cheapest.cost.toLocaleString('id-ID')}</div>
                    <div class="courier-etd">${cheapest.etd}</div>
                </div>
            </div>
        `;

        // Show other options if expanded
        if (showAll && shippingOptions.length > 1) {
            courierHTML += '<div id="otherCourierOptions" style="margin-top: 12px;">';
            courierHTML += '<div style="padding: 8px 0; font-weight: 600; color: #64748b; font-size: 14px;">Opsi Pengiriman Lainnya:</div>';
            
            shippingOptions.slice(1).forEach((service, idx) => {
                const actualIndex = idx + 1;
                courierHTML += `
                    <div class="courier-option" 
                        data-index="${actualIndex}"
                        data-courier-code="${service.courier_code}"
                        data-courier-name="${service.courier_name}"
                        data-service="${service.service}"
                        data-cost="${service.cost}"
                        data-etd="${service.etd}"
                        onclick="selectCourier(this, ${actualIndex})">
                        <div class="courier-info">
                            <h6>${service.courier_name} - ${service.service}</h6>
                            <p>${service.description || 'Layanan pengiriman standar'}</p>
                        </div>
                        <div class="courier-price">
                            <div class="courier-cost">Rp ${service.cost.toLocaleString('id-ID')}</div>
                            <div class="courier-etd">${service.etd}</div>
                        </div>
                    </div>
                `;
            });
            courierHTML += '</div>';
        }

        // Add toggle button if there are more options
        if (shippingOptions.length > 1) {
            courierHTML += `
                <button class="btn-toggle-couriers" id="btnToggleCouriers" onclick="toggleCourierOptions()">
                    <i class="bi ${showAll ? 'bi-chevron-up' : 'bi-chevron-down'}"></i>
                    <span>${showAll ? 'Sembunyikan' : 'Lihat'} ${shippingOptions.length - 1} Opsi Lainnya</span>
                </button>
            `;
        }

        document.getElementById('courierList').innerHTML = courierHTML;
    }

    // Toggle show/hide other courier options
    let courierExpanded = false;
    function toggleCourierOptions() {
        courierExpanded = !courierExpanded;
        renderCourierOptions(courierExpanded);
        
        // Re-select the currently selected courier
        if (selectedCourier) {
            const selectedIndex = shippingOptions.findIndex(opt => 
                opt.courier_code === selectedCourier.code && 
                opt.service === selectedCourier.service
            );
            
            if (selectedIndex >= 0) {
                const elements = document.querySelectorAll('.courier-option');
                elements.forEach((el, idx) => {
                    if (parseInt(el.dataset.index) === selectedIndex) {
                        el.classList.add('selected');
                    }
                });
            }
        }
    }

    // Select courier
    function selectCourier(element, index) {
        // Remove previous selection
        document.querySelectorAll('.courier-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        // Add selection
        element.classList.add('selected');

        // Get courier data from options array
        const service = shippingOptions[index];

        // Save selected courier
        selectedCourier = {
            code: service.courier_code,
            name: service.courier_name,
            service: service.service,
            cost: service.cost,
            etd: service.etd
        };

        // Update summary
        document.getElementById('shippingCostDisplay').textContent =
            'Rp ' + selectedCourier.cost.toLocaleString('id-ID');

        updateTotal();

        // Enable checkout button
        document.getElementById('btnCheckout').disabled = false;

        console.log('Selected courier:', selectedCourier);
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
            estimated_delivery: selectedCourier.etd,
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


    // Simpan Alamat Baru
    function submitAddress() {
        handleFormSubmit('formAddAddress', '<?= base_url("address/store") ?>');
    }

    // Update Alamat (Edit)
    function submitEditAddress() {
        handleFormSubmit('formEditAddress', '<?= base_url("address/update") ?>');
    }

    // Fungsi Universal Submit Form (AJAX)
    async function handleFormSubmit(formId, url) {
        const form = document.getElementById(formId);
        if (!form.checkValidity()) { form.reportValidity(); return; }

        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'flex';

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            
            if (overlay) overlay.style.display = 'none';
            alert(data.message);
            if (data.success) location.reload();
        } catch (err) {
            if (overlay) overlay.style.display = 'none';
            alert('Terjadi kesalahan sistem.');
        }
    }

    // Membuka Modal Edit dan Mengisi Data Awal
    async function openEditModalCheckout(addressId) {
        try {
            const res = await fetch(`<?= base_url("address/edit") ?>/${addressId}`);
            const data = await res.json();
            
            if (data.success) {
                const addr = data.data;
                // Isi Field Dasar
                document.getElementById('editAddressId').value = addr.id;
                document.getElementById('editLabel').value = addr.label;
                document.getElementById('editRecipientName').value = addr.recipient_name;
                document.getElementById('editPhoneNumber').value = addr.phone_number;
                document.getElementById('editAddressLine').value = addr.address_line;
                document.getElementById('editZipCode').value = addr.zip_code;
                document.getElementById('editSetDefault').checked = addr.is_default == 1;

                // Load Dropdown Berjenjang (Provinsi -> Kota -> dst)
                await updateRegionSelect('editProvince', '<?= base_url("address/provinces") ?>', 'Pilih Provinsi');
                document.getElementById('editProvince').value = addr.province_id;
                
                await updateRegionSelect('editCity', `<?= base_url("address/cities") ?>/${addr.province_id}`, 'Pilih Kota');
                document.getElementById('editCity').value = addr.city_id;

                await updateRegionSelect('editDistrict', `<?= base_url("address/districts") ?>/${addr.city_id}`, 'Pilih Kecamatan');
                document.getElementById('editDistrict').value = addr.district_id;

                await updateRegionSelect('editVillage', `<?= base_url("address/villages") ?>/${addr.district_id}`, 'Pilih Desa');
                document.getElementById('editVillage').value = addr.village_id;

                new bootstrap.Modal(document.getElementById('editAddressModal')).show();
            }
        } catch (err) {
            alert('Gagal mengambil data alamat.');
        }
    }
</script>
<?= $this->endSection() ?>