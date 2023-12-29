<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="8" md="4">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Cadastro de Médico</v-toolbar-title>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
              <v-card-text>
                <v-form >
                    <v-row>
                      <v-col cols="6">
                        <v-select :items="this.$store.state.especialidades" label="Especialidades" item-title="especialidade" v-model="idespecialidades" item-value="idespecialidade" ></v-select>
                      </v-col>
                      <v-col cols="6">
                        <v-btn @click="addEspecialidade" icon>
                          <v-icon>mdi-plus</v-icon>
                        </v-btn>
                      </v-col>
                    </v-row>
                    <v-text-field v-model="medico.nome" label="Nome" required></v-text-field>
                    <v-text-field v-model="medico.crm" label="CRM" required></v-text-field>
                    <v-text-field v-model="medico.email" label="E-mail" required></v-text-field>
                    <v-text-field v-model="medico.senha" label="Senha" type="password" required></v-text-field>
                    <v-col cols="12" >
                        <v-btn @click="cadastrar" type="submit" color="primary" style ='padding: 10px 40px' class="mr-4">Cadastrar</v-btn>
                    </v-col>
                    <v-col cols="12" >
                        <v-btn @click="exibir"  color="primary" style ='padding: 10px 40px' class="mr-4">Exibir médicos</v-btn>
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
    name: "FormCadMedico",
    data(){
        return{
            idespecialidades: "",
            medico: {idmedico: "", idespecialidade: "", nome:"",crm:"",email:"",senha:"" },
            carregando: false,
            snackbar: false,
            text: "",
        };
    },
    mounted(){
      this.getEspecialidade()
    },
    methods:{
        logout(){
            this.$router.push('/');
        },
        addEspecialidade(){
          this.$router.push('/cadespecialidade'); 
        },
        exibir(){
          this.$emit('exibir');
        },
        cadastrar(){
          event.preventDefault();
            console.log(this.medico);
            if (this.medico.idmedico != ""){
              this.editMedico(this.medico);
            }
            else{
              this.postMedico(this.medico);
            }

        },
        postMedico(medico){
            this.medico.idespecialidade = this.idespecialidades;
            const headers={"Content-Type":"text/plain"};
                api.post("/medico", medico, {headers})
                    .then(()=>{
                        this.text = "Médico inserido com sucesso";
                        this.snackbar = true;
                        this.inicioB = 60;
                        this.getMedico();
                        
                    })
                    .catch((error)=>{
                        this.text = "Erro ao inserir o médico";
                        this.snackbar = true;
                        console.log(error);
                    });
        },
        editMedico(medico){
          const headers={
              "Content-Type":"text/plain"
          };
          api.put("/medico", medico, {headers})
              .then(()=>{
                  this.text = "medico alterado com sucesso";
                  this.snackbar = true;
                  this.inicioB = 60;
                  this.getMedico();
              })
              .catch((error)=>{
                  this.text = "Erro ao alterar o medico";
                  this.snackbar = true;
                  console.log(error);
              });
       },
        getMedico(){
                api.get("/medico/all")
                    .then((res)=>{
                        this.$store.state.medicos=res.data;
                        this.inicioB = 100;
                        this.carregando = false;
                    })
                    .catch((error)=>{ 
                        console.log(error);
                        this.incioB = 100;
                        this.carregando = false;
                    });
            },
          getEspecialidade(){
                api.get("/especialidade/all")
                    .then((res)=>{
                        this.$store.state.especialidades=res.data;
                        this.inicioB = 100;
                        this.carregando = false;
                    })
                    .catch((error)=>{ 
                        console.log(error);
                        this.incioB = 100;
                        this.carregando = false;
                    });
            }
    },
    props:['medicoprop'],
    watch:{
      medicoprop(){
        this.medico.idmedico = this.medicoprop.idmedico;
        this.medico.idespecialidade = this.medicoprop.idespecialidade;
        this.medico.nome = this.medicoprop.nome;
        this.medico.crm = this.medicoprop.crm;
        this.medico.email = this.medicoprop.email;
        this.medico.senha = this.medicoprop.senha;
      }
    }

}
</script>