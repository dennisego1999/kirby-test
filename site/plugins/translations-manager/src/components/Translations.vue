<script setup>
	// Define props
	defineProps({
		translations: Array
	});

	// Define functions
	function arrayToCsv(data) {
		// Structure the data by type and key first, then locales as columns
		const structuredData = {};

		// Group translations by type and key
		data.forEach((row) => {
			const { type, key, value, locale } = row;
			if (!structuredData[key]) {
				structuredData[key] = { type, key, values: {} };
			}
			structuredData[key].values[locale] = value;
		});

		// Collect all locales (columns)
		const locales = Array.from(
			new Set(data.map((row) => row.locale))
		).sort();

		// Prepare the CSV rows
		const csvRows = [];

		// Add the header row (Type, Key, and all locales)
		const headerRow = ['TYPE', 'KEY', ...locales.map(locale => locale.toUpperCase())];
		csvRows.push(headerRow.join(','));

		// Add rows for each translation key
		Object.values(structuredData).forEach((item) => {
			const row = [
				item.type,
				item.key,
				...locales.map((locale) => item.values[locale] || ''),
			];
			csvRows.push(row.join(','));
		});

		// Return the CSV string
		return csvRows.join('\r\n');
	}

	function downloadBlob(content, contentType) {
		const blob = new Blob([content], { type: contentType });
		const url = URL.createObjectURL(blob);

		const pom = document.createElement('a');
		pom.href = url;
		pom.setAttribute('download', `export_translations_${Date.now()}.csv`);
		pom.click();
	}

	function onUploadClick(event) {
		let options = {
			"accept": "*",
			"attributes": {},
			"files": [],
			"max": null,
			"multiple": false,
			"replacing": null,
			"url": '/translations-manager/import-translations'
		}

		window.panel.upload.pick(options);
	}
</script>

<template>
	<k-inside>
		<k-view class="k-submissions-view">
			<k-header>
				Translations Manager
			</k-header>

			<div class="buttons-container">
				<k-button
					@click="downloadBlob(arrayToCsv(translations), 'text/csv;charset=utf-8;')"
					variant="filled"
					icon="download"
				>
					Export
				</k-button>

				<k-button
					icon="upload"
					variant="filled"
					@click="onUploadClick"
				>
					Import
				</k-button>
			</div>
		</k-view>
	</k-inside>
</template>

<style>
	.buttons-container {
		display: flex;
		justify-content: flex-end;
		align-items: center;
		gap: 12px;
	}
</style>
