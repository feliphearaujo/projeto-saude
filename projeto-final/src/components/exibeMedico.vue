<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="12" md="6">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Cadastro de Médico</v-toolbar-title>
              <v-btn @click="logout" icon>
                <v-icon>mdi-logout</v-icon>
              </v-btn>
            </v-toolbar>
              <v-card-text>
                <v-row>
                <v-col cols="12">
                        <v-table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Especialidade</th>
                                    <th>CRM</th>
                                    <th>E-mail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in this.$store.state.medicos" :key="i">
                                    <td>{{ item.idmedico }}</td>
                                    <td>{{ item.nome }}</td>
                                    <td>{{ item.especialidade}}</td>
                                    <td>{{ item.crm }}</td>
                                    <td>{{ item.email}}</td>
                                    <td>
                                        <v-btn icon density="comfortable" @click="editar(i)">
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-btn>
                                    </td>
                                    <td>
                                        <v-btn icon density="comfortable" @click="apagar(i)">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-col>
                </v-row>
              </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>
<script>
    import api from '@/plugins/axios';

export default{
    name: 'ExibeMedico',
    data(){
        return{

        }
    },
    mounted(){
        this.getMedico();
    },
    methods:{
        logout(){
            this.$router.push('/');
        },
        apagar(i){
            let removido = this.$store.state.medicos.splice(i,1);
            //console.log(removido[0].idaluno);
            const headers={ "Content-Type":"text/plain" };
            api.delete("/medico/"+removido[0].idmedico, headers)
                .then((res)=>{
                    console.log("Sucesso "+res);
                })
                .catch((error)=>{ 
                    console.log(error);
                });
        },
        editar(i){
            let alterado = this.$store.state.medicos[i];
            this.$emit('edit', alterado);
            console.log(alterado);
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
    }
}   
</script>