<template>
 <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Cadastro de Especialidade</v-toolbar-title>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
              <v-card-text>
                <v-form >
                    <v-text-field v-model="especialidade.especialidade" label="Nome" required></v-text-field>
                    <v-col cols="12" >
                        <v-btn @click="cadastrar" type="submit" color="primary" style ='padding: 10px 40px' class="mr-4">Cadastrar</v-btn>
                    </v-col>
                    <v-col cols="12" >
                      <v-btn @click="exibir" color="primary" style ='padding: 10px 40px' class="mr-4">Exibir especialidades</v-btn>
                    </v-col>
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
export default{
    name: "FormCadEspecialidade",
    data() {
        return {
            especialidade: { idespecialidade:"", especialidade: "" },
            carregando: false,
            snackbar: false,
            text: "",
        };
    },
    mounted() {

    },
    methods: {
        logout() {
            this.$router.push('/cadmedico');
        },
        cadastrar() {
            event.preventDefault();
            console.log(this.especialidade);
            if (this.especialidade.idespecialidade != ""){
              this.editEspecialidade(this.especialidade);
            }
            else{
              this.postEspecialidade(this.especialidade);
            }
        },
        postEspecialidade(especialidade) {
            const headers = { "Content-Type": "text/plain" };
            api.post("/especialidade", especialidade, { headers })
                .then(() => {
                this.text = "Especialidade inserida com sucesso";
                this.snackbar = true;
                this.inicioB = 60;
                this.getEspecialidade();
            })
                .catch((error) => {
                this.text = "Erro ao inserir a especialidade";
                this.snackbar = true;
                console.log(error);
            });
        },
        getEspecialidade() {
            api.get("/especialidade/all")
                .then((res) => {
                this.$store.state.especialidades = res.data;
                this.inicioB = 100;
                this.carregando = false;
            })
                .catch((error) => {
                console.log(error);
                this.incioB = 100;
                this.carregando = false;
            });
        },
        editEspecialidade(especialidade){
          const headers={
              "Content-Type":"text/plain"
          };
          api.put("/especialidade", especialidade, {headers})
              .then(()=>{
                  this.text = "Especialidade alterado com sucesso";
                  this.snackbar = true;
                  this.inicioB = 60;
                  this.getEspecialidade();
              })
              .catch((error)=>{
                  this.text = "Erro ao alterar a especialidade";
                  this.snackbar = true;
                  console.log(error);
              });
       },
       exibir(){
        this.$emit('exibir');
       }
    },
    props:['especialidadeprop'],
    watch:{
      especialidadeprop(){
        this.especialidade.idespecialidade = this.especialidadeprop.idespecialidade;
        this.especialidade.especialidade = this.especialidadeprop.especialidade;
        
      }
    }

}
</script>