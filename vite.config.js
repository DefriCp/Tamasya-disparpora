import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    build: {
        outDir: "/build/", // direktori output (opsional, bisa disesuaikan)
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                // "resources/css/frontend.css",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
