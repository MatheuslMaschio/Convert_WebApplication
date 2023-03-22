<template>
  <div class="container container-lg">
    <div class="row mt-3">
      <div class="col col-lg-6">
        <br>
        <h4 class="text-dark">Tabela De Atividades</h4>
      </div>
    </div>
    <!--tabela -->
    <br>
    <table class="at-table " at-bg="dark">
      <thead at-bg="light-blue">
        <tr class="align-baseline bg-info text-light text-center">
          <th scope="col">#</th>
          <th scope="col">Tipo</th>
          <th scope="col">Descrição</th>
          <th scope="col">Status</th>
          <th scope="col">Excluir</th>
          <th scope="col">Editar</th>

        </tr>
      </thead>
      <tbody>
        <tr class="text-center" v-for="(dados, index) in posts.data" :key="index"> <!-- Passando para a tabela os valores da API-->
          <td>{{ dados.id }}</td>
          <td>{{ dados.tipo }}</td>
          <td>{{ dados.descricao }}</td>
          <td>{{ dados.status }}</td>
          <td> <button class=" at-button" at-bg="reverse-danger"  @click="this.deleteAtividade(dados.id)"> Excluir</button></td>
          <td> <button type="button" class="at-button" at-bg="reverse-primary" data-bs-toggle="modal" data-bs-target="#modalAtividade" @click="preparaEdit(dados.id)">Editar</button></td>
        </tr>
      </tbody>
    </table>
    
    <!--modal -->
    <div class="modal fade" id="modalAtividade" tabindex="-1" aria-labelledby="modalAtividadeLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAtividadeLabel">Atividade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div>
              <div class="at-field">
                <input type="text" v-model="descricao" class="form-control">
                <label><i class="bx bx-text"></i>Descricao</label>
              </div>
              <div class="at-field">
                <select class="form-select" v-model="tipo" >
                  <option v-for="(dados, index) in tipos.data" :key="index"> {{ dados.id }} {{dados.descricao}}</option>
                </select>
                <label><i class="bx bx-menu"></i>Tipo de Atividade: </label>
              </div>

              <div class="at-field">
                <select class="form-select"  v-model="status">
                  <option value="1">Ativa</option>
                  <option value="2">Concluída</option>
                </select>
                <label><i class="bx bx-menu"></i>Status: </label>
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

  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Home",
  data() {
    return { 
      posts: [],
      tipos:[],
      id: null,
      tipo: "",
      descricao: "",
      status:"",
      isOpen: false,
    };
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
          //chamamos o criarTabela no created para que quando iniciarmos a aplicação o vue já chame a função.
          this.criarTabela();  
          this.consultarApiTipos();
        }
      }
      else{//se ñ existir token 
        this.$router.push({ name: "login" });  //redireciona para a página de login
      }
    },


    //Trás os dados da api
    consultarApi() {
      //definimos algumas variaveis para ficar mais facil
      const webApiUrl = "http://localhost/projetos/PHP/api/atividade/read.php"; 
      const self = this;
      const token = localStorage.getItem("token");
      //--> AXIOS <-- 
      axios({
        method: "get", //Passamos o metodo pode ser get, post, put
        url: webApiUrl, //url
        headers: {
          Authorization : "Bearer " + token
        },
      }).then((response) => (  
      self.posts = response.data)); //pedimos para quando terminar de executar passar a resposta do data para o array posts criado no data 
    },
    
    consultarApiTipos(){
      const webApiUrl = "http://localhost/projetos/php/api/tipo_atividade/read.php";
      const self = this;
      const token = localStorage.getItem("token");
      axios({
        method: "get", //Passamos o metodo pode ser get, post, put
        url: webApiUrl, //url
        headers: {
          Authorization : "Bearer " + token
        },
      }).then((response) => (self.tipos = response.data)); //pedimos para quando terminar de executar passar a resposta do data
    },

    criarTabela(){
      this.consultarApi();
    },

    limpaInput(){
      this.descricao = "";
      this.tipo = "";
      this.status = "";     
    },

    deleteAtividade(id){
      this.$swal.fire({ //itens do sweet alert
        title: 'Você tem certeza?',
        text: "Você não podera reverter depois disso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, deletar atividade!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if(result.isConfirmed) {
          const self = this;
          const token = localStorage.getItem("token");
          const options = {
            method: 'DELETE',
            url: 'http://localhost/projetos/PHP/api/atividade/delete.php',
            headers: {
              Authorization : "Bearer " + token
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
            'A atividade foi excluída com sucesso!',
            'success'
          )
        }
      })
    },

    preparaEdit(id){
      const self = this; //definindo self = this para usar dentro do axios
      const token = localStorage.getItem("token");
      const options = {
        method: 'GET', //definindo o metodo get
        url: "http://localhost/projetos/PHP/api/atividade/read_single.php", //link da api
        params:{id:id}, //passando o id
        headers: {
          Authorization : "Bearer " + token
        },
        data: {}
      };
      axios.request(options).then((response) => {
        //passando o v-model dos inputs , para quando vir a query os valores irem direto para os inputs
        self.id = response.data.id;
        self.descricao = response.data.descricao;
        self.status = response.data.status;
        console.log(response.data);
      })
      .catch(function (error) {
          console.log(error);  
      })
    },

    atualizarUsuario(){
      const self = this; //definindo self = this para usar dentro do axios
      const token = localStorage.getItem("token");
      const options = {
        method: 'PUT', //definindo o metodo put
        url: "http://localhost//projetos/PHP/api/atividade/update.php", //link da api
        headers: {
          Authorization : "Bearer " + token
        },
        data: { //passando para o data o valor dos v-model dos inputs
          id: this.id,
          descricao: this.descricao,
          tipo: this.tipo,
          status: this.status
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

    alertSucess(){
      this.$swal.fire({
        icon: 'success',
        title: 'Atividade Atualizada com Sucesso',
        showConfirmButton: false,
        timer: 1500,
        background: '#fff url(/images/trees.png)',
      })
    },
  },
}

</script>



