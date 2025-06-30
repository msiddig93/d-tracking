<template>
    <Head title="Medications" />

    <AuthenticatedLayout>
        <template #header>
            Medications
        </template>

        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="flex w-12 items-center justify-center bg-blue-500">
                <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            </div>
    
            <div class="mx-0 px-4 py-2 w-full">
                <div class="mx-3 w-full flex items-center justify-between">
                    <span class="font-semibold text-blue-500">
                        <span class="hidden lg:inline-block">Medications List</span> 
                    </span>
                    <button 
                        class="flex items-center gap-2 rounded-full bg-blue-600 text-white px-4 py-2 font-semibold shadow hover:bg-blue-700 transition" 
                        @click="addNewMedication">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add <span>Medication</span>
                    </button>
                </div>
            </div>
        </div>
        <SkeletonTable :loading="loading" :columns="4" :rows="5">            
            <MedicationTable />
        </SkeletonTable>

        <!-- Add Medication Modal -->
        <Modal :show="showAddMedicationModal" maxWidth="sm" @close="store.toggleMedicationModal">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Medication</h2>
                <form @submit.prevent="sendMedication">
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input v-model="currentMedication.name" type="text" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        <div v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</div>
                    </div>
                    <!-- Patient -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                        <select v-model="currentMedication.patient_id" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option v-for="p in patientsList" :key="p.id" :value="p.id">{{ p.name }}</option>
                        </select>
                        <div v-if="errors.patient_id" class="text-red-500 text-xs mt-1">{{ errors.patient_id }}</div>
                    </div>
                    <!-- Reminder Time -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reminder Time</label>
                        <input v-model="currentMedication.reminder_time" type="time" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        <div v-if="errors.reminder_time" class="text-red-500 text-xs mt-1">{{ errors.reminder_time }}</div>
                    </div>
                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea v-model="currentMedication.notes" rows="2" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                        <div v-if="errors.notes" class="text-red-500 text-xs mt-1">{{ errors.notes }}</div>
                    </div>
                    <!-- Is Active Switch -->
                    <div class="mb-6 flex items-center gap-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
                        <button type="button" @click="currentMedication.is_active = !currentMedication.is_active" :class="currentMedication.is_active ? 'bg-green-500' : 'bg-gray-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition">
                            <span :class="currentMedication.is_active ? 'translate-x-6 bg-white' : 'translate-x-1 bg-white'" class="inline-block h-4 w-4 transform rounded-full transition" />
                        </button>
                    </div>
                    <!-- Footer Buttons -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="submit" class="flex items-center gap-2 rounded-full bg-blue-600 text-white px-4 py-2 font-semibold shadow hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0m8 0a4 4 0 01-8 0m8 0V5a4 4 0 00-8 0v2m8 0v2a4 4 0 01-8 0V7" />
                            </svg>
                            Send Data
                        </button>
                        <button type="button" @click="store.toggleMedicationModal" class="flex items-center gap-2 rounded-full bg-gray-200 text-gray-700 px-4 py-2 font-semibold shadow hover:bg-gray-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SkeletonTable from '@/Components/SkeletonTable.vue';
import { usePatientsStore } from '@/stores/patients';
import { useMedicationsStore } from '@/stores/medications';
import { storeToRefs } from 'pinia';
import MedicationTable from './partials/MedicationTable.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const patientStore = usePatientsStore();
patientStore.fetchPatientsList();
const { patientsList } = storeToRefs(patientStore);
const store = useMedicationsStore();
store.fetchMedications();
const {loading, currentMedication, showAddMedicationModal} = storeToRefs(store)

const showAddModal = ref(false);
const errors = ref({});
const sending = ref(false);

async function sendMedication() {
    try {
        errors.value = {}
        await store.createMedication();
        store.fetchMedications();
        store.toggleMedicationModal();
    } catch (error) {
        store.toggleMedicationModal();
        if(error.responses && error.responses.status === 422) {
            errors.value = error.responses.data.errors;
        } 
    }
}

function addNewMedication() {
    store.setCurrentMedication({
        name: '',
        patient_id: null,
        reminder_time: '',
        notes: '',
        is_active: true,
    });
    errors.value = {};
    store.toggleMedicationModal();
}
</script>
