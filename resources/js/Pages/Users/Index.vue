<template>
    <Head title="Doctors" />

    <AuthenticatedLayout>
        <template #header>
            Doctors
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
                        <span class="hidden lg:inline-block">Doctors List</span> 
                    </span>
                    <button 
                        class="flex items-center gap-2 rounded-full bg-blue-600 text-white px-4 py-2 font-semibold shadow hover:bg-blue-700 transition" 
                        @click="addNewDoctor">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add <span>Doctor</span>
                    </button>
                </div>
            </div>
        </div>
        <SkeletonTable :loading="loading" :columns="4" :rows="5">            
            <DoctorTable />
        </SkeletonTable>

        <!-- Add Doctor Modal -->
        <Modal :show="showAddDoctorModal" :closeable="!sending" maxWidth="sm" @close="store.toggleDoctorModal">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">
                    {{ currentDoctor.title }}    
                </h2>
                <form @submit.prevent="sendDoctor">
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input v-model="currentDoctor.name" type="text" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        <div v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</div>
                    </div>
                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input v-model="currentDoctor.email" type="email" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        <div v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</div>
                    </div>
                    <!-- Role Switch -->
                    <div class="mb-6 flex items-center gap-2">
                        <label v-if="currentDoctor.role == 'admin'" class="block text-sm font-medium text-gray-700 mb-1">Admin</label>
                        <label v-else class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                        <button type="button" @click="currentDoctor.role = currentDoctor.role == 'admin' ? 'doctor' : 'admin'" :class="currentDoctor.role != 'any' ? 'bg-green-500' : 'bg-gray-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition">
                            <span :class="currentDoctor.role == 'admin' ? 'translate-x-6 bg-white' : 'translate-x-1 bg-white'" class="inline-block h-4 w-4 transform rounded-full transition" />
                        </button>
                    </div>
                    <!-- note explain password login -->
                    <p class="text-xs text-gray-500 mb-4">
                        Note: If you want to login the password, is going to be <strong class="text-dark font-weight-bold">"password"</strong> by default, after login you can change it form your profile.
                    </p>
                    <!-- Footer Buttons -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button 
                            type="submit" 
                            :class="{'bg-blue-400 hover:bg-blue-400 cursor-not-allowed w-full justify-center': sending}"
                            class="flex items-center gap-2 rounded-full bg-blue-600 text-white px-4 py-2 font-semibold shadow hover:bg-blue-700 transition">
                            <span class="mx-4">Send Data</span>

                            <template v-if="!sending">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0m8 0a4 4 0 01-8 0m8 0V5a4 4 0 00-8 0v2m8 0v2a4 4 0 01-8 0V7" />
                                </svg>
                            </template>
                            <template v-else>
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </template>
                        </button>
                        <button 
                            :class="{'bg-gray-200 hover:bg-gray-200 cursor-not-allowed hidden': sending}" 
                            type="button" 
                            @click="store.toggleDoctorModal" class="flex items-center gap-2 rounded-full bg-gray-200 text-gray-700 px-4 py-2 font-semibold shadow hover:bg-gray-300 transition">
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
import { useDoctorsStore } from '@/stores/doctors';
import { storeToRefs } from 'pinia';
import DoctorTable from './partials/DoctorTable.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const patientStore = usePatientsStore();
patientStore.fetchPatientsList();
const { patientsList } = storeToRefs(patientStore);
const store = useDoctorsStore();
store.fetchDoctors();
const {loading, currentDoctor, showAddDoctorModal} = storeToRefs(store)

const showAddModal = ref(false);
const errors = ref({});
const sending = ref(false);

async function sendDoctor() {
    try {
        errors.value = {}
        sending.value = true
        await store.createDoctor();
        store.fetchDoctors();
        store.toggleDoctorModal();
        sending.value = false
    } catch (error) {
        sending.value = false
        console.log(error.response);
        
        if(error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            store.toggleDoctorModal();
        }
    }
}

function addNewDoctor() {
    store.setCurrentDoctor({
        id: 0,
        title: 'Add New Doctor',
        name: '',
        email: '',
        role: 'doctor',
    });
    errors.value = {};
    store.toggleDoctorModal();
}
</script>
