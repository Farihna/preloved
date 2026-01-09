<?= $this->extend('layout_user') ?>
<?= $this->section('content') ?>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-wrapper">
                <img src="<?= base_url('img/' . ($profile['img_profile'] ?: 'no_profile.jpg')) ?>" alt="Profile"
                    class="profile-avatar">
            </div>
            <h1 class="profile-name"><?= $profile['username'] ?></h1>
            <p class="profile-role">User Account</p>
        </div>

        <div class="profile-tabs">
            <button class="tab-button active" data-tab="overview">Overview</button>
            <button class="tab-button" data-tab="edit">Edit Profile</button>
            <button class="tab-button" data-tab="addresses">Addresses</button>
        </div>

        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane active" id="overview">
                <div class="info-row">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?= $profile['username'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?= $profile['email'] ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value"><?= $profile['hp'] ?></div>
                </div>
            </div>

            <!-- Edit Tab -->
            <div class="tab-pane" id="edit">
                <form action="<?= base_url('profile/edit/' . $profile['id']) ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="avatar-upload-section">
                        <img src="<?= base_url('img/' . ($profile['img_profile'] ?: 'no_profile.jpg')) ?>" alt="Profile"
                            class="avatar-preview">
                        <div class="avatar-upload-info">
                            <p><strong>Change Profile Picture</strong></p>
                            <input type="file" name="img_profile" class="form-control-profile">
                            <input type="hidden" name="check" value="1">
                            <p style="margin-top: 8px; font-size: 13px;">Max 1MB, JPG/PNG</p>
                        </div>
                    </div>

                    <div class="form-group-profile">
                        <label class="form-label-profile">Username</label>
                        <input type="text" name="username" class="form-control-profile"
                            value="<?= $profile['username'] ?>" required>
                    </div>

                    <div class="form-group-profile">
                        <label class="form-label-profile">Email</label>
                        <input type="email" name="email" class="form-control-profile" value="<?= $profile['email'] ?>"
                            required>
                    </div>

                    <div class="form-group-profile">
                        <label class="form-label-profile">Phone Number</label>
                        <div class="input-group-profile">
                            <span class="input-prefix-profile">+62</span>
                            <input type="text" name="hp" id="hp" class="form-control-profile"
                                value="<?= isset($profile['hp']) ? preg_replace('/^\+62/', '', $profile['hp']) : '' ?>"
                                placeholder="8123456789" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-save-profile">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>
            </div>
            <!-- Addresses Tab -->
            <div class="tab-pane" id="addresses">
                <div class="addresses-section">
                    <?php if (empty($addresses)): ?>
                        <p style="text-align: center; color: #64748b; padding: 40px;">Belum ada alamat tersimpan</p>
                    <?php else: ?>
                        <?php foreach ($addresses as $addr): ?>
                            <div class="address-item"
                                style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
                                <div class="address-item-header"
                                    style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <strong><?= esc($addr['label']) ?></strong>
                                    <?php if ($addr['is_default']): ?>
                                        <span
                                            style="background: #3b82f6; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;">Default</span>
                                    <?php endif; ?>
                                </div>
                                <div class="address-item-body" style="color: #64748b; font-size: 14px;">
                                    <p style="margin: 4px 0;"><strong><?= esc($addr['recipient_name']) ?></strong> |
                                        <?= esc($addr['phone_number']) ?></p>
                                    <p style="margin: 4px 0;"><?= esc($addr['address_line']) ?></p>
                                    <p style="margin: 4px 0;">
                                        <?= esc($addr['village_name'] ?? $addr['village']) ?>,
                                        <?= esc($addr['district_name'] ?? $addr['district']) ?>,
                                        <?= esc($addr['city_name'] ?? $addr['city']) ?>,
                                        <?= esc($addr['province_name'] ?? $addr['province']) ?>
                                        <?= esc($addr['zip_code']) ?>
                                    </p>
                                </div>
                                <div class="address-item-actions" style="margin-top: 12px; display: flex; gap: 8px;">
                                    <?php if (!$addr['is_default']): ?>
                                        <button class="btn btn-sm btn-outline-primary" onclick="setDefaultAddress(<?= $addr['id'] ?>)">Set Default</button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-outline-info" onclick="openEditModal(<?= $addr['id'] ?>)">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAddress(<?= $addr['id'] ?>)">Hapus</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <button class="btn-save-profile" data-bs-toggle="modal" data-bs-target="#addAddressModalProfile"
                        style="margin-top: 16px;">
                        <i class="bi bi-plus-circle"></i> Tambah Alamat Baru
                    </button>
                </div>
            </div>

            <div class="modal fade" id="addAddressModalProfile" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Alamat Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formAddAddressProfile">
                                <div class="mb-3">
                                    <label class="form-label">Label Alamat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="label"
                                        placeholder="Rumah, Kantor, dll" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Penerima <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="recipient_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor Telepon <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone_number"
                                            placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="provinceProfile" name="province_id" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select class="form-select" id="cityProfile" name="city_id" required disabled>
                                        <option value="">Pilih provinsi dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="districtProfile" name="district_id" required
                                        disabled>
                                        <option value="">Pilih kota dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                                    <select class="form-select" id="villageProfile" name="village_id" required disabled>
                                        <option value="">Pilih kecamatan dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address_line" rows="3"
                                        placeholder="Jalan, RT/RW, detail alamat" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="zip_code" maxlength="5"
                                        pattern="[0-9]{5}" placeholder="12345" required>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1"
                                        id="setDefaultProfile">
                                    <label class="form-check-label" for="setDefaultProfile">
                                        Jadikan alamat utama
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitAddressProfile()">Simpan
                                Alamat</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Alamat -->
            <div class="modal fade" id="editAddressModalProfile" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Alamat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formEditAddressProfile">
                                <input type="hidden" name="address_id" id="editAddressId">

                                <div class="mb-3">
                                    <label class="form-label">Label Alamat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="label" id="editLabel"
                                        placeholder="Rumah, Kantor, dll" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Penerima <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="recipient_name"
                                            id="editRecipientName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nomor Telepon <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone_number" id="editPhoneNumber"
                                            placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editProvinceProfile" name="province_id" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editCityProfile" name="city_id" required disabled>
                                        <option value="">Pilih provinsi dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editDistrictProfile" name="district_id" required
                                        disabled>
                                        <option value="">Pilih kota dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editVillageProfile" name="village_id" required
                                        disabled>
                                        <option value="">Pilih kecamatan dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address_line" id="editAddressLine" rows="3"
                                        placeholder="Jalan, RT/RW, detail alamat" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="zip_code" id="editZipCode"
                                        maxlength="5" pattern="[0-9]{5}" placeholder="12345" required>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1"
                                        id="editSetDefaultProfile">
                                    <label class="form-check-label" for="editSetDefaultProfile">
                                        Jadikan alamat utama
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitEditAddressProfile()">Update
                                Alamat</button>
                        </div>
                    </div>
                </div>
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
<script>
    // Tab switching
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.dataset.tab;
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });

    // Phone input validation
    const hpInput = document.getElementById('hp');
    if (hpInput) {
        hpInput.addEventListener('input', function (e) {
            let val = e.target.value;
            val = val.replace(/[^0-9]/g, '');
            if (val.startsWith('0')) {
                val = val.substring(1);
            }
            e.target.value = val;
        });
    }

    // Address functions
    function setDefaultAddress(id) {
        if (confirm('Set alamat ini sebagai default?')) {
            fetch(`<?= base_url("address/set-default") ?>/${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan');
                });
        }
    }

    function deleteAddress(id) {
        if (confirm('Hapus alamat ini?')) {
            fetch(`<?= base_url("address/delete") ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan');
                });
        }
    }

    // Load provinces when modal opens
    const modalProfile = document.getElementById('addAddressModalProfile');
    if (modalProfile) {
        modalProfile.addEventListener('show.bs.modal', function () {
            loadProvincesProfile();
        });
    }

    function loadProvincesProfile() {
        fetch('<?= base_url("address/provinces") ?>')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('provinceProfile');
                select.innerHTML = '<option value="">Pilih Provinsi</option>';

                if (data.success && data.data) {
                    data.data.forEach(prov => {
                        select.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                    });
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Gagal memuat data provinsi');
            });
    }

    // Province change handler
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.getElementById('provinceProfile');
        const citySelect = document.getElementById('cityProfile');
        const districtSelect = document.getElementById('districtProfile');
        const villageSelect = document.getElementById('villageProfile');

        if (provinceSelect) {
            provinceSelect.addEventListener('change', function () {
                const provinceId = this.value;

                // Reset dependent dropdowns
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
                                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                                });
                                citySelect.disabled = false;
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            citySelect.innerHTML = '<option value="">Gagal memuat data</option>';
                        });
                }
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', function () {
                const cityId = this.value;

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
                        .catch(err => {
                            console.error('Error:', err);
                            districtSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                        });
                }
            });
        }

        if (districtSelect) {
            districtSelect.addEventListener('change', function () {
                const districtId = this.value;

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
                        .catch(err => {
                            console.error('Error:', err);
                            villageSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                        });
                }
            });
        }
    });

    // Submit address form
    function submitAddressProfile() {
        const form = document.getElementById('formAddAddressProfile');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'flex';

        fetch('<?= base_url("address/store") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (overlay) overlay.style.display = 'none';
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                if (overlay) overlay.style.display = 'none';
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
    }
    // Function untuk format city dengan type
function formatCityName(city) {
    const type = city.type || '';
    const name = city.name || '';
    // Ubah 'Kabupaten' jadi 'KAB' dan 'Kota' jadi 'KOTA'
    const formattedType = type.toLowerCase() === 'kabupaten' ? 'KAB' : (type.toLowerCase() === 'kota' ? 'KOTA' : type);
    return `${formattedType} ${name}`;
}

// Auto postal code when village selected
document.addEventListener('DOMContentLoaded', function () {
    // ... kode sebelumnya tetap ...

    // Tambahkan listener untuk village selection - AUTO POSTAL CODE
    const villageSelect = document.getElementById('villageProfile');
    if (villageSelect) {
        villageSelect.addEventListener('change', function () {
            const villageId = this.value;
            if (villageId) {
                fetch(`<?= base_url("address/postal-code") ?>/${villageId}`)
                    .then(res => res.json())
                    .then(data => {
                        const zipInput = document.querySelector('#formAddAddressProfile input[name="zip_code"]');
                        if (data.success && data.postal_code && zipInput) {
                            zipInput.value = data.postal_code;
                        }
                    })
                    .catch(err => console.error('Error loading postal code:', err));
            }
        });
    }

    // Update city handler untuk format dengan KAB/KOTA
    citySelect.addEventListener('change', function () {
        const cityId = this.value;
        
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
                .catch(err => {
                    console.error('Error:', err);
                    districtSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        }
    });
});

// Update load cities untuk format KAB/KOTA
provinceSelect.addEventListener('change', function () {
    const provinceId = this.value;
    
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
            .catch(err => {
                console.error('Error:', err);
                citySelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    }
});

// Function untuk open edit modal
function openEditModal(addressId) {
    fetch(`<?= base_url("address/edit") ?>/${addressId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const addr = data.data;
                
                // Fill form
                document.getElementById('editAddressId').value = addr.id;
                document.getElementById('editLabel').value = addr.label;
                document.getElementById('editRecipientName').value = addr.recipient_name;
                document.getElementById('editPhoneNumber').value = addr.phone_number;
                document.getElementById('editAddressLine').value = addr.address_line;
                document.getElementById('editZipCode').value = addr.zip_code;
                document.getElementById('editSetDefaultProfile').checked = addr.is_default == 1;
                
                // Load provinces first
                loadProvincesForEdit(addr);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editAddressModalProfile'));
                modal.show();
            } else {
                alert('Gagal memuat data alamat');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan');
        });
}

function loadProvincesForEdit(addressData) {
    fetch('<?= base_url("address/provinces") ?>')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('editProvinceProfile');
            select.innerHTML = '<option value="">Pilih Provinsi</option>';
            
            if (data.success && data.data) {
                data.data.forEach(prov => {
                    const selected = prov.id == addressData.province_id ? 'selected' : '';
                    select.innerHTML += `<option value="${prov.id}" ${selected}>${prov.name}</option>`;
                });
                
                // Trigger load cities
                if (addressData.province_id) {
                    loadCitiesForEdit(addressData);
                }
            }
        });
}

function loadCitiesForEdit(addressData) {
    fetch(`<?= base_url("address/cities") ?>/${addressData.province_id}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('editCityProfile');
            select.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            
            if (data.success && data.data) {
                data.data.forEach(city => {
                    const formattedName = formatCityName(city);
                    const selected = city.id == addressData.city_id ? 'selected' : '';
                    select.innerHTML += `<option value="${city.id}" ${selected}>${formattedName}</option>`;
                });
                select.disabled = false;
                
                // Trigger load districts
                if (addressData.city_id) {
                    loadDistrictsForEdit(addressData);
                }
            }
        });
}

function loadDistrictsForEdit(addressData) {
    fetch(`<?= base_url("address/districts") ?>/${addressData.city_id}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('editDistrictProfile');
            select.innerHTML = '<option value="">Pilih Kecamatan</option>';
            
            if (data.success && data.data) {
                data.data.forEach(district => {
                    const selected = district.id == addressData.district_id ? 'selected' : '';
                    select.innerHTML += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                });
                select.disabled = false;
                
                // Trigger load villages
                if (addressData.district_id) {
                    loadVillagesForEdit(addressData);
                }
            }
        });
}

function loadVillagesForEdit(addressData) {
    fetch(`<?= base_url("address/villages") ?>/${addressData.district_id}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('editVillageProfile');
            select.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            
            if (data.success && data.data) {
                data.data.forEach(village => {
                    const selected = village.id == addressData.village_id ? 'selected' : '';
                    select.innerHTML += `<option value="${village.id}" ${selected}>${village.name}</option>`;
                });
                select.disabled = false;
            }
        });
}

// Edit form handlers
document.getElementById('editProvinceProfile')?.addEventListener('change', function () {
    const provinceId = this.value;
    const citySelect = document.getElementById('editCityProfile');
    const districtSelect = document.getElementById('editDistrictProfile');
    const villageSelect = document.getElementById('editVillageProfile');
    
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
            });
    }
});

document.getElementById('editCityProfile')?.addEventListener('change', function () {
    const cityId = this.value;
    const districtSelect = document.getElementById('editDistrictProfile');
    const villageSelect = document.getElementById('editVillageProfile');
    
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
            });
    }
});

document.getElementById('editDistrictProfile')?.addEventListener('change', function () {
    const districtId = this.value;
    const villageSelect = document.getElementById('editVillageProfile');
    
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
            });
    }
});

// Auto postal code for edit form
document.getElementById('editVillageProfile')?.addEventListener('change', function () {
    const villageId = this.value;
    if (villageId) {
        fetch(`<?= base_url("address/postal-code") ?>/${villageId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.postal_code) {
                    document.getElementById('editZipCode').value = data.postal_code;
                }
            })
            .catch(err => console.error('Error:', err));
    }
});

function submitEditAddressProfile() {
    const form = document.getElementById('formEditAddressProfile');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'flex';

    fetch('<?= base_url("address/update") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (overlay) overlay.style.display = 'none';
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        if (overlay) overlay.style.display = 'none';
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
<?= $this->endSection() ?>