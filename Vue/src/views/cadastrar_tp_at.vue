<template>
    <br /><br /><br /><br />
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h1>Cadastrar Tipo de Atividade</h1>
                    <div >
                        <div class="at-field">
                            <input type="text" v-model="descricao" class="form-control">
                            <label><i class="bx bx-text"></i>Descricao</label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="at-button" at-bg="primary" @click="cadastrar_tipo_at" >Cadastrar</button>
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

    methods: {
        cadastrar_tipo_at(){
            const webApiUrl = "http://localhost/projetos/PHP/api/tipo_atividade/create.php"
            const self = this;

            const options = {
                method: 'POST',
                url: webApiUrl,
                headers: {
                    "Access-Control-Allow-Origin" : "*",
                },
                data: {
                    descricao: this.descricao 
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

        limpaInput(){
            this.descricao = "";    
        }


    }
        
}
</script>

<style>

</style>