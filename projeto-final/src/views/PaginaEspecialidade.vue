<template>

    <ExibeEspecialidade @edit="carregaEspecialidade" v-show="exibeEspecialidade"></ExibeEspecialidade>
    <FormCadEspecialidade @exibir="exibir" :especialidadeprop="especialidade" v-show="formCadEspecialidade"></FormCadEspecialidade>
    
</template>
<script>
import ExibeEspecialidade from '@/components/exibeEspecialidade.vue';
import FormCadEspecialidade from '@/components/formCadEspecialidade.vue';
export default{
    name: "paginaEspecialidade",
    components:{ExibeEspecialidade, FormCadEspecialidade},
    data(){
        return{
            especialidade: {idespecialidade:"",especialidade:""},
            exibeEspecialidade: false,
            formCadEspecialidade: true
        }
    },
    methods:{
        carregaEspecialidade(especialidade){
            console.log(especialidade);
            this.especialidade = especialidade;
            this.exibeEspecialidade = false;
            this.formCadEspecialidade = true;
        },
        exibir(){
            this.exibeEspecialidade = true;
            this.formCadEspecialidade = false; 
        }
    }

}
</script>