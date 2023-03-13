    <template>
    <div class="container container-lg">
        <div class="row mt-3">
            <div class="col col-lg-6">
                <br>
                <h4 class="text-info">Tabela De Usuarios</h4>
            </div>
        </div>

        <!--tabela -->
        <br>
        <table class="at-table">
        <thead at-bg="primary">
            <tr class="align-baseline bg-info text-light text-center">
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col"> Excluir</th>
                <th scope="col"> Editar</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center" v-for="(dados, index) in posts.data" :key="index"> <!-- Passando para a tabela os valores da API-->
            <td>{{ dados.id }}</td>
            <td>{{ dados.nome }}</td>
            <td>{{ dados.email }}</td>
            <td> <button class=" at-button" at-bg="danger" @click="this.deleteUsuario(dados.id)">Excluir</button></td>
            <td> <button class=" at-button" at-bg="primary" @click="preparaEdit(dados.id)">Editar</button></td> 
            </tr>
        </tbody>
        </table>
    </div>

    <div>                   
        <transition name="modal"> 
            <div v-if="isOpen">
                <div class="overlay" @click.self="isOpen = false;">
                    <div class="container">
                        <div class="row">
                            <div class = "card">
                                <div class = "card-body">
                                    <h1>Atualizar Usuario</h1>
                                    <div>
                                        <div class="mb-3">
                                            <label>Nome</label>
                                            <input type="text" v-model="nome" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>email</label>
                                            <input type="text" v-model="email" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="at-button" at-bg="primary" @click="atualizarUsuario">Atualizar</button>
                                            <button class="at-button" at-bg="danger" @click.self="isOpen = false;">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data(){
        return {
            posts : [],
            id : null,
            nome : '',
            email : '', 
            isOpen: false
        
        }
    },

    created(){ 
        this.criarTabela(); //chamamos o criarTabela no created para que quando iniciarmos a aplicação o vue já chame a função.
    },

    methods: {
        //Trás os dados da api
        consultarApi() {
            //definimos algumas variaveis para ficar mais facil
            const webApiUrl = "http://localhost/projetos/PHP/api/users/read.php"; //aqui add o this.search para colocar na url tudo que for digitado no input.

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


        preparaEdit(id){
            this.isOpen = true;

            const self = this;
            const options = {
            method: 'GET',
            url: "http://localhost/projetos/PHP/api/users/read_single.php",
            params:{id:id},
            headers: {
                "Access-Control-Allow-Origin" : "*" 
            },
            data: {}
            };
            axios.request(options).then((response) => {
                //passando o v-model dos inputs , para quando vir a query os valores irem direto para os inputs
                self.id = response.data.id;
                self.nome = response.data.nome;
                self.email = response.data.email;
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);  
            })
        },

        atualizarUsuario(){
            const self = this;
            const options = {
                method: 'PUT',
                url: "http://localhost//projetos/PHP/api/users/update.php",
                headers: {
                "Access-Control-Allow-Origin" : "*" 
                },
                data: {
                    id: this.id,
                    nome: this.nome,
                    email: this.email,
                }
            };

            axios.request(options)
            .then(function (response){
                console.log(response.data);
                self.criarTabela();
                self.limpaInput();
            }).catch(function (error) {
                console.log(error);  
            })
        },

        limpaInput(){
            this.nome = "";
            this.email = "";
        },
    }
}
</script>

<style scoped>
.modal {
    width: 500px;
    margin: 0px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px 3px;
    transition: all 0.2s ease-in;
    font-family: Helvetica, Arial, sans-serif;
}
.fadeIn-enter {
    opacity: 0;
}

.fadeIn-leave-active {
    opacity: 0;
    transition: all 0.2s step-end;
}

.fadeIn-enter .modal,
.fadeIn-leave-active.modal {
    transform: scale(1.1);
}


.overlay {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background: #00000094;
    z-index: 999;
    transition: opacity 0.2s ease;
}
</style>
