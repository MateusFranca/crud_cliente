<template>
  <div class="container">
    <h2>Lista de Clientes</h2>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">Nome</th>
          <th class="text-center">Email</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientes" :key="cliente.id">
          <td class="text-center">{{ cliente.nome }}</td>
          <td class="text-center">{{ cliente.email }}</td>
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
            <p><strong>Nome:</strong> {{ detalhesCliente.nome }}</p>
            <p><strong>Email:</strong> {{ detalhesCliente.email }}</p>
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
    };
  },
  methods: {
    exibirDetalhes(cliente) {
      this.detalhesCliente = cliente;
      this.abrirDetalhesModal();
    },
    editarCliente(clienteId) {
      // Redirecionar para a página de edição do cliente
      this.$router.push({ name: 'editar-cliente', params: { id: clienteId } });
    },
    excluirCliente(clienteId) {
      if (confirm('Tem certeza de que deseja excluir este cliente?')) {
        // Enviar uma solicitação para excluir o cliente
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
