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
                    console.log("ok caiu aqui");
                    this.gerarRequest();
                }
            }
        },

        cadastrarAtividade(){
            const webApiUrl = "http://localhost/projetos/PHP/api/atividade/create.php"
            const self = this

            const options = {
                method: 'POST',
                url: webApiUrl,
                headers: {
                    "Access-Control-Allow-Origin" : "*",
                },
                data: {
                    descricao: this.descricao,
                    tipo: this.tipo,
                    status: this.status,
                }
            };
            // --> AXIOS <--
            axios.request(options)
            .then(function (response){
                console.log(response);
                self.limpaInput();
            

            })
            .catch(function (error) {
                console.error(error.msg);
            });
        },

        consultarApi() {
            const webApiUrl = "http://localhost/projetos/PHP/api/tipo_atividade/read.php"; 
            const self = this;

            axios({
                method: "get", 
                url: webApiUrl, 
                headers: {
                    "Access-Control-Allow-Origin" : "*" 
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
            
        }
    }
}
</script>

<style>

</style>