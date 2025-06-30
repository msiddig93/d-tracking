<template>
    <div class="w-full overflow-x-auto inline-block min-w-full rounded-lg shadow">
        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" maxWidth="sm" @close="showDeleteModal = false">
            <div class="p-6 text-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Delete Patient</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this patient? This action cannot be undone.</p>
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
                        id
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Name
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Email
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Phone
                    </th>
                    <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        -
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="patient in patients.data" :key="patient.id" class="text-gray-700">
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ patient.id }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ patient.name }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ patient.email }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ patient.phone }}</p>
                    </td>
                    <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                        <div class="flex justify-end gap-2">
                            <!-- View Button -->
                            <button
                                class="flex items-center gap-1 rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold hover:bg-blue-200 transition"
                                title="View"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View
                            </button>
                            <!-- Edit Button -->
                            <button
                                class="flex items-center hidden gap-1 rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-semibold hover:bg-yellow-200 transition"
                                title="Edit"
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
                                @click="openDeleteModal(patient)"
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
    <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between">
        <Pagination 
            :links="patients.meta.links"
            v-if="patients.meta && patients.meta.links.length"
            @pagination-change-page="store.fetchPatients"
        />
    </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import { usePatientsStore } from '@/stores/patients';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';

const store = usePatientsStore();
const { patients } = storeToRefs(store);

const showDeleteModal = ref(false);
const patientToDelete = ref(null);

function openDeleteModal(patient) {
    patientToDelete.value = patient;
    showDeleteModal.value = true;
}

function confirmDelete() {
    // You can call your delete logic here, e.g.:
    // store.deletePatient(patientToDelete.value.id)
    showDeleteModal.value = false;
}
</script>