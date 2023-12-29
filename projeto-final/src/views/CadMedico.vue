<template>
    <ExibeMedico @edit="carregaMedico" v-show="exibeMedico"></ExibeMedico>
    <FormCadMedico :medicoprop="medico" @exibir="exibir" v-show="formCadMedico"></FormCadMedico>
</template>

<script>
    import ExibeMedico from '@/components/exibeMedico.vue';
    import FormCadMedico from '@/components/formCadMedico.vue';
    

    export default{
        name:"cadMedico",
        components:{ExibeMedico, FormCadMedico},
        data(){
            return{
                medico: {idmedico:"", idespecialidade: "", nome:"",crm:"",email:"",senha:"" },
                exibeMedico: false,
                formCadMedico: true
            };
        },
        methods:{
            carregaMedico(medico){
                console.log(medico);
                this.medico = medico;
                this.exibeMedico = false;
                this.formCadMedico= true;
        },
            exibir(){
                this.exibeMedico = true;
                this.formCadMedico = false; 
        }
        }
    }
</script>