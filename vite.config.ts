import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import path from 'path';
import checker from 'vite-plugin-checker';

const artomicViewsDir = 'site/views';

const config = {
	plugins: [
		laravel({
			input: [
				`${artomicViewsDir}/06_layouts/app/app.scss`,
				`${artomicViewsDir}/06_layouts/app/app.ts`,
				`${artomicViewsDir}/00_panel/panel-development.scss`,
				`${artomicViewsDir}/00_panel/panel-staging.scss`,
				`${artomicViewsDir}/00_panel/panel-production.scss`,
				`${artomicViewsDir}/00_panel/panel.scss`,
				`${artomicViewsDir}/00_panel/panel.ts`,
			],
			refresh: [`site/**/**/*`],
		}),
		checker({
			overlay: true,
			typescript: true,
		}),
		sassGlobImports(),
	],
	resolve: {
		alias: {
			'@views': path.resolve(__dirname, 'site/views'),
			'@node_modules': path.resolve(__dirname, 'node_modules'),
		},
	},
	server: {},
};

if (process.env.DDEV_PRIMARY_URL) {
	config.server = {
		host: '0.0.0.0',
		port: 5173,
		strictPort: true,
		origin: `${process.env.DDEV_PRIMARY_URL.replace(/:\d+$/, "")}:5173`,
		cors: {
			origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(\.ddev\.site)(?::\d+)?$/,
		},
	};
}

export default defineConfig(config);
