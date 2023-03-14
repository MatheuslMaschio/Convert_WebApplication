<template>

<div class="container container-lg">
  <div class="row mt-3">
    <div class="col col-lg-6">
      <br>
      <h4 class="text-info">Tabela De Atividades</h4>
    </div>
  </div>
  <!--tabela -->
  <br>
  <table class="at-table">
    <thead at-bg="primary">
      <tr class="align-baseline bg-info text-light text-center">
        <th scope="col">#</th>
        <th scope="col">Tipo</th>
        <th scope="col">Descrição</th>
        <th scope="col">Status</th>
        <th scope="col">Excluir</th>
      </tr>
    </thead>
    <tbody>
      <tr class="text-center" v-for="(dados, index) in posts.data" :key="index"> <!-- Passando para a tabela os valores da API-->
        <td>{{ dados.id }}</td>
        <td>{{ dados.tipo }}</td>
        <td>{{ dados.descricao }}</td>
        <td>{{ dados.status }}</td>
        <td> <button class=" at-button" at-bg="danger"  @click="this.deleteAtividade(dados.id)"> Excluir</button></td>
      </tr>
    </tbody>
  </table>
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "Home",
  data() {
    return { 
      usuarioAutenticado: false,
      posts: [],
      id: null,
      tipo: "",
      descricao: "",
      status:"",
      isOpen: false
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
          
          this.criarTabela(); //chamamos o criarTabela no created para que quando iniciarmos a aplicação o vue já chame a função.
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
          const options = {
            method: 'DELETE',
            url: 'http://localhost/projetos/PHP/api/atividade/delete.php',
            headers: {
              "Access-Control-Allow-Origin" : "*" 
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
            'A atividade foi exclída com sucesso!',
            'success'
          )
        }
      })
    },
  },
}

</script>



