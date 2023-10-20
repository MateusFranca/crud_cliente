<template>
    <div class="container mt-5">
        <h2 class="mb-4">Adicionar Venda</h2>
        <form @submit.prevent="adicionarVenda" class="mb-4">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input
                        v-model="novaVenda.valor"
                        class="form-control"
                        placeholder="Valor"
                        required
                    />
                </div>
                <div class="col-md-3 mb-3">
                    <input
                        v-model="novaVenda.nome"
                        class="form-control"
                        placeholder="Nome do produto"
                        required
                    />
                </div>
                <div class="col-md-3 mb-3">
                    <input
                        v-model="novaVenda.descrição"
                        class="form-control"
                        placeholder="Descrição"
                        required
                    />
                </div>
                <div class="col-md-3 mb-3">
                    <select
                        v-model="novaVenda.cliente_id"
                        class="form-control"
                        required
                    >
                        <option value="" disabled>Selecione um cliente</option>
                        <option
                            v-for="cliente in clientes"
                            :key="cliente.id"
                            :value="cliente.id"
                        >
                            {{ cliente.nome }}
                        </option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>

        <h2 class="mb-4">Lista de Vendas</h2>
        <div class="table-responsive">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Venda</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="venda in vendas"
                        :key="venda.id"
                        class="hover-row"
                    >
                        <td>{{ venda.valor }}</td>
                        <td>{{ venda.nome }}</td>
                        <td>{{ venda.descrição }}</td>
                        <td>
                            <button
                                @click="editarVenda(venda.id)"
                                class="btn btn-primary"
                            >
                                Editar
                            </button>
                            <button
                                @click="excluirVenda(venda.id)"
                                class="btn btn-danger"
                            >
                                Excluir
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal de Edição -->
        <div
            class="modal fade"
            id="editarModal"
            tabindex="-1"
            aria-labelledby="editarModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">
                            Editar Venda
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="salvarEdicao">
                            <div class="form-group">
                                <input
                                    v-model="novaVenda.valor"
                                    class="form-control"
                                    placeholder="Valor"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="novaVenda.nome"
                                    class="form-control"
                                    placeholder="Nome do produto"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="novaVenda.descrição"
                                    class="form-control"
                                    placeholder="Descrição"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <select
                                    v-model="novaVenda.cliente_id"
                                    class="form-control"
                                    required
                                >
                                    <option value="" disabled>
                                        Selecione um cliente
                                    </option>
                                    <option
                                        v-for="cliente in clientes"
                                        :key="cliente.id"
                                        :value="cliente.id"
                                    >
                                        {{ cliente.nome }}
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Salvar Alterações
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            novaVenda: {
                valor: "",
                nome: "",
                descrição: "",
                cliente_id: "",
            },
            vendas: [],
            clientes: [],
            vendaEmEdição: null,
            atualizacaoComSucesso: false,
        };
    },
    methods: {
        adicionarVenda() {
            axios
                .post("/api/vendas", this.novaVenda)
                .then((response) => {
                    this.vendas.push(response.data);
                    this.novaVenda = {};
                    alert("Venda adicionada com sucesso!");
                })
                .catch((error) => {
                    console.error(error);
                    alert(
                        "Erro ao adicionar a venda. Por favor, tente novamente."
                    );
                });
        },
        editarVenda(vendaId) {
            this.vendaEmEdição = vendaId;
            const vendaSelecionada = this.vendas.find(
                (venda) => venda.id === vendaId
            );
            this.novaVenda = { ...vendaSelecionada };
            $("#editarModal").modal("show");
        },
        salvarEdicao() {
            axios
                .put(`/api/vendas/${this.vendaEmEdição.id}`, this.novaVenda)
                .then((response) => {
                    const index = this.vendas.indexOf(this.vendaEmEdição);
                    this.vendas[index] = response.data;
                    this.novaVenda = {};
                    this.vendaEmEdição = null;

                    $("#editarModal").modal("hide");

                    alert("Venda editada com sucesso!");
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        excluirVenda(vendaId) {
            axios
                .delete(`/api/vendas/${vendaId}`)
                .then(() => {
                    this.vendas = this.vendas.filter(
                        (venda) => venda.id !== vendaId
                    );

                    alert("Venda excluída com sucesso!");
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    selecionarCliente(clienteId) {
        this.novaVenda.cliente_id = clienteId;
    },
    created() {
        axios
            .get("/api/clientes")
            .then((response) => {
                this.clientes = response.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    mounted() {
        axios
            .get("/api/vendas")
            .then((response) => {
                this.vendas = response.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    confirmarExclusao(vendaId) {
        const confirmar = window.confirm(
            "Tem certeza de que deseja excluir esta venda?"
        );
        if (confirmar) {
            this.excluirVenda(vendaId);
        }
    },
};
</script>
