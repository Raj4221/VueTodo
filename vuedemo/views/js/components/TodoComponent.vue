<template>
    
    <div class="container">
       <div v-if="seen">
        <form @submit.prevent="savedata">
                <div class="form-group">
                    <input type="text" v-model="form.name" class="form-control" name="name" id="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.address" class="form-control" name="address" id="address" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <input type="number" v-model="form.contact" class="form-control" name="contact" id="contact" placeholder="Contact" required>
                </div>
                <button type="submit" id="btn" class="btn btn-secondary w-5">Insert</button>
        </form>
        </div>
        <div v-else>
        <form @submit.prevent="updatedata">
                <div class="form-group">
                    <input type="text" v-model="form.id" class="form-control" name="id" id="name" placeholder="Name" disabled>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.name" class="form-control" name="name" id="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="text" v-model="form.address" class="form-control" name="address" id="address" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <input type="number" v-model="form.contact" class="form-control" name="contact" id="contact" placeholder="Contact" required>
                </div>
                <button type="submit" id="btn" class="btn btn-secondary w-5">update</button>
        </form>
        </div>
        <br>
        <div>
            <div class="container">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <div v-for="todo in todos" :key="todo.id">
                                <tr>
                                    <td class="w-25">{{todo.id}}</td>
                                    <td class="w-25">{{todo.name}}</td>
                                    <td class="w-25"> {{todo.address}}</td>
                                    <td class="w-25">{{todo.contact}}</td>
                                    <td><button class="btn btn-secondary" v-on:click="editTodo(todo)">update</button></td>
                                    <td><button class="btn btn-dark" v-on:click="deleteTodo(todo)">delete</button></td>
                                </tr>
                            </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
    </div> 
</template>

<script>
    export default {
        data(){
            return{
                seen:true,
                todos:'',
                form: new Form({
                    name:'',
                    address:'',
                    contact:'',
                })
            }   
        },
        
        methods: {
            gettodos(){
                axios.get('/todo').then((res)=>{
                    this.todos=res.data
                }).catch((error)=>{
                    console.log(error)
                })
            },

            editTodo(e){
                this.seen=!this.seen
                this.form.id=e.id
                this.form.name=e.name
                this.form.address=e.address
                this.form.contact=e.contact
            },


            updatedata(){
                let data = new FormData();
                data.append('_method', 'PATCH')
                data.append('name', this.form.name)
                data.append('address', this.form.address)
                data.append('contact', this.form.contact)
                axios.post('/todo/'+this.form.id, data).then((res)=>{
                    this.form.reset()
                    this.gettodos()
                    this.seen=true
                })
            },

            savedata(){
                let data=new FormData();
                data.append('name',this.form.name)
                data.append('address',this.form.address)
                data.append('contact',this.form.contact)
                axios.post('/todo',data).then((res)=>{
                    this.form.reset()
                    this.gettodos()
                })
            },

            deleteTodo(e){
                let data = new FormData();
                data.append('_method', 'DELETE')
                axios.post('/todo/'+e.id, data).then((res) =>{
                    this.todos = res.data
                }).catch((error) => {
                    this.form.errors.record(error.response.data.errors)
                })
            }
        },

        mounted(){
            this.gettodos()
        }
    }
</script>
