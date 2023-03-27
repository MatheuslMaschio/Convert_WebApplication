<template>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <div>
                                    <img class="img-responsive" src="../images/favicon.svg">
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <a> Nome </a>
                                    <input type="text"  v-model="nome" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <a> Email </a>
                                    <input type="email"  v-model="email" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <a >Senha </a>
                                    <input type="password" v-model="senha" class="form-control form-control-lg" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" @click="cadastrarUsuario()">Cadastrar</button>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="button" @click="voltar()">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return {
            nome: "",
            email: "",
            senha: "",
        }
    },


    methods: {
        cadastrarUsuario(){
            const webApiUrl = "http://localhost/projetos/PHP/api/users/create_user.php"; //link da api
            const self = this  //definindo self = this para usar dentro do axios
            const token = localStorage.getItem("token");

            const options = {
                method: 'POST', //definindo método
                url: webApiUrl, //link da api
                headers: {
                    Authorization : "Bearer " + token
                },
                data: { //passando para o data os dados do formulario
                    nome : this.nome, 
                    email: this.email,
                    senha: this.senha,
                }
            };
            // --> AXIOS <--
            axios.request(options)
            .then(function (response){
                console.log(response); 
                if(response.data.Status == 200){
                    self.alertSucess();
                    setTimeout(() => self.$router.push({name: 'login'}), 1500);
                }
                else{
                    self.alertError();
                }

            })
            .catch(function (error) {
                console.error(error.msg);
            });
        },

        alertSucess(){
            this.$swal.fire({
            icon: 'success',
            title: 'Usuário Cadastrada com Sucesso!',
            showConfirmButton: false,
            timer: 1500,
            background: '#fff url(/images/trees.png)',
            })
        },

        alertError(){
            this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo deu errado!',
            })
        },

        voltar(){
            this.$router.push({name: 'login'});
        }
    } 
}

</script>

<style>
img {
    width: 300px;
    height: auto;
}

.card {
    background-color: #283141;

}
</style>