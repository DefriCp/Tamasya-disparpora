let chartTotalPerBulan, chartTop5, chartDropdown;

const API_URL = "http://tamasya.tasikmalayakab.go.id/api/jumlahkunjunganwisata"; // ganti sesuai endpoint
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

// function transformData(items) {
//     // items must be an array of wisata objects
//     const wisataData = {};
//     (items || []).forEach(w => {
//         const name = w.nama || w.name || "Unknown";
//         wisataData[name] = Array(12).fill(0);

//         if (Array.isArray(w.jumlahpengunjung)) {
//             w.jumlahpengunjung.forEach(jp => {
//                 const idx = monthToIndex(jp.bulan || jp.month || "");
//                 const val = Number(jp.jumlah) || 0;
//                 if (idx >= 0) wisataData[name][idx] = val;
//             });
//         }
//     });
//     return wisataData;
// }

function transformData(items) {
    const wisataData = {};

    (items || []).forEach(w => {
        const name = w.destinasi_wisata || "Unknown";
        wisataData[name] = Array(12).fill(0);

        const bulanKeys = [
            "januari", "februari", "maret", "april", "mei", "juni",
            "juli", "agustus", "september", "oktober", "november", "desember"
        ];

        bulanKeys.forEach((bulan, i) => {
            const val = w[bulan];
            // kalau string "Data Belum Ada" → 0, kalau angka → parseInt
            wisataData[name][i] = isNaN(val) ? 0 : Number(val);
        });
    });

    return wisataData;
}

function destroyChartsIfExist() {
    if (chartTotalPerBulan) { try { chartTotalPerBulan.destroy(); } catch (e) { } chartTotalPerBulan = null; }
    if (chartTop5) { try { chartTop5.destroy(); } catch (e) { } chartTop5 = null; }
    if (chartDropdown) { try { chartDropdown.destroy(); } catch (e) { } chartDropdown = null; }
}

function renderTotalPerBulan(wisataData) {
    const ctx = document.getElementById("kunjunganChart").getContext("2d");

    const totalPerBulan = labels.map((_, i) =>
        Object.values(wisataData).reduce((s, arr) => s + (arr[i] || 0), 0)
    );

    // gradient fill hijau
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, "rgba(34,197,94,0.5)");
    gradient.addColorStop(1, "rgba(34,197,94,0.1)");

    return new Chart(ctx, {
        type: "line",
        data: {
            labels,
            datasets: [{
                label: "Total Pengunjung",
                data: totalPerBulan,
                borderColor: "rgba(34,197,94,1)",
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: "rgba(34,197,94,1)",
                pointHoverBackgroundColor: "rgba(16,185,129,1)",
                pointBorderWidth: 2,
                pointHoverBorderWidth: 2,
                segment: {
                    borderColor: ctx => {
                        // garis lebih hidup, bisa kasih shadow efek ringan
                        return "rgba(34,197,94,1)";
                    }
                }
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { font: { size: 13 } }
                },
                tooltip: {
                    backgroundColor: "rgba(30,41,59,0.9)",
                    titleFont: { size: 14, weight: "bold" },
                    bodyFont: { size: 13 },
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    grid: { color: "rgba(0,0,0,0.05)" },
                    ticks: { font: { size: 12 } }
                }
            },
            animation: {
                duration: 1200,
                easing: "easeOutQuart"
            }
        }
    });
}


function renderTop5(wisataData) {
    const ctx = document.getElementById("chartTop5").getContext("2d");

    // hitung total per wisata
    const totals = Object.entries(wisataData).map(([w, arr]) => ({
        w,
        total: arr.reduce((a, b) => a + (b || 0), 0)
    }));
    const top5 = totals.sort((a, b) => b.total - a.total).slice(0, 3);

    // gradient generator
    function getGradient(ctx, color1, color2) {
        const gradient = ctx.createLinearGradient(0, 0, 300, 0);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    }

    // shadow plugin
    const shadowPlugin = {
        id: "shadow",
        beforeDatasetsDraw(chart) {
            const ctx = chart.ctx;
            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar) => {
                    ctx.save();
                    ctx.shadowColor = "rgba(0,0,0,0.15)";
                    ctx.shadowBlur = 8;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 4;
                    bar.draw(ctx);
                    ctx.restore();
                });
            });
        }
    };

    // hapus chart lama biar gak duplikat
    if (chartTop5) {
        chartTop5.destroy();
    }

    chartTop5 = new Chart(ctx, {
        type: "bar",
        data: {
            labels: top5.map(x => x.w),
            datasets: [{
                label: "Total Pengunjung",
                data: top5.map(x => x.total),
                backgroundColor: (ctx) =>
                    getGradient(
                        ctx.chart.ctx,
                        "rgba(34,197,94,0.9)", // hijau tua
                        "rgba(34,197,94,0.2)"  // hijau muda transparan
                    ),
                borderRadius: 12,
                barThickness: 26
            }]
        },
        options: {
            indexAxis: "y",
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgba(30,41,59,0.9)",
                    titleFont: { size: 14, weight: "bold" },
                    bodyFont: { size: 13 },
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                x: {
                    grid: { color: "rgba(0,0,0,0.05)" },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    grid: { display: false },
                    ticks: { font: { size: 13, weight: "bold" } }
                }
            },
            animation: {
                duration: 1200,
                easing: "easeOutQuart"
            }
        },
        plugins: [shadowPlugin]
    });


    return chartTop5;
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
        updateDropdownChart([selected], wisataData);
    });
}

function updateDropdownChart(selected, wisataData) {
    const ctxDropdown = document.getElementById("chartDropdown").getContext("2d");

    // Hapus chart lama biar gak error "canvas already in use"
    if (chartDropdown) {
        chartDropdown.destroy();
    }

    // Fungsi bikin gradient
    function getGradient(ctx, color1, color2) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    }

    // Warna untuk tiap dataset
    const colorPairs = [
        ["rgba(34,197,94,0.9)", "rgba(34,197,94,0.2)"],   // hijau
        ["rgba(59,130,246,0.9)", "rgba(59,130,246,0.2)"], // biru
        ["rgba(234,88,12,0.9)", "rgba(234,88,12,0.2)"],   // oranye
        ["rgba(139,92,246,0.9)", "rgba(139,92,246,0.2)"], // ungu
        ["rgba(244,63,94,0.9)", "rgba(244,63,94,0.2)"]    // merah
    ];

    const datasets = selected.map((wisata, i) => ({
        label: "Jumlah Pengunjung",
        data: wisataData[wisata],
        backgroundColor: (ctx) =>
            getGradient(ctx.chart.ctx, colorPairs[i % colorPairs.length][0], colorPairs[i % colorPairs.length][1]),
        borderRadius: 12,
        barThickness: 30
    }));

    // Plugin untuk shadow
    const shadowPlugin = {
        id: "shadow",
        beforeDatasetsDraw(chart) {
            const ctx = chart.ctx;
            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar) => {
                    ctx.save();
                    ctx.shadowColor = "rgba(0,0,0,0.15)";
                    ctx.shadowBlur = 8;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 4;
                    bar.draw(ctx);
                    ctx.restore();
                });
            });
        }
    };

    // Buat chart baru
    chartDropdown = new Chart(ctxDropdown, {
        type: "bar",
        data: {
            labels: [
                "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
            ],
            datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        usePointStyle: true,
                        pointStyle: "circle",
                        padding: 20,
                        font: { size: 13 }
                    }
                },
                tooltip: {
                    backgroundColor: "rgba(30,41,59,0.9)",
                    titleFont: { size: 14, weight: "bold" },
                    bodyFont: { size: 13 },
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 18 } }
                },
                y: {
                    grid: { color: "rgba(0,0,0,0.05)" },
                    ticks: { font: { size: 12 } }
                }
            },
            animation: {
                duration: 1200,
                easing: "easeOutBounce"
            }
        },
        plugins: [shadowPlugin]
    });
}


// MAIN
// async function loadDataPengunjung() {
//     try {
//         const raw = await fetchWisataData();
//         // console.log("API raw response:", raw); // bantu debug kalau masih ada masalah
//         // support bentuk: [] atau { data: [...] }
//         const items = Array.isArray(raw) ? raw : (raw && Array.isArray(raw.data) ? raw.data : []);
//         const wisataData = transformData(items);

//         destroyChartsIfExist();

//         // kalau tidak ada data, bikin charts kosong (supaya UI tetap konsisten)
//         if (Object.keys(wisataData).length === 0) {
//             console.warn("Tidak ada data wisata (kosong).");
//             // buat dataset kosong dengan nol
//             const empty = {};
//             empty["Tidak ada data"] = Array(12).fill(0);
//             chartTotalPerBulan = renderTotalPerBulan(empty);
//             chartTop5 = renderTop5(empty);
//             setupDropdown(empty);
//             return;
//         }

//         chartTotalPerBulan = renderTotalPerBulan(wisataData);
//         chartTop5 = renderTop5(wisataData);
//         setupDropdown(wisataData);

//     } catch (err) {
//         console.error("Gagal load data pengunjung:", err);
//         alert("Gagal memuat data pengunjung. Cek console untuk detail.");
//     }
// }

async function loadDataPengunjung() {
    try {
        const raw = await fetchWisataData();
        const items = Array.isArray(raw) ? raw : (raw && Array.isArray(raw.data) ? raw.data : []);
        const wisataData = transformData(items);

        destroyChartsIfExist();

        if (Object.keys(wisataData).length === 0) {
            console.warn("Tidak ada data wisata (kosong).");
            const empty = { "Tidak ada data": Array(12).fill(0) };
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
