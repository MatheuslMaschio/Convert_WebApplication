<template>
    <nav class="navbar navbar-expand-lg navbar-dark" style ="background-color: #283141 ;">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://convertcompany.com.br/">
                <img src="../images/favicon.svg" width="100" height="24">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link to="/portal" class="nav-link">Atividades</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/portal/usuarios" class="nav-link">Usuarios</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/portal/tipos" class="nav-link">Tipos</router-link>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastro
                        </a>
                        <ul class="dropdown-menu" >
                            <li><router-link to="/portal/cadastrar_atividade" class="dropdown-item">Atividade</router-link></li>
                            <li><router-link to="/portal/cadastrar_tp_at" class="dropdown-item" >Tipo Atividade</router-link></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div>
                <button type="button" class="at-button " at-bg="reverse-primary" @click="alertLogout()">Logout</button>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navbar',
    data() {
        return {
            
        };
    },

    created(){

    },
    methods: {
        logout(){
            const token = localStorage.getItem("token");
            if (token) { //se token for nulo
                localStorage.removeItem("token");
                this.$router.push({ name: "login" });  //redireciona para a página de login
            }
        },

        alertLogout(){
            this.$swal.fire({
                title: 'Logout',
                text: "Você tem certeza que deseja deslogar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, fazer Logout!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const token = localStorage.getItem("token");
                    if (token) { //se token for nulo
                        localStorage.removeItem("token");
                        this.$router.push({ name: "login" });  //redireciona para a página de login
                    }
                    this.$swal.fire(
                        'Logout!',
                        'Usuário deslogado com Sucesso!',
                        'success'
                    )
                }             
            })
        },
    

    }
}
</script>

<style>
.navbar img {
    width: 180px;
    height: auto;
}

</style>