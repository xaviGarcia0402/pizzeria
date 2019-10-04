<style lang="scss" scoped>
.list-group-item{
  position: relative;
  &:hover{
    background-color: #efffef;
    .botones{
      opacity: 1;
    }
  }
  .botones{
    position: absolute;
    right: 10px;
    bottom: 10px;
    opacity: 0;
    transition: .5s;
  }
}
</style>
<template>
  <div>
    <div class="row">
      <div class="col-md-4 mb-2">
        <div class="card">
          <div class="card-header">
            <span v-if="modoEditar">Editar</span>
            <span v-else>Agregar</span>
            Nota
          </div>
          <div class="card-body">
            <form @submit.prevent="editarNota(nota)" v-if="modoEditar">
              <input
                v-bind:class="{'is-invalid': errors.nombre}"
                type="text"
                class="form-control mb-2"
                placeholder="Nombre de la nota"
                v-model="nota.nombre">
              <div class="invalid-feedback mb-2 mt-n1" v-if="errors.nombre">{{ errors.nombre }}</div>
              <textarea
                v-bind:class="{'is-invalid': errors.descripcion}"
                v-model="nota.descripcion"
                rows="3"
                class="form-control mb-2"
                placeholder="Descripción de la nota"></textarea>
              <div class="invalid-feedback mb-2 mt-n1" v-if="errors.descripcion">{{ errors.descripcion }}</div>
              <button class="btn btn-outline-info" type="submit">Guardar</button>
              <button class="btn btn-outline-warning float-right" type="submit" @click="cancelarEdicion"><i class="fa fa-times"></i></button>
            </form>
            <form @submit.prevent="agregar" v-else>
              <input
                v-bind:class="{'is-invalid': errors.nombre}"
                type="text"
                class="form-control mb-2"
                placeholder="Nombre de la nota"
                v-model="nota.nombre">
              <div class="invalid-feedback mb-2 mt-n1" v-if="errors.nombre">{{ errors.nombre }}</div>
              <textarea
                v-bind:class="{'is-invalid': errors.descripcion}"
                v-model="nota.descripcion"
                rows="3"
                class="form-control mb-2"
                placeholder="Descripción de la nota"></textarea>
              <div class="invalid-feedback mb-2 mt-n1" v-if="errors.descripcion">{{ errors.descripcion }}</div>
              <div class="text-center">
                <button class="btn btn-outline-primary" type="submit">Agregar</button>
              </div>
            </form>
          </div><!-- /.card-body -->
          <div class="overlay" v-if="cargando"><i class="fa fa-2x fa-refresh fa-spin"></i></div>
        </div><!-- /.card -->
      </div><!-- /.col -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Notas</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="(item, index) in notas" :key="index">
              <span class="badge badge-light float-right">{{item.updated_at}}</span>
              <h4>{{item.nombre}}</h4>
              <p class="text-muted mb-0" style="white-space: pre;">{{item.descripcion}}</p>
              <div class="botones">
                <button class="btn btn-outline-info btn-sm" @click="editarFormulario(item)">Editar</button>
                <button class="btn btn-outline-danger btn-sm" @click="eliminarNota(item, index)"><i class="fa fa-trash"></i></button>
              </div>
            </li>
          </ul>
        </div><!-- /.card -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>
</template>

<script>
export default{

  data(){
    return {
      notas: [],
      modoEditar: false,
      nota: {nombre: '', descripcion: ''},
      errors: [],
      cargando: false,
    }
  },

  created(){
    axios.get('/notas').then(res=>{
      this.notas = res.data;
    })
  },

  methods:{

    validar(){
      this.errors = [];
      if(this.nota.nombre.trim() === ''){ this.errors["nombre"] = "El nombre es requerido"; }
      if(this.nota.descripcion.trim() === ''){ this.errors["descripcion"] = "Descripción requerida"; }
      if( Object.keys(this.errors).length ){ return false; }
      return true;
    },// /validar

    agregar(){
      if(! this.validar()){ return false; }
      this.cargando = true;
      const notaNueva = this.nota;
      axios.post('/notas', notaNueva)
        .then((res) => {
          const notaServidor = res.data;
          this.notas.push(notaServidor);
          this.nota = {nombre: '', descripcion: ''};
        })
        .catch((error) => {
          if(error.response && error.response.status == 422){
            // this.errors = error.response.data.errors;
            Object.keys(error.response.data.errors).forEach(k => {
              this.errors[k] = error.response.data.errors[k][0];
            });
            console.log(this.errors);
          }
          else{
            alert(error);
          }
        })
        .finally(() => {
          this.cargando = false;
        });
    },// /agregar

    editarFormulario(item){
      this.errors = [];
      this.nota.nombre = item.nombre;
      this.nota.descripcion = item.descripcion;
      this.nota.id = item.id;
      this.modoEditar = true;
    },// /editarFormulario

    editarNota(nota){
      if(! this.validar()){ return false; }
      const params = {nombre: nota.nombre, descripcion: nota.descripcion};
      this.cargando = true;
      axios.put(`/notas/${nota.id}`, params)
        .then(res=>{
          this.modoEditar = false;
          const index = this.notas.findIndex(item => item.id === nota.id);
          this.notas[index] = res.data;
        })
        .catch((error) => {
          // console.log(error.response.data);
          if(error.response && error.response.status == 422){
            Object.keys(error.response.data.errors).forEach(k => {
              this.errors[k] = error.response.data.errors[k][0];
            });
          }
          else{
            alert(error);
          }
        })
        .finally(() => {
          this.cargando = false;
        });
    },// /editarNota

    eliminarNota(nota, index){
      const confirmacion = confirm(`Eliminar nota ${nota.nombre}`);
      if(confirmacion){
        axios.delete(`/notas/${nota.id}`)
          .then(()=>{
            this.notas.splice(index, 1);
          })
      }
    },

    cancelarEdicion(){
      this.errors = [];
      this.modoEditar = false;
      this.nota = {nombre: '', descripcion: ''};
    }

  }// /methods

}// /export
</script>
