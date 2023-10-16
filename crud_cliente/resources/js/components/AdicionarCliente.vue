<template>
  <div>
    <h2>Adicionar Novo Cliente</h2>
    <form @submit.prevent="adicionarCliente">
      <input v-model="novoCliente.nome" placeholder="Nome" required>
      <input v-model="novoCliente.email" type="email" placeholder="Email" required>
      <input v-model="novoCliente.telefone" placeholder="Telefone" required>
      <input type="file" accept="image/*" @change="handleFileChange">
      <input v-model="novoCliente.sexo" placeholder="Sexo" required>
      <button type="submit">Adicionar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      novoCliente: {
        nome: '',
        email: '',
        telefone: '',
        foto: null,
        sexo: '',
      },
    };
  },
  methods: {
    adicionarCliente() {
      // Chamada para adicionar o novo cliente
      const formData = new FormData();
      formData.append('nome', this.novoCliente.nome);
      formData.append('email', this.novoCliente.email);
      formData.append('telefone', this.novoCliente.telefone);
      formData.append('foto', this.novoCliente.foto);
      formData.append('sexo', this.novoCliente.sexo);

      axios.post('/api/clientes', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      .then(response => {
        // Limpe os campos após a adição bem-sucedida
        this.novoCliente = {
          nome: '',
          email: '',
          telefone: '',
          foto: null,
          sexo: '',
        };
      })
      .catch(error => {
        console.error(error);
      });
    },
    handleFileChange(event) {
      this.novoCliente.foto = event.target.files[0];
    },
  },
};
</script>
