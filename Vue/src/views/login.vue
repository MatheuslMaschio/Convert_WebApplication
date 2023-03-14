<template>
    

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card-login text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <div>
                                    <img class="img-responsive" src="../images/favicon.svg">
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <a>Email</a>
                                    <input type="email"  v-model="email" class="form-control form-control-lg" />
                                    
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <a>Senha</a>
                                    <input type="password" v-model="senha" class="form-control form-control-lg" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" @click="loginUsuario">Login</button>
                            </div>

                            <div>
                                <p class="mb-0">Ainda não tem conta ? <a href="cadastrar_usuario.vue" class="text-blue-50 fw-bold "> <router-link to="/cadastrar_usuario">Cadastre agora mesmo </router-link> </a>
                                </p>
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
    name: 'login',
    data() {
        return {
            email: "",
            senha: "",
        };

    },

    methods: {
        loginUsuario(){
            const webApiUrl = "http://localhost/projetos/PHP/api/users/login.php"
            const self = this
            const options = {
                method: 'POST',
                url: webApiUrl,
                headers: {
                    "Access-Control-Allow-Origin" : "*",
                },
                data: {
                    email: this.email,
                    senha: this.senha,
                }
            };
            // --> AXIOS <--
            axios.request(options)
            .then(function (response){
                console.log(response);
                
                if(response.data.status == 200){ // se o status for 200 
                    self.alertSucess();
                    localStorage.setItem('token', response.data.token); // salva o token no localstorage
                    setTimeout(() => self.$router.push({name: 'inicio'}), 1500);
                }
                else{
                    self.alertError();
                    self.$router.push({ name: "login" }); //Mantém para a página de login
                }
            })
            .catch(function (error) {
                console.error(error.msg);
            });
        },

        alertSucess(){
            this.$swal.fire({
                icon: 'success',
                title: 'Usuário Logado com Sucesso',
                showConfirmButton: false,
                timer: 1500,
                background: '#fff url(/images/trees.png)',
            })
        },
        alertError(){
            this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email ou Senha errados!',
            })
        },
    },
}
</script>

<style>
img {
    width: 300px;
    height: auto;
}

.card-login {
    background-color: #283141;

}

</style> 

