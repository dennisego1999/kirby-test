import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import path from 'path';
import checker from 'vite-plugin-checker';

const artomicViewsDir = 'site/views';

const config = {
	plugins: [
		laravel({
			input: [`${artomicViewsDir}/06_layouts/app/app.scss`, `${artomicViewsDir}/06_layouts/app/app.ts`],
			refresh: [`site/**/**/*`],
			detectTls: 'plainkit.test', // needed if name of project is different from the domain
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
};
export default defineConfig(config);
