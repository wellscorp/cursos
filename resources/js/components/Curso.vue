<template>
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

            <h2>Cursos</h2>

            <slot>
              <div class="row">

                <div class="col">
                  <button type="button" class="btn btn-primary" @click="novoCurso()">Novo</button>
                </div>
                <div class="col">
                  <input type="text" class="form-control" v-model="pesquisa" id="pesquisa" placeholder="pesquisar..." />
                </div>

              </div>


              <div class="row">

                <div class="col">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th>Nome do curso</th>
                        <th>Valor</th>
                        <th>Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="curso in cursos" :key="curso.id">
                        <td>{{ curso.cur_nome }}</td>
                        <td>{{ curso.cur_valor }}</td>

                        
                        <td>
                          <button type="button" class="btn btn-warning" @click="editarCurso(curso.id)">Editar</button>
                          <button type="button" class="btn btn-danger" @click="deletarCurso(curso.id)">Deletar</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              




            </slot> 
            

            


        </main>
    </div>

    
    <div class="modal fade" id="formCurso" tabindex="-1" aria-labelledby="formCursoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">


          <form @submit.prevent="inserirCurso(this.id)">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="formCursoLabel">Formulário</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


              <p v-if="mensagem" id="mensagem"><div class="alert alert-primary" role="alert">{{ mensagem }}</div></p>

              <div class="mb-3">
                <label for="curNome" class="form-label">Nome</label>
                <input type="text" class="form-control" v-model="curNome" id="curNome" placeholder="Nome">
              </div>

              <div class="mb-3">
                <label for="curValor" class="form-label">Valor</label>
                <input type="number" class="form-control" v-model="curValor" @input="validarDecimal" step="0.01" id="curValor" placeholder="0.00">
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
  name: 'Curso',

  data(){
    return {
      cursos : [],
    };
  },

  /*
  computed : {
    cursos(){

      console.log("this.pesquisa", this.pesquisa)
      if( this.pesquisa ){
        const pesq = this.pesquisa.toLowerCase();

      }else{
        const pesq = "";
      }
      
      return this.filter(item => {
        return (
          item.cur_nome.toLowerCase().includes( pesq )
        );
      })
    }
  },
  */

  mounted(){
    this.listarCursos();
    this.getCurso();
    //this.inserirCurso();
    //this.alterarCurso(2);
    //this.deletarCurso(4);

  },
  methods : {

    validarDecimal( ev ){
      const value = ev.target.value;
      if( !/^\d*\.?\d*$/.test(value) ){
        ev.target.value = value.slice(0, -1);

      }
    },

    listarCursos(){
      axios.get('api/cursos')
        .then(response => {
          this.cursos = response.data;
        })
        .catch(error => {
          console.log('houve um erro', error);
        })
    },

    getCurso(){
      axios.get('api/cursos/1')
        .then(response => {
          console.log('api/cursos/1', response.data)
        })

    },

    inserirCurso( id ){

      let postData = {
        'cur_nome' : this.curNome,
        'cur_valor' : this.curValor
      }


      if( id ){
        axios.post('api/cursos/alterar/' + id, postData)
          .then(response => {
            console.log('api/cursos/alterar', response.data)
            
            this.mensagem = response.data.mensagem;
            this.listarCursos();
          })

      }else{
        axios.post('api/cursos/inserir', postData)
          .then(response => {
            console.log('api/cursos/inserir', response.data)

            this.listarCursos();
          })

      }

    },


    novoCurso(){
      this.id = "";
      this.curNome = "";
      this.curValor = "";
      document.getElementById('curNome').value = "";
      document.getElementById('curValor').value = "";
      
      this.mensagem = false;


      let myModal = new bootstrap.Modal('#formCurso')
      myModal.show();
    },

    editarCurso( id ){

      this.mensagem = false;
      
      axios.get('api/cursos/' + id )
        .then(response => {
          let data = response.data;
          this.id = data.id;
          this.curNome = data.cur_nome;
          this.curValor = data.cur_valor;
          document.getElementById('curNome').value = data.cur_nome;
          document.getElementById('curValor').value = data.cur_valor;

          

          let myModal = new bootstrap.Modal('#formCurso')
          myModal.show();

        })

    },
    

    alterarCurso(id){

      let postData = {
        'cur_nome' : 'teste 01.2',
        'cur_valor' : '200.00'
      }

      axios.post('api/cursos/alterar/' + id, postData)
        .then(response => {
          console.log('api/cursos/alterar', response.data)
        })

    },
    
    

    deletarCurso(id){
      axios.get('api/cursos/deletar/' + id)
        .then(response => {
          this.listarCursos();
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