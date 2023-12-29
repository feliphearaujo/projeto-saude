<template>
    <v-container fluid>
         <v-row align="center"  justify="center" class="fill-height">
           <v-col cols="12" sm="8" md="4">
             <v-card class="elevation-12">
               <v-toolbar dark color="primary">
                 <v-toolbar-title style = 'letter-spacing: 2px;'>Cadastro de receituário</v-toolbar-title>
                 <v-btn @click="logout" icon>
                   <v-icon>mdi-logout</v-icon>
                 </v-btn>
               </v-toolbar>
                 <v-card-text>
                   <v-form >
                        <v-col cols="12" md="6">
                            <v-text-field disabled = "true" label="Consulta"  v-model="receituario.idconsulta"  ></v-text-field>
                        </v-col>
                            <v-text-field :style="{ height: '300px' }" v-model="receituario.descricao" label="Descrição" required></v-text-field>
                       <v-col cols="12" >
                           <v-btn @click="cadastrar" type="submit" color="primary" style ='padding: 10px 40px' class="mr-4">Cadastrar</v-btn>
                       </v-col>
                       <v-col cols="12" >
                         <v-btn @click="exibir" color="primary" style ='padding: 10px 40px' class="mr-4">Exibir receituários</v-btn>
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
       name: "FormCadReceituario",
       data() {
           return {
               receituario: { idreceituario:"", idconsulta:"", descricao: "" },
               carregando: false,
               snackbar: false,
               text: "",
           };
       },
       mounted() {
        
       },
       methods: {
           logout() {
            event.preventDefault();
            this.$emit('logoutReceituario');
           },
           exibir(){
            event.preventDefault();
            this.$emit('exibirReceituario');
           },
           cadastrar() {
               event.preventDefault();
               console.log(this.receituario);
               if (this.receituario.idreceituario != ""){
                 this.editReceituario(this.receituario);
               }
               else{
                 this.postReceituario(this.receituario);
               }
           },
           postReceituario(receituario) {
               const headers = { "Content-Type": "text/plain" };
               api.post("/receituario", receituario, { headers })
                   .then(() => {
                   this.text = "Receituário inserido com sucesso";
                   this.snackbar = true;
                   this.inicioB = 60;
                   this.getReceituario();
               })
                   .catch((error) => {
                   this.text = "Erro ao inserir o receituario";
                   this.snackbar = true;
                   console.log(error);
               });
           },
           getReceituario() {
               api.get("/receituario/all")
                   .then((res) => {
                   this.$store.state.receituarios = res.data;
                   this.inicioB = 100;
                   this.carregando = false;
               })
                   .catch((error) => {
                   console.log(error);
                   this.incioB = 100;
                   this.carregando = false;
               });
           },
           editReceituario(receituario){
             const headers={
                 "Content-Type":"text/plain"
             };
             api.put("/receituario", receituario, {headers})
                 .then(()=>{
                     this.text = "Receituário alterado com sucesso";
                     this.snackbar = true;
                     this.inicioB = 60;
                     this.getReceituario();
                 })
                 .catch((error)=>{
                     this.text = "Erro ao alterar o receituário";
                     this.snackbar = true;
                     console.log(error);
                 });
          }
       },
       props:['idconsultaprop', 'receituarioprop'],
       watch:{
            idconsultaprop(){
           this.receituario.idconsulta = this.idconsultaprop.idconsulta;
         },
            receituarioprop(){
                this.receituario.idreceituario = this.receituarioprop.idreceituario;
                this.receituario.idconsulta = this.receituarioprop.idconsulta;
                this.receituario.descricao = this.receituarioprop.descricao;
            }
       }
   
   }
   </script>