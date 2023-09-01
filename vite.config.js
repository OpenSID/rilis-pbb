import { defineConfig, splitVendorChunkPlugin } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject"

export default defineConfig({
    emptyOutDir: false,
    plugins: [
        inject({   // => that should be first under plugins array
            $: 'jquery',
            jQuery: 'jquery',
            moment: 'moment',
        }),
        splitVendorChunkPlugin(),
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
            buildDirectory: 'build-dev'
        }),
    ],
});
