<template>
  <div class="container">
    <h2>Lista de Clientes</h2>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">Nome</th>
          <th class="text-center">Email</th>
          <th class="text-center">Telefone</th>
          <th class="text-center">Sexo</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes" :key="cliente.id">
          <td class="text-center">{{ cliente.nome }}</td>
          <td class="text-center">{{ cliente.email }}</td>
          <td class="text-center">{{ cliente.telefone  }}</td>
          <td class="text-center">{{ cliente.sexo  }}</td>
          <td class="text-center">
            <button @click="editarCliente(cliente.id)" class="btn btn-primary">Editar</button>
            <button @click="excluirCliente(cliente.id)" class="btn btn-danger">Excluir</button>
            <button @click="exibirDetalhes(cliente)" class="btn btn-secondary">Detalhes</button>
          </td>
        </tr>
      </tbody>
    </table>

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
              <form @submit.prevent="atualizarCliente">
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
    axios.put(`/api/clientes/${this.clienteEditado.id}`, this.clienteEditado)
      .then(_response => {
        this.fecharEdicaoModal();
      })
      .catch(error => {
        console.error(error);
      });
    },

    excluirCliente(clienteId) {
      if (confirm('Tem certeza de que deseja excluir este cliente?')) {
        axios.delete('/api/clientes/' + clienteId)
          .then(response => {
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
