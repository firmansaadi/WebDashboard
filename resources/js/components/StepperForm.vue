<!-- src/components/StepperForm.vue -->
<template>
  <div class="row">
    <div class="col-xxl-8 col-12">
      <div id="stepperForm" class="bs-stepper">
        <div class="bs-stepper-header p-0 bg-transparent mb-4" role="tablist">
          <div class="step" data-target="#test-l-1">
            <button type="button" class="step-trigger" role="tab" id="stepperFormtrigger1" aria-controls="test-l-1">
              <span class="bs-stepper-circle me-2">
                <i data-feather="users" class="icon-xs"></i>
              </span>
              <span class="bs-stepper-label">Billing Info</span>
            </button>
          </div>
          <div class="bs-stepper-line"></div>
          <div class="step" data-target="#test-l-2">
            <button type="button" class="step-trigger" role="tab" id="stepperFormtrigger2" aria-controls="test-l-2">
              <span class="bs-stepper-circle me-2">
                <i data-feather="shopping-bag" class="icon-xs"></i>
              </span>
              <span class="bs-stepper-label">Shipping Details</span>
            </button>
          </div>
          <div class="bs-stepper-line"></div>
          <div class="step" data-target="#test-l-3">
            <button type="button" class="step-trigger" role="tab" id="stepperFormtrigger3" aria-controls="test-l-3">
              <span class="bs-stepper-circle me-2">
                <i data-feather="credit-card" class="icon-xs"></i>
              </span>
              <span class="bs-stepper-label">Payment Info</span>
            </button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="bs-stepper-content">
              <form @submit.prevent="completeOrder">
                <div id="test-l-1" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormtrigger1">
                  <div class="mb-5">
                    <h3 class="mb-1">Billing Information</h3>
                    <p class="mb-0">Please fill all information below </p>
                  </div>
                  <div class="row">
                    <!-- form inputs here, use v-model for data binding -->
                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="firstName">First Name</label>
                      <input type="text" class="form-control" placeholder="Enter first name" id="firstName" v-model="billingInfo.firstName">
                    </div>
                    <!-- other input fields... -->
                  </div>
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" @click="goToStep(2)"> Proceed to Shipping <i class="fe fe-shopping-bag ms-1"></i></button>
                  </div>
                </div>
                <div id="test-l-2" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormtrigger2">
                  <div class="mb-5">
                    <h3 class="mb-1">Shipping Information</h3>
                    <p class="mb-0">Fill the form below in order to send you the orders invoice. </p>
                  </div>
                  <!-- shipping form inputs here -->
                  <div class="d-md-flex justify-content-between mt-4">
                    <button class="btn btn-outline-primary mb-2 mb-md-0" @click="goToStep(1)"> Back to Info </button>
                    <button class="btn btn-primary" @click="goToStep(3)"> Continue to Payment <i class="fe fe-credit-card ms-2"></i></button>
                  </div>
                </div>
                <div id="test-l-3" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormtrigger3">
                  <div class="mb-5">
                    <h3 class="mb-1">Payment selection</h3>
                    <p class="mb-0">Please select and enter your billing information. </p>
                  </div>
                  <!-- payment form inputs here -->
                  <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-primary mt-3" @click="goToStep(2)"> Back to shipping </button>
                    <button type="submit" class="btn btn-primary mt-3"> Complete Order </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Stepper from 'bs-stepper';
import feather from 'feather-icons';

export default {
  data() {
    return {
      stepper: null,
      billingInfo: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        address: '',
        town: '',
        state: '',
        zip: '',
        country: '',
        shipAddress: false
      },
      // Define shipping and payment info similarly
    };
  },
  mounted() {
    feather.replace();

    this.stepper = new Stepper(document.querySelector('#stepperForm'), {
      linear: false,
      animation: true
    });
  },
  methods: {
    goToStep(step) {
      this.stepper.to(step);
    },
    completeOrder() {
      // Handle order completion logic
      console.log('Order completed with data:', this.billingInfo);
    }
  }
};
</script>

<style scoped>
.step-trigger {
  cursor: pointer;
}
</style>
