<template>
    <v-container fluid>
      <v-row align="center" justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="6">
          <v-card class="elevation-12" style="background-color: #fafafa;">
            <v-toolbar dark color="primary">
              <v-toolbar-title>Central</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <h2>Cadastrar Consulta</h2>
              <br>
              <v-form>
                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field disabled = "true" label="Médico"  v-model="nome"  ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-select :items="this.$store.state.pacientes" label="Paciente" item-title="nome" v-model="consulta.idpaciente" item-value="idpaciente"></v-select>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="consulta.data" label="Data" type="date" required></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="consulta.hora" label="Hora" type="time" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="finalizada" label="Finalizada" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field :style="{ height: '300px' }" v-model="consulta.observacao" label="Observações" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-btn @click="cadastrar" color="primary">Agendar Consulta</v-btn>
                  </v-col>
                  <v-col cols="12" >
                        <v-btn @click="exibir" color="primary">Exibir consultas</v-btn>
                    </v-col>
                </v-row>
              </v-form> 
            </v-card-text>
            <v-snackbar v-model="snackbar" timeout="2000">{{ text }}
                  <template v-slot:actions>
                    <v-btn color="blue" variant="text" @click="snackbar = false">
                      Close
                    </v-btn>
                  </template>
            </v-snackbar>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
    import api from '@/plugins/axios';
  export default {
    data() {
      return {
        finalizada:"",
        nome:'',
        idpaciente:'',
        consulta: {
            idconsulta:'',
            idmedico:'',
            idpaciente: '',
            data: '',
            hora: '',
            finalizada:'',
            observacao:''
        },
        carregando: false,
        snackbar: false,
        text: "",
      };
    },
    mounted(){
        this.selecionaMedico(),
        this.getPaciente()
    },
    methods: {
        exibir(){
            event.preventDefault();
          this.$emit('exibir');
        },
        selecionaMedico(){
            this.consulta.idmedico = this.$store.state.medicoLogin.idmedico;
            this.nome = this.$store.state.medicoLogin.nome;
        },
      logout() {
        // Lógica de logout aqui
        // Exemplo: redirecionar para a página de login
        this.$router.push('/');
      },
        getPaciente(){
                api.get("/paciente/all")
                    .then((res)=>{
                        this.$store.state.pacientes=res.data;
                        this.inicioB = 100;
                        this.carregando = false;
                    })
                    .catch((error)=>{ 
                        console.log(error);
                        this.incioB = 100;
                        this.carregando = false;
                    });
        },
      cadastrar() {
        event.preventDefault();
            console.log(this.consulta);
            if (this.finalizada == "sim"){
              this.consulta.finalizada = 1;
            }
            else{
              this.consulta.finalizada = 0;
            }
            console.log(this.consulta);
            if (this.consulta.idconsulta != ""){
              this.editConsulta(this.consulta);
            }
            else{
              this.postConsulta(this.consulta);
            }

        },
        postConsulta(consulta){
            const headers={"Content-Type":"text/plain"};
                api.post("/consulta", consulta, {headers})
                    .then(()=>{
                        this.text = "Consulta cadastrada com sucesso";
                        this.snackbar = true;
                        this.inicioB = 60;
                        this.getConsulta();
                    })
                    .catch((error)=>{
                        this.text = "Erro ao cadastrar a consulta";
                        this.snackbar = true;
                        console.log(error);
                    });
        },
        editConsulta(consulta){
          const headers={
              "Content-Type":"text/plain"
          };
          api.put("/consulta", consulta, {headers})
              .then(()=>{
                  this.text = "Consulta alterada com sucesso";
                  this.snackbar = true;
                  this.inicioB = 60;
                  this.getConsulta();
              })
              .catch((error)=>{
                  this.text = "Erro ao alterar a consulta";
                  this.snackbar = true;
                  console.log(error);
              });
       },
        /*getConsulta(){
                api.get("/consulta/all")
                    .then((res)=>{
                        this.$store.state.consultas=res.data;
                        this.inicioB = 100;
                        this.carregando = false;
                    })
                    .catch((error)=>{ 
                        console.log(error);
                        this.incioB = 100;
                        this.carregando = false;
                    });
            },*/
            getConsulta(){
                api.get("/consulta/medico/"+this.consulta.idmedico)
                    .then((res)=>{
                        this.$store.state.consultas=res.data;
                        console.log(this.$store.state.consultas);
                        this.inicioB = 100;
                        this.carregando = false;
                    })
                    .catch((error)=>{ 
                        console.log(error);
                        this.incioB = 100;
                        this.carregando = false;
                    });
            },
            
        // Adicione lógica adicional conforme necessário
      },
    props:['consultaprop'],
    watch:{
      consultaprop(){
        this.consulta.idconsulta = this.consultaprop.idconsulta;
        this.consulta.idpaciente = this.consultaprop.idpaciente;
        this.consulta.idmedico = this.consultaprop.idmedico;
        this.consulta.data = this.consultaprop.data;
        this.consulta.hora = this.consultaprop.hora;
        this.consulta.finalizada = this.consultaprop.finalizada;
        this.consulta.observacao = this.consultaprop.observacao;
      }
      
    }
  }
  
  </script>
  
  <style scoped>
  /* Adicione estilos personalizados conforme necessário */
  </style>
  