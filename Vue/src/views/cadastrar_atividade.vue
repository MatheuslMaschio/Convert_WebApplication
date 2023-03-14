<template>
    <br /><br /><br /><br />
    <div class="container">
        <div class="row">
            <div class = "card">
                <div class = "card-body">
                    <h1>Cadastrar Atividade</h1>

                    <div>
                        <div class="at-field">
                            <input type="text" v-model="descricao" class="form-control">
                            <label><i class="bx bx-text"></i>Descricao</label>
                        </div>
                        <div class="at-field">
                            <select class="form-select" v-model="tipo" >
                                <option selected v-for="(dados, index) in posts.data" :key="index">{{dados.id}} {{dados.descricao}}</option>
                            </select>
                            <label><i class="bx bx-menu"></i>Tipo de Atividade: </label>
                        </div>
                        <div class="at-field">
                            <select class="form-select"  v-model="status">
                                <option selected>Escolha...</option>
                                <option value="1">Ativa</option>
                                <option value="2">Concluída</option>
                            </select>
                            <label><i class="bx bx-menu"></i>Status: </label>
                        </div> 
                        <div class="mb-3">
                            <button type="submit" class="at-button" at-bg="primary" @click="cadastrarAtividade">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name: "cadastrar_atividade",
    data(){
        return {
            posts: [],
            descricao: "",
            tipo: "",
            status: ""
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
                    this.gerarRequest();
                }
            }
            else{//se ñ existir token 
                this.$router.push({ name: "login" });  //redireciona para a página de login
            }
        },

        cadastrarAtividade(){
            const webApiUrl = "http://localhost/projetos/PHP/api/atividade/create.php" //link da api
            const self = this //definindo self = this para usar dentro do axios

            const options = {
                method: 'POST', //definindo o método
                url: webApiUrl, //link da api
                headers: {
                    "Access-Control-Allow-Origin" : "*", //headers de acesso
                },
                data: {
                    descricao: this.descricao, //passando para o data os valores do formulario 
                    tipo: this.tipo,
                    status: this.status,
                }
            };
            // --> AXIOS <--
            axios.request(options) //enviando a request 
            .then(function (response){
                console.log(response);
                self.alertSucess()
                self.limpaInput(); //limpando os inputs
            

            })
            .catch(function (error) {
                console.error(error.msg);
            });
        },

        consultarApi() {
            const webApiUrl = "http://localhost/projetos/PHP/api/tipo_atividade/read.php";  //link da api
            const self = this; //definindo self = this para usar dentro do axios

            axios({
                method: "get", //definindo o método
                url: webApiUrl, //link da api
                headers: {
                    "Access-Control-Allow-Origin" : "*" // headers de acesso
                },
            }).then((response) => (self.posts = response.data)); 
        },

        gerarRequest(){
            this.consultarApi();
        },

        limpaInput(){
            this.descricao = "";
            this.tipo = "";
            this.status = "";
            
        },

        alertSucess(){
            this.$swal.fire({
            icon: 'success',
            title: 'Atividade Cadastrada com Sucesso!',
            showConfirmButton: false,
            timer: 1500,
            background: '#fff url(/images/trees.png)',
            })
        },
    }
}
</script>

<style>

</style>