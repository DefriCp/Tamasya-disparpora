
  let kecamatanData = [];

  document.addEventListener("DOMContentLoaded", async () => {
    const kecSelect = document.getElementById("kecamatanSelect");
    const desaSelect = document.getElementById("desaSelect");

    try {
      const res = await fetch("http://127.0.0.1:8000/api/kecamatan");
      const result = await res.json();

      console.log("Hasil API:", result); // cek apakah array atau object

      // jika result array langsung
      if (Array.isArray(result)) {
        kecamatanData = result;
      } else if (result.data && Array.isArray(result.data)) {
        kecamatanData = result.data;
      } else {
        throw new Error("Format API tidak sesuai, bukan array");
      }

      // isi dropdown kecamatan
      kecamatanData.forEach((item) => {
        const opt = document.createElement("option");
        opt.value = item.id; // pakai id (angka)
        opt.textContent = item.nama;
        kecSelect.appendChild(opt);
      });

      // event pilih kecamatan
      kecSelect.addEventListener("change", () => {
        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

        const selectedId = parseInt(kecSelect.value);
        const kecamatan = kecamatanData.find(k => k.id === selectedId);

        if (kecamatan && Array.isArray(kecamatan.desas)) {
          kecamatan.desas.forEach((desa) => {
            const opt = document.createElement("option");
            opt.value = desa.id;
            opt.textContent = desa.nama;
            desaSelect.appendChild(opt);
          });
        }
      });
    } catch (err) {
      console.error("Gagal memuat data:", err);
    }
  });
