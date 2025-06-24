<template>
    <div class="w-full py-3 overflow-x-auto">
		<div class="flex gap-1 justify-center items-center"></div>
			<button
			v-for="(link, index) in links"
			:key="`link_${index}`"
			:class="[
			'px-3 py-1 text-sm font-medium focus:outline-none transition',
			link.active
				? 'rounded-full bg-blue-600 text-white shadow'
				: (link.url == null
				? 'rounded-full bg-gray-200 text-gray-400 border border-gray-300 cursor-not-allowed'
				: 'rounded-full bg-white text-blue-600 border border-blue-200 hover:bg-blue-50 hover:text-blue-700')
			]"
			v-html="makeLabel(link.label)"
			@click.prevent="onPaginationChangePage(link.url)"
			:disabled="link.url == null || link.active"
			></button>
	</div>
</template>

<script setup>
defineProps({
    links: {
        type: Array,
        default: []
    },
    hasParam: {
        type: Boolean,
        default: false
    }
})
const emit = defineEmits(['pagination-change-page'])

const onPaginationChangePage = (url) => {
    let page = String(url).split('page=')[1] ?? 1
    emit('pagination-change-page', page);
}

const makeLabel = (label) => {
    label = label.replace('Next ', '')
    label = label.replace(' Previous', '')
    return label
}
</script>
