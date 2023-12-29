<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="12" md="6">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Consultas</v-toolbar-title>
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
                                    <th>Médico</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Status</th>
                                    <th>Observação</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in this.$store.state.consultas" :key="i">
                                    <td>{{ item.nome }}</td>
                                    <td>{{ item.data }}</td>
                                    <td>{{ item.hora}}</td>
                                    <td>{{ item.finalizada == 1 ? "Finalizada" : "Em aberto" }}</td>
                                    <td>{{ item.observacao}}</td>
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
    name: 'ExibeConsultaPaciente',
    data(){
        return{

        }
    },
    mounted(){
        this.getConsulta();
    },
    methods:{
        logout(){
            this.$emit('logout');
        },
        apagar(i){
            let removido = this.$store.state.consultas.splice(i,1);
            //console.log(removido[0].idaluno);
            const headers={ "Content-Type":"text/plain" };
            api.delete("/consulta/"+removido[0].idconsulta, headers)
                .then((res)=>{
                    console.log("Sucesso "+res);
                })
                .catch((error)=>{ 
                    console.log(error);
                });
        },
        editar(i){
            let alterado = this.$store.state.consultas[i];
            this.$emit('edit', alterado);
            console.log(alterado);
        },
        getConsulta(){
                api.get("/consulta/paciente/"+this.$store.state.pacienteLogin.idpaciente)
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
    }
}   
</script>