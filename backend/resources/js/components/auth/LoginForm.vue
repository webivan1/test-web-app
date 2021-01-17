<template>
  <CardBody>
    <LoginHeading>
      Sign in
    </LoginHeading>

    <form @submit.prevent="handleSubmit" novalidate>
      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <!-- @todo create UI Input component or install vue bootstrap -->
      <div class="form-group">
        <label>Email <span class="text-muted">(admin@admin.com)</span></label>
        <input
          name="email"
          class="form-control"
          :class="{ 'is-invalid': $v.form.email.$error }"
          v-model.trim="$v.form.email.$model"
        />
        <div v-if="$v.form.email.$error" class="invalid-feedback">
          Your email is not correct
        </div>
      </div>

      <div class="form-group">
        <label>Password <span class="text-muted">(password)</span></label>
        <input
          type="password"
          name="password"
          class="form-control"
          :class="{ 'is-invalid': $v.form.password.$error }"
          v-model.trim="$v.form.password.$model"
        />
        <div v-if="$v.form.password.$error" class="invalid-feedback">
          Password is required
        </div>
      </div>

      <div class="text-center d-flex justify-content-center align-content-center">
        <button :disabled="loader" type="submit" class="mx-2 btn btn-primary">
          Sign in
        </button>

        <Loader v-if="loader" />
      </div>
    </form>
  </CardBody>
</template>

<script>
  import { required, minLength, maxLength, email } from 'vuelidate/lib/validators'
  import CardBody from '../ui/CardBody'
  import LoginHeading from './LoginHeading'
  import Loader from '../ui/Loader'

  export default {
    name: 'login-form',
    components: {
      Loader,
      LoginHeading,
      CardBody
    },
    props: {
      submitUrl: {
        type: String,
        required: true
      },
      dashboardUrl: {
        type: String,
        required: true
      }
    },
    data: () => ({
      loader: false,
      success: null,
      error: null,
      form: {
        email: '',
        password: ''
      }
    }),
    validations: {
      form: {
        email: {
          required,
          email,
          maxLength: maxLength(255)
        },
        password: {
          required,
          minLength: minLength(6)
        }
      }
    },
    methods: {
      async handleSubmit() {
        this.$v.$touch();

        if (!this.$v.$invalid) {
          try {
            this.loader = true;
            await axios.post(this.submitUrl, this.form);
            window.location.href = this.dashboardUrl;
          } catch (e) {
            // @todo to make a correct errors message
            this.error = e.message;
            this.loader = false;
          }
        }
      }
    }
  }
</script>
