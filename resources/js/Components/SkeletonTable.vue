<template>
  <div v-if="loading" class="w-full animate-pulse inline-block min-w-full overflow-hidden rounded-lg shadow">
    <table class="w-full">
      <thead>
        <tr class="border-b bg-gray-100 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
          <th 
            class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
            v-for="n in columns" :key="n" >
            <div class="h-5 bg-gray-300 rounded w-full mx-auto"></div>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in rows" :key="row">
          <td
            v-for="col in columns" :key="col"
            class="border-b border-gray-100 bg-white px-5 py-5 text-sm"
        >
            <div class="h-5 bg-gray-200 rounded"></div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <slot />
  </div>
</template>

<script setup>
const props = defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
  columns: {
    type: Number,
    default: 3,
  },
  rows: {
    type: Number,
    default: 5,
  },
});
</script>

<style scoped>
.animate-pulse {
  animation: pulse 1.5s cubic-bezier(.4,0,.6,1) infinite;
}
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}
</style>
