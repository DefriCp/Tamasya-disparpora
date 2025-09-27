let chartTotalPerBulan, chartTop5, chartDropdown;

const API_URL = "http://127.0.0.1:8000/api/tamasyawisata"; // ganti sesuai endpoint
const labels = [
    "January", "February", "March", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

// sinonim bulan (bahasa & singkatan)
const monthSynonyms = [
    ["jan", "january", "januari"],
    ["feb", "february", "februari"],
    ["mar", "march", "maret"],
    ["apr", "april"],
    ["may", "mei", "may"],
    ["jun", "june", "juni"],
    ["jul", "july", "juli"],
    ["aug", "august", "agustus"],
    ["sep", "sept", "september"],
    ["oct", "oct", "okt", "oktober", "october"],
    ["nov", "november"],
    ["dec", "december", "desember"]
];

function monthToIndex(bulan) {
    if (!bulan) return -1;
    const b = bulan.toString().trim().toLowerCase();
    // coba kecocokan lengkap dulu, lalu prefix (3 huruf)
    for (let i = 0; i < monthSynonyms.length; i++) {
        for (const syn of monthSynonyms[i]) {
            if (b === syn) return i;
        }
    }
    const b3 = b.slice(0, 3);
    for (let i = 0; i < monthSynonyms.length; i++) {
        for (const syn of monthSynonyms[i]) {
            if (syn.startsWith(b3) || b.startsWith(syn)) return i;
        }
    }
    return -1;
}

async function fetchWisataData() {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
}

function transformData(items) {
    // items must be an array of wisata objects
    const wisataData = {};
    (items || []).forEach(w => {
        const name = w.nama || w.name || "Unknown";
        wisataData[name] = Array(12).fill(0);

        if (Array.isArray(w.jumlahpengunjung)) {
            w.jumlahpengunjung.forEach(jp => {
                const idx = monthToIndex(jp.bulan || jp.month || "");
                const val = Number(jp.jumlah) || 0;
                if (idx >= 0) wisataData[name][idx] = val;
            });
        }
    });
    return wisataData;
}

function destroyChartsIfExist() {
    if (chartTotalPerBulan) { try { chartTotalPerBulan.destroy(); } catch (e) { } chartTotalPerBulan = null; }
    if (chartTop5) { try { chartTop5.destroy(); } catch (e) { } chartTop5 = null; }
    if (chartDropdown) { try { chartDropdown.destroy(); } catch (e) { } chartDropdown = null; }
}

function renderTotalPerBulan(wisataData) {
    const totalPerBulan = labels.map((_, i) =>
        Object.values(wisataData).reduce((s, arr) => s + (arr[i] || 0), 0)
    );

    return new Chart(document.getElementById("kunjunganChart"), {
        type: "line",
        data: { labels, datasets: [{ label: "Total Pengunjung", data: totalPerBulan, borderColor: "rgba(34,197,94,1)", backgroundColor: "rgba(34,197,94,0.2)", fill: true, tension: 0.3 }] }
    });
}

function renderTop5(wisataData) {
    const totals = Object.entries(wisataData).map(([w, arr]) => ({ w, total: arr.reduce((a, b) => a + (b || 0), 0) }));
    const top5 = totals.sort((a, b) => b.total - a.total).slice(0, 5);

    return new Chart(document.getElementById("chartTop5"), {
        type: "bar",
        data: {
            labels: top5.map(x => x.w), datasets: [{
                label: "Total Pengunjung",
                data: top5.map(x => x.total),
                backgroundColor: "rgba(34,197,94,0.7)",
                borderRadius: 8,
            }]
        },
        options: { indexAxis: "y" }
    });
}

function setupDropdown(wisataData) {
    const $filter = $("#wisataFilter").empty();
    Object.keys(wisataData).forEach(w => $filter.append(`<option value="${w}">${w}</option>`));

    const ctx = document.getElementById("chartDropdown").getContext("2d");
    chartDropdown = new Chart(ctx, { type: "bar", data: { labels, datasets: [] }, options: { responsive: true } });

    const totals = Object.entries(wisataData).map(([w, arr]) => ({ w, total: arr.reduce((a, b) => a + (b || 0), 0) }));
    const defaultWisata = totals.sort((a, b) => b.total - a.total)[0]?.w || null;
    if (defaultWisata) $filter.val([defaultWisata]);

    updateDropdownChart(defaultWisata ? [defaultWisata] : [], wisataData);

    $filter.on("change", function () {
        const selected = $(this).val() || [];
        updateDropdownChart(selected, wisataData);
    });
}

function updateDropdownChart(selected, wisataData) {
    const colors = ["rgba(34,197,94,0.7)", "rgba(59,130,246,0.7)", "rgba(234,88,12,0.7)", "rgba(139,92,246,0.7)", "rgba(244,63,94,0.7)", "rgba(16,185,129,0.7)"];
    const validSelected = (Array.isArray(selected) ? selected : [selected]).filter(s => wisataData[s]);
    const datasets = validSelected.map((w, i) => ({
        // label: w, 
        label: "Jumlah Pengunjung Wisata",
        data: wisataData[w],
        backgroundColor: colors[i % colors.length],
        borderRadius: 8,
    }));
    chartDropdown.data.datasets = datasets;
    chartDropdown.update();
}

// MAIN
async function loadDataPengunjung() {
    try {
        const raw = await fetchWisataData();
        // console.log("API raw response:", raw); // bantu debug kalau masih ada masalah
        // support bentuk: [] atau { data: [...] }
        const items = Array.isArray(raw) ? raw : (raw && Array.isArray(raw.data) ? raw.data : []);
        const wisataData = transformData(items);

        destroyChartsIfExist();

        // kalau tidak ada data, bikin charts kosong (supaya UI tetap konsisten)
        if (Object.keys(wisataData).length === 0) {
            console.warn("Tidak ada data wisata (kosong).");
            // buat dataset kosong dengan nol
            const empty = {};
            empty["Tidak ada data"] = Array(12).fill(0);
            chartTotalPerBulan = renderTotalPerBulan(empty);
            chartTop5 = renderTop5(empty);
            setupDropdown(empty);
            return;
        }

        chartTotalPerBulan = renderTotalPerBulan(wisataData);
        chartTop5 = renderTop5(wisataData);
        setupDropdown(wisataData);

    } catch (err) {
        console.error("Gagal load data pengunjung:", err);
        alert("Gagal memuat data pengunjung. Cek console untuk detail.");
    }
}

loadDataPengunjung();
