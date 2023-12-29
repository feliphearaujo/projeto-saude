<template>
    <v-container fluid>
      <v-row align="center" justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="6">
          <v-card class="elevation-12" style="background-color: #fafafa;">
            <v-toolbar dark color="primary">
              <v-toolbar-title>Consultas</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <h2>Suas Consultas</h2>
              <br>
              <v-list>
                <v-list-item-group v-if="consultas.length > 0">
                  <v-list-item v-for="(consulta, index) in consultas" :key="index">
                    <v-list-item-content>
                      <v-list-item-title>{{ consulta.data }} - {{ consulta.hora }}</v-list-item-title>
                      <v-list-item-subtitle>{{ consulta.medico }} - {{ consulta.especialidade }}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-list-item-group>
                <v-list-item v-else>
                  <v-list-item-content>
                    <v-list-item-title>Você não tem consultas marcadas.</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
              <br>
              <h2>Agendar Nova Consulta</h2>
              <br>
               
              <v-form @submit.prevent="agendarConsulta">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-select :items="this.$store.state.medicos" label="Médico" item-title="medico" v-model="idmedico" item-value="idmedico"></v-select>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-select :items="this.$store.state.pacientes" label="Paciente" item-title="paciente" v-model="idpaciente" item-value="idpaciente"></v-select>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="novaConsulta.data" label="Data" type="date" required></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="novaConsulta.hora" label="Hora" type="time" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="novaConsulta.finalizada" label="Finalizada" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field :style="{ height: '300px' }" v-model="novaConsulta.observacao" label="Observações" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-btn @click="cadconsulta" color="primary">Agendar Consulta</v-btn>
                  </v-col>
                </v-row>
              </v-form> 

            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container> 
   
    
  </template>
  
  <script>
  
  export default {
    data() {
      return {
        consultas: [
          { data: '2023-12-01', hora: '10:00', medico: 'Dr. Silva', especialidade: 'Cardiologia' },
          // Adicione consultas de exemplo aqui
        ],
        idmedico:'',
        idpaciente:'',
        novaConsulta: {
          idmedico:'',
          idpaciente:'',
          data: '',
          hora: '',
          finalizada:'',
          observacao:''
        },
      };
    },
    methods: {
      logout() {
        // Lógica de logout aqui
        // Exemplo: redirecionar para a página de login
        this.$router.push('/login');
      },
      agendarConsulta() {
        // Lógica para agendar nova consulta
        this.consultas.push({
          data: this.novaConsulta.data,
          hora: this.novaConsulta.hora,
          medico: this.novaConsulta.medico,
          especialidade: this.novaConsulta.especialidade,
        });
        this.novaConsulta = {
          data: '',
          hora: '',
          medico: '',
          especialidade: '',
        };
        // Adicione lógica adicional conforme necessário
      },
      cadconsulta(){
        this.$router.push('/consulta');
      }
    },
  };
  </script>
  
  <style scoped>
  /* Adicione estilos personalizados conforme necessário */
  </style>
  