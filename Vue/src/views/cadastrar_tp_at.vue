<template>
    <br /><br /><br /><br />
    <div class="container">
        <div class="row">
            <div class="card" >
                <div class="card-body">
                    <h1>Cadastrar Tipo de Atividade</h1>
                    <div >
                        <div class="mb-3">
                            <label>Descricao</label>
                            <input type="text" v-model="descricao" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" @click="cadastrar_tipo_at" >Cadastrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>          
</template>

<script>
export default {
    name: "cadastrar_tp_at",
    
    data(){
        return {
            posts: [],
            descricao: "",
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
                    
                }
            }else{//se ñ existir token 
                this.$router.push({ name: "login" });  //redireciona para a página de login
            }

        },

        cadastrar_tipo_at(){
            const webApiUrl = "http://localhost/projetos/PHP/api/tipo_atividade/create.php" //link da api
            const self = this; //definindo self = this para usar dentro do axios
            const token = localStorage.getItem("token");

            const options = { 
                method: 'POST', // definição do método
                url: webApiUrl, //link da api
                headers: {
                    Authorization : "Bearer " + token
                },
                data: {
                    descricao: this.descricao //passando para o data o valor do input 
                }
            };

            // --> AXIOS <--
            axios.request(options)
            .then(function (response){
                console.log(response);
                if(response.data.Status == 200){
                    self.limpaInput();
                    self.alertSucess(); 
                }
                else{
                    self.alertError();
                }
            })
            .catch(function (error) {
                console.error(error.msg);
            });
        },

        limpaInput(){
            this.descricao = "";    
        },

        alertSucess(){
            this.$swal.fire({
            icon: 'success',
            title: 'Tipo de Atividade Cadastrada com Sucesso!',
            showConfirmButton: false,
            timer: 1500,
            background: '#fff url(/images/trees.png)',
            })
        },

        alertError(){
            this.$swal.fire({
                icon: 'error',
                title: 'Erro ao Cadastrar!',
                text: 'Algum campo não foi preenchido corretamente!',
            })
        }
    }
}
</script>

<style>

</style>