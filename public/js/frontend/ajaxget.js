$(document).ready(function () {
    const apiUrl = "/get-berita-kabtsm";
    // const apiUrl = "https://tasikmalayakab.go.id/wp-json/wp/v2/posts";
    const container = $("#news-container");
    const loading = $("#loading");

    // Ambil data berita kabupaten tasik
    $.ajax({
        url: apiUrl,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            loading.show(); // Show loading animation
        },
        success: function (data) {
            loading.hide(); // Hide loading animation

            if (data.length > 0) {
                data.forEach((post) => {
                    // Ekstrak URL gambar dari content.rendered
                    const imgRegex = /<img.*?src=["'](.*?)["']/;
                    const match = imgRegex.exec(post.content.rendered);
                    const imageUrl = match
                        ? match[1]
                        : "https://via.placeholder.com/500x160?text=No+Image";

                    const card = `
                        <div class="swiper-slide">
                            <div class="group border border-gray-200 duration-200 bg-white rounded-2xl overflow-hidden hover:shadow-[0_4px_8px_rgba(0,0,25,0.1)] transition-shadow w-full h-auto">
                                <img src="${imageUrl}" class="line-clamp-2" alt="${
                        post.title.rendered
                    }"
                                    style="aspect-ratio: 4/3; width:100%; object-fit:cover;">
                                <div class="flex flex-col justify-between p-4">
                                    <div class="flex items-center mb-2 space-x-2 text-sm text-gray-500">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>${new Date(
                                            post.date
                                        ).toLocaleDateString("id-ID", {
                                            weekday: "long",
                                            year: "numeric",
                                            month: "long",
                                            day: "numeric",
                                        })}</span>
                                    </div>
                                    <a href="${
                                        post.link
                                    }" target="_blank" class="h-12 overflow-hidden font-semibold duration-150">
                                        ${post.title.rendered}
                                    </a>
                                  <p class="mt-2 text-sm text-gray-600 line-clamp-2">${post.excerpt.rendered.replace(
                                      /<\/?[^>]+(>|$)/g,
                                      ""
                                  )}</p>
                                </div>
                            </div>
                        </div>`;
                    container.append(card);
                });
            } else {
                container.html(
                    '<p class="text-gray-500">Tidak ada berita saat ini.</p>'
                );
            }
        },
        error: function (error) {
            loading.hide(); // Hide loading animation
            container.html(
                '<p class="text-red-500 text-center">Gagal memuat berita. Coba refresh kembali.</p>'
            );
            console.error("Error:", error);
        },
    });

    $(".btn-tab").on("click", function () {
        var tipe = $(this).text().trim().toLowerCase(); // terbaru / terpopuler

        // Tampilkan konten sesuai tombol
        $("#konten-terbaru, #konten-terpopuler, #konten-pengumuman").addClass(
            "hidden"
        );
        $("#konten-" + tipe).removeClass("hidden");

        // Toggle class pada tombol
        if (tipe === "terbaru") {
            $("#btn-terbaru")
                .removeClass("btn-color-custom")
                .addClass("btn-color-primary");
            $("#btn-terpopuler")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-pengumuman")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-lihatSemuaBerita").addClass("block").removeClass("hidden");
        } else if (tipe === "terpopuler") {
            $("#btn-terpopuler")
                .removeClass("btn-color-custom")
                .addClass("btn-color-primary");
            $("#btn-terbaru")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-pengumuman")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-lihatSemuaBerita").addClass("block").removeClass("hidden");
        } else if (tipe === "pengumuman") {
            $("#btn-pengumuman")
                .removeClass("btn-color-custom")
                .addClass("btn-color-primary");
            $("#btn-terbaru")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-terpopuler")
                .removeClass("btn-color-primary")
                .addClass("btn-color-custom");
            $("#btn-lihatSemuaBerita").addClass("hidden").removeClass("block");
        }
    });
});
