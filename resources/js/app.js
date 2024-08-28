import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import { createApp } from 'vue';
import Layout from './components/Layout.vue'
import Curso from './components/Curso.vue'
import Inscricao from './components/Inscricao.vue'
import Aluno from './components/Aluno.vue'
import Pedido from './components/Pedido.vue'

import '../css/app.css'



const app = createApp({});


app.component('layout', Layout);
app.component('curso', Curso);
app.component('inscricao', Inscricao);
app.component('aluno', Aluno);
app.component('pedido', Pedido);


app.mount("#app");


