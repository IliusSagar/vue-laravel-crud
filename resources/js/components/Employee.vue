<template>
   <div class="container p-5">

    <!-- <button type="button" class="btn btn-primary mb-4 float-right" data-toggle="modal" data-target="#myModal">New Employee</button>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted">Add New Employee</h5>
                    <button type="button" class="close close_modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control">
                    </div>

                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div> -->

   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-4 float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
    New Employee
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Employee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="text-sm text-danger" if="errors != ''">
                <p v-for="error in errors" :key="error"><small>{{ error}}</small></p>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" v-model="form.name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" v-model="form.email">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" v-model="form.phone">
            </div>

            <button type="button" class="btn btn-primary mt-2" @click="storeEmployee">Submit</button>
        </div>
        <!-- <div class="modal-footer ">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>
  

    <table class="table table-bordered table-hover">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </thead>

        <tbody>
            <template v-for="employee in employees" :key="employee.id">
                <tr>
                    <td>{{ employee.name}}</td>
                    <td>{{ employee.email}}</td>
                    <td>{{ employee.phone}}</td>
                    <td>Edit</td>
                    
                </tr>
            </template>
           
        </tbody>
    </table>
   </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup(){
        const employees = ref([]);
        const errors = ref([]);

        const form = reactive({
            name:'',
            email:'',
            phone:'',
        });

        const storeEmployee = async() => {
            try {
                await axios.post('api/employees/store', form)
                getEmployee()
                $("#myModal").modal('hide');
            }catch(e){
                if(e.response.status == 422){
                    var data = [];
                    for(const key in e.response.data.errors){
                        data.push(e.response.data.errors[key][0]);
                    }
                    errors.value = data;
                }
            }
        }

        const getEmployee = async() => {
            const res = await axios.get('api/employees');
            employees.value = res.data;
        }

        onMounted(getEmployee());

        return {
            employees,
            form,
            storeEmployee,
            errors
        }

    }
}
</script>

