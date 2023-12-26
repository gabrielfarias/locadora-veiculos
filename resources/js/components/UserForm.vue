<template>
  <form @submit.prevent="submitForm">
    <div class="mb-3">
      <label for="name" class="form-label">Nome:</label>
      <input v-model="formData.name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input v-model="formData.email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Senha:</label>
      <input v-model="formData.password" type="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="cpf" class="form-label">CPF:</label>
      <input v-model="formData.cpf" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Criar Usuário</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        name: '',
        email: '',
        password: '',
        cpf: '',
      },
    };
  },
  methods: {
    submitForm() {
      this.$emit('form-submit', this.formData);
    },
  },
};
</script>
