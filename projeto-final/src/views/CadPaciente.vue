<template>
    <ExibePaciente v-show="exibePaciente" @edit="carregaPaciente"></ExibePaciente>
    <FormCadPaciente v-show="formCadPaciente" @exibir = "exibir" :pacienteprop = "paciente"></FormCadPaciente>
</template>
<script>
    import ExibePaciente from '@/components/exibePaciente.vue';
    import FormCadPaciente from '@/components/formCadPaciente.vue';

    export default{
        name: "cadPaciente",
        components:{ExibePaciente, FormCadPaciente},
        data(){
            return{
                paciente:{idpaciente:"",nome:"",cpf:"",telefone:"",email:"",senha:"",particular:"" },
                exibePaciente: false,
                formCadPaciente: true
            };
        },
        methods:{
            exibir(){
                this.exibePaciente = true;
                this.formCadPaciente = false; 
            },
            carregaPaciente(paciente){
                console.log(paciente);
                this.paciente = paciente;
                this.exibePaciente = false;
                this.formCadPaciente= true;
            }
        }
    }
</script>