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
                        <th>Status</th>
                        <th>Curso</th>
                        <th>Aluno</th>
                        <th>Valor</th>
                        <th>Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="item in pedidos" :key="item.id">
                      
                        <td>{{ item.ped_status }}</td>

                        <td>{{ item.inscricao.curso.cur_nome }}</td>

                        
                        <td>{{ item.inscricao.aluno.alu_nome }}</td>
                        
                        <td>{{ item.ped_valor }}</td>

                        
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
                <label for="insIdInscricao" class="form-label">Inscrição</label>
                
                <select class="form-control" v-model="insIdInscricao" id="insIdInscricao">
                    <option value="">.:selecione:.</option>
                    <option v-for="inscricao in inscricoes" :key="inscricao.id" :value="inscricao.id">{{ inscricao.aluno.alu_nome }} ({{inscricao.curso.cur_nome}})</option>
                    
                </select>
              </div>

              <div class="mb-3">
                <label for="pedStatus" class="form-label">Status</label>
                
                <select class="form-control" v-model="pedStatus" id="pedStatus">
                    <option value="0">Pendente</option>
                    <option value="1">Pago</option>
                    <option value="2">Cancelado</option>
                    
                </select>
              </div>


              <div class="mb-3">
                <label for="pedValor" class="form-label">Valor</label>
                <input type="number" class="form-control" v-model="pedValor" @input="validarDecimal" step="0.01" id="pedValor" placeholder="0.00">

              </div>


              
              <div class="mb-3">
                <input type="text" v-model="cardName" placeholder="Nome no cartão" required />
                <div id="card-element"></div>


              </div>






            </div>

            
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>

              
              <button type="button" class="btn btn-warning" :disabled="processing" @click="pagar()">Pagar {{ this.pedValor }}</button>
            </div>


          </form>


        </div>
      </div>
    </div>
</template>


<script>


import * as bootstrap from 'bootstrap'
import axios from 'axios';
import { loadStripe } from '@stripe/stripe-js';




export default {
  name: 'Pedido',

  data(){
    return {
      pedidos : [],
      inscricoes : [],

      stripe : null,
      cardElement : null,
      cardName : '',
      processing : false,
      error : null,
      valor : 1000,
    };
  },



  async mounted(){
    this.listar();
    this.get();


    this.stripe = await loadStripe( "pk_test_51PsQE9FuPCJJkfrm5aeUK6i89yyXVH9h922GBcY3nnN9ZWGK30nhPAiZRjY0HRCisTjBCGGzrfUZCyOdTlZXNOcP00ToY0zus7" );
    const elements = this.stripe.elements();
    this.cardElement = elements.create('card');
    this.cardElement.mount('#card-element');


  },


  computed(){
    /*
    formatacaoValor(){

      return ( this.valor / 100 ).toFixed(2);
    },
    */

  },
  methods : {

    validarDecimal( ev ){
      const value = ev.target.value;
      if( !/^\d*\.?\d*$/.test(value) ){
        ev.target.value = value.slice(0, -1);

      }
    },

    listar(){
      axios.get('api/pedidos')
        .then(response => {
          this.pedidos = response.data;
        })
        .catch(error => {
          console.log('houve um erro', error);
        })

        
      axios.get('api/inscricoes')
        .then(response => {
          this.inscricoes = response.data;
        })
    },

    get(){
      axios.get('api/pedidos/1')
        .then(response => {
          console.log('api/pedidos/1', response.data)
        })

    },



    async pagar( id ){


      this.processing = true;
      this.error = null;
      const { paymentIntent, error } = await this.stripe.createPaymentMethod({
        type : 'card', 
        card : this.cardElement,
        billing_details : {
          name : this.cardName
        }
      });

      if( error ){
        this.error = error.message;
        this.processing = false;

        return;
      }


      const response = await axios.post('/criar-pagamento', { valor : this.pedValor })
      const clientSecret = response.data.clientSecret;

      console.log("paymentIntent", paymentIntent)
      const result = await this.stripe.confirmCardPayment( clientSecret, {
        payment_method : paymentIntent.id
      } )

      if( result.error ){
        this.error = result.error.message;
      }else{
        alert('Pagamento realizado com sucesso');
        
      }

      this.processing = false;
    },


    inserir( id ){

      let postData = {
        'ins_id_inscricao' : this.insIdInscricao,
        'ped_status' : this.pedStatus,
        'ped_valor' : this.pedValor
      }




      if( id ){
        axios.post('api/pedidos/alterar/' + id, postData)
          .then(response => {
            console.log('api/pedidos/alterar', response.data)
            
            this.mensagem = response.data.mensagem;
            this.listar();
          })

      }else{
        axios.post('api/pedidos/inserir', postData)
          .then(response => {
            console.log('api/pedidos/inserir', response.data)

            this.listar();
          })

      }

    },


    novo(){
      this.id = "";
        this.insIdInscricao = "";
        this.pedStatus = "";
        this.pedValor = "";
        document.getElementById('insIdInscricao').value = "";
        document.getElementById('pedStatus').value = "";
        document.getElementById('pedValor').value = "";
      
      this.mensagem = false;


      let myModal = new bootstrap.Modal('#form')
      myModal.show();
    },

    editar( id ){

      this.mensagem = false;

      
      axios.get('api/pedidos/' + id )
        .then(response => {
          let data = response.data;
          this.id = data.id;
          this.insIdInscricao = data.ins_id_inscricao;
          this.pedStatus = data.ped_status;
          this.pedValor = data.ped_valor;
          document.getElementById('insIdInscricao').value = data.ins_id_inscricao;
          document.getElementById('pedStatus').value = data.ped_status;
          document.getElementById('pedValor').value = data.ped_valor;

          

          let myModal = new bootstrap.Modal('#form')
          myModal.show();

        })

    },
    

    

    deletar(id){
      axios.get('api/pedidos/deletar/' + id)
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