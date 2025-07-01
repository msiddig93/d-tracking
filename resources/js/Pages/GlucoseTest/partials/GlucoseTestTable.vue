<template>
    <div class="w-full overflow-x-auto inline-block min-w-full rounded-lg shadow">
        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" :closeable="false" maxWidth="sm" @close="showDeleteModal = false">
            <div class="p-6 text-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Delete Glucose Test</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this test? This action cannot be undone.</p>
                <div class="flex justify-center gap-4 mt-4">
                    <button
                        class="px-4 py-2 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition"
                        @click="confirmDelete"
                    >
                        Confirm
                    </button> 
                    <button
                        class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition"
                        @click="showDeleteModal = false"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </Modal>
        <!-- Table -->
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        -
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Patient
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Level
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Fasting
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Date
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        -
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="glucoseTest in glucoseTests.data" :key="glucoseTest.id" class="text-gray-700">
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ glucoseTest.id }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ glucoseTest.patient?.name ?? 'N/A' }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ glucoseTest.level }}</p>
                    </td>
                    <td class="border-b bg-white border-gray-200 px-2 py-2 text-sm">
                        <span :style="`background-color: ${glucoseTest.status_colors[0]}; color: ${glucoseTest.status_colors[1]}`" 
                        class=" whitespace-no-wrap p-2 rounded-full">{{ glucoseTest.fasting }}</span>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ glucoseTest.test_date }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <div class="flex justify-end gap-2">
                            
                            <!-- Edit Button -->
                            <button
                                v-if="false"
                                class="flex items-center gap-1 rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-semibold hover:bg-yellow-200 transition"
                                title="Edit"
                                @click="openEditModal(glucoseTest)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m-7-7h14" />
                                </svg>
                                Edit
                            </button>
                            <!-- Delete Button -->
                            <button
                                class="flex items-center gap-1 rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-semibold hover:bg-red-200 transition"
                                title="Delete"
                                @click="openDeleteModal(glucoseTest)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between overflow-x-auto">
        <Pagination 
            :links="glucoseTests.meta.links"
            v-if="glucoseTests.meta && glucoseTests.meta.links.length"
            @pagination-change-page="store.fetchGlucoseTests"
        />
    </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import { useGlucoseTestsStore } from '@/stores/glucoseTests';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';

const store = useGlucoseTestsStore();
const { glucoseTests } = storeToRefs(store);

const showDeleteModal = ref(false);
const glucoseTestToDelete = ref(null);

function openDeleteModal(glucoseTest) {
    glucoseTestToDelete.value = glucoseTest;
    showDeleteModal.value = true;
}

const openEditModal = (glucoseTest) => {
    store.setCurrentGlucoseTest(glucoseTest);
    store.toggleGlucoseTestModal();
};

async function confirmDelete() {
    // You can call your delete logic here, e.g.:
    try {
        await store.deleteGlucoseTest(glucoseTestToDelete.value.id)
        showDeleteModal.value = false;
        store.fetchGlucoseTests()
    } catch (error) {
        console.log(error);
        showDeleteModal.value = false;
    }
}
</script>