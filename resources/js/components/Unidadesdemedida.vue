<template>

    <main>
            <!-- Breadcrumb -->
            <div class="container-fluid">

                <div class="card">     
                   
                        <div class=" card-primary">

                            <div class="card-header">
                                <h3 class="card-title">Nueva Categoria</h3>
                            </div>

                            <div class="row">
                
                                <div class="col-md-6">

                                    <div class="card-body">

                                        <form  @submit.prevent="processQueue" method="POST" enctype = "multipart/form-data">
                                            
                                            <div  class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" v-model="nombre" @click="activarBoton" id="condicion" style="border-radius:0;" class="form-control" placeholder="name" >
                                            </div>

                                            <div class="form-group">
                                                <label for="descripcion" >descripcion</label>
                                                <input type="text" v-model="descripcion" style="border-radius:0;" class="form-control" placeholder="descripcion">
                                            </div>

                                            
                                          
                                            
                                            <div class="form-group row">

                                                <div class="col-md-12">
                                                    <a type="button"  style="border-radius:0;" href="/categoria" class="btn btn-secondary">Cerrar</a>
                                                    <button id="button" type="submit" v-on:click="processQueue" style="border-radius:0;" class="btn btn-primary" disabled  >Registrar Venta</button>
                                                </div>

                                            </div>

                                        
                                        </form>

                                    </div>
                                    
                                </div>

                            </div>
                        
                        </div>
                    

                </div>

            </div>

    </main>

</template>

<script>
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    
    export default {
        mounted() {
            this.listarCategoria();
        },
        data (){
            return {
                dropzoneOptions: {
                    url: 'http://127.0.0.1:8000/api/categoria/storecategoria',
                    
                    
                    maxFiles: 1,
                    addRemoveLinks: true,
                    accept: function(file, done) {
                        console.log("uploaded");
                        
                        done();
                    },
                    init: function() {
                        this.on("addedfile", function() {
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                            }
                        });
                    },
                     autoProcessQueue: false,
                },
                listado : '',
                estado: true,
                prueba: '',
                imagenMiniatura: '',
                categoria_id: 0,
                nombre : '',
                descripcion : '',
                arrayCategoria : [],
                modal : 0,
                imagenpreview : '',
                image : '',
                listado:1,
                tituloModal : '',
                tipoAccion : 0,
                errorCategoria : 0,
                errorMostrarMsjCategoria : [],
               
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        components: {
            vueDropzone: vue2Dropzone   
        },
        
        
        methods : {
            activarBoton(){
                
                let activadornombre = document.getElementById("condicion")
                let activadorimg = document.getElementById("dropzone")

                activadornombre.addEventListener("keyup", () => {
                    if(activadornombre.value !=  ""){
                        document.getElementById("button").disabled = false
                    }else{
                        document.getElementById("button").disabled = true
                    }
                })

                activadorimg.addEventListener("keyup", () => {
                    if(activadorimg.value !=  ""){
                        document.getElementById("button").disabled = false
                    }else{
                        document.getElementById("button").disabled = true
                    }
                })                

            },
            processQueue() {
                this.$refs.myVueDropzone.processQueue();
            },
            sendingEvent(file, xhr, formData) {
                formData.append("nombre", this.nombre);
                formData.append("descripcion", this.descripcion);
            },
            listarCategoria (){
                let me=this;
                var url= '/categoria' ;
                axios.get(url).then(function (response) {
                    me.listado ='/categoria';
                })
               
                .catch(function (error) {
                    console.log(error);
                });
            },
            obtenerImagen(e){

                let file = e.target.files[0];
                this.image = file;
                this.cargarImagen(file); 

            },
            cargarImagen(file){
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }

                reader.readAsDataURL(file);
            },
            addProduct(){
                let me = this;
                //let formData = new FormData();
               // formData.append('nombre',this.nombre);
               // formData.append('descripcion',this.descripcion);
               // formData.append('image',this.image);

                axios.post('/categoria/storecategoria',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion
                }).then(function(responses) {
                    me.nombre='';
                    me.descripcion='';
                    me.imagenMiniatura = '';
                   

                    console.log(responses.data);
                })
            },

            

            mostrarDetalle(){
                let me=this;
                
                me.listado=0;

               
            },
            cerrarRegistro(){
                this.nombre='';
                this.descripcion='';
                this.imagenMiniatura='';
            }

        },
        
    }
</script>

<style>    