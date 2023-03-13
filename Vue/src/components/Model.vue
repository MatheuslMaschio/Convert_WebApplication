<template>
<div>
    <transition name="modal"> 
        <div v-if="isOpen">
            <div class="overlay" @click.self="isOpen = false;">
            <div class="container">
                <div class="row">
                    <div class = "card">
                        <div class = "card-body">
                        <h1>Atualizar Atividade</h1>
                            <div>
                                <div class="mb-3">
                                    <label>Descrição</label>
                                    <input type="text" v-model="descricao" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Tipo de Atividade: </label>
                                    <select class="form-select" v-model="tipo" >
                                        <option selected v-for="(dados, index) in posts.data" :key="index"> {{dados.tipo}}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Status: </label>
                                    <select class="form-select"  v-model="status">
                                        <option value="1">Ativa</option>
                                        <option value="2">Concluída</option>
                                    </select>
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

}
</script>

<style>

</style>