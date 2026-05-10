# Pull Request Guide untuk Repository Pramanaaaa-byte

## 🎯 Tujuan
Push perubahan ke repository https://github.com/Pramanaaaa-byte/website-sekolah melalui Pull Request

## 📋 Langkah-langkah

### 1. Fork Repository
1. Buka: https://github.com/Pramanaaaa-byte/website-sekolah
2. Klik tombol "Fork" (kanan atas)
3. Pilih akun: Azmi-asshidiq
4. Klik "Create fork"
5. Tunggu proses fork selesai

### 2. Setup Remote Repository
```bash
cd c:\laragon\www\website-sekolah

# Tambahkan remote untuk fork Anda
git remote add fork https://github.com/Azmi-asshidiq/website-sekolah.git

# Push ke fork Anda
git push fork main
```

### 3. Buat Pull Request
1. Buka: https://github.com/Azmi-asshidiq/website-sekolah
2. Klik "Contribute" → "Open pull request"
3. Atur:
   - Base repository: Pramanaaaa-byte/website-sekolah
   - Base branch: main
   - Head repository: Azmi-asshidiq/website-sekolah
   - Compare branch: main
4. Isi title dan description
5. Klik "Create pull request"

### 4. Tunggu Review
- Owner Pramanaaaa-byte akan mendapat notifikasi
- Owner akan review dan merge
- Perubahan akan masuk ke repository asli

## 🔧 Cara Alternatif: Manual Commands

```bash
# Setup remote
git remote set-url origin https://github.com/Azmi-asshidiq/website-sekolah.git

# Push perubahan
git add .
git commit -m "Add database setup and debugging tools"
git push origin main

# Buat PR via GitHub UI
```

## 📱 Link Penting

- Repository Asli: https://github.com/Pramanaaaa-byte/website-sekolah
- Fork Anda: https://github.com/Azmi-asshidiq/website-sekolah
- Pull Request: https://github.com/Pramanaaaa-byte/website-sekolah/compare

## ✅ Status Checklist

- [ ] Fork repository ke akun Anda
- [ ] Push perubahan ke fork
- [ ] Buat Pull Request
- [ ] Tunggu review dari owner
- [ ] Perubahan di-merge ke repository asli

## 🎉 Hasil

Setelah PR di-merge:
- Perubahan Anda ada di repository asli
- Semua orang bisa melihat perubahan
- Kontribusi Anda tercatat di GitHub

---
**Siap untuk membuat Pull Request!**
