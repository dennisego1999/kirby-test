<script setup>
	defineProps({
		translations: Array
	});

	// Define functions
	function importTranslations() {
		console.log('import translations');
	}
	function arrayToCsv(data) {
		let copy = [...data];

		// Get all possible keys from all objects
		const allKeys = copy.reduce((keys, row) => {
			Object.keys(row).forEach((key) => keys.add(key));
			return keys;
		}, new Set());

		// Create header row using all possible keys
		const headerRow = Object.fromEntries([...allKeys].map((key) => [key, key]));
		copy.unshift(headerRow);

		return copy
			.map((row) => {
				// Ensure all keys exist in each row, fill missing with empty string
				return [...allKeys].map((key) => row[key] || '');
			})
			.map((row) =>
				row
					.map(String)
					.map((v) => v.replaceAll('"', '""'))
					.map((v) => `"${v}"`)
					.join(',')
			)
			.join('\r\n');
	}

	function downloadBlob(content, contentType) {
		// Create a blob
		var blob = new Blob([content], { type: contentType });
		var url = URL.createObjectURL(blob);

		// Create a link to download it
		var pom = document.createElement('a');
		pom.href = url;
		pom.setAttribute('download', `export_translations_${Date.now()}`);
		pom.click();
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
					Export translations
				</k-button>

				<k-button
					@click="importTranslations"
					variant="filled"
					icon="file"
				>
					Import translations
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