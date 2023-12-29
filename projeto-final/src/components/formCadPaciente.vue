<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Cadastro de Pacientes</v-toolbar-title>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
              <v-card-text>
                <v-form >
                    <v-text-field v-model="paciente.nome" label="Nome" required></v-text-field>
                    <v-text-field v-model="paciente.cpf" label="CPF" required></v-text-field>
                    <v-text-field v-model="paciente.telefone" label="Telefone" required></v-text-field>
                    <v-text-field v-model="paciente.email" label="E-mail" required></v-text-field>
                    <v-text-field v-model="paciente.senha" label="Senha" type="password" required></v-text-field>
                    <v-text-field v-model="particular" label="Particular" required></v-text-field>
                    <v-col cols="12" >
                        <v-btn @click="cadastrar" type="submit" color="primary" style ='padding: 10px 40px' class="mr-4">Cadastrar</v-btn>
                    </v-col>
                    <v-col cols="12" >
                        <v-btn @click="exibir" type="submit" color="primary" style ='padding: 10px 40px' class="mr-4">Exibir outros pacientes</v-btn>
                    </v-col>
                </v-form>
              </v-card-text>
              <v-progress-linear v-show="carregando" v-model="inicioB"></v-progress-linear>
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
export default{
    name: "cadPaciente",
    data(){
        return{
            particular:"",
            paciente: {idpaciente:"",nome:"",cpf:"",telefone:"",email:"",senha:"",particular:"" },
            carregando: false,
            snackbar: false,
            text: "",
        };
    },
    methods:{
        logout(){
            this.$router.push('/');
        },
        cadastrar(){
            event.preventDefault();
            console.log(this.paciente);
            if (this.particular == "sim"){
              this.paciente.particular = 1;
            }
            else{
              this.paciente.particular = 0;
            }
            if (this.paciente.idpaciente != ""){
              this.editPaciente(this.paciente);
            }
            else{
              this.postPaciente(this.paciente);
            }

        },
        exibir(){
          event.preventDefault();
          this.$emit('exibir');
        },
        postPaciente(paciente){
            const headers={"Content-Type":"text/plain"};
                api.post("/paciente", paciente, {headers})
                    .then(()=>{
                        this.text = "Paciente inserido com sucesso";
                        this.snackbar = true;
                        this.inicioB = 60;
                        this.getPaciente();
                    })
                    .catch((error)=>{
                        this.text = "Erro ao inserir o paciente";
                        this.snackbar = true;
                        console.log(error);
                    });
        },
        editPaciente(paciente){
          const headers={
              "Content-Type":"text/plain"
          };
          api.put("/paciente", paciente, {headers})
              .then(()=>{
                  this.text = "paciente alterado com sucesso";
                  this.snackbar = true;
                  this.inicioB = 60;
                  this.getPaciente();
              })
              .catch((error)=>{
                  this.text = "Erro ao alterar o medico";
                  this.snackbar = true;
                  console.log(error);
              });
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
    },
    props:['pacienteprop'],
    watch:{
      pacienteprop(){
        this.paciente.idpaciente = this.pacienteprop.idpaciente;
        this.paciente.nome = this.pacienteprop.nome;
        this.paciente.cpf = this.pacienteprop.cpf;
        this.paciente.telefone = this.pacienteprop.telefone;
        this.paciente.email = this.pacienteprop.email;
        this.paciente.senha = this.pacienteprop.senha;
        this.paciente.particular = this.pacienteprop.particular;
      }
    }

}
</script>