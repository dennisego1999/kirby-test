import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import path from 'path';
import checker from 'vite-plugin-checker';

const artomicViewsDir = 'site/views';

const DDEVServer = {
	host: '0.0.0.0',
	hmr: {
		host: process.env.DDEV_HOSTNAME,
		protocol: 'wss',
	},
};

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

if (process.env.DDEV_HOSTNAME) {
	config.server = DDEVServer;
}

export default defineConfig(config);
