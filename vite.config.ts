import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path';
import viteCompression from 'vite-plugin-compression';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';
import { NaiveUiResolver } from 'unplugin-vue-components/resolvers';
import { visualizer } from 'rollup-plugin-visualizer';
// https://vitejs.dev/config/
export default defineConfig({
    root: path.resolve(__dirname, 'ui/'),
    envDir: path.resolve(__dirname),
    envPrefix: "APP",
    base: "./",
    plugins: [
        vue(),
        viteCompression(),
        AutoImport({
            imports: [
                'vue',
            ]
        }),
        Components({
            resolvers: [NaiveUiResolver()]
        }),
        visualizer({
            open: true,
        })
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './ui/src'),
        },
    },
    define: {
        'process.env': process.env
    },

    optimizeDeps: {
        include: [
            "axios",
            "crypto-js",
            "vue",
            "vue-router",
            "vuex",
            'lodash-es',
            "css-doodle",
            "naive-ui"
        ],
        exclude: ['__INDEX__']
    },

    css: {
        preprocessorOptions: {
            scss: {
                additionalData: '@import "@/styles/common.scss";',
            }
        }
    },

    build: {
        reportCompressedSize: false,
        outDir: path.resolve(__dirname, 'public/statics/build/admin'),
        emptyOutDir: false,
        sourcemap: false,
        chunkSizeWarningLimit: 2500,
        manifest: true,
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
            output: {
                comments: true,
            },
        },
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return id
                            .toString()
                            .split('node_modules/')[1]
                            .split('/')[0]
                            .toString();
                    }
                },
                chunkFileNames: (chunkInfo) => {
                    const facadeModuleId = chunkInfo.facadeModuleId
                        ? chunkInfo.facadeModuleId.split('/')
                        : [];
                    const fileName =
                        facadeModuleId[facadeModuleId.length - 2] || '[name]';
                    return `js/${fileName}/[name].[hash].js`;
                }
            }
        }
    }
})
