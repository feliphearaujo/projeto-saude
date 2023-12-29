<template>
    <v-container fluid>
      <v-row align="center"  justify="center" class="fill-height">
        <v-col cols="12" sm="12" md="6">
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title style = 'letter-spacing: 2px;'>Receituários</v-toolbar-title>
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
                                    <th>ID consulta</th>
                                    <th>Descrição</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in this.$store.state.receituarios" :key="i">
                                    <td>{{ item.idconsulta}}</td>
                                    <td>{{ item.descricao}}</td>
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
    name: 'ExibeReceituario',
    data(){
        return{

        }
    },
    mounted(){
        this.getReceituario();
    },
    methods:{
        logout(){
            event.preventDefault();
            this.$emit('logoutExibeReceituario');
        },
        apagar(i){
            let removido = this.$store.state.receituarios.splice(i,1);
            const headers={ "Content-Type":"text/plain" };
            api.delete("/receituario/"+removido[0].idreceituario, headers)
                .then((res)=>{
                    console.log("Sucesso "+res);
                })
                .catch((error)=>{ 
                    console.log(error);
                });
        },
        editar(i){
            let alterado = this.$store.state.receituarios[i];
            this.$emit('editReceituario', alterado);
            console.log(alterado);
        },
        getReceituario(){
                api.get("/receituario/all")
                    .then((res)=>{
                        this.$store.state.receituarios=res.data;
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
    
}   
</script>