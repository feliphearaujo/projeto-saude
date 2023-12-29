<template>
    <ExibeConsultaMedico v-show="exibeConsultaMedico" @edit="carregaConsulta" @logout="logout" @receituario="carregaReceituario"></ExibeConsultaMedico>
    <FormConsultaMedico v-show="formConsultaMedico" @exibir="exibir" :consultaprop="consulta"></FormConsultaMedico>
    <FormCadReceituario v-show="formCadReceituario" @exibirReceituario="exibirReceituario" @logoutReceituario="logoutReceituario" :idconsultaprop="idconsulta" :receituarioprop="receituario"></FormCadReceituario>
    <ExibeReceituario v-show="exibeReceituario" @editReceituario="editReceituario"    @logoutExibeReceituario="logoutExibeReceituario"></ExibeReceituario>
</template>

<script>
    import ExibeConsultaMedico from '@/components/exibeConsultaMedico.vue';
    import FormConsultaMedico from '@/components/formConsultaMedico.vue';
    import FormCadReceituario from '@/components/formCadReceituario.vue';
    import ExibeReceituario from '@/components/exibeReceituario.vue';

    export default{
        name:"ConsultaMedico",
        components:{ExibeConsultaMedico, FormConsultaMedico, FormCadReceituario, ExibeReceituario},
        data(){
            return{
                consulta: {idconsulta:'',
                            idmedico:'',
                            idpaciente: '',
                            data: '',
                            hora: '',
                            finalizada:'',
                            observacao:''},
                receituario: {
                    dreceituario:"", idconsulta:"", descricao: "" 
                },
                exibeConsultaMedico: false,
                formConsultaMedico: true,
                formCadReceituario: false,
                exibeReceituario: false
            };
        },
        methods:{
            carregaConsulta(consulta){
                console.log(consulta);
                this.consulta = consulta;
                this.exibeConsultaMedico = false;
                this.formConsultaMedico= true;
        },
            exibir(){
                this.exibeConsultaMedico = true;
                this.formConsultaMedico = false; 
        },
        logout(){
            this.exibeConsultaMedico = false;
            this.formConsultaMedico = true; 
        },
            carregaReceituario(consulta){
                console.log(consulta);
                this.idconsulta = consulta;
                this.formCadReceituario = true,
                this.exibeConsultaMedico = false;
            },
            logoutReceituario(){
                this.exibeConsultaMedico = true;
                this.formCadReceituario = false; 
            },
            exibirReceituario(){
                this.formCadReceituario = false;
                this.exibeReceituario = true; 
            },
            logoutExibeReceituario(){
                this.formCadReceituario = true;
                this.exibeReceituario = false; 
            },
            editReceituario(receituario){
                this.receituario = receituario;
                this.exibeReceituario = false;
                this.formCadReceituario= true;
            }
    }
    }
</script>