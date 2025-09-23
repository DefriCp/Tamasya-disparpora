let kecamatanLayer, desaLayer;
let kecSelect, desaSelect;
// --- ambil data API untuk dropdown ---
let kecamatanData = [];

// Fungsi load GeoJSON manual
async function loadGeoJSON(url, style) {
    const res = await fetch(url);
    const geojson = await res.json();
    return L.geoJSON(geojson, { style });
}

document.addEventListener("DOMContentLoaded", async () => {
    const kecSelect = document.getElementById("kecamatanSelect");
    const desaSelect = document.getElementById("desaSelect");

    // --- load layer kecamatan & desa ---
    kecamatanLayer = await loadGeoJSON("/assets/geojson/kecamatan.geojson", {
        color: "white",
        weight: 1,
    });
    desaLayer = await loadGeoJSON("/assets/geojson/desa.geojson", {
        color: "gray",
        weight: 0.5,
        fillOpacity: 0.2,
    });

    kecamatanLayer.addTo(map);
    // desaLayer.addTo(map);

    try {
        const res = await fetch("http://127.0.0.1:8000/api/kecamatan");
        const result = await res.json();
        kecamatanData = Array.isArray(result) ? result : result.data || [];

        kecamatanData.forEach((item) => {
            const opt = document.createElement("option");
            opt.value = item.nama; // langsung pakai nama
            opt.textContent = item.nama;
            kecSelect.appendChild(opt);
        });
        // render tabel default semua kecamatan
        renderTableKecamatan(kecamatanData);
        // === Event pilih kecamatan ===
        kecSelect.addEventListener("change", () => {
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
            resetHighlight(kecamatanLayer);
            resetHighlight(desaLayer);

            const namaKec = kecSelect.value.trim().toLowerCase();

            const kecamatan = kecamatanData.find(
                (k) => k.nama.trim().toLowerCase() === namaKec
            );

            // isi desa
            if (kecamatan && Array.isArray(kecamatan.desas)) {
                kecamatan.desas.forEach((desa) => {
                    const opt = document.createElement("option");
                    opt.value = desa.id;
                    opt.textContent = desa.nama;
                    desaSelect.appendChild(opt);
                });

                // render tabel desa
                renderTableDesa(kecamatan.desas);
            } else {
                // kalau reset / tidak ada pilihan, balik ke tabel kecamatan
                renderTableKecamatan(kecamatanData);
            }

            // zoom ke polygon kecamatan
            let found = false;
            kecamatanLayer.eachLayer((layer) => {
                const namaGeo =
                    layer.feature.properties.WADMKC.trim().toLowerCase();
                if (namaGeo === namaKec) {
                    map.fitBounds(layer.getBounds());
                    layer.setStyle({
                        color: "red",
                        weight: 2,
                        fillOpacity: 0.5,
                    });
                    found = true;
                }
            });

            if (!found) {
                console.warn("Kecamatan tidak ditemukan di geojson:", namaKec);
            }
        });

        // === Event pilih desa ===
        desaSelect.addEventListener("change", () => {
            if (!map.hasLayer(desaLayer)) {
                desaLayer.addTo(map);
            }
            resetHighlight(desaLayer);

            // const namaDesa =
            //     desaSelect.options[desaSelect.selectedIndex].textContent.trim();
            const selectedIndex = desaSelect.selectedIndex;
            if (selectedIndex === -1) return; // kalau belum ada pilihan, stop

            const namaDesa = desaSelect.options[selectedIndex].textContent;

            desaLayer.eachLayer((layer) => {
                if (
                    layer.feature.properties.WADMKD.trim().toLowerCase() ===
                    namaDesa.toLowerCase()
                ) {
                    map.fitBounds(layer.getBounds());
                    layer.setStyle({
                        color: "orange",
                        weight: 2,
                        fillOpacity: 0.6,
                    });
                }
            });

            // filter wisata sesuai desa
            const wisataDesa = wisataData.filter((w) => w.desa === namaDesa);
            renderTableWisata(wisataDesa);
        });
    } catch (err) {
        console.error("Gagal memuat data:", err);
    }
});

// reset style
function resetHighlight(layerGroup) {
    layerGroup.eachLayer((layer) => {
        layer.setStyle({ color: "white", weight: 1, fillOpacity: 0.3 });
    });
}
// ===============================================================
// Fungsi untuk render tabel
// ===============================================================
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("btn-buka")) {
        e.preventDefault();

        const type = e.target.getAttribute("data-type");
        const nama = e.target.getAttribute("data-nama");

        const kecSelect = document.getElementById("kecamatanSelect");
        const desaSelect = document.getElementById("desaSelect");

        if (type === "kecamatan" && kecSelect) {
            kecSelect.value = nama;
            kecSelect.dispatchEvent(new Event("change"));
        } else if (type === "desa" && desaSelect) {
            // cari kecamatan induk dari desa
            const kecamatan = kecamatanData.find(
                (k) => k.desas && k.desas.some((d) => d.nama === nama)
            );

            if (kecamatan) {
                // isi ulang dropdown desa
                desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                kecamatan.desas.forEach((desa) => {
                    const opt = document.createElement("option");
                    opt.value = desa.nama;
                    opt.textContent = desa.nama;
                    desaSelect.appendChild(opt);
                });

                // pilih desa yang sesuai
                desaSelect.value = nama;
                desaSelect.dispatchEvent(new Event("change")); // trigger zoom
            } else {
                console.warn("Desa tidak ditemukan di kecamatanData:", nama);
            }
        }
    }
});

function renderTableKecamatan(data) {
    const tbody = document.querySelector("#dataTable tbody");
    const tfoot = document.querySelector("#dataTable tfoot");
    const theadNama = document.querySelector("#dataTable thead th:nth-child(2)");

    tbody.innerHTML = "";
    theadNama.textContent = "Kecamatan";

    let totalWisata = 0;

    data.forEach((item, idx) => {
        const jmlWisata = wisataData.filter(
            (w) => w.kecamatan?.toLowerCase() === item.nama.toLowerCase()
        ).length;

        totalWisata += jmlWisata; // ✅ tambahkan ke total

        const tr = document.createElement("tr");
        tr.className = "transition border-b hover:bg-gray-50";
        tr.innerHTML = `
            <td class="px-4 py-3">
                <span class="flex items-center justify-center font-bold text-blue-600 bg-blue-100 rounded-full w-7 h-7">
                    ${idx + 1}
                </span>
            </td>
            <td class="px-4 py-3 font-medium">${item.nama}</td>
            <td class="px-4 py-3">
                <a href="#"
                   class="font-medium text-blue-600 hover:underline btn-buka"
                   data-type="kecamatan"
                   data-nama="${item.nama}">
                   Buka
                </a>
            </td>
        `;
        tbody.appendChild(tr);
    });

    
}

function renderTableDesa(data) {
    const tbody = document.querySelector("#dataTable tbody");
    const tfoot = document.querySelector("#dataTable tfoot");
    const theadNama = document.querySelector("#dataTable thead th:nth-child(2)");

    tbody.innerHTML = "";
    theadNama.textContent = "Desa";

    let totalWisata = 0;

    data.forEach((item, idx) => {
        const jmlWisata = wisataData.filter(
            (w) => w.desa?.toLowerCase() === item.nama.toLowerCase()
        ).length;

        totalWisata += jmlWisata; // ✅ tambahkan ke total

        const tr = document.createElement("tr");
        tr.className = "transition border-b hover:bg-gray-50";
        tr.innerHTML = `
            <td class="px-4 py-3">
                <span class="flex items-center justify-center font-bold text-blue-600 bg-blue-100 rounded-full w-7 h-7">
                    ${idx + 1}
                </span>
            </td>
            <td class="px-4 py-3 font-medium">${item.nama}</td>
           
            <td class="px-4 py-3">
                <a href="#"
                   class="font-medium text-blue-600 hover:underline btn-buka"
                   data-type="desa"
                   data-nama="${item.nama}">
                   Buka
                </a>
            </td>
        `;
        tbody.appendChild(tr);
    });

}


let wisataData = [];

// fetch wisata data sekali di awal
fetch("http://127.0.0.1:8000/api/tamasyawisata")
    .then((res) => res.json())
    .then((data) => {
        wisataData = data.data;
    });

// render tabel wisata
function renderTableWisata(data) {
    const tbody = document.querySelector("#dataTable tbody");
    const theadNama = document.querySelector(
        "#dataTable thead th:nth-child(2)"
    );
    const theadJumlah = document.querySelector(
        "#dataTable thead th:nth-child(3)"
    );
    tbody.innerHTML = "";

    theadNama.textContent = "Wisata";
    theadJumlah.textContent = "Jenis";

    let total = 0;

    data.forEach((item, idx) => {
        const tr = document.createElement("tr");
        tr.className = "transition border-b hover:bg-gray-50";

        tr.innerHTML = `
          <td class="px-4 py-3">
            <span class="flex items-center justify-center font-bold text-blue-600 bg-blue-100 rounded-full w-7 h-7">
              ${idx + 1}
            </span>
          </td>
          <td class="px-4 py-3 font-medium">${item.potensi_unggulan}</td>
          <td class="px-4 py-3 font-semibold text-gray-700">${item.jenis?.join(", ") ?? "-"
            }</td>
          <td class="px-4 py-3">
            <a href="/tamasya-wisata/${item.slug
            }" target="_blank" rel="noopener"
               class="font-medium text-blue-600 hover:underline">
               Detail
            </a>
          </td>
        `;

        tbody.appendChild(tr);
        total++;
    });

    // update tfoot
    const tfootCell = document.querySelector("#dataTable tfoot td");
    if (tfootCell) {
        tfootCell.textContent = `Total Wisata: ${total}`;
    }
}

// ===============================================================
// Akhir fungsi untuk render tabel
// ===============================================================
