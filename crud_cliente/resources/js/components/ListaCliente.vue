<template>
  <div class="container mt-5">
    <h2 class="mb-4">Lista de Clientes</h2>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="text-center">Nome</th>
            <th class="text-center">Email</th>
            <th class="text-center">Telefone</th>
            <th class="text-center">Sexo</th>
            <th class="text-center">Foto</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cliente in clientes" :key="cliente.id" class="hover-row">
            <td class="text-center">{{ cliente.nome }}</td>
            <td class="text-center">{{ cliente.email }}</td>
            <td class="text-center">{{ cliente.telefone  }}</td>
            <td class="text-center">{{ cliente.sexo  }}</td>
            <td class="text-center">
              <img v-if="cliente.foto" :src="cliente.foto" alt="Foto do Cliente" width="50" height="50">
            </td>
            <td class="text-center">
              <button @click="editarCliente(cliente.id)" class="btn btn-primary">Editar</button>
              <button @click="excluirCliente(cliente.id)" class="btn btn-danger">Excluir</button>
              <button @click="exibirDetalhes(cliente)" class="btn btn-secondary">Detalhes</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal de Detalhes do Cliente -->
    <div class="modal" id="detalhesModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalhes do Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" @click="fecharDetalhesModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Nome:</strong> {{ clienteEditado.nome }}</p>
            <p><strong>Email:</strong> {{ clienteEditado.email }}</p>
            <p><strong>Telefone:</strong> {{ clienteEditado.telefone  }}</p>
            <p><strong>Sexo:</strong> {{ clienteEditado.sexo }}</p>
            <p><strong>Foto:</strong></p>
            <img :src="clienteEditado.foto" alt="Foto do Cliente" width="100" height="100">
          </div>
        </div>
      </div>
    </div>

      <!-- Modal de Edição do Cliente -->
      <div class="modal" id="edicaoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Editar Cliente</h5>
              <button type="button" class="close" data-dismiss="modal" @click="fecharEdicaoModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="atualizarCliente" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="nome">Nome:</label>
                  <input type="text" class="form-control" id="nome" v-model="clienteEditado.nome">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" class="form-control" id="email" v-model="clienteEditado.email">
                </div>
                <div class="form-group">
                  <label for="telefone">Telefone:</label>
                  <input type="text" class="form-control" id="telefone" v-model="clienteEditado.telefone">
                </div>
                <div class="form-group">
                  <label for="sexo">Sexo:</label>
                  <input type="text" class="form-control" id="sexo" v-model="clienteEditado.sexo">
              </div>
              <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" class="form-control" id="foto" v-on:change="carregarFoto">
              </div>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      clientes: [],
      detalhesCliente: {},
      clienteEditado: {
        nome: "",
        email: "",
        telefone: "",
        sexo: "",
        foto: "",
      },
    };
  },
  methods: {
    exibirDetalhes(cliente) {
    this.clienteEditado = { ...cliente };
    this.abrirDetalhesModal();
    },
    editarCliente(clienteId) {
    axios.get(`/api/clientes/${clienteId}`)
      .then(response => {
        this.clienteEditado = response.data;
        this.abrirEdicaoModal();
      })
      .catch(error => {
        console.error(error);
      });
    },
    atualizarCliente() {
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('nome', this.clienteEditado.nome);
      formData.append('email', this.clienteEditado.email);
      formData.append('telefone', this.clienteEditado.telefone);
      formData.append('sexo', this.clienteEditado.sexo);

      if (this.clienteEditado.foto instanceof File) {
        formData.append('foto', this.clienteEditado.foto);
      }

      axios.post(`/api/clientes/${this.clienteEditado.id}`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(_response => {
        this.fecharEdicaoModal();
        window.alert('Alterações salvas com sucesso!');
      })
      .catch(error => {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          console.error(error);
        }
      });
  },

    carregarFoto(event) {
      this.clienteEditado.foto = event.target.files[0];
    },

    excluirCliente(clienteId) {
      if (confirm('Tem certeza de que deseja excluir este cliente?')) {
        axios.delete('/api/clientes/' + clienteId)
          .then(_response => {
            this.clientes = this.clientes.filter(cliente => cliente.id !== clienteId);
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    abrirDetalhesModal() {
      $('#detalhesModal').modal('show');
    },
    fecharDetalhesModal() {
      $('#detalhesModal').modal('hide');
    },
      abrirEdicaoModal() {
      $('#edicaoModal').modal('show');
      },
    fecharEdicaoModal() {
      $('#edicaoModal').modal('hide');
      },
    },
    mounted() {
    axios.get('/api/clientes')
    .then(response => {
      this.clientes = response.data;
    })
    .catch(error => {
      console.error(error);
      });
    },
};
</script>

<style scoped>
  .hover-row:hover {
    background-color: #cfcfcf;
  }
</style>