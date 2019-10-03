<style scoped>
.list-group-item{
  position: relative;
}
.list-group-item:hover{
  background-color: #efffef;
}
.list-group-item:hover .botones{
  opacity: 1;
}
.botones{
  position: absolute;
  right: 10px;
  bottom: 10px;
  opacity: 0;
  transition: .5s;
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
              <input type="text" class="form-control mb-2" placeholder="Nombre de la nota" v-model="nota.nombre">
              <textarea v-model="nota.descripcion" rows="3" class="form-control mb-2" placeholder="Descripción de la nota"></textarea>
              <button class="btn btn-outline-info" type="submit">Guardar</button>
              <button class="btn btn-outline-warning float-right" type="submit" @click="cancelarEdicion"><i class="fa fa-times"></i></button>
            </form>
            <form @submit.prevent="agregar" v-else>
              <input type="text" class="form-control mb-2" placeholder="Nombre de la nota" v-model="nota.nombre">
              <textarea v-model="nota.descripcion" rows="3" class="form-control mb-2" placeholder="Descripción de la nota"></textarea>
              <div class="text-center">
                <button class="btn btn-outline-primary" type="submit">Agregar</button>
              </div>
            </form>
          </div><!-- /.card-body -->
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
      nota: {nombre: '', descripcion: ''}
    }
  },
  created(){
    axios.get('/notas').then(res=>{
      this.notas = res.data;
    })
  },
  methods:{
    agregar(){
      if(this.nota.nombre.trim() === '' || this.nota.descripcion.trim() === ''){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const notaNueva = this.nota;
      this.nota = {nombre: '', descripcion: ''};
      axios.post('/notas', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.notas.push(notaServidor);
        })
    },
    editarFormulario(item){
      this.nota.nombre = item.nombre;
      this.nota.descripcion = item.descripcion;
      this.nota.id = item.id;
      this.modoEditar = true;
    },
    editarNota(nota){
      const params = {nombre: nota.nombre, descripcion: nota.descripcion};
      axios.put(`/notas/${nota.id}`, params)
        .then(res=>{
          this.modoEditar = false;
          const index = this.notas.findIndex(item => item.id === nota.id);
          this.notas[index] = res.data;
        })
    },
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
      this.modoEditar = false;
      this.nota = {nombre: '', descripcion: ''};
    }
  }
}
</script>
