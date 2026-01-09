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
                                onclick="selectAddress(this)">
                                <div class="address-card-header">
                                    <span class="address-label"><?= esc($addr['label']) ?></span>
                                    <?php if ($addr['is_default']): ?>
                                        <span class="address-default-badge">Default</span>
                                    <?php endif; ?>
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
                <?php if (empty($addresses)): ?>
                    <button type="button" class="btn btn-outline-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAlamat">
                        <i class="fas fa-plus me-2"></i>Tambah Alamat Baru
                    </button>
                <?php endif; ?>
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

    <script>
        function formatCityName(city) {
            const type = city.type || '';
            const name = city.name || '';
            const formattedType = type.toLowerCase() === 'kabupaten' ? 'KAB' : (type.toLowerCase() === 'kota' ? 'KOTA' : type);
            return `${formattedType} ${name}`;
        }

        // Load provinces on modal open
        document.getElementById('addAddressModal').addEventListener('show.bs.modal', function () {
            loadProvincesModal();
        });

        function loadProvincesModal() {
            fetch('<?= base_url("address/provinces") ?>')
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('province');
                    select.innerHTML = '<option value="">Pilih Provinsi</option>';

                    if (data.success && data.data) {
                        data.data.forEach(prov => {
                            select.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                        });
                    }
                })
                .catch(err => console.error('Error loading provinces:', err));
        }

        // Province change handler
        document.getElementById('province').addEventListener('change', function () {
            const provinceId = this.value;
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const villageSelect = document.getElementById('village');

            citySelect.innerHTML = '<option value="">Memuat...</option>';
            citySelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Pilih kota dahulu</option>';
            districtSelect.disabled = true;
            villageSelect.innerHTML = '<option value="">Pilih kecamatan dahulu</option>';
            villageSelect.disabled = true;

            if (provinceId) {
                fetch(`<?= base_url("address/cities") ?>/${provinceId}`)
                    .then(res => res.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';

                        if (data.success && data.data) {
                            data.data.forEach(city => {
                                const formattedName = formatCityName(city);
                                citySelect.innerHTML += `<option value="${city.id}">${formattedName}</option>`;
                            });
                            citySelect.disabled = false;
                        }
                    })
                    .catch(err => console.error('Error loading cities:', err));
            }
        });

        // City change handler
        document.getElementById('city').addEventListener('change', function () {
            const cityId = this.value;
            const districtSelect = document.getElementById('district');
            const villageSelect = document.getElementById('village');

            districtSelect.innerHTML = '<option value="">Memuat...</option>';
            districtSelect.disabled = true;
            villageSelect.innerHTML = '<option value="">Pilih kecamatan dahulu</option>';
            villageSelect.disabled = true;

            if (cityId) {
                fetch(`<?= base_url("address/districts") ?>/${cityId}`)
                    .then(res => res.json())
                    .then(data => {
                        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                        if (data.success && data.data) {
                            data.data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        }
                    })
                    .catch(err => console.error('Error loading districts:', err));
            }
        });

        // District change handler
        document.getElementById('district').addEventListener('change', function () {
            const districtId = this.value;
            const villageSelect = document.getElementById('village');

            villageSelect.innerHTML = '<option value="">Memuat...</option>';
            villageSelect.disabled = true;

            if (districtId) {
                fetch(`<?= base_url("address/villages") ?>/${districtId}`)
                    .then(res => res.json())
                    .then(data => {
                        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

                        if (data.success && data.data) {
                            data.data.forEach(village => {
                                villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
                            });
                            villageSelect.disabled = false;
                        }
                    })
                    .catch(err => console.error('Error loading villages:', err));
            }
        });

        // Auto postal code
        document.getElementById('village').addEventListener('change', function () {
            const villageId = this.value;
            if (villageId) {
                fetch(`<?= base_url("address/postal-code") ?>/${villageId}`)
                    .then(res => res.json())
                    .then(data => {
                        const zipInput = document.querySelector('input[name="zip_code"]');
                        if (data.success && data.postal_code && zipInput) {
                            zipInput.value = data.postal_code;
                        }
                    })
                    .catch(err => console.error('Error loading postal code:', err));
            }
        });

        function submitAddress() {
            const form = document.getElementById('formAddAddress');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            document.getElementById('loadingOverlay').style.display = 'flex';

            fetch('<?= base_url("address/store") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';

                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
        }
    </script>
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