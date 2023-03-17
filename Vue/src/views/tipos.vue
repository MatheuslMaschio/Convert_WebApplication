<template>
    <div class="container container-lg">
        <div class="row mt-3">
            <div class="col col-lg-6">
                <br>
                <h4 class="text-dark">Tabela Dos Tipos de Atividade</h4>
            </div>
        </div>

        <!--tabela -->
        <br>
        <table class="at-table" at-bg="dark">
            <thead at-bg="light-blue">
                <tr class="align-baseline bg-info text-light text-center">
                    <th scope="col">#</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Excluir</th>
                    <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center" v-for="(dados, index) in posts.data" :key="index"> <!-- Passando para a tabela os valores da API-->
                    <td>{{ dados.id }}</td>
                    <td>{{ dados.descricao }}</td>
                    <td> <button class=" at-button" at-bg="reverse-danger"  @click="deleteTipo(dados.id)"> Excluir</button></td>
                    <td> <button type="button" class="at-button" at-bg="reverse-primary" data-bs-toggle="modal" data-bs-target="#modalTipo" @click="preparaEdit(dados.id)">Editar</button></td>
                </tr>
            </tbody>
        </table>
        </div>

        <!--Modal-->
        <div class="modal fade" id="modalTipo" tabindex="-1" aria-labelledby="modalTipoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalTipoLabel">Tipos de Atividade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div>
                        <div class="at-field">
                            <input type="text" v-model="descricao" class="form-control">
                            <label><i class="bx bx-text"></i>Descricao</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="at-button" at-bg="danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="at-button" at-bg="primary" data-bs-dismiss="modal" @click="atualizarUsuario()">Alterar</button>
                </div>
            </div>
        </div>
    </div>



</template>

<script>
export default {
    name: "tipos",
    
    data(){
        return {
            posts: [],
            descricao: "",
            id: null,
        }
    },

    created(){
        this.verificatoken();
    },

    methods: {
        verificatoken(){
            const token = localStorage.getItem("token");
            if(token) {
                const partesDoToken = token.split("."); //dividino o token em partes 
                
                const getPayload = partesDoToken[1]; //pegando o payload aonde está a data de expiração
                
                const payload = JSON.parse(window.atob(getPayload)); //decodificando o payload
            
                const dataExpiracao = payload.exp * 1000; //transformando em milisegundos

                let horaAtual = Date.now(); //pegando a hora atual

                horaAtual = horaAtual - 3 * 60 * 60 * 1000; //arrumando a hora atual por causa do fuso
                

                if(dataExpiracao < horaAtual) { //se a data de expiração for menor que a hora atual
                    this.$router.push({ name: "login" });  //redireciona para a página de login
                }
                else {
                    this.criarTabela();  
                }
            }else{//se ñ existir token 
                this.$router.push({ name: "login" });  //redireciona para a página de login
            }

        },

        consultarApi() {
            //definimos algumas variaveis para ficar mais facil
            const webApiUrl = "http://localhost/projetos/PHP/api/tipo_atividade/read.php"; 
            const self = this;
            //--> AXIOS <-- 
            axios({
                method: "get", //Passamos o metodo pode ser get, post, put
                url: webApiUrl, //url
                headers: {
                "Access-Control-Allow-Origin" : "*" 
                },
            }).then((response) => (self.posts = response.data)); //pedimos para quando terminar de executar passar a resposta do data para o array posts criado no data 
        },

        criarTabela(){
            this.consultarApi();
        },

        deleteTipo(id){
            this.$swal.fire({ //itens do sweet alert
                title: 'Você tem certeza?',
                text: "Você não podera reverter depois disso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar Tipo de atividade!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.isConfirmed) {
                    const self = this;    
                    const options = {
                        method: 'DELETE',
                        url: 'http://localhost/projetos/PHP/api/tipo_atividade/delete.php',
                        headers: {
                        "Access-Control-Allow-Origin" : "*" 
                        },
                        data: {
                        id: id,
                        }
                    };
                    //--> AXIOS <-- 
                    axios.request(options).then(function (response){
                        self.criarTabela();
                        console.log(response.data);
                    }).catch(function (error){
                        console.log(error);
                    });
                    this.$swal.fire(
                        'Excluído!',
                        'O tipo de atividade foi excluída com sucesso!',
                        'success'
                    )
                }
            })
        },

        preparaEdit(id){
            const self = this; //definindo self = this para usar dentro do axios
            const options = {
                method: 'GET', //definindo o metodo get
                url: "http://localhost/projetos/PHP/api/tipo_atividade/read_single.php", //link da api
                params:{id:id}, //passando o id
                headers: {
                "Access-Control-Allow-Origin" : "*" //headers de acesso
                },
                data: {}
            };
            axios.request(options).then((response) => {
                //passando o v-model dos inputs , para quando vir a query os valores irem direto para os inputs
                self.id = response.data.id;
                self.descricao = response.data.descricao;
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);  
            })
        },

        atualizarUsuario(){
            const self = this; //definindo self = this para usar dentro do axios
            const options = {
                method: 'PUT', //definindo o metodo put
                url: "http://localhost//projetos/PHP/api/tipo_atividade/update.php", //link da api
                headers: {
                    "Access-Control-Allow-Origin" : "*" //headers de acesso
                },
                data: { //passando para o data o valor dos v-model dos inputs
                    id: this.id,
                    descricao: this.descricao,
                }
            };

            axios.request(options)
            .then(function (response){
                console.log(response.data);
                self.alertSucess();
                self.criarTabela(); //gerando a tabela novamente
                self.limpaInput(); //limpa os inputs
            }).catch(function (error) {
                console.log(error);  
            })
        },



        limpaInput(){
            this.descricao = "";    
        },

        alertSucess(){
            this.$swal.fire({
                icon: 'success',
                title: 'Tipo de Atividade Atualizada com Sucesso!',
                showConfirmButton: false,
                timer: 1500,
                background: '#fff url(/images/trees.png)',
            })
        },

        alertError(){
            this.$swal.fire({
                icon: 'error',
                title: 'Erro ao Editar!',
                text: 'Algum campo não foi preenchido corretamente!',
            })
        }

    }
}
</script>
