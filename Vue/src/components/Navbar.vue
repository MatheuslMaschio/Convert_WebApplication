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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastro
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><router-link to="/portal/cadastrar_atividade" class="dropdown-item">Atividade</router-link></li>
                            <li><router-link to="/portal/cadastrar_tp_at" class="dropdown-item" >Tipo Atividade</router-link></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div>
                <button type="button" class="at-button " at-bg="primary">Logout</button>
            </div>
        </div>
    </nav>

</template>

<script>
export default {
    name: 'Navbar',
}
</script>

<style>
.navbar img {
    width: 180px;
    height: auto;
}

</style>