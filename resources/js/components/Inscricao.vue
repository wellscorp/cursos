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
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
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


            <slot>
              <div class="row">

                <div class="col">
                  <button type="button" class="btn btn-primary" @click="novo()">Novo</button>
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
                        <th>Curso</th>
                        <th>Aluno</th>
                        <th>Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="item in inscricoes" :key="item.id">
                        <td>{{ item.curso.cur_nome }}</td>

                        
                        <td>{{ item.aluno.alu_nome }}</td>

                        
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
                <label for="curIdCurso" class="form-label">Curso</label>
                
                <select class="form-control" v-model="curIdCurso" id="curIdCurso">
                    <option value="">.:selecione:.</option>
                    <option v-for="curso in cursos" :key="curso.id" :value="curso.id">{{ curso.cur_nome }}</option>
                    
                </select>
              </div>

              <div class="mb-3">
                <label for="aluIdAluno" class="form-label">Aluno</label>
                
                <select class="form-control" v-model="aluIdAluno" id="aluIdAluno">
                    <option value="">.:selecione:.</option>
                    <option v-for="aluno in alunos" :key="aluno.id" :value="aluno.id">{{ aluno.alu_nome }}</option>
                    
                </select>
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
  name: 'Inscricao',

  data(){
    return {
      inscricoes : [],
      cursos : [],
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
      axios.get('api/inscricoes')
        .then(response => {
          this.inscricoes = response.data;
        })
        .catch(error => {
          console.log('houve um erro', error);
        })

        
      axios.get('api/cursos')
        .then(response => {
          this.cursos = response.data;
          console.log("this.cursos", this.cursos)
        })
        
      axios.get('api/alunos')
        .then(response => {
          this.alunos = response.data;
          console.log("this.alunos", this.alunos)
        })
    },

    get(){
      axios.get('api/inscricoes/1')
        .then(response => {
          console.log('api/inscricoes/1', response.data)
        })

    },

    inserir( id ){

      let postData = {
        'cur_id_curso' : this.curIdCurso,
        'alu_id_aluno' : this.aluIdAluno
      }


      if( id ){
        axios.post('api/inscricoes/alterar/' + id, postData)
          .then(response => {
            console.log('api/inscricoes/alterar', response.data)
            
            this.mensagem = response.data.mensagem;
            this.listar();
          })

      }else{
        axios.post('api/inscricoes/inserir', postData)
          .then(response => {
            console.log('api/inscricoes/inserir', response.data)

            this.listar();
          })

      }

    },


    novo(){
      this.id = "";
        this.curIdCurso = "";
        this.aluIdAluno = "";
        document.getElementById('curIdCurso').value = "";
        document.getElementById('aluIdAluno').value = "";
      
      this.mensagem = false;


      let myModal = new bootstrap.Modal('#form')
      myModal.show();
    },

    editar( id ){

      this.mensagem = false;
      
      axios.get('api/inscricoes/' + id )
        .then(response => {
          let data = response.data;
          this.id = data.id;
          this.curIdCurso = data.cur_id_curso;
          this.aluIdAluno = data.alu_id_aluno;
          document.getElementById('curIdCurso').value = data.cur_id_curso;
          document.getElementById('aluIdAluno').value = data.alu_id_aluno;

          

          let myModal = new bootstrap.Modal('#form')
          myModal.show();

        })

    },
    

    

    deletar(id){
      axios.get('api/inscricoes/deletar/' + id)
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