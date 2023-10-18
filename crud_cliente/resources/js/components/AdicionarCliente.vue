<template>
  <div class="container">
    <h2>Adicionar Novo Cliente</h2>
      <form @submit.prevent="adicionarCliente" class="mt-4">
        <div class="form-group">
          <input v-model="novoCliente.nome" class="form-control" placeholder="Nome" required>
        </div>
        <div class="form-group">
          <input v-model="novoCliente.email" class="form-control" type="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input v-model="novoCliente.telefone" class="form-control" placeholder="Telefone" required>
        </div>
        <div class="form-group">
          <input type="file" accept="image/*" @change="handleFileChange" class="form-control-file">
        </div>
        <div class="form-group">
          <input v-model="novoCliente.sexo" class="form-control" placeholder="Sexo" required>
        </div>
              <button type="submit" class="btn btn-primary">Adicionar</button>
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
      .then(_response => {
        this.novoCliente = {
          nome: '',
          email: '',
          telefone: '',
          foto: null,
          sexo: '',
        };
        window.alert('Cliente salvo com sucesso!');
      })
      .catch(error => {
        console.error(error);
        window.alert('Erro ao salvar o cliente. Verifique os campos e tente novamente.');
      });
    },
    handleFileChange(event) {
      this.novoCliente.foto = event.target.files[0];
    },
  },
};
</script>