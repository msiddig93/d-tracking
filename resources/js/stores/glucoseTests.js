import { defineStore } from 'pinia';
import GlucoseTestApiService from '../ApiServices/GlucoseTestApiService';

export const useGlucoseTestsStore = defineStore('glucoseTests', {
  state: () => ({
    glucoseTests: {},
    currentGlucoseTest: {},
    loading: false,
    error: null,
    showAddGlucoseTestModal: false,
  }),
  actions: {
    async fetchGlucoseTests(page = 1) {
        try {
            this.loading = true;
            this.glucoseTests = await GlucoseTestApiService.getAll(page);
            this.loading = false;
        } catch (error) {
            this.loading = false;
            throw error;
        }
    },
    setCurrentGlucoseTest(glucoseTest) {
      this.currentGlucoseTest = glucoseTest;
    },
    async createGlucoseTest(glucoseTest) {
      try {
        await GlucoseTestApiService.create(this.currentGlucoseTest)
      } catch (error) {
        throw error
      }
    },
    setGlucoseTests(glucoseTests) {
      this.glucoseTests = glucoseTests;
    },
    clearGlucoseTests() {
      this.glucoseTests = [];
    },
    toggleGlucoseTestModal() {
      this.showAddGlucoseTestModal = !this.showAddGlucoseTestModal;
    }
  },
});
