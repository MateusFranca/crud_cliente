<template>
  <div>
    <h2>Lista de Clientes</h2>
    <ul>
      <li v-for="cliente in clientes" :key="cliente.id">
        {{ cliente.nome }} - {{ cliente.email }}
        <button @click="exibirDetalhes(cliente)">Detalhes</button>
        <button @click="editarCliente(cliente.id)">Editar</button>
        <button @click="excluirCliente(cliente.id)">Excluir</button>
      </li>
    </ul>

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
            <!-- Adicione mais detalhes conforme necessário -->
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
