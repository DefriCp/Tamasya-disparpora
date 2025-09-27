let chartTotalPerBulan, chartTop5, chartDropdown;

function loadDataPengunjung() {
    // === Dummy Data ===
    const dummyData = [
        { wisata: "Kampung Naga", bulan: "Jan", jumlah: 1200 },
        { wisata: "Kampung Naga", bulan: "Feb", jumlah: 1500 },
        { wisata: "Kampung Naga", bulan: "Mar", jumlah: 1800 },
        { wisata: "Kampung Naga", bulan: "Apr", jumlah: 1400 },
        { wisata: "Galunggung", bulan: "Jan", jumlah: 1000 },
        { wisata: "Galunggung", bulan: "Feb", jumlah: 1200 },
        { wisata: "Galunggung", bulan: "Mar", jumlah: 1600 },
        { wisata: "Pantai Cipatujah", bulan: "Jan", jumlah: 800 },
        { wisata: "Pantai Cipatujah", bulan: "Feb", jumlah: 1000 },
        { wisata: "Pantai Cipatujah", bulan: "Mar", jumlah: 1200 },
        { wisata: "Situ Gede", bulan: "Jan", jumlah: 600 },
        { wisata: "Situ Gede", bulan: "Feb", jumlah: 700 },
        { wisata: "Situ Gede", bulan: "Mar", jumlah: 900 },
        { wisata: "Rajapolah", bulan: "Jan", jumlah: 500 },
        { wisata: "Rajapolah", bulan: "Feb", jumlah: 600 },
        { wisata: "Rajapolah", bulan: "Mar", jumlah: 800 },
        { wisata: "Karang Tawulan", bulan: "Jan", jumlah: 400 },
        { wisata: "Karang Tawulan", bulan: "Feb", jumlah: 500 },
        { wisata: "Karang Tawulan", bulan: "Mar", jumlah: 700 }
    ];

    const labels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

    // Kelompokkan data per wisata
    const wisataData = {};
    dummyData.forEach(item => {
        if (!wisataData[item.wisata]) wisataData[item.wisata] = Array(12).fill(0);
        const bulanIndex = labels.indexOf(item.bulan);
        if (bulanIndex >= 0) {
            wisataData[item.wisata][bulanIndex] = item.jumlah;
        }
    });

    // === Grafik 1: Total Pengunjung Per Bulan ===
    const totalPerBulan = labels.map((_, i) => {
        return Object.values(wisataData).reduce((sum, arr) => sum + arr[i], 0);
    });

    chartTotalPerBulan = new Chart(document.getElementById("kunjunganChart"), {
        type: "line",
        data: {
            labels,
            datasets: [{
                label: "Total Pengunjung",
                data: totalPerBulan,
                borderColor: "rgba(34,197,94,1)",
                backgroundColor: "rgba(34,197,94,0.3)",
                fill: true,
                tension: 0.3
            }]
        }
    });

    // === Grafik 2: Top 5 Wisata ===
    const totalPerWisata = Object.entries(wisataData).map(([wisata, arr]) => ({
        wisata,
        total: arr.reduce((a, b) => a + b, 0)
    }));
    const top5 = totalPerWisata.sort((a, b) => b.total - a.total).slice(0, 5);

    chartTop5 = new Chart(document.getElementById("chartTop5"), {
        type: "bar",
        data: {
            labels: top5.map(x => x.wisata),
            datasets: [{
                label: "Total Pengunjung",
                data: top5.map(x => x.total),
                backgroundColor: "rgba(59,130,246,0.7)"
            }]
        },
        options: { indexAxis: "y" }
    });

    // === Isi Dropdown ===
    const filter = $("#wisataFilter");
    filter.empty();
    Object.keys(wisataData).forEach(wisata => {
        filter.append(`<option value="${wisata}">${wisata}</option>`);
    });

    // === Grafik 3: Dropdown Filter ===
    const ctxDropdown = document.getElementById("chartDropdown").getContext("2d");
    chartDropdown = new Chart(ctxDropdown, {
        type: "bar",
        data: { labels, datasets: [] },
        options: { responsive: true }
    });

    // Tentukan default wisata (ambil yang total terbanyak)
    const defaultWisata = totalPerWisata.sort((a, b) => b.total - a.total)[0].wisata;
    filter.val([defaultWisata]); // set dropdown selected

    // Render grafik pertama kali
    updateDropdownChart([defaultWisata], wisataData);

    // Event ketika dropdown berubah
    filter.on("change", function () {
        const selected = $(this).val() || [];
        updateDropdownChart(selected, wisataData);
    });

}

function updateDropdownChart(selected, wisataData) {
    const colors = [
        "rgba(34,197,94,0.7)", "rgba(59,130,246,0.7)", "rgba(234,88,12,0.7)",
        "rgba(139,92,246,0.7)", "rgba(244,63,94,0.7)", "rgba(16,185,129,0.7)"
    ];

    const datasets = selected.map((wisata, index) => ({
        label: wisata,
        data: wisataData[wisata],
        backgroundColor: colors[index % colors.length]
    }));

    chartDropdown.data.datasets = datasets;
    chartDropdown.update();
}


loadDataPengunjung();
