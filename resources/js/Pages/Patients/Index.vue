<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SkeletonTable from '@/Components/SkeletonTable.vue';
import { usePatientsStore } from '@/stores/patients';
import { storeToRefs } from 'pinia';
import PatientTable from './partials/PatientTable.vue';

const store = usePatientsStore();
store.fetchPatients();
const { loading} = storeToRefs(store)

</script>

<template>
    <Head title="Patients" />

    <AuthenticatedLayout>
        <template #header>
            Patients
        </template>

        <div class="mb-4 inline-flex w-full overflow-x-auto rounded-lg bg-white shadow-md">
            <div class="flex w-12 items-center justify-center bg-blue-500">
                <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            </div>
    
            <div class="-mx-3 px-4 py-2">
                <div class="mx-3">
                    <span class="font-semibold text-blue-500">Patients List</span>
                    
                </div>
            </div>
        </div>
        <SkeletonTable :loading="loading" :columns="4" :rows="5">            
            <PatientTable />
        </SkeletonTable>

    </AuthenticatedLayout>
</template>
