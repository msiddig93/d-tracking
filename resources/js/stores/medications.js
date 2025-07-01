import { defineStore } from 'pinia';
import MedicationApiService from '../ApiServices/MedicationApiService';

export const useMedicationsStore = defineStore('medications', {
  state: () => ({
    medications: {},
    currentMedication: {},
    loading: false,
    error: null,
    showAddMedicationModal: false,
  }),
  actions: {
    async fetchMedications(page = 1) {
        try {
            this.loading = true;
            this.medications = await MedicationApiService.getAll(page);
            this.loading = false;
        } catch (error) {
            this.loading = false;
            throw error;
        }
    },
    setCurrentMedication(medication) {
      this.currentMedication = medication;
    },
    async createMedication(medication) {
      try {
        await MedicationApiService.create(this.currentMedication)
      } catch (error) {
        throw error
      }
    },
    setMedications(medications) {
      this.medications = medications;
    },
    clearMedications() {
      this.medications = [];
    },
    toggleMedicationModal() {
      this.showAddMedicationModal = !this.showAddMedicationModal;
    },
    async delete(id){
      try {
        await MedicationApiService.delete(id);
      } catch (error) {
        throw error
      }
    }
  },
});
