<script setup>
	defineProps({
		translations: Array
	});

	// Define functions
	function exportTranslations() {
		console.log('expor ttranslations!');
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
					@click="exportTranslations"
					variant="filled"
					icon="download"
				>
					Export translations
				</k-button>

				<k-button
					@click="exportTranslations"
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