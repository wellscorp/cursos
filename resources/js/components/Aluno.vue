<template>
    <div class="banner">
      <img src="../../../public/logo.png" />
    </div>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cursos">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/alunos">Alunos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inscricoes">Inscrições</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pedidos">Pedidos</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <main class="container mt-4">


            <h2>Alunos</h2>
            <slot>
              <div class="row">

                <div class="col">
                  <button type="button" class="btn btn-primary" @click="novo()">Novo</button>
                </div>
                <div class="col">
                </div>

              </div>


              <div class="row">

                <div class="col">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th>Nome do aluno</th>
                        <th>Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="item in alunos" :key="item.id">
                        <td>{{ item.alu_nome }}</td>

                        
                        <td>
                          <button type="button" class="btn btn-warning" @click="editar(item.id)">Editar</button>
                          <button type="button" class="btn btn-danger" @click="deletar(item.id)">Deletar</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              




            </slot> 
            

            


        </main>
    </div>

    
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="formLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">


          <form @submit.prevent="inserir(this.id)">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="formLabel">Formulário</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


              <p v-if="mensagem" id="mensagem"><div class="alert alert-primary" role="alert">{{ mensagem }}</div></p>

              <div class="mb-3">
                <label for="aluNome" class="form-label">Nome</label>
                <input type="text" class="form-control" v-model="aluNome" id="aluNome" placeholder="Nome">
              </div>

              <div class="mb-3">
                <label for="aluEmail" class="form-label">Email</label>
                <input type="text" class="form-control" v-model="aluEmail" id="aluEmail" placeholder="E-mail">
              </div>
              
              <div class="mb-3">
                <label for="aluCelular" class="form-label">Celular</label>
                <input type="text" class="form-control" v-model="aluCelular" id="aluCelular" placeholder="Celular">
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>


          </form>


        </div>
      </div>
    </div>
</template>


<script>


import * as bootstrap from 'bootstrap'
import axios from 'axios';



export default {
  name: 'Aluno',

  data(){
    return {
      alunos : [],
    };
  },



  mounted(){
    this.listar();
    this.get();

  },
  methods : {

    validarDecimal( ev ){
      const value = ev.target.value;
      if( !/^\d*\.?\d*$/.test(value) ){
        ev.target.value = value.slice(0, -1);

      }
    },

    listar(){
      axios.get('api/alunos')
        .then(response => {
          this.alunos = response.data;
        })
        .catch(error => {
          console.log('houve um erro', error);
        })

        
    },

    get(){
      axios.get('api/alunos/1')
        .then(response => {
          console.log('api/alunos/1', response.data)
        })

    },

    inserir( id ){

      let postData = {
        'alu_nome' : this.aluNome,
        'alu_email' : this.aluEmail,
        'alu_celular' : this.aluCelular
      }

      console.log('postData', postData)


      if( id ){
        axios.post('api/alunos/alterar/' + id, postData)
          .then(response => {
            console.log('api/alunos/alterar', response.data)
            
            this.mensagem = response.data.mensagem;
            this.listar();
          })

      }else{
        axios.post('api/alunos/inserir', postData)
          .then(response => {
            console.log('api/alunos/inserir', response.data)

            this.listar();
          })

      }

    },


    novo(){
      this.id = "";
      
      this.mensagem = false;


      let myModal = new bootstrap.Modal('#form')
      myModal.show();
    },

    editar( id ){

      this.mensagem = false;
      
      axios.get('api/alunos/' + id )
        .then(response => {
          let data = response.data;
          this.id = data.id;
          this.aluNome = data.alu_nome;
          this.aluEmail = data.alu_email;
          this.aluCelular = data.alu_celular;
          document.getElementById('aluNome').value = data.alu_nome;
          document.getElementById('aluEmail').value = data.alu_email;
          document.getElementById('aluCelular').value = data.alu_celular;

          

          let myModal = new bootstrap.Modal('#form')
          myModal.show();

        })

    },
    

    

    deletar(id){
      axios.get('api/alunos/deletar/' + id)
        .then(response => {
          this.listar();
        })

    }


  }
};

</script>




<style scoped>
h1 {
  color: #42b983;
}
</style>