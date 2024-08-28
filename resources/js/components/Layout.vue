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


            <slot>
              <h2>Olá, seja bem vindo ao sistema de gestão de cursos</h2>

            </slot>
        </main>
      </div>
</template>

<script>
export default {
  name: 'Layout',
};
</script>

<style scoped>
h1 {
  color: #42b983;
}
</style>