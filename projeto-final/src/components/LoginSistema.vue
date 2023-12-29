<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Login</v-toolbar-title>
            </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-select
                    v-model="userType"
                    :items="userTypes"
                    label="Tipo de Usuário"
                    required
                  ></v-select>
                  <v-text-field v-model="username" label="Username" required></v-text-field>
                  <v-text-field v-model="password" label="Password" type="password" required></v-text-field>
                  <v-col cols="12" >
                    <v-btn @click="Acessar"  color="primary" style ='padding: 10px 40px' class="mr-4">Login</v-btn>
                  </v-col>
                  <!-- New buttons for "Cadastro Paciente" and "Cadastro Médico" -->
                  <v-row>
                    <v-col cols="6" >
                      <v-btn @click="cadastroPaciente" color="primary" style ='padding: 10px 40px'>Cadastro Paciente</v-btn>  
                    </v-col>
                    <v-col cols="6" >
                     <v-btn @click="cadastroMedico" color="primary" style ='padding: 10px 40px'>Cadastro Médico</v-btn>
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
        userTypes: ['Médico', 'Paciente'],
        userType: null,
        username: '',
        password: '',
        carregando: false,
        snackbar: false,
        text: "",
      };
    },
    methods: {
      async Acessar(){
        if (this.userType == "Médico"){
            api.post('/medico/login', {
              nome: this.username,
              senha: this.password,
            })
            .then((response)=>{
              if (response.data.quantidade > 0) {
                // Login bem-sucedido
                console.log('Login bem-sucedido!');
                console.log('Tipo de Usuário:', response.data.idmedico);
                this.$store.state.medicoLogin = {idmedico: response.data.idmedico, nome: response.data.nome};
                // Redirecionar para a página inicial ou fazer qualquer outra ação necessária
                this.$router.push({ name: 'consultamedico' });
              }else{
                this.text = "Usuário não cadastrado";
                this.snackbar = true;
                
              }
            })
            .catch((error)=>{
                this.text = "Erro ao realizar o login";
                this.snackbar = true;
                console.log(error);
            }); 
          
        }
        else{
          api.post('/paciente/login', {
              nome: this.username,
              senha: this.password,
            })
            .then((response)=>{
              if (response.data.quantidade > 0) {
                // Login bem-sucedido
                console.log('Login bem-sucedido!');
                console.log('Tipo de Usuário:', response.data.idpaciente);
                console.log('Tipo de Usuário:', response.data.nome);
                this.$store.state.pacienteLogin = {idpaciente: response.data.idpaciente, nome: response.data.nome};
                // Redirecionar para a página inicial ou fazer qualquer outra ação necessária
                this.$router.push({ name: 'consultapaciente' });
              }else{
                this.text = "Usuário não cadastrado";
                this.snackbar = true;
                
              }
            })
            .catch((error)=>{
                this.text = "Erro ao realizar o login";
                this.snackbar = true;
                console.log(error);
            }); 
        }
      },
      cadastroMedico(){
        this.$router.push('/cadmedico');
      },
      cadastroPaciente(){
        this.$router.push('/cadpaciente');
      },
      validaMedico(){

      }
    },
  };
  </script>
  
  <style scoped>
  
  </style>
  