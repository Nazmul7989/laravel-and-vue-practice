<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h3 class="float-left text-success">Students Information</h3>
                            <button data-toggle="modal" data-target="#addnew" class="float-right btn btn-success btn-sm">Add New</button>
                        </div>
                        <table class="table table-bordered mt-2">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th style="width: 170px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="student in students" :key="student.id">
                                <th>{{ student.id }}</th>
                                <td>{{ student.name }}</td>
                                <td>{{ student.className }}</td>
                                <td>{{ student.address }}</td>
                                <td>
                                    <button @click.prevent="editStudent(student)" class="btn btn-success btn-sm">Edit</button>
                                    <button @click.prevent="deleteStudent(student.id)" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    <!--=========Add modal =============-->
                        <div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-if="modalShow">Add New Student</h5>
                                        <h5 class="modal-title" v-else id="exampleModalLabel">Edit Student</h5>
                                        <button @click="formResetByCloseBtnHeader" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Name</label>
                                                <input type="text" name="name" v-model="form.name" class="form-control" id="name">
                                                <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                            </div>
                                            <div class="form-group">
                                                <label for="className" class="col-form-label">Class Name</label>
                                                <input type="text" name="className" v-model="form.className" class="form-control" id="className">
                                                <div class="text-danger" v-if="form.errors.has('className')" v-html="form.errors.get('className')" />
                                            </div>
                                            <div class="form-group">
                                                <label for="address" class="col-form-label">Address</label>
                                                <input type="text" name="address" v-model="form.address" class="form-control" id="address">
                                                <div class="text-danger" v-if="form.errors.has('address')" v-html="form.errors.get('address')" />
                                            </div>
                                            <div class="modal-footer">
                                                <button @click="formResetByCloseBtnFooter" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button @click.prevent="addStudent" v-if="modalShow" type="submit" class="btn btn-success">Add</button>
                                                <button @click.prevent="updateStudent" v-else type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import Swal from "sweetalert2";

export default {
   data (){
       return{
           form: new Form({
               id: '',
              name: '',
              className : '',
              address : '',
           }),
           modalShow: true,
       }
   },
    computed: {
        students(){
            return this.$store.getters.getStudents;
        }
    },
    methods: {
       addStudent(){
           this.modalShow = true;

            this.form.post('/students/store').then((response)=>{
                Toast.fire({
                    icon: 'success',
                    title: 'Student added successfully'
                })
                $('.modal').modal('hide');
                this.loadStudents()
                this.clearForm()

            }).catch((error)=>{
                console.log(error);
            })
       },
        loadStudents(){
            this.$store.dispatch('loadStudents');
        },
        editStudent(student){
           this.modalShow = false;
           $('.modal').modal('show');

           this.form.id = student.id;
           this.form.name = student.name;
           this.form.className = student.className;
           this.form.address = student.address;
        },
        updateStudent(){
           this.form.put('/students/update/'+ this.form.id).then((response)=>{
               Toast.fire({
                   icon: 'success',
                   title: 'Student updated successfully'
               })
               $('.modal').modal('hide');
               this.loadStudents()
               this.clearForm()
               this.$router.push({name: 'home'});

           }).catch((error)=>{
               console.log(error);
           })
        },
        deleteStudent(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                width: 400,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/students/' + id).then((response)=>{
                        this.loadStudents()

                    }).catch((error)=>{
                        console.log(error);
                    })
                    Swal.fire(
                        'Deleted!',
                        'Student deleted successfully.',
                        'success'
                    )
                }
            })

        },
        clearForm(){
            this.form.id = ''
            this.form.name = ''
            this.form.className = ''
            this.form.address = ''
            this.modalShow = true;
        },
        formResetByCloseBtnHeader(){
           this.clearForm()
        },
        formResetByCloseBtnFooter(){
           this.clearForm()
        }
    },
    mounted() {
       this.loadStudents()
    }

}
</script>

<style scoped>

</style>
