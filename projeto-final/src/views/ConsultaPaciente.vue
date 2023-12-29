<template>
    <ExibeConsultaPaciente v-show="exibeConsultaPaciente" @edit="carregaConsulta" @logout="logout" ></ExibeConsultaPaciente>
    <FormConsultaPaciente v-show="formConsultaPaciente" @exibir="exibir" :consultaprop="consulta"></FormConsultaPaciente>
</template>

<script>
    import ExibeConsultaPaciente from '@/components/exibeConsultaPaciente.vue';
    import FormConsultaPaciente from '@/components/formConsultaPaciente.vue';

    export default{
        name:"ConsultaMedico",
        components:{ExibeConsultaPaciente, FormConsultaPaciente},
        data(){
            return{
                consulta: {idconsulta:'',
                            idmedico:'',
                            idpaciente: '',
                            data: '',
                            hora: '',
                            finalizada:'0',
                            observacao:''},
                exibeConsultaPaciente: false,
                formConsultaPaciente: true
            };
        },
        methods:{
            carregaConsulta(consulta){
                console.log(consulta);
                this.consulta = consulta;
                this.exibeConsultaPaciente = false;
                this.formConsultaPaciente= true;
        },
            exibir(){
                this.exibeConsultaPaciente = true;
                this.formConsultaPaciente = false; 
        },
        logout(){
            this.exibeConsultaPaciente = false;
            this.formConsultaPaciente = true; 
        }
    }
    }
</script>