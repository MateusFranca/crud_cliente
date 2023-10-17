<template>
  <div class="container mt-5">
    <h2>Listar Vendas</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Cliente</th>
          <th scope="col">Data</th>
          <th scope="col">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="venda in vendas" :key="venda.id">
          <th scope="row">{{ venda.id }}</th>
          <td>{{ venda.cliente.nome }}</td>
          <td>{{ venda.data_da_venda }}</td>
          <td>{{ venda.valor_da_venda }}</td>
        </tr>
      </tbody>
    </table>

    <h2>Adicionar Venda</h2>
    <form @submit.prevent="adicionarVenda">
      <div class="form-group">
        <label for="cliente_id">ID do Cliente</label>
        <input type="text" class="form-control" id="cliente_id" placeholder="ID do Cliente">
      </div>
      <div class="form-group">
        <label for="data_da_venda">Data da Venda</label>
        <input type="date" class="form-control" id="data_da_venda" placeholder="Data da Venda">
      </div>
      <div class="form-group">
        <label for="valor_da_venda">Valor da Venda</label>
        <input type="number" class="form-control" id="valor_da_venda" placeholder="Valor da Venda">
      </div>
      <button type="submit" class="btn btn-primary">Adicionar Venda</button>
    </form>
  </div>
</template>

<script>

</script>